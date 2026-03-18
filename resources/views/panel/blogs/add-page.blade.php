@extends('layout.admin.dashboard')

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
      <h6 class="mt-6">Add Blog</h6>
      <div class="row">
        <div class="col-12 col-md-9">
          <div class="card mb-6">
            <form id="pageForm" enctype="multipart/form-data" method="post">
              <div class="card-header px-0 pt-0">
                <div class="nav-align-top">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal" aria-controls="form-tabs-personal"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">General Info</span> </button>
                    </li>
                    <li class="nav-item">
                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-seo" aria-controls="form-tabs-seo" role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">SEO Info</span> </button>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                    <div class="row g-2">
                    	<div class="col-md-4">
                        <label class="form-label required" for="title">Category</label>
                        <select id="category" name="category" value="index,nofollow" class="form-select">
                          <option value="">Select Category</option>
                          @if(isset($categories) && $categories->count()>0)
                          	@foreach($categories as $key => $category)
                            	<option value="{{$key}}">{{$category}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label required" for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control"/>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="title">Description</label>
                        <textarea id="description" name="description" rows="5" class="form-control editorBox"></textarea>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Added By</label>
                        <input type="text" id="added_by" name="added_by" class="form-control"/>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Author ID</label>
                        <input type="text" id="author_id" name="author_id" class="form-control"/>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Date</label>
                        <input type="date" id="blog_date" name="blog_date" class="form-control"/>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Image</label>
                        <input type="file" id="image" name="image" class="form-control"/>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label" for="title">Image Alt Text</label>
                        <input type="text" id="image_alt" name="image_alt" class="form-control"/>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">
                    <div class="row g-2">
                      <div class="col-md-12">
                        <label class="form-label" for="title">SEO Title</label>
                        <input type="text" class="form-control" placeholder="Enter SEO Title" name="seo_title" id="seo_title">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="title">SEO  Description</label>
                        <textarea class="form-control" rows="6" placeholder="Enter SEO Description" name="seo_description" id="seo_description"></textarea>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="title">SEO  Keywords</label>
                        <textarea class="form-control" rows="6" placeholder="Enter SEO Keywords" name="seo_keyword" id="seo_keyword"></textarea>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="title">Schema Text</label>
                        <textarea id="schema_tags" name="schema_tags" rows="4" class="form-control"></textarea>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="title">Canonical Tag</label>
                        <textarea id="canonical_tags" name="canonical_tags" class="form-control"></textarea>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="title">SEO  Robots</label>
                        <select id="robot_tags" name="robot_tags" value="index,nofollow" class="form-select">
                          <option value="index,follow">index,follow</option>
                          <option value="index,nofollow">index,nofollow</option>
                          <option value="noindex,follow">noindex,follow</option>
                          <option value="noindex,nofollow">noindex,nofollow</option>
                        </select>
                      </div>
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
                <button type="reset" onclick="window.location.href='{{route('admin.blogs')}}'" class="btn btn-label-secondary" >Cancel</button>
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

var addUrl = "{{route('admin.add-blog')}}";
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
						window.location.href = "{{url('/panel/edit-blog/')}}/"+obj['row_id'];
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