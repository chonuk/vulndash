<?php

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

Route::get('vulnsinfra/import', 'VulnInfraController@import')->name('vulnsinfra.import');
Route::post('vulnsinfra/importar', 'VulnInfraController@importar')->name('vulnsinfra.importar');
Route::resource('vulnsinfra','VulnInfraController');

Route::get('vulnsserpico/import', 'VulnSerpicoController@import')->name('vulnsserpico.import');
Route::post('vulnsserpico/importar', 'VulnSerpicoController@importar')->name('vulnsserpico.importar');
Route::resource('vulnsserpico','VulnSerpicoController');

Route::get('plataformas/import', 'PlataformaController@import')->name('plataformas.import');
Route::post('plataformas/importar', 'PlataformaController@importar')->name('plataformas.importar');
Route::post('plataformas/{id}/detach', 'PlataformaController@detach')->name('plataformas.detach');
Route::resource('plataformas','PlataformaController');

Route::get('activos/import', 'ActivoController@import')->name('activos.import');
Route::post('activos/importar', 'ActivoController@importar')->name('activos.importar');
Route::resource('activos','ActivoController');

Route::post('import-file', 'ExcelController@importFile')->name('import.file');
Route::get('export-file/{type}', 'ExcelController@exportFile')->name('export.file');

Route::get('vulnerabilidades/plataformas/{id?}', 'VulnerabilidadController@plataformas')->name('vulnerabilidades.plataformas');
Route::get('vulnerabilidades/data', 'VulnerabilidadController@data')->name('vulnerabilidades.data');
Route::resource('vulnerabilidades','VulnerabilidadController');