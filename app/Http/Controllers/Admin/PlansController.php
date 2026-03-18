<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Plans;
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

class PlansController extends Controller{
    private static $Plans;
	private static $States;
    private static $TokenHelper;

    public function __construct(){
        self::$Plans = new Plans();
		self::$States = new States();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       return view('/panel/plans/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Plans->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('subscription_plans.title', 'like', '%'.$SearchKeyword.'%')
				   ->orWhere('subscription_plans.type', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/plans/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'title' => 'required',
				'price' => 'required'
			 ], [
			 	'title.required' => 'Please enter title.',
				'price.required' => 'Please enter price.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
				if($errors->first('price')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('price')));
                    die;
                }
            }else{
                $mobileExist = self::$Plans->where('title', $request->title)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Plan already exist'));
                    die;
                }
                $setData['type'] = $request->input('type');
				$setData['text1'] = $request->input('text1');
				$setData['text2'] = $request->input('text2');
				$setData['title'] = $request->input('title');
				$setData['price'] = $request->input('price');
				$setData['discounted_price'] = $request->input('discounted_price');
				$setData['features'] = implode('||',array_filter($request->input('features')));
               	$record = self::$Plans->CreateRecord($setData);
				
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
        return view('/panel/plans/add-page');
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
				'price' => 'required'
			 ], [
			 	'title.required' => 'Please enter title.',
				'price.required' => 'Please enter price.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
				if($errors->first('price')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('price')));
                    die;
                }
            }else{
                $mobileExist = self::$Plans->where('title', $request->title)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Plan already exist'));
                    die;
                }
                $setData['type'] = $request->input('type');
				$setData['text1'] = $request->input('text1');
				$setData['text2'] = $request->input('text2');
				$setData['title'] = $request->input('title');
				$setData['price'] = $request->input('price');
				$setData['discounted_price'] = $request->input('discounted_price');
				$setData['features'] = implode('||',array_filter($request->input('features')));
                $record = self::$Plans->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
            $record = self::$Plans->where('id', $row_id)->first();
            return view('/panel/plans/edit-page', ['record' => $record]);
        }else{
            return redirect('/panel/plans');
        }
    }
	
}