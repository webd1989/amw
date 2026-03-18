@extends('layout.default')
@if(isset($blog->id))
@section('title',strip_tags($blog->seo_title))
@section('description',strip_tags($blog->seo_description))
@section('keywords',strip_tags($blog->seo_keyword))
@section('robots',strip_tags($blog->robot_tags))
@endif
@section('content')

@php
$siteUrl = env('APP_URL');
@endphp  
{!! $blog->canonical_tags !!}
{!! $blog->schema_tags !!}
<style>
	.blog_section a span{
		color: var(--greenBg) !important;
	}
</style>

<!--Ready to see you quailty section start here-->
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp aditya-test">
  <div class="container">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb mt-3">
        <li class="breadcrumb-item"><a href="{{route('pages.index')}}" class="read-more">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('pages.blogs')}}" class="read-more">Blog</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$blog->title}}</li>
      </ol>
    </nav>
    <div class="college-detail-section pt-3 pb-5 wow fadeInUp">
      <div class="colleage-banner wow fadeInUp">
        <div class="collage-banner">
          <div class="overlay-bg">
            <div class="college-banner-text justify-content-center h-100 d-flex flex-column">
              <h3 class="text-white fw-bold mb-4">{{$blog->title}}</h3>
              <p class="text-white">
              	@if(isset($blog->blog_date) && $blog->blog_date != '')
              		{{date('d, F, Y',strtotime($blog->blog_date))}} 
                @endif
                | Written by {{$blog->added_by}}
                @if($blog->author_id != '')
                | Author ID {{$blog->author_id}}
                @endif
                </p>
              
              @php
                    $shareurl = 'https://amwcareerpoint.com/blog/'.$blog->slug;
                @endphp                
                
                <span style="float:left; margin-top:10px;">   
                <a style="font-size:1.3rem; color:#FFF" href="https://www.facebook.com/sharer.php?u={{urlencode($shareurl)}}" rel="external noopener nofollow" title="Facebook" target="_blank" class="facebook-share-btn" data-raw="https://www.facebook.com/sharer.php?u={{urlencode($shareurl)}}">
                    <i class="bi bi-facebook"></i>
                </a>
            
                                    
                <?php /*?><a style="font-size:1.3rem" href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title)}}&url={{urlencode($shareurl)}}" rel="external noopener nofollow" title="Twitter" target="_blank" class="twitter-share-btn " data-raw="https://twitter.com/intent/tweet?text{{$blog->title}}&url={{urlencode($shareurl)}}">
                    <i class="bi bi-twitter"></i>
                </a><?php */?>
                
                <a style="font-size:1.3rem; color:#FFF" href="https://www.linkedin.com/sharing/share-offsite/?url={{urlencode($shareurl)}}" rel="external noopener nofollow" title="LinkedIn" target="_blank" class="linkedin-share-btn " data-raw="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode($shareurl)}}&title={{$blog->title}}">
                    <i class="bi bi-linkedin"></i>
                </a>
                
                <a style="font-size:1.3rem; color:#FFF" href="https://api.whatsapp.com/send?text={{urlencode($shareurl)}}" rel="external noopener nofollow" title="WhatsApp" target="_blank" class="whatsapp-share-btn " data-raw="https://api.whatsapp.com/send?text={{$blog->title}}&{{urlencode($shareurl)}}">
                    <i class="bi bi-whatsapp"></i>
                </a>                           
                </span>
            </div>
          </div>
          @if($blog->image != '') 
          <img alt="" title="" src="{{ asset('public/admin/images/blogs/') }}/{{$blog->image}}" alt="{{$blog->image_alt}}" title="{{$blog->title}}" class="img-banner"> 
          @else 
          <img alt="" src="{{ asset('public/img/no_banner.png') }}" class="img-banner"/> 
          @endif 
          </div>
      </div>
    </div>
    <div class="step-today-section wow fadeInUp"> 
      <!-- Tabs -->
      <div class="row">
         <div class="col-md-12">
        	<h1 class="fw-bold text-dark mb-4 blog_title">{{$blog->title}}</h1>
            <div class="blog_section">
        	{!! $blog->description !!} 
            </div>
          </div>
               <!-- <div class="col-md-4">form</div> -->

        </div>
      <?php /*?><div class="course-we-offer wow fadeInUp">
                <h4 class="fw-bold text-dark mb-3">Courses Offered</h4>
                <div class="course-lsit">
                    <ul>
                        <li class="course-name">B.A. in English Literature</li>
                        <li class="course-name">B.A. in History</li>
                        <li class="course-name">B.A. in Political Science</li>
                        <li class="course-name">B.A. in Geography</li>
                        <li class="course-name">B.A. in Economics</li>
                        <li class="course-name">B.A. in English Literature</li>
                        <li class="course-name">B.A. in Economics</li>
                    </ul>
                </div>
            </div><?php */?>
    </div>
  </div>
</div>
<!--Ready to see you quailty section end here--> 
@if(isset($blogs) && $blogs->count()>0)
<!--Related Blog post start here-->
<div class="faq-section bg-white py-5 wow fadeInUp">
  <div class="container">
    <div class="testi-title mb-4 mb-lg-5 wow fadeInUp d-flex align-items-center justify-content-between">
      <h2>Latest Blogs</h2>
      <a href="{{route('pages.blogs')}}" class="btn btn-primary cta-button">View All Blogs</a> 
    </div>
    <div class="our-blog-posts wow fadeInUp">
      <div class="row g-4">
      	@foreach($blogs as $key => $blog)
        <div class="col-lg-3 col-md-6 wow fadeInUp">
          <div class="blog-post-box wow fadeInUp">
            <div class="blog-post-thumb wow fadeInUp"> 
            	@if($blog->image != '')                    	
                    <a href="{{url('blog',$blog->slug)}}"><img alt="" alt="" title="" src="{{ asset('public/admin/images/blogs/') }}/{{$blog->image}}"></a>
                 @else
                    <a href="{{url('blog',$blog->slug)}}"><img alt="" alt="" title="" src="{{ asset('public/images/no_image.jpg') }}"></a>
                 @endif
            </div>
            <div class="blog-post-content">
              <div class="category-name">{{date('d, F, Y',strtotime($blog->created_at))}}</div>
              <div class="blog-post-content-inner px-3">
                <h5><a href="{{url('blog',$blog->slug)}}" class="post-tile-name">{!! substr(strip_tags($blog->title),0,50) !!}...</a></h5>
                <div class="post-author">Written by <b class="strong">{{$blog->added_by}}</b></div>
                <p>{!! substr(strip_tags($blog->description),0,50) !!}...</p>
                <a href="{{url('blog',$blog->slug)}}" class="read-more">Read More</a>
             </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<!--Related Blog post end here--> 
@endif

@endsection