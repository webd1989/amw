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
	th {
    color: #000;
}
td {
    color: #000;
}

h1{ font-size: 25px !important;
    margin-bottom: 10px;}
h2{ font-size: 22px !important;
    margin-bottom: 10px;}
h4{ font-size: 20px !important;
    margin-bottom: 10px; color:#000}
</style>
<div class="hero-section">   
   <div class="container">
     <div class="row hero-banner-content align-items-center test-inner">
        <div class="col-lg-12 wow fadeInLeft">        
         	<div class="left-content">
            @if(isset($inner_page->id))
                <div class="badge">{!! $inner_page->title !!}</div>
                <h1 class="mb-4 mt-4"> {!! $inner_page->heading !!} <span class="orange-text">{!! $inner_page->sub_heading !!}</span></h1>
                <div class="mb-5 page_section blog_section con-page">{!! $inner_page->description !!}</div>
            @endif
            </div>
        </div>
     </div>
   </div>
</div>

@endsection