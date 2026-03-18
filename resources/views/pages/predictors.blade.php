@extends('layout.default')
@if(isset($inner_page->id))
@section('title',strip_tags($inner_page->seo_title))
@section('description',strip_tags($inner_page->seo_description))
@section('keywords',strip_tags($inner_page->seo_keyword))
@section('robots',strip_tags($inner_page->robot_tags))
@endif
@section('content')

@php
$siteUrl = env('APP_URL');
$page_url = request()->route()->getName();
@endphp
@if(session()->has('login_user_email'))
    @php $user_details = getDetails('users',session()->get('login_user_id')); @endphp
@endif

<div class="hero-section">  
   <div class="container">
     <div class="row hero-banner-content align-items-center">
        <div class="col-lg-6 wow fadeInLeft">
        	@if(isset($inner_page->id))
         	<div class="left-content">
            	<div class="badge">{!! $inner_page->title !!}</div>
            	<h1 class="mb-4 mt-4">{!! $inner_page->heading !!}<span class="orange-text">{!! $inner_page->sub_heading !!}</span></h1>
            	<p class="mb-5">{!! $inner_page->description !!}</p>
            </div>
            @endif
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-5 wow fadeInRight">
            <div class="inquery-form form-card">
                <div class="step-form">
                    <h3 class="title-box mb-3">NEET PG College Predictor 2026</h3>
                    <form id="pageForm">                    
                    <!-- Step 1 to Step 7 -->
                    <div class="step active">
                        <?php /*?><span class="step-text">Step 1/6</span><?php */?>
                        <div class="step-title d-flex align-items-center justify-content-between pb-2">
                            <h3>Course & Specialization</h3>
                        </div>
                        <div class="predictor-from">                          
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <select id="predictor_type" name="predictor_type" class="form-input select-from">
                                        <!--<option value="">Select Predictor Type</option>-->
                                        @if(isset($predictors_types) && $predictors_types->count()>0)
                                        	@foreach($predictors_types as $key => $ptype)
                                                <option value="{{$ptype->id}}">{{$ptype->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="step">
                        <?php /*?><span class="step-text">Step 2/6</span><?php */?>
                        <div class="step-title d-flex align-items-center justify-content-between pb-2">
                            <h3>NEET Rank and Counselling Type</h3>
                        </div>
                        <div class="predictor-from">                          
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <input type="text" id="neet_rank" name="neet_rank" placeholder="Enter Your NEET Rank" class="form-input">
                                </div>

                                <div class="col-md-12 pb-2">
                                    <select class="form-input select-from" id="counselling_type" onchange="getAllCategory(this.value)" name="counselling_type" aria-label="Default select example">
                                        <option value="">Select Counselling Type</option>
                                        @if(isset($counceling_types) && $counceling_types->count()>0)
                                        	@foreach($counceling_types as $key => $ctype)
                                                <option value="{{$ctype->id}}">{{$ctype->title}}</option>
                                            @endforeach
                                        @endif                                   
                                    </select>
                                </div>
                            </div>    

                        </div>
                    </div>
                    
                    
                    
                    <div class="step" id="state_div">
                        <?php /*?><span class="step-text">Step 4/6</span><?php */?>
                        <div class="step-title d-flex align-items-center justify-content-between pb-2">
                            <h3>State and local Area</h3>
                        </div>
                        <div class="predictor-from">                          
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <select class="form-input select-from" id="state_id" name="state_id" onchange="getCategory(this.value)" aria-label="Default select example">
                                        <option value="0">Select State</option>
                                        @if(isset($states) && $states->count()>0)
                                        	@foreach($states as $key => $state)
                                                <option value="{{$state->id}}">{{$state->state}}</option>
                                            @endforeach
                                        @endif                                  
                                    </select>
                                </div>
                                
                                <div class="col-md-12 pb-4">
                                    <select class="form-input select-from" id="local_area_id" name="local_area_id" aria-label="Default select example">
                                        <option value="0">Select Local Area</option>
                                        <option value="">Not Applicable</option>
                                        @if(isset($local_area) && $local_area->count()>0)
                                        	@foreach($local_area as $key => $larea)
                                                <option value="{{$larea->id}}">{{$larea->title}}</option>
                                            @endforeach
                                        @endif                                  
                                    </select>                                   
                                    
                                </div>
                                
                            </div>    
                        </div>
                    </div>
                    
                    <div class="step">
                        <?php /*?><span class="step-text">Step 3/6</span><?php */?>
                        <div class="step-title d-flex align-items-center justify-content-between pb-2">
                            <h3>Seat Type and Category</h3>
                        </div>
                        <div class="predictor-from">                          
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <select class="form-input select-from" id="seat_category" name="seat_category" aria-label="Default select example">
                                        <option value="">Select Category</option>
                                        <option value="">Not Applicable</option>
                                        @if(isset($seat_categories) && $seat_categories->count()>0)
                                        	@foreach($seat_categories as $key => $scategory)
                                                <option value="{{$scategory->id}}">{{$scategory->title}}</option>
                                            @endforeach
                                        @endif                                  
                                    </select>
                                </div>
                                
                                <div class="col-md-12 pb-4">
                                    <select class="form-input select-from" id="sub_category_id" name="sub_category_id" aria-label="Default select example">
                                        <option value="">Select Sub Category</option>
                                        <option value="">Not Applicable</option>
                                        @if(isset($college_sub_categories) && $college_sub_categories->count()>0)
                                        	@foreach($college_sub_categories as $key => $sbcategory)
                                                <option value="{{$sbcategory->id}}">{{$sbcategory->title}}</option>
                                            @endforeach
                                        @endif                                  
                                    </select>                                   
                                    
                                </div>
                                
                            </div>    
                        </div>
                    </div>
                    
                    <?php /*?><div class="step">
                        <span class="step-text">Step 4/5</span>
                        <div class="step-title d-flex align-items-center justify-content-between pb-2">
                            <h3>Sate & Local Area</h3>
                        </div>
                        <div class="predictor-from">                          
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <select class="form-input select-from" id="seat_category" name="seat_category" aria-label="Default select example">
                                        <option value="">Select Category</option>
                                        @if(isset($seat_categories) && $seat_categories->count()>0)
                                        	@foreach($seat_categories as $key => $scategory)
                                                <option value="{{$scategory->id}}">{{$scategory->title}}</option>
                                            @endforeach
                                        @endif                                  
                                    </select>
                                    <select class="form-input select-from" id="seat_category" name="seat_category" aria-label="Default select example">
                                        <option value="">Select Sub Category</option>
                                        @if(isset($college_sub_categories) && $college_sub_categories->count()>0)
                                        	@foreach($college_sub_categories as $key => $sbcategory)
                                                <option value="{{$scategory->id}}">{{$sbcategory->title}}</option>
                                            @endforeach
                                        @endif                                  
                                    </select>                                   
                                    
                                </div>
                                
                            </div>    
                        </div>
                    </div><?php */?>
                    
                    <div class="step">
                        <?php /*?><span class="step-text">Step 5/6</span><?php */?>
                        <div class="step-title d-flex align-items-center justify-content-between pb-2">
                            <h3>What Is Your Name?</h3>
                        </div>
                        @php
                        	$fname = $lname = '';
                        	if(isset($user_details->id)){
                            	$full_name = $user_details->name;                                
                                if($full_name != ''){
                               		$exp = explode(' ',$full_name);
                                    if(isset($exp[0])){ $fname = $exp[0]; }
                                    if(isset($exp[1])){ $lname = $exp[1]; }
                               	}
                           	}
                        @endphp
                        <div class="predictor-from">                          
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <input type="text" id="first_name" name="first_name" value="{{$fname}}" placeholder="Enter First Name" class="form-input">
                                </div>
                                <div class="col-md-12 pb-2">
                                    <input type="text" placeholder="Enter Last Name" id="last_name" value="{{ $lname }}" name="last_name" class="form-input">
                                </div>
                            </div>    
                        </div>
                        
                    </div>
                    
                    <div class="step">
                        <?php /*?><span class="step-text">Step 6/6</span><?php */?>
                        <div class="step-title d-flex align-items-center justify-content-between pb-2">
                            <h3>Enter Your Contact Details</h3>
                        </div>
                        <div class="predictor-from">                          
                            <div class="row">
                                <div class="col-md-12 pb-4">
                                    <input type="tel" id="mobile" name="mobile" value="{{isset($user_details->id)?$user_details->mobile:''}}" placeholder="Enter Mobile Number" maxlength="10" class="form-input numberonly">
                                </div>

                                <div class="col-md-12 pb-2">
                                    <input type="email" id="email" name="email" value="{{isset($user_details->id)?$user_details->email:''}}" placeholder="Enter Email Address" class="form-input">
                                </div>
                                <div class="col-md-12 pb-2">
                                	<select class="form-input select-from" id="gender" name="gender" aria-label="Default select example">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select> 
                                </div>                                
                            </div>    
                        </div>
                    </div>                    

                    <div class="buttons-set">
                    	<button id="prevBtn" type="button" class="btn btn-primary cta-button" disabled>Previous</button>
                    	@if(session()->has('login_user_email'))
                            <button id="nextBtn" type="button" class="btn btn-primary cta-button">Next</button>
                        @else
                            <a href="javascript:void(0)" class="btn btn-primary cta-button" data-bs-toggle="modal" data-bs-target="#exampleModal">Next</a>
                        @endif
                    </div>

                    <div class="progress-step mt-4">
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
     </div>

   </div>

   
</div>

<div class="container" id="search_predictor_college"></div>

<!--Learn Skills section start here-->
@include('element.section1')

<!--Learn Skills section end here-->


<!--Price section start here-->

@include('element.section2')

<!--FAQ section start here-->
@include('element.faq')
<!--FAQ section end here-->


<!--blog section start here-->
@include('element.blogs')
<!--blog section end here-->


<!--Get in Touch form bottm start here-->

@include('element.contact_us2')
<!--Get in Touch form bottom end here-->


<script type="text/javascript">
	var addUrl = "{{url('/save-predictor/')}}";
	var returnUrl = "{{url('/predictor-colleges')}}";
	var category_url = "{{url('/get-state-category')}}";
	var sub_category_url = "{{url('/get-state-sub-category')}}";
	//var returnUrl = "{{url('/packages')}}";
	$(document).ready(function(){
		$('.numberonly').keypress(function(e){
			var charCode = (e.which) ? e.which : event.keyCode
			if(String.fromCharCode(charCode).match(/[^0-9+]/g))
			return false;
		});
	});
	
	function getSubCategory(state){
		$.ajax({
		   type: 'POST',
		   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		   url: sub_category_url,
		   data: {state:state},
		   success: function(msg){
			   $('#sub_category_id').html(msg);
		   },error: function(ts){
			  formSubmitted = false;
			  swal("Error!", 'Something went wrong, please try after sometime.', "error");
			  return false;
		   }
		});
	}
	
	function getAllCategory(type){
		if(type == 1){
			$.ajax({
			   type: 'POST',
			   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			   url: category_url,
			   data: {state:0},
			   success: function(msg){
				   $('#seat_category').html(msg);
				   getSubCategory(0);
			   },error: function(ts){
				  formSubmitted = false;
				  swal("Error!", 'Something went wrong, please try after sometime.', "error");
				  return false;
			   }
			});
		}
	}
	
	function getCategory(state){
		$.ajax({
		   type: 'POST',
		   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		   url: category_url,
		   data: {state:state},
		   success: function(msg){
			   $('#seat_category').html(msg);
			   getSubCategory(state);
		   },error: function(ts){
			  formSubmitted = false;
			  swal("Error!", 'Something went wrong, please try after sometime.', "error");
			  return false;
		   }
		});
	}
</script>

@endsection