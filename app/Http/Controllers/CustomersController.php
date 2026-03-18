<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Orders;
use App\Models\InnerPages;
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


class CustomersController extends Controller{
	 
	private static $Orders;
	private static $Users;
	private static $Predictors;
	private static $InnerPages;
	
	public function __construct(){
        self::$Orders = new Orders();
		self::$Predictors = new Predictors();
		self::$Users = new Users();
		self::$InnerPages = new InnerPages();
    }
	
	public function login(Request $request,$type = NULL){		
		if($request->Ajax() || $request->Post()){
			if($request->ajax()){
				$validator = Validator::make($request->all(),[
					'email_login' => 'required',		
					'password_login' => 'required',
				],[
					'email_login.required' => 'Please enter email.',
					'password_login.required' => 'Please enter password.',
				]);
				
				if($validator->fails()){
					$errors = $validator->errors();
					return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>$validator->errors()->getMessages()]);
				}else{
					$User = self::$Users->where(array('email' => $request->email_login, 'type' => 'User'))->where('status','!=',3)->first();

					if(!$User){

						$User = self::$Users->where(array('mobile' => $request->email_login, 'type' => 'User'))->where('status','!=',3)->first();

						if(!$User){

							return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('email_login' => 'Username or password incorrect')]);

						}else{

							$PasswordMatch = password_verify($request->password_login, $User->password);
							if(!$PasswordMatch){
								return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('email_login' => 'Username or password incorrect')]);
							}else{
								if($User->status == 1){
									$this->setUserSession($User->id);								
									echo json_encode(array('heading'=>'Success','msg'=>''));
								}else{
									return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('email_login' => 'Your account is inactive, Please contact to admin.')]);
								}						
							}
							
						}
					}else{
						$PasswordMatch = password_verify($request->password_login, $User->password);
						if(!$PasswordMatch){
							return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('email_login' => 'Username or password incorrect')]);
						}else{
							if($User->status == 1){
								$this->setUserSession($User->id);
								echo json_encode(array('heading'=>'Success','msg'=>''));
							}else{
								return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('email_login' => 'Your account is inactive, Please contact to admin.')]);
							}
						}
					}
				}
			}
			exit;
		}
	}

	public function customerSignup(Request $request){
		if($request->ajax()){
			$validator = Validator::make($request->all(), [
				'cname' => 'required',
				'cmobile' => 'required|digits:10', 
				'cemail' => 'required|email',				
				'password' => 'required|min:4|confirmed',
				'password_confirmation' => 'required|min:4'
            ],[
				'cname.required' => 'Please enter name	.',
				'cmobile.digits' => 'Please enter valid contact.',
				'cmobile.required' => 'Please enter contact.',
				'cemail.required' => 'Please enter email.',
				'cemail.email' => 'Please enter valid email.',
				'password.required' => 'Please enter password.',
				'password.min' => 'Minimum 4 character password required.',
				'password_confirmation.required' => 'Please enter confirm password.',
				'password_confirmation.min' => 'Minimum 4 character password required.',
				'password.confirmed' => 'Password and confirmed password must be same.',
            ]);
			if($validator->fails()){
				$errors = $validator->errors();
				return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>$validator->errors()->getMessages()]);
			}else{
				$count = self::$Users->where('status','!=',3)->where('email',$request->input('cemail'))->count();
				if($count > 0){
					return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('cemail' => 'Email already exists.')]);
				}else{
					$countmobile = self::$Users->where('status','!=',3)->where('mobile',$request->input('cmobile'))->count();
					if($countmobile > 0){
						return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('cmobile' => 'Mobile number already exists.')]);
					}else{
						$setData['name'] = $request->input('cname');
						$setData['mobile'] = $request->input('cmobile');
						$setData['email'] = strtolower($request->input('cemail'));
						$password = password_hash($request->input('password'),PASSWORD_BCRYPT);
						$setData['password'] = $password;
						$setData['original_password'] = $request->input('password');						
						$record = self::$Users->CreateRecord($setData);
						$user_details = self::$Users->where('id',$record->id)->first();	
						$this->setUserSession($user_details->id);				
						return response()->json(['status'=>'success', 'msg' => 'User register successfully']);
					}					
				}
			}
		}
		exit;			
	}

	#changePassword
    public function changePassword(Request $request){
		if(!$request->session()->has('login_user_email')){return redirect('/');}
		if($request->input()){
			$validator = Validator::make($request->all(), [
				'current_password' => 'required',
				'new_password' => 'required',
				'confirm_password' => 'required'
			],[
				'current_password.required' => 'Please enter current password',
				'new_password.required' => 'Please enter new password',
				'confirm_password.required' => 'Please enter confirm password'
			]);
			if($validator->fails()){
				$errors = $validator->errors();
				if($errors->first('current_password')){
					echo json_encode(['success'=>false, 'message' => $errors->first('current_password')]); die;
				}
				if($errors->first('new_password')){
					echo json_encode(['success'=>false, 'message' => $errors->first('new_password')]); die;
				}
				if($errors->first('confirm_password')){
					echo json_encode(['success'=>false, 'message' => $errors->first('confirm_password')]); die;
				}
			}else{
				$userData = self::$Users->where('id',Session::get('login_user_id'))->first();
				if($userData->original_password != $request->current_password){
					echo json_encode(['success'=>false, 'message' => 'Invalid current password']); die;
				}
				if($request->new_password != $request->confirm_password){
					echo json_encode(['success'=>false, 'message' => 'Password do not match']); die;
				}
				$password = password_hash($request->input('new_password'),PASSWORD_BCRYPT);
				$setNewAddressData['password'] = $password;
				$setNewAddressData['original_password'] = $request->input('new_password');	
				self::$Users->where('id',Session::get('login_user_id'))->update($setNewAddressData);
				echo json_encode(['success'=>true, 'message' => 'Password updated successfully']); die;
			}
		}
		$inner_page = self::$InnerPages->where('id',13)->where('status',1)->first();
        return view('customers.change_password',compact('inner_page'));
    }

	#myAccount
    public function myAccount(Request $request){
		if(!$request->session()->has('login_user_email')){return redirect('/');}
		if($request->input()){
			$validator = Validator::make($request->all(), [
				'o_name' => 'required',
			],[
				'o_name.required' => 'Please enter name',
			]);
			if($validator->fails()){
				$errors = $validator->errors();
				if($errors->first('o_name')){
					echo json_encode(['success'=>false, 'message' => $errors->first('o_name')]); die;
				}
			}else{
				$setNewAddressData['name'] = trim(ucwords($request->o_name));
				$setNewAddressData['address'] = $request->o_address;
				$setNewAddressData['city'] = trim(ucwords($request->o_city));
				$setNewAddressData['state'] = trim(ucwords($request->o_state));
				$setNewAddressData['zipcode'] = $request->o_pincode;
				self::$Users->where('id',Session::get('login_user_id'))->update($setNewAddressData);
				echo json_encode(['success'=>true, 'message' => 'Profile updated successfully']); die;
			}
		}
		$inner_page = self::$InnerPages->where('id',13)->where('status',1)->first();
		$userData = self::$Users->where('id',Session::get('login_user_id'))->first();
        return view('customers.my_account',compact('inner_page','userData'));
    }
	
	#myAccount
    public function myPredictors(Request $request){
		if(!$request->session()->has('login_user_email')){return redirect('/');}
		$authId = Session::get('login_user_id');
		$inner_page = self::$InnerPages->where('status', 1)->where('id',7)->first();
		$predictors = self::$Predictors->where('status','!=',3)->where('user_id',$authId)->get();
        return view('customers.my_predictors',compact('inner_page','predictors'));
    }
	
	#myAccount
    public function myOrders(Request $request){
		if(!$request->session()->has('login_user_email')){return redirect('/');}
		$inner_page = self::$InnerPages->where('status', 1)->where('id',7)->first();
		$orders = self::$Orders->where('status','!=',3)->get();
        return view('customers.my_orders',compact('inner_page','orders'));
    }
	
	public function forgotPassword(Request $request){
		if($request->Ajax()){
			$postData = $request->all();
			$msg = '';
			if(isset($postData) && !empty($postData)){
				$email = trim($postData['forgot_email']);
				if(filter_var(strtolower(trim($email)),FILTER_VALIDATE_EMAIL)){						
					$customerEmail = self::$Users->where('email',$email)->where('type','User')->first();			
					if(isset($customerEmail) && !empty($customerEmail->email)){
						if($customerEmail->status == 2){	
							return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('forgot_email' => 'Your account has been deactivated. Please contact to system administrator.')]);
						}else{
							try {
								$security_key = base64_encode(base64_encode($email));
								$setData['id'] = $customerEmail->id;
								$setData['security_key'] = $security_key;
								if(self::$Users->UpdateRecord($setData)){
									$siteUrl = trim(env('SITE_URL'));
									$customerEmail['link'] = $siteUrl.'reset-password/'.$email.'/'.$security_key;
								}
								return response()->json(['status' => 'success', 'msg' => 'Please Check Your Email To Reset Password.']);
							}
							catch(\Exception $e){
								//print_r($e->getMessage());
								return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('forgot_email' => 'Something went wrong.')]);
							}						
						}
					}else{
						return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('forgot_email' => 'No user is registered with this email address.')]);
					}
				}else{
					return response()->json(['status' => 'error', 'msg' => 'error',  'errors'=>array('forgot_email' => 'Please enter valid email address.')]);
				}
								
			}				
		}
		exit;
	}
		
	public function resetPassword(Request $request, $email=NULL,$securityKey=NULL){
		if(!empty($email) && !empty($securityKey)){
			$userDetail = self::$Users->where('email',$email)->where('security_key',$securityKey)->first();
			if($userDetail){	
				return view('customers.reset_password',compact('email','securityKey'));
			}else{
				return redirect('/')->with('error','The password reset link has expired, Please forgot password again.');
			}
		}else{
			return redirect('/login')->with('error','Something went wrong.');	
		}			
	}
	
	public function resetPasswordChange(Request $request){
		if($request->Ajax()){
			$postData = $request->all();
			if(!empty($postData)){
				$email = strtolower(trim($postData['email']));
				$security_key = $postData['security_key'];
				$userDetail = self::$Users->where('email',$email)->where('security_key',$security_key)->first();
				$setData['id'] = $userDetail->id;
				$setData['original_password'] = $postData['new_password'];
				$setData['password'] = password_hash($postData['new_password'],PASSWORD_BCRYPT);
				$setData['security_key'] = NULL;
				if(self::$Users->UpdateRecord($setData)){
					return response()->json(['status' => 'success']);
				}
			}
		}
		exit;
	}

	public function change_user_profile(Request $request){
		if($request->ajax()){
			$setData = array();
			$msg = [];
			$postData = $request->all();
			if(isset($postData) && !empty($postData)){
				$actual_image_name = time().rand().'.'.$request->profile_picture->extension();  
				$destination = base_path().'/public/assets/images/admin/';
				if($request->profile_picture->move($destination, $actual_image_name)){
					if($request->input('old_banner') != ""){
						if(file_exists($destination.$request->input('old_banner'))){
							unlink($destination.$request->input('old_banner'));
						}
					}
					return response()->json(['status' => 'success','img_name' => $actual_image_name, 'img_url' => asset('public/assets/images/admin/'.$actual_image_name)]);
				}else{
					return response()->json(['status' => 'error', 'msg' => 'Something went wrong']);
				}			
			}		
		}
		exit;
	}
	
	public function dashboard(Request $request){
		if(!$request->session()->has('auth.id') || $request->session()->get('auth.user_type') != 'User'){return redirect('/login');}
		$authId = $request->session()->get('auth.id');
		$authUserType = $request->session()->get('auth.user_type');
		$user = self::$Users->where('id',$authId)->first();
		
		return view('customers.dashboard',compact('user'));
	}

	public function setUserSession($userID){
		$userData = self::$Users->where('id',$userID)->first();
		#set Session
		Session::put('login_unique_id', $userData->unique_id);
		Session::put('login_user_email', $userData->email);
		Session::put('login_user_name', $userData->name);
		Session::put('login_user_id', $userData->id);								
		Session::save();
		return true;
	}

	public function logout(Request $request){
		Session::flush();
		return redirect('/');
	}

}