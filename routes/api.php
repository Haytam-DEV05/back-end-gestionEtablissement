<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\etablissementApiController;
use App\Http\Controllers\API\equipementApiController;
use App\Http\Controllers\API\locauxApiController;
use App\Http\Controllers\API\historiqueApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




// ETABLISSEMENTS  =>
Route::apiResource('etablissements', etablissementApiController::class);
Route::get('/etablissement/{id}/equipements', [etablissementApiController::class, 'getEquipementsByEtablissement']);


// IMPORTATION && EXPORTATION =>
Route::post('/etablissements/{id}/import', [etablissementApiController::class, 'import']);
Route::get('/export-equipements/{id}', [etablissementApiController::class, 'exportEquipements']);

// EQUIPEMENT API =>
Route::apiResource('equipements', equipementApiController::class);
Route::get('/equipements/custom/{id}', [equipementApiController::class, 'grabEquipements']);

// LOCAUXES API =>
Route::apiResource('locaux', locauxApiController::class);
Route::get('/locaux/custom/{id}', [locauxApiController::class, 'getLocauxEtab']);


// HISTORIQUES =>
Route::apiResource('historiques', historiqueApiController::class);