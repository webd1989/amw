<option value="">Select Sub Category</option>
<option value="">Not Applicable</option>
@php
	if(isset($coll_sub_categories) && !empty($coll_sub_categories)){
    	foreach($coll_sub_categories as $key => $cat){
@endphp
        	<option value="{{$key}}">{{$cat}}</option>
@php	}	}	die;	@endphp