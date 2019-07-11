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

Route::get('/project/sberbankIndividualsController','Project\SberbankIndividualsController@index');
Route::post('/project/sberbankIndividualsController','Project\SberbankIndividualsController@store');
//Auth::routes();
//Route::get('/register', 'RegistrationController@create');
//Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy')->name('logout');

/*
Route::get('/home', 'HomeController@index')->name('home');*/

Route::get('/statistics','StatisticsController@show')->name('statisticsId');
Route::post('/statistics','StatisticsController@send');

Route::get('/users/create','OktellController@createUser');
Route::post('/users/create','OktellController@storeUser');

Route::get('/users','OktellController@indexUser');
Route::get('/users/{id}','OktellController@showUser');
Route::post('/users/{id}','OktellController@updateUser');

Route::get('/algorithmSettings','AlgorithmSettingsController@task');
Route::get('/algorithmSettings/{id}','AlgorithmSettingsController@index');
Route::post('/algorithmSettings/{id}','AlgorithmSettingsController@update');
Route::get('/admin','Admin\IndexController@index')->name('admin');
#section
Route::get('/admin/section/create','Admin\SectionController@create');
Route::post('/admin/section/create','Admin\SectionController@store');
Route::get('/admin/section/','Admin\SectionController@index')->name('sections');
Route::get('/admin/section/{id}','Admin\SectionController@show');
Route::post('/admin/section/{id}','Admin\SectionController@update');
Route::delete('/admin/section/{id}','Admin\SectionController@destroy');
#users
Route::get('admin/users','Admin\UsersController@index');
Route::get('admin/users/{id}','Admin\UsersController@show');
Route::post('admin/users/{id}','Admin\UsersController@update');
#role
Route::get('/admin/role/create','Admin\RolesController@create');
Route::post('/admin/role/create','Admin\RolesController@store');
Route::get('/admin/role/','Admin\RolesController@index');
Route::get('/admin/role/{id}','Admin\RolesController@show');
Route::post('/admin/role/{id}','Admin\RolesController@update');
Route::delete('/admin/role/{id}','Admin\RolesController@destroy');
#algorithmSettings
Route::get('/admin/task/create','Admin\AlgorithmSettingsController@create');
Route::post('/admin/task/create','Admin\AlgorithmSettingsController@store');
Route::get('admin/task','Admin\AlgorithmSettingsController@index');
Route::get('admin/task/{id}','Admin\AlgorithmSettingsController@show');
Route::post('admin/task/{id}','Admin\AlgorithmSettingsController@update');




