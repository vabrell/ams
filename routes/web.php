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
Route::post('/neptune/contracts', 'NeptuneContractsController@store')->name('neptune.contracts.store');
Route::patch('/neptune/contracts/{contract}', 'NeptuneContractsController@update');
Route::delete('/neptune/contracts/{contract}', 'NeptuneContractsController@destroy');

Route::get('/neptune/roles/create', 'NeptuneRolesController@create')->name('neptune.roles.create');
Route::post('neptune/roles', 'NeptuneRolesController@store');
Route::patch('neptune/roles/{role}', 'NeptuneRolesController@update');
Route::delete('neptune/roles/{role}', 'NeptuneRolesController@destroy');

Route::resource('accounts', 'AccountsController');


