<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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

class StatesController extends Controller {
	private static $States;
    private static $TokenHelper;

    public function __construct(){
		self::$States = new States();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       return view('/panel/states/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$States->where('country_id',101)->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('states.state', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('states.state', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/states/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [				
				'state' => 'required',
			 ], [
				'state.required' => 'Please enter state.',
			]);
            if($validator->fails()){
                $errors = $validator->errors();
				if($errors->first('state')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('state')));
                    die;
                }
            }else{
                //$mobileExist = self::$States->where('country_id', 101)->where('state', $request->state)->where('state', '!=',3)->count();
				$mobileExist = self::$States->where('state', $request->state)->where('state', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'State already exist'));
                    die;
                }
				$setData['country_id'] = 101;
				$setData['state'] = $request->input('state');
               	$record = self::$States->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
        return view('/panel/states/add-page');
    }

    #editPage
    public function editPage(Request $request, $row_id){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $row_id = base64_decode($row_id);
        if($request->input()){
            $validator = Validator::make($request->all(), [				
				'state' => 'required',
			 ], [
				'state.required' => 'Please enter state.',
			]);
            if($validator->fails()){
                $errors = $validator->errors();
				if($errors->first('state')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('state')));
                    die;
                }
            }else{
                //$mobileExist = self::$States->where('country_id', 101)->where('state', $request->state)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
				$mobileExist = self::$States->where('state', $request->state)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'State already exist'));
                    die;
                }
				$setData['country_id'] = 101;
				$setData['state'] = $request->input('state');
                $record = self::$States->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
            $record = self::$States->where('id', $row_id)->first();
            return view('/panel/states/edit-page', ['record' => $record]);
        }else{
            return redirect('/panel/states');
        }
    }

}