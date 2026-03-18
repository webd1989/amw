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
      <div class="col-lg-12 wow fadeInLeft"> 
      @if(isset($inner_page->id))
        <div class="left-content">
          <h1 class="mb-3 mt-3">Frequently Asked Questions</span> </h1>
        </div>
      @endif 
      </div>
    </div>
  </div>
</div>

@if(isset($faqs) && $faqs->count()>0)
<!--FAQ section start here-->
<div class="faq-section bg-white py-5 wow fadeInUp">
   <div class="container">
       <div class="col-md-9 mx-auto">
            <div class="accordion faq-content" id="accordionExample">
            	@foreach($faqs as $key => $faq)
               <div class="accordion-item">
                  <h2 class="accordion-header">
                     <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                     <span style="color:#052c65">{{$faq->question}}</span>
                     </button>
                  </h2>
                  <div id="collapseOne{{$key}}" class="accordion-collapse collapse {{$key == 0?'show':''}}" data-bs-parent="#accordionExample">
                     <div class="accordion-body">
                     	{{nl2br($faq->answer)}}
                     </div>
                  </div>
               </div>
				@endforeach
            </div>
       </div>
   </div>
</div>
@endif

@endsection