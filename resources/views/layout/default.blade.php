@php
$siteUrl = env('APP_URL');
$page_url = request()->route()->getName();
$setting = getDetails('settings',1);
@endphp

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="google-site-verification" content="Dmgabdp9aBldGRPm5yVdr-iNszejkOdwZgRe_0OulcU" />
    
    <title>@yield('title')</title>
    
    <meta name="description" content="@yield('description')">
    
    <meta name="keywords" content="@yield('keywords')">
    
    <meta name="robots" content="@yield('robots')" />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!--faviocn icon-->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/logo/favicon.png') }}">
 
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Main Theme Styles + Bootstrap -->
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">
    <?php /*?><link rel="stylesheet" href="{{ asset('public/css/bootstrap-icons.min.css') }}"><?php */?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('public/css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />  
    <!-- JS -->
    <script src="{{ asset('public/js/jquery-3.6.0.min.js') }}"></script>
    <link href="{{ asset('public/css/sweet-alert.css') }}" rel="stylesheet" />
    
    <!--Start of Tawk.to Script-->
	<script type="text/javascript">
    /*var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6912cb8c4e58c31958ef9899/1j9omm7p7';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();*/
    </script>
    <!--End of Tawk.to Script-->
    
    <!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-RPHK3ZK6S9"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-RPHK3ZK6S9');
    </script>
    
  </head>
  <body>
  
  	<style>
	.field_error {
		width: 100%;
		color: #a94442;
	}
	.desktop-none{ display:none}
	@media (max-width: 767.98px) {
    .mob-btn-bottom.desktop-none {
        position: fixed;
        bottom: 0px;
        right: 0;
        left: 0;
        z-index: 9;
        background: #E52DB7;
        box-shadow: black;
        padding-top: 0px;
        padding-bottom: 15px;
        box-shadow: 0px 2px 20px 0px rgba(0, 0, 0, 0.15);
    }
	    .desktop-none {
        display: block;
    }
	    .menu-bt-list {
        margin-bottom: 0;
        margin-top: 15px;
    }
	.menu-bt-list li a {
        display: flex;
        flex-direction: column;
        text-align: center;
        align-items: center;
        justify-content: center;
        gap: 5px;
        color: #fff;
    }
	span.home-icon2 {
    font-size: 24px;
}
}
	</style>
  
  	<div class="wrapper">
 
    <!--Desktop Header start here-->
    @include('element.header')

    <!--Desktop Header end here-->
    @yield('content')

    @include('element.footer')
    
    </div>   
    
    <div class="mob-btn-bottom desktop-none" bis_skin_checked="1">

    <ul class="d-flex menu-bt-list list-unstyled justify-content-between px-2">
      <li>
      <a class="text-center" href="{{url('/colleges')}}">
      <span class="home-icon2">
      <i class="bi bi-building"></i>
      </span>
      <span class="mob-link">Government</span>
      </a>
      </li>
      <li>
      <a class="text-center" href="{{url('/colleges')}}">
      <span class="home-icon2">
      <i class="bi bi-building"></i>
      </span>
      <span class="mob-link">Private</span>
      </a>
      </li>
      <li>
      <a class="text-center" href="{{url('/colleges')}}">
      <span class="home-icon2">
      <i class="bi bi-building"></i>
      </span>
      <span class="mob-link">Abroad</span>
      </a>
      </li>
      
      <li><a href="https://api.whatsapp.com/send?phone=9929299268" class="text-center"><span class="home-icon2"><i class="bi bi-whatsapp"></i></span><span class="mob-link">Contact</span></a></li>
    </ul>


</div>
     
    <div class="know-more">
        <a href="{{route('pages.predictors')}}" class="btn btn-knowmore">Know about your college</a>
    </div> 
    
    <script src="{{ asset('public/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('public/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/custom.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/js/sweet-alert.min.js') }}"></script>

  </body>
</html>