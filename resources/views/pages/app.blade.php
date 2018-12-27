<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Andrew's Boiler Plate</title>
        <meta name="description" content="">
        <meta name="author" content="Elliot Robert">
        <link rel="shortcut icon" href="/favicon.ico">

        {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        {{-- Fonts --}}
        @yield('template_linked_fonts')

        {{-- Styles --}}
        <!--<link href="{{ mix('/css/app.css') }}" rel="stylesheet">-->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        <link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" media="all" type="text/css" href="{{asset('css/jquery-ui-timepicker-addon.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}">

        <script type="text/javascript" src="{{asset('js/jquery-te-1.4.0.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-te-1.4.0.css')}}">

        <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-3-vert-offset-shim.css')}}">
        <link rel="shortcut icon" href="{{asset('assets/img/logo1.ico')}}"/>
        
        <link type="text/css" rel="stylesheet" href="{{asset('assets/css/components.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{asset('css/custom.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
        <!-- copy button-->
        <script type="text/javascript" src="{{asset('assets/js/clipboard.min.js')}}"></script>
        

        @yield('template_linked_css')

        <style type="text/css">
            @yield('template_fastload_css')

            @if (Auth::User() && (Auth::User()->profile) && (Auth::User()->profile->avatar_status == 0))
                .user-avatar-nav {
                    background: url({{ Gravatar::get(Auth::user()->email) }}) 50% 50% no-repeat;
                    background-size: auto 100%;
                    width:30px !important;
                    height:30px !important;
                }
            @endif

        </style>

        {{-- Scripts --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>

        

        @yield('head')

    </head>

    <body>
        <div id="app">

            <div class="container-fluid">

                @include('partials.form-status')

            </div>

            @if (Auth::check())
              @include('layouts.default')
            @else
              <!-- use this for non logged in visitors page-->
              @yield('content')
            @endif
            

        </div>

        {{-- Scripts --}}
        
        <script src="{{asset('js/appExtra.js')}}"></script>
        

        <!-- Datetime picker Must come after appExtra.js-->
        <script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery-ui-timepicker-addon-i18n.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery-ui-sliderAccess.js')}}"></script>
  
    

        @yield('footer_scripts')

    </body>


</html>
