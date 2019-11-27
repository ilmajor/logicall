
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    @if(Auth::check())
      <title>Личный кабинет оператора {{ Auth::user()->name }} </title>
    @else
      <title>Личный кабинет оператора</title>
    @endif
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- Custom styles for this template -->

  </head>

  <body>

  <header>
    @include('layouts.nav')
  </header>

  <main role="main">

    <div class="container">

      {{ Breadcrumbs::render() }}

      @yield('content')

    </div>

  </main>
  @if(Auth::check())
    @include('layouts.footer')
  @endif
  @include('layouts.js')


  </body>
</html>
