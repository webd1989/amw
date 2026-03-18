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
      <h6 class="mt-6">Edit Plan</h6>
      <div class="row">
        <div class="col-12 col-md-9">
          <div class="card mb-6">
            <form id="pageForm" enctype="multipart/form-data" method="post">
              <input type="hidden" name="row_id" value="{{$record->id}}"/>
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
                      <div class="col-md-4">
                        <label class="form-label" for="title">Type</label>
                        <select name="type" id="type" class="form-select">
                        	<option {{$record->type == 'UG'?'selected':''}} value="UG">UG</option>
                            <option {{$record->type == 'PG'?'selected':''}} value="PG">PG</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Text One</label>
                        <input type="text" id="text1" name="text1" value="{{$record->text1}}" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Text Two</label>
                        <input type="text" id="text2" name="text2" value="{{$record->text2}}" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label required" for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{$record->title}}" class="form-control">
                      </div>           
                      <div class="col-md-4">
                        <label class="form-label required" for="title">Price</label>
                        <input type="text" id="price" name="price" maxlength="10" value="{{$record->price}}" class="form-control numberonly">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Discounted Price</label>
                        <input type="text" id="discounted_price" name="discounted_price" maxlength="10" value="{{$record->discounted_price}}" class="form-control numberonly">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label required" for="title">Features</label>
                        <input type="text" id="features" name="features[]" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label" for="title">&nbsp;</label><br />
                        <button type="button" id="add_more" class="btn btn-success">Add More</button>
                      </div>
                      
                      @if($record->features != '')
                      @php
                      	$exp = explode('||',$record->features);
                      @endphp
                      
                      @if(count($exp) > 0)
                      	@foreach($exp as $key => $feature)
                        @php $rand = mt_rand(); @endphp
                        	<div class="row g-2" id="row_{{$key+$rand}}">
                        	<div class="col-md-4">
                                <label class="form-label required" for="title">Features</label>
                                <input type="text" id="features" value="{{$feature}}" name="features[]" class="form-control" />
                              </div>
                              <div class="col-md-2">
                                <label class="form-label" for="title">&nbsp;</label><br />
                                <button type="button" onclick="remove('{{$key+$rand}}')" class="btn btn-danger">Remove</button>
                              </div>
                              </div>
                        @endforeach
                      @endif
                      @endif
                      
                      <div class="row g-2" id="add_more_div"></div>
                      
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
                <button type="reset" onclick="window.location.href='{{route('admin.plans')}}'" class="btn btn-label-secondary">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var x = 1;
function remove(x){
	$('#row_'+x).remove();
}
$(document).on('click','#add_more',function(){
			$('#add_more_div').append('<div class="row g-2" id="row_'+x+'">\
					<div class="col-md-4">\
						<label class="form-label" for="title">Features</label>\
						<input type="text" id="features" name="features[]" class="form-control" />\
					</div>\
					<div class="col-md-2">\
						<label class="form-label" for="title">&nbsp;</label><br />\
						<button type="button" onclick="remove('+x+')" class="btn btn-danger">Remove</button>\
					  </div>\
					</div>');
					x++;
});

$(document).ready(function(){
	$('.numberonly').keypress(function(e){
		var charCode = (e.which) ? e.which : event.keyCode
		if(String.fromCharCode(charCode).match(/[^0-9+]/g))
		return false;
	});
});

var addUrl = "{{url('/panel/edit-plan/')}}/{{$record->id}}";
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