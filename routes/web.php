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

Auth::routes([
    'register'  => false,
    'verify'    => false,
    'reset'    => false,
]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/neptune', 'NeptuneController@index')->name('neptune.index');

Route::get('/neptune/contracts/create', 'NeptuneContractsController@create')->name('neptune.contracts.create');
Route::get('/neptune/contracts/{contract}', 'NeptuneContractsController@show')->name('neptune.contracts.show');
Route::get('/neptune/contracts/{contract}/edit', 'NeptuneContractsController@edit')->name('neptune.contracts.edit');
Route::post('/neptune/contracts', 'NeptuneContractsController@store')->name('neptune.contracts.store');
Route::patch('/neptune/contracts/{contract}', 'NeptuneContractsController@update')->name('neptune.contracts.update');
Route::delete('/neptune/contracts/{contract}', 'NeptuneContractsController@destroy')->name('neptune.contracts.destroy');

Route::get('/neptune/roles/create', 'NeptuneRolesController@create')->name('neptune.roles.create');
Route::get('/neptune/roles/{role}', 'NeptuneRolesController@show')->name('neptune.roles.show');
Route::get('/neptune/roles/{role}/edit', 'NeptuneRolesController@edit')->name('neptune.roles.edit');
Route::post('neptune/roles', 'NeptuneRolesController@store')->name('neptune.roles.store');
Route::patch('neptune/roles/{role}', 'NeptuneRolesController@update')->name('neptune.roles.update');
Route::delete('neptune/roles/{role}', 'NeptuneRolesController@destroy')->name('neptune.roles.destroy');


