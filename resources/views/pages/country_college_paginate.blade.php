<style>
	.college-show{
		display: flex !important;
	}
</style>



<div id="college-list" class="college-show row g-4">
@if(isset($gcolleges) && $gcolleges->count()>0)
  @foreach($gcolleges as $key => $college)
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
                	<img alt="" src="{{ asset('public/img/star.svg') }}" title=""/>
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
  {!! $gcolleges->appends(['type' => 'Government', 'cname' => $cname,'cid' => $countryId])->links('pagination.custom') !!}
@endif 
</div>

<!------------------------------------------------------------------->





<script>
	$(document).ready(function(){
		$('#govt-tab').on('click', function(){
			var cname = "{{$cname}}";			
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: {type:'Government',cname:cname},
				url: "{{ url('/colleges_paginate') }}",
				success: function(response){
					$('#replaceHtml').html(response);
					$(this).addClass('active');
					$('#private-tab').removeClass('active');
					$('#abroad-tab').removeClass('active');
					$('#college-list').addClass('college-show');
					$('#college-list-abroad').removeClass('college-show');
					$('#college-list-priv').removeClass('college-show');
					// $('#college-list').html($('#college-list').html()); // Placeholder: you can load government colleges here
				}
			});			
			
		});
	
		$('#private-tab').on('click', function(){
			var cname = "{{$cname}}";
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: {type:'Private',cname:cname},
				url: "{{ url('/colleges_paginate') }}",
				success: function(response){
					$('#replaceHtml').html(response);
					$(this).addClass('active');
					$('#govt-tab').removeClass('active');
					$('#abroad-tab').removeClass('active');
					$('#college-list').removeClass('college-show');
					$('#college-list-abroad').removeClass('college-show');
					$('#college-list-priv').addClass('college-show');
				}
			});			
			
		});
		
		$('#abroad-tab').on('click', function(){
			var cname = "{{$cname}}";
			$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: {type:'Abroad',cname:cname},
				url: "{{ url('/colleges_paginate') }}",
				success: function(response){
					$('#replaceHtml').html(response);
					$(this).addClass('active');
					$('#govt-tab').removeClass('active');
					$('#private-tab').removeClass('active');
					$('#college-list').removeClass('college-show');
					$('#college-list-priv').removeClass('college-show');
					$('#college-list-abroad').addClass('college-show');
				}
			});			
			
		});		
		
	});
</script>