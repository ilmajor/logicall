@extends ('layouts.master')
@section('content')


    <hr>   
 <div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ">
      <div class="table-responsive-sm">
        <table class="table table-striped table-sm table-bordered">
          <thead class="thead-dark">
            <tr>
              <th colspan="3">{{ Carbon\Carbon::now() }}</th>

            </tr>
          </thead>
          <tbody>
            @foreach ($projects as $project)
              <tr>
                <td>{{$project->name}}</td>
                <td>{{$project->users_count}}</td>
                <td>
                  <a href="/lk/ProjectManager/Dashboard/{{$project->id}}" class="btn btn-warning btn-sm">Dashboard</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection