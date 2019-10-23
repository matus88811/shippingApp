<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->


<!-- Latest compiled and minified JavaScript -->
<style>
            html, body {
                background-color: #0c1923;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .container {
                width:50%;
                margin:5em auto;
            }

            a {
                text-decoration:none;
            }

           .payment {
            font-size:1.5em;

           }

           .payment input[type=text]  {
            padding:1em;
            width:50%;
            border:none;
            margin-top:1em;
            margin-bottom:1em;
            border-radius:0.3em;
           }

           .payment input[type=radio] {
            margin-top:2em;
           }

           .button {
            background-color:#24a0ed;
            color:#fff;
            padding:0.5em 1em;
            border-radius:0.3em;
            border:none;
            }

            .button:hover {
                text-decoration:none;
                color:#fff;
            }

            .bigger {
                padding:1em;
                margin-top:1em;
            }

            .left-gap {
                margin-left:1em;
            }

            .alert {
                padding:1.5em;
                background-color:#82B541;
                border-radius:0.4em;
                color:#fff;
                border:none;
            }
                
             .bottom-gap {
                margin-bottom:4em;
             }       




        </style>
            

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="bottom-gap">
        @include('flash::message')
        </div>
        <h1 class="app-header">
            @if( request()->is('/'))
            <a class="button" href="/payment"> Send Payment </a>
            @endif
             <a class="button {{ !request()->is('/') ? '' : 'left-gap' }}" href="/new-bank">New payment method </a></h1> 
            <div>
                @yield('content')
            </div>
    </div>

<script src="{{ asset('js/app.js') }}" defer></script>



</body>
</html>