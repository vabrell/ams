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

// Neptune services
Route::get('/neptune', 'NeptuneController@index')->name('neptune.index')->middleware('hr');

// Neptune contracts
Route::get('/neptune/contracts/create', 'NeptuneContractsController@create')->name('neptune.contracts.create')->middleware('hr');
Route::get('/neptune/contracts/{contract}', 'NeptuneContractsController@show')->name('neptune.contracts.show')->middleware('hr');
Route::get('/neptune/contracts/{contract}/edit', 'NeptuneContractsController@edit')->name('neptune.contracts.edit')->middleware('hr');
Route::post('/neptune/contracts', 'NeptuneContractsController@store')->name('neptune.contracts.store');
Route::patch('/neptune/contracts/{contract}', 'NeptuneContractsController@update')->name('neptune.contracts.update')->middleware('hr');
Route::delete('/neptune/contracts/{contract}', 'NeptuneContractsController@destroy')->name('neptune.contracts.destroy')->middleware('hr');

// Neptune roles
Route::get('/neptune/roles/create', 'NeptuneRolesController@create')->name('neptune.roles.create')->middleware('hr');
Route::get('/neptune/roles/{role}', 'NeptuneRolesController@show')->name('neptune.roles.show')->middleware('hr');
Route::get('/neptune/roles/{role}/edit', 'NeptuneRolesController@edit')->name('neptune.roles.edit')->middleware('hr');
Route::post('neptune/roles', 'NeptuneRolesController@store')->name('neptune.roles.store')->middleware('hr');
Route::patch('neptune/roles/{role}', 'NeptuneRolesController@update')->name('neptune.roles.update')->middleware('hr');
Route::delete('neptune/roles/{role}', 'NeptuneRolesController@destroy')->name('neptune.roles.destroy')->middleware('hr');

// Account services
Route::get('/accounts', 'AccountsController@index')->name('accounts.index');
Route::post('/accounts/{account}/{type}/reset', 'AccountsController@resetPassword')->name('accounts.resetpwd');
Route::post('/accounts/{account}/{type}/unlock', 'AccountsController@unlockAccount')->name('accounts.unlock');
Route::post('/accounts/{account}/server', 'AccountsController@serverAdd')->name('accounts.server.add');

// Employees
Route::get('/accounts/employee', 'AccountsController@employeeIndex')->name('accounts.employee.index')->middleware('servicedesk');
Route::post('/accounts/employee', 'AccountsController@employeeSearch')->name('accounts.employee.search')->middleware('servicedesk');
Route::get('/accounts/employee/{account}', 'AccountsController@employeeShow')->name('accounts.employee.show')->middleware('servicedesk');

// Consultants
Route::get('/accounts/consultants', 'AccountsController@consultantIndex')->name('accounts.consultants.index')->middleware('systemadmin');
Route::get('/accounts/consultants/create', 'AccountsController@create')->name('accounts.consultants.create')->middleware('systemadmin');
Route::get('/accounts/consultants/{account}/edit', 'AccountsController@edit')->name('accounts.consultants.edit')->middleware('systemadmin');
Route::get('/accounts/consultants/active', 'AccountsController@active')->name('accounts.consultants.active')->middleware('systemadmin');
Route::get('/accounts/consultants/{account}', 'AccountsController@show')->name('accounts.consultants.show')->middleware('systemadmin');
Route::get('/accounts/consultants/{account}/task', 'AccountsController@createTask')->name('accounts.consultants.task')->middleware('systemadmin');
Route::post('/accounts/consultants', 'AccountsController@store')->name('accounts.consultants.store')->middleware('systemadmin');
Route::post('/accounts/consultants/{account}/task', 'AccountsController@storeTask')->name('accounts.consultants.storeTask')->middleware('systemadmin');
Route::post('/accounts/consultants/search', 'AccountsController@consultantSearch')->name('accounts.consultants.search')->middleware('systemadmin');
Route::patch('/accounts/consultants/{account}', 'AccountsController@update')->name('accounts.consultants.update')->middleware('systemadmin');
Route::delete('/accounts/consultants/{account}', 'AccountsController@destroy')->name('accounts.consultants.delete')->middleware('systemadmin');

// Students
Route::get('/accounts/students/kk', 'AccountsController@studentsKKIndex')->name('accounts.students.kk.index')->middleware('schooladminkk');
Route::post('/accounts/students/kk', 'AccountsController@studentsKKSearch')->name('accounts.students.kk.search')->middleware('schooladminkk');
Route::get('/accounts/students/kk/{account}', 'AccountsController@studentsKKShow')->name('accounts.students.kk.show')->middleware('schooladminkk');
Route::get('/accounts/students/le', 'AccountsController@studentsLEIndex')->name('accounts.students.le.index')->middleware('schooladminle');
Route::post('/accounts/students/le', 'AccountsController@studentsLESearch')->name('accounts.students.le.search')->middleware('schooladminle');
Route::get('/accounts/students/le/{account}', 'AccountsController@studentsLEShow')->name('accounts.students.le.show')->middleware('schooladminle');

// Reports
Route::get('/reports', 'ReportsController@index')->name('reports.index')->middleware('systemadmin');
Route::get('/reports/tasks', 'ReportsController@tasks')->name('reports.tasks.index')->middleware('systemadmin');
Route::post('/reports/tasks', 'ReportsController@searchTasks')->name('reports.tasks.search')->middleware('systemadmin');

// Settings
Route::get('/settings', 'HomeController@settings')->name('settings.index')->middleware('admin');

// Customers
Route::get('/settings/customer', 'CustomersController@index')->name('settings.customer.index')->middleware('admin');
Route::get('/settings/customer/create', 'CustomersController@create')->name('settings.customer.create')->middleware('admin');
Route::get('/settings/customer/{customer}/edit', 'CustomersController@edit')->name('settings.customer.edit')->middleware('admin');
Route::post('/settings/customer', 'CustomersController@store')->name('settings.customer.store')->middleware('admin');
Route::patch('/settings/customer/{customer}', 'CustomersController@update')->name('settings.customer.patch')->middleware('admin');

// Import
Route::get('/settings/import', 'ImportsController@index')->name('settings.import.index')->middleware('admin');
Route::get('/settings/import/{account}', 'ImportsController@show')->name('settings.import.show')->middleware('admin');
Route::post('/settings/import', 'ImportsController@store')->name('settings.import.store')->middleware('admin');

// Logs
Route::get('/logs', 'SamsLogController@index')->name('logs.index')->middleware('admin');
Route::post('/logs', 'SamsLogController@search')->name('logs.search')->middleware('admin');
