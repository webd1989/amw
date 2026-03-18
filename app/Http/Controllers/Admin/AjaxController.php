<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
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

    private static $TokenHelper;
	public function __construct(){
        self::$TokenHelper = new TokenHelper();
	}
	
	public function changePrice(Request $request){
		if(!$request->session()->has('admin_id')){echo 'SessionExpire'; die;}
		$value = $request->input('value');
		$rowID = $request->input('id');
		$field = $request->input('field');
		if(DB::table('products')->where(array('id' => $rowID))->update(array($field => $value))){
			echo "Success"; die;
		}else{
			echo "Error"; die;
		}
	}
	
	public function changeProductStatus(Request $request){
		if(!$request->session()->has('admin_id')){echo 'SessionExpire'; die;}
		$tableName = $request->input('table');
		$rowID = $request->input('rowID');
		$new_status = $request->input('status');
		$record = DB::table($tableName)->select('status')->where(array('id' => $rowID))->first();
		$status = $record->status;
		if($tableName != "" && $rowID != "" && $status != "" && is_numeric($rowID) && is_numeric($status)){            
            $newStatus = $new_status;
			if($newStatus == 3){
				DB::table($tableName)->where(array('id' => $rowID))->update(array('status' => $newStatus, 'moderation_status' => 'Pending'));
			}else{
				DB::table($tableName)->where(array('id' => $rowID))->update(array('status' => $newStatus));
			}			
			echo 'Success';die;
		}else{
			echo 'InvalidData'; die;
		}
    }

	public function getEnquiry(Request $request){
		$enquiry = DB::table('contacts')->where('id', $request->rowId)->first();
		DB::table('contacts')->where(array('id' => $enquiry->id))->update(array('read_status' => 1));
		return view('/panel/ajax/enquiry_details',['enquiry' => $enquiry]);
    }

   public function changeStatus(Request $request){
		if(!$request->session()->has('admin_id')){echo 'SessionExpire'; die;}
		$tableName = $request->input('table');
		$rowID = $request->input('rowID');
		$status = $request->input('status');
		if($tableName != "" && $rowID != "" && $status != "" && is_numeric($rowID) && is_numeric($status)){
            $newStatus = $status == 1 ? 2 : 1;
			DB::table($tableName)->where(array('id' => $rowID))->update(array('status' => $newStatus));
			echo 'Success';die;
		}else{
			echo 'InvalidData'; die;
		}
    }

	public function getUserDetails(Request $request){
		$userData = DB::table('users')->where('id', $request->rowId)->first();
		return view('/panel/ajax/user_details',['userData' => $userData]);
    }

    public function deleteRecord(Request $request){
		if(!$request->session()->has('admin_id')){echo 'SessionExpire'; die;}
		$tableName = $request->input('table');
		$rowID = $request->input('rowID');
		if($tableName != "" && $rowID != "" && is_numeric($rowID)){
            DB::table($tableName)->where(array('id' => $rowID))->update(array('status' => 3));
			echo 'Success';die;
		}else{
			echo 'InvalidData'; die;
		}
    }

    public function productsChangeStatus(Request $request){
		if(!$request->session()->has('admin_id')){echo 'SessionExpire'; die;}
		$productIDs = $request->input('productIDs');
		$status = $request->input('status');
        if(count($productIDs) == 0){
            echo 'Please select Products.';die;
        }
		if($status != "" && is_numeric($status)){
            foreach($productIDs as $rowID){
                $newStatus = $status == 1 ? 2 : 1;
                DB::table('products')->where(array('id' => $rowID))->update(array('status' => $newStatus));
            }
			echo 'Success';die;
		}else{
			echo 'InvalidData'; die;
		}
    }
	
    public function productsDeleteRecord(Request $request){
		if(!$request->session()->has('admin_id')){echo 'SessionExpire'; die;}
		$productIDs = $request->input('productIDs');
		$status = $request->input('status');
        if(count($productIDs) == 0){
            echo 'Please select Products.';die;
        }
        foreach($productIDs as $rowID){
            $newStatus = $status == 1 ? 2 : 1;
            //DB::table('products')->where('id', $rowID)->delete();
            DB::table('products')->where(array('id' => $rowID))->update(array('status' => 3));
        }
        echo 'Success';die;
    }
 
	public function getState(Request $request){
		if($request->ajax()){
			$country_id = $request->input('countryId');
			$states = DB::table('states')->where('country_id',$country_id)->where('status',1)->orderBy('state')->pluck('state','id');
			echo view('/panel/ajax/get_state',compact('states'));
		}
		exit;
	}
	
	public function getCity(Request $request){
		if($request->ajax()){
			$state_id = $request->input('stateId');
			$cities = DB::table('cities')->where('state_id',$state_id)->where('status',1)->orderBy('city')->pluck('city','id');
			echo view('/panel/ajax/get_city',compact('cities'));
		}
		exit;
	}

	public function getCollegeCategory(Request $request){
		if($request->ajax()){
			$rand = mt_rand();
			$ccategories = DB::table('college_categories')->where('status',1)->orderBy('title')->pluck('title','id');
			$cscategories = DB::table('sub_categories')->where('status',1)->orderBy('title')->pluck('title','id');
			$college_localareas = DB::table('local_areas')->where('status',1)->orderBy('title')->pluck('title','id');
			echo view('/panel/ajax/get_college_category',compact('ccategories','cscategories','college_localareas','rand'));
		}
		exit;
	}
	
	#create Image
    function createImage($base64_string, $output_file, $ext = NULL) {
        if($ext == 'jpg'){
            $image = imagecreatefrompng($base64_string);
            imagejpeg($image, $output_file, 100);
            imagedestroy($image);
        }else{
            $ifp = fopen($output_file, "wb");
            $data = explode(',', $base64_string);
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);
        }
    }
	
	public function uploadCropperImage(Request $request){
		if($request->ajax()){
			$msg = "Error";
			$postData = $request->all();
            if(!empty($postData)){
				$folder = $postData['folder'];
				$ext = $postData['ext'];
				$crop_img = $postData['crop_img'];
				$destination = base_path().'/public/admin/images/'.$folder.'/';
				$actual_image_name = time().random_int(0,99999).".".$ext;
				$this->createImage($crop_img,$destination.$actual_image_name,$ext);
				$fullpath = env('APP_URL').'/public/admin/images/'.$folder.'/'.$actual_image_name;				
				if($postData['old_image'] != ''){
					if(file_exists($destination.$postData['old_image'])){
						unlink($destination.$postData['old_image']);
					}
				}
            	echo json_encode(array('filename' => $actual_image_name, 'full_path' => $fullpath));
        	}
        	exit;
		}
	}

}