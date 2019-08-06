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
Route::get('/','SectionsController@index')->name('home');
Route::get('/user','UsersController@show')->name('userId');

Route::get('/project/sberbankIndividualsController','Project\SberbankIndividualsController@index')
	->name('projectSberbankIndividualsController');
Route::post('/project/sberbankIndividualsController','Project\SberbankIndividualsController@store');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');

Route::get('/logout', 'SessionsController@destroy')->name('logout');

Route::get('/statistics','StatisticsController@show')->name('statistics');
Route::post('/statistics','StatisticsController@send');

Route::get('/users/create','OktellController@createUser')->name('userCreate');
Route::post('/users/create','OktellController@storeUser');

Route::get('/users','OktellController@indexUser')->name('users');
Route::get('/users/{id}','OktellController@showUser')->name('user');
Route::post('/users/{id}','OktellController@updateUser');
#algorithmSettings
Route::get('/algorithmSettings','AlgorithmSettingsController@task')->name('algorithmSettings');
Route::get('/algorithmSettings/{id}','AlgorithmSettingsController@index')->name('algorithmSetting');
Route::post('/algorithmSettings/{id}','AlgorithmSettingsController@update');

#admin
Route::get('/admin','Admin\IndexController@index')->name('admin');
#section
Route::get('/admin/section/create','Admin\SectionController@create')->name('adminSectionCreate');
Route::post('/admin/section/create','Admin\SectionController@store');
Route::get('/admin/section/','Admin\SectionController@index')->name('adminSections');
Route::get('/admin/section/{id}','Admin\SectionController@show')->name('adminSection');
Route::post('/admin/section/{id}','Admin\SectionController@update');
Route::delete('/admin/section/{id}','Admin\SectionController@destroy');
#users
Route::get('admin/users','Admin\UsersController@index')->name('adminUsers');
Route::get('admin/users/{id}','Admin\UsersController@show')->name('adminUser');
Route::post('admin/users/{id}','Admin\UsersController@update');
#role
Route::get('/admin/role/create','Admin\RolesController@create')->name('adminRoleCreate');
Route::post('/admin/role/create','Admin\RolesController@store');
Route::get('/admin/role/','Admin\RolesController@index')->name('adminRoles');
Route::get('/admin/role/{id}','Admin\RolesController@show')->name('adminRole');
Route::post('/admin/role/{id}','Admin\RolesController@update');
Route::delete('/admin/role/{id}','Admin\RolesController@destroy');
#Task
Route::get('/admin/task/create','Admin\AlgorithmSettingsController@create')->name('adminTaskCreate');
Route::post('/admin/task/create','Admin\AlgorithmSettingsController@store');
Route::get('/admin/task','Admin\AlgorithmSettingsController@index')->name('admnTasks');
Route::get('admin/task/{id}','Admin\AlgorithmSettingsController@show')->name('admnTask');
Route::post('/admin/task/{id}','Admin\AlgorithmSettingsController@update');




