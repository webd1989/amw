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
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
   <div class="container">
   		<div class="pagination_anchor"></div>
        <div class="title-section text-center py-3 py-lg-5 wow fadeInUp">
         	<h2 class="mb-3 text-center">colleges</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">Explore India’s best medical colleges curated to help you make confident career decisions. Compare facilities, fees, ranking, and admission details — all in one place.</p>
            </div>
         	<div id="college-list-priv" class="row g-4 mt-2 mb-2" style="display: flex !important;">
                @if(isset($spcolleges) && $spcolleges->count()>0)
                  @foreach($spcolleges as $key => $college)
                  @php
                      $year = date('Y',strtotime($college->created_at));
                      $month = date('m',strtotime($college->created_at));
                      $dir = $year.'/'.$month;
                  @endphp
                  <div class="col-md-4">
                    <div class="college-card h-100">
                      <div class="d-flex justify-content-between align-items-center"> 
                        @if($college->logo != '') 
                            <img src="{{URL::asset('public/admin/images/banners')}}/{!! $college->logo !!}" alt="college logo" title=""> 
                        @else 
                            <img src="{{URL::asset('public/images/no_img.jpg')}}" class="rounded-circle" alt="college logo" title=""> 
                        @endif
                        <div> 
                            <span class="star">
                                @for($i=1;$i<=$college->rating;$i++) 
                                    <img src="{{ asset('public/img/star.svg') }}" alt="" title=""/>
                                @endfor 
                            </span> 
                        </div>
                      </div>
                      <a href="{{url('college',$college->slug)}}"><h5 class="mt-3">{{$college->name}}</h5></a>
                      <p class="mb-4">{{getDetails('states',$college->state,'state')}}</p>
                      @if($college->description != '')
                        <p>{{substr(strip_tags($college->description),0,70)}}...</p>
                      @endif 
                      <a href="{{url('college',$college->slug)}}" class="btn btn-outline-warning mt-4 w-100">College Details</a> 
                    </div>
                  </div>
                  @endforeach                    	
                  @else
                  	 <div class="col-md-12 col-lg-12 text-center alert alert-danger">No College Found</div> 
                @endif
            </div>
         </div>
   </div>
</div>

@endsection