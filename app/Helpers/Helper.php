<?php
function getDetails($table,$id,$field = NULL){
	$query = DB::table($table);
	if($table != 'settings'){
		$query->where('status',1);
	}
	$query->where('id',$id);
	$data = $query->first();	
	if(isset($data->id)){
		if($field != ''){
			return $data->$field;			
		}else{
			return $data;		
		}		
	}else{		
		return '';		
	}
}
function getCountriesOfCollege(){
	$countryGroups = DB::table('colleges')->where('status', 1)->groupBy('country')->pluck('country');	
	$countriesNames = []; $counter = 0;
	foreach($countryGroups as $key => $countryGroup){
		if($countryGroup != "" && $countryGroup > 0){
			$cData = DB::table('countries')->where('id', $countryGroup)->first();
			if(isset($cData->title)){
				$countriesNames[$counter]['id'] = $cData->id;
				$countriesNames[$counter]['title'] = $cData->title;
				$countriesNames[$counter]['slug'] = $cData->slug;
				$counter++;
			}
		}
	}
	
	return $countriesNames;
}
function getCollegePages(){
	$pages = DB::table('country_pages')->select('title','slug','image','alt_image')->where('status',1)->get();	
	return $pages;	
}
function getVideos(){
	$pages = DB::table('videos')->where('status',1)->orderBy('id','DESC')->get()->take(4);	
	return $pages;	
}
function getAllRecords($table,$limit = NULL){
	$query = DB::table($table);
	$query->where('status',1);
	if($table == 'faqs'){
		$data = $query->limit(10)->get();	
	}else{
		if($limit > 0){
			$query->limit($limit);	
		}
		$data = $query->latest()->get();		
	}
	return $data;	
}

function getTotal($table,$status = NULL){
	$query = DB::table($table);
	if($status == NULL){
		$query->where('status','!=',3);
	}else{
		if($table == 'contacts'){
			$query->where('read_status',$status);
		}else{
			$query->where('status',$status);
		}
	}
	return $query->count();
}

function getCustomQuery($query){
	return DB::select($query);
}

function getPermission($admin_id = NULL, $section_id = NULL){
	$query = DB::table('users');
	$query->where('id',$admin_id);
	$data = $query->first();	
	$exist  = false;
	if(isset($data->id) && $data->permision != ''){
		if($section_id > 0){
			$exp_permission = explode(',',$data->permision);	
			if(in_array($section_id,$exp_permission)){
				$exist = true;
			}
		}
	}
	return $exist;
}

?>