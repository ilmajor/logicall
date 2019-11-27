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

Route::get('/login', 'SessionsController@create')->name('login');
Route::get('/logout', 'SessionsController@destroy')->name('logout');
Route::post('/login', 'SessionsController@store');
Route::middleware(['auth'])->group(function () {
	
	Route::get('/user','UsersController@show')->name('userId');
	
	Route::get('/','SectionsController@index')->name('home');
	Route::get('/statistics','StatisticsController@show')->name('statistics');
	Route::post('/statistics','StatisticsController@send');
	#sberbankFU
	Route::middleware(['OktellProject:16'])->group(function () {
		Route::get('/project/sberbankIndividuals','Project\SberbankIndividualsController@index')
			->name('projectSberbankIndividuals');
		Route::post('/project/sberbankIndividuals','Project\SberbankIndividualsController@store');
	});	

	Route::middleware(['AuthManager'])->group(function () {
		#tecos
		Route::middleware(['OktellProject:27'])->group(function () {
			Route::get('/project/tecos','Project\sberbankLE\TecosController@index')->name('tecos');
			Route::get('/project/tecos/{task}','Project\sberbankLE\TecosController@show')->name('tecosShow');
			Route::get('/project/tecos/start/{task}/{id_campaign}/{date}','Project\sberbankLE\TecosController@start')
				->name('tecosStart');
			Route::get(
					'/project/tecos/stopTemporarily/{task}/{id_campaign}/{date}'
					,'Project\sberbankLE\TecosController@stopTemporarily'
				)
				->name('tecosStopTemporarily');
			Route::get('/project/tecos/stopForever/{task}/{id_campaign}/{date}','Project\sberbankLE\TecosController@stopForever')
				->name('tecosStopForever');
		});	

		Route::get('/users/create','OktellController@createUser')->name('userCreate');
		Route::post('/users/create','OktellController@storeUser')->name('userStore');

		Route::get('/users','OktellController@indexUser')->name('users');
		Route::get('/users/{user}','OktellController@showUser')->name('user');
		Route::post('/users/{user}','OktellController@updateUser')->name('userUpdate');

		#algorithmSettings
		Route::get('/algorithmSettings','AlgorithmSettingsController@index')->name('algorithmSettings');
		Route::get('/algorithmSettings/{task}','AlgorithmSettingsController@show')->name('algorithmSetting');
		Route::post('/algorithmSettings/{task}','AlgorithmSettingsController@update');
		#exclusion Database 
		Route::get('/DatabaseExclusion','DatabaseExclusionController@index')->name('DatabaseExclusions');
		Route::get('/DatabaseExclusion/{task}','DatabaseExclusionController@show')->name('DatabaseExclusion');
		Route::post('/DatabaseExclusion/{task}','DatabaseExclusionController@exclusion');
		Route::post('/DatabaseInclusion/{task}','DatabaseExclusionController@inclusion');
	});	
	Route::middleware(['AuthAdmin'])->group(function () {

		#admin
		Route::get('/admin','Admin\IndexController@index')->name('admin');
		#users
		Route::get('admin/users','Admin\UsersController@index')->name('adminUsers');
		Route::get('admin/users/{user}','Admin\UsersController@show')->name('adminUser');
		Route::post('admin/users/{user}','Admin\UsersController@update');
		#section
		Route::get('/admin/section/create','Admin\SectionController@create')->name('adminSectionCreate');
		Route::post('/admin/section/create','Admin\SectionController@store');
		Route::get('/admin/section/','Admin\SectionController@index')->name('adminSections');
		Route::get('/admin/section/{section}','Admin\SectionController@show')->name('adminSection');
		Route::post('/admin/section/{section}','Admin\SectionController@update');
		Route::delete('/admin/section/{section}','Admin\SectionController@destroy');

		#role
		Route::get('/admin/role/create','Admin\RolesController@create')->name('adminRoleCreate');
		Route::post('/admin/role/create','Admin\RolesController@store');
		Route::get('/admin/role/','Admin\RolesController@index')->name('adminRoles');
		Route::get('/admin/role/{role}','Admin\RolesController@show')->name('adminRole');
		Route::post('/admin/role/{role}','Admin\RolesController@update');
		Route::delete('/admin/role/{role}','Admin\RolesController@destroy');
		#Task
		Route::get('/admin/task/create','Admin\AlgorithmSettingsController@create')->name('adminTaskCreate');
		Route::post('/admin/task/create','Admin\AlgorithmSettingsController@store');
		Route::get('/admin/task','Admin\AlgorithmSettingsController@index')->name('admnTasks');
		Route::get('/admin/task/{task}','Admin\AlgorithmSettingsController@show')->name('admnTask');
		Route::post('/admin/task/{task}','Admin\AlgorithmSettingsController@update');
		#exclusion Database
		Route::get('/admin/DatabaseExclusion/','Admin\DatabaseExclusionController@index')->name('admnDatabaseExclusions');
		Route::get('/admin/DatabaseExclusion/{task}/','Admin\DatabaseExclusionController@show')->name('admnDatabaseExclusion');
		Route::post('/admin/DatabaseExclusion/{task}/','Admin\DatabaseExclusionController@update');
		#project
		Route::get('/admin/project/','Admin\ProjectController@index');
		Route::get('/admin/project/{project}','Admin\ProjectController@show');
		Route::post('/admin/project/{project}','Admin\ProjectController@update');
		#SberBank LE
		Route::get('/admin/project/sberbank/tecos/create','Admin\project\sberbankLE\TecosController@create')
			->name('adminProjectSberbankTecosCreate');
		Route::post('/admin/project/sberbank/tecos/create','Admin\project\sberbankLE\TecosController@store');
		Route::get('/admin/project/sberbank/tecos','Admin\project\sberbankLE\TecosController@index');
		Route::get('/admin/project/sberbank/tecos/{task}','Admin\project\sberbankLE\TecosController@show');
		Route::post('/admin/project/sberbank/tecos/{task}','Admin\project\sberbankLE\TecosController@update');
		Route::delete('/admin/project/sberbank/tecos/{task}','Admin\project\sberbankLE\TecosController@destroy');
		#City
		Route::get('/admin/city/create','Admin\CityController@create')
			->name('adminCityCreate');
		Route::post('/admin/city/create','Admin\CityController@store');
		Route::get('/admin/city','Admin\CityController@index');
		Route::get('/admin/city/{city}','Admin\CityController@show');
		Route::post('/admin/city/{city}','Admin\CityController@update');
		Route::delete('/admin/city/{city}','Admin\CityController@destroy');
		#ContractingOrganization
		Route::get('/admin/ContractingOrganization/create','Admin\ContractingOrganizationController@create')
			->name('adminCityCreate');
		Route::post('/admin/ContractingOrganization/create','Admin\ContractingOrganizationController@store');
		Route::get('/admin/ContractingOrganization','Admin\ContractingOrganizationController@index');
		Route::get('/admin/ContractingOrganization/{ContractingOrganization}','Admin\ContractingOrganizationController@show');
		Route::post('/admin/ContractingOrganization/{ContractingOrganization}','Admin\ContractingOrganizationController@update');
		Route::delete('/admin/ContractingOrganization/{ContractingOrganization}','Admin\ContractingOrganizationController@destroy');
	});	

});	




