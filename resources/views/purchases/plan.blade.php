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
@endphp

<style>
	.contact-us-section {
		background: url({{ asset('public/img/enquery_bg.png') }}) no-repeat 0 0;
	}
</style>
<div class="contact-us-section py-100 wow fadeInUp">
  <div class="container">
    <div class="row">
      <div class="col-md-7"></div>
      <div class="col-md-5">
        <div class="inquery-form form-card">
          <h4 class="mb-3"> {{$package->title}} </h4>
          <div class="college-card h-100">
            <div class="badge mt-3 mb-2">{{$package->title}}</div>
            <h4 style="color:#080000"> 
            @if($package->id == 1)
              	Free
              @else
              	₹ {{$package->price}}
              @endif 
            </h4>
            @if($package->features != '')
            @php 
            	$features = $package->features;
	            $exp_features = explode('||',$features);
            @endphp            
            <ul style="color:#ef831d" class="mt-3">
              @foreach($exp_features as $key => $feature)
              <li class="mt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="m9 12 2 2 4-4"></path>
                </svg><span> {{$feature}}</span>
              </li>
              @endforeach
            </ul>
            @endif 
            <a href="javascript:void(0)" id="pay_btn" class="btn btn-outline-warning mt-4 w-100 pay_btn">Pay Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).on('click','#pay_btn',function(){
		let returnURL = "{{route('pages.index')}}";
		let package_id = "{{base64_encode($package->id)}}";
		let saveURL = "{{route('purchase.purchase-package')}}";
		$('.pay_btn').html('Processing...');
		$('.pay_btn').attr('disabled',true);
		formSubmitted = true;
		$.ajax({
		   type: 'POST',
		   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		   url: saveURL,
		   data: {package_id:package_id},
		   success: function(msg){
			  var obj = JSON.parse(msg);
			  formSubmitted = false;
			  if(obj['success'] == true){
				 swal("", obj['message'], "success").then((value) => {
					window.location.href = returnURL;
				 });
			  }else{
				 swal("Error!", obj['message'], "error");        
			  }
			  $('.pay_btn').html('Pay Now');
			  $('.pay_btn').attr('disabled',false);
		   },error: function(ts){
			  formSubmitted = false;
			  swal("Error!", 'Something went wrong, please try after sometime.', "error");
			  return false;
		   }
		});
        return false;	
	});
</script>

@endsection