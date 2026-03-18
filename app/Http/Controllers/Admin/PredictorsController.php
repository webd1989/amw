<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Predictors;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class PredictorsController extends Controller {
    private static $Predictors;
    private static $TokenHelper;
	
    public function __construct(){
        self::$Predictors = new Predictors();
        self::$TokenHelper = new TokenHelper();
    }
	
    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        return view('/panel/predictors/index');
    }
	
    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Predictors->where('status', '!=', 3);
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('predictors.first_name', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('predictors.last_name', 'like', '%'.$SearchKeyword.'%')
				   ->orWhere('predictors.mobile', 'like', '%'.$SearchKeyword.'%')				   
				   ->orWhere('predictors.email', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        if($request->input('search_status') && $request->input('search_status') != ""){
            $query->where('order_status', $request->input('search_status'));
        }
		
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/predictors/paginate', compact('records'));
    }
	
	public function viewPage(Request $request, $vid = NULL){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		if($vid != ''){
			$vid = base64_decode($vid);
			if($vid > 0){
				$order = self::$Predictors->where('id',$vid)->first();
				if(isset($order->id)){
					return view('/panel/predictors/view-page',compact('order'));
				}else{
					return redirect('/panel/');		
				}
			}
		}else{
			return redirect('/panel/');	
		}
			
	}

}