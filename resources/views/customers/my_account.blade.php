@extends('layout.default')
@if(isset($inner_page->id))
@section('title',strip_tags('My Account'))
@section('description',strip_tags('My Account'))
@section('keywords',strip_tags('My Account'))
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
    	<div class="col-lg-2"></div>
      <div class="col-lg-8 wow fadeInRight">
        <div class="inquery-form form-card">
          <h4 class="mb-4" id="page_heading"> My Account</h4>
          <form class="form-fields" id="inquiry-form">
          	<div class="row">
          	<div class="col-lg-6 mb-3">
            <input type="text" placeholder="Enter Your Name" value="{{$userData->name}}" name="o_name" class="form-input">
            </div>
            <div class="col-lg-6 mb-3">
            <input type="text" placeholder="Enter Your Email" value="{{$userData->email}}" readonly="true" class="form-input">
            </div>
            <div class="col-lg-6 mb-3">
            <input type="text" placeholder="Enter Your Mobile" value="{{$userData->mobile}}" readonly="true" class="form-input">
            </div>
            <div class="col-lg-6 mb-3">
            <input type="text" placeholder="Enter Your State" value="{{$userData->state}}" name="o_state" class="form-input">
            </div>
            <div class="col-lg-6 mb-3">
            <input type="text" placeholder="Enter Your City" value="{{$userData->city}}"name="o_city" class="form-input">
            </div>
            <div class="col-lg-6 mb-3">
            <input type="text" placeholder="Enter Your Pincode" value="{{$userData->zipcode}}"name="o_pincode" class="form-input">
            </div>
            <div class="col-lg-12 mb-3">
            <input type="text" placeholder="Enter Your Address" value="{{$userData->address}}" name="o_address" class="form-input">
            </div>
            </div>
            <button type="button" class="btn btn-primary cta-button enquiry_btn" id="enquiry_btn">Submit</button>
          </form>
        </div>
      </div>
      <div class="col-lg-2"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).on('click','#enquiry_btn',function(){
		sendEnquiry('inquiry-form');
	});
	function sendEnquiry(formid){
		let saveURL = "{{route('my-account')}}";
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
					window.location.href = '';
				 });
			  }else{
				 swal("Error!", obj['message'], "error");        
			  }
			  $('.enquiry_btn').html('Submit');
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