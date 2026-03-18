<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Colleges;
use App\Models\Countries;
use App\Models\States;
use App\Models\CollegeImages;
use App\Models\CollegeCategories;
use App\Models\CollegeRanks;
use App\Models\CollegeSubCategories;
use App\Models\LocalAreas;
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

class CollegesController extends Controller {
    private static $Colleges;
	private static $Countries;
	private static $States;
	private static $CollegeImages;
	private static $CollegeCategories;
	private static $CollegeRanks;
	private static $CollegeSubCategories;
	private static $LocalAreas;
    private static $TokenHelper;

    public function __construct(){
        self::$Colleges = new Colleges();
		self::$Countries = new Countries();
		self::$States = new States();
		self::$CollegeImages = new CollegeImages();
		self::$CollegeCategories = new CollegeCategories();
		self::$CollegeRanks = new CollegeRanks();
		self::$CollegeSubCategories = new CollegeSubCategories();
		self::$LocalAreas = new LocalAreas();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){		
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		
		/*$file = fopen(base_path().'/public/admin/images/banners/2025/sample1.csv', "r");
		$num = 1;
		date_default_timezone_set('Asia/Kolkata');
		while (($column = fgetcsv($file, 10000, ",")) !== FALSE){
			if($num > 1){
				if($column[0] != ''){
					$countData = self::$CollegeImages->where('college_id',$column[0])->where('status',1)->count();
					if($countData == 0){
						if($column[3]!=""){
							$imgName = $this->saveImage(trim($column[3]));
							if($imgName != ""){
								$setData['college_id'] = $column[0];
								$setData['image'] = $imgName;
								self::$CollegeImages->CreateRecord($setData);
							}
						}
						if($column[4]!=""){
							$imgName = $this->saveImage(trim($column[4]));
							if($imgName != ""){
								$setData['college_id'] = $column[0];
								$setData['image'] = $imgName;
								self::$CollegeImages->CreateRecord($setData);
							}
							
						}
						if($column[5]!=""){
							$imgName = $this->saveImage(trim($column[5]));
							if($imgName != ""){
								$setData['college_id'] = $column[0];
								$setData['image'] = $imgName;
								self::$CollegeImages->CreateRecord($setData);
							}
							
						}
						if($column[6]!=""){
							$imgName = $this->saveImage(trim($column[6]));
							if($imgName != ""){
								$setData['college_id'] = $column[0];
								$setData['image'] = $imgName;
								self::$CollegeImages->CreateRecord($setData);
							}
							
						}
						if($column[7]!=""){
							$imgName = $this->saveImage(trim($column[7]));
							if($imgName != ""){
								$setData['college_id'] = $column[0];
								$setData['image'] = $imgName;
								self::$CollegeImages->CreateRecord($setData);
							}
						}
						if($column[8]!=""){
							$imgName = $this->saveImage(trim($column[8]));
							if($imgName != ""){
								$setData['college_id'] = $column[0];
								$setData['image'] = $imgName;
								self::$CollegeImages->CreateRecord($setData);
							}
							
						}
					}
					
					
				}
			}
			$num++;
		}
		
		echo 'Success'; die;*/
		/*$dir = $_SERVER['DOCUMENT_ROOT'].'/public/admin/images/banners/logos';
		$des = $_SERVER['DOCUMENT_ROOT'].'/public/admin/images/banners/new';
		$files = scandir($dir);
		foreach($files as $key => $file){
			if($file != '.' && $file != '..'){
				$path_info = pathinfo($file);
				$collegeName = trim($path_info['filename']);
				$extension = $path_info['extension'];
				$newFileName = time().rand(1001,9999).$key.'.'.$extension;
				copy($dir.'/'.$file, $des.'/'.$newFileName);
				$record = self::$Colleges->select('id')->where('name', $collegeName)->first();
				if(isset($record->id)){
					self::$Colleges->where('id', $record->id)->update(['logo' => $newFileName]);
				}
			}
		}
		echo '<pre>';
		print_r($files); die;*/
		
		$countries = $this->getCountryList();
		$states = $this->getStateList();
       	return view('/panel/colleges/index',compact('countries','states'));
    }
	public function saveImage($url){
		$path_info = pathinfo($url);
		if(isset($path_info['extension'])){
			$ext = $path_info['extension']; 
			$actual_image_name = time().rand(1001,9999).'.'.$ext;
			$destination = base_path().'/public/admin/images/banners/2025/12/';
			$img = $destination.$actual_image_name;
			//echo $url; die;
			$context = stream_context_create([
							'ssl' => [
								'verify_peer'      => false,
								'verify_peer_name' => false,
								'allow_self_signed'=> true,
							],
						]);
			if(@file_put_contents($img,@file_get_contents($url,false,$context))){
				return $actual_image_name;
			}else{
				return '';
			}
			
		}else{
			return '';
		}
	}
    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Colleges->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
		if($request->input('search_country') && $request->input('search_country') != ""){		
			$query->where('country', $request->input('search_country'));			
		}
		if($request->input('search_state') && $request->input('search_state') != ""){		
			$query->where('state', $request->input('search_state'));	
		}
		if($request->input('search_type') && $request->input('search_type') != ""){		
			$query->where('type', $request->input('search_type'));
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('colleges.name', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('colleges.ranking', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/colleges/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'name' => 'required',
				'country' => 'required',
			 ], [
			 	'name.required' => 'Please enter name.',  
				'country.required' => 'Please enter country.', 
			]);
            if($validator->fails()){
                $errors = $validator->errors();                
				if($errors->first('name')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('name')));
                    die;
                }
				if($errors->first('country')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('country')));
                    die;
                }
            }else{
                $mobileExist = self::$Colleges->where('name', $request->name)->where('country', $request->country)->where('state', $request->state)->where('city', $request->city)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'College already exist'));
                    die;
                }
				$state_name = NULL;
				if($request->input('state') && $request->input('slug') != ''){
					$state_data = self::$States->where('status',1)->where('id',$request->input('state'))->first();
					if(isset($state_data->id)){
						$state_name = $state_data->state;
					}
				}
				$setData['type'] = $request->input('type');
				$setData['city'] = $request->input('city');
				$setData['country'] = $request->input('country');
                $setData['name'] = $request->input('name');
				$setData['slug'] = Str::slug($request->input('name').' '.$state_name.' '.$request->input('city'));				
				$setData['state'] = $request->input('state');
				
               	$record = self::$Colleges->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
		$countries = $this->getCountryList();
		$states = $this->getStateList();
		$college_categories = $this->getCollegeCategoryList();
		$college_sub_categories = $this->getCollegeSubCategoryList();
		$college_localareas = $this->getlocalAreasList();
        return view('/panel/colleges/add-page',compact('states','countries','college_categories','college_sub_categories','college_localareas'));
    }

    #editPage
    public function editPage(Request $request, $row_id){
		if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }		
        $row_id = base64_decode($row_id);
		
		/*
		$array = ["Govt","Mgmt","NRI","GQ","Mgmt (Converted UR)","NRI (Converted UR)","MGT","SGS","STATE"];	
		
		foreach($array as $key => $vl){
		$countData = self::$CollegeCategories->where('title',$vl)->where('status','!=',3)->count();	
		
		if($countData == 0){
				$setData['title'] = $vl;
				self::$CollegeCategories->CreateRecord($setData);	
			}			
		}	
		die;
		*/

        if($request->input()){
            $validator = Validator::make($request->all(), [
				'name' => 'required', 
				'slug' => 'required', 				
				'country' => 'required',
			 ], [
			 	'name.required' => 'Please enter name.', 
				'slug.required' => 'Please enter slug.', 
				'country.required' => 'Please enter country.',
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('name')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('name')));
                    die;
                }
				if($errors->first('slug')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('slug')));
                    die;
                }
				if($errors->first('country')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('country')));
                    die;
                }
            }else{
				$mobileExist = self::$Colleges->where('name', $request->name)->where('country', $request->country)->where('state', $request->state)->where('city', $request->city)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'College already exist'));
                    die;
                }
				$slugExist = self::$Colleges->where('slug', $request->slug)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($slugExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'College slug already exist'));
                    die;
                }
				if($request->edit_college_category_id){
					foreach($request->edit_college_category_id as $ekey => $eccat){
						if($request->edit_rank[$ekey] != '' && $eccat != ''){
							$setEditCollRankData['college_category_id'] = $eccat;
							$setEditCollRankData['rank'] = $request->edit_rank[$ekey];
							$setEditCollRankData['sub_category_id'] = $request->edit_college_subcategory_id[$ekey];
							$setEditCollRankData['local_area_id'] = $request->edit_college_localarea_id[$ekey];
							$setEditCollRankData['female_rank'] = $request->edit_female_rank[$ekey];
							$setEditCollRankData['male_rank'] = $request->edit_male_rank[$ekey];
							self::$CollegeRanks->where('id', $request->edit_rank_id[$ekey])->update($setEditCollRankData);
						}
					}
				}

				if($request->college_category_id){
					foreach($request->college_category_id as $key => $ccat){
						if($request->rank[$key] != '' && $ccat != ''){
							$setCollRankData['college_id'] = $request->input('row_id');
							$setCollRankData['college_category_id'] = $ccat;
							$setCollRankData['sub_category_id'] = $request->college_subcategory_id[$key];
							$setCollRankData['local_area_id'] = $request->college_localarea_id[$key];
							$setCollRankData['rank'] = $request->rank[$key];
							$setCollRankData['female_rank'] = $request->female_rank[$key];
							$setCollRankData['male_rank'] = $request->male_rank[$key];
							self::$CollegeRanks->CreateRecord($setCollRankData);
						}
					}
				}
				
				$setData['type'] = $request->input('type');
				$setData['city'] = $request->input('city');
				$setData['country'] = $request->input('country');
				$setData['ranking'] = $request->input('ranking');
				$setData['rating'] = $request->input('rating');
                $setData['name'] = $request->input('name');
				$setData['slug'] = $request->input('slug');
				$setData['description'] = $request->input('description');
				$setData['course_name'] = $request->input('course_name');
				$setData['state'] = $request->input('state');
				$setData['lop_date'] = $request->input('lop_date');
				$setData['address'] = $request->input('address');
				$setData['management'] = $request->input('management');
				$setData['inspection_year'] = $request->input('inspection_year');
				$setData['seats'] = $request->input('seats');
				$setData['mci_recongniotion'] = $request->input('mci_recongniotion');
				$setData['campus'] = $request->input('campus');
				$setData['mess'] = $request->input('mess');
				$setData['hospital'] = $request->input('hospital');
				$setData['city_info'] = $request->input('city_info');				
				$setData['fees_structure'] = $request->input('fees_structure');
				$setData['miscellaneous'] = $request->input('miscellaneous');
				$setData['canonical_tags'] = $request->input('canonical_tags');				
				$setData['schema_tags'] = $request->input('schema_tags');				
				$setData['gen_boys'] = $request->input('gen_boys');
				$setData['obc_boys'] = $request->input('obc_boys');
				$setData['ews_boys'] = $request->input('ews_boys');
				$setData['sc_boys'] = $request->input('sc_boys');
				$setData['st_boys'] = $request->input('st_boys');
				$setData['mbc_boys'] = $request->input('mbc_boys');
				$setData['sa_boys'] = $request->input('sa_boys');
				$setData['gen_girls'] = $request->input('gen_girls');
				$setData['obc_girls'] = $request->input('obc_girls');
				$setData['ews_girls'] = $request->input('ews_girls');
				$setData['sc_girls'] = $request->input('sc_girls');
				$setData['st_girls'] = $request->input('st_girls');
				$setData['mbc_girls'] = $request->input('mbc_girls');
				$setData['sa_girls'] = $request->input('sa_girls');				
				$setData['seo_title'] = $request->input('seo_title');
                $setData['seo_description'] = $request->input('seo_description');
                $setData['seo_keyword'] = $request->input('seo_keyword');
                $setData['robot_tags'] = $request->input('robot_tags');
				
				#logo pic upload
                if(isset($request->logo) && $request->logo->extension() != ""){
                    $validator = Validator::make($request->all(), ['logo' => 'required|image|mimes:jpeg,png,jpg|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('logo')));
                        die;
                    }else{						
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' . $request->logo->extension();
                        $destination = base_path().'/public/admin/images/banners/';
                        $request->logo->move($destination, $actual_image_name);
						$setData['logo'] = $actual_image_name;
						if($request->input('old_logo') != ""){
                            if (file_exists($destination . $request->old_logo)){
                                unlink($destination . $request->old_logo);
                            }
                        }
                    }
                }
				#brochure pic upload
                if(isset($request->brochure) && $request->brochure->extension() != ""){
                    $validator = Validator::make($request->all(), ['brochure' => 'required|mimes:pdf,png,jpg|max:20480']);
                    if($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('brochure')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' . $request->brochure->extension();
                        $destination = base_path().'/public/admin/images/banners/';
                        $request->brochure->move($destination, $actual_image_name);
                        if($request->input('old_brochure') != ""){
                            if(file_exists($destination . $request->old_brochure)){
                                unlink($destination . $request->old_brochure);
                            }
                        }
						$setData['brochure'] = $actual_image_name;
                    }
                }
                $record = self::$Colleges->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){			
			$college_ranks = self::$CollegeRanks->where('college_id',$row_id)->where('status','!=',3)->get();
			$college_images = self::$CollegeImages->where('college_id',$row_id)->where('status','!=',3)->latest()->get();
            $record = self::$Colleges->where('id', $row_id)->first();
			$countries = $this->getCountryList();
			$college_categories = $this->getCollegeCategoryList();
			$college_sub_categories = $this->getCollegeSubCategoryList();
			$college_localareas = $this->getlocalAreasList();
			$states = $this->getStateList($record->country);
			if($record->lop_date != NULL && $record->lop_date != 'N/A'){
				$record->lop_date = date('Y-m-d',strtotime($record->lop_date));
			}
            return view('/panel/colleges/edit-page', ['record' => $record, 'states' => $states, 'college_images' => $college_images, 'countries' => $countries, 'college_categories' => $college_categories, 'college_ranks' => $college_ranks, 'college_sub_categories' => $college_sub_categories, 'college_localareas' => $college_localareas]);
        }else{
            return redirect('/panel/colleges');
        }
    }

	public function uploadCollegeImages(Request $request){
        if($request->ajax()){
            if(!empty($_FILES)){
				$postData = $request->all();
                $msg = "Error";
                $fileName = $_FILES['file']['name']; //Get the image
                $file_temp_name = $_FILES['file']['tmp_name'];
                $pathInfo = pathinfo(basename($fileName));
                $ext = $request->file->extension();
                $checkImage = getimagesize($file_temp_name);
				$actual_image_name = sha1(str_shuffle(microtime(true).mt_rand(100001,999999)).uniqid(mt_rand().true).$request->file('file')).$postData['id'].'.'.$request->file->extension();
				$year = date('Y');
				$month = date('m');
				if(!File::exists(public_path('/admin/images/banners/'.$year))){
					mkdir(public_path('/admin/images/banners/'.$year, 0777, true));
				}
				if(!File::exists(public_path('/admin/images/banners/'.$year.'/'.$month))){
					mkdir(public_path('/admin/images/banners/'.$year.'/'.$month, 0777, true));
				}
				$destination2 = base_path().'/public/admin/images/banners/'.$year.'/'.$month.'/';
                if($checkImage !== false){
					if($request->file->move($destination2, $actual_image_name)){
						$setData['college_id'] = $request->input('id');
						$setData['image'] = $actual_image_name;
						$record = self::$CollegeImages->CreateRecord($setData);
						$msg = "Success";
					}
                }
            }
            echo json_encode(array('msg' => $msg));
        }
        exit;
    }

	function getStateList($cid = NULL){
		//return self::$States->where('status',1)->where('country_id',101)->pluck('state','id');
		if($cid > 0){
			return self::$States->where('status',1)->where('country_id',$cid)->pluck('state','id');
		}else{
			return self::$States->where('status',1)->pluck('state','id');
		}
	}
	
	function getCountryList(){
		//return self::$States->where('status',1)->where('country_id',101)->pluck('state','id');
		return self::$Countries->where('status',1)->pluck('title','id');
	}
	
	function getCollegeCategoryList(){
		return self::$CollegeCategories->where('status',1)->pluck('title','id');
	}
	
	function getCollegeSubCategoryList(){
		return self::$CollegeSubCategories->where('status',1)->pluck('title','id');
	}
	
	function getlocalAreasList(){
		return self::$LocalAreas->where('status',1)->pluck('title','id');
	}
	
	

}