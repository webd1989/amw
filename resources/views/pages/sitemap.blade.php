@extends('layout.default')
@section('title',strip_tags('Sitemap - Amw Career Point'))
@section('description',strip_tags(''))
@section('keywords',strip_tags(''))
@section('robots',strip_tags('index,follow'))
@section('content')

@php
$siteUrl = env('APP_URL');
@endphp

<style>	
	ul li a {
    	color: var(--gray);
    	font-weight: var(--medium);
	}
	.map{
		margin-bottom:5px;
		list-style-type:circle; color:#383838;
	}
</style>

<?php /*?><div class="our-locations">
   <div class="container">
       <h2 class="text-center mb-4 text-white">Sitemap</h2>
   </div>   
</div><?php */?>

<div class="hero-section">
   <div class="container">
     <div class="row hero-banner-content align-items-center">
        <div class="col-lg-6">
         	<div class="left-content">
                <h2 class="orange-text">Sitemap</h2>
            </div>
        </div>
        <div class="row mb-4 mt-4 college-card h-100">
        	<div class="col-lg-6">
            	<ul>
                	<li class="map"><a href="{{route('pages.index')}}">Home</a></li>
                    <li class="map"><a href="{{route('pages.about-us')}}">About Us</a></li>                    
                    <li class="map"><a href="{{route('pages.colleges')}}">College</a></li>                    
                    <li class="map"><a href="{{route('pages.predictors')}}">Predictors</a></li>
                    <li class="map"><a href="{{route('pages.contact-us')}}">Contact Us</a></li>
                    <li class="map"><a href="{{route('pages.faqs')}}">Faqs</a></li>
                </ul>
            </div>
            <div class="col-lg-6">
            	<ul>
                	<li class="map"><a href="{{route('pages.blogs')}}">Blogs</a></li>
                    <li class="map"><a href="{{route('pages.privacy-policy')}}">Privacy Policy</a></li>
                    <li class="map"><a href="{{route('pages.support')}}">Support</a></li>
                    <li class="map"><a href="{{route('pages.tutorials')}}">Tutorials</a></li>
                    <li class="map"><a href="{{route('pages.documentation')}}">Documentation</a></li>
                    <li class="map"><a href="{{route('pages.packages')}}">Packages</a></li>
                </ul>
            </div>            
        </div>
      </div>
   	</div>  
</div>

@endsection