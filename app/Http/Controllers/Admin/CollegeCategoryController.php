<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CollegeCategories;
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

class CollegeCategoryController extends Controller {
    private static $States;
	private static $CollegeCategories;
    private static $TokenHelper;

    public function __construct(){
        self::$States = new States();
		self::$CollegeCategories = new CollegeCategories();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       return view('/panel/college_category/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$CollegeCategories->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('title', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('state_id', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/college_category/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'title' => 'required', 
				'state_id' => 'required', 
			 ], [
			 	'title.required' => 'Please enter title.', 
				'state_id.required' => 'Please enter state.', 
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
				if($errors->first('state_id')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('state_id')));
                    die;
                }
            }else{
                $setData['title'] = $request->input('title');
				$setData['slug'] = Str::slug($request->input('title'));
				$setData['state_id'] = implode(',',$request->input('state_id'));
               	$record = self::$CollegeCategories->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
		$stateList = $this->getState();
		return view('/panel/college_category/add-page',compact('stateList'));
    }

    #editPage
    public function editPage(Request $request, $row_id){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $row_id = base64_decode($row_id);
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'title' => 'required', 
				'state_id' => 'required', 
			 ], [
			 	'title.required' => 'Please enter title.', 
				'state_id.required' => 'Please enter state.', 
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
				if($errors->first('state_id')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('state_id')));
                    die;
                }
            }else{				
                $setData['title'] = $request->input('title');
				$setData['slug'] = Str::slug($request->input('title'));
				$setData['state_id'] = implode(',',$request->input('state_id'));
                $record = self::$CollegeCategories->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
			$stateList = $this->getState();
            $record = self::$CollegeCategories->where('id', $row_id)->first();
            return view('/panel/college_category/edit-page', ['record' => $record, 'stateList' => $stateList]);
        }else{
            return redirect('/panel/college-categories');
        }
    }
	
	function getState(){			
		return self::$States->where('status', 1)->where('country_id',101)->pluck('state','id');
	}

}