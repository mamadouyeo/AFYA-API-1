<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Importer les controller
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * ----------------------
 *  API AFYA ENDPOINTS
 *    AFYAAPI v1
 * ----------------------
 */


   /**
    *---------------
    * API PATIENT
    *---------------
    */
     //inscription
     Route::match(['GET','POST'],'inscriptionPatient',[PatientController::class, 'inscriptionPatient']);
     //connection
     Route::match(['GET','POST'],'loginPatient',[PatientController::class, 'loginPatient']);
    

    /**
    *---------------
    * API PHARMACIE
    *---------------
    */


    /**
    *---------------
    * API ADMIN
    *---------------
    */



   