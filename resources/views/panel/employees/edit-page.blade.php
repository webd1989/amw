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
      <h6 class="mt-6">Edit Employee</h6>
      <div class="row">
        <div class="col-12 col-md-9">
          <div class="card mb-6">
            <form id="pageForm" enctype="multipart/form-data" method="post">
              <input type="hidden" name="row_id" value="{{$record->id}}"/>
              <input type="hidden" name="old_profile" value="{{$record->profile}}"/>
              <input type="hidden" name="rmonth" id="rmonth" value="{{date('m',strtotime($record->created_at))}}"/>
              <input type="hidden" name="ryear" id="ryear" value="{{date('Y',strtotime($record->created_at))}}"/>
              <div class="card-header px-0 pt-0">
                <div class="nav-align-top">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal" aria-controls="form-tabs-personal"
role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">General Info</span></button>
                    </li>
                    <li class="nav-item">
                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-permission" aria-controls="form-tabs-permission"
role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Permission Info</span></button>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                  <div class="row g-2">
                    <div class="col-md-4">
                      <label class="form-label required" for="title">Name</label>
                      <input type="text" id="name" name="name" value="{{$record->name}}" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required" for="title">Designation</label>
                        <input type="text" id="designation" name="designation" value="{{$record->designation}}" class="form-control"/>
                      </div>                      
                    <div class="col-md-4">
                      <label class="form-label required" for="title">Email</label>
                      <input type="text" id="email" name="email" value="{{$record->email}}" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label required" for="title">Password</label>
                      <input type="password" id="password" name="password" value="" class="form-control"/>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="title">Mobile</label>
                      <input type="text" id="contact" name="contact" maxlength="10" value="{{$record->mobile}}" class="form-control numberonly"/>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="title">State</label>
                      <input type="text" id="state" name="state" class="form-control" value="{{$record->state}}"/>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="title">City</label> 
                      <input type="text" id="city" name="city" value="{{$record->city}}" class="form-control"/>
                    </div>
                    <div class="col-md-12">
                      <label class="form-label" for="title">Address</label>
                      <input type="text" id="address" name="address" value="{{$record->address}}" class="form-control"/>
                    </div>
                  </div>
                  </div>
                  <div class="tab-pane fade" id="form-tabs-permission" role="tabpanel">
                  <div class="row g-2">
                  	@if(isset($section_list) && $section_list->count()>0)
                    	@foreach($section_list as $key => $section)
                        @php
                        	$exp_permission = explode(',',$record->permision);
                        @endphp
                        	<div class="col-md-3">
                              <div class="form-check">
                                  <input class="form-check-input" {{in_array($key,$exp_permission)?'checked':''}} name="permision[]" type="checkbox" value="{{$key}}" id="checkDefault{{$key}}">
                                  <label class="form-check-label" for="checkDefault{{$key}}">
                                    {{$section}}
                                  </label>
                                </div>
                            </div>
                        @endforeach
                    @endif                                        
                  </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-12 col-md-3">
          <div class="card mb-6">
            <div class="card-body">
              <div class="pt-6">
                <button  type="button" id="submitBtn" class="btn btn-primary me-4">Submit</button>
                <button type="reset" onclick="window.location.href='{{route('admin.employees')}}'" class="btn btn-label-secondary" >Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.numberonly').keypress(function(e){
		var charCode = (e.which) ? e.which : event.keyCode
		if(String.fromCharCode(charCode).match(/[^0-9+]/g))
		return false;
	});
});
var addUrl = "{{url('/panel/edit-employee/')}}/{{$record->id}}";
$(document).ready(function(){
	$('#submitBtn').click(function(e){
		$('#submitBtn').html('Processing...');
		var form = $('#pageForm')[0];
		var formData = new FormData(form);
       	$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'POST',
			data:formData,
			url: addUrl,
			processData: false,
            contentType: false,
			success: function(response){
				$('#submitBtn').html('Submit');
				var obj = JSON.parse(response);
				 if(obj['heading'] == "Success"){
					swal("", obj['msg'], "success").then((value) => {
						window.location.href = "";
					});
				}else{
					swal("Error!", obj['msg'], "error");
					return false;
				}
			},error: function(ts){
				$('#submitBtn').html('Submit');
				swal("Error!", 'Something went to wrong, please try after sometime.', "error");
				return false;
			}
		});
    });
});
</script> 
@endsection