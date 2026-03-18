@php
	$section5 = getDetails('inner_pages',5);
@endphp

@if(isset($section5->id))
@php
	$desc = str_replace('<p>', '', $section5->description);
    $desc = str_replace('<p/>', '', $desc);
@endphp
<!--Price section start here-->
<div class="price-section my-lg-5 my-4 wow fadeInUp">
    <div class="container">
       <div class="price-content wow fadeInUp">
          <div class="img-left-section">
          	@if($section5->image != '')
             <img src="{{ asset('public/admin/images/banners/') }}/{{$section5->image}}" class="wow fadeInUp"/>
             @endif
          </div>
          <div class="price-inner-box py-4 py-lg-5 wow fadeInUp">
             <div class="price-text wow bounce bounce-slow-more">{!! $section5->title !!}<span class="permoth">{!! $section5->heading !!}</span></div>
             <h4 class="pb-5">{!! $desc !!}</h4>
             <a href="#" class="btn btn-primary cta-button">Get Started Now</a>
          </div>

          <span class="design-element-end wow bounce bounce-slow"><img src="{{$siteUrl}}public/img/abstract_line.svg"/></span>
       </div>
    </div>
</div>
<!--Price section end here-->
@endif