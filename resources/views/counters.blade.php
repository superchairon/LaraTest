<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('ACCOUNT_NAME') ? env('ACCOUNT_NAME') : 'Laravel' }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Helvetica', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                padding: 10px;
            }

            .simple-box {
                border: solid 1px gray;
                margin: 10px;
                padding: 10px;
                background-color: #F0F0F0;
            }
            /*.full-height {*/
                /*height: 100vh;*/
            /*}*/

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
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
            </div>
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
</html>