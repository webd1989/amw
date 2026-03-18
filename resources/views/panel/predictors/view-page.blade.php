@extends('layout.admin.dashboard')

@php
$siteUrl = env('APP_URL');
@endphp

@section('content')

<style>
	.required:after {
		content:" *";
		color: red;
	  }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col">
      <h6 class="mt-6">View Predictor</h6>
      <div class="row">
        <div class="col-12 col-md-9">
          <div class="card mb-6">
            <form id="pageForm" enctype="multipart/form-data" method="post">
              <div class="card-header px-0 pt-0">
                <div class="nav-align-top">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal" aria-controls="form-tabs-personal"
role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">General Info</span></button>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="row g-2">
                  	<h5>Predictor Details</h5>
                    <div class="col-md-4">
                      <label for="title"><strong>Predictor Type: </strong>{{getDetails('predictor_type',$order->predictor_type,'title')}}</label>
                    </div>
                    <div class="col-md-4">
                      <label for="title"><strong>Neet Rank: </strong>{{ $order->neet_rank }}</label>
                    </div>
					<div class="col-md-4">
                      <label for="title"><strong>Counselling Type: </strong>{{getDetails('counceling_type',$order->counselling_type,'title')}}</label>
                    </div>                    
                    <div class="col-md-4">
                      <label for="title"><strong>Seat Category: </strong>{{getDetails('college_categories',$order->seat_category,'title')}}</label>
                    </div>
                    <div class="col-md-4">
                      <label for="title"><strong>Seat Sub Category: </strong>{{getDetails('sub_categories',$order->sub_category_id,'title')}}</label>
                    </div>
                    <div class="col-md-4">
                      <label for="title"><strong>Local Area: </strong>{{getDetails('local_areas',$order->local_area_id,'title')}}</label>
                    </div>
                    <br /><br />
                    
                    <h5>Customer Details</h5>
                    <div class="col-md-4">
                      <label for="title"><strong>Name: </strong>{{$order->first_name}} {{$order->last_name}}</label>
                    </div>
                    
                    <div class="col-md-4">
                      <label for="title"><strong>Email: </strong>{{$order->email}}</label>
                    </div>
                    
                    <div class="col-md-4">
                      <label for="title"><strong>Mobile: </strong>{{$order->email}}</label>
                    </div>                    
                  </div>
                  
                  <div class="mb-4 mt-4">
                  <a href="{{route('admin.predictors')}}" class="btn btn-primary me-3">Back</a>
                </div>
                </div>
              </div>
            </form>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>
  
@endsection