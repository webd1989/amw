@if($records->count()>0)

    @foreach($records as $key => $row)  
	@php
        $count = $records->count();
        $last = $records->lastItem();
        $page = $records->currentPage();
        $sr = $key+1;
        if($page > 1){
            $sr = ($last-$count)+$key+1;
        }
    @endphp
    @php

    	$read = "";

        if($row->read_status == 2){$read = "fw-bold";}

    @endphp

    

    <tr class="{{$read}}">

    <td>{{$sr}}.</td>

    <td>{{$row->name}}</td>    

    <td>{{$row->email}}</td>    

    <td>{{$row->contact}}</td>    

    <td>{!! date('d M, Y h:i A',strtotime($row->created_at)) !!}</td>

    <td>

    <div class="dropdown">

        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">

        <i class="icon-base ti tabler-dots-vertical"></i>

        </button>

        <div class="dropdown-menu">

        <a class="dropdown-item" style="cursor:pointer" onclick="getDetails('{{$row->id}}');" data-bs-toggle="modal" data-bs-target="#viewDetails"><i class="icon-base ti tabler-pencil me-1"></i> View</a>
        
        @if(Session::get('admin_type') == 'Admin')
        <a class="dropdown-item" onclick="deleteData('contacts','{{ $row->id }}');" href="javascript:void(0);"><i class="icon-base ti tabler-trash me-1"></i> Delete</a>
        @endif

        </div>

    </div>

    </td>

    </tr>

    @endforeach

    @else

    <tr>

        <td align="center" colspan="10">Record not found</td>

    </tr>

    @endif

    <tr>

        <td align="center" colspan="10">

            <div id="pagination">{!! $records->links('pagination.front') !!}</div>

        </td>

    </tr>