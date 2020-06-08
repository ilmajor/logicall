@extends ('layouts.master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3>Отработанное время за {{date('Y-m-d')}}</h2>
          <ul class="list-group">
            <div id = 'timeWorked'></div>
          </ul>
        </div>

         <div class="col-md-6">
          <h3>Информация по звонкам</h2>
          <ul class="list-group">
            <div id = 'callsInformation'></div>
          </ul>
        </div>

      </div>
    </div> 
    <div class="row">
        <div class="col-md-6">
          <h3>Согласия за {{date('Y-m-d')}}</h2>
          <ul class="list-group">
            <div id="callConsent"></div>
          </ul>
        </div>
</div>

</div>
 <script>

$(document).ready(function(){

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
      type: "POST",
      url: "/lk/statistics",
      async: true,
      cache: false,
      data:'_token = <?php echo csrf_token() ?>',
      success: function(data){
        //$("#timeWorked").html(html);
        //$('#timeWorked').html(data.html);
        //console.log(data.timeWorked);
        //console.log(data.timeWorked[0]['Name']);
/*        Object.keys(data.timeWorked).map(function(objectKey, index) {
            var value = data.timeWorked[objectKey];
            console.log(value);
        });*/
        elem = document.getElementById( 'timeWorked' );
        for(var key in data.timeWorked) {
            if (data.timeWorked.hasOwnProperty(key)) {
                 elem.innerHTML += '<li class="list-group-item">' 
                  + data.timeWorked[key].Name + ' '
                  + data.timeWorked[key].humanTime 
                  + '</li>';
                //setTimeout( arguments.callee, 2000 );
            }
        }
        elem = document.getElementById( 'callsInformation' );
        task = '';
        for(var key in data.callsInformation) {
            if (data.callsInformation.hasOwnProperty(key)) {
                if(task != data.callsInformation[key].taskName ){
                  elem.innerHTML = data.callsInformation[key].taskName;
                };
                task = data.callsInformation[key].taskName;
                 elem.innerHTML += '<li class="list-group-item d-flex justify-content-between align-items-center">' 
                  + data.callsInformation[key].codeName 
                  + '<span class="badge badge-primary badge-pill">'
                  + data.callsInformation[key].calls
                  + '</span>'
                  + '</li>';
                //setTimeout( arguments.callee, 2000 );
            }
        }
        elem = document.getElementById( 'callConsent' );
        for(var key in data.callConsent) {
            if (data.callConsent.hasOwnProperty(key)) {
                 elem.innerHTML += '<li class="list-group-item">' 
                  + data.callConsent[key].userName
                  + ' | '
                  + data.callConsent[key].calls
                  + '</li>';
                //setTimeout( arguments.callee, 2000 );
            }
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  });
    
 </script>
@endsection