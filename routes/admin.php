<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\ExportsController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\InnerPagesController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\CollegesController;
use App\Http\Controllers\Admin\StatesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\LocationsController;
use App\Http\Controllers\Admin\PredictorsController;
use App\Http\Controllers\Admin\BrochuresController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\CountryPagesController;
use App\Http\Controllers\Admin\VideosController;
use App\Http\Controllers\Admin\CollegeCategoryController;
use App\Http\Controllers\Admin\CollegeSubCategoryController;
use App\Http\Controllers\Admin\EmployeeController;

Route::prefix('panel')->group(function(){
	
	#account setup
	Route::get('/',[AdminController::class, 'login'])->name('admin.login');
	Route::get('/login',[AdminController::class, 'login'])->name('admin.login');
	Route::post('/admin-login',[AdminController::class, 'admin_login'])->name('admin.admin_login');
	Route::get('/logout',[AdminController::class, 'logout'])->name('admin.logout');
		
	#dashboard setup
	Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
	Route::get('/profile',[ProfileController::class, 'profile'])->name('admin.profile');
	Route::post('/save-profile',[ProfileController::class, 'saveProfile'])->name('admin.saveProfile');
	
	#settings
    Route::get('/settings', [ProfileController::class, 'settings'])->name('admin.settings');
    Route::post('/save-setting', [ProfileController::class, 'saveSetting'])->name('admin.save-setting');
	
	#change password
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('admin.change-password');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('admin.update-password');

	#ajax
	Route::post('/change-status',[AjaxController::class, 'changeStatus'])->name('admin.change-status');
    Route::post('/delete-record',[AjaxController::class, 'deleteRecord'])->name('admin.delete-record');
	Route::post('/get-enquiry',[AjaxController::class, 'getEnquiry'])->name('admin.get-enquiry');
	Route::post('/get-state',[AjaxController::class, 'getState'])->name('admin.get-state');
	Route::post('/get-college-category',[AjaxController::class, 'getCollegeCategory'])->name('admin.get-college-category');	

	#locations
    Route::get('/locations',[LocationsController::class, 'getList'])->name('admin.locations');
    Route::any('/locations_paginate',[LocationsController::class, 'listPaginate'])->name('admin.locations_paginate');
	Route::any('/edit-location/{row_id}',[LocationsController::class, 'editPage'])->name('admin.edit-location');
	Route::any('/add-location',[LocationsController::class, 'addPage'])->name('admin.add-location');
	
	#College
    Route::get('/blogs',[BlogsController::class, 'getList'])->name('admin.blogs');
    Route::any('/blogs_paginate',[BlogsController::class, 'listPaginate'])->name('admin.blogs_paginate');
	Route::any('/edit-blog/{row_id}',[BlogsController::class, 'editPage'])->name('admin.edit-blog');
	Route::any('/add-blog',[BlogsController::class, 'addPage'])->name('admin.add-blog');
	
	#countries
    Route::get('/countries',[CountriesController::class, 'getList'])->name('admin.countries');
    Route::any('/countries_paginate',[CountriesController::class, 'listPaginate'])->name('admin.countries_paginate');
	Route::any('/edit-country/{row_id}',[CountriesController::class, 'editPage'])->name('admin.edit-country');
	Route::any('/add-country',[CountriesController::class, 'addPage'])->name('admin.add-country');
	
	#College
    Route::get('/colleges',[CollegesController::class, 'getList'])->name('admin.colleges');
    Route::any('/colleges_paginate',[CollegesController::class, 'listPaginate'])->name('admin.colleges_paginate');
	Route::any('/edit-college/{row_id}',[CollegesController::class, 'editPage'])->name('admin.edit-college');
	Route::any('/add-college',[CollegesController::class, 'addPage'])->name('admin.add-college');
	Route::any('/upload-college-images',[CollegesController::class, 'uploadCollegeImages'])->name('admin.upload-college-images');
	
	#testimonials
    Route::get('/testimonials',[TestimonialsController::class, 'getList'])->name('admin.testimonials');
    Route::any('/testimonials_paginate',[TestimonialsController::class, 'listPaginate'])->name('admin.testimonials_paginate');
	Route::any('/edit-testimonial/{row_id}',[TestimonialsController::class, 'editPage'])->name('admin.edit-testimonial');
	Route::any('/add-testimonial',[TestimonialsController::class, 'addPage'])->name('admin.add-testimonial');
	
	#videos
    Route::get('/videos',[VideosController::class, 'getList'])->name('admin.videos');
    Route::any('/videos_paginate',[VideosController::class, 'listPaginate'])->name('admin.videos_paginate');
	Route::any('/edit-video/{row_id}',[VideosController::class, 'editPage'])->name('admin.edit-video');
	Route::any('/add-video',[VideosController::class, 'addPage'])->name('admin.add-video');
	
	#Brochures
    Route::get('/brochures',[BrochuresController::class, 'getList'])->name('admin.brochures');
    Route::any('/brochures_paginate',[BrochuresController::class, 'listPaginate'])->name('admin.brochures_paginate');
	Route::any('/edit-brochure/{row_id}',[BrochuresController::class, 'editPage'])->name('admin.edit-brochure');
	Route::any('/add-brochure',[BrochuresController::class, 'addPage'])->name('admin.add-brochure');
	
	#Brochures
    Route::get('/employees',[EmployeeController::class, 'getList'])->name('admin.employees');
    Route::any('/employees_paginate',[EmployeeController::class, 'listPaginate'])->name('admin.employees_paginate');
	Route::any('/edit-employee/{row_id}',[EmployeeController::class, 'editPage'])->name('admin.edit-employee');
	Route::any('/add-employee',[EmployeeController::class, 'addPage'])->name('admin.add-employee');
	
	#Brochures
    Route::get('/college-sub-categories',[CollegeSubCategoryController::class, 'getList'])->name('admin.college-sub-categories');
    Route::any('/college_sub_categories_paginate',[CollegeSubCategoryController::class, 'listPaginate'])->name('admin.college_sub_categories_paginate');
	Route::any('/edit-college-sub-category/{row_id}',[CollegeSubCategoryController::class, 'editPage'])->name('admin.edit-college-sub-category');
	Route::any('/add-college-sub-category',[CollegeSubCategoryController::class, 'addPage'])->name('admin.add-college-sub-category');
	
	#Brochures
    Route::get('/college-categories',[CollegeCategoryController::class, 'getList'])->name('admin.college-categories');
    Route::any('/college_categories_paginate',[CollegeCategoryController::class, 'listPaginate'])->name('admin.college_categories_paginate');
	Route::any('/edit-college-category/{row_id}',[CollegeCategoryController::class, 'editPage'])->name('admin.edit-college-category');
	Route::any('/add-college-category',[CollegeCategoryController::class, 'addPage'])->name('admin.add-college-category');
	
	#faqs
    Route::get('/faqs',[FaqsController::class, 'getList'])->name('admin.faqs');
    Route::any('/faqs_paginate',[FaqsController::class, 'listPaginate'])->name('admin.faqs_paginate');
	Route::any('/edit-faq/{row_id}',[FaqsController::class, 'editPage'])->name('admin.edit-faq');
	Route::any('/add-faq',[FaqsController::class, 'addPage'])->name('admin.add-faq');

	#states
    Route::get('/states',[StatesController::class, 'getList'])->name('admin.states');
    Route::any('/states_paginate',[StatesController::class, 'listPaginate'])->name('admin.states_paginate');
	Route::any('/edit-state/{row_id}',[StatesController::class, 'editPage'])->name('admin.edit-state');
	Route::any('/add-state',[StatesController::class, 'addPage'])->name('admin.add-state');
	
	#subscription
    Route::get('/plans',[PlansController::class, 'getList'])->name('admin.plans');
    Route::any('/plans_paginate',[PlansController::class, 'listPaginate'])->name('admin.plans_paginate');
	Route::any('/edit-plan/{row_id}',[PlansController::class, 'editPage'])->name('admin.edit-plan');
	Route::any('/add-plan',[PlansController::class, 'addPage'])->name('admin.add-plan');

	#subscription
    Route::get('/orders',[OrdersController::class, 'getList'])->name('admin.orders');
    Route::any('/orders_paginate',[OrdersController::class, 'listPaginate'])->name('admin.orders_paginate');
	Route::any('/view-order/{row_id}',[OrdersController::class, 'viewPage'])->name('admin.view-order');
	Route::any('/update-order-status',[OrdersController::class, 'updateOrderStatus'])->name('admin.update-order-status');
	
	#subscription
    Route::get('/predictors',[PredictorsController::class, 'getList'])->name('admin.predictors');
    Route::any('/predictors_paginate',[PredictorsController::class, 'listPaginate'])->name('admin.predictors_paginate');
	Route::any('/view-predictor/{row_id}',[PredictorsController::class, 'viewPage'])->name('admin.view-predictor');
		
	#admins
    Route::get('/users',[UsersController::class, 'getList'])->name('admin.users');
    Route::any('/users_paginate',[UsersController::class, 'listPaginate'])->name('admin.users_paginate');
	Route::any('/edit-user/{row_id}',[UsersController::class, 'editPage'])->name('admin.edit-user');
	Route::any('/add-user',[UsersController::class, 'addPage'])->name('admin.add-user');

	#enquiries
    Route::get('/enquiries',[ContactsController::class, 'getList'])->name('admin.enquiries');
    Route::any('/enquiries_paginate',[ContactsController::class, 'listPaginate'])->name('admin.enquiries_paginate');

	#inner pages
    Route::get('/inner-pages', [InnerPagesController::class, 'getList'])->name('admin.inner-pages');
    Route::any('/inner_pages_paginate', [InnerPagesController::class, 'listPaginate'])->name('admin.inner_pages_paginate');
    Route::any('/edit-inner-page/{row_id}', [InnerPagesController::class, 'editPage'])->name('admin.edit-inner-page');
	
	#country pages
    Route::get('/country-pages', [CountryPagesController::class, 'getList'])->name('admin.country-pages');
    Route::any('/country_pages_paginate', [CountryPagesController::class, 'listPaginate'])->name('admin.country_pages_paginate');
    Route::any('/edit-country-page/{row_id}', [CountryPagesController::class, 'editPage'])->name('admin.edit-country-page');
	Route::any('/add-country-page',[CountryPagesController::class, 'addPage'])->name('admin.add-country-page');

	#import
	Route::any('/import-colleges',[ImportController::class, 'importColleges'])->name('admin.import-colleges');
	
	#import college category
	Route::any('/import-college-categories',[ImportController::class, 'importCollegeCategories'])->name('admin.import-college-categories');
});