@extends('layout')

@section('content')
    <div id="app" class="simple-box">
        <example-component></example-component>
    </div>
    <div class="simple-box">
        <h3>Files</h3>
        @foreach($files as $file)
            <p><a href="{{ Storage::url($file) }}">{{ $file }}</a></p>
        @endforeach
        <h3>Folders</h3>
        @foreach($directories as $dir)
            <p>{{ $dir }}</p>
        @endforeach
    </div>
    <div class="simple-box">
        <label for="">Upload a file please</label><br><br>
        <form action="./upload" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="filename"><br>
            <button type="submit">Submit</button>
        </form>
    </div>
@endsection
