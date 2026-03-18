@extends('layout.default')
@if(isset($inner_page->id))
@section('title',strip_tags('My Orders'))
@section('description',strip_tags('My Orders'))
@section('keywords',strip_tags('My Orders'))
@section('robots',strip_tags('index,follow'))
@endif
@section('content')

@php
$siteUrl = env('APP_URL');
$page_url = request()->route()->getName();
$setting = getDetails('settings',1);
@endphp

<section class="pro-carousel">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-12">
            <div class="accordion myOrder-tab-cls" id="accordionExample"> 
            @if(isset($orders) && $orders->count()>0)
              @foreach($orders as $key => $order)
              <div class="accordion-item">
                <div class="accordion-header" id="headingOne">
                  <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne{{$key}}">
                    <div class="kk-contant-boxb cart-box-cnt w-100 align-items-center  d-flex justify-content-between">
                      <div class="left-content-order">
                        <h4 class="d-block cat-head text-capitalize mb-2">Invoice No: <span class="title-dscnt">#{{$order->invoice_id}} </span> </h4>
                        <div class="d-flex align-items-center"> <span class="d-block cat-head fw-bold">Amount: ₹ {{$order->total}}</span> <span class="d-flex align-items-center order_date ps-3"><span class="pe-2 calendar-icon"><i class="bi bi-calendar"></i></span>{{date('d F, Y h:ia', strtotime($order->created_at))}}</span> </div>
                      </div>
                      <span class="delivered-btn me-3">{{$order->product_name}}</span> </div>
                  </div>
                </div>
                <div id="collapseOne{{$key}}" class="accordion-collapse collapse {{$key == 0?'show':''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body p-0">
                    <div class="d-flex flex-md-row w-100 flex-column align-items-md-center shipping-address">
                      <p class=" mt-0 pb-4 w-50"><strong class="me-2 text-uppercase">Address:</strong> 
                      @if($order->customer_address != ''){{$order->customer_address}} @endif<br />
                        City: {{$order->customer_city}}, State: {{$order->customer_state}}, India, {{$order->customer_zipcode}}</p>
                        
                      <p class="mt-0 pb-4 w-50 "><strong class="me-2 text-uppercase">Customer:</strong> Name: {{$order->customer_name}} <br />
                        Email: {{$order->customer_email}}, Mobile: {{$order->customer_mobile}}</p>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              @endif 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
@endsection