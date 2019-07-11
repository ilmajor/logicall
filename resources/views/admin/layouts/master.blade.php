
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    
    @if(Auth::check())
      <title>Личный кабинет оператора {{ Auth::user()->name }} </title>
    @else
      <title>Личный кабинет оператора</title>
    @endif
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="/lk/public/css/dashboard.css" rel="stylesheet">
    {{-- <link href="/lk/public/css/offcanvas.css" rel="stylesheet"> --}}

  </head>

  <body>

    <header>
		@include('admin.layouts.nav')
    </header>

    <main role="main">

      
    <div class="container-fluid">
      <div class="row">
        @include('admin.layouts.sidebar')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          
            @yield('content')
            <div class="form-group">
              @include('admin.layouts.errors')
            </div>
        </main>
      </div>
    </div>

    </main>
  @if(Auth::check())
  	@include('admin.layouts.footer')
  @endif
	@include('admin.layouts.js')


  </body>
</html>
