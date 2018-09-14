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
Auth::routes();
Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Ruta de Visualizacion general
Route::get('ocurrencias/{grupo}','OcurrenciaController@listar')->middleware('auth')->where('grupo', 'activos|plataformas|vulnerabilidades');
Route::resource('ocurrencias','OcurrenciaController')->middleware('auth');

// Rutas de administracion
Route::middleware(['auth','role:admin'])->group(function ()
{
	Route::get('activos/import', 'ActivoController@import')->name('activos.import');
	Route::post('activos/importar', 'ActivoController@importar')->name('activos.importar');
	Route::resource('activos','ActivoController');

	Route::get('plataformas/import', 'PlataformaController@import')->name('plataformas.import');
	Route::post('plataformas/importar', 'PlataformaController@importar')->name('plataformas.importar');
	Route::post('plataformas/{id}/detach', 'PlataformaController@detach')->name('plataformas.detach');
	Route::resource('plataformas','PlataformaController');

	Route::get('vulnerabilidades/import', 'VulnerabilidadController@import')->name('vulnerabilidades.import');
	Route::post('vulnerabilidades/importar', 'VulnerabilidadController@importar')->name('vulnerabilidades.importar');
	Route::resource('vulnerabilidades','VulnerabilidadController');
});