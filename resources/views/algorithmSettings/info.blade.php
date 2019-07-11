@extends ('layouts.master')
@section('content')
    <h1>{{ $result['username'] }}</h1>
    <li>name {{ $result['username'] }}</li>
    <li>Login: {{ $result['login'] }}</li>
    <li>Password: {{ $result['password'] }}</li>
    <li>Operator: {{ $result['operator'] }}</li>
    <li>manager: {{ $result['manager'] }}</li>
    <li>admin: {{ $result['admin'] }}</li>
     {{-- @foreach ($login as $key )
        <h1>{{ $key->UserName }}</h1>
    @endforeach --}}
@endsection