<?php

use App\Http\Controllers\DormitoryController;
use App\Http\Controllers\DynamicFormController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\StudentDormitoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dynamic_form',[DynamicFormController::class,'index'])->name('dynamic_form.index');
    Route::get('/dynamic_form/create',[DynamicFormController::class,'create'])->name('dynamic_form.create');
    Route::get('/dynamic_form/show/{slug}',[DynamicFormController::class,'show'])->name('dynamic_form.show');
    Route::get('/dynamic_form/all_users/{slug}',[DynamicFormController::class,'allUser'])->name('dynamic_form.all_users');
    Route::get('/dynamic_form/edit/{slug}',[DynamicFormController::class,'edit'])->name('dynamic_form.edit');
    Route::post('/dynamic_form/store',[DynamicFormController::class,'store'])->name('dynamic_form.store');
   
    Route::get('/dynamic_form_value/create/{name}',[DynamicFormController::class,'dynamicFormValueCreate'])->name('dynamic_form_value.create');
    Route::post('dynamic_form_value/{name}',[DynamicFormController::class,'dynamicFormValueStore'])->name('dynamic_form_value.store');
    Route::post('dynamic_form_value/update/{name}',[DynamicFormController::class,'dynamicFormValueUpdate'])->name('dynamic_form_value.update');

});




require __DIR__.'/auth.php';
