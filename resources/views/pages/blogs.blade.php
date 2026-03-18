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
            <h2 class="mb-3">{{ $slug }}</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">{!! $inner_page->description !!}</p>
            </div>
        </div>
		@endif
       <div class="our-blog-posts wow fadeInUp">
       		<input type="hidden" id="slug" value="{{$slug}}"/>
            <div class="row g-4" id="replaceHtml"></div>
        </div>
    </div>
</div>
<!--Blog list section end here-->


<script type="text/javascript">
    $(document).ready(function(){
        filterData('simple');		
		$('#replaceHtml').on('click', '.pagination a', function(){
			var url = $(this).attr('href');
			$('#replaceHtml').load(url);
			var scrollPos =  $(".pagination_anchor").offset().top;
			$(window).scrollTop(scrollPos);
			return false;
		});
    });

    function filterData(type = null){
		var slug = $('#slug').val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
			data:{slug:slug},
            url: "{{ url('/blogs_paginate') }}",
            success: function(response){
                $('#replaceHtml').html(response);
            }
        });
    }
</script>

@endsection