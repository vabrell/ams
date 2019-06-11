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

Route::get('/accounts', 'AccountsController@index')->name('accounts.index');

Route::get('/accounts/search', 'AccountsController@adIndex')->name('accounts.ad.index');
Route::post('/accounts/search', 'AccountsController@adSearch')->name('accounts.ad.search');
Route::get('/accounts/search/{account}', 'AccountsController@adShow')->name('accounts.ad.show');
Route::post('/accounts/{account}/reset', 'AccountsController@resetPassword')->name('accounts.ad.resetpwd');
Route::post('/accounts/{account}/unlock', 'AccountsController@unlockAccount')->name('accounts.ad.unlock');

Route::post('/accounts/consultants', 'AccountsController@store')->name('accounts.consultants.store');
Route::patch('/accounts/consultants/{account}', 'AccountsController@update')->name('accounts.consultants.update');
Route::delete('/accounts/consultants/{account}', 'AccountsController@destroy')->name('accounts.consultants.delete');

Route::get('/logs', 'SamsLogController@index')->name('logs.index');
