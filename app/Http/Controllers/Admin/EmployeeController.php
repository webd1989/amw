<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\States;
use App\Models\UserPermission;
use App\Models\UserPermissionSections;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller {
    private static $Users;
	private static $UserPermission;
	private static $States;
	private static $UserPermissionSections;
    private static $TokenHelper;

    public function __construct(){
        self::$Users = new Users();
		self::$UserPermission = new UserPermission();
		self::$States = new States();
		self::$UserPermissionSections = new UserPermissionSections();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       return view('/panel/employees/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Users->where('status', '!=', 3)->where('type','Employee');
		if($request->input('search_status') && $request->input('search_status') != ""){
			$query->where('status', 'like', '%'.$request->input('search_status').'%');		
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('users.name', 'like', '%'.$SearchKeyword.'%')
                   ->orWhere('users.email', 'like', '%'.$SearchKeyword.'%')
				   ->orWhere('users.mobile', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/employees/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'name' => 'required',		
				'email' => 'required|email',
				'password' => 'required',
			 ], [
			 	'name.required' => 'Please enter name.', 
				'email.required' => 'Please enter email.', 
				'email.email' => 'Please enter valid email.',
				'password.required' => 'Please enter password.', 
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('name')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('name')));
                    die;
                }
				if($errors->first('email')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('email')));
                    die;
                }
				if($errors->first('password')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('password')));
                    die;
                }
            }else{
                $mobileExist = self::$Users->where('email', $request->email)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Email already exist'));
                    die;
                }
				$mobileExist = self::$Users->where('mobile', $request->contact)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Contact already exist'));
                    die;
                }
				$setData['type'] = 'Employee';				
				$setData['designation'] = $request->input('designation');
                $setData['name'] = $request->input('name');
				$setData['email'] = $request->input('email');
				$setData['mobile'] = $request->input('contact');
				$setData['address'] = $request->input('address');
				$setData['state'] = $request->input('state');
				$setData['city'] = $request->input('city');
				$password = password_hash($request->input('password'),PASSWORD_BCRYPT);
				$setData['password'] = $password;
				$setData['original_password'] = $request->input('password');				
               	$record = self::$Users->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
        return view('/panel/employees/add-page');
    }

    #editPage
    public function editPage(Request $request, $row_id){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $row_id = base64_decode($row_id);
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'name' => 'required', 				
				'email' => 'required|email'
			 ], [
			 	'name.required' => 'Please enter name.', 
				'email.required' => 'Please enter email.', 
				'email.email' => 'Please enter valid email.'
			]);

           if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('name')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('name')));
                    die;
                }
				if($errors->first('email')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('email')));
                   	die;
                }
            }else{
                $mobileExist = self::$Users->where('email', $request->email)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'User already exist'));
                    die;
                }
				$mobileExist = self::$Users->where('mobile', $request->contact)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'User already exist'));
                    die;
                }
                $setData['type'] = 'Employee';
				$setData['designation'] = $request->input('designation');
				$setData['name'] = $request->input('name');
				$setData['email'] = $request->input('email');
				$setData['mobile'] = $request->input('contact');
				$setData['address'] = $request->input('address');
				$setData['state'] = $request->input('state');
				$setData['city'] = $request->input('city');
				if($request->input('password') && $request->input('password') != ''){
					$password = password_hash($request->input('password'),PASSWORD_BCRYPT);
					$setData['password'] = $password;
					$setData['original_password'] = $request->input('password');
				}
				if($request->permision && $request->permision != ''){
					$setData['permision'] = implode(',',$request->input('permision'));
				}else{
					$setData['permision'] = NULL;
				}
                $record = self::$Users->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
			$section_list = $this->getSectionList();
            $record = self::$Users->where('id', $row_id)->first();
            return view('/panel/employees/edit-page', ['record' => $record, 'section_list' => $section_list]);
        }else{
            return redirect('/panel/employees');
        }
    }
	
	function getSectionList(){
		return self::$UserPermissionSections->where('status',1)->pluck('title','id');
	}

}