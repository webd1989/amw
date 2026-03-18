<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\InnerPages;
use App\Models\Blogs;
use App\Models\Locations;
use App\Models\Plans;
use App\Models\Categories;
use App\Models\Colleges;
use App\Models\CollegeImages;
use App\Models\Countries;
use App\Models\Faqs;
use App\Models\CouncelingTypes;
use App\Models\PredictorTypes;
use App\Models\SeatCategories;
use App\Models\CollegeCategories;
use App\Models\CollegeSubCategories;
use App\Models\SeatTypes;
use App\Models\States;
use App\Models\LocalAreas;
use App\Models\Testimonials;
use App\Models\CountryPages;
use App\Models\TokenHelper;
use App\Models\Responses;
use App\RouteHelper;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Hash;
use Illuminate\Validation\Rule;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class PagesController extends Controller{

    private static $InnerPages;
	private static $Blogs;
	private static $Colleges;
	private static $CollegeImages;
	private static $Categories;
	private static $Faqs;
	private static $Plans;
	private static $Locations;
	private static $CouncelingTypes;
	private static $PredictorTypes;
	private static $SeatCategories;
	private static $SeatTypes;
	private static $Testimonials;
    private static $TokenHelper;
	private static $Countries;
	private static $CountryPages;
	private static $States;
	private static $CollegeCategories;
	private static $CollegeSubCategories;
	private static $LocalAreas;
		
    public function __construct(){
        self::$InnerPages = new InnerPages();
		self::$Blogs = new Blogs();
		self::$Colleges = new Colleges();
		self::$Locations = new Locations();
		self::$Faqs = new Faqs();
		self::$Categories = new Categories();
		self::$Plans = new Plans();
		self::$CollegeImages = new CollegeImages();
		self::$Testimonials = new Testimonials();
		self::$CouncelingTypes = new CouncelingTypes();
		self::$PredictorTypes = new PredictorTypes();
		self::$SeatCategories = new SeatCategories();
		self::$SeatTypes = new SeatTypes();
        self::$TokenHelper = new TokenHelper();
		self::$Countries = new Countries();
		self::$CountryPages = new CountryPages();
		self::$CollegeCategories = new CollegeCategories();
		self::$CollegeSubCategories = new CollegeSubCategories();
		self::$States = new States();
		self::$LocalAreas = new LocalAreas();
    }
    	
	public function index(Request $request, $slug = NULL){
		if($slug != NULL){
			$cData = self::$CountryPages->where('slug',$slug)->where('status',1)->first();
			if(isset($cData->id)){
				$countryId = $cData->country_id;
				$cid = $countryId;
				return view('pages.all_country_colleges', compact('cData','countryId','cid'));	
			}else{				
				return redirect('/');
			}
		}else{
			$innerPages = self::$InnerPages->where('status', 1)->whereIn('id',[1,2,3,4,5,6])->get();
			$inner_page = $section2 = $section3 = $section4 = $section5 = $section6 = array();
			if(isset($innerPages) && $innerPages->count()>0){
				$x = 0;
				foreach($innerPages as $key => $inner_pag){
					if($inner_pag->id == 1){ $inner_page = $inner_pag; }
					if($inner_pag->id == 2){ $section2 = $inner_pag; }
					if($inner_pag->id == 3){ $section3 = $inner_pag; }
					if($inner_pag->id == 4){ $section4 = $inner_pag; }
					if($inner_pag->id == 5){ $section5 = $inner_pag; }
					if($inner_pag->id == 6){ $section6 = $inner_pag; }
					$x++;
				}
			}
			$blogs = self::$Blogs->where('status',1)->latest()->limit(4)->get();
			$testimonials = self::$Testimonials->where('status',1)->latest()->get();
			$faqs = self::$Faqs->where('status',1)->limit(10)->get();
			$gcolleges = self::$Colleges->where('status',1)->where('type','Government')->latest()->limit(6)->get();
			$pcolleges = self::$Colleges->where('status',1)->where('type','Private')->latest()->limit(6)->get();
			$acolleges = self::$Colleges->where('status',1)->where('type','Abroad')->latest()->limit(6)->get();
			return view('pages.index', compact('inner_page','section2','section3','section4','section5','section6','blogs','testimonials','faqs','gcolleges','pcolleges','acolleges'));		
		}		
	}
	
	public function aboutUs(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',14)->first();
		return view('pages.inner_page', compact('inner_page'));			
	}
	
	public function blogs(Request $request,$slug = NULL){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',11)->first();
		if($request->slug && $request->slug != ''){
			$category = self::$Categories->where('slug',$slug)->where('status',1)->first();
			if(!$category){
				return redirect('/blogs');
			}
		}
		return view('pages.blogs', compact('inner_page','slug'));
	}
	
	public function blogPaginate(Request $request){
		$query = self::$Blogs->where('status', 1);
		$slug = $request->slug;
		if($request->slug && $request->slug != ''){
			$category = self::$Categories->where('slug',$slug)->where('status',1)->first();
			if(isset($category->id)){
				$query->where('category', $category->id);
			}
		}        
        $blogs = $query->orderBy('id', 'DESC')->paginate(30);
        return view('pages.blog_paginate', compact('blogs','slug'));
    }
	
	public function blogDetails(Request $request,$slug = NULL){
		if($slug != ''){
			$blog = self::$Blogs->where('status',1)->where('slug',$slug)->first();
			if(isset($blog->id)){
				$views = $blog->user_views += 1;
				self::$Blogs->where('id',$blog->id)->update(['user_views' => $views]);
				$blogs = self::$Blogs->where('status',1)->where('id','!=',$blog->id)->orderBy('id','DESC')->limit(4)->get();
				return view('pages.blog_details', compact('blog','blogs'));
			}else{
				return redirect('/blogs');
			}
		}else{
			return redirect('/blogs');	
		}			
	}
	public function country(Request $request,$country){
		if($country != ""){
			$cData = self::$Countries->where('slug',$country)->where('status',1)->first();
			if(isset($cData->id)){
				$countryId = $cData->id;
				return view('pages.all_country_colleges', compact('cData','countryId'));	
			}else{
				return redirect('/');
			}
		}else{
			return redirect('/');
		}				
	}
	public function countryPaginate(Request $request){
		$gquery = self::$Colleges->where('status', 1)->where('country', $request->cid);
		$cname  = $request->input('cname');
		$cid  = $request->input('cid');
		if($cname != ''){
			$gquery->where('name','like','%'.$cname.'%');
		}
        $gcolleges = $gquery->orderBy('id', 'DESC')->paginate(30);
        return view('pages.all_country_college_paginate', compact('gcolleges','cname','cid'));
    }
	public function countryColleges(Request $request,$country){
		if($country != ""){
			$cData = self::$Countries->where('title',$country)->where('status',1)->first();
			if(isset($cData->id)){
				$countryId =$cData->id;
				$inner_page = self::$InnerPages->where('status', 1)->where('id',13)->first();
				return view('pages.country_colleges', compact('inner_page','countryId','cData'));	
			}else{
				return redirect('/');
			}
		}else{
			return redirect('/');
		}				
	}
	public function countryCollegePaginate(Request $request){
		$gquery = self::$Colleges->where('status', 1)->where('country', $request->cid);
		$cname  = $request->input('cname');
		if($cname != ''){
			$gquery->where('name','like','%'.$cname.'%');
		}
        $gcolleges = $gquery->orderBy('id', 'DESC')->paginate(30);
		$countryId = $request->cid;
        return view('pages.country_college_paginate', compact('gcolleges','cname','countryId'));
    }
	public function colleges(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',13)->first();
		return view('pages.colleges', compact('inner_page'));			
	}
	
	public function collegePaginate(Request $request){
		$allquery = self::$Colleges->where('status', 1);
		$gquery = self::$Colleges->where('status', 1)->where('type','Government');
		$pquery = self::$Colleges->where('status', 1)->where('type','Private');
		$aquery = self::$Colleges->where('status', 1)->where('type','Abroad');		
		
		$type  = $request->input('type');
		if(!$request->input('type')){
			$type = 'All';	
		}		
		$cname  = $request->input('cname');				
		if($cname != ''){
			$allquery->where('name','like','%'.$cname.'%');
			$gquery->where('name','like','%'.$cname.'%');
			$pquery->where('name','like','%'.$cname.'%');
			$aquery->where('name','like','%'.$cname.'%');
		}
        $allcolleges = $allquery->orderBy('id', 'DESC')->paginate(30);	
		$gcolleges = $gquery->orderBy('id', 'DESC')->paginate(30);		
        $pcolleges = $pquery->orderBy('id', 'DESC')->paginate(30);	
		$acolleges = $aquery->orderBy('id', 'DESC')->paginate(30);
        return view('pages.college_paginate', compact('allcolleges','gcolleges','acolleges','pcolleges','type','cname'));
    }
	
	public function collegeDetails(Request $request,$slug = NULL){
		if($slug != ''){
			$college = self::$Colleges->where('status',1)->where('slug',$slug)->first();
			if(isset($college->id)){
				$college_images = self::$CollegeImages->where('status',1)->where('college_id',$college->id)->latest()->get();				
				return view('pages.college_details', compact('college','college_images'));
			}else{
				return redirect('/colleges');
			}
		}else{
			return redirect('/colleges');	
		}			
	}	
	
	public function contactUs(Request $request){		
		$locations = self::$Locations->where('status', 1)->get();
		$inner_page = self::$InnerPages->where('status', 1)->where('id',8)->first();
		return view('pages.contact_us', compact('inner_page','locations'));			
	}
	
	public function sitemap(Request $request){
		//return response()->view('pages.sitemap')->header('Content-type', 'text/xml');
		$inner_page = self::$InnerPages->where('status', 1)->where('id',8)->first();
		return view('pages.sitemap', compact('inner_page'));	
	}
	
	public function faqs(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',12)->first();
		$faqs = self::$Faqs->where('status',1)->get();
		return view('pages.faqs', compact('inner_page','faqs'));			
	}
	public function videos(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',18)->first();
		$videos = DB::table('videos')->where('status',1)->orderBy('id','DESC')->get();	
		return view('pages.videos', compact('inner_page','videos'));			
	}	
	
	public function packages(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',17)->first();
		$plans = self::$Plans->where('status',1)->get();
		return view('pages.packages', compact('inner_page','plans'));
	}

	public function predictors(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',9)->first();
		$counceling_types = self::$CouncelingTypes->where('status',1)->get();
		$predictors_types = self::$PredictorTypes->where('status',1)->get();
		$seat_categories = self::$CollegeCategories->where('status',1)->get();
		$seat_types = self::$SeatTypes->where('status',1)->get();
		$states = self::$States->where('status',1)->where('country_id',101)->orderBy('state')->get();
		$college_sub_categories = self::$CollegeSubCategories->where('status',1)->get();
		$local_area = self::$LocalAreas->where('status',1)->get();
		return view('pages.predictors', compact('inner_page','counceling_types','predictors_types','seat_categories','seat_types','states','local_area','college_sub_categories'));			
	}
	
	public function predictorColleges(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',9)->first();
		$pcids = '';
		$pcids = array();
		$query = DB::table('colleges');
		if($request->session()->has('precoll') && $request->session()->get('precoll') != ''){
			$pcids = explode(',', $request->session()->get('precoll'));			
			$counselling_type = $request->session()->get('counselling_type');
			$state_id = $request->session()->get('state_id');
			if($counselling_type == 2 && $state_id > 0){
				$query->where('state', $state_id);
			}			
		}
		$query->whereIn('id', $pcids);	
		$spcolleges = $query->get();
		return view('pages.predictor_college', compact('inner_page','spcolleges'));			
	}

	public function privacyPolicy(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',7)->first();
		return view('pages.inner_page', compact('inner_page'));			
	}
	
	public function support(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',10)->first();
		return view('pages.inner_page', compact('inner_page'));			
	}
	
	public function tutorials(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',15)->first();
		return view('pages.inner_page', compact('inner_page'));			
	}
	
	public function documentation(Request $request){
		$inner_page = self::$InnerPages->where('status', 1)->where('id',16)->first();
		return view('pages.inner_page', compact('inner_page'));			
	}

}