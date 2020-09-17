<?php

// login
Breadcrumbs::for('login', function ($trail) {
    $trail->push('login', route('login'));
});

// logout
Breadcrumbs::for('logout', function ($trail) {
    $trail->push('logout', route('logout'));
});


// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

// Home > userId
Breadcrumbs::for('userId', function ($trail) {
    $trail->parent('home');
    $trail->push('Пользовательские данные', route('userId'));
});

Breadcrumbs::for('test', function ($trail) {
    $trail->push('test', route('test'));
});

// Home > projectSberbankIndividualsController
Breadcrumbs::for('projectSberbankIndividuals', function ($trail) {
    $trail->parent('home');
    $trail->push('Претензии по Follow-Up', route('projectSberbankIndividuals'));
});

// Home > projectalfabankUrl
Breadcrumbs::for('alfabankUrl', function ($trail) {
    $trail->parent('home');
    $trail->push('Претензии по Follow-Up', route('alfabankUrl'));
});

// Home > DatabaseExclusion
Breadcrumbs::for('DatabaseExclusions', function ($trail) {
    $trail->parent('home');
    $trail->push('Исключение баз', route('DatabaseExclusions'));
});

// Home > DatabaseExclusion > [DatabaseExclusion]
Breadcrumbs::for('DatabaseExclusion', function ($trail, $Task) {
    $trail->parent('DatabaseExclusions');
    $trail->push($Task->name, route('DatabaseExclusion', $Task->id));
});

// Home > DatabaseExclusion
Breadcrumbs::for('tasksCompletionCodes', function ($trail) {
    $trail->parent('home');
    $trail->push('Коды завершения', route('tasksCompletionCodes'));
});

// Home > EmployeePresenceTable
Breadcrumbs::for('EmployeePresenceUsers', function ($trail) {
    $trail->parent('home');
    $trail->push('Табель присутствия', route('EmployeePresenceUsers'));
});

// Home > EmployeePresenceTable
Breadcrumbs::for('EmployeePresence', function ($trail,$user) {
    $trail->parent('EmployeePresenceUsers');
    $trail->push($user->profiles()->first()->FullName);
});



// Home > DatabaseExclusion > [DatabaseExclusion]
Breadcrumbs::for('CompletionCodes', function ($trail, $Task) {
    $trail->parent('tasksCompletionCodes');
    $trail->push($Task->name, route('CompletionCodes', $Task->id));
});

// Home > DatabaseExclusion > [DatabaseExclusion]
Breadcrumbs::for('CompletionCode', function ($trail, $Task, $CompletionCode) {
    
    $trail->parent('CompletionCodes',$Task);
    $trail->push(App\Repositories\CompletionCodes::getCompletionCode($Task->uuid,$CompletionCode)->Name);

});
// Home > DatabaseExclusion > [DatabaseExclusion]
Breadcrumbs::for('CreateCompletionCodes', function ($trail, $Task) {
    
    $trail->parent('tasksCompletionCodes');
    $trail->push($Task->name, route('CreateCompletionCodes', $Task->id));
});
Breadcrumbs::for('storeCompletionCodes', function ($trail, $Task) {
    
    $trail->parent('tasksCompletionCodes');
    $trail->push($Task->name, route('storeCompletionCodes', $Task->id));

});

Breadcrumbs::for('CustomerDashboard', function ($trail) {
    $trail->parent('home');
    $trail->push('dashboard');
});

// Home > tecos
Breadcrumbs::for('tecos', function ($trail) {
    $trail->parent('home');
    $trail->push('Тэкос', route('tecos'));
});

// Home > algorithmSettings > [algorithmSetting]
Breadcrumbs::for('tecosShow', function ($trail, $Task) {
    $trail->parent('tecos');
    $trail->push($Task->name, route('tecosShow', $Task->id));
});

// Home > statistics
Breadcrumbs::for('statistics', function ($trail) {
    $trail->parent('home');
    $trail->push('Статистика', route('statistics'));
});

// Home > userCreate
Breadcrumbs::for('userCreate', function ($trail) {
    $trail->parent('home');
    $trail->push('Создать пользователя Oktell', route('userCreate'));
});

// Home > userStore
Breadcrumbs::for('userStore', function ($trail) {
    $trail->parent('home');
    $trail->push('userStore', route('userStore'));
});

// Home > algorithmSettings
Breadcrumbs::for('algorithmSettings', function ($trail) {
    $trail->parent('home');
    $trail->push('Настройка алгоритма обзвона', route('algorithmSettings'));
});

// Home > algorithmSettings > [algorithmSetting]
Breadcrumbs::for('algorithmSetting', function ($trail, $Task) {
	
    $trail->parent('algorithmSettings');
    $trail->push($Task->name, route('algorithmSetting', $Task->id));
});

// Home > users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Редактировать профиль пользователя Oktell', route('users'));
});

// Home > users
Breadcrumbs::for('user', function ($trail, $User) {
    $trail->parent('users');
    $trail->push($User->name, route('user', $User->id));
});


// Home > DatabaseExclusion
Breadcrumbs::for('searchChangeCompletionCode', function ($trail) {
    $trail->parent('home');
    $trail->push('Поиск звонка', route('searchChangeCompletionCode'));
});

// Home > DatabaseExclusion > idchain
Breadcrumbs::for('showChangeCompletionCode', function ($trail) {
    $trail->parent('searchChangeCompletionCode');
    $trail->push('Изменить код завершения', route('showChangeCompletionCode'));
});

// Home > userCreate
Breadcrumbs::for('citys', function ($trail) {
    $trail->parent('home');
    $trail->push('Площадки', route('citys'));
});

// Home > userStore
Breadcrumbs::for('city', function ($trail,$city) {
    $trail->parent('citys');
    $trail->push($city->name, route('city',$city->id ));
});

// Home > userCreate
Breadcrumbs::for('ProjectManager', function ($trail) {
    $trail->parent('home');
    $trail->push('РП '.Auth::user()->name, route('ProjectManager'));
});
// Home > userCreate
Breadcrumbs::for('ProjectManagerDashboard', function ($trail,$project) {

    $trail->parent('ProjectManager');
    $trail->push($project->name, route('ProjectManagerDashboard',$project->id));
});


/*// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});*/