<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\etablissementController;
use App\Http\Controllers\locauxControlelr;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\equipementController;
use App\Http\Controllers\typeLocauxController;

Route::resource('etablissement', etablissementController::class);
// Route::get('/etablissement/create', [etablissementController::class, 'index']) ;
Route::post('/etablissement/{id}/import', [EtablissementController::class, 'import'])
    ->name('etablissement.import');

Route::resource('locaux', locauxControlelr::class);
Route::resource('categorie', categoryController::class);
Route::resource('equipement', equipementController::class);
Route::get('/etablissement/{id}/deplacer', [equipementController::class, 'deplacerEquipement'])
    ->name('equipement.deplacer');

Route::post('/etablissement/{id}/deplacer', [equipementController::class, 'getEquipementById'])
    ->name('equipement.get');

Route::post('/etablissement/deplacer', [equipementController::class, 'historique'])
    ->name('equipement.historique');

