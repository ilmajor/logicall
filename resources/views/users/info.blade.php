@extends ('layouts.master')
@section('content')
    <h1>{{ $user->name }}</h1>
    <h2>Профиль:</h2>
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center" >ФИО <span>{{ $profile->FullName }}</span></span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Логин: <span>{{ $profile->Rate }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">График: <span>{{ $profile->Schedule }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Дата трудоустройства: <span>{{ $profile->EmploymentDate }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Прощадка: <span>{{ $profile->City }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Должность: <span>{{ $profile->Position }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Закрепленный коуч: <span>{{ $profile->PinnedCoach }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Коуч по ОС: <span>{{ $profile->OSCoach }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Руководитель группы: <span>{{ $profile->TeamLeader }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Дата рождения: <span>{{ $profile->DateofBirth }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Логин сотрудника в WZ: <span>{{ $profile->WZemployeeLogin }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Мобильный телефон: <span>{{ $profile->MobilePhone }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Роли в ЛК: <span>
            @foreach ($roles as $role)
                  {{ $role }}
            @endforeach
        </span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Номер в Oktell: <span>{{ $prefix->Prefix }}</span></li>
        <li class="list-group-item d-flex justify-content-between align-items-center">Доступные проекты в ЛК:
            @foreach ($projects as $project)
                  {{ $project }}
            @endforeach
        </li>
    </ul>


{{--     <li class="list-group-item">Номер в Oktell: {{ $result['number'] }}</li>
    <li>Статус: {{ $result['operatorStatus'] }}</li> --}}

     {{-- @foreach ($login as $key )
        <h1>{{ $key->UserName }}</h1>
    @endforeach --}}
@endsection
