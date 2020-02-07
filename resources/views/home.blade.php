{{-- <!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>Chart with VueJS</title>
    </head>
    <body>
        @foreach($charts as $chart)
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
                    setTimeout({{ $chart->id }}_getData, {{ $timeout }});   // <-- The correct way
                }
                {{ $chart->id }}_getData();
            </script>
        @endforeach
    </body>
</html> --}}