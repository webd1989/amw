@php
	$section4 = getDetails('inner_pages',4);
@endphp
@if(isset($section4->id))
@if($section4->image != '')
	<style>
    	.learn-skills-banner-section {
			background: url("{{ asset('public/admin/images/banners/') }}/{{$section4->image}}") no-repeat 0 0;
		}
    </style>
@endif
<!--Learn Skills section start here-->
<div class="learn-skills-banner-section py-100 wow fadeInUp">
   <div class="container">
      <div class="lean-skill-conntent col-lg-7 wow fadeInUp">
          <div class="badge badge-gray">{!! $section4->title !!}</div>
          <h2 class="mb-4">{!! $section4->heading !!}</h2>
          <p class="mb-5">{!! $section4->description !!}</p>
          <a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button">Use College Predictor</a>
      </div>
   </div>
</div>
<!--Learn Skills section end here-->
@endif