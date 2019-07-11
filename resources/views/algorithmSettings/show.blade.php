@extends ('layouts.master')
@section('content')
    <h1>Данные оператора {{ $profile->FullName }}.</h1>
    <h6>
        Логин сотрудника <span class="badge badge-light">{{ $data->login }}</span> |
        Добавочный <span class="badge badge-light">{{ $prefix->Prefix }}</span> |
        Возраст <span class="badge badge-light">{{ \Carbon\Carbon::parse($profile->DateofBirth)->age }}</span> |
        Стаж в кц <span class="badge badge-light">{{  \Carbon\Carbon::parse($profile->EmploymentDate)->age }}</span> |
        Статус <span class="badge badge-light">{{ ($profile->DateDismissal != '' ? 'Уволен' : 'Работает') }}</span> |
    </h6>
    <hr>

    <div class="table-responsive">
        <form method="POST" action="/lk/showUser/{{ $profile->user_id }}">

        {{ csrf_field() }}

            <div class="form-group">
                <label for="FullName">Фамилия Имя Отчество.</label>
                <input type="text" class="form-control" id="FullName" name="FullName" aria-describedby="FullName" value="{{ $profile->FullName }}" required>
            </div>
            <div class="form-group">

                <label for="Rate" >Ставка.</label>
                <input type="text" class="form-control" name="Rate" id="Rate" max="1" value="{{ $profile->Rate }}" onchange="rangeRate.value = Rate.value" / required>
                <input type="range" oninput="Rate.value = rangeRate.value" class="form-control-range slider" type="range" min="0.3" max="1" value="{{ $profile->Rate }}" id="rangeRate" step="0.01" onchange="Rate.value = rangeRate.value" >
                {{-- <input type="range" class="form-control-range" id="Rate"  min="0.3" max="1" step="0.1" name="Rate" value=""> --}}
            </div>
            <div class="form-group">
                <label for="Schedule">График 2/2 или 5/2.</label>
                <select class="form-control form-control" id="Schedule" name="Schedule" aria-describedby="Schedule" required>
                    <option>{{ $profile->Schedule }}</option>
                    <option>5/2</option>
                    <option>2/2</option>
                </select>

            </div>
            <div class="form-group">
                <label for="EmploymentDate">Дата трудоустройства.</label>
                <input type="date" class="form-control" id="EmploymentDate" name="EmploymentDate" aria-describedby="EmploymentDate" value="{{ 
                    date("Y-m-d", strtotime($profile->EmploymentDate))
                }}"required>
            </div>
            <div class="form-group">
                <label for="DateDismissal">Дата увольнения.</label>
                <input type="date" class="form-control" id="DateDismissal" name="DateDismissal" aria-describedby="DateDismissal" 
                    @if(!empty($profile->DateDismissal))
                        value="{{ date("Y-m-d", strtotime($profile->DateDismissal)) }}"
                    @endif
                >
            </div>
            <div class="form-group">
                <label for="City">Прощадка.</label>
                <select class="form-control form-control" id="City" name="City" aria-describedby="City" required>
                    <option>{{ $profile->City }}</option>
                    <option>Саранск</option>
                    <option>Красноярск</option>
                    <option>Москва</option>
                    <option>Самара</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Project">Проект.</label>
                <select multiple class="form-control form-control" id="Project" name="Project[]" aria-describedby="Project" size='10'required>
                    @foreach($projects as $project)
                        @if(in_array($project->Name, $profile->Project))
                            <option selected>{{$project->Name}}</option>
                         @else 
                            <option>{{$project->Name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Position">Должность.</label>
                <select class="form-control form-control" id="Position" name="Position" aria-describedby="Position" required>
                    <option>{{ $profile->Position }}</option>
                    <option>Оператор 1 категории</option>
                    <option>Оператор 2 категории</option>
                    <option>Оператор 3 категории</option>
                </select>
                
            </div>
            <div class="form-group">
                <label for="LastJumpDate">Дата последнего перехода.</label>
                <input type="date" class="form-control" id="LastJumpDate" name="LastJumpDate" aria-describedby="LastJumpDate" value="{{ 
                    date("Y-m-d", strtotime($profile->LastJumpDate))
                }}" required>
            </div>
            <div class="form-group">
                <label for="PinnedCoach">Закрепленный коуч.</label>
                <select class="form-control form-control" id="PinnedCoach" name="PinnedCoach" aria-describedby="PinnedCoach" required>
                    <option>{{ $profile->PinnedCoach }}</option>
                    @foreach($trainers as $trainer)
                        <option>{{$trainer->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="OSCoach">Коуч по ОС.</label>
                <select class="form-control form-control" id="OSCoach" name="OSCoach" aria-describedby="OSCoach" required>
                    <option>{{ $profile->OSCoach }}</option>
                    @foreach($trainers as $trainer)
                        <option>{{$trainer->name}}</option>
                    @endforeach
                </select>
            </div>
{{--            
            <div class="form-group">
                <label for="EnshrinedMentor">Закрепленный наставник.</label>
                <input type="text" class="form-control" id="EnshrinedMentor" name="EnshrinedMentor" aria-describedby="EnshrinedMentor" value="{{ $profile->EnshrinedMentor }}">
            </div> 
--}}
{{--            <div class="form-group">
                <label for="login"></label>
                <input type="text" class="form-control" id="title" name="login" aria-describedby="login" placeholder="" readonly>
            </div> --}}
            <div class="form-group">
                <label for="TeamLeader">Руководитель группы.</label>
                <select class="form-control form-control" id="TeamLeader" name="TeamLeader" aria-describedby="TeamLeader" required>
                    <option>{{ $profile->TeamLeader }}</option>
                    @foreach($trainers as $trainer)
                        <option>{{$trainer->name}}</option>
                    @endforeach
                </select>
            </div>
    {{--        <div class="form-group">
                <label for="Additional">Добавочный.</label>
                <input type="text" class="form-control" id="Additional" name="Additional" aria-describedby="Additional" value="{{ $prefix->Prefix }}"readonly>
            </div> --}}
            <div class="form-group">
                <label for="DateofBirth">Дата рождения.</label>
                <input type="date" class="form-control" id="DateofBirth" name="DateofBirth" aria-describedby="DateofBirth"  value="{{ 
                    
                    date("Y-m-d", strtotime($profile->DateofBirth) )
                }}"required>
            </div>
{{--            <div class="form-group">
                <label for="Age">возраст.</label>
                <input type="text" class="form-control" id="Age" name="Age" aria-describedby="Age" placeholder="{{
                 
                 \Carbon\Carbon::parse($profile->DateofBirth)->diffForHumans()

                }}"readonly>
            </div> --}}
{{--            <div class="form-group">
                <label for="ExperienceinKts">стаж в кц.</label>
                <input type="text" class="form-control" id="ExperienceinKts" name="ExperienceinKts" aria-describedby="ExperienceinKts" placeholder="{{ 
                    \Carbon\Carbon::parse($profile->EmploymentDate)->diffForHumans()
                }} "readonly>
            </div> --}}
            <div class="form-group">
                <label for="WZemployeeLogin">Логин сотрудника в WZ.</label>
                <input type="text" class="form-control" id="WZemployeeLogin" name="WZemployeeLogin" aria-describedby="WZemployeeLogin" value="{{ $profile->WZemployeeLogin }}">
            </div>
{{--            <div class="form-group">
                <label for="FixedtoProject">Закреплен на проекте.</label>
                <input type="text" class="form-control" id="FixedtoProject" name="FixedtoProject" aria-describedby="FixedtoProject" value="{{ $profile->FixedtoProject }}">
            </div> --}}
            <div class="form-group">
                <label for="MobilePhone">Мобильный телефон.</label>
                <input type="text" class="form-control" id="MobilePhone" name="MobilePhone" aria-describedby="MobilePhone" value="{{ $profile->MobilePhone }}"required>
            </div>


            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form> 
    </div>
@endsection