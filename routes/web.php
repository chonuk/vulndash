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

Route::get('vulnerabilidades/import', 'VulnerabilidadController@import')->name('vulnerabilidades.import')->middleware('auth','role:admin');
Route::post('vulnerabilidades/importar', 'VulnerabilidadController@importar')->name('vulnerabilidades.importar')->middleware('auth','role:admin');
Route::resource('vulnerabilidades','VulnerabilidadController')->middleware('auth');

Route::get('plataformas/import', 'PlataformaController@import')->name('plataformas.import')->middleware('auth','role:admin');
Route::post('plataformas/importar', 'PlataformaController@importar')->name('plataformas.importar')->middleware('auth','role:admin');
Route::post('plataformas/{id}/detach', 'PlataformaController@detach')->name('plataformas.detach')->middleware('auth','role:admin');
Route::resource('plataformas','PlataformaController')->middleware('auth');

Route::get('activos/import', 'ActivoController@import')->name('activos.import')->middleware('auth','role:admin');
Route::post('activos/importar', 'ActivoController@importar')->name('activos.importar')->middleware('auth','role:admin');
Route::resource('activos','ActivoController')->middleware('auth');

#Route::post('import-file', 'ExcelController@importFile')->name('import.file')->middleware('auth');
#Route::get('export-file/{type}', 'ExcelController@exportFile')->name('export.file')->middleware('auth');

Route::resource('ocurrencias','OcurrenciaController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');;
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');