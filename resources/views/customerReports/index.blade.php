@extends ('layouts.master')
@section('content')

  <h1>Dashboard {{ !empty($project) ? $project->implode(' | ') : '' }}</h1>

 	<hr>
  @foreach($types as $key => $type)
  <h3>{{ $dashboardsName[$key] }}</h3>
    @if($type == 'table')
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
      <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" defer></script> 
      <div class="table-responsive">
        <table id="datatable{{ $key }}" class="table table-striped table-sm">
          <thead>
            <tr>
              @foreach($tableColumnName[$key] as $ColumnName)
                <th>{{$ColumnName}}</th>
              @endforeach
            </tr>
          </thead>
        </table>
      </div>
    
    <script>
        $(document).ready( function () {
            $('#datatable{{ $key }}').DataTable({
              processing: true,
              serverSide: true,
              searching: false,
              orderable: false,
              paging: false,
              bInfo : false,
              ajax: {
                url: '{{ url('CustomerDashboard/'.$key) }}',
              },
              columns: [
                @foreach($tableColumnName[$key] as $ColumnName)
                {
                  data: '{{$ColumnName}}',
                  name: '{{$ColumnName}}',
                  searchable: false,
                  orderable: false
                },
                @endforeach
            ],

        });
      });
      setInterval(function () {
            var table = $('#datatable{{ $key }}').DataTable();
            table.ajax.reload();
      }, {{ $timeouts[$key] }}*1000);
    </script>
      @else
      <div id="app">
          {!! $charts[$key]->container() !!}
      </div>
         <script src="https://unpkg.com/vue"></script>
        <script>
            var app = new Vue({
                el: '#app',
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
            {!! $charts[$key]->script() !!}
        <script type="text/javascript">
            function {{ $charts[$key]->id }}_getData() // Gets triggered by page load so innerHTML works
            {
                {{ $charts[$key]->id }}_api_url = "{{ $charts[$key]->api_url }}";
                {{ $charts[$key]->id }}_refresh();
                setTimeout({{ $charts[$key]->id }}_getData, {{ $timeouts[$key] }}*1000);   // <-- The correct way
            }
            {{ $charts[$key]->id }}_getData();
        </script>
        <hr> 

    @endif
  @endforeach

@endsection