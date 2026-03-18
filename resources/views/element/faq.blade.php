@php
	$section6 = getDetails('inner_pages',6);
    $faqs = getAllRecords('faqs');
@endphp
@if(isset($faqs) && $faqs->count()>0)
<!--FAQ section start here-->
<div class="faq-section bg-white py-5 wow fadeInUp">
   <div class="container">
       <div class="col-md-8 mx-auto">
       	@if(isset($section6->id))
          <div class="testi-title-box text-center mb-5 wow fadeInUp">
             <h2>{!! $section6->sub_heading !!}</h2>
          </div>
			@endif
            <div class="accordion faq-content" id="accordionExample">
            	@foreach($faqs as $key => $faq)
               <div class="accordion-item">
                  <h2 class="accordion-header">
                     <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                     {{$faq->question}}
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
<!--FAQ section end here-->
@endif
