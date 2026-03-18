@php
$action =  Route::getCurrentRoute()->getName();
$admin_type = Session::get('admin_type'); 
$admin_id = Session::get('admin_id');    
$PREV = Session::get('PREV');
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu">
  <div class="app-brand demo"> 
  <a href="{{route('admin.dashboard')}}" class="app-brand-link"> 
  <span class="app-brand-logo demo"> 
  <span class="text-primary"> 
	<img src="{{ asset('public/img/logo.svg') }}" class="img-responsive" width="170px"/>
  <?php /*?><svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="currentColor" />
	
	<path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
				
	<path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
	
	<path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="currentColor" />
	
    </svg> <?php */?>
    </span> 
    </span> 
    <?php /*?><span class="app-brand-text demo menu-text fw-bold ms-3">AMW</span><?php */?> 
    </a> 
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto"> <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i> <i class="icon-base ti tabler-x d-block d-xl-none"></i> </a> 
    </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
    <!-- Dashboards -->
    
    <li class="menu-item active"> 
    	<a href="{{route('admin.dashboard')}}" class="menu-link"> 
        <i class="menu-icon icon-base ti tabler-smart-home"></i>
      	<div data-i18n="Dashboards">Dashboards</div>
      	</a>
    </li>
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-users"></i>
      <div data-i18n="Users">Users</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.users')}}" class="menu-link">  
            <div data-i18n="Users">Users</div>    
          </a>    
        </li>
        <li class="menu-item">    
          <a href="{{route('admin.employees')}}" class="menu-link">  
            <div data-i18n="Employee">Employee</div>    
          </a>    
        </li>
      </ul>
    </li>
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-clipboard"></i>
      <div data-i18n="General">General</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.inner-pages')}}" class="menu-link">  
            <div data-i18n="Inner Pages">Inner Pages</div>    
          </a>    
        </li>
        <li class="menu-item">    
          <a href="{{route('admin.country-pages')}}" class="menu-link">  
            <div data-i18n="Country Pages">Country Pages</div>    
          </a>    
        </li>
        <li class="menu-item">    
          <a href="{{route('admin.enquiries')}}" class="menu-link">  
            <div data-i18n="Enquiries">Enquiries</div>    
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-building"></i>
      <div data-i18n="Colleges">Colleges</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.colleges')}}" class="menu-link">  
            <div data-i18n="Colleges">Colleges</div>    
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-map"></i>
      <div data-i18n="Locations">Locations</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.countries')}}" class="menu-link">  
            <div data-i18n="Countries">Countries</div>    
          </a>    
        </li>
        <li class="menu-item">    
          <a href="{{route('admin.states')}}" class="menu-link">  
            <div data-i18n="States">States</div>    
          </a>    
        </li>
        <li class="menu-item">    
          <a href="{{route('admin.locations')}}" class="menu-link">  
            <div data-i18n="Our Locations">Our Locations</div>    
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-receipt-rupee"></i>
      <div data-i18n="Plans">Plans</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.plans')}}" class="menu-link">
            <div data-i18n="Plans">Plans</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-truck"></i>
      <div data-i18n="Orders">Orders</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.orders')}}" class="menu-link">
            <div data-i18n="Orders">Orders</div>
          </a>    
        </li>
        <li class="menu-item">    
          <a href="{{route('admin.predictors')}}" class="menu-link">
            <div data-i18n="Predictors">Predictors</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-article"></i>
      <div data-i18n="Blogs">Blogs</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.blogs')}}" class="menu-link">
            <div data-i18n="Blogs">Blogs</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-message"></i>
      <div data-i18n="Testimonials">Testimonials</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.testimonials')}}" class="menu-link">
            <div data-i18n="Testimonials">Testimonials</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-video"></i>
      <div data-i18n="Videos">Videos</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.videos')}}" class="menu-link">
            <div data-i18n="Videos">Videos</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-file-text"></i>
      <div data-i18n="Brochures">Brochures</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.brochures')}}" class="menu-link">
            <div data-i18n="Brochures">Brochures</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-file-text"></i>
      <div data-i18n="Category">Category</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.college-categories')}}" class="menu-link">
            <div data-i18n="College Category">College Category</div>
          </a>    
        </li>
        <li class="menu-item">    
          <a href="{{route('admin.college-sub-categories')}}" class="menu-link">
            <div data-i18n="College Sub Category">College Sub Category</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    @if($admin_type == 'Admin' || $admin_type == 'Account')
    
    <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-help"></i>
      <div data-i18n="Faqs">Faqs</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">    
          <a href="{{route('admin.faqs')}}" class="menu-link">
            <div data-i18n="Faqs">Faqs</div>
          </a>    
        </li>
      </ul>
    </li>   
        
    @endif
    
    
    
    @if($admin_type == 'Employee')
            
        @if(getPermission($admin_id,1) || getPermission($admin_id,2) || getPermission($admin_id,3))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-clipboard"></i>
          <div data-i18n="General">General</div>
          </a>
          <ul class="menu-sub">
          	@if(getPermission($admin_id,1))
            <li class="menu-item">             	   
              <a href="{{route('admin.inner-pages')}}" class="menu-link">  
                <div data-i18n="Inner Pages">Inner Pages</div>    
              </a>    
            </li>
            @endif
            @if(getPermission($admin_id,2))
            <li class="menu-item">    
              <a href="{{route('admin.country-pages')}}" class="menu-link">  
                <div data-i18n="Country Pages">Country Pages</div>    
              </a>    
            </li>
            @endif
            @if(getPermission($admin_id,3))
            <li class="menu-item">    
              <a href="{{route('admin.enquiries')}}" class="menu-link">  
                <div data-i18n="Enquiries">Enquiries</div>    
              </a>    
            </li>
            @endif
          </ul>
        </li>
        @endif
           
        @if(getPermission($admin_id,4))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-building"></i>
          <div data-i18n="Colleges">Colleges</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.colleges')}}" class="menu-link">  
                <div data-i18n="Colleges">Colleges</div>    
              </a>    
            </li>
          </ul>
        </li>  
        @endif 
            
        @if(getPermission($admin_id,5))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-map"></i>
          <div data-i18n="Locations">Locations</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.locations')}}" class="menu-link">  
                <div data-i18n="Our Locations">Our Locations</div>    
              </a>    
            </li>
          </ul>
        </li>
        @endif
    	
        @if(getPermission($admin_id,6))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-receipt-rupee"></i>
          <div data-i18n="Plans">Plans</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.plans')}}" class="menu-link">
                <div data-i18n="Plans">Plans</div>
              </a>    
            </li>
          </ul>
        </li>
        @endif
        
        @if(getPermission($admin_id,7))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-article"></i>
          <div data-i18n="Blogs">Blogs</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.blogs')}}" class="menu-link">
                <div data-i18n="Blogs">Blogs</div>
              </a>    
            </li>
          </ul>
        </li>
        @endif
    
        @if(getPermission($admin_id,8))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-message"></i>
          <div data-i18n="Testimonials">Testimonials</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.testimonials')}}" class="menu-link">
                <div data-i18n="Testimonials">Testimonials</div>
              </a>    
            </li>
          </ul>
        </li>
        @endif
    
       	@if(getPermission($admin_id,9))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-video"></i>
          <div data-i18n="Videos">Videos</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.videos')}}" class="menu-link">
                <div data-i18n="Videos">Videos</div>
              </a>    
            </li>
          </ul>
        </li>
        @endif
            
    	@if(getPermission($admin_id,10))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-file-text"></i>
          <div data-i18n="Brochures">Brochures</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.brochures')}}" class="menu-link">
                <div data-i18n="Brochures">Brochures</div>
              </a>    
            </li>
          </ul>
        </li>  
        @endif 
            
    	@if(getPermission($admin_id,11) || getPermission($admin_id,12))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-file-text"></i>
          <div data-i18n="Category">Category</div>
          </a>
          <ul class="menu-sub">
          	@if(getPermission($admin_id,11))
            <li class="menu-item">    
              <a href="{{route('admin.college-categories')}}" class="menu-link">
                <div data-i18n="College Category">College Category</div>
              </a>    
            </li>
            @endif
            @if(getPermission($admin_id,12))
            <li class="menu-item">    
              <a href="{{route('admin.college-sub-categories')}}" class="menu-link">
                <div data-i18n="College Sub Category">College Sub Category</div>
              </a>    
            </li>
            @endif
          </ul>
        </li>
        @endif    
        
        @if(getPermission($admin_id,13))
        <li class="menu-item"> <a href="javascript:void(0);" class="menu-link menu-toggle"> <i class="menu-icon icon-base ti tabler-help"></i>
          <div data-i18n="Faqs">Faqs</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">    
              <a href="{{route('admin.faqs')}}" class="menu-link">
                <div data-i18n="Faqs">Faqs</div>
              </a>    
            </li>
          </ul>
        </li>
        @endif    
    
    @endif

  </ul>
</aside>