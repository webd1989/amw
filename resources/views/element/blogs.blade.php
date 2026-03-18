@php
    $blogs = getAllRecords('blogs',4);
@endphp

@if(isset($blogs) && $blogs->count()>0)
<!--blog section start here-->
<div class="blog-section py-100 wow fadeInUp">
    <div class="container">
      <div class="testi-title mb-4 mb-lg-5 wow fadeInUp d-flex align-items-center justify-content-between">
         <h2>Our Blog</h2>
         <a href="{{route('pages.blogs')}}" class="btn btn-primary cta-button">View All Blogs</a>
      </div>

      <div class="our-blog-posts wow fadeInUp">
         <div class="row g-4">
         	@foreach($blogs as $key => $blog)
            <div class="col-lg-3 col-md-6 wow fadeInUp">
               <div class="blog-post-box wow fadeInUp">
                  <div class="blog-post-thumb wow fadeInUp">
                  	@if($blog->image != '')                    	
                     	<a href="{{url('blog',$blog->slug)}}"><img alt="{{$blog->image_alt}}" title="{{$blog->title}}" src="{{ asset('public/admin/images/blogs/') }}/{{$blog->image}}"></a>
                     @else
                     	<a href="{{url('blog',$blog->slug)}}"><img alt="" title="" src="{{ asset('public/images/no_image.jpg') }}"></a>
                     @endif
                  </div>               
                  <div class="blog-post-content">
                     <div class="category-name">{{date('d, F, Y',strtotime($blog->created_at))}}</div>
                     <div class="blog-post-content-inner px-3">
                        <h5><a href="{{url('blog',$blog->slug)}}" class="post-tile-name">{!! substr(strip_tags($blog->title),0,60) !!}...</a></h5>
                        <div class="post-author">Written by <b class="strong">{{$blog->added_by}}</b></div>
                        @if($blog->author_id != '')
                        	<div class="post-author">Author ID<b class="strong">{{$blog->author_id}}</b></div>
                        @endif
                        <p>{!! substr(strip_tags($blog->description),0,70) !!}...</p>
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
<!--blog section end here-->
@endif
