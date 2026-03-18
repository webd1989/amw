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
$setting = getDetails('settings',1);
@endphp

<div class="hero-section">
  <div class="container">
    <div class="row hero-banner-content align-items-center">
      <div class="col-lg-6 wow fadeInLeft"> 
      @if(isset($inner_page->id))
        <div class="left-content">
          <div class="badge">{!! $inner_page->title !!}</div>
          <h1 class="mb-4 mt-4">{!! $inner_page->heading !!} <span class="orange-text">{!! $inner_page->sub_heading !!}</span> </h1>
          <p class="mb-5">{!! $inner_page->description !!}</p>
          <a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button">Use College Predictor</a> 
        </div>
      @endif 
      </div>
      <div class="col-lg-1"></div>
      <div class="col-lg-5 wow fadeInRight"> @include('element.contact_us') </div>
    </div>
  </div>
</div>





<!--Contact Info section start here-->
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
   <div class="container">
        <div class="title-seciton text-center py-3 py-lg-5 wow fadeInUp">
            <h2 class="mb-3">We're Just a Message Away</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">No matter where you are, our team is ready to connect.</p>
            </div>
         </div>

         <div class="step-today-section wow fadeInUp">
            
            <!-- Government-College Cards -->
            <div class="row g-4">
               <div class="col-md-12">
                    <div class="locations mb-4">
                        <h5>Contact Informations</h5>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="college-card h-100 text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('public/img/location_bg.svg') }}" alt="college logo" title="">
                                </div>
                                <h5 class="mt-3">Address</h5>
                                <p class="mb-3">{!! $setting->business_address !!}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                           <div class="college-card h-100 text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('public/img/location_bg.svg') }}" alt="college logo" title="">
                                </div>
                                <h5 class="mt-3">Call Us</h5>
                                <p class="">{{$setting->mobile}}</p>
                           </div>
                        </div>

                        <div class="col-md-4">
                           <div class="college-card h-100 text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('public/img/location_bg.svg') }}" alt="college logo" title="">
                                </div>
                                <h5 class="mt-3">Email Us</h5>
                                <p class="">{{$setting->admin_email}}</p>
                           </div>
                        </div>
                    </div>
               </div>              

            </div>

            
         </div>

         <div class="d-flex align-items-center justify-content-center mx-auto mt-5 wow fadeInUp">
              <a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button me-4">Use College Predictor</a>
              <a href="{{route('pages.colleges')}}" class="btn btn-secondary cta-button">View All Colleges</a>
         </div>

   </div>
</div>
<!--Contact Info section end here-->

<div class="our-locations mb-3 mb-md-5">
   <div class="container">
       <h4 class="text-center mb-4">Our Locations</h4>
   </div>
   <div class="marquee" role="region" aria-label="Site announcements">
   		@if(isset($locations) && $locations->count()>0)
      <!-- Track duplicates the same group twice for seamless scrolling -->
      	<div class="marquee__track" aria-hidden="false">
            <div class="marquee__group">
            	@foreach($locations as $key => $location)
               		<span class="marquee__item"><i class="bi bi-geo-alt-fill"></i> {{$location->title}}</span>
                @endforeach
            </div>
            <?php /*?><div class="marquee__group" aria-hidden="true">
               <span class="marquee__item"><i class="bi bi-geo-alt-fill"></i> Telangana — Hyderabad</span>
               <span class="marquee__item"><i class="bi bi-geo-alt-fill"></i> Haryana — Nuh (formerly Mewat)</span>
               <span class="marquee__item"><i class="bi bi-geo-alt-fill"></i> Uttar Pradesh — Lucknow, Moradabad</span>
               <span class="marquee__item"><i class="bi bi-geo-alt-fill"></i> Gujarat — Surat, Ahmedabad</span>
               <span class="marquee__item"><i class="bi bi-geo-alt-fill"></i> Rajasthan — Udaipur, Jodhpur</span>
            </div><?php */?>
         </div>
         @endif
   </div>
</div>




<!--Contact Info section start here-->
 
</div>
<!--Contact Info section end here--> 

<!--Location map section start here-->
<div class="location-map py-100 pt-0 wow fadeInUp">
  <div class="container">
  	<div class="testi-title-box text-center mb-5 wow fadeInUp">
         <h2>Visit Our Office</h2>
      </div>	
    <div class="map-img">
      <div class="mapouter">
        <div class="gmap_canvas">
          <iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=D 100 A, Supreme Complex, Meera Marg, Bani Park, Jaipur 302006&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
          <a href="https://embed-googlemap.com">google maps embed</a></div>
        <style>
.mapouter{position:relative;text-align:right;width:100%;height:400px;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;height:400px;}.gmap_iframe {height:400px!important;}
</style>
      </div>
    </div>
  </div>
</div>
<!--Location map section end here--> 

@include('element.faq')

@endsection