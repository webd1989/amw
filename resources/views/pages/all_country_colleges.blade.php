@extends('layout.default')
@if(isset($cData->id))
@section('title',strip_tags($cData->seo_title))
@section('description',strip_tags($cData->seo_description))
@section('keywords',strip_tags($cData->seo_keyword))
@section('robots',strip_tags($cData->robot_tags))
@endif
@section('content')

@php
$siteUrl = env('APP_URL');
@endphp
  
{!! $cData->canonical_tags !!}
{!! $cData->schema_tags !!}
<style>
	th {
    color: #000;
}
td {
    color: #000;
}
</style>
<!--Ready to see you quailty section start here-->
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp test-countey-c">
   <div class="container">
   		<div class="pagination_anchor"></div>
   		@if(isset($cData->id))
        <div class="title-seciton py-3 py-lg-5 wow fadeInUp">
        	@if($cData->image != '')
            	<div class="row">         	
                    <div class="col-md-10 offset-md-1">
                        <img src="{{URL::asset('public/admin/images/banners')}}/{!! $cData->image !!}" alt="{{$cData->alt_image}}" title="{{$cData->title}}" style="width: 100%;height: auto;">
                    </div>
                </div>
            @endif            
            <h2 class="mb-3 mt-3 text-center">{!! $cData->title !!}</h2>            
            <div class="blog_section">
                <p class="col-md-10 mx-auto">{!! $cData->description !!}</p>
            </div>
            @if($cData->introduction != '')
            <div class="blog_section">
                <p class="col-md-10 mx-auto">{!! $cData->introduction !!}</p>
            </div>
            @endif
            @if($cData->elegibility != '')
            <div class="blog_section">
                <p class="col-md-10 mx-auto">{!! $cData->elegibility !!}</p>
            </div>
            @endif
         </div>
         @endif
			
         <!--Search bar section start here-->
           <div class="search-college-filter">
              <div class="search-filter-box d-flex flex-column flex-md-row">
                 <div class="search-form-left">
                    <input type="search" placeholder="Search Collage Name" class="form-input w-100" id="college_name">
                    <?php /*?><select class="form-input select-from w-30" aria-label="Default select example" id="college_type">
                          <option value="">Collage Type</option>
                          <option value="Government">Government</option>
                          <option value="Private">Private</option>               
                    </select><?php */?>
                 </div>
                 <div class="search-btn-icon">
                    <a href="javascript:void(0)" type="button" id="search_college_btn" onclick="filterData()" class="btn btn-primary cta-button">Search</a>
                 </div>
              </div>
           </div>
        <!--Search bar section end here-->

         <div class="step-today-section wow fadeInUp" id="replaceHtml"></div>

         <div class="d-flex align-items-center justify-content-center mx-auto mt-5 wow fadeInUp">
			<a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button">Use College Predictor</a>
         </div>

   </div>
</div>
<!--Ready to see you quailty section end here-->


<!--Learn Skills section start here--> 
  
@include('element.section1') 

<!--Learn Skills section end here-->


<!--Price section start here-->

@include('element.section2')

<!--Price section end here-->


<!--FAQ section start here-->
@include('element.faq')
<!--FAQ section end here-->


<script type="text/javascript">
	document.getElementById("college_name").addEventListener("keyup", function(event){
		if(event.keyCode === 13){
			//$('#search_college_btn').trigger('click');
			filterData();
			return false;
		}
	});
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
		var cname = $('#college_name').val();
		var cid = '{{$countryId}}';
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
			data: {cname:cname,cid:cid},
            url: "{{ url('/country_paginate') }}",
            success: function(response){
                $('#replaceHtml').html(response);				
            }
        });
		return false;
    }
</script>

@endsection