<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Contacts;
use App\Models\Predictors;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class AjaxController extends Controller{
    private static $Contacts;
	private static $Predictors;
	private static $TokenHelper;
	
	public function __construct(){
        self::$Contacts = new Contacts();
		self::$Predictors = new Predictors();
		self::$TokenHelper = new TokenHelper();
	}
	
	public function addNewsletter(Request $request){
		if(!empty($request->email) && filter_var($request->email, FILTER_VALIDATE_EMAIL)){			
			$this->newsletter($request->email);
		}
	}	
	
	public function savePredictor(Request $request){
		if($request->ajax()){
			$validator = Validator::make($request->all(), [
                'predictor_type' => 'required', 
				'neet_rank' => 'required', 
				'counselling_type' => 'required',
				'seat_category' => 'required', 
				'first_name' => 'required', 
				'last_name' => 'required', 
				'mobile' => 'required|digits:10', 	
				'email' => 'required|email',
            ],[
                'predictor_type.required' => 'Please select predictor type.',				
				'neet_rank.required' => 'Please enter neet rank.',
				'counselling_type.required' => 'Please enter counselling type.',
				'seat_category.required' => 'Please slect seat category.',
				'first_name.required' => 'Please enter first name.',
				'last_name.required' => 'Please enter last name.',
				'mobile.required' => 'Please enter mobile number.',
				'mobile.digits' => 'Please enter valid mobile number.',
				'mobile.min' => 'Please enter valid mobile number.',
				'email.required' => 'Please enter email.',
				'email.email' => 'Please enter valid email.',
            ]);
			if($validator->fails()){
				$errors = $validator->errors();
				if($errors->first('predictor_type')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('predictor_type')));die;
				}
				if($errors->first('neet_rank')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('neet_rank')));die;
				}
				if($errors->first('seat_category')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('seat_category')));die;
				}
				if($errors->first('first_name')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('first_name')));die;
				}
				if($errors->first('last_name')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('last_name')));die;
				}
				if($errors->first('mobile')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('mobile')));die;
				}
				if($errors->first('email')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('email')));die;
				}
			}else{
				$this->newsletter($request->email);
				$setData['user_id'] = Session::get('login_user_id');
				//$setData['state_id'] = $request->input('state_id');
				$setData['local_area_id'] = $request->input('local_area_id');
				$setData['sub_category_id'] = $request->input('sub_category_id');
				$setData['predictor_type'] = $request->input('predictor_type');
				$setData['counselling_type'] = $request->input('counselling_type');
				$setData['neet_rank'] = $request->input('neet_rank');
				//$setData['seat_type'] = $request->input('seat_type');
				$setData['seat_category'] = $request->input('seat_category');
				$setData['first_name'] = $request->input('first_name');
				$setData['last_name'] = $request->input('last_name');
				$setData['mobile'] = $request->input('mobile');
				$setData['email'] = $request->input('email');
				$record = self::$Predictors->CreateRecord($setData);

				$query = DB::table('college_ranks')->where('status',1);
				if($request->input('counselling_type') == 2){
					if($request->input('local_area_id') && $request->input('local_area_id') > 0){
						$query->where('local_area_id',$request->input('local_area_id'));
					}
				}				
				$query->where('college_category_id',$request->input('seat_category'));				
				if($request->input('sub_category_id')){
					$query->where('sub_category_id',$request->input('sub_category_id'));
				}				
				$rank = $request->input('neet_rank');				
				if($request->input('gender') == 'Male'){
					$predcoll = (clone $query)
						->where('male_rank','>=',$rank)
						->pluck('college_id')
						->implode(',');
				}else{
					$predcoll = (clone $query)
						->where('female_rank','>=',$rank)
						->pluck('college_id')
						->implode(',');
				}				
				if($predcoll == ''){
					$predcoll = (clone $query)
						->where('rank','>=',$rank)
						->pluck('college_id')
						->implode(',');
				}
				Session::put('precoll', $predcoll);
				Session::put('state_id', $request->state_id);
				Session::put('counselling_type', $request->counselling_type);
				Session::save();
				echo json_encode(array('heading'=>'Success','msg'=>'Prediction added successfully'));die;
			}
		}
		exit;
	}	
	public function getStateCategory(Request $request){
		if($request->ajax()){		
			$state_id = $request->input('state');		
			if($state_id > 0){		
				$coll_categories = DB::table('college_categories')
					->whereRaw("FIND_IN_SET(?, state_id)", $state_id)
					->where('status',1)
					->orderBy('title')
					->pluck('title','id');		
			}else{		
				$coll_categories = DB::table('college_categories')
					->where('status',1)
					->orderBy('title')
					->pluck('title','id');
			}		
			echo view('/ajax/get_college_cat',compact('coll_categories'));
		}
		exit;
	}
	public function getStateSubCategory(Request $request){
		if($request->ajax()){		
			$state_id = $request->input('state');		
			if($state_id > 0){		
				$coll_sub_categories = DB::table('sub_categories')
					->whereRaw("FIND_IN_SET(?, state_id)", $state_id)
					->where('status',1)
					->orderBy('title')
					->pluck('title','id');		
			}else{		
				$coll_sub_categories = DB::table('sub_categories')
					->where('status',1)
					->orderBy('title')
					->pluck('title','id');
			}		
			echo view('/ajax/get_college_subcat',compact('coll_sub_categories'));
		}		
		exit;
	}
 	public function setCookie(Request $request){
		setcookie("home_modal", "Yes", time() + 86400, "/");
		echo 'Success'; die;
	}
	public function saveInquiry(Request $request){
		if($request->ajax()){
			$validator = Validator::make($request->all(), [
                'cname' => 'required', 
				'cemail' => 'required|email',
				'ccontact' => 'required|min:10', 				
				'cmessage' => 'required', 
            ],[
                'cname.required' => 'Please enter name.',				
				'cemail.required' => 'Please enter email.',
				'cemail.email' => 'Please enter valid email.',
				'ccontact.required' => 'Please enter contact.',
				'ccontact.min' => 'Please enter valid contact.',
				'cmessage.required' => 'Please enter message.',
            ]);
			if($validator->fails()){
				$errors = $validator->errors();
				if($errors->first('cname')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('cname')));die;
				}
				if($errors->first('cemail')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('cemail')));die;
				}
				if($errors->first('ccontact')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('ccontact')));die;
				}
				if($errors->first('cmessage')){
                    return json_encode(array('heading'=>'Error','msg'=>$errors->first('cmessage')));die;
				}
			}else{
				$this->newsletter($request->cemail);
				$setData['name'] = $request->input('cname');
				$setData['email'] = $request->input('cemail');
				$setData['contact'] = $request->input('ccontact');
				$setData['message'] = $request->input('cmessage');
				$record = self::$Contacts->CreateRecord($setData);				
				echo json_encode(array('heading'=>'Success','msg'=>'Your enquiry has been submitted successfully! 
Our counsellor will reach out to you shortly to guide you through the admission process.'));die;
			}
		}
		exit;
	}
	
}