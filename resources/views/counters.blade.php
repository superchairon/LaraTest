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
        @foreach($counters as $counter)
            <p><strong>{{$counter['description']}}</strong>: {{$counter['value']}} times</p>
        @endforeach
        <a href="/job">Increment Job counters in 10 seconds</a>
    </div>
@endsection
