@extends ('layouts.master')
@section('content')
  
  <h1>Пользователи телефониии Oktell.</h1>
  <hr>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="isWork-tab" data-toggle="tab" href="#isWork" role="tab" aria-controls="isWork" aria-selected="true">Работают</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="IsDeleted-tab" data-toggle="tab" href="#IsDeleted" role="tab" aria-controls="IsDeleted" aria-selected="false">Уволены</a>
  </li>
</ul> 
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="isWork" role="tabpanel" aria-labelledby="isWork-tab">
    <div class="table-responsive">
      {{ $currentUsers->links() }}
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Имя</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($currentUsers as $user )
            <tr>
              
              <td>{{ $user->name}}</td>
              <td><a href="/lk/users/{{ $user->id }}">Редактировать</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $currentUsers->links() }}
    </div>
  </div>
  <div class="tab-pane fade" id="IsDeleted" role="tabpanel" aria-labelledby="IsDeleted-tab">
    <div class="table-responsive">
      {{ $firedUsers->links() }}
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Имя</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($firedUsers as $user )
            <tr>
              <td>{{ $user->name}}</td>
              <td><a href="/lk/users/{{ $user->id }}">Редактировать</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $firedUsers->links() }}
    </div>
  </div>
</div>



@endsection