<div class="contact-us-section new-contact-us-section py-100 wow fadeInUp">
    <div class="container">
      <div class="contact-us-full-page">
         <div class="row g-4 align-items-center justify-content-between">
            <div class="col-md-6 wow fadeInUp">
                <div class="contact-us-left-info">
                  <h3 class="font-bold mb-4">Why Consult With Us?</h3>
                  <div class="consult-list-box">
                     <ul>
                        <li>
                           <i class="bi bi-check2"></i>
                           <span class="text-white">15+ years of experience in medical education counseling</span>
                        </li>
                         <li>
                           <i class="bi bi-check2"></i>
                           <span class="text-white">5000+ students successfully guided</span>
                        </li>
                         <li>
                           <i class="bi bi-check2"></i>
                           <span class="text-white">50+ partner universities worldwide</span>
                        </li>
                         <li>
                           <i class="bi bi-check2"></i>
                           <span class="text-white">Free initial consultation with no obligation</span>
                        </li>
                     </ul>
                  </div>
                </div>
            </div>

            <div class="col-md-6 mt-0">
               <div class="inquery-form form-card">
                  <h4 class="mb-3">Enquiry Now</h4>
                  <form class="form-fields" id="enquiry-form2" method="post">
                    <input type="text" placeholder="Enter Your Name" name="cname" class="form-input"/>
                    <input type="email" placeholder="Email Address" name="cemail" class="form-input"/>
                    <input type="tel" placeholder="Phone No." name="ccontact" maxlength="10" class="form-input numberonly"/>
                    <textarea placeholder="Message" class="form-input form-textarea" name="cmessage"></textarea>
                    <button type="button" class="btn btn-primary cta-button enquiry_btn" id="form2_btn">Submit</button>
                 </form>
               </div>
            </div>

         </div>
      </div>
       
    </div>
</div>

<script type="text/javascript">
	$(document).on('click','#form2_btn',function(){
		sendEnquiry('enquiry-form2');
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