<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Locations;
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

class LocationsController extends Controller {
    private static $Locations;
    private static $TokenHelper;

    public function __construct(){
        self::$Locations = new Locations();
        self::$TokenHelper = new TokenHelper();
    }

    #admin dashboard page
    public function getList(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
       return view('/panel/locations/index');
    }

    public function listPaginate(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        $query = self::$Locations->where('status', '!=', 3);	
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
		}
        if($request->input('search_keywords') && $request->input('search_keywords') != ""){	
			$SearchKeyword = $request->input('search_keywords');
           	$query->where(function($query) use ($SearchKeyword){
               if(!empty($SearchKeyword)){
                   $query->where('locations.title', 'like', '%'.$SearchKeyword.'%')
                   ->orWhere('locations.title', 'like', '%'.$SearchKeyword.'%');
               }
            });
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/panel/locations/paginate', compact('records'));
    }

    public function addPage(Request $request){
        if(!$request->session()->has('admin_email')){
            return redirect('/panel/');
        }
        if($request->input()){
            $validator = Validator::make($request->all(), [
				'title' => 'required', 
			 ], [
			 	'title.required' => 'Please enter title.',
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
            }else{
                $setData['title'] = $request->input('title');

               	$record = self::$Locations->CreateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record added successfully', 'row_id' => base64_encode($record->id)));
                die;
            }
        }
		return view('/panel/locations/add-page');
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
			 ], [
			 	'title.required' => 'Please enter title.',
			]);
            if($validator->fails()){
                $errors = $validator->errors();
                if($errors->first('title')){
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
            }else{
                $setData['title'] = $request->input('title');
                $record = self::$Locations->where('id', $request->row_id)->update($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Record updated successfully'));
                die;
            }
        }
        if($row_id > 0){
            $record = self::$Locations->where('id', $row_id)->first();
            return view('/panel/locations/edit-page', ['record' => $record]);
        }else{
            return redirect('/panel/Locations');
        }
    }

}