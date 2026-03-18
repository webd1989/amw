@extends('layout.admin.dashboard')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="card mb-2 p-3">

    <form id="searchForm" name="searchForm">

      <div class="row">

        <div class="col-md-2">

          <input type="text" class="form-control" name="search_keywords" placeholder="Search by keywords" id="defaultFormControlInput" />

        </div>

        <div class="col-md-2">

          <select name="search_type" id="search_type" class="form-select">

            <option value="">Select College Type</option>

            <option value="Government">Government</option>
            <option value="Private">Private</option>
            <option value="Abroad">Abroad</option>

          </select>

        </div>
        
        <div class="col-md-2">

          <select name="search_country" id="search_country" class="form-select">

            <option value="">Select Country</option>
			@if(isset($countries) && $countries->count()>0)
                @foreach($countries as $key => $country)
                    <option value="{{$key}}">{{$country}}</option>
                @endforeach
            @endif

          </select>

        </div>
        
        <div class="col-md-2">

          <select name="search_state" id="search_state" class="form-select">

            <option value="">Select State</option>
			@if(isset($states) && $states->count()>0)
                @foreach($states as $key => $state)
                    <option value="{{$key}}">{{$state}}</option>
                @endforeach
            @endif
          </select>

        </div>
        
        <div class="col-md-2">

          <select name="search_status" id="search_status" class="form-select">

            <option value="">Select Status</option>

            <option value="1">Active</option>

            <option value="2">Inactive</option>

          </select>

        </div>

        <div class="col-md-1"> <a style="color:#FFF" id="searchbuttons" onclick="filterData('search');" class="btn btn-primary waves-effect waves-light">Search</a> </div>

        <div class="col-md-1"> <a style="color:#FFF" onclick="resetFilterForm();" class="btn btn-danger waves-effect waves-light">Reset</a> </div>

      </div>

    </form>

  </div>

  

  <!-- Basic Bootstrap Table -->

  

  <div class="card">

    <h5 class="card-header">Colleges 

    <a onclick="exportSitemap();" style="float:right;color:#FFF; margin-left:5px;" id="exportSitemapBtn" class="btn btn-info waves-effect waves-light float-end" style="margin-left:10px">Site Map</a>
    
    <a data-bs-toggle="modal" data-bs-target="#uploadCsvModal" class="btn btn-warning waves-effect waves-light" style="float:right;color:#FFF; margin-left:5px;">Import CSV</a>
    
    <?php /*?><a data-bs-toggle="modal" data-bs-target="#uploadCsvcCategory" class="btn btn-warning waves-effect waves-light" style="float:right;color:#FFF; margin-left:5px;">College Category CSV</a><?php */?>

	<a onclick="exportData();" style="float:right;color:#FFF; margin-left:5px;" id="exportCsvBtn" class="btn btn-primary waves-effect waves-light float-end" style="margin-left:10px">Export CSV</a>
    
     <a href="{{route('admin.add-college')}}" style="float:right; color:#FFF" class="btn btn-success waves-effect waves-light">Add</a>
    
    </h5>        

    <div class="table-responsive text-nowrap">

      <table class="table">

        <thead>

          <tr>

            <th>#</th>

            <th>Name</th>
            
            <th>Logo</th>

            <th>Country</th>
            
            <th>State</th>
            
            <th>Type</th>

            <th>Status</th>

            <th>Created</th>

            <th>Actions</th>

          </tr>

        </thead>

        <tbody class="table-border-bottom-0" id="replaceHtml">

          <tr>

            <td colspan="10" class="text-center"><img src="{{ asset('public/admin/images/svg/oval.svg') }}" class="me-4" style="width: 3rem" alt="audio"></td>

          </tr>

        </tbody>

      </table>

    </div>

  </div>

  
  <!---/ Basic Bootstrap Table --->

</div>



<div class="modal fade" id="uploadCsvcCategory" tabindex="-1" aria-labelledby="exampleModalLabelCC" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabelCC">Import CSV</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">

        <div class="form-group">

        <label for="basicInput">Choose File</label>

        <input type="file" class="form-control" name="upload_csv_file_ccat" id="upload_csv_file_cct">

        </div>

      </div>

      <div class="modal-footer">

      <a href="{{url('/storage/sample-csv/college_categories.csv')}}" target="_blank" class="btn btn-success">Download Sample CSV</a>

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        <button type="button" onclick="UploadCSVCCat();" id="uploadCsvBtnCCat" class="btn btn-primary">Upload</button>

      </div>

    </div>

  </div>

</div>


<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body">

        <div class="form-group">

        <label for="basicInput">Choose File</label>

        <input type="file" class="form-control" name="upload_csv_file" id="upload_csv_file">

        </div>

      </div>

      <div class="modal-footer">

      <a href="{{url('/storage/sample-csv/colleges.csv')}}" target="_blank" class="btn btn-success">Download Sample CSV</a>

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        <button type="button" onclick="UploadCSV();" id="uploadCsvBtn" class="btn btn-primary">Upload</button>

      </div>

    </div>

  </div>

</div>


<script type="text/javascript">

	function UploadCSVCCat(){

		if($.trim($('#upload_csv_file_ccat').val()) != ''){

			var file_data = $('#upload_csv_file_ccat').prop('files')[0];

			var form_data = new FormData();

			form_data.append('file', file_data);			

			$('#uploadCsvBtnCCat').html('......');

			$.ajax({

				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

				url: "{{route('admin.import-college-categories')}}",

				dataType: 'text',  // <-- what to expect back from the PHP script, if anything

				cache: false,

				contentType: false,

				processData: false,

				data: form_data,

				type: 'post',

				success: function(msg){					

					$('#uploadCsvBtnCCat').html('Upload');					

					if(msg == 'Success'){

						$('#uploadCsvcCategory').modal('hide');

						swal("", "CSV Uploaded successfully", "success").then((value) => {});

						resetFilterForm();

					}else if(msg == 'InvalidFileType'){

						swal("Error!", 'Please select valid file format', "error");

					}else if(msg == 'ChoseFile'){

						swal("Error!", 'Please choose file', "error");

					}					

				},error: function(ts){

					$('#error500').modal('show');

				}

			});

		}

	}

	function exportSitemap(){
		$('#exportSitemapBtn').html('......');
	
		$.ajax({
	
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	
			type: "POST",
	
			url: "{{route('exports.sitemap')}}",
	
			success: function(msg){
	
				$('#exportSitemapBtn').html('Sitemap');
	
				window.location.href = msg;
	
			},error: function(ts){
	
				$('#error500').modal('show');
	
			}
	
		});
		return false;	
	}
	
    $(document).ready(function(){

        filterData('simple');

    });

	function filterData(type = null){

        if(type =='search'){$('#searchbuttons').html('Searching..');}

        $.ajax({

            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

            type: 'POST',

            data: $('#searchForm').serialize(),

            url: "{{ url('/panel/colleges_paginate') }}",

            success: function(response){

                $('#replaceHtml').html(response);

                $('#searchbuttons').html('Search');

            }

        });

    }
	
	function exportData(){
		$('#exportCsvBtn').html('......');
	
		$.ajax({
	
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	
			type: "POST",
	
			url: "{{route('exports.college')}}",
	
			data: $('#searchForm').serialize(),
	
			success: function(msg){
	
				$('#exportCsvBtn').html('Export CSV');
	
				window.location.href = 'https://amwcareerpoint.com/admin/download-file/'+msg;
	
			},error: function(ts){
	
				$('#error500').modal('show');
	
			}
	
		});
		return false;	
	}

	function UploadCSV(){

		if($.trim($('#upload_csv_file').val()) != ''){

			var file_data = $('#upload_csv_file').prop('files')[0];

			var form_data = new FormData();

			form_data.append('file', file_data);			

			$('#uploadCsvBtn').html('......');

			$.ajax({

				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

				url: "{{route('admin.import-colleges')}}",

				dataType: 'text',  // <-- what to expect back from the PHP script, if anything

				cache: false,

				contentType: false,

				processData: false,

				data: form_data,

				type: 'post',

				success: function(msg){					

					$('#uploadCsvBtn').html('Upload');					

					if(msg == 'Success'){

						$('#uploadCsvModal').modal('hide');

						swal("", "CSV Uploaded successfully", "success").then((value) => {});

						resetFilterForm();

					}else if(msg == 'InvalidFileType'){

						swal("Error!", 'Please select valid file format', "error");

					}else if(msg == 'ChoseFile'){

						swal("Error!", 'Please choose file', "error");

					}					

				},error: function(ts){

					$('#error500').modal('show');

				}

			});

		}

	}

</script>

@endsection