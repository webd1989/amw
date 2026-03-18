<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Colleges;
use App\Models\CollegeCategories;
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

class ImportController extends Controller{
    private static $Colleges;
	private static $CollegeCategories;
    public function __construct(){
        self::$CollegeCategories = new CollegeCategories();
		self::$Colleges = new Colleges();
    }

    #importVendor
    public function importCollegeCategories(Request $request){
        if(!$request->session()->has('admin_email')){
            echo 'SessionExpired';
            die;
        }
        $fileName = $_FILES["file"]["tmp_name"];
        if(isset($fileName) && !empty($fileName)){
            $csvMimes = array('application/csv', 'text/csv');
            if(!empty($_FILES['file']['name']) && $_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'], $csvMimes)){
                $file = fopen($fileName, "r");
                $num = 1;
				date_default_timezone_set('Asia/Kolkata');
                while (($column = fgetcsv($file, 10000, ",")) !== FALSE){
                    if($num > 1){
						if($column[0] != ''){
							$count = self::$CollegeCategories->where('title',$column[0])->where('status','!=',3)->count();
							if($count == 0){
								$setData['title'] = $column[0];
								$setData['slug'] = Str::slug($column[0]);
								self::$CollegeCategories->CreateRecord($setData);
							}
						}
                    }
                    $num++;
                }
                echo 'Success';
                die;
            } else {
                echo 'InvalidFileType';
                die;
            }
        } else {
            echo 'ChoseFile';
            die;
        }
    }
	
	#importVendor
    public function importColleges(Request $request){
        if(!$request->session()->has('admin_email')){
            echo 'SessionExpired';
            die;
        }
        $fileName = $_FILES["file"]["tmp_name"];
        if(isset($fileName) && !empty($fileName)){
            $csvMimes = array('application/csv', 'text/csv');
            if(!empty($_FILES['file']['name']) && $_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'], $csvMimes)){
                $file = fopen($fileName, "r");
                $num = 1;
				date_default_timezone_set('Asia/Kolkata');
                while (($column = fgetcsv($file, 10000, ",")) !== FALSE){
                    if($num > 1){
						if($column[0] != ''){
							$count = self::$Colleges->where('name',$column[0])->where('status','!=',3)->count();
							if($count == 0){
								$setData['name'] = $column[0];
								$setData['slug'] = Str::slug($column[0]);
								$setData['state'] = $column[1];
								$setData['management'] = $column[2];
								$setData['seats'] = $column[3];
								$setData['inspection_year'] = $column[4];
								$setData['courses'] = $column[5];
								$setData['mci_recongniotion'] = $column[6];
								$setData['lop_date'] = $column[7];
								$setData['seo_title'] = $column[8];
								$setData['seo_description'] = $column[9];
								$setData['seo_keyword'] = $column[10];
								$setData['city'] = $column[11];
								$setData['ranking'] = $column[12];
								$setData['robot_tags'] = 'index,follow';
								self::$Colleges->CreateRecord($setData);
							}
						}
                    }
                    $num++;
                }
                echo 'Success';
                die;
            } else {
                echo 'InvalidFileType';
                die;
            }
        } else {
            echo 'ChoseFile';
            die;
        }
    }
	
}