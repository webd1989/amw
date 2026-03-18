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
   

<!--Ready to see you quailty section start here-->
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp test-data-inner">
   <div class="container">
   		<div class="pagination_anchor"></div>
   		@if(isset($inner_page->id))
        <div class="title-seciton text-center py-3 py-lg-5 wow fadeInUp">
            <h2 class="mb-3">{!! $inner_page->heading !!}</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">{!! $inner_page->description !!}</p>
            </div>
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
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
			data: {cname:cname,},
            url: "{{ url('/colleges_paginate') }}",
            success: function(response){
                $('#replaceHtml').html(response);				
            }
        });
		return false;
    }
</script>

@endsection