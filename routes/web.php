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
#tecos
Route::get('/project/tecos','Project\sberbankLE\TecosController@index')->name('tecos');
Route::get('/project/tecos/{id}','Project\sberbankLE\TecosController@show')->name('tecosShow');
Route::get('/project/tecos/start/{id}/{id_campaign}/{date}','Project\sberbankLE\TecosController@start')
	->name('tecosStart');
Route::get(
		'/project/tecos/stopTemporarily/{id}/{id_campaign}/{date}'
		,'Project\sberbankLE\TecosController@stopTemporarily'
	)->name('tecosStopTemporarily');
Route::get('/project/tecos/stopForever/{id}/{id_campaign}/{date}','Project\sberbankLE\TecosController@stopForever')
	->name('tecosStopForever');
//Route::post('/project/sberbankLE/Tecos','Project\sberbankLE\Tecos@store');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');

Route::get('/logout', 'SessionsController@destroy')->name('logout');

Route::get('/statistics','StatisticsController@show')->name('statistics');
Route::post('/statistics','StatisticsController@send');

Route::get('/users/create','OktellController@createUser')->name('userCreate');
Route::post('/users/create','OktellController@storeUser')->name('userStore');

Route::get('/users','OktellController@indexUser')->name('users');
Route::get('/users/{id}','OktellController@showUser')->name('user');
Route::post('/users/{id}','OktellController@updateUser')->name('userUpdate');

#algorithmSettings
Route::get('/algorithmSettings','AlgorithmSettingsController@task')->name('algorithmSettings');
Route::get('/algorithmSettings/{id}','AlgorithmSettingsController@index')->name('algorithmSetting');
Route::post('/algorithmSettings/{id}','AlgorithmSettingsController@update');
#exclusion Database 
Route::get('/DatabaseExclusion','DatabaseExclusionController@index')->name('DatabaseExclusions');
Route::get('/DatabaseExclusion/{id}','DatabaseExclusionController@show')->name('DatabaseExclusion');
Route::post('/DatabaseExclusion/{id}','DatabaseExclusionController@exclusion');
Route::post('/DatabaseInclusion/{id}','DatabaseExclusionController@inclusion');

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
Route::get('/admin/task/{id}','Admin\AlgorithmSettingsController@show')->name('admnTask');
Route::post('/admin/task/{id}','Admin\AlgorithmSettingsController@update');
#exclusion Database
Route::get('/admin/DatabaseExclusion/','Admin\DatabaseExclusionController@index')->name('admnDatabaseExclusions');
Route::get('/admin/DatabaseExclusion/{id}/','Admin\DatabaseExclusionController@show')->name('admnDatabaseExclusion');
Route::post('/admin/DatabaseExclusion/{id}/','Admin\DatabaseExclusionController@update');
#project
Route::get('/admin/project/','Admin\ProjectController@index');
Route::get('/admin/project/{id}','Admin\ProjectController@show');
Route::post('/admin/project/{id}','Admin\ProjectController@update');
#SberBank LE
Route::get('/admin/project/sberbank/tecos/create','Admin\project\sberbankLE\TecosController@create')
	->name('adminProjectSberbankTecosCreate');
Route::post('/admin/project/sberbank/tecos/create','Admin\project\sberbankLE\TecosController@store');
Route::get('/admin/project/sberbank/tecos','Admin\project\sberbankLE\TecosController@index');
Route::get('/admin/project/sberbank/tecos/{id}','Admin\project\sberbankLE\TecosController@show');
Route::post('/admin/project/sberbank/tecos/{id}','Admin\project\sberbankLE\TecosController@update');
Route::delete('/admin/project/sberbank/tecos/{id}','Admin\project\sberbankLE\TecosController@destroy');
#City
Route::get('/admin/city/create','Admin\CityController@create')
	->name('adminCityCreate');
Route::post('/admin/city/create','Admin\CityController@store');
Route::get('/admin/city','Admin\CityController@index');
Route::get('/admin/city/{id}','Admin\CityController@show');
Route::post('/admin/city/{id}','Admin\CityController@update');
Route::delete('/admin/city/{id}','Admin\CityController@destroy');



