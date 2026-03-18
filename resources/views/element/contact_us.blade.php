<div class="inquery-form form-card">
 <h4 class="mb-3" id="page_heading">
 	@if($page_url == 'pages.index')
 		Enquiry Now
    @else
    	Get In Touch
    @endif
 </h4>
 <p class="mb-3">
 	Fill out the enquiry form below, and our team will connect with you shortly for a free career counselling session.
 </p>
  <form class="form-fields" id="inquiry-form">
        <input type="text" placeholder="Enter Your Name" name="cname" class="form-input"/>
        <input type="email" placeholder="Email Address" name="cemail" class="form-input"/>
        <input type="tel" placeholder="Phone No." name="ccontact" maxlength="10" class="form-input numberonly"/>
        <textarea placeholder="Message" class="form-input form-textarea" name="cmessage"></textarea>
        <button type="button" class="btn btn-primary cta-button enquiry_btn" id="form1_btn">Submit</button>                    
   </form>
</div>


<script type="text/javascript">
	$(document).on('click','#form1_btn',function(){
		sendEnquiry('inquiry-form');
	});
	function sendEnquiry(formid){
		let saveURL = "{{url('/save-inquiry')}}";
		$('.enquiry_btn').html('Processing...');
		$('.enquiry_btn').attr('disabled',true);
		formSubmitted = true;
		$.ajax({
		   type: 'POST',
		   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		   url: saveURL,
		   data: $('#'+formid).serialize(),
		   success: function(msg){
			  var obj = JSON.parse(msg);
			  formSubmitted = false;
			  if(obj['heading'] == "Success"){
				 swal("", obj['msg'], "success").then((value) => {
					$('#'+formid)[0].reset();
				 });
			  }else{
				 swal("Error!", obj['msg'], "error");        
			  }
			  $('.enquiry_btn').html('Submit');
			  $('.enquiry_btn').attr('disabled',false);
		   },error: function(ts){
			  formSubmitted = false;
			  swal("Error!", 'Something went wrong, please try after sometime.', "error");
			  return false;
		   }
		});
        return false;
	}
</script>