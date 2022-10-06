<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PubliController;
use App\Http\Controllers\API\UserController;

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

Route::middleware(['cors'])->group(function (){

    Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login'])->name('login');
    
    Route::group(['middleware' => ['auth:sanctum']], function(){
        
        /** All Levels */
        Route::get('/profile', function(Request $request){
            return auth()->user();
        });
        
        /** User */
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::get('/user/{id}', [UserController::class, 'detail_data'])->name('user_data');
        Route::get('/user/download/{id}', [UserController::class, 'downloadDocument'])->name('user_download');
    
        /** Validator */
        Route::get('/validator', [App\Http\Controllers\API\ValidatorController::class, 'index'])->name('validator');
        Route::get('/validator/{id}', [App\Http\Controllers\API\ValidatorController::class, 'detail_data'])->name('validator_data');
        Route::get('/validator/unvalidated', [App\Http\Controllers\API\ValidatorController::class, 'no_validasi_data'])->name('validator_unvalidated');
        Route::post('/validator/validating/{id}/{status}', [App\Http\Controllers\API\ValidatorController::class, 'validasi_data'])->name('validator_validating');
        Route::get('/validator/download/{id}', [App\Http\Controllers\API\UserController::class, 'downloadDocument'])->name('validator_downoadDocument');
        
        /** Admin */
        Route::get('/admin', [App\Http\Controllers\API\AdminController::class, 'index'])->name('admin');
        Route::post('/admin/add_data', [App\Http\Controllers\API\AdminController::class, 'addData'])->name('admin_data');
        Route::post('/admin/data/{id}', [App\Http\Controllers\API\AdminController::class, 'deleteData'])->name('admin_deleteData');
        Route::post('/admin/data/edit/{id}', [App\Http\Controllers\API\AdminController::class, 'editData'])->name('admin_editData');
        Route::get('/admin/users', [App\Http\Controllers\API\AdminController::class, 'users'])->name('admin_users');
        Route::post('/admin/add_user', [App\Http\Controllers\API\AdminController::class, 'addUsers'])->name('admin_addUser');
        Route::post('/admin/user/{id}', [App\Http\Controllers\API\AdminController::class, 'deleteUser'])->name('admin_deleteUser');
        Route::post('/admin/user/edit/{id}', [App\Http\Controllers\API\AdminController::class, 'editUser'])->name('admin_editUser');
        Route::get('/admin/data/download/{id}', [App\Http\Controllers\API\UserController::class, 'downloadDocument'])->name('admin_downloadDocument');
        Route::get('/admin/data/detail/{id}', [App\Http\Controllers\API\AdminController::class, 'detail_data'])->name('admin_detailData');
        Route::get('/admin/user/detail/{id}', [App\Http\Controllers\API\AdminController::class, 'detail_user'])->name('admin_detailUser');
    
        /** All Levels */
        Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
    });
    
    /** Public  */
    Route::get('/public', [App\Http\Controllers\API\PublicController::class, 'index'])->name('public');
    Route::get('public/{id}', [App\Http\Controllers\API\PublicController::class, 'detail_data'])->name('public_detail');
    
    Route::get('/cleareverything', function () {
        $clearcache = Artisan::call('cache:clear');
        echo "Cache cleared<br>";
    
        $clearview = Artisan::call('view:clear');
        echo "View cleared<br>";
    
        $clearconfig = Artisan::call('config:cache');
        echo "Config cleared<br>";
    
        $cleardebugbar = Artisan::call('debugbar:clear');
        echo "Debug Bar cleared<br>";
    });
});



