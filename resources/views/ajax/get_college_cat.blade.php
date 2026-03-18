<option value="">Select Category</option>
@php
	if(isset($coll_categories) && !empty($coll_categories)){
    	foreach($coll_categories as $key => $cat){
@endphp
        	<option value="{{$key}}">{{$cat}}</option>
@php	}	}	die;	@endphp