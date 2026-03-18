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
          <h4 class="mb-4" id="page_heading"> Reset Password </h4>
          <form class="form-fields" id="reset-password-form">
          	<input type="hidden" name="email" value="{{$email}}"/>
            <input type="hidden" name="security_key" id="security_key" value="{{$securityKey}}"/>
            
            <input type="password" class="form-input" id="new_password" name="new_password" placeholder="New Password">
            <input type="password" class="form-input" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
            <button type="button" class="btn btn-primary cta-button" id="checkout_btn" onclick="resetPassword()">Submit</button>
          </form>
        </div>
      </div>
      <div class="col-lg-3"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function resetPassword(){
		let saveURL = "{{route('resetPasswordChange')}}";
		var flag = 0;
		if($.trim($("#new_password").val()) == ''){
			flag = 1;
			swal("Error!", 'Please Enter New Password', "error");
			return false;
		}
		if($.trim($("#confirm_password").val()) == ''){
			flag = 1;
			swal("Error!", 'Please Enter Confirm Password', "error");
			return false;
		}
		if($.trim($("#confirm_password").val()) != $.trim($("#new_password").val())){
			flag = 1;
			swal("Error!", 'Password And Confirm Password Must Be Same', "error");
			return false;
		}
		if(flag == 0){
			$('#checkout_btn').html('Processing...');
			var url = "{{route('pages.index')}}";
			$.ajax({
				type: 'POST',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: saveURL,
				data:$('#reset-password-form').serialize(),
				dataType: "json",
				success: function(msg){
					$('#checkout_btn').html('Submit');	
					if (msg.status == 'success'){
						swal("", "Password has been changed successfully", "success").then((value) => {
							window.location.href = url;
						});
					}
				},error: function(ts){
					swal("Error!", 'Something went wrong, please try after sometime.', "error");
					return false;
				}
			});	
		}
	}
</script> 
@endsection