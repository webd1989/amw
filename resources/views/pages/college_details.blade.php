@extends('layout.default')
@if(isset($college->id))
@section('title',strip_tags($college->seo_title))
@section('description',strip_tags($college->seo_description))
@section('keywords',strip_tags($college->seo_keyword))
@section('robots',strip_tags($college->robot_tags))
@endif
@section('content')

@php
$siteUrl = env('APP_URL');
$page_url = request()->route()->getName();
@endphp

<link rel="stylesheet" href="{{$siteUrl}}public/css/lightbox.min.css">

<style>
.card-content ul{ margin-left: 25px;}
.card-content ul li{ list-style-type:disclosure-closed;margin-bottom:25px;}

.card-content ol{ margin-left: 25px;}
.card-content ol li{ list-style-type:disclosure-closed;margin-bottom:25px;}

.card-content li{ list-style-type:disclosure-closed;margin-bottom:25px; margin-left: 17px;}

.card-content h2 {
    font-size: 1.5rem !important;
}
.card-content h3 {
    font-size: 1rem !important;
}

@media (max-width: 768px) {
    .card-content ul{ margin-left:0px;}
	.card-content ol{ margin-left:-26px;}
	.tabs-list .tab-button {
        white-space: normal;
        width: 49%;
        font-size: 12px;
        margin-bottom: 5px;
    }
}
</style>

<!--Ready to see you quailty section start here-->
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
   <div class="container">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item"><a href="{{route('pages.index')}}" class="read-more">Home</a></li>
             <li class="breadcrumb-item"><a href="{{route('pages.colleges')}}" class="read-more">College</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$college->name}}</li>
        </ol>
        </nav>
        
        <div class="college-detail-section pt-3 pb-3 wow fadeInUp">
             <div class="colleage-banner wow fadeInUp">
             	<div class="collage-banner">
                    <div class="overlay-bg">
                        <div class="college-banner-text">
                            
                            <div class="college-logo d-flex align-items-center">
                               @if($college->logo != '') 
                                    <img src="{{URL::asset('public/admin/images/banners')}}/{!! $college->logo !!}" alt="college logo" title="" class="collage-logo-img"> 
                               @else   
                                @endif                               
                                <span class="star">
                                    @for($i=1;$i<=$college->rating;$i++) 
                                        <img src="{{ asset('public/img/star.svg') }}" alt="" title=""/>
                                    @endfor 
                                </span>
                            </div>

                            <h1 class="text-white fw-bold mb-3">{{$college->name}}</h1>
                            <div class="hero-info">
                                <span>
                                   <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                   </svg>
                                   {{getDetails('states',$college->state,'state')}} - 
                                   @if($college->city != '')
                                   {{$college->city}}, 
                                   @endif
                                   {{getDetails('countries',$college->country,'title')}}
                                </span>
                                <span>
                                	@if($college->lop_date != '' && $college->lop_date != '1970-01-01')
                                   <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                   </svg>                                   	
                                   		Established {{date('d-F-Y',strtotime($college->lop_date))}}
                                   	@endif
                                </span>
                             </div>

                             <div class="badges mt-4">
                             	@if($college->type != '')
                                <span class="badge badge-blue">{{$college->type}}</span>
                                @endif
                                @if($college->course_name != '')
                                <span class="badge badge-green">{{$college->course_name}}</span>
                                @endif
                                @if($college->seats != '')
                                <span class="badge badge-purple">Seats: {{$college->seats}}</span>
                                @endif
                                @if($college->inspection_year != '')
                                <span class="badge">Inspection Year: {{$college->inspection_year}}</span>
                                @endif
                             </div>
                          </div>
                    </div>
                    <?php /*?><img src="img/college-banner.png" class="img-banner"/><?php */?>
                    <img src="{{URL::asset('public/img/no_banner.png')}}" class="img-banner"/>
                </div>                    
             </div>
        </div>


        <!-- Tabs Navigation -->
        <div class="tabs-list">
            <button class="tab-button active" onclick="switchTab('overview')">Overview</button>
            <button class="tab-button" onclick="switchTab('campus')">Campus</button>
            <button class="tab-button" onclick="switchTab('hospital')">Hospital</button>
            <button class="tab-button" onclick="switchTab('fees')">Fee Structure</button>
            <button class="tab-button" onclick="switchTab('admissions')">Hostel & Mess</button>
            <button class="tab-button" onclick="switchTab('miscellaneous')">Miscellaneous</button>
            @if( $college->type == 'Abroad')
            <button class="tab-button" onclick="switchTab('city_details')">City Details</button>
            @endif
            <button class="tab-button" onclick="switchTab('placements')">Gallery</button>
        </div>

         <!-- Overview Tab -->
        <div id="overview" class="tab-content tab-content-show active">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        General Information
                    </h2>
                </div>
                <div class="card-content">
                	{!! $college->description !!} 
                    
                    @if($college->mci_recongniotion != '')
                    	<hr />
                        <h5>MCI Recogination</h5>
                    	<p style="line-height: 1.38" class="mt-3">{!! nl2br($college->mci_recongniotion) !!}</p>
                    @endif
                </div>
            </div>

            <!-- Photo Gallery -->
            <?php /*?><div class="card">
                <div class="card-header">
                    <h2 class="card-title">Campus Gallery</h2>
                    <p class="card-description">Explore our state-of-the-art facilities</p>
                </div>
                <div class="card-content">
                    <div class="image-grid">
                        <div class="image-card">
                            <img src="https://images.unsplash.com/photo-1713721332588-122f666e2525?w=600" alt="Main Building">
                            <div class="image-label">Main Building</div>
                        </div>
                        <div class="image-card">
                            <img src="https://images.unsplash.com/photo-1758101512269-660feabf64fd?w=600" alt="Research Laboratory">
                            <div class="image-label">Research Laboratory</div>
                        </div>
                        <div class="image-card">
                            <img src="https://images.unsplash.com/photo-1722248540590-ba8b7af1d7b2?w=600" alt="Central Library">
                            <div class="image-label">Central Library</div>
                        </div>
                    </div>
                </div>
            </div><?php */?>
        </div>

         <!-- Campus Tab -->
         <div id="campus" class="tab-content tab-content-show">
               <div class="card">
                  <div class="card-header">
                     <h2 class="card-title">
                           <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                           </svg>
                           Campus Facilities
                     </h2>
                  </div>
                  <div class="card-content">
                  	
                    {!! $college->campus !!}
                  
                  </div>
               </div>
         </div>
         
          <!-- Hospital Tab -->
         <div id="hospital" class="tab-content tab-content-show">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Hospital & Medical Facilities
                    </h2>
                    <p class="card-description">Leading tertiary care hospital attached to the institution</p>
                </div>
                <div class="card-content">
                	{!! $college->hospital !!}
                </div>
            </div>
        </div>


         <!-- Fee Structure Tab -->
         <div id="fees" class="tab-content tab-content-show">
            <div class="card">
                <div class="card-header"> 
                    <h2 class="card-title">Fee Structure</h2>
                    <p class="card-description">State University Affordability</p>
                </div>
                <div class="card-content">
                    
                    {!! $college->fees_structure !!}
                                        
                </div>
            </div>
        </div>  
        
        <!-- Fee Structure Tab -->
         <div id="city_details" class="tab-content tab-content-show">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">City Details</h2>                    
                </div>
                <div class="card-content">                    
                    {!! $college->city_info !!}                                        
                </div>
            </div>
        </div>                             
        
        <div id="admissions" class="tab-content tab-content-show">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        Hostel & Mess
                    </h2>
                </div>
                <div class="card-content">
                
                	 {!! $college->mess !!}

                </div>
            </div>
             
        </div>

         <!-- Hostel & Mess Tab -->
        <div id="miscellaneous" class="tab-content tab-content-show">            

             <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        Miscellaneous
                    </h2>
                  </div>
                  <div class="card-content">
                  	
                    	{!! $college->miscellaneous !!}

                  </div>
            </div>
        </div>

        <!-- Gallery Tab -->
        
        <div id="placements" class="tab-content tab-content-show">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="icon-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Collage Images Gallery
                    </h2>
                </div>
                <div class="card-content">
                     <div class="image-grid">
                        @if(isset($college_images) && $college_images->count()>0)
                        @foreach($college_images as $key => $value)
                        	@php
                                  $year = date('Y',strtotime($value->created_at));
                                  $month = date('m',strtotime($value->created_at));
                                  $dir = $year.'/'.$month;
                            @endphp
                            <div class="image-card">
                                <a class="example-image-link" href="{{URL::asset('public/admin/images/banners')}}/{{$dir}}/{!! $value->image !!}" data-lightbox="example-set" data-title="">
                                    <img class="img-responsive example-image" src="{{URL::asset('public/admin/images/banners')}}/{{$dir}}/{!! $value->image !!}" alt="college logo" title="college logo"></a>
                            </div>
                        @endforeach
                        @endif
                     </div>
                </div>
            </div>
        </div>
   </div>
   
   <div class="d-flex align-items-center justify-content-center mx-auto mt-5 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
      <a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button">Use College Predictor</a>
    </div>


</div>
<!--Ready to see you quailty section end here-->



<!--Learn Skills section start here-->
@include('element.section1')

<!--Learn Skills section end here-->

<!--Facilities & Campus Life section-->
<div class="facilities-section py-5 wow fadeInUp">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center text-center pb-5">
            <h3 class="fw-bold text-dark">Facilities & Campus Life</h3>
        </div>

        <div class="campus-list-list wow fadeInUp">
            <div class="facilites-box  wow fadeInUp">
                <div class="facitlies-icon">
                    <img src="{{URL::asset('public/img/library.svg')}}"/>
                </div>
                <p class="fw-semibold text-dark">Well-equipped Library</p>
            </div>

            <div class="facilites-box  wow fadeInUp">
                <div class="facitlies-icon">
                    <img src="{{URL::asset('public/img/customer_experience.svg')}}"/>
                </div>
                <p class="fw-semibold text-dark">Experienced Faculty</p>
            </div>

            <div class="facilites-box  wow fadeInUp">
                <div class="facitlies-icon">
                    <img src="{{URL::asset('public/img/computer_lab.svg')}}"/>
                </div>
                <p class="fw-semibold text-dark">Computer Lab</p>
            </div>

            <div class="facilites-box  wow fadeInUp">
                <div class="facitlies-icon">
                    <img src="{{URL::asset('public/img/sports.svg')}}"/>
                </div>
                <p class="fw-semibold text-dark"> Sports Activities</p>
            </div>

            <div class="facilites-box  wow fadeInUp">
                <div class="facitlies-icon">
                    <img src="{{URL::asset('public/img/campus.svg')}}"/>
                </div>
                <p class="fw-semibold text-dark">Heritage Campus</p>
            </div>
        </div>
    </div>
</div>
<!--Facilities & Campus Life section end -->

<!--Price section start here-->

@include('element.section2')

<!--Price section end here-->


<!--FAQ section start here-->
@include('element.faq')
<!--FAQ section end here-->


<!--Get in Touch form bottm start here--> 
             
 @include('element.contact_us2')     
             
<!--Get in Touch form bottom end here-->

<script src="{{$siteUrl}}public/js/lightbox-plus-jquery.min.js"></script>
  
@endsection