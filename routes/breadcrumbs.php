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

// Home > projectSberbankIndividualsController
Breadcrumbs::for('projectSberbankIndividualsController', function ($trail) {
    $trail->parent('home');
    $trail->push('Претензии по Follow-Up', route('projectSberbankIndividualsController'));
});

// Home > tecos
Breadcrumbs::for('tecos', function ($trail) {
    $trail->parent('home');
    $trail->push('Тэкос', route('tecos'));
});

// Home > algorithmSettings > [algorithmSetting]
Breadcrumbs::for('tecosShow', function ($trail, $id) {
    $Task = App\Task::findOrFail($id);
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
Breadcrumbs::for('algorithmSetting', function ($trail, $id) {
	$Task = App\Task::findOrFail($id);
    $trail->parent('algorithmSettings');
    $trail->push($Task->name, route('algorithmSetting', $Task->id));
});

// Home > users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Редактировать профиль пользователя Oktell', route('users'));
});

// Home > users
Breadcrumbs::for('user', function ($trail, $id) {
	$User = App\User::findOrFail($id);
    $trail->parent('users');
    $trail->push($User->name, route('user', $User->id));
});


/*// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});*/