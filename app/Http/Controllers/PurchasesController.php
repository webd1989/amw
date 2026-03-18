<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\InnerPages;
use App\Models\Orders;
use App\Models\Users;
use App\Models\Plans;
use App\Models\TokenHelper;
use App\Models\Responses;
use App\RouteHelper;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Hash;
use Illuminate\Validation\Rule;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class PurchasesController extends Controller{

    private static $InnerPages;
	private static $Users;
	private static $Orders;
	private static $Plans;
    private static $TokenHelper;
	
    public function __construct(){
        self::$InnerPages = new InnerPages();
		self::$Users = new Users();
		self::$Orders = new Orders();
		self::$Plans = new Plans();
        self::$TokenHelper = new TokenHelper();
    }
    	
	public function plan(Request $request,$pid = NULL){
		if(!$request->session()->has('login_user_email')){return redirect('/');}
		if($pid != ''){
			$pid = base64_decode($pid);
			if($pid > 0){
				$package = self::$Plans->where('status',1)->where('id',$pid)->first();	
				if(isset($package->id)){
					$inner_page = self::$InnerPages->where('status',1)->first();
					return view('purchases.plan', compact('inner_page','package'));		
				}else{
					return redirect('/');	
				}			
			}else{
				return redirect('/');
			}			
		}else{
			return redirect('/');
		}		
	}
	
	public function purchasePackage(Request $request){
		if(!$request->session()->has('login_user_email')){return redirect('/');}
		if($request->ajax()){
			$package_id = base64_decode($request->package_id);
			if($package_id > 0){
				$package = self::$Plans->where('status',1)->where('id',$package_id)->first();
				if(isset($package->id)){
					$userData = self::$Users->where('id',Session::get('login_user_id'))->first();
					if(isset($userData->id)){
						$setData['product_id'] = $package->id;
						$setData['user_id'] = $userData->id;
						$setData['product_name'] = $package->title;
						$setData['customer_name'] = $userData->name;
						$setData['customer_email'] = $userData->email;
						$setData['customer_mobile'] = $userData->mobile;
						$setData['customer_address'] = $userData->address;
						$setData['customer_city'] = $userData->city;
						$setData['customer_state'] = $userData->state;
						$setData['customer_zipcode'] = $userData->zipcode;
						$setData['order_date'] = date('Y-m-d');
						$setData['discount'] = 0;
						$setData['total'] = $package->price;
						$record = self::$Orders->CreateRecord($setData);
						$setInvoice['invoice_id'] = mt_rand(111,999).$record->id;
						self::$Orders->where('id',$record->id)->update($setInvoice);
						echo json_encode(array('success'=>true,'message'=>'Package purchase successfully'));die;
					}else{
						return json_encode(array('success'=>false,'message'=>'User not found.'));die;
					}					
				}else{
					return json_encode(array('success'=>false,'message'=>'Package not found.'));die;
				}
			}else{
				return json_encode(array('success'=>false,'message'=>'Package not found.'));die;
			}
		}
		exit;
	}

}