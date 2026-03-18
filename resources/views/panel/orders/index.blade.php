@extends('layout.admin.dashboard')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

  <div class="card mb-2 p-3">

    <form id="searchForm" name="searchForm">

      <div class="row">

        <div class="col-md-2">

          <input type="text" class="form-control" name="search_keywords" placeholder="Search by keywords" id="search_keywords" />

        </div>

        <div class="col-md-2">

          <input type="date" class="form-control" name="from_date" id="from_date" />

        </div>

        <div class="col-md-2">

          <input type="date" class="form-control" name="to_date" id="to_date" />

        </div>

        <div class="col-md-1"> <a style="color:#FFF" id="searchbuttons" onclick="filterData('search');" class="btn btn-primary waves-effect waves-light">Search</a> </div>

        <div class="col-md-1"> <a style="color:#FFF" onclick="resetFilterForm();" class="btn btn-danger waves-effect waves-light">Reset</a> </div>

      </div>

    </form>

  </div>

  <!-- Basic Bootstrap Table -->

  <div class="card">
  	
    <h5 class="card-header">Orders</h5>

    <div class="table-responsive text-nowrap">

      <table class="table">

        <thead>

          <tr>

            <th>#</th>

            <th>Customer Details</th>

            <th>Order Details</th>

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

  

  <!--/ Basic Bootstrap Table --> 

  

</div>

<script type="text/javascript">

	function getDetails(rowId){

		$('#user_details_html').html('Loading...');

		$.ajax({

			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

			type: 'POST',

			data:{rowId:rowId},

			url: "{{route('admin.get-enquiry')}}",

			success: function(response){

				$('#user_details_html').html(response);

			}

		});

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

            url: "{{ url('/panel/orders_paginate') }}",

            success: function(response){

                $('#replaceHtml').html(response);

                $('#searchbuttons').html('Search');

            }

        });

    }

	function updateOrderStatus(row,value){

		swal({

		title: "Are you sure?",

		text: "",

		icon: "warning",

		buttons: true,

		dangerMode: true,

		})

		.then((willDelete) => {

		if (willDelete) {

			$.ajax({

				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

				type: 'POST',

				data: {row:row,value:value},

				url: "{{ url('/panel/update-order-status') }}",

				success: function(msg){

					if(msg == "Success"){

						swal({

						title: 'Success',

						text: 'Order status updated successfully.',

						type: 'success',

						confirmButtonText: 'Ok',

						confirmButtonColor: "#009EF7"});

						filterData('simple');

					}else{

						swal({

							title: "Oops!",

							text: msg,

							type: "warning",

							timer: 3000

						});

					}

				}

			});

		} else {

			filterData('simple');

		   // swal("Order status is pending!");
		}

		});

	}
</script> 

@endsection