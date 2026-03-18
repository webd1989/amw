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
	.college-show{
		display: flex!important;
	}
</style>

<!--Ready to see you quailty section start here-->
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
  <div class="container"> 
  @if(isset($inner_page->id))
    <div class="title-seciton text-center py-3 py-lg-5 wow fadeInUp">
      <h2 class="mb-3">{!! $inner_page->heading !!}</h2>
      <div class="taketo-first">
        <p class="text-center col-md-10 mx-auto">{!! $inner_page->description !!}</p>
      </div>
    </div>
   @endif
    
    
  <div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
   <div class="container">
   		@if(isset($section3->id))
        <div class="title-seciton text-center py-3 py-lg-5 wow fadeInUp">
            <h2 class="mb-3">{!! $section3->title !!}</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">{!! $section3->description !!}</p>
            </div>
         </div>
		@endif
            
         <div class="step-today-section wow fadeInUp">

            <!-- Government-College Cards -->
            <div id="college-list" class="college-show row g-4">
               @if(isset($plans) && $plans->count()>0)
               @foreach($plans as $key => $package)
               <div class="col-md-4">
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
                        <li class="mt-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg><span> {{$feature}}</span></li>                 
                     @endforeach
                     </ul>
                     @endif
                     @if($package->id == 1)
                        <a href="{{route('pages.predictors')}}" class="btn btn-outline-warning mt-4 w-100">Use Predictor</a>
                    @else
                    	@if(!session()->has('login_user_email'))
                        	<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-warning mt-4 w-100">Book Now</a>
                        @else
                        	<a href="{{url('/plan',base64_encode($package->id))}}" class="btn btn-outline-warning mt-4 w-100">Book Now</a>
                        @endif                        
                    @endif                     
                  </div>
               </div>
               @endforeach
               @endif                              
          	</div>

         </div>

   </div>
</div>
            
           
  
</div>
@endsection