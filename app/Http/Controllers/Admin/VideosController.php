<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Videos;
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

class VideosController extends Controller {
	
    private static $Videos;
    private static $TokenHelper;

    public function __construct(){
        self::$Videos = new Videos();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       return view('/panel/videos/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Videos->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('testimonials.name', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('testimonials.testimonial', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/videos/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'name' => 'required', 				
				'testimonial' => 'required'
			 ], [
			 	'name.required' => 'Please enter name.', 
				'testimonial.required' => 'Please enter testimonial.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('name')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('name')));
                    die;
                }
				if($errors->first('testimonial')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('testimonial')));
                    die;
                }
            }else{
                $setData['name'] = $request->input('name');
				$setData['testimonial'] = $request->input('testimonial');
				
				#profile pic upload
                if(isset($request->image) && $request->image->extension() != ""){
                    $validator = Validator::make($request->all(), ['image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('image')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' .$request->image->extension();
                        $destination = base_path().'/public/admin/images/users/';
                        $request->image->move($destination, $actual_image_name);
						$setData['image'] = $actual_image_name;
                    }
                }
               	$record = self::$Videos->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
		return view('/panel/videos/add-page');
    }

    #editPage
    public function editPage(Request $request, $row_id){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $row_id = base64_decode($row_id);
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'name' => 'required', 				
				'testimonial' => 'required'
			 ], [
			 	'name.required' => 'Please enter name.', 
				'testimonial.required' => 'Please enter testimonial.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('name')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('name')));
                    die;
                }
				if($errors->first('testimonial')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('testimonial')));
                    die;
                }
            }else{				
                $setData['name'] = $request->input('name');
				$setData['testimonial'] = $request->input('testimonial');
				#profile pic upload
                if(isset($request->image) && $request->image->extension() != ""){
                    $validator = Validator::make($request->all(), ['image' => 'required|image|mimes:jpeg,png,jpg|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('image')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' .$request->image->extension();
                        $destination = base_path().'/public/admin/images/users/';
                        $request->image->move($destination, $actual_image_name);
						$setData['image'] = $actual_image_name;
						if($request->input('old_image') != ""){
                            if(file_exists($destination . $request->old_image)){
                                unlink($destination . $request->old_image);
                            }
                        }
                    }
                }
                $record = self::$Videos->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
            $record = self::$Videos->where('id', $row_id)->first();
            return view('/panel/videos/edit-page', ['record' => $record]);
        }else{
            return redirect('/panel/videos');
        }
    }

}