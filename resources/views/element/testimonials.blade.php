@php
	$section6 = getDetails('inner_pages',6);
    $testimonials = getAllRecords('testimonials');
@endphp

@if(isset($testimonials) && $testimonials->count()>0)
<!--Testimonials section start here-->
    <div class="testimonial-section py-5 wow fadeInUp">
       <div class="container">
       	@if(isset($section6->id))
         <div class="testi-title-box text-center mb-5 wow fadeInUp ">
             <h5>{!! $section6->title !!}</h6>
             <h2>{!! $section6->heading !!}</h2>
         </div>
		@endif
        
         <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">                                
               <!-- Slides -->
               <div class="carousel-inner">
               	@foreach($testimonials as $key => $testimonial)
                  <div class="carousel-item {{$key == 0?'active':''}}">
                     <div class="testimonial-inner">
                        <div class="client-info">
                            <div class="cleint-img">
                                @if($testimonial->image != '')
                               		<img src="{{ asset('public/admin/images/users/') }}/{{$testimonial->image}}"/> 
                                @endif                               
                            </div>
                            <div class="client-details">
                               <b class="client-name">{{$testimonial->name}}</b>
                               <small>Students
                               	@if($testimonial->country_university != '')
                               	 , {{$testimonial->country_university}}
                               @endif
                               </small>                               
                               @if($testimonial->batch_year != '')
                               	<small>Batch/Year: {{$testimonial->batch_year}}
                                	@if($testimonial->neet_score != '')
                                    	, Neet Rank: {{$testimonial->neet_score}}
                                   @endif
                                </small>
                               @endif                               
                            </div>
                        </div>
                        <p class="fst-italic">“ {!! nl2br($testimonial->testimonial) !!} ”</p>
                     </div>
                  </div>
                  @endforeach
               </div>
				                
               <!-- Controls -->
                <div class="arrows-next-prv">
                     <button class="carousel-control-prev testi-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="arrow-img"><img src="{{$siteUrl}}public/img/arrow_left.svg"/></span>
                     </button>

                     <button class="carousel-control-next testi-prive" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="arrow-img"><img src="{{$siteUrl}}public/img/arrow_right.svg"/></span>
                     </button>
                </div>               

         </div>

         <div class="d-flex align-items-center justify-content-center pt-5 pb-3 pb-lg-5">
             <a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button">Use College Predictor</a>
         </div>
         
       </div>
    </div>
<!--Testimonials section end here-->
@endif