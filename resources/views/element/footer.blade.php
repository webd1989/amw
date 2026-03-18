@php
	$colleges_records = getCountriesOfCollege();
    $collegePages = getCollegePages();
@endphp
<footer class="footer footer-main wow fadeInUp">
  <div class="container">
    <div class="row g-3">
           <div class="col-lg-3 col-md-6">
              <div class="footer-links">
                  <h4 class="text-white mb-4"> Study MBBS</h4>
                  <ul class="foot-link">
                  @foreach($collegePages as $key => $collegePage)
                      <li><a href="https://amwcareerpoint.com/{{$collegePage->slug}}">{{$collegePage->title}}</a></li>
                      
                      @if(($key+1)%6 == 0)
                        </ul>
                        </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                        <div class="footer-links">
                        <h4 class="text-white h-46 h-46-tab-frist fs-0"> </h4>
                        <ul class="foot-link">
                      @endif
                      
                  @endforeach
                  </ul>
                </div>
              </div>              
        </div>
          
    <hr class="my-4 my-md-5"/>
    <div class="row g-3">
           <div class="col-lg-3 col-md-6">
              <div class="footer-links">
                  <h4 class="text-white mb-4"> Top Universities</h4>
                  <ul class="foot-link">
                  @foreach($colleges_records as $key => $country)
                      <li><a href="{{url('country-colleges')}}/{{$country['title']}}">Top University in {{$country['title']}}</a></li>
                      
                      @if(($key+1)%19 == 0)
                        </ul>
                        </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                        <div class="footer-links">
                        <h4 class="text-white h-46 h-46-tab-frist fs-0"> </h4>
                        <ul class="foot-link">
                      @endif
                      
                  @endforeach
                  </ul>
                </div>
              </div>              
        </div>
          
    <hr class="my-4 my-md-5"/>
    <div class="row justify-content-between wow fadeInUp">
      <div class="col-lg-4 col-md-6 mb-4 wow fadeInUp">
        <div class="foot-about">
          <div class="footer-logo"> <img src="{{ asset('public/img/logo.svg') }}" width="150px"/> </div>
          <p class="py-4">{{nl2br($setting->footer_info)}}</p>
        </div>
        <div class="foot-social">
          <h4 class="text-white fw-bold mb-3 mb-md-4">Follow Us</h4>
          <div class="social-media-icons">
            <ul>
              <li class="cta-button"><a href="https://www.instagram.com/amwcarrierpoint_official/" class="social-icon-bg "><img src="{{$siteUrl}}public/img/insta.svg"/></a></li>
              <li class="cta-button"><a href="https://www.facebook.com/Amwcarrierpoint/" class="social-icon-bg "><img src="{{$siteUrl}}public/img/facebook.svg"/></a></li>
              <li class="cta-button"><a href="https://www.youtube.com/@amwcarrierpoint368" class="social-icon-bg "><img style="background:#fff;padding:9px;border-radius:35px;width:42px;" src="{{$siteUrl}}public/img/youtube-svgrepo-com.svg"/></a></li>
              <?php /*?><li class="cta-button"><a href="#" class="social-icon-bg "><img src="{{$siteUrl}}public/img/x.svg"/></a></li>
              <li class="cta-button"><a href="#" class="social-icon-bg "><img src="{{$siteUrl}}public/img/linkedin.svg"/></a></li><?php */?>
              <?php /*?><li class="cta-button"><a href="#" class="social-icon-bg "><img src="{{$siteUrl}}public/img/whatsapp_foot.svg"/></a></li><?php */?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
        <div class="row g-3">
          <div class="col-6 wow fadeInUp">
            <div class="footer-links">
              <h4 class="text-white mb-3 mb-md-4">Quick Links</h4>
              <ul class="foot-link">
                <li class="active"><a href="{{route('pages.index')}}">Home</a></li>
                <li><a href="{{route('pages.predictors')}}">Predictors</a></li>
                <li><a href="{{route('pages.colleges')}}">College</a></li>
                <li><a href="{{route('pages.blogs')}}">Blogs</a></li>
                <li><a href="{{route('pages.contact-us')}}">Contact Us</a></li>
                <li><a href="{{route('pages.packages')}}">Package</a></li>
              </ul>
            </div>
          </div>
          <div class="col-6 wow fadeInUp">
            <div class="footer-links">
              <h4 class="text-white mb-3 mb-md-4">Informations</h4>
              <ul class="foot-link">
                <?php /*?><li class="active"><a href="{{route('pages.tutorials')}}">Tutorials</a></li>
                <li><a href="{{route('pages.documentation')}}">Documentation</a></li><?php */?>
                <li class="active"><a href="{{route('pages.privacy-policy')}}">Privacy Policy</a></li>
                <li><a href="{{route('pages.faqs')}}">FAQs</a></li>
                <li><a href="{{route('pages.support')}}">Support</a></li>
                <li><a href="{{route('pages.sitemap')}}">Sitemap</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 wow fadeInUp">
        <div class="footer-links mb-5">
          <h4 class="text-white mb-4">News Letter</h4>
          <div class="newsletter-form">
            <form class="d-flex align-items-center">
              <input type="email" class="form-control newsletter-from" id="newsletter_email" name="newsletter_email" style="color: var(--white);" placeholder="Enter your email "/>
              <button type="button" id="newsletter_email_btn" class="btn btn-primary subs-btn">Subscribe</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <hr>
  </div>
  <div class="footer-bottom pb-3 wow fadeInUp">
    <div class="container">
      <div class="text-center justify-content-between d-flex">
        <p class="text-center copytirytext w-100">{{$setting->footer_content}}</p>
      </div>
    </div>
  </div>
</footer>

<!------d-none d-md-block----->
<div class="d-none d-md-block">
<a title="Whatsapp" href="https://api.whatsapp.com/send?phone=9929299268" class="whats-app" target="_blank"></a>
<div>
<style>
.whats-app {
	position: fixed;
    width: 53px;
    height: 54px;
    bottom: 40px;
	background-image: url("{{ asset('public/images/icon/whatsapp.svg') }}");
    border-radius: 50px;
    text-align: center;
    z-index: 100;
    left: 25px;
	right: auto;
}

.my-float {
    margin-top: 16px;
}
</style>
</div>
@if($page_url == 'pages.index') 
@if(!isset($_COOKIE["home_modal"]))
<script>
if (window.innerWidth > 1024){
  // Wait 5 seconds (5000 milliseconds) after the page loads
  window.addEventListener('load', function(){
    setTimeout(function(){
      var myModal = new bootstrap.Modal(document.getElementById('autoModal'));
      myModal.show();
    }, 3000);
  });
}
</script>
@endif 
@endif 
<script type="text/javascript">	
	let newsletterFormURL = "{{url('/add-newsletter')}}";
	let login_url = "{{route('cutomers.customer-login')}}";
	let register_url = "{{route('cutomers.customer-registration')}}";
	let forgot_password_url = "{{route('customers.forgotPassword')}}";
</script> 
<script src="{{ asset('public/js/pages/login.js') }}"></script> 
<script>
    function switchTab(tabName) {
        // Hide all tab contents
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // Remove active class from all buttons
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Show selected tab content
        document.getElementById(tabName).classList.add('active');

        // Add active class to clicked button
        event.target.classList.add('active');
    }
	function closeModel(){
		$.ajax({
		   type: 'POST',
		   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		   url: "{{route('ajax.set-cookie')}}",
		   data:{},
		   success: function(msg){
			   
		   },error: function(ts){
			  formSubmitted = false;
			  swal("Error!", 'Something went wrong, please try after sometime.', "error");
			  return false;
		   }
		});
	}
</script> 

<!--Auto open popup model--> 
<!-- Modal -->
<div class="modal fade" id="autoModal" tabindex="-1" aria-labelledby="autoModalLabel" aria-hidden="true">
  <div class="modal-dialog position-relative auto_open_popup login-popup gradent-bg">
    <div class="modal-content">
      <button type="button" class="btn-close" onclick="closeModel();" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="need_prep_free_downlad">
        <div class="app-left-content">
          <div class="logo-comp"> <img src="{{ asset('public/img/logo.svg') }}"/> </div>
          <div class="popup-content-app">
            <h2 style="font-size:13px !important;" class="my-2">Find the Right Medical College. Not Just Any College. <br /> <span class="orange-text">Government, Private & Abroad MBBS Admissions with Expert Guidance</span> </h2>
            <ul class="crack_point_box">
              <li><i class="bi bi-check-circle-fill" style="color: #38BCEF;"></i> College Predictor Tool
Check your MBBS admission chances based on NEET rank, category & budget</li>
              <li><i class="bi bi-check-circle-fill" style="color: #38BCEF;"></i> Govt, Private & Abroad Options
Explore verified medical colleges across India & abroad</li>
              <li><i class="bi bi-check-circle-fill" style="color: #38BCEF;"></i> Expert Counselling Support
One-to-one guidance from experienced medical admission counsellors</li>
              <li><i class="bi bi-check-circle-fill" style="color: #38BCEF;"></i> Transparent & Ethical Process
No fake promises. No hidden charges. Complete clarity at every step</li>
              <li><i class="bi bi-check-circle-fill" style="color: #38BCEF;"></i> Free Initial Consultation
Talk to an expert before taking any admission decision</li>
            </ul>
            <!--<div class="app-downlaod-section"> <a href="#"><img src="{{ asset('public/img/app_download_pupup/google_play.png') }}"/></a> <a href="#"><img src="{{ asset('public/img/app_download_pupup/app_store.png') }}"/></a> </div>-->
            <!--<p>Download the AMW Career Point App now and enjoy a <a href="#" class="read-more">7-Day Free Trial!</a></p>-->
            <div class="call-us-btn"> <a class="btn btn-sm btn-outline-warning mt-1 mb-4 w-100" href="{{ route('pages.contact-us') }}">Contact Us</a> </div>
          </div>
        </div>
        <div class="app_big_img"> <img src="{{ asset('public/img/app_download_pupup/amw_app_img.png') }}"/> </div>
      </div>
    </div>
  </div>
</div>

<!--Modelbox section end here-->