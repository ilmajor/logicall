@extends ('layouts.master')
@section('content')
    <h1>Данные оператора {{ $profile->FullName }}.</h1>
    <h6>
        Логин сотрудника <span class="badge badge-light">{{ $user->login }}</span> |
        Добавочный <span class="badge badge-light">{{ $prefix->Prefix }}</span> |
        Возраст <span class="badge badge-light">{{ \Carbon\Carbon::parse($profile->DateofBirth)->age }}</span> |
        Стаж в кц <span class="badge badge-light">{{  \Carbon\Carbon::parse($profile->EmploymentDate)->age }}</span> |
        Статус <span class="badge badge-light">{{ ($profile->DateDismissal != '' ? 'Уволен' : 'Работает') }}</span> |
    </h6>
    <hr>

    <div class="table-responsive">
        <form method="POST" action="/lk/users/{{ $profile->user_id }}">

        {{ csrf_field() }}

            <div class="form-group">
                <label for="FullName">Фамилия Имя Отчество.</label>
                <input type="text" class="form-control" id="FullName" name="FullName" aria-describedby="FullName" value="{{ $profile->FullName }}">
            </div>
            <div class="form-group">

                <label for="Rate" >Ставка.</label>
                <input type="text" class="form-control" name="Rate" id="Rate" max="1" value="{{ $profile->Rate }}" onchange="rangeRate.value = Rate.value" / >
                <input type="range" oninput="Rate.value = rangeRate.value" class="form-control-range slider" type="range" min="0.3" max="1" value="{{ $profile->Rate }}" id="rangeRate" step="0.01" onchange="Rate.value = rangeRate.value" >
                {{-- <input type="range" class="form-control-range" id="Rate"  min="0.3" max="1" step="0.1" name="Rate" value=""> --}}
            </div>
            <div class="form-group">
                <label for="Schedule">График 2/2 или 5/2.</label>
                <select class="form-control form-control" id="Schedule" name="Schedule" aria-describedby="Schedule" >
                    <option>{{ $profile->Schedule }}</option>
                    <option>5/2</option>
                    <option>2/2</option>
                </select>

            </div>
            <div class="form-group">
                <label for="EmploymentDate">Дата трудоустройства.</label>
                <input 
                    type="date" 
                    class="form-control" 
                    id="EmploymentDate" 
                    name="EmploymentDate" 
                    aria-describedby="EmploymentDate" 
                    value="{{ !empty($profile->EmploymentDate) ? date("Y-m-d", strtotime($profile->EmploymentDate)) : null}}">
            </div>
            <div class="form-group">
                <label for="DateDismissal">Дата увольнения.</label>
                <input 
                    type="date" 
                    class="form-control" 
                    id="DateDismissal" 
                    name="DateDismissal" 
                    aria-describedby="DateDismissal" 
{{--                     @if(!empty($profile->DateDismissal))
                        value="{{ date("Y-m-d", strtotime($profile->DateDismissal)) }}"
                    @endif 
                    >--}}
                    value="{{ !empty($profile->DateDismissal) ? date("Y-m-d", strtotime($profile->DateDismissal)) : null}}">
                
            </div>
            <div class="form-group">
                <label for="City">Площадка.</label>
                <select class="form-control form-control" id="City" name="City" aria-describedby="City">
                    @foreach($cities as $city)
                        @if((!empty($city)) && ((int) $profile->City == $city->id))
                            <option value="{{$city->id}}" selected>{{$city->name}}</option>
                        @else 
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="project">Проект.</label>
                <select multiple class="form-control form-control" id="project" name="project[]" aria-describedby="project" size='10' 
                @if($roleWeight > $userRoleWeight )
                    disabled>
                @else
                    required>
                @endif
                    <option></option>
                        @foreach($projects as $project)
                            @if((!empty($userProjects)) && in_array($project->id, $userProjects))
                                <option value="{{$project->id}}" selected>{{$project->name}}</option>
                             @else 
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endif
                        @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Position">Должность.</label>
                <select class="form-control form-control" id="Position" name="Position" aria-describedby="Position" >
                    <option>{{ $profile->Position }}</option>
                    <option></option>
                    <option>Оператор 1 категории</option>

                    <option>Оператор 2 категории</option>
                    <option>Оператор 3 категории</option>
                    <option>Специалист 3 категории</option>
                </select>
                
            </div>

            <div class="form-group">
                <label for="PinnedCoach">Закрепленный коуч.</label>
                <select class="form-control form-control" id="PinnedCoach" name="PinnedCoach" aria-describedby="PinnedCoach" >
                    <option>{{ $profile->PinnedCoach }}</option>
                    @foreach($managers as $manager)
                        <option>{{$manager->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="OSCoach">Коуч по ОС.</label>
                <select class="form-control form-control" id="OSCoach" name="OSCoach" aria-describedby="OSCoach" >
                    <option>{{ $profile->OSCoach }}</option>
                    @foreach($managers as $manager)
                        <option>{{$manager->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="TeamLeader">Руководитель группы.</label>
                <select class="form-control form-control" id="TeamLeader" name="TeamLeader" aria-describedby="TeamLeader" >
                    <option>{{ $profile->TeamLeader }}</option>
                    @foreach($managers as $manager)
                        <option>{{$manager->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="DateofBirth">Дата рождения.</label>
                <input 
                    type="date" 
                    class="form-control" 
                    id="DateofBirth" 
                    name="DateofBirth" 
                    aria-describedby="DateofBirth"  
                    {{-- value="{{ date("Y-m-d", strtotime($profile->DateofBirth) ) }}"> --}}
                    value="{{ !empty($profile->DateofBirth) ? date("Y-m-d", strtotime($profile->DateofBirth)) : null}}">
            </div>

            <div class="form-group">
                <label for="WZemployeeLogin">Логин сотрудника в WZ.</label>
                <input type="text" class="form-control" id="WZemployeeLogin" name="WZemployeeLogin" aria-describedby="WZemployeeLogin" value="{{ $profile->WZemployeeLogin }}">
            </div>
            
            <div class="form-group">
                <label for="MobilePhone">Мобильный телефон.</label>
                <input type="text" class="form-control" id="MobilePhone" name="MobilePhone" aria-describedby="MobilePhone" value="{{ $profile->MobilePhone }}">
            </div>
            <div class="form-group">
                <label for="ContractingOrganization">Подрядная организация.</label>
                <select class="form-control form-control" id="ContractingOrganization" name="ContractingOrganization" aria-describedby="ContractingOrganization">
                    <option value=""></option>
                    @foreach($ContractingOrganizations as $ContractingOrganization)
                        @if((!empty($ContractingOrganization)) && ((int) $profile->ContractingOrganization == $ContractingOrganization->id))
                            <option value="{{$ContractingOrganization->id}}" selected>{{$ContractingOrganization->name}}</option>
                        @else 
                            <option value="{{$ContractingOrganization->id}}">{{$ContractingOrganization->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <hr>
            <h3>Права контроля.</h3>
            
            <div class="form-group">
                <label for="project">Подчиняется:</label>
                <div style="border:2px solid #ccc; width:100%; height: 250px; overflow-y: scroll;">
                    
                    <table class="table table-sm">
                        <tbody>
                            @foreach($usersList as $user)
                                <tr>
                                    @if((!empty($UsersControl)) && in_array($user->id_user, $UsersControl))
                                        <td>
                                            <label for="{{$user->id_user}}">
                                                {{$user->name}}
                                            </label>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="UserA[]" value="{{$user->id_user}}" id="{{$user->id_user}}" checked 
                                               @if($user->weight >= $userRoleWeight && Auth::id() != $user->id )
                                                    disabled>
                                                    {{-- userRoleWeight залогинившийся  roleWeight просматриваемый--}}
                                                @else
                                                    >
                                                @endif
                                        </td>
                                    @else 
                                        <td>
                                            <label  for="{{$user->id_user}}">
                                                {{$user->name}} 
                                            </label>
                                        </td>
                                        <td>
                                            <input  type="checkbox" name="UserA[]" value="{{$user->id_user}}" id="{{$user->id_user}}" 
                                                @if($user->weight >= $userRoleWeight && Auth::id() != $user->id )
                                                    disabled>
                                                @else
                                                    >
                                                @endif                                            
                                            </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <label for="project">Контролирует:</label>
                <div style="border:2px solid #ccc; width:100%; height: 250px; overflow-y: scroll;">
                    
                    <table class="table table-sm">
                        <tbody>
                            @foreach($usersList as $user)
                                <tr>
                                    @if((!empty($UsersUnderControl)) && in_array($user->id_user, $UsersUnderControl))
                                        <td>
                                            <label for="{{$user->id_user}}">
                                                {{$user->name}}
                                            </label>
                                        </td>
                                        <td><input type="checkbox" name="UserB[]" value="{{$user->id_user}}" id="{{$user->id_user}}" checked 
                                            @if($user->weight >= $userRoleWeight && Auth::id() != $user->id )
                                                disabled>
                                            @else
                                                >
                                            @endif
                                        </td>
                                    @else 
                                        <td>
                                            <label  for="{{$user->id_user}}">
                                                {{$user->name}}
                                            </label>
                                        </td>
                                        <td><input  type="checkbox" name="UserB[]" value="{{$user->id_user}}" id="{{$user->id_user}}" 

                                            @if($user->weight >= $userRoleWeight && Auth::id() != $user->id )
                                                disabled>
                                            @else
                                                >
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <h3>Внешний модуль</h3>
            <div class="form-group">
                <select multiple class="form-control form-control" id="OktellPlugins" name="OktellPlugins[]" aria-describedby="OktellPlugins" size='10' 
                @if($roleWeight > $userRoleWeight )
                    disabled>
                @else
                    required>
                @endif
                    <option></option>
                        @foreach($OktellPlugins as $OktellPlugin)
                             @if((!empty($UserInOktellPlugins)) && in_array($OktellPlugin->Id, $UserInOktellPlugins))
                                <option value="{{$OktellPlugin->Id}}" selected>{{$OktellPlugin->MenuText}}</option>
                            @else 
                                <option value="{{$OktellPlugin->Id}}">{{$OktellPlugin->MenuText}}</option>
                            @endif  
                            
                        @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form> 
    </div>
@endsection