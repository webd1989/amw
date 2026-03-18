@if($blogs->count()>0)

    @foreach($blogs as $key => $blog)
        <div class="col-lg-4 col-md-6 wow fadeInUp">
           <div class="blog-post-box wow fadeInUp">
              <div class="blog-post-thumb wow fadeInUp">
                @if($blog->image != '')                    	
                    <a href="{{url('blog',$blog->slug)}}"><img alt="{{$blog->image_alt}}" title="{{$blog->title}}" src="{{ asset('public/admin/images/blogs/') }}/{{$blog->image}}"></a>                 
                 @endif
              </div>               
              <div class="blog-post-content">
                 <div class="category-name">
                 	@if(isset($blog->blog_date) && $blog->blog_date != '')
                        {{date('d, F, Y',strtotime($blog->blog_date))}} 
                    @endif
                 </div>
                 <div class="blog-post-content-inner px-3">
                    <h5><a href="{{url('blog',$blog->slug)}}" class="post-tile-name">{{$blog->title}}</a></h5>
                    <div class="post-author">Written by <b class="strong">{{$blog->added_by}}</b></div>
                    @if($blog->author_id != '')
                        <div class="post-author">Author ID<b class="strong">{{$blog->author_id}}</b></div>
                    @endif
                    <p>{!! substr(strip_tags($blog->description),0,70) !!}...</p>
                    <a href="{{url('blog',$blog->slug)}}" class="read-more">Read More</a>
                    
                    @php
                    	$shareurl = 'https://amwcareerpoint.com/blog/'.$blog->slug;
                    @endphp
                     
                     <span style="float:right">   
                    <a style="font-size:1.3rem" href="https://www.facebook.com/sharer.php?u={{urlencode($shareurl)}}" rel="external noopener nofollow" title="Facebook" target="_blank" class="facebook-share-btn" data-raw="https://www.facebook.com/sharer.php?u={{urlencode($shareurl)}}">
						<i class="bi bi-facebook"></i>
					</a>
                
                                        
                    <?php /*?><a style="font-size:1.3rem" href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title)}}&url={{urlencode($shareurl)}}" rel="external noopener nofollow" title="Twitter" target="_blank" class="twitter-share-btn " data-raw="https://twitter.com/intent/tweet?text{{$blog->title}}&url={{urlencode($shareurl)}}">
                        <i class="bi bi-twitter"></i>
	                </a><?php */?>
                    
                    <a style="font-size:1.3rem" href="https://www.linkedin.com/sharing/share-offsite/?url={{urlencode($shareurl)}}" rel="external noopener nofollow" title="LinkedIn" target="_blank" class="linkedin-share-btn " data-raw="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode($shareurl)}}&title={{$blog->title}}">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    
                    <a style="font-size:1.3rem" href="https://api.whatsapp.com/send?text={{urlencode($shareurl)}}" rel="external noopener nofollow" title="WhatsApp" target="_blank" class="whatsapp-share-btn " data-raw="https://api.whatsapp.com/send?text={{$blog->title}}&{{urlencode($shareurl)}}">
                        <i class="bi bi-whatsapp"></i>
                    </a>                
                               
                    </span>
                                      
                 </div>
              </div>
           </div>
        </div>
    @endforeach

@else

    <div class="col-12">        	
        <div class="row text-center mt-3 my-md-5">        	
            <div class="alert alert-danger alert-block">	
                There are no records
            </div>
        </div>
    </div>

@endif

{{ $blogs->appends(['slug' => $slug])->links('pagination.custom') }}