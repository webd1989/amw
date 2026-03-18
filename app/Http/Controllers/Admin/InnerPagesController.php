<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\InnerPages;
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

class InnerPagesController extends Controller {
    private static $InnerPages;
    public function __construct(){
        self::$InnerPages = new InnerPages();
    }

   #admin dashboard page
    public function getList(Request $request){
        if (!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        return view('/panel/inner_pages/index');
    }

    public function listPaginate(Request $request){
        if (!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		$page = $request->page;
        $query = self::$InnerPages->where('status', '!=', 3);
        if ($request->input('search_page') && $request->input('search_page') != ""){
           $search_page = $request->input('search_page');
            $query->where('page', 'like', '%' . $search_page . '%');
        }
		if($request->input('search_status') && $request->input('search_status') != ""){
            $query->where('status', $request->input('search_status'));
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/inner_pages/paginate', compact('records','page'));
    }

    #edit Service Type
    public function editPage(Request $request, $row_id){
        $RowID = base64_decode($row_id);
        if (!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
		$record = self::$InnerPages->where(array('id' => $RowID))->first();
        if ($request->input()){
            $validator = Validator::make($request->all(), ['title' => 'required'], ['title.required' => 'Please enter title.']);
            if ($validator->fails()){
                $errors = $validator->errors();
                if ($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
            }else{
                #profile pic upload
                if (isset($request->banner) && $request->banner->extension() != ""){
                    $validator = Validator::make($request->all(), ['banner' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
                    if ($validator->fails()){
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('banner')));
                        die;
                    }else{
                        $actual_image_name = str_shuffle(mt_rand() . time()) . '.' . $request->banner->extension();
                        $destination = base_path() . '/public/admin/images/banners/';
                        $request->banner->move($destination, $actual_image_name);
                        if ($request->input('old_banner') != ""){
                            if (file_exists($destination . $request->old_banner)){
                                unlink($destination . $request->old_banner);
                            }
                        }
						$setData['image'] = $actual_image_name;
                    }
                }
                $setData['id'] = $request->row_id;
                $setData['title'] = $request->input('title');
                $setData['heading'] = $request->input('heading');
                $setData['sub_heading'] = $request->input('sub_heading');
                $setData['description'] = $request->input('description');
				$setData['canonical_tags'] = $request->input('canonical_tags');				
				$setData['schema_tags'] = $request->input('schema_tags');  
                $setData['seo_title'] = $request->input('seo_title');
                $setData['seo_description'] = $request->input('seo_description');
                $setData['seo_keyword'] = $request->input('seo_keyword');
                $setData['robot_tags'] = $request->input('robot_tags');
                self::$InnerPages->UpdateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Inner page details updated successfully'));
                die;
            }
        }        
        if (isset($record->id)){
            return view('/panel/inner_pages/edit-page', compact('record', 'row_id'));
        }else{
            return redirect('/panel/inner_pages');
        }
    }

}