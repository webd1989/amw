<style>
	.college-show{
		display: flex !important;
	}
</style>

<div id="college-list" class="college-show row g-4 test-pagi">
@if(isset($gcolleges) && $gcolleges->count()>0)
  @foreach($gcolleges as $key => $college)
  @php
      $year = date('Y',strtotime($college->created_at));
      $month = date('m',strtotime($college->created_at));
      $dir = $year.'/'.$month;
  @endphp


  <div class="col-md-6">
  <div class="college-card h-100">
    <div class="d-flex justify-content-between">
      <div class="uni-detais d-flex gap-3 w-75">
        <div class="uni-image">
          @if($college->logo != '')
          <img
            src="{{URL::asset('public/admin/images/banners')}}/{!! $college->logo !!}"
            alt="college logo"
            title=""
          />
          @else
          <img
            src="{{URL::asset('public/images/no_img.jpg')}}"
            class="rounded-circle"
            alt="college logo"
            title=""
          />
          @endif
        </div>
        <div class="uni-namecity">
          <h5 class="uni-name">
            <a href="{{url('college',$college->slug)}}">{{$college->name}}</a>
          </h5>
          <p class="uni-city">
            <i class="fa fa-map-pin"></i>
            {{getDetails('states',$college->state,'state')}} {{$college->city}}
          </p>
          <ul class="uni-badges-list">
            <li class="uni-badge ub-nmc">NMC Approved</li>
            <li class="uni-badge ub-who">WHO Listed</li>
            <li class="uni-badge ub-eng">English Medium</li>
          </ul>
        </div>
      </div>

      <span class="star w-25">
        @for($i=1;$i<=$college->rating;$i++)
        <img src="{{ asset('public/img/star.svg') }}" alt="" title="" />
        @endfor
      </span>
    </div>
    <!-- end uni-detais -->
    <div class="uni-details-card row">
      <div class="col-md-4 text-center">
        <div class="details-card">
          <strong>₹22–27L</strong>
          <span>Total 6yr Fee </span>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="details-card">
          <strong>1804</strong>
          <span>Est. Year </span>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <div class="details-card">
          <strong>~52%</strong>
          <span> FMGE Rate </span>
        </div>
      </div>
    </div>
    <!-- end uni-details-card  -->
    @if($college->description != '')
    <p class="uni-desc">
      {{substr(strip_tags($college->description),0,255)}}...
    </p>
    @endif
    <div class="uni-footer d-flex gap-2">
      <a
        href="{{url('college',$college->slug)}}"
        class="btn btn-outline-secondary flex-fill"
        >View Details</a
      >
      <a href="{{route('pages.predictors')}}" class="btn btn-primary flex-fill">Apply Now</a>
    </div>
    <!-- end uni-footer  -->
  </div>
</div>

  @endforeach  
  {!! $gcolleges->appends(['cid' => $cid, 'cname' => $cname])->links('pagination.custom') !!}
@endif 
</div>