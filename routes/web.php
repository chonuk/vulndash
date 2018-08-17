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
    return view('home');
})->middleware('auth');;

Route::get('vulnsinfra/import', 'VulnInfraController@import')->name('vulnsinfra.import')->middleware('auth');
Route::post('vulnsinfra/importar', 'VulnInfraController@importar')->name('vulnsinfra.importar')->middleware('auth');
Route::resource('vulnsinfra','VulnInfraController')->middleware('auth');

Route::get('vulnsserpico/import', 'VulnSerpicoController@import')->name('vulnsserpico.import')->middleware('auth');
Route::post('vulnsserpico/importar', 'VulnSerpicoController@importar')->name('vulnsserpico.importar')->middleware('auth');
Route::resource('vulnsserpico','VulnSerpicoController')->middleware('auth');

Route::get('plataformas/import', 'PlataformaController@import')->name('plataformas.import')->middleware('auth');
Route::post('plataformas/importar', 'PlataformaController@importar')->name('plataformas.importar')->middleware('auth');
Route::post('plataformas/{id}/detach', 'PlataformaController@detach')->name('plataformas.detach')->middleware('auth');
Route::resource('plataformas','PlataformaController')->middleware('auth');

Route::get('activos/import', 'ActivoController@import')->name('activos.import')->middleware('auth');
Route::post('activos/importar', 'ActivoController@importar')->name('activos.importar')->middleware('auth');
Route::resource('activos','ActivoController')->middleware('auth');

Route::post('import-file', 'ExcelController@importFile')->name('import.file')->middleware('auth');
Route::get('export-file/{type}', 'ExcelController@exportFile')->name('export.file')->middleware('auth');

Route::get('vulnerabilidades/plataformas/{id?}', 'VulnerabilidadController@plataformas')->name('vulnerabilidades.plataformas')->middleware('auth');
Route::get('vulnerabilidades/data', 'VulnerabilidadController@data')->name('vulnerabilidades.data')->middleware('auth');
Route::resource('vulnerabilidades','VulnerabilidadController')->middleware('auth');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');;
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');