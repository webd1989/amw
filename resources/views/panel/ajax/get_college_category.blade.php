<div class="row g-2 mt-2" id="row_{{$rand}}">                    
  <div class="col-md-2">                        
    <select name="college_category_id[]" class="form-select">
        <option value="">Select Category</option>
        @if(isset($ccategories) && $ccategories->count()>0)
            @foreach($ccategories as $key => $ccat)
                <option value="{{$key}}">{{$ccat}}</option>
            @endforeach
        @endif
    </select>
  </div>
  <div class="col-md-2">
    <select name="college_subcategory_id[]" class="form-select">
        <option value="">Select Sub Category</option>
        @if(isset($cscategories) && $cscategories->count()>0)
            @foreach($cscategories as $key => $ccat)
                <option value="{{$key}}">{{$ccat}}</option>
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
    <button type="button" class="btn btn-danger" onclick="remove('{{$rand}}')">Remove</button>
  </div>                       
</div>

@php
	die;
@endphp