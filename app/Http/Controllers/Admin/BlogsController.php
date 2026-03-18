<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Blogs;
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

class BlogsController extends Controller {
    private static $Categories;
	private static $Blogs;
    private static $TokenHelper;

    public function __construct(){
        self::$Categories = new Categories();
		self::$Blogs = new Blogs();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		$categories = $this->getCategory();
       	return view('/panel/blogs/index',compact('categories'));
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Blogs->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
		if($request->input('search_category') && $request->input('search_category') != ""){		
			$query->where('category', $request->input('search_category'));
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('blogs.title', 'like', '%'.$SearchKeyword.'%') 
                   ->orWhere('blogs.description', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/blogs/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'title' => 'required', 				
				'description' => 'required',
				'blog_date' => 'required'
			 ], [
			 	'title.required' => 'Please enter title.', 
				'description.required' => 'Please enter description.',
				'blog_date.required' => 'Please enter blog date.'
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
				if($errors->first('description')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('description')));
                    die;
                }
				if($errors->first('blog_date')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('blog_date')));
                    die;
                }
            }else{
				$mobileExist = self::$Blogs->where('title', $request->title)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Blog already exist'));
                    die;
                }
				$setData['category'] = $request->input('category');
                $setData['title'] = $request->input('title');
				$setData['slug'] = Str::slug($request->input('title'));
				$setData['description'] = $request->input('description');
				$setData['added_by'] = $request->input('added_by');
				$setData['blog_date'] = $request->input('blog_date');
				$setData['image_alt'] = $request->input('image_alt');	
				$setData['author_id'] = $request->input('author_id');	
				$setData['canonical_tags'] = $request->input('canonical_tags');
				$setData['schema_tags'] = $request->input('schema_tags');
				$setData['seo_title'] = $request->input('seo_title');
				$setData['seo_description'] = $request->input('seo_description');
				$setData['seo_keyword'] = $request->input('seo_keyword');
				$setData['robot_tags'] = $request->input('robot_tags');
				#profile pic upload
                if(isset($request->image) && $request->image->extension() != ""){
                    $validator = Validator::make($request->all(), ['image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('image')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' .$request->image->extension();
                        $destination = base_path().'/public/admin/images/blogs/';
                        $request->image->move($destination, $actual_image_name);
						$setData['image'] = $actual_image_name;
                    }
                }
               	$record = self::$Blogs->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
		$categories = $this->getCategory();
		return view('/panel/blogs/add-page',compact('categories'));
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
				'slug' => 'required', 				
				'description' => 'required'
			 ], [
			 	'title.required' => 'Please enter title.', 
				'slug.required' => 'Please enter slug.', 
				'description.required' => 'Please enter description.'
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
				if($errors->first('description')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('description')));
                    die;
                }
            }else{
				$mobileExist = self::$Blogs->where('title', $request->title)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Blog already exist'));
                    die;
                }
				$mobileExist = self::$Blogs->where('slug', $request->slug)->where('id', '!=', $request->row_id)->where('status', '!=',3)->count();
                if($mobileExist > 0){
                    return json_encode(array('heading' => 'Error', 'msg' => 'Slug already exist'));
                    die;
                }
                $setData['category'] = $request->input('category');
				$setData['title'] = $request->input('title');
				$setData['slug'] = $request->input('slug');
				$setData['description'] = $request->input('description');
				$setData['added_by'] = $request->input('added_by');
				$setData['blog_date'] = $request->input('blog_date');
				$setData['image_alt'] = $request->input('image_alt');	
				$setData['author_id'] = $request->input('author_id');
				$setData['canonical_tags'] = $request->input('canonical_tags');				
				$setData['schema_tags'] = $request->input('schema_tags');
				$setData['seo_title'] = $request->input('seo_title');
				$setData['seo_description'] = $request->input('seo_description');
				$setData['seo_keyword'] = $request->input('seo_keyword');
				$setData['robot_tags'] = $request->input('robot_tags'); 
				#profile pic upload
                if(isset($request->image) && $request->image->extension() != ""){
                    $validator = Validator::make($request->all(), ['image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('image')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) .mt_rand(). '.' .$request->image->extension();
                        $destination = base_path().'/public/admin/images/blogs/';
                        $request->image->move($destination, $actual_image_name);
						$setData['image'] = $actual_image_name;
						if($request->input('old_image') != ""){
                            if(file_exists($destination . $request->old_image)){
                                unlink($destination . $request->old_image);
                            }
                        }
                    }
                }
                $record = self::$Blogs->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
			$categories = $this->getCategory();
            $record = self::$Blogs->where('id', $row_id)->first();
            return view('/panel/blogs/edit-page', ['record' => $record, 'categories' => $categories]);
        }else{
            return redirect('/panel/blogs');
        }
    }
	
	public function getCategory(){
		return self::$Categories->where('status',1)->pluck('title','id');
	}

}