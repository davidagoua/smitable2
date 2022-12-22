<?php

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
    return view('base');
});

Route::get('/test', function(){
    return view('test');
});

Route::controller(\App\Http\Controllers\HomeController::class)
    ->name('home.')
    ->group(function(){
    Route::get('/patients', 'patient_list')->name('patient_list');
    Route::get('ajouter/', 'patient_add')->name('patient_add');
});

Route::controller(\App\Http\Controllers\ServiceController::class)
    ->name('services.')
    ->prefix('services/')
    ->group(function(){
       Route::get('{service}/liste/', 'index')->name('liste');
       Route::get('{service}/edit/', 'edit')->name('edit');
    });


Route::controller(\App\Http\Controllers\HospitalisationController::class)
    ->name('hospi.')
    ->prefix('hospitalisation/')
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/chambre', 'chambre')->name('chambre');
    });

Route::controller(\App\Http\Controllers\AnalyseController::class)
    ->name('analyse.')
    ->prefix('analyse/')
    ->group(function(){
        Route::get('/', 'analyse_appointement_list')->name('analyse_appointement_list');
        Route::get('liste/', 'analyse_list')->name('liste');
    });
