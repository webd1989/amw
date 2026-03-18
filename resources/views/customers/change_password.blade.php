@extends('layout.default')
@if(isset($inner_page->id))
@section('title',strip_tags('Change Password'))
@section('description',strip_tags('Change Password'))
@section('keywords',strip_tags('Change Password'))
@section('robots',strip_tags('index,follow'))
@endif
@section('content')

@php
$siteUrl = env('APP_URL');
$page_url = request()->route()->getName();
$setting = getDetails('settings',1);
@endphp

<div class="hero-section">
  <div class="container">
    <div class="row hero-banner-content align-items-center">
    	<div class="col-lg-3"></div>
      <div class="col-lg-6 wow fadeInRight">
        <div class="inquery-form form-card">
          <h4 class="mb-4" id="page_heading"> Change Password </h4>
          <form class="form-fields" id="inquiry-form">
            <input type="password" placeholder="Enter Your Current Password" name="current_password" class="form-input">
            <input type="password" placeholder="Enter Your New Password" name="new_password" class="form-input">
            <input type="password" placeholder="Enter Your Confirm Password" name="confirm_password" class="form-input">
            <button type="button" class="btn btn-primary cta-button enquiry_btn" id="enquiry_btn">Change Password</button>
          </form>
        </div>
      </div>
      <div class="col-lg-3"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).on('click','#enquiry_btn',function(){
		sendEnquiry('inquiry-form');
	});
	function sendEnquiry(formid){
		let saveURL = "{{route('change-password')}}";
		$('.enquiry_btn').html('Processing...');
		$('.enquiry_btn').attr('disabled',true);
		formSubmitted = true;
		$.ajax({
		   type: 'POST',
		   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		   url: saveURL,
		   data: $('#'+formid).serialize(),
		   success: function(msg){
			  var obj = JSON.parse(msg);
			  formSubmitted = false;
			  if(obj['success'] == true){
				 swal("", obj['message'], "success").then((value) => {
					$('#'+formid)[0].reset();
				 });
			  }else{
				 swal("Error!", obj['message'], "error");        
			  }
			  $('.enquiry_btn').html('Change Password');
			  $('.enquiry_btn').attr('disabled',false);
		   },error: function(ts){
			  formSubmitted = false;
			  swal("Error!", 'Something went wrong, please try after sometime.', "error");
			  return false;
		   }
		});
        return false;
	}
</script> 
@endsection