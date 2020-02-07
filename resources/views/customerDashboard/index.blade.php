@extends ('layouts.master')
@section('content')

  <h1>Dashboard {{ !empty($project) ? $project->implode(' | ') : '' }}</h1>

 	<hr>
  @foreach($charts as $key => $chart)
    <div id="app">
        {!! $chart->container() !!}
    </div>
      <script src="https://unpkg.com/vue"></script>
      <script>
          var app = new Vue({
              el: '#app',
          });
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
          {!! $chart->script() !!}
      <script type="text/javascript">
          function {{ $chart->id }}_getData() // Gets triggered by page load so innerHTML works
          {
              {{ $chart->id }}_api_url = "{{ $chart->api_url }}";
              {{ $chart->id }}_refresh();
              setTimeout({{ $chart->id }}_getData, {{ $timeouts[$key] }}*1000);   // <-- The correct way
          }
          {{ $chart->id }}_getData();
      </script>
      <hr>
  @endforeach

@endsection