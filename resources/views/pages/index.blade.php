@extends('layout.default')
@if(isset($inner_page->id))
@section('title',strip_tags($inner_page->seo_title))
@section('description',strip_tags($inner_page->seo_description))
@section('keywords',strip_tags($inner_page->seo_keyword))
@section('robots',strip_tags($inner_page->robot_tags))
@endif
@section('content')

@php
$siteUrl = env('APP_URL');
$page_url = request()->route()->getName();
@endphp
{!! $inner_page->canonical_tags !!}
{!! $inner_page->schema_tags !!}
<style>
	.college-show{
		display: flex!important;
	}
	th {
    color: #000;
}
td {
    color: #000;
}
</style>

<div class="hero-section hero-new test-main">  
   <div class="container">
     <div class="row hero-banner-content align-items-center">
        <div class="col-lg-7 wow fadeInLeft">
         	<div class="left-content w-75">
            @if(isset($inner_page->id))
                <div class="badge">{!! $inner_page->title !!}</div>
                <h1 class="mb-4 mt-4"> {!! $inner_page->heading !!} <span class="orange-text">{!! $inner_page->sub_heading !!}</span></h1>
                <p class="mb-5">{!! $inner_page->description !!}</p>    
                <a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button">Use College Predictor</a>
               <a href="#" class="btn btn-outline-secondary"> Meet Our Experts </a>  
              
            @endif
            </div>
             <ul class="universities-recognised">
                  <li>NMC Approved Colleges </li>
                  <li>WHO Recognized Universities </li>
                  <li>15+ Years Experience </li>
                  <li>18,000+ Students Placed </li>
               </ul>
        </div>
        <!-- <div class="col-lg-2"></div> -->
        <div class="col-lg-5 wow fadeInRight">
           @include('element.contact_us')
        </div>
     </div>
   </div>
</div>

<div class="home-featured">
<div class="container">
  <ul class="row justify-content-center align-items-center row-cols-1 row-cols-sm-2 row-cols-md-3 text-center  w-75 mx-auto home-featured-list">
         
            <li class="col"><i class="fa fa-university me-2"></i> NMC Registered Consultancy</li>
            <li class="col"><i class="fa fa-earth-africa me-2"></i> WHO Recognized Partner</li>
            <li class="col"><i class="fa fa-grin-stars me-2"></i> 4.8/5 Google Rating</li>
            <li class="col"><i class="fa fa-home-user me-2"></i> 18,000+ Students Placed</li>
            <li class="col"><i class="fa fa-award me-2"></i> Best Consultancy Award 2024</li>
         
     </ul>
</div>
</div>

<div class="home-static fadeInUp">
   <div class="container">
      <div class="row gx-2">
         <div class="col-md-8  offset-md-2 text-center home-static-txt">
            <h2>These Numbers Speak of <span> Our Success Story</span></h2>
         </div>
         <div class="col-md-3">
            <div class="row align-items-center static-wrapper">
               <div class="col-4 static-img"><img src="https://www.instantassignmenthelp.com/templates/instantassignmenthelp/images/CA-1.png" alt="DELIVERED ORDERS"></div>
               <div class="col-8">
                  <h4>18,000+</h4>
                  <p>Students Placed
                  </p>
               </div>
            </div>
         </div>
           <!-- col-md-3 static-wrapper end -->
         <div class="col-md-3">
             <div class="row align-items-center static-wrapper">
                 <div class="col-4 static-img"><img src="https://www.instantassignmenthelp.com/templates/instantassignmenthelp/images/CA-1.png" alt="DELIVERED ORDERS"></div>
                 <div class="col-8"> 
                   <h4>60000+</h4>
                   <p>HAPPY CLIENTS</p>
               </div>
            </div>
         </div>
           <!-- col-md-3 static-wrapper end -->
         <div class="col-md-3">
              <div class="row align-items-center static-wrapper">
                 <div class="col-4 static-img"><img src="https://www.instantassignmenthelp.com/templates/instantassignmenthelp/images/CA-1.png" alt="DELIVERED ORDERS"></div>
                  <div class="col-8"> 
                     <h4>4.8/5</h4>
                     <p>CLIENT RATING</p>
                  </div>
            </div>
         </div>
           <!-- col-md-3 static-wrapper end -->
         <div class="col-md-3">
             <div class="row align-items-center static-wrapper">
                 <div class="col-4 static-img"><img src="https://www.instantassignmenthelp.com/templates/instantassignmenthelp/images/CA-1.png" alt="DELIVERED ORDERS"></div>
                   <div class="col-8">  
                     <h4>4500+</h4>
                     <p>PH.D. EXPERTS</p>
                  </div>
            </div>
         </div>
           <!-- col-md-3 static-wrapper end -->
      </div>
   </div>
</div> 
<!-- home-static end -->

<div class="home-counsellors">
   <div class="container">
      <div class="row">
         <div class="col-md-12 counsellors-title text-center">
            <p class="section-label">Expert Team</p>
            <h2 class="section-title">Meet Our Most <span>Qualified Counsellors!</span></h2>
            <p class="section-sub">Our expert counsellors have helped thousands of students secure MBBS seats across India and abroad.</p>
         </div>
      </div>

      <div class="row">
         <div class="col-md-4 counsellors-body">
            <div class="counsellors-wrapper">
               <div class="counsellor-profile d-flex align-items-center gap-3">
                  <div class="counsellor-avatar"><img src="https://leelagreenship.com/wp-content/uploads/2023/06/Chairman-Managing-Director.jpg" alt="dr"></div>
                   <div class="counsellor-info">  <p class="counsellor-name">Dr. Rajesh Sharma</p>
                    <p class="verified-badge">Verified Expert</p></div>
               </div>
                <div class="counsellors-rating">
                  <span class="star">
                        	                           <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                   </span>
                </div>
                <p class="counsellor-spec">MBBS (AIIMS Delhi), 12+ years guiding students for government medical admissions. Specialist in NEET counselling and state quota admissions.</p>
                 <div class="counsellor-stats d-flex align-items-center gap-3">
                     <div class="c-stat"><strong class="d-block">1,200+</strong>Students Guided</div>
                     <div class="c-stat"><strong class="d-block">5 Star</strong>Rating</div>
                </div> 
                <div class="counsellor-btns">
                  <button class="btn btn-primary">View Profile</button>
                  <button class="btn btn-outline-primary">Book Session</button>
               </div> 
            </div>
         </div>
           <!-- end counsellors-body -->
         <div class="col-md-4 counsellors-body">
            <div class="counsellors-wrapper">
               <div class="counsellor-profile d-flex align-items-center gap-3">
                  <div class="counsellor-avatar"><img src="https://leelagreenship.com/wp-content/uploads/2023/06/Chairman-Managing-Director.jpg" alt="dr"></div>
                   <div class="counsellor-info">  <p class="counsellor-name">Dr. Rajesh Sharma</p>
                    <p class="verified-badge">Verified Expert</p></div>
               </div>
                <div class="counsellors-rating">
                  <span class="star">
                        	                           <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                   </span>
                </div>
                <p class="counsellor-spec">MBBS (AIIMS Delhi), 12+ years guiding students for government medical admissions. Specialist in NEET counselling and state quota admissions.</p>
                 <div class="counsellor-stats d-flex align-items-center gap-3">
                     <div class="c-stat"><strong class="d-block">1,200+</strong>Students Guided</div>
                     <div class="c-stat"><strong class="d-block">5 Star</strong>Rating</div>
                </div> 
                <div class="counsellor-btns">
                  <button class="btn btn-primary">View Profile</button>
                  <button class="btn btn-outline-primary">Book Session</button>
               </div> 
            </div>
         </div>
           <!-- end counsellors-body -->
         <div class="col-md-4 counsellors-body">
            <div class="counsellors-wrapper">
               <div class="counsellor-profile d-flex align-items-center gap-3">
                  <div class="counsellor-avatar"><img src="https://leelagreenship.com/wp-content/uploads/2023/06/Chairman-Managing-Director.jpg" alt="dr"></div>
                   <div class="counsellor-info">  <p class="counsellor-name">Dr. Rajesh Sharma</p>
                    <p class="verified-badge">Verified Expert</p></div>
               </div>
                <div class="counsellors-rating">
                  <span class="star">
                        	                           <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                      <img src="https://amwcareerpoint.com/public/img/star.svg" alt="" title="">
                                                   </span>
                </div>
                <p class="counsellor-spec">MBBS (AIIMS Delhi), 12+ years guiding students for government medical admissions. Specialist in NEET counselling and state quota admissions.</p>
                 <div class="counsellor-stats d-flex align-items-center gap-3">
                     <div class="c-stat"><strong class="d-block">1,200+</strong>Students Guided</div>
                     <div class="c-stat"><strong class="d-block">5 Star</strong>Rating</div>
                </div> 
                <div class="counsellor-btns">
                  <button class="btn btn-primary">View Profile</button>
                  <button class="btn btn-outline-primary">Book Session</button>
               </div> 
            </div>
         </div>
           <!-- end counsellors-body --> 
      </div>
   </div>
</div>

<!-- universities stat -->
 <div class="universities-list">
    <div class="container">
      <div class="row">
         <div class="col-md-6 universities-tile">
             <p class="section-label">Take a Look for Yourself</p>
            <h2 class="section-title">Top Medical Universities <span>We Partner With</span></h2>
            <p class="section-sub">All our partner universities are NMC approved and WHO recognized, ensuring your degree is valid worldwide.</p>
         </div>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 justify-content-center">
         <div class="col universities-body">
             <div class="universities-wrapper position-relative">
                <div class="universities-image">
                   <img src="https://amwcareerpoint.com/public/images/home-image/russia-780x1206.jpg" alt="russia">
                </div>
                <div class="universities-infomation position-absolute top-0 start-0 w-100 h-100">
                     <div class="uni-flag text-end p-4">Ru</div>
                     <div class="uni-details p-2 position-absolute bottom-0 start-0">
                        <!-- <p class="uni-tag"> <span> NMC Approved</span> </p> -->
                        <h4 class="uni-name">Russia</h4>
                         <p class="uni-city">Moscow, Kazan, Samara, Orenburg, Magas, Arkhangelsk, Tver, Pskov, and Kemerovo</p>
                     </div>
                </div>
             </div>
         </div>
            <!-- universities-body end -->
         <div class="col universities-body">
             <div class="universities-wrapper position-relative">
                <div class="universities-image">
                   <img src="https://amwcareerpoint.com/public/images/home-image/kyrgyzstan-780x1206.jpg" alt="kyrgyzstan">
                </div>
                <div class="universities-infomation position-absolute top-0 start-0 w-100 h-100">
                     <div class="uni-flag text-end p-4">Ru</div>
                     <div class="uni-details p-2 position-absolute bottom-0 start-0">
                        <!-- <p class="uni-tag"> <span> NMC Approved</span> </p> -->
                        <h4 class="uni-name">Kyrgyzstan</h4>
                         <p class="uni-city">-</p>
                     </div>
                </div>
             </div>
         </div>
            <!-- universities-body end -->
         <div class="col universities-body">
             <div class="universities-wrapper position-relative">
                <div class="universities-image">
                   <img src="https://amwcareerpoint.com/public/images/home-image/kazakhstn-780x1206.jpg" alt="kazakhstn">
                </div>
                <div class="universities-infomation position-absolute top-0 start-0 w-100 h-100">
                     <div class="uni-flag text-end p-4">Ru</div>
                     <div class="uni-details p-2 position-absolute bottom-0 start-0">
                        <!-- <p class="uni-tag"> <span> NMC Approved</span> </p> -->
                        <h4 class="uni-name">kazakhstn</h4>
                         <p class="uni-city"> Almaty, Astana, Semey, Aktobe, Shymkent, Karaganda</p>
                     </div>
                </div>
             </div>
         </div>
            <!-- universities-body end -->
         <div class="col universities-body">
             <div class="universities-wrapper position-relative">
                <div class="universities-image">
                   <img src="https://amwcareerpoint.com/public/images/home-image/uzbekistan-780x1206.jpg" alt="Uzbekistan">
                </div>
                <div class="universities-infomation position-absolute top-0 start-0 w-100 h-100">
                     <div class="uni-flag text-end p-4">Ru</div>
                     <div class="uni-details p-2 position-absolute bottom-0 start-0">
                        <!-- <p class="uni-tag"> <span> NMC Approved</span> </p> -->
                        <h4 class="uni-name">Uzbekistan</h4>
                         <p class="uni-city">-</p>
                     </div>
                </div>
             </div>
         </div>
            <!-- universities-body end -->
         <div class="col universities-body">
             <div class="universities-wrapper position-relative">
                <div class="universities-image">
                   <img src="https://amwcareerpoint.com/public/images/home-image/georgia-780x1206.jpg" alt="Georgia">
                </div>
                <div class="universities-infomation position-absolute top-0 start-0 w-100 h-100">
                     <div class="uni-flag text-end p-4">Ru</div>
                     <div class="uni-details p-2 position-absolute bottom-0 start-0">
                        <!-- <p class="uni-tag"> <span> NMC Approved</span> </p> -->
                        <h4 class="uni-name">Georgia</h4>
                         <p class="uni-city">-</p>
                     </div>
                </div>
             </div>
         </div> 
            <!-- universities-body end -->
         <div class="col universities-body">
             <div class="universities-wrapper position-relative">
                <div class="universities-image">
                   <img src="https://amwcareerpoint.com/public/images/home-image/nepal-780x1206.jpg" alt="Nepal">
                </div>
                <div class="universities-infomation position-absolute top-0 start-0 w-100 h-100">
                     <div class="uni-flag text-end p-4">Ru</div>
                     <div class="uni-details p-2 position-absolute bottom-0 start-0">
                        <!-- <p class="uni-tag"> <span> NMC Approved</span> </p> -->
                        <h4 class="uni-name">Nepal</h4>
                         <p class="uni-city">-</p>
                     </div>
                </div>
             </div>
         </div>
            <!-- universities-body end -->
         <div class="col universities-body">
             <div class="universities-wrapper position-relative">
                <div class="universities-image">
                   <img src="https://amwcareerpoint.com/public/images/home-image/england-780x1206.jpg" alt="United kingdom">
                </div>
                <div class="universities-infomation position-absolute top-0 start-0 w-100 h-100">
                     <div class="uni-flag text-end p-4">Ru</div>
                     <div class="uni-details p-2 position-absolute bottom-0 start-0">
                        <!-- <p class="uni-tag"> <span> NMC Approved</span> </p> -->
                        <h4 class="uni-name">United kingdom</h4>
                         <p class="uni-city">-</p>
                     </div>
                </div>
             </div>
         </div>
            <!-- universities-body end -->
      </div>
      <div class="row">
          <div class="col-md-12 text-center">
             <!-- <a href="https://amwcareerpoint.com/colleges" class="btn btn-secondary cta-button"> All Universities</a> -->
          </div>
      </div>

    </div>
 </div>
<!-- universities end -->

<!-- admission start  -->
  <div class="admission-process">
   <div class="container">
      <div class="row">
         <div class="col-md-12 admission-title text-center">
            <p class="section-label">Full Service Package</p>
            <h2 class="section-title">How We Help You Get <span>Admitted</span></h2>
            <p class="section-sub">A simple 3-step process to take you from NEET score to your dream medical college in India or abroad.</p>
         </div>
      </div>
  
       <div class="row">
         <div class="col-md-4 text-center">
            <div class="admission-step">
            <div class="admission-step-count">
                <span>1</span>
            </div>
            <div class="admission-step-image">
               <img src="" alt="">
            </div>
            <div class="admission-step-details">
               <h4>Counselling & Application</h4>
               <p>Share your NEET score, budget, and preferences. Our experts analyse your profile and present the best college options suited to your goals.</p>
             </div>
          </div>
         </div>
          <!-- admission-step end -->
         <div class="col-md-4 text-center">
            <div class="admission-step">
            <div class="admission-step-count">
                <span>2</span>
            </div>
            <div class="admission-step-image">
               <img src="" alt="">
            </div>
            <div class="admission-step-details">
               <h4>Preparation & Documentation</h4>
               <p>We handle your entire application — documents, forms, eligibility certificates, visa applications, and more. Zero hassle for you or your family.</p>
             </div>
          </div>
         </div>
          <!-- admission-step end -->
         <div class="col-md-4 text-center">
            <div class="admission-step">
            <div class="admission-step-count">
                <span>3</span>
            </div>
            <div class="admission-step-image">
               <img src="" alt="">
            </div>
            <div class="admission-step-details">
               <h4>Support, Hostel & Network</h4>
               <p>We don't stop at admission. From accommodation and travel to FMGE coaching and alumni networking — we're with you throughout your journey.</p>
             </div>
          </div>
         </div>
          <!-- admission-step end -->
      </div>     

   </div>
  </div>

<!-- admission end  -->

<!-- predictor start -->

<div class="predictor">
   <div class="container">
      <div class="row">
         <div class="col-md-6 offset-md-3 predictor-title text-center">
            <p class="section-label">Free Tool</p>
            <h2 class="section-title">NEET College Predictor<span></span></h2>
            <p class="section-sub">Enter your NEET score and category to instantly see which government and private medical colleges you qualify for.</p>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6 offset-md-3 text-center">
            <a href="https://amwcareerpoint.com/predictors" class="btn btn-primary">Predict My Colleges Now</a>
         </div>
      </div>
   </div>
 
</div>

<!-- predictor end -->

<!-- fee-table start  -->

<div class="fee-table-home">
   <div class="container">
      <div class="row">
         <div class="col-md-6 fee-table-title text-start">
            <p class="section-label">Smart Comparison</p>
            <h2 class="section-title">MBBS Fee Comparison — <span>India vs Abroad</span></h2>
            <p class="section-sub">Transparent cost breakdown to help you and your family make an informed decision.</p>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 offset-md-0 text-start fee-table-wrapper">
              <table class="fee-table table table-striped">
                  <thead>
                  <tr>
                     <th>Country / Type</th>
                     <th>Total Fee (6 Years)</th>
                     <th>Living Cost / Year</th>
                     <th>Medium</th>
                     <th>NMC Approved</th>
                     <th>FMGE Pass Rate</th>
                     <th>Best For</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr class="highlight-row">
                     <td>🇮🇳 India – Govt College <span class="badge bg-info ">Lowest Cost</span></td>
                     <td>₹1–5 Lakhs</td>
                     <td>₹1–2 Lakhs</td>
                     <td>English/Hindi</td>
                     <td>✅ Yes</td>
                     <td>—</td>
                     <td>700+ NEET</td>
                  </tr>
                  <tr>
                     <td>🇮🇳 India – Private College</td>
                     <td>₹60–100 Lakhs</td>
                     <td>₹2–4 Lakhs</td>
                     <td>English</td>
                     <td>✅ Yes</td>
                     <td>—</td>
                     <td>500–600 NEET</td>
                  </tr>
                  <tr>
                     <td>🇷🇺 Russia <span class="badge bg-success">Popular</span></td>
                     <td>₹20–35 Lakhs</td>
                     <td>₹2–3 Lakhs</td>
                     <td>English</td>
                     <td>✅ Yes</td>
                     <td>
                          <div class="progress my-2 height14">
                            <div class="progress-bar bg-info height14" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                          </div>
                     </td>
                     <td>400–500 NEET</td>
                  </tr>
                  <tr>
                     <td>🇺🇿 Uzbekistan <span class="badge bg-warning ">Best Value</span></td>
                     <td>₹18–28 Lakhs</td>
                     <td>₹1.5–2 Lakhs</td>
                     <td>English</td>
                     <td>✅ Yes</td>
                     <td> 
                          <div class="progress my-2 height14">
                            <div class="progress-bar bg-info height14" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                          </div>
                     </td>
                     <td>350–500 NEET</td>
                  </tr>
                  <tr>
                     <td>🇰🇿 Kazakhstan</td>
                     <td>₹22–35 Lakhs</td>
                     <td>₹2–3 Lakhs</td>
                     <td>English</td>
                     <td>✅ Yes</td>
                     <td> 
                        <div class="progress my-2 height14">
                            <div class="progress-bar bg-info height14" role="progressbar" style="width: 48%" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100">48%</div>
                          </div>
                     </td>
                     <td>400–500 NEET</td>
                  </tr>
                  <tr>
                     <td>🇬🇪 Georgia</td>
                     <td>₹30–45 Lakhs</td>
                     <td>₹2.5–3.5 Lakhs</td>
                     <td>English</td>
                     <td>✅ Yes</td>
                     <td> 
                        <div class="progress my-2 height14">
                            <div class="progress-bar bg-info height14" role="progressbar" style="width: 52%" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100">52%</div>
                          </div>
                     </td>
                     <td>400–550 NEET</td>
                  </tr>
                  <tr>
                     <td>🇨🇳 China</td>
                     <td>₹25–40 Lakhs</td>
                     <td>₹2–3 Lakhs</td>
                     <td>English/Chinese</td>
                     <td>✅ Yes</td>
                     <td> 
                         <div class="progress my-2 height14">
                            <div class="progress-bar bg-info height14" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                          </div>
                     </td>
                     <td>400–500 NEET</td>
                  </tr>
                  </tbody>
               </table>
               <p>* Fees are approximate. Contact our counsellors for exact, updated fee structures. All listed colleges are NMC approved as of 2025.</p>
         </div>
      </div>
   </div>
 
</div>

<!-- fee-table end  -->

<!-- guidance-cta strat -->

  <div class="guidance">
      <div class="container">
        <div class="row">
          <div class="col-md-12 guidance-wrapper">
            <div class="guidance-wrapper-in">
              <div class="row align-items-center">
                <div class="col-md-6 text-center">
                  <img class="d-inline-block"
                    src="https://www.instantassignmenthelp.com/templates/instantassignmenthelp/images/CA-1.png"
                    alt="phone"
                  />
                </div>
                <div class="col-md-6 guidance-title text-center">
                  <p class="section-label">
                    We guide you, through every step of the way
                  </p>
                  <h2 class="section-title">
                    Book a Free Career<span class="d-block"
                      >Guidance Session Today!</span
                    >
                  </h2>
                  <p class="section-sub">
                    Exploring your options can be tough. That's why our experts
                    are here to help. Under our guidance you'll discover your
                    full potential and find the right path to your medical
                    career.
                  </p>
                  <a href="#" class="btn btn-primary">
                    Arrange a Free Career Guidance Session
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- guidance-cta  end-->

<!-- stories start -->

    <div class="stories">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3 stories-title text-center">
            <p class="section-label">Real Students, Real Results</p>
            <h2 class="section-title">What Our<span> Students Say </span></h2>
            <p class="section-sub">
              Over 18,000 students have successfully started their medical
              journey with AMW Career Point.
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 stories-body">
            <div class="stories-wrapper">
              <div class="story-quote">"</div>
              <p class="story-text">
                I had a NEET score of 480 and was hopeless. AMW counselled me
                within 24 hours and I got admission in Russia. Now I'm in my 3rd
                year!
              </p>
              <div class="story-student d-flex align-items-center gap-3">
                <div class="student-avatar">RS</div>
                <div>
                  <div class="student-name">Rahul Singh</div>
                  <div class="student-meta">
                    Kazan Federal University, Russia
                  </div>
                  <span class="neet-score">NEET: 480 | Batch 2022</span>
                </div>
              </div>
            </div>
          </div>
            <!-- end stories-body -->
          <div class="col-md-4 stories-body">
            <div class="stories-wrapper">
              <div class="story-quote">"</div>
              <p class="story-text">
                I had a NEET score of 480 and was hopeless. AMW counselled me
                within 24 hours and I got admission in Russia. Now I'm in my 3rd
                year!
              </p>
              <div class="story-student d-flex align-items-center gap-3">
                <div class="student-avatar">RS</div>
                <div>
                  <div class="student-name">Rahul Singh</div>
                  <div class="student-meta">
                    Kazan Federal University, Russia
                  </div>
                  <span class="neet-score">NEET: 480 | Batch 2022</span>
                </div>
              </div>
            </div>
          </div>
            <!-- end stories-body -->
          <div class="col-md-4 stories-body">
            <div class="stories-wrapper">
              <div class="story-quote">"</div>
              <p class="story-text">
                I had a NEET score of 480 and was hopeless. AMW counselled me
                within 24 hours and I got admission in Russia. Now I'm in my 3rd
                year!
              </p>
              <div class="story-student d-flex align-items-center gap-3"> 
                <div class="student-avatar">RS</div>
                <div>
                  <div class="student-name">Rahul Singh</div>
                  <div class="student-meta">
                    Kazan Federal University, Russia
                  </div>
                  <span class="neet-score">NEET: 480 | Batch 2022</span>
                </div>
              </div>
            </div>
          </div>
            <!-- end stories-body -->
        </div>
      </div>
    </div>
<!-- stories end-->

<!-- founders-inner start -->

<div class="founders">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-md-6 text-center">
            <img class="d-inline-block" src="https://amwcareerpoint.com/public/images/home-image/amw-llogo-consultation-footer.png" alt="phone">
         </div>
         <div class="col-md-6 founders-title text-start">
            <p class="section-label">Meet Our Founders</p>
            <h2 class="section-title">AMW Career Point was <span>founded and run by doctors</span></h2>
            <p class="section-sub">Once upon a time, two passionate medical graduates saw thousands of NEET aspirants lose their dreams simply due to a lack of proper guidance. They founded AMW Career Point to change that.</p>
             <p class="section-sub">Today, with 15+ years of experience and 18,000+ students successfully placed, our founders continue to personally oversee the quality of counselling every student receives — ensuring no dream goes unfulfilled.</p>
            <a href="#" class="btn btn-primary"> + Read our full story  </a>
         </div>
      </div>
   </div>
 
</div>

<!-- founders-inner end -->

<!-- home-faq start -->

<div class="home-faq">
      <div class="container">
        <div class="row">
          <div class="col-md-6 gx-5 offset-md-3 home-faq-title text-center">
            <p class="section-label">Got Questions?</p>
            <h2 class="section-title">
              Frequently Asked<span> Questions </span>
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="accordion faq-content row" id="accordionExample">
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                   <h2 class="accordion-header text-start">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse101"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    What are the basic eligibility criteria for admission?
                  </button>
                </h2>
                <div
                  id="collapse101"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    Students must typically have a minimum of 50% marks in PCB
                    (Physics, Chemistry, Biology) in the 12th standard (40% for
                    reserved categories) and must have qualified NEET in the
                    current or previous two years, as per NMC guidelines.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                  <h2 class="accordion-header text-start">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse102"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    What is the total duration of the MBBS course?
                  </button>
                </h2>
                <div
                  id="collapse102"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    The duration is generally 6 years in total, which includes 5
                    years of academic study (54 months) and 1 year of compulsory
                    internship (12 months), fully complying with the latest
                    National Medical Commission (NMC) rules.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                  <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse103"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    What is the application process?
                  </button>
                </h2>
                <div
                  id="collapse103"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    The process is simple: 1. Submit scanned documents (10th,
                    11th, and 12th mark sheets, NEET result, Passport scan, and
                    a recent passport-size photograph with a white background).
                    2. Receive the Admission Letter from the University. 3.
                    Process the Invitation Letter for Visa. 4. Complete the Visa
                    application with our assistance.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                  <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse104"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    Are the degrees globally recognized?
                  </button>
                </h2>
                <div
                  id="collapse104"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    Yes, all our partner universities are recognized by the
                    World Health Organization (WHO) and the National Medical
                    Commission (NMC). Graduate doctors can also write major
                    global licensing exams such as USMLE (USA), PLAB (UK), AMC
                    (Australia), and the FMGE/NExT exam for India.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                  <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse105"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    Is an entrance test required by the university?
                  </button>
                </h2>
                <div
                  id="collapse105"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    While most universities admit based on your 12th marks and
                    NEET qualification, some may require a simple online
                    entrance test or interview. We will guide you through any
                    such requirement.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                  <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse106"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    What is included in the Total Fees?
                  </button>
                </h2>
                <div
                  id="collapse106"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    Fees typically cover the Tuition Fee, Hostel Fee, Medical
                    Insurance, Visa Extension, and administrative charges. A
                    detailed, transparent fee structure showing Tuition Fee,
                    Hostel Fee, Mess Charges, Visa/Invitation Fee, and Medical
                    Assurance Fee for each country and university will be
                    provided upfront.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list"> <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse107"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    Can I pay the fees in installments?
                  </button>
                </h2>
                <div
                  id="collapse107"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    Payment schedules are determined by the individual
                    university. Some universities allow semester-wise payments,
                    while others require annual payments. We will provide clear
                    guidance on the university's official payment schedule.
                  </div>
                </div></div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                    <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse108"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    Are there any hidden costs?
                  </button>
                </h2>
                <div
                  id="collapse108"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    We are committed to transparency. All costs, including
                    consultation charges and university expenses, are detailed
                    in your offer letter. We strongly advise against any form of
                    donation.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
                <div class="faq-list">
                   <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse109"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    Do you assist with travel arrangements?
                  </button>
                </h2>
                <div
                  id="collapse109"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    Yes, we coordinate group departures for students and assist
                    with flight ticket booking. Our representative will meet the
                    students at the destination airport and provide transport to
                    the university hostel.
                  </div>
                </div>
                </div>
              </div>
              <div class="accordion-item0 col-md-6">
               <div class="faq-list">
                   <h2 class="accordion-header">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse110"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    Is the food and accommodation suitable for Indian students?
                  </button>
                </h2>
                <div
                  id="collapse110"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    Hostels offer secure accommodation with separate facilities
                    for boys and girls. Indian meals are generally cooked and
                    served by Indian caterers within the hostel premises or mess
                    hall to ensure a suitable diet for students.
                  </div>
                </div>
               </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- faq end -->

<!-- Homecontact start -->
 <div class="homecontact">
   <div class="container">
      <div class="row">
         <div class="col-md-12 homecontact-title">
                 <p class="section-label">Visit Us</p>
            <h2 class="section-title">Our Office & <span> Registrations </span></h2>
            <p class="section-sub">Transparent cost breakdown to help you and your family make an informed decision.</p>
         </div>
         <div class="col-md-6 homecontact-map">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3557.154146453078!2d75.79122869999999!3d26.9303273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db3a05c4e5e9d%3A0xb2efe41db0339bad!2sAMW%20CAREER%20POINT%20MBBS%20ABROAD%20%2F%20STUDY%20ABROAD!5e0!3m2!1sen!2sin!4v1773045905970!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
         </div>
         <div class="col-md-6 homecontact-body">
            <h3 class="homecontact-term-tile">AMW Career Point — Head Office</h3>
            <ul class="homecontact-term">
               <li class="d-flex align-items-center gap-3">
                   <i class="fa fa-map-pin"></i>
                   <span class="homecontact-info">
                     <strong  class="d-block"> D 100 A, Suprem Complex, Meera Marg, Bani Park, </strong>
                     Jaipur, Rajasthan 302006, India 
                   </span>
               </li>
               <li class="d-flex align-items-center gap-3">
                   <i class="fa fa-mobile-phone"></i>
                   <span class="homecontact-info">
                     <strong  class="d-block"> +91-9929299268 </strong>
                     (Mon - Saturday | 10:00 AM - 06:00 PM)
                   </span>
               </li>
               <li class="d-flex align-items-center gap-3">
                   <i class="fa fa-envelope"></i>
                   <span class="homecontact-info">
                     <strong  class="d-block"> info@amwcareerpoint.com </strong>
                     We reply within 2 hours
                   </span>
               </li>
               <li class="d-flex align-items-center gap-3">
                   <i class="fa fa-stopwatch"></i>
                   <span class="homecontact-info">
                     <strong  class="d-block"> Response Commitment </strong>
                      All enquiries answered within 2 hours
                   </span>
               </li>
            </ul>
         </div>
         <div class="col-md-6 offset-md-6">
            <ul class="recognised-ponit">
               <li>NMC Reg: XXXX-2024 </li>
               <li>ISO 9001:2015</li>
               <li>AIASA Member</li>
               <li>WHO Partner</li>
            </ul>
         </div>
      </div>
   </div>
 </div>
<!-- Homecontact end -->
 

@php
    $collegePages = getCollegePages();
    $videos = getVideos();
@endphp
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
   <div class="container">
        <div class="title-seciton text-center py-3 py-lg-5 wow fadeInUp">
            <h2 class="mb-3">Most Popular Countries for MBBS</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">With AMW Career Point you can get MBBS Admission in renowned Medical Universities Worldwide</div>
         </div>

         <div class="step-today-section wow fadeInUp">
            <!-- Tabs -->
            

            <!-- Government-College Cards -->
            <div id="college-list" class="show row g-4 college-show">
               @foreach($collegePages as $key => $collegePage)
               <div class="col-md-4">
                  <div class="college-card h-100">
                     <div class="d-flex justify-content-between align-items-center">
                        <img src="https://amwcareerpoint.com/public/admin/images/banners/{{$collegePage->image}}" style="width: 100%;
    height: 100%;" alt="{{$collegePage->alt_image}}" title="{{$collegePage->title}}">
                        <div>
                        
                        </div>
                     </div>
                     <h5 class="mt-3">{{$collegePage->title}}</h5>
                     <a href="https://amwcareerpoint.com/{{$collegePage->slug}}" class="btn btn-outline-warning w-100">Read More</a>
                  </div>
               </div>
				@endforeach
             

            </div>


         </div>

   </div>
</div>

<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
   <div class="container">
        <div class="title-seciton text-center py-3 py-lg-5 wow fadeInUp">
            <h2 class="mb-3">Choose the Right Country for Your MBBS Journey</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">Compare, Evaluate, and Decide with Clarity</div>
         </div>

         <div class="step-today-section wow fadeInUp">
            <div id="" class="show row g-4 college-show">
               @foreach($videos as $key => $video)
               <div class="col-md-3">
                    {!!$video->testimonial!!}
                </div>
               @endforeach
            </div>
            
            <div class="d-flex align-items-center justify-content-center mx-auto mt-5 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;" bis_skin_checked="1">
			<a href="{{route('pages.videos')}}" class="btn btn-secondary cta-button" bis_skin_checked="1">View All</a>
         </div>
			

         </div>

   </div>
</div>

<!--About us section start here-->
<div class="about-us-section py-100 add-test">
   <div class="container">
   		@if(isset($section2->id))
         <div class="row">
             <div class="col-lg-6">
                  <div class="about-left-img-section wow fadeInUp">
                  	@if($section2->image != '')
                    <img alt="" src="{{ asset('public/admin/images/banners/') }}/{{$section2->image}}" class="wow bounce bounce-slow-more"/>
                    @endif
                  </div>
             </div>

             <div class="col-lg-6">
                  <div class="about-us-content wow fadeInUp">
                        <div class="badge yellow-bedge">{!! $section2->title !!}</div>
                        <h2 class="mb-4">{!! $section2->heading !!}</h2>
                        <p class="mb-4">{!! $section2->description !!}</p>
                        <a href="{{route('pages.about-us')}}" class="btn btn-primary cta-button">Read More</a>
                  </div>
             </div>
         </div>
		@endif
         <div class="row">
            <div class="col-lg-12 wow fadeInUp">
               <div class="pt-100">
                  <div class="our-milliion-seciton wow fadeInUp">
                     <h5>Our Milestones and Achievements</h5>
                     <div class="stats">
                           <div class="stat">
                              <h2 class="count" data-target="3500">0</h2>
                              <p>Students Trained</p>
                           </div>
                           <div class="stat">
                              <h2 class="count" data-target="2500">0</h2>
                              <p>Admissions Secured</p>
                           </div>
                           <div class="stat">
                              <div class="d-flex align-items-center">
                                 <h2 class="count" data-target="100">0</h2>
                                 <span class="count-per">%</span>
                              </div>
                              <p>Visa Success Rate (for Abroad Students)</p>
                           </div>
                     </div>

                     <div class="achievments-img-section wow fadeInUp"><img alt="" src="{{ asset('public/img/our_milestones.svg') }}" class="wow animated2 bounce-slow-more"/></div>
                  </div>
               </div>
            </div>
         </div>
   </div>
</div>
<!--About us section end here-->

<!--Ready to see you quailty section start here-->
<div class="top-ranked-colleges py-100 pt-0 wow fadeInUp">
   <div class="container">
   		@if(isset($section3->id))
        <div class="title-seciton text-center py-3 py-lg-5 wow fadeInUp">
            <h2 class="mb-3">{!! $section3->title !!}</h2>
            <div class="taketo-first">
                <p class="text-center col-md-10 mx-auto">{!! $section3->description !!}</p>
            </div>
         </div>
			@endif
            
         <div class="step-today-section wow fadeInUp">
            <!-- Tabs -->
            <div class="text-center d-flex align-items-center justify-content-center wow fadeInUp">
               <div class="tab-btn mb-5">
                  <button class="active" id="govt-tab">Government</button>
                  <button id="private-tab">Private</button>
                  <button id="abroad-tab">Abroad</button>
               </div>
            </div>

            <!-- Government-College Cards -->
            <div id="college-list" class="college-show row g-4">
               @if(isset($gcolleges) && $gcolleges->count()>0)
               @foreach($gcolleges as $key => $college)
               @php
                    $year = date('Y',strtotime($college->created_at));
                    $month = date('m',strtotime($college->created_at));
                    $dir = $year.'/'.$month;
                @endphp
               <div class="col-md-4">
                  <div class="college-card h-100">
                     <div class="d-flex justify-content-between align-items-center">
                     	@if($college->logo != '')
                        	<img src="{{URL::asset('public/admin/images/banners')}}/{!! $college->logo !!}" alt="college logo" title="">
                        @else
                        	<img src="{{URL::asset('public/images/no_img.jpg')}}" class="rounded-circle" alt="college logo" title="">
                        @endif                        
                        <div>
                        <span class="star">
                        	@for($i=1;$i<=$college->rating;$i++)
                           <img src="{{ asset('public/img/star.svg') }}" alt="" title=""/>
                           @endfor
                        </span>
                        </div>
                     </div>
                     <a href="{{url('college',$college->slug)}}"><h5 class="mt-3">{{$college->name}}</h5></a>
                     <p class="mb-4">{{getDetails('states',$college->state,'state')}}</p>
                     @if($college->description != '')
                     	<p>{{substr(strip_tags($college->description),0,70)}}...</p>
                     @endif                     
                     <a href="{{url('college',$college->slug)}}" class="btn btn-outline-warning mt-4 w-100">College Details</a>
                  </div>
               </div>
               @endforeach
               @endif                              
          	</div>

            <!-- Private-College Cards -->
            <div id="college-list-priv" class="row g-4 ">
               
               @if(isset($pcolleges) && $pcolleges->count()>0)
               @foreach($pcolleges as $key => $college)
               @php
                    $year = date('Y',strtotime($college->created_at));
                    $month = date('m',strtotime($college->created_at));
                    $dir = $year.'/'.$month;
                @endphp
               <div class="col-md-4">
                  <div class="college-card h-100">
                     <div class="d-flex justify-content-between align-items-center">
                     	@if($college->logo != '')
                        	<img src="{{URL::asset('public/admin/images/banners')}}/{!! $college->logo !!}" alt="college logo" title="">
                        @else
                        	<img src="{{URL::asset('public/images/no_img.jpg')}}" class="rounded-circle" alt="college logo" title="">
                        @endif                        
                        <div>
                        <span class="star">
                        	@for($i=1;$i<=$college->rating;$i++)
                           <img src="{{ asset('public/img/star.svg') }}" alt="" title=""/>
                           @endfor
                        </span>
                        </div>
                     </div>
                    <a href="{{url('college',$college->slug)}}"><h5 class="mt-3">{{$college->name}}</h5></a>
                     <p class="mb-4">{{getDetails('states',$college->state,'state')}}</p>
                     @if($college->description != '')
                     	<p>{{substr(strip_tags($college->description),0,70)}}...</p>
                     @endif                     
                     <a href="{{url('college',$college->slug)}}" class="btn btn-outline-warning mt-4 w-100">College Details</a>
                  </div>
               </div>
               @endforeach
               @endif

            </div>
            
            <!-- Private-College Cards -->
            <div id="college-list-abroad" class="row g-4 ">
               
               @if(isset($acolleges) && $acolleges->count()>0)
               @foreach($acolleges as $key => $college)
               @php
                    $year = date('Y',strtotime($college->created_at));
                    $month = date('m',strtotime($college->created_at));
                    $dir = $year.'/'.$month;
                @endphp
               <div class="col-md-4">
                  <div class="college-card h-100">
                     <div class="d-flex justify-content-between align-items-center">
                     	@if($college->logo != '')
                        	<img src="{{URL::asset('public/admin/images/banners')}}/{!! $college->logo !!}" alt="college logo" title="">
                        @else
                        	<img src="{{URL::asset('public/images/no_img.jpg')}}" class="rounded-circle" alt="college logo" title="">
                        @endif                        
                        <div>
                        <span class="star">
                        	@for($i=1;$i<=$college->rating;$i++)
                           <img src="{{ asset('public/img/star.svg') }}" alt="" title=""/>
                           @endfor
                        </span>
                        </div>
                     </div>
                     <a href="{{url('college',$college->slug)}}"><h5 class="mt-3">{{$college->name}}</h5></a>
                     <p class="mb-4">{{getDetails('states',$college->state,'state')}} {{getDetails('countries',$college->country,'title')}}</p>
                     @if($college->description != '')
                     	<p>{{substr(strip_tags($college->description),0,70)}}...</p>
                     @endif                     
                     <a href="{{url('college',$college->slug)}}" class="btn btn-outline-warning mt-4 w-100">College Details</a>
                  </div>
               </div>
               @endforeach
               @endif

            </div>
         </div>

         <div class="d-flex align-items-center justify-content-center mx-auto mt-5 wow fadeInUp">
			<a href="{{route('pages.predictors')}}" class="btn btn-primary cta-button me-4">Use College Predictor</a>
			<a href="{{route('pages.colleges')}}" class="btn btn-secondary cta-button">View All Colleges</a>
         </div>

   </div> 
</div>
<!--Ready to see you quailty section end here-->


@include('element.section1')


@include('element.section2')


@include('element.testimonials')


@include('element.faq')


@include('element.blogs')


@include('element.contact_us2')       


<script type="text/javascript">
	$(document).ready(function () {
		$('.numberonly').keypress(function(e){
			var charCode = (e.which) ? e.which : event.keyCode
			if(String.fromCharCode(charCode).match(/[^0-9+]/g))
			return false;
		});
    });	
	
</script>

@endsection