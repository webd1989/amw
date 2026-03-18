<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExportsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->group(function(){

	Route::any('/export-enquiry',[ExportsController::class, 'exportEnquiry'])->name('exports.enquiries');
	Route::any('/export-college',[ExportsController::class, 'exportCollege'])->name('exports.college');
	Route::any('/export-sitemap',[ExportsController::class, 'exportSitemap'])->name('exports.sitemap');
	
	Route::any('/download-file/{file_name}',[ExportsController::class, 'downloadFile'])->name('downloadFile');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});