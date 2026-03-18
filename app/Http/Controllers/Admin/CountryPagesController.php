<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CountryPages;
use App\Models\Countries;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class CountryPagesController extends Controller {
    private static $CountryPages;
	private static $Countries;
    public function __construct(){
        self::$CountryPages = new CountryPages();
		self::$Countries = new Countries();
    }
	function getCountryList(){
		//return self::$States->where('status',1)->where('country_id',101)->pluck('state','id');
		return self::$Countries->where('status',1)->pluck('title','id');
	}
   #admin dashboard page
    public function getList(Request $request){
        if (!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        return view('/panel/country_pages/index');
    }

    public function listPaginate(Request $request){
        if (!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		$page = $request->page;
        $query = self::$CountryPages->where('status', '!=', 3);
        if ($request->input('search_page') && $request->input('search_page') != ""){
           $search_page = $request->input('search_page');
            $query->where('page', 'like', '%' . $search_page . '%');
        }
		if($request->input('search_status') && $request->input('search_status') != ""){
            $query->where('status', $request->input('search_status'));
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
		foreach($records as $key => $record){
			$countryData = self::$Countries->where('id',$record->country_id)->first();
			$record->country_name = $countryData->title;
		}
        return view('/panel/country_pages/paginate', compact('records','page'));
    }
	public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'country_id' => 'required', 				
				'title' => 'required'
			 ], [
			 	'country_id.required' => 'Please select country.', 
				'title.required' => 'Please enter answer.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('country_id')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('country_id')));
                    die;
                }
				if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
            }else{
				$checkExist = self::$CountryPages->where('country_id',$request->input('country_id'))->count();
				if($checkExist > 0){
					return json_encode(array('heading' => 'Error', 'msg' => 'Record already exist'));
                    die;
				}
                $setData['title'] = $request->input('title');
				$setData['slug'] = Str::slug($request->input('title'));
                $setData['country_id'] = $request->input('country_id');
                $setData['description'] = $request->input('description');
				$setData['introduction'] = $request->input('introduction');  
				$setData['elegibility'] = $request->input('elegibility');  
				$setData['canonical_tags'] = $request->input('canonical_tags');				
				$setData['schema_tags'] = $request->input('schema_tags');  
                $setData['seo_title'] = $request->input('seo_title');
                $setData['seo_description'] = $request->input('seo_description');
                $setData['seo_keyword'] = $request->input('seo_keyword');
                $setData['robot_tags'] = $request->input('robot_tags');

               	$record = self::$CountryPages->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
		$countries = $this->getCountryList();
		return view('/panel/country_pages/add-page',compact('countries'));
    }
    #edit Service Type
    public function editPage(Request $request, $row_id){
        $RowID = base64_decode($row_id);
        if (!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		$record = self::$CountryPages->where(array('id' => $RowID))->first();
        if ($request->input()){
            $validator = Validator::make($request->all(), [
				'country_id' => 'required', 				
				'title' => 'required',
				'slug' => 'required'
			 ], [
			 	'country_id.required' => 'Please select country.', 
				'title.required' => 'Please enter title.',
				'slug.required' => 'Please enter slug.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('country_id')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('country_id')));
                    die;
                }
				if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
				if($errors->first('slug')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('slug')));
                    die;
                }
            }else{
				$checkExist = self::$CountryPages->where('country_id',$request->input('country_id'))->where('id','!=',$request->input('row_id'))->count();
				$checkExistSlug = self::$CountryPages->where('slug',$request->input('slug'))->where('id','!=',$request->input('row_id'))->count();
				if($checkExist > 0 || $checkExistSlug > 0){
					return json_encode(array('heading' => 'Error', 'msg' => 'Record already exist'));
                    die;
				}
                #profile pic upload
                if(isset($request->banner) && $request->banner->extension() != ""){
                    $validator = Validator::make($request->all(), ['banner' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
                    if($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('banner')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()).'.'.$request->banner->extension();
                        $destination = base_path() . '/public/admin/images/banners/';
                        $request->banner->move($destination, $actual_image_name);
                        if($request->input('old_banner') != ""){
                            if(file_exists($destination . $request->old_banner)){
                                unlink($destination . $request->old_banner);
                            }
                        }
						$setData['image'] = $actual_image_name;
                    }
                }
                $setData['id'] = $request->row_id;
                $setData['title'] = $request->input('title');
				$setData['slug'] = Str::slug($request->input('slug'));
                $setData['country_id'] = $request->input('country_id');
                $setData['description'] = $request->input('description');
				$setData['introduction'] = $request->input('introduction');  
				$setData['elegibility'] = $request->input('elegibility');
				$setData['alt_image'] = $request->input('alt_image');				
				$setData['canonical_tags'] = $request->input('canonical_tags');				
				$setData['schema_tags'] = $request->input('schema_tags');  
                $setData['seo_title'] = $request->input('seo_title');
                $setData['seo_description'] = $request->input('seo_description');
                $setData['seo_keyword'] = $request->input('seo_keyword');
                $setData['robot_tags'] = $request->input('robot_tags');
                self::$CountryPages->UpdateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Country page details updated successfully'));
                die;
            }
        }        
        if (isset($record->id)){
			$countries = $this->getCountryList();
            return view('/panel/country_pages/edit-page', compact('record', 'row_id','countries'));
        }else{
            return redirect('/panel/country-pages');
        }
    }

}