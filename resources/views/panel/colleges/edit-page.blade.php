@extends('layout.admin.dashboard')

@php

$siteUrl = env('APP_URL');

@endphp

<script src="{{ URL::asset('public/admin/js/dropzone.js') }}"></script>

<link href="{{ URL::asset('public/admin/css/dropzone.css') }}" rel="stylesheet">

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

      <h6 class="mt-6">Edit College</h6>
	  <div class="row">
      <div class="col-12 col-md-12">

          <div class="card mb-6">

            <div class="card-body">

              <div style="float:right">

                <button  type="button" id="submitBtn" class="btn btn-primary me-4 submitBtn">Submit</button>

                <button type="reset" onclick="window.location.href='{{route('admin.colleges')}}'" class="btn btn-label-secondary" >Cancel</button>

              </div>

            </div>

          </div>

        </div>
      </div>
      <div class="row">

        <div class="col-12 col-md-12">

          <div class="card mb-6">

            <form id="pageForm" enctype="multipart/form-data" method="post">

              <input type="hidden" name="row_id" value="{{$record->id}}"/>

              <input type="hidden" name="old_brochure" value="{{$record->brochure}}"/>

              <input type="hidden" name="old_logo" value="{{$record->logo}}"/>

              <input type="hidden" name="rmonth" id="rmonth" value="{{date('m',strtotime($record->created_at))}}"/>

              <input type="hidden" name="ryear" id="ryear" value="{{date('Y',strtotime($record->created_at))}}"/>              

              <div class="card-header px-0 pt-0">

                <div class="nav-align-top">

                  <ul class="nav nav-tabs" role="tablist">

                    <li class="nav-item">

                      <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal" aria-controls="form-tabs-personal"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">General Info</span> </button>

                    </li>
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-college" aria-controls="form-tabs-college"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Campus</span> </button>

                    </li>
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-hospital" aria-controls="form-tabs-hospital"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Hospital</span> </button>

                    </li>
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-fees" aria-controls="form-tabs-fees"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Fees Structure</span> </button>

                    </li>
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-mess" aria-controls="form-tabs-mess"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Hostel & Mess</span> </button>

                    </li>
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-city-info" aria-controls="form-tabs-city-info"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">City Details</span> </button>

                    </li>  
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-miscellaneous" aria-controls="form-tabs-miscellaneous"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Miscellaneous</span> </button>

                    </li>  
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-cut-off" aria-controls="form-tabs-cutt-off"

role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Cut Off</span> </button>

                    </li>                    

                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-images" aria-controls="form-tabs-images" role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Images Info</span> </button>

                    </li>
                    
                    <li class="nav-item">

                      <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#form-tabs-ranks" aria-controls="form-tabs-ranks" role="tab" aria-selected="true"> <span class="icon-base ti tabler-user icon-lg d-sm-none"></span><span class="d-none d-sm-block">Rank</span> </button>

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
						
                      <div class="col-md-3">

                        <label class="form-label required" for="title">College Type</label>

						<select name="type" id="type" class="form-select">
                        	<option {{$record->type == 'Abroad'?'selected':''}} value="Abroad">Abroad</option>
                            <option {{$record->type == 'Government'?'selected':''}} value="Government">Government</option>
                            <option {{$record->type == 'Private'?'selected':''}} value="Private">Private</option>                            
                        </select>

                      </div>
                      
                      <div class="col-md-9">

                        <label class="form-label required" for="title">Name</label>

                        <input type="text" id="name" name="name" value="{{$record->name}}" class="form-control" />

                      </div>

                      <div class="col-md-6">

                        <label class="form-label required" for="title">Slug</label>

                        <input type="text" id="slug" name="slug" value="{{$record->slug}}" class="form-control" />

                      </div>                     
                                             
                      <div class="col-md-3">

                        <label class="form-label required" for="title">Country</label>

                        <select name="country" id="country" class="form-select" onchange="getState(this.value)">

                        	<option value="">Select Country</option>

                           	 @if(isset($countries) && $countries->count()>0)
                                @foreach($countries as $key => $country)
                                    <option {!! $record->country == $key ? 'selected' : '' !!} value="{{$key}}">{{$country}}</option>
                                @endforeach
                            @endif
                        </select>

                      </div>

                      <div class="col-md-3">

                        <label class="form-label required" for="title">State</label>

                        <select name="state" id="state" class="form-select">

                        	<option value="">Select State</option>

                            @if(isset($states) && $states->count()>0)

                            	@foreach($states as $key => $state)

                                	<option {{$record->state == $key?'selected':''}} value="{{$key}}">{{$state}}</option>

                                @endforeach

                            @endif

                        </select>

                      </div>
                      
                      <div class="col-md-3">

                        <label class="form-label required" for="title">City</label>

                        <input type="text" id="city" name="city" class="form-control" value="{{$record->city}}" />

                      </div>
                      
                      <div class="col-md-12">

                        <label class="form-label required" for="title">Description</label>
                        
                        <textarea id="description" name="description" class="form-control editorBox">{{$record->description}}</textarea>

                      </div>

                      <div class="col-md-4">

                        <label class="form-label required" for="title">Course Name</label>

                        <input type="text" id="course_name" name="course_name" value="{{$record->course_name}}" class="form-control" />

                      </div>

                      <div class="col-md-4">

                        <label class="form-label required" for="title">Seats</label>

                        <input type="text" id="seats" name="seats" value="{{$record->seats}}" class="form-control" />

                      </div>
                      
                      <div class="col-md-4">

                        <label class="form-label required" for="title">Inspection Year</label>

                        <input type="text" id="inspection_year" name="inspection_year" value="{{$record->inspection_year}}" class="form-control" />

                      </div>
                      
                      <div class="col-md-4">

                        <label class="form-label required" for="title">Management</label>

                        <input type="text" id="management" name="management" value="{{$record->management}}" class="form-control" />

                      </div>
                      
                      <div class="col-md-4">

                        <label class="form-label required" for="title">Rank</label>

                        <input type="text" id="ranking" name="ranking" class="form-control" value="{{$record->ranking}}" />

                      </div> 
                      
                      <div class="col-md-4">

                        <label class="form-label required" for="title">Lop Date</label>
						@if($record->lop_date != '')
                        <input type="date" id="lop_date" name="lop_date" value="{{$record->lop_date}}" class="form-control" />
                        @else
                        <input type="date" id="lop_date" name="lop_date" class="form-control" />
                        @endif

                      </div>
                      
                      <div class="col-md-12">

                        <label class="form-label required" for="title">MCI Recogination</label>
                        
                        <textarea id="mci_recongniotion" rows="4" name="mci_recongniotion" class="form-control">{{$record->mci_recongniotion}}</textarea>

                      </div>
                      
                      <div class="col-md-4">
                        <label class="form-label" for="title">Rating</label>
                        <select name="rating" id="rating" class="form-select">
                        	
                            <option {{$record->rating == 5?'selected':''}} value="5">5 Star</option>
                            <option {{$record->rating == 4?'selected':''}} value="4">4 Star</option>
                            <option {{$record->rating == 3?'selected':''}} value="3">3 Star</option>
                            <option {{$record->rating == 2?'selected':''}} value="2">2 Star</option>
                            <option {{$record->rating == 1?'selected':''}} value="1">1 Star</option>
                            
                            
                            
                        </select>
                      </div>
                      
                      
                      
                      <div class="col-md-4">
                        <label class="form-label" for="title">Logo</label>
                        <input type="file" id="logo" name="logo" class="form-control" value="" />
                        <input type="hidden" name="old_logo" id="old_logo" value="{{$record->logo}}"/>
                      </div>
                      @if($record->logo != '')
                      <div class="col-md-2">
                        <label class="form-label" for="title">&nbsp;</label>
                        <br />
                        <img src="{{URL::asset('public/admin/images/banners')}}/{!! $record->logo !!}" style="max-width:100px;height: auto;"> </div>
                      @endif

                    </div>

                  </div>
                  
                  <div class="tab-pane fade" id="form-tabs-college" role="tabpanel">
                 	<label class="form-label required" for="title">College & Campus</label>
                        
                    <textarea id="campus" rows="4" name="campus" class="form-control editorBox">{{$record->campus}}</textarea>
                  </div>
                  
                  <div class="tab-pane fade" id="form-tabs-hospital" role="tabpanel">
                  	<label class="form-label required" for="title">Hospital</label>
                        
                    <textarea id="hospital" rows="4" name="hospital" class="form-control editorBox">{{$record->hospital}}</textarea>
                  </div>
                  
                  <div class="tab-pane fade" id="form-tabs-fees" role="tabpanel">
                  	<label class="form-label required" for="title">Fee Structure</label>
                        
                    <textarea id="fees_structure" rows="4" name="fees_structure" class="form-control editorBox">{{$record->fees_structure}}</textarea>
                  </div>
                                                      
                  <div class="tab-pane fade" id="form-tabs-mess" role="tabpanel">
                  	<label class="form-label required" for="title">Hostel & Mess</label>
                        
                    <textarea id="mess" rows="4" name="mess" class="form-control editorBox">{{$record->mess}}</textarea>
                  </div>
                  
                  <div class="tab-pane fade" id="form-tabs-city-info" role="tabpanel">
                  	<label class="form-label required" for="title">City Details</label>
                        
                    <textarea id="city_info" rows="4" name="city_info" class="form-control editorBox">{{$record->city_info}}</textarea>
                  </div>
                  
                  <div class="tab-pane fade" id="form-tabs-miscellaneous" role="tabpanel">
                  	<label class="form-label required" for="title">Miscellaneous & NRI Seat</label>
                        
                    <textarea id="miscellaneous" rows="4" name="miscellaneous" class="form-control editorBox">{{$record->miscellaneous}}</textarea>
                  </div>                  
                                    
                <div class="tab-pane fade" id="form-tabs-images" role="tabpanel">

                   <div class="row">

                      <div class="col-12">

                        <label for="basicInput">College Images</label>

                        <div id="my-awesome-dropzone" class="dropzone"></div>

                      </div>

                      @if(isset($college_images) && count($college_images) > 0)

                      <div class="col-12" id="replaceHtml">

                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

                            <thead>

                            <tr>

                               <th>#</th>

                               <th>Image</th>

                               <th>Status</th>

                               <th>Action</th>

                               <th>Created</th> 

                            </tr>

                            </thead>

                            <tbody>

                            @foreach($college_images as $key => $value)
                            
                            @php
                            $year = date('Y',strtotime($value->created_at));
                            $month = date('m',strtotime($value->created_at));
                            $dir2 = $year.'/'.$month;
                            @endphp

                            <tr>

                            <td>{{ $key+1; }}</td>

                            <td>

                               	<a target="_blank" href="{{ URL::asset('public/admin/images/banners/') }}/{{$dir2}}/{!! $value->image !!}" data-sub-html="Image"> 

                               		<img width="100px" class="img-responsive" src="{{ URL::asset('public/admin/images/banners/') }}/{{$dir2}}/{!! $value->image !!}">

                                </a>

                            </td>

                            <td>       

                              	@php

                     				if($value->status == 1){$class = 'bg-label-success'; $label = 'Active';}else{$class = 'bg-label-danger'; $label = 'In-Active';}

                               	@endphp

                               	<a style="cursor:pointer" onclick="changeStatus('college_images','{!!$value->id!!}');" id="status_{{$value->id}}" class="badge {{$class}} me-1">{{$label}}</a>

                               	<input type="hidden" id="status_value_{{$value->id}}" value="{!!$value->status!!}" />

                            </td>

                            <td><a href="javascript:void(0);" onclick="deleteData('college_images','{{ $value->id }}');" title="Delete">

                                  Delete

                               </a></td>

                            <td>{{ date("F jS, Y h:i A",strtotime($value->created_at)); }}</td> 

                            </tr>

                            @endforeach

                            </tbody>

                         </table>

                      </div>

                      @endif 

                   </div>

                </div>
                
                <div class="tab-pane fade" id="form-tabs-cut-off" role="tabpanel">

                    <div class="row g-2">
                    
                    <div>GEN</div>
                      <div class="col-md-4">

                        <label class="form-label" for="title">Boys</label>

                        <input type="text" class="form-control" placeholder="GEN" maxlength="7" name="gen_boys" id="gen_boys" value="{{$record->gen_boys}}">

                      </div>

                       <div class="col-md-4">

                        <label class="form-label" for="title">Girls</label>

                        <input type="text" class="form-control" placeholder="GEN" maxlength="7" name="gen_girls" id="gen_girls" value="{{$record->gen_girls}}">

                      </div>
                      
                      <div>OBC</div>
                      <div class="col-md-4">

                        <label class="form-label" for="title">Boys</label>

                        <input type="text" class="form-control" placeholder="OBC" maxlength="7" name="obc_boys" id="obc_boys" value="{{$record->obc_boys}}">

                      </div>

                       <div class="col-md-4">

                        <label class="form-label" for="title">Girls</label>

                        <input type="text" class="form-control" placeholder="OBC" maxlength="7" name="obc_girls" id="obc_girls" value="{{$record->obc_girls}}">

                      </div>
                      
                      <div>EWS</div>
                      <div class="col-md-4">

                        <label class="form-label" for="title">Boys</label>

                        <input type="text" class="form-control" placeholder="EWS" name="ews_boys" id="ews_boys" value="{{$record->ews_boys}}">

                      </div>

                       <div class="col-md-4">

                        <label class="form-label" for="title">Girls</label>

                        <input type="text" class="form-control" placeholder="EWS" maxlength="7" name="ews_girls" id="ews_girls" value="{{$record->ews_girls}}">

                      </div>
                      
                      <div>SC</div>
                      <div class="col-md-4">

                        <label class="form-label" for="title">Boys</label>

                        <input type="text" class="form-control" placeholder="SC" maxlength="7" name="sc_boys" id="sc_boys" value="{{$record->sc_boys}}">

                      </div>

                       <div class="col-md-4">

                        <label class="form-label" for="title">Girls</label>

                        <input type="text" class="form-control" placeholder="SC" maxlength="7" name="sc_girls" id="sc_girls" value="{{$record->sc_girls}}">

                      </div>
                      
                      <div>ST</div>
                      <div class="col-md-4">

                        <label class="form-label" for="title">Boys</label>

                        <input type="text" class="form-control" placeholder="ST" maxlength="7" name="st_boys" id="st_boys" value="{{$record->st_boys}}">

                      </div>

                       <div class="col-md-4">

                        <label class="form-label" for="title">Girls</label>

                        <input type="text" class="form-control" placeholder="ST" maxlength="7" name="st_girls" id="st_girls" value="{{$record->st_girls}}">

                      </div>
                      
                      <div>MBC</div>
                      <div class="col-md-4">

                        <label class="form-label" for="title">Boys</label>

                        <input type="text" class="form-control" placeholder="MBC" maxlength="7" name="mbc_boys" id="mbc_boys" value="{{$record->mbc_boys}}">

                      </div>

                       <div class="col-md-4">

                        <label class="form-label" for="title">Girls</label>

                        <input type="text" class="form-control" placeholder="MBC" maxlength="7" name="mbc_girls" id="mbc_girls" value="{{$record->mbc_girls}}">

                      </div>
                      
                      <div>SA</div>
                      <div class="col-md-4">

                        <label class="form-label" for="title">Boys</label>

                        <input type="text" class="form-control" placeholder="SA" maxlength="7" name="sa_boys" id="sa_boys" value="{{$record->sa_boys}}">

                      </div>

                       <div class="col-md-4">

                        <label class="form-label" for="title">Girls</label>

                        <input type="text" class="form-control" placeholder="SA" maxlength="7" name="sa_girls" id="sa_girls" value="{{$record->sa_girls}}">

                      </div>
                      
                    </div>

                  </div>

                  <div class="tab-pane fade" id="form-tabs-seo" role="tabpanel">

                    <div class="row g-2">

                      <div class="col-md-12">

                        <label class="form-label" for="title">SEO Title</label>

                        <input type="text" class="form-control" placeholder="Enter SEO Title" name="seo_title" id="seo_title" value="{{$record->seo_title}}">

                      </div>

                      <div class="col-md-6">

                        <label class="form-label" for="title">SEO  Description</label>

                        <textarea class="form-control" rows="6" placeholder="Enter SEO Description" name="seo_description" id="seo_description">{{$record->seo_description}}</textarea>

                      </div>

                      <div class="col-md-6">

                        <label class="form-label" for="title">SEO  Keywords</label>

                        <textarea class="form-control" rows="6" placeholder="Enter SEO Keywords" name="seo_keyword" id="seo_keyword">{{$record->seo_keyword}}</textarea>

                      </div>
                      
                      <div class="col-md-12">
                        <label class="form-label" for="title">Schema Text</label>
                        <textarea id="schema_tags" name="schema_tags" rows="4" class="form-control">{{$record->schema_tags}}</textarea>
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="title">Canonical Tag</label>
                        <textarea id="canonical_tags" name="canonical_tags" class="form-control">{{$record->canonical_tags}}</textarea>
                      </div>

                      <div class="col-md-6">

                        <label class="form-label" for="title">SEO  Robots</label>

                        <select id="robot_tags" name="robot_tags" value="index,nofollow" class="form-select">

                          <option {{$record->robot_tags == 'index,follow'?'selected':''}} value="index,follow">index,follow</option>

                          <option {{$record->robot_tags == 'index,nofollow'?'selected':''}} value="index,nofollow">index,nofollow</option>

                          <option {{$record->robot_tags == 'noindex,follow'?'selected':''}} value="noindex,follow">noindex,follow</option>

                          <option {{$record->robot_tags == 'noindex,nofollow'?'selected':''}} value="noindex,nofollow">noindex,nofollow</option>

                        </select>

                      </div>

                    </div>

                  </div>
                  
                  <div class="tab-pane fade" id="form-tabs-ranks" role="tabpanel">					
                    <div>RANKS</div>
                    @if(isset($college_ranks) && $college_ranks->count() > 0)
                    	@foreach($college_ranks as $key => $crank)
                        
                        	<div class="row g-2 mt-2" id="coll_rank_id{{$crank->id}}">
                              <div class="col-md-2">
                              	<input type="hidden" name="edit_rank_id[]" value="{{$crank->id}}"/>
                                <select name="edit_college_category_id[]" class="form-select">
                                    <option value="">Select Category</option>
                                    @if(isset($college_categories) && $college_categories->count()>0)
                                        @foreach($college_categories as $ekey => $eccat)
                                            <option {{$ekey == $crank->college_category_id?'selected':''}} value="{{$ekey}}">{{$eccat}}</option>
                                        @endforeach
                                    @endif
                                </select>
                              </div>
                              <div class="col-md-2">
                                <select name="edit_college_subcategory_id[]" class="form-select">
                                    <option value="">Select Sub Category</option>
                                    @if(isset($college_sub_categories) && $college_sub_categories->count()>0)
                                        @foreach($college_sub_categories as $ekey => $ecscat)
                                            <option {{$ekey == $crank->sub_category_id?'selected':''}} value="{{$ekey}}">{{$ecscat}}</option>
                                        @endforeach
                                    @endif
                                </select>
                              </div>
                              <div class="col-md-2">
                                <select name="edit_college_localarea_id[]" class="form-select">
                                    <option value="">Select Local Area</option>
                                    @if(isset($college_localareas) && $college_localareas->count()>0)
                                        @foreach($college_localareas as $key => $clarea)
                                            <option {{$key == $crank->local_area_id?'selected':''}} value="{{$key}}">{{$clarea}}</option>
                                        @endforeach
                                    @endif
                                </select>
                              </div>
                               <div class="col-md-1">
                                <input type="text" class="form-control" placeholder="Rank" name="edit_rank[]" id="rank" value="{{$crank->rank}}">
                              </div>
                              <div class="col-md-1">
                                <input type="text" class="form-control" placeholder="Male Rank" name="edit_male_rank[]" id="edit_male_rank" value="{{$crank->male_rank}}">
                              </div>
                              <div class="col-md-1">
                                <input type="text" class="form-control" placeholder="Female Rank" name="edit_female_rank[]" id="edit_female_rank" value="{{$crank->female_rank}}">
                              </div>                   
                              <div class="col-md-2">
                                <button type="button" class="btn btn-danger" onclick="deleteData('college_ranks','{{ $crank->id }}');">Remove</button>
                              </div>                       
                            </div>
                        
                        @endforeach
                    @endif
                    <div class="row g-2 mt-2">                    
                      <div class="col-md-2">                        
                        <select name="college_category_id[]" class="form-select">
                        	<option value="">Select Category</option>
                            @if(isset($college_categories) && $college_categories->count()>0)
                            	@foreach($college_categories as $key => $ccat)
                                	<option value="{{$key}}">{{$ccat}}</option>
                                @endforeach
                            @endif
                        </select>
                      </div>
                      <div class="col-md-2">
                        <select name="college_subcategory_id[]" class="form-select">
                            <option value="">Select Sub Category</option>
                            @if(isset($college_sub_categories) && $college_sub_categories->count()>0)
                                @foreach($college_sub_categories as $key => $cscat)
                                    <option value="{{$key}}">{{$cscat}}</option>
                                @endforeach
                            @endif
                        </select>
                      </div>
                      <div class="col-md-2">
                        <select name="college_localarea_id[]" class="form-select">
                            <option value="">Select Local Area</option>
                            @if(isset($college_localareas) && $college_localareas->count()>0)
                                @foreach($college_localareas as $key => $clarea)
                                    <option value="{{$key}}">{{$clarea}}</option>
                                @endforeach
                            @endif
                        </select>
                      </div> 
                      <div class="col-md-1">
                        <input type="text" class="form-control" placeholder="Rank" name="rank[]" id="rank" value="">
                      </div>                       
                      <div class="col-md-1">
                        <input type="text" class="form-control" placeholder="Male Rank" name="male_rank[]" id="male_rank" value="">
                      </div>
                      <div class="col-md-1">
                        <input type="text" class="form-control" placeholder="Female Rank" name="female_rank[]" id="female_rank" value="">
                      </div>              
                      <div class="col-md-2">
                        <button type="button" class="btn btn-warning" onclick="addMore()">Add More</button>
                      </div>                       
                    </div>                    
                    <div id="replaceHtmlRank"></div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>        

      </div>
      <div class="row">
      <div class="col-12 col-md-12">

          <div class="card mb-6">

            <div class="card-body">

              <div style="float:right">

                <button  type="button" id="submitBtn" class="btn btn-primary me-4 submitBtn">Submit</button>

                <button type="reset" onclick="window.location.href='{{route('admin.colleges')}}'" class="btn btn-label-secondary" >Cancel</button>

              </div>

            </div>

          </div>

        </div>
      </div>

    </div>

  </div>

</div>


<script type="text/javascript">
function filterData(){
	$('#coll_rank_id'+rowID).remove();
}

function addMore(){
	$.ajax({
		type: 'POST',
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		url: "{{url('/panel/get-college-category')}}",
		success: function(response){
			$('#replaceHtmlRank').append(response);
		}
	});
	return false;	
}

function remove(row){
	$('#row_'+row).remove();
}

function getState(countryId){
	if(countryId != ''){
		$.ajax({
			type: 'POST',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: "{{url('/panel/get-state')}}",
			data: {countryId:countryId},				
			success: function(response){
				$('#state').html(response);
			}
		});
		return false;
	}
}

$(document).ready(function () {

	$('.numberonly').keypress(function(e){

		var charCode = (e.which) ? e.which : event.keyCode

		if(String.fromCharCode(charCode).match(/[^0-9+]/g))

		return false;

	});

});

var addUrl = "{{url('/panel/edit-college/')}}/{{$record->id}}";

$(document).ready(function(){

	$('.submitBtn').click(function(e){

		$('.submitBtn').html('Processing...');

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

				$('.submitBtn').html('Submit');

				var obj = JSON.parse(response);

				 if(obj['heading'] == "Success"){

					swal("", obj['msg'], "success").then((value) => {

						window.location.href = "";

					});

				}else{

					swal("Error!", obj['msg'], "error");

					return false;

				}

			},error: function(ts) {

				$('#submitBtn').html('Submit');

				swal("Error!", 'Something went wrong, please try after sometime.', "error");

				return false;

			}

		}); 

    });

});


function filterData(){

	$("#replaceHtml").load(location.href + " #replaceHtml");

}


$('#my-awesome-dropzone').attr('class', 'dropzone');

var myDropzone = new Dropzone('#my-awesome-dropzone', {

	url: "{{url('panel/upload-college-images')}}",

	clickable: true,

	method: 'POST',

	maxFiles: 50,

	parallelUploads: 50,

	maxFilesize: 20,

	addRemoveLinks: false,

	dictRemoveFile: 'Remove',

	dictCancelUpload: 'Cancel',

	dictCancelUploadConfirmation: 'Confirm cancel?',

	dictDefaultMessage: 'Drop files here to upload',

	dictFallbackMessage: 'Your browser does not support drag n drop file uploads',

	dictFallbackText: 'Please use the fallback form below to upload your files like in the olden days',

	paramName: 'file',

	params: {'id':'{{$record->id}}'},

	forceFallback: false,

	createImageThumbnails: true,

	maxThumbnailFilesize: 5,

	//acceptedFiles: ".jpeg,.jpg,.webp,.png,.svg",

	acceptedFiles: "image/*",

	autoProcessQueue: true,

	headers:{

		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

	},

	init: function(){

		this.on('thumbnail', function(file){

			if(file.width < 50 || file.height < 50){

				//file.rejectDimensions();

				file.acceptDimensions();

			}else{

				file.acceptDimensions();

			}

		});

	},

	accept: function(file, done){

		file.acceptDimensions = done;

		file.rejectDimensions = function() {

			done('The image must be at least 50 x 50px')

		};

	}

});


myDropzone.on("complete", function(file){

	var status = file.status;

	if(status == 'success'){



	}

	console.log(file);

});


var count = 1;

myDropzone.on("success", function(file, responseText){

	var fnamenew = file.name;

	var fname = fnamenew.trim().replace(/["~!@#$%^&*\(\)_+=`{}\[\]\|\\:;'<>,.\/?"\- \t\r\n]+/g, '');

	$("#productsimgall").append('<input type="hidden" name="image[]" class="img_eng" id="img_eng' + fname + '" value="' + responseText + '">');



	count++;

});


myDropzone.on("removedfile", function(file){

	var fname = file.name;

	fname2 = fname.trim().replace(/["~!@#$%^&*\(\)_+=`{}\[\]\|\\:;'<>,.\/?"\- \t\r\n]+/g, '_');    

	var image = $('#img_eng'+fname2).val();

	$.ajax({

		url: "{{url('admins/upload-wedding-images')}}",

		type:'POST',

		data:{imgname:image}, 

		success:function (success){

			$(this).parents('li').remove();

			$("#productsimgall #img_eng" + fname2 + "").replaceWith('');   

		}

	});	

	return false; 

});


myDropzone.on("addedfile", function(file){
	
});

</script> 

@endsection