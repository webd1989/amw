<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Languages;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class OrdersController extends Controller {
    private static $Orders;
    private static $TokenHelper;
	
    public function __construct(){
        self::$Orders = new Orders();
        self::$TokenHelper = new TokenHelper();
    }
	
    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        return view('/panel/orders/index');
    }
	
    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Orders->where('status', '!=', 3);
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('orders.customer_name', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('orders.customer_email', 'like', '%'.$SearchKeyword.'%')
				   ->orWhere('orders.customer_mobile', 'like', '%'.$SearchKeyword.'%')				   
				   ->orWhere('orders.invoice_id', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
		if(!empty($request->input('from_date')) || !empty($request->input('to_date'))){
            $fdate = $tdate = '';
            if(!empty($request->input('from_date'))){
                $fdate = date('Y-m-d', strtotime($request->input('from_date')));
            }
            if(!empty($request->input('to_date'))){
                $tdate = date('Y-m-d', strtotime($request->input('to_date')));
            }
            if(!empty($fdate) && empty($tdate)){
                $query->where('order_date', '>=', $fdate);
            }else if(empty($fdate) && !empty($tdate)){
                $query->where('order_date', '<=', $tdate);
            }else{
                $query->whereBetween(DB::raw('DATE(order_date)'), [$fdate, $tdate]);
            }
        }
        if($request->input('search_status') && $request->input('search_status') != ""){
            $query->where('order_status', $request->input('search_status'));
        }
		
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/orders/paginate', compact('records'));
    }
	
	public function viewPage(Request $request, $vid = NULL){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		if($vid != ''){
			$vid = base64_decode($vid);
			if($vid > 0){
				$order = self::$Orders->where('id',$vid)->first();
				if(isset($order->id)){
					return view('/panel/orders/view-page',compact('order'));
				}else{
					return redirect('/panel/');		
				}
			}
		}else{
			return redirect('/panel/');	
		}
			
	}

}