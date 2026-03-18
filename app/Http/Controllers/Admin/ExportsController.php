<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Contacts;
use App\Models\Colleges;
use App\Models\Blogs;
use App\Models\CollegeImages;
use App\Models\CountryPages;
use App\Models\Countries;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;


class ExportsController extends Controller{

	private static $Contacts;
	private static $Colleges;	
	private static $Blogs;	
    private static $TokenHelper;
	private static $CollegeImages;
	private static $Countries;
	private static $CountryPages;
	
	public function __construct(){
		self::$Contacts = new Contacts();
		self::$Colleges = new Colleges();
		self::$Blogs = new Blogs();
        self::$TokenHelper = new TokenHelper();
		self::$CollegeImages = new CollegeImages();
		self::$Countries = new Countries();
		self::$CountryPages = new CountryPages();
	}

	#exportBrs
    public function exportEnquiry(Request $request){
		if(!$request->session()->has('admin_id')){ echo 'SessionExpired'; die; }

		$query = self::$Contacts->where('status', '!=', 3);
		if($request->input('search_name') && $request->input('search_name') != ""){
            $query->where('name', 'like', '%' . $request->input('search_name') . '%');
        }
		if($request->input('search_email') && $request->input('search_email') != ""){
            $query->where('email', 'like', '%' . $request->input('search_email') . '%');
        }
		if($request->input('search_contact') && $request->input('search_contact') != ""){
            $query->where('contact', 'like', '%' . $request->input('search_contact') . '%');
        }
        if($request->input('search_status') && $request->input('search_status') != ""){
            $query->where('read_status', $request->input('search_status'));
        }
		$records = $records = $query->orderBy('id', 'DESC')->get();
		
		$delimiter = ",";
		$filename = "enquiry_" . date('d_F_Y') . ".csv";
		
		$destination = "storage/csv/".$filename;
		
		//create a file pointer
		$f = fopen($destination,"w");
		
		//set column headers				
		$fields = array(
						'S.No',
						'Name',
						'Email',
						'Contact',
						'Subject',
						'Message',
						'Created',
					);
		 
		fputcsv($f, $fields, $delimiter);

		foreach($records as $key => $record):
		
			$lineData = array(
							$key+1,
							$record->name,
							$record->email,
							$record->contact,
							$record->subject,
							$record->message,
							$record->created_at
						);
			fputcsv($f, $lineData, $delimiter);

		endforeach;
		$lineData2 = array('','');						
		fputcsv($f, $lineData2, $delimiter);                     
		
		fclose ($f);

		echo env('APP_URL').$destination;
		exit;		
	}
	#downloadFile
    public function downloadFile(Request $request,$file_name){
		$file = $_SERVER['DOCUMENT_ROOT'].'/storage/csv/'.$file_name; 
		if (file_exists($file)) {
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename="' . basename($file) . '"');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		} else {
			echo "File not found."; die;
		}
		
	}
	#exportCollege
    public function exportCollege(Request $request){
		if(!$request->session()->has('admin_id')){ echo 'SessionExpired'; die; }

		$query = self::$Colleges->where('status',1);
		if($request->input('search_status') && $request->input('search_status') != ""){		
			$query->where('status', 'like', '%'.$request->input('search_status').'%');			
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
		$records = $records = $query->orderBy('id', 'DESC')->get();
		
		$delimiter = ",";
		$filename = "college_" . date('d_F_Y') . ".csv";
		
		$destination = "storage/csv/".$filename;
		
		//create a file pointer
		$f = fopen($destination,"w");
		
		//set column headers				
		$fields = array(
						'S.No',
						'ID',
						'Type',
						'Rating',
						'Name',
						'State',
						'City',
						'Ranking',
						'Description',
						'Course Name',
						'Lop Date',
						'Address',
						'Management',
						'Inspection Year',
						'Seats',
						'MCI Recongniotion',
						'Campus',
						'Mess',
						'Hospital',
						'Fees Structure',
						'Miscellaneous',
						'SEO Title',
						'SEO Description',
						'SEO Keywords',
						'Created',
					);
		 
		fputcsv($f, $fields, $delimiter);

		foreach($records as $key => $record):
		
			//$imageCount = self::$CollegeImages->where('status',1)->where('college_id',$record->id)->count();
			
			//if($imageCount == 0){
		
				$lineData = array(
								$key+1,
								$record->id,
								$record->type,
								$record->rating,
								$record->name,
								$record->state,
								$record->city,
								strip_tags($record->ranking),
								strip_tags($record->description),
								strip_tags($record->course_name),
								strip_tags($record->lop_date),
								strip_tags($record->address),
								strip_tags($record->management),
								strip_tags($record->inspection_year),
								strip_tags($record->seats),
								strip_tags($record->mci_recongniotion),
								strip_tags($record->campus),
								strip_tags($record->mess),
								strip_tags($record->hospital),
								strip_tags($record->fees_structure),
								strip_tags($record->miscellaneous),
								strip_tags($record->seo_title),
								strip_tags($record->seo_description),
								strip_tags($record->seo_keyword),
								$record->created_at
							);
				fputcsv($f, $lineData, $delimiter);
			
			//}

		endforeach;
		$lineData2 = array('','');						
		fputcsv($f, $lineData2, $delimiter);                     
		
		fclose ($f);

		echo $filename;
		exit;		
	}
	
	public function exportSitemap(){
		$baseUrl = 'https://amwcareerpoint.com';
 
        $staticUrls = [

            "$baseUrl/",

            "$baseUrl/tutorials",

            "$baseUrl/documentation",

            "$baseUrl/privacy-policy",

            "$baseUrl/support",

            "$baseUrl/faqs",

            "$baseUrl/packages",

            "$baseUrl/contact-us",

            "$baseUrl/blogs",
			
			"$baseUrl/colleges",
			
			"$baseUrl/predictors",
			
			"$baseUrl/about-us",

        ];
		
		
		
		$countryUrls = [];

		$countries = self::$Countries->where('status',1)->get();

	    foreach ($countries as $country) {

            $countryUrls[] = "$baseUrl/country-colleges/".$country->title;

        }

		$blogsUrls = [];

		$blogs = self::$Blogs->select('slug')->where('blogs.status', '!=', 3)->get();

	    foreach ($blogs as $blog) {

            $blogsUrls[] = "$baseUrl/blog/".$blog->slug;

        }
		
		$collegeUrls = [];

		$colleges = self::$Colleges->select('slug')->where('colleges.status', '!=', 3)->get();

	    foreach ($colleges as $college) {

            $collegeUrls[] = "$baseUrl/college/".$college->slug;

        }
		
		$collegeUrls2 = [];

		$colleges2 = self::$CountryPages->select('slug')->where('status', '!=', 3)->get();

	    foreach ($colleges2 as $college2) {

            $collegeUrls2[] = "$baseUrl/".$college2->slug;

        }

		$allUrls = array_merge($staticUrls,$collegeUrls,$blogsUrls,$countryUrls,$collegeUrls2);

		// Build XML content

        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>';

        $xmlContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
 
        foreach ($allUrls as $url) {

            $xmlContent .= '<url>';

            $xmlContent .= "<loc>$url</loc>";

            $xmlContent .= "<lastmod>" . date('Y-m-d') . "</lastmod>";

            $xmlContent .= "<changefreq>daily</changefreq>";

            $xmlContent .= "<priority>0.8</priority>";

            $xmlContent .= '</url>';

        }

		$xmlContent .= '</urlset>';
 
        $filePath = public_path('sitemap.xml');
		
		//$destination = "storage/csv/sitemap.xml";
		$destination = "sitemap.xml";
				
        File::put($destination, $xmlContent);
		
		echo env('APP_URL').$destination;
		exit;		
	}

}