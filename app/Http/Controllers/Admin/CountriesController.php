<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Countries;
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

class CountriesController extends Controller {
    private static $Categories;
	private static $Countries;
    private static $TokenHelper;

    public function __construct(){
        self::$Categories = new Categories();
		self::$Countries = new Countries();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       	return view('/panel/countries/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Countries->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('title', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('country_code', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/countries/paginate', compact('records'));
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
				'slug' => 'required'
			 ], [
			 	'title.required' => 'Please enter title.', 
				'slug.required' => 'Please enter slug.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
				if($errors->first('slug')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('slug')));
                    die;
                }
            }else{
				$mobileExist = self::$Countries->where('title', $request->title)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Country already exist'));
                    die;
                }
				$mobileExist = self::$Countries->where('slug', $request->slug)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Slug already exist'));
                    die;
                }
				$setData['title'] = $request->input('title');
				$setData['slug'] = Str::slug($request->input('slug'));
				$setData['description'] = $request->input('description');
				$setData['country_code'] = $request->input('country_code');
				$setData['phonecode'] = $request->input('phonecode');
				$setData['seo_title'] = $request->input('seo_title');
				$setData['seo_description'] = $request->input('seo_description');
				$setData['seo_keyword'] = $request->input('seo_keyword');
				$setData['schema_tags'] = $request->input('schema_tags');
				$setData['canonical_tags'] = $request->input('canonical_tags');
				$setData['robot_tags'] = $request->input('robot_tags');
				#profile pic upload
                if(isset($request->banner) && $request->banner->extension() != ""){
                    $validator = Validator::make($request->all(), ['banner' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('banner')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' .$request->banner->extension();
                        $destination = base_path().'/public/admin/images/blogs/';
                        $request->banner->move($destination, $actual_image_name);
						$setData['banner'] = $actual_image_name;
						if($request->input('old_image') != ""){
                            if(file_exists($destination . $request->old_image)){
                                unlink($destination . $request->old_image);
                            }
                        }
                    }
                }
                $record = self::$Countries->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
            $record = self::$Countries->where('id', $row_id)->first();
            return view('/panel/countries/edit-page', ['record' => $record]);
        }else{
            return redirect('/panel/Countries');
        }
    }

}