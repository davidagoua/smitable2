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

Route::any("/login",[
    \App\Http\Controllers\AuthController::class,
    "login"
])->name("login");

Route::middleware('auth')
    ->group(function(){

        Route::any("/logout", [
            \App\Http\Controllers\AuthController::class,
            "logout"
        ])->name("logout");

        Route::get('/', \App\Http\Livewire\HomePage::class)->name('home');

        Route::get('/test', function(){
            return view('test');
        });

        Route::controller(\App\Http\Controllers\HomeController::class)
            ->name('home.')
            ->group(function(){
                Route::get('/patients', 'patient_list')->name('patient_list');
                Route::get('/patients-consultes', 'patient_consultes')->name('patient_consultes');
                Route::get('ajouter/', 'patient_add')->name('patient_add');
                Route::get('recherche/', 'search')->name('search');
            });

        Route::get('urgence/add-patient', [
            \App\Http\Controllers\UrgenceController::class,
            'form'
        ])->name('urgence.patient_add');
        Route::get('urgence/list-patient', [
            \App\Http\Controllers\UrgenceController::class,
            'liste'
        ])->name('urgence.patient_list');

        Route::controller(\App\Http\Controllers\ServiceController::class)
            ->name('services.')
            ->prefix('services/')
            ->group(function(){
                Route::get('{service}/liste/', 'index')->name('liste');
                Route::get('{service}/edit/', 'edit')->name('edit');
                Route::get('service/dossier/{appointement}', 'service_form')->name('form');
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
                Route::get('demandes/', 'analyse_demandes')->name('demandes');
                Route::get('terminees/', 'analyse_termines')->name('termines');
            });

        Route::controller(\App\Http\Controllers\PharmacieController::class)
            ->name('pharmacie.')
            ->prefix('pharmacie/')
            ->group(function(){
                Route::get('ordonances/', 'list_ordonance')->name('list_ordonance');
                Route::get('stock/', 'stock')->name('stock');
            });

    });

Route::view('/users', 'settings.user')->name('user-resource');
Route::view('/services', 'settings.services')->name('service-resource');
