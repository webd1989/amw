<script>
let SiteUrl = "{{url('/')}}";
</script>
@php
	$all_categories = getAllRecords('categories');
    $collegePages = getCollegePages();
@endphp
<style>
.phone-no b {
    font-size: 16px;
}
.dropdown-menu.mega-menu {
	width: 800px;
	padding: 20px;
}
.dropdown-menu.mega-menu ul li{
	margin-bottom: 9px;
}
</style>
 
<header class="header">
  <!-- <div class="annousment_banner"><a href="{{url('/contact-us')}}"><img alt="" src="{{ asset('public/img/announcement.jpg') }}"/></a></div> -->
    <!--Main header start-->
    <div class="headertop">
      <nav class="navbar navbar-expand-lg py-2">
        <div class="container-fluid px-lg-4">
            <div class="logo-left d-flex align-items-center gap-2">
                <a class="navbar-brand comp-logo" href="{{route('pages.index')}}">
                    <img src="{{ asset('public/img/logo.svg') }}" class="img-fluid" alt="" title="">
                </a>
            </div>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
              <div class="d-flex align-items-center justify-content-between w-100">
                <div class="logo-mobile-seciton">
                  <img src="{{ asset('public/img/logo.svg') }}" class="img-fluid" alt="" title="">
                </div>
                <button type="button" class="btn-close-bl" data-bs-dismiss="offcanvas" aria-label="Close">
                  <img src="{{ asset('public/img/arrow-left_menu.svg') }}" alt="">
                </button>
              </div>
            </div>

            <div class="offcanvas-body">
              <ul class="menu_nav">
                <li><a href="{{route('pages.about-us')}}">About Us</a></li>
                <li><a href="{{route('pages.predictors')}}">Predictors</a></li>
                <li><a href="{{route('pages.colleges')}}">College</a></li>
                <li>
                    <div class="dropdown">
                      <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>
                      <ul class="dropdown-menu">
                        @if(isset($all_categories) && $all_categories->count()>0)
                            @foreach($all_categories as $key => $category)
                                <li><a class="dropdown-item" href="{{url('/blogs',$category->slug)}}">{{$category->title}}</a></li>	
                            @endforeach
                        @endif                    
                      </ul>
                    </div>
                  </li>
                  <li>
        <div class="dropdown mega-menu-dropdown">
            <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Study MBBS</a>
            <ul class="dropdown-menu mega-menu">
                <li>
                    <div class="row">
                        <div class="col-md-4">
                            <!--<h6>Column 1</h6>-->
                            <ul>
                            	@foreach($collegePages as $key => $collegePage)
                                <li><a href="https://amwcareerpoint.com/{{$collegePage->slug}}">{{$collegePage->title}}</a></li>
                                @if(($key+1)%10 == 0)
                                </ul>
                                </div>
                                <div class="col-md-4">
                                <!--<h6>Column 2</h6>-->
                                <ul>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                </li>
            </ul>
        </div>
    </li>
                  
                <li><a href="{{url('/contact-us')}}">Contact Us</a></li>
                @if(!session()->has('login_user_email'))
                  <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</a></li>              
                @else
                    <div class="dropdown">
                      <a class="btn btn-primary d-flex align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="">
                      @php
                        $uname = session()->get('login_user_name');
                        $expuname = explode(' ',$uname);
                        if(isset($expuname[0])){
                            $uname = $expuname[0];
                        }
                      @endphp
                      <span class="mob-none">{{$uname}}</span>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{url('/my-account')}}">Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{url('/change-password')}}">Change Password</a></li>
                        <li><a class="dropdown-item" href="{{url('/my-orders')}}">My Orders</a></li>
                        <li><a class="dropdown-item" href="{{url('/my-predictors')}}">My Predictors</a></li>
                        <li><a class="dropdown-item" href="{{url('/logout')}}">Logout</a></li>
                      </ul>
                    </div>
                @endif
              </ul>  
              <div class="get-in-touch-content mt-3">
                  <h6>Get in Touch</h6>
                  <p>{{$setting->business_address}}</p>
                  <p><b>Call Us:</b> +91-{{$setting->mobile}}</p>
                  <p><b>Email Us:</b> {{$setting->admin_email}}</p>
              </div>              
            </div>
         </div>

          <div class="call-us-btn">
            <div class="contact_us_list">
              <div class="whatsapp_icon"><a href="https://wa.me/{{$setting->whatsapp}}"><img src="{{ asset('public/img/whatsapp.svg') }}" alt="" title=""/></a></div> |
              <div class="phone_no-main">
                <a href="tel:{{$setting->mobile}}"><img src="{{ asset('public/img/phone_call.svg') }}" alt="" title=""/></a>
                <div class="phone-no"> <a href="tel:{{$setting->mobile}}"><b>+91-{{$setting->mobile}}</b></a>
                    <p>(Mon - Saturday | 10:00 AM - 06:00 PM)</p>
                  </div>
              </div>
            </div>
            <div class="call-text">
              <a href="{{route('pages.predictors')}}" class="btn btn-primary">Get Started</a>
            </div>
          </div>

          <button class="mob-view" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
            <img alt="" src="{{ asset('public/img/hemburger.svg') }}"/>
          </button>             

        </div>
      </nav>
    </div>
    <!--Main header end-->  
</header>

 @if(!session()->has('login_user_email'))
<!--Modelbox section stat here-->

  <!--Login model box-->
  <div class="modal fade" id="exampleModal" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog position-relative login-popup gradent-bg">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="login-form p-4">
                <div class="login-form">
                  <h4 class="mb-4 text-dark">Login</h4>
                    <form class="form-fields" id="customerLoginForm">
                    <div class="text-start-login">
                        <input type="email" placeholder="Email Or Phone Number" onkeyup="$('#email_loginError').remove();" class="form-input email_login" id="email_login" name="email_login"/>
                        </div>
                        <div class="password text-start-login">
                          <input type="password" placeholder="Password" class="form-input" onkeyup="$('#password_loginError').remove();" id="password_login" name="password_login"/>
                          <a href="#" class="eye-icon toggle-password"><i class="bi bi-eye text-dark"></i></a>
                        </div>
                        <div class="keep-loggned-in">
                          <div class="checkobx"><input type="checkbox" class="checkobx-icon"/> Keep me Logged in</div>
                          	<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" class="read-more">Forgot Password?</a>                          </div>
                        <button type="button" id="customer_login_btn" class="btn btn-primary cta-button px-5">Login</button>
                    </form>

                    <div class="orlignwith-social">
                      <div class="login-with-title">
                          Or Login With
                      </div>

                      <div class="socialmedia-box">
                        <a href="#" class="social-login-bg"><img alt="" src="{{ asset('public/img/loign_google.svg') }}"/></a>
                        <a href="#" class="social-login-bg"><img alt="" src="{{ asset('public/img/login_facebook.svg') }}"/></a>
                      </div>
                    </div>

                    <div class="donthave-account">
                      <p>Don't have an account? <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#registerUserModal" class="read-more">Create Account</a></p>
                    </div>
                </div>
          </div>
        </div>
      </div>
  </div>
  <!--Login model box end---->   
  
  <!--Login model box-->
  <div class="modal fade" id="registerUserModal" tabindex="1" aria-labelledby="registerUserModalLabel" aria-hidden="true">
      <div class="modal-dialog position-relative login-popup gradent-bg" style="max-height: 600px;">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="login-form p-4">
            <div class="login-form">            	
              <h4 class="mb-4 text-dark">Register</h4>
                <form id="customerRegistrationForm" class="form-fields" method="post">
                	<div class="text-start-input">
                    <input type="text" placeholder="Name" class="form-input cname" id="cname" onkeyup="$('#cnameError').remove();" name="cname"/>
                    </div>
                    <div class="text-start-input">
                    <input type="text" placeholder="Email Address" class="form-input cemail" onkeyup="$('#cemailError').remove();" id="cemail" name="cemail"/>
                    </div>
                    <div class="text-start-input">
                    <input type="number" placeholder="Mobile Number" class="form-input cmobile" onkeyup="$('#cmobileError').remove();" id="cmobile" name="cmobile"/>
                    </div>
                    <div class="text-start-input">
                      <input type="password" placeholder="Password" class="form-input password" onkeyup="$('#passwordError').remove();" id="password" name="password"/>                      
                    </div>
                    <div class="text-start-input">
                      <input type="password" placeholder="Confirm Password" class="form-input password_confirmation" onkeyup="$('#password_confirmationError').remove();" id="password_confirmation" name="password_confirmation"/>                      
                    </div>
                    <button type="button" id="add_customer_btn" class="btn btn-primary cta-button px-5">Submit</button>
                </form>
                	<div class="donthave-account">
                  	<p><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" class="read-more">Back To Login</a></p>
                </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <!--Login model box end---->
  
  <!-----forgot password  ------->
  	<div class="modal fade" id="forgotPasswordModal" tabindex="1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog position-relative login-popup gradent-bg" style="max-height: 600px;">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="login-form p-4">
            <div class="login-form">            	
              <h4 class="mb-4 text-dark">Forgot Password</h4>
                <form id="customerForgotPasswordForm" class="form-fields" method="post">
                	<div class="text-start-forgot">
                    <input type="email" placeholder="Email Address" class="form-input forgot_email" id="forgot_email" onkeyup="$('#forgot_emailError').remove();" name="forgot_email">
                    </div>
                    <button type="button" id="forgot_password_btn" class="btn btn-primary cta-button px-5">Send Email</button>
                </form>
                <div class="donthave-account">
                  	<p><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal" class="read-more">Back To Login</a></p>
                </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <!--------------------------->
@endif
  
<!--Modelbox section end here-->

<script>
	$(".toggle-password").click(function(){
		
		if($('#password_login').attr('type') == 'password'){
			$('#password_login').attr('type','text');
			$('.eye-icon').html('<i class="bi bi-eye-slash text-dark"></i>');
		}else{
			$('#password_login').attr('type','password');
			$('.eye-icon').html('<i class="bi bi-eye text-dark"></i>');
		}
		
	});
</script>