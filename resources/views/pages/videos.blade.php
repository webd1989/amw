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
  {!! $inner_page->canonical_tags !!}
{!! $inner_page->schema_tags !!}
 <!--Blog list section start here-->
<div class="blog-section py-100 wow fadeInUp">
    <div class="container">
    	<div class="pagination_anchor"></div>
    	@if(isset($inner_page->id))
        <div class="title-seciton text-center pb-3 pb-lg-5 wow fadeInUp">
            <h2 class="mb-3">{!! $inner_page->heading !!}</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">{!! $inner_page->description !!}</p>
            </div>
        </div>
		@endif
       <div class="our-blog-posts wow fadeInUp">
            <div class="row g-4" id="replaceHtml">
            @foreach($videos as $key => $video)
               <div class="col-md-3">
                    {!!$video->testimonial!!}
                </div>
               @endforeach
            </div>
        </div>
    </div>
</div>
<!--Blog list section end here-->




@endsection