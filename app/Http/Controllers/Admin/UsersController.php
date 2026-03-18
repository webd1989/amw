<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\States;
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

class UsersController extends Controller {
    private static $Users;
	private static $States;
    private static $TokenHelper;

    public function __construct(){
        self::$Users = new Users();
		self::$States = new States();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       return view('/panel/users/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Users->where('status', '!=', 3)->where('type','User');
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
        return view('/panel/users/paginate', compact('records'));
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
				$setData['type'] = 'User';
                $setData['name'] = $request->input('name');
				$setData['email'] = $request->input('email');
				$setData['mobile'] = $request->input('contact');
				$setData['address'] = $request->input('address');
				$setData['state'] = $request->input('state');
				$setData['city'] = $request->input('city');
				$password = password_hash($request->input('password'),PASSWORD_BCRYPT);
				$setData['password'] = $password;
				$setData['original_password'] = $request->input('password');
				
				$year = date('Y');
				$month = date('m');
				if(!File::exists(public_path('/admin/images/banners/'.$year))){
					mkdir(public_path('/admin/images/banners/'.$year, 0777, true));
				}

				#profile pic upload
                if(isset($request->profile) && $request->profile->extension() != ""){
                    $validator = Validator::make($request->all(), ['profile' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('profile')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' .$request->profile->extension();
                        $destination = base_path().'/public/admin/images/banners/'.$year.'/'.$month.'/';
                        $request->profile->move($destination, $actual_image_name);
						$setData['profile'] = $actual_image_name;
                    }
                }
               	$record = self::$Users->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
		$states = $this->getStateList();
        return view('/panel/users/add-page',compact('states'));
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
				$year = $request->ryear;
				$month = $request->rmonth;
				if(!File::exists(public_path('/admin/images/banners/'.$year))){
					mkdir(public_path('/admin/images/banners/'.$year, 0777, true));
				}
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

				#profile pic upload
                if(isset($request->profile) && $request->profile->extension() != ""){
                    $validator = Validator::make($request->all(), ['profile' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('profile')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' . $request->profile->extension();
                        $destination = base_path().'/public/admin/images/banners/'.$year.'/'.$month.'/';
                        $request->profile->move($destination, $actual_image_name);
						$setData['profile'] = $actual_image_name;
						if($request->input('old_profile') != ""){
                            if(file_exists($destination . $request->old_profile)){
                                unlink($destination . $request->old_profile);
                            }
                        }
                    }
                }
                $record = self::$Users->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
			$states = $this->getStateList();
            $record = self::$Users->where('id', $row_id)->first();
            return view('/panel/users/edit-page', ['record' => $record, 'states' => $states]);
        }else{
            return redirect('/panel/users');
        }
    }
	
	function getStateList(){
		return self::$States->where('status',1)->where('country_id',101)->pluck('state','id');
	}

}