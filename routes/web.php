<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController; 
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\PurchasesController;

########## pages ##############

Route::get('/blogs/{slug?}',[PagesController::class, 'blogs'])->name('pages.blogs');
Route::any('/blogs_paginate',[PagesController::class, 'blogPaginate'])->name('pages.blogs_paginate');
Route::get('/blog/{slug}',[PagesController::class, 'blogDetails'])->name('pages.blog-details');
Route::get('/colleges',[PagesController::class, 'colleges'])->name('pages.colleges');
Route::any('/colleges_paginate',[PagesController::class, 'collegePaginate'])->name('pages.colleges_paginate');
Route::get('/college/{slug}',[PagesController::class, 'collegeDetails'])->name('pages.college-details');
Route::get('/contact-us',[PagesController::class, 'contactUs'])->name('pages.contact-us');
Route::get('/predictors',[PagesController::class, 'predictors'])->name('pages.predictors');
Route::get('/faqs',[PagesController::class, 'faqs'])->name('pages.faqs');
Route::get('/videos',[PagesController::class, 'videos'])->name('pages.videos');
Route::get('/sitemap',[PagesController::class, 'sitemap'])->name('pages.sitemap');
Route::get('/country-colleges/{country}',[PagesController::class, 'countryColleges'])->name('pages.country.colleges');
Route::any('/country_colleges_paginate',[PagesController::class, 'countryCollegePaginate'])->name('pages.country.colleges_paginate');
Route::get('/country/{country}',[PagesController::class, 'country'])->name('pages.country.all.colleges');
Route::any('/country_paginate',[PagesController::class, 'countryPaginate'])->name('pages.country.paginate');

####### inner pages $#########
Route::get('/about-us',[PagesController::class, 'aboutUs'])->name('pages.about-us');
Route::get('/privacy-policy',[PagesController::class, 'privacyPolicy'])->name('pages.privacy-policy');
Route::get('/support',[PagesController::class, 'support'])->name('pages.support');
Route::get('/tutorials',[PagesController::class, 'tutorials'])->name('pages.tutorials');
Route::get('/documentation',[PagesController::class, 'documentation'])->name('pages.documentation');
Route::get('/packages',[PagesController::class, 'packages'])->name('pages.packages');
Route::get('/predictor-colleges',[PagesController::class, 'predictorColleges'])->name('pages.predictor-colleges');

##### PurchasesController ##########
Route::get('/plan/{slug?}',[PurchasesController::class, 'plan'])->name('cutomers.plan');
Route::post('/purchase-package',[PurchasesController::class, 'purchasePackage'])->name('purchase.purchase-package');

### CustomersController ######
Route::get('/customer-registration',[CustomersController::class, 'customerSignup'])->name('cutomers.customer-registration');
Route::get('/customer-login',[CustomersController::class, 'login'])->name('cutomers.customer-login');
Route::get('/logout',[CustomersController::class, 'logout'])->name('cutomers.customer-logout');
Route::any('/change-password',[CustomersController::class, 'changePassword'])->name('change-password');
Route::any('/my-account',[CustomersController::class, 'myAccount'])->name('my-account');
Route::any('/my-orders',[CustomersController::class, 'myOrders'])->name('my-orders');
Route::any('/my-predictors',[CustomersController::class, 'myPredictors'])->name('my-predictors');
Route::get('/forgot-password',[CustomersController::class, 'forgotPassword'])->name('customers.forgotPassword');
Route::get('/reset-password/{email}/{sec_pass}',[CustomersController::class, 'resetPassword'])->name('resetPassword');
Route::any('/reset-password-change',[CustomersController::class, 'resetPasswordChange'])->name('resetPasswordChange');


########### ajax #############
Route::any('/check-login',[AjaxController::class, 'checkLogin'])->name('ajax.check-login');
Route::any('/save-inquiry',[AjaxController::class, 'saveInquiry'])->name('ajax.save-inquiry');
Route::any('/add-newsletter',[AjaxController::class, 'addNewsletter'])->name('ajax.add-newsletter');
Route::any('/save-predictor',[AjaxController::class, 'savePredictor'])->name('ajax.save-predictor');
Route::any('/set-cookie',[AjaxController::class, 'setCookie'])->name('ajax.set-cookie');
Route::any('/get-state-category',[AjaxController::class, 'getStateCategory'])->name('ajax.get-state-category');
Route::any('/get-state-sub-category',[AjaxController::class, 'getStateSubCategory'])->name('ajax.get-state-sub-category');


require "admin.php";
require "export.php";


Route::get('/{slug?}',[PagesController::class, 'index'])->name('pages.index');