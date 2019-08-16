@extends('layout')

@section('content')
    <div id="app" class="simple-box">
        <example-component></example-component>
    </div>
    <div class="simple-box">
        <div class="title m-b-md">
            {{ env('ACCOUNT_NAME') ? env('ACCOUNT_NAME') : 'Laravel' }}
        </div>
        <h3>Welcome!</h3>
        <p>
            This is a testing environment on Kubernetes!</strong>
        </p>
        <hr>
        <a href="/counters">DB counters</a><br>
        <a href="/log">Create a random Log entry</a><br>
        <a href="/bug">Simulate an error</a><br>
        <a href="/upload">Upload a file</a><br>
    </div>
@endsection
