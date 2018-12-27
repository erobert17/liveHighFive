@extends('layouts.app')

@section('content')



<!-- Main -->
<div class="d-md-flex h-md-100 align-items-center">
    <div class="col-md-5 p-0 bg-white h-md-100 loginarea">
        <div class="d-md-flex align-items-center h-md-100 p-5 justify-content-center" style="padding-bottom: 7em !important;">
            <form class="border rounded p-5" style="min-width: 38%;" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <h3 class="mb-4 text-center">
                    <img class="vert-offset-bottom-1" style="max-width: 100%;" src="{{asset('img/mainLogoBlackText.png')}}"/>
                </h3>
                <div class="form-group">
                    <label for="email" class="">User Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="username" class="">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label small text-muted" for="exampleCheck1">Remember me</label>
                </div>
                
                <div class="col-md-2 col-xs-12">
                    <button type="submit" class="btn btn-primary ">
                        Login
                    </button>
                </div>
                <div class="col-md-3 col-xs-12 noLeftPadding">
                    <small class="text-center">
                        <a class="btn btn-link" style="font-size: 10px !important; padding-top: 1em;" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </small>
                </div>
                <div class="col-md-3 col-xs-12 noLeftPadding">
                    <small class="text-center">
                        <a class="btn btn-link" style="font-size: 10px !important; padding-top: 1em;" href="/register">
                            Register
                        </a>
                    </small>
                </div>
                <div class="col-md-4"></div>
                <!--
                <button type="submit" class="btn btn-success btn-round btn-block shadow-sm">Sign in</button>
                <small class="d-block mt-4 text-center"><a class="text-gray" href="#">Forgot your password?</a></small>
                -->
            </form>
        </div>
    </div>

    <div class="col-md-7 p-0 hidden-xs bg-gray h-md-100">
        <div class="text-white d-md-flex align-items-center h-100 p-5 text-center justify-content-center">
            <div class="logoarea pt-5 pb-5" style="width: 38%;">
                <!--
                <p>
                    <i class="fa fa-anchor fa-3x"></i>
                </p>
                
                <h1 class="mb-0 mt-3 display-4">Anchor</h1>
                <h5 class="mb-4 font-weight-light">Free Bootstrap UI Kit with <i class="fab fa-sass fa-2x text-cyan"></i></h5>
                <a class="btn btn-outline-white btn-lg btn-round" href="#" data-toggle="modal" data-target="#modal_newsletter">Download <a href="https://github.com/wowthemesnet/Anchor-Bootstrap-UI-Kit/archive/master.zip" class="downloadzip" class="hidden"></a>-->
                </a>
            </div>
        </div>
    </div>
</div>



<style type="text/css">
@media (min-width: 768px) {
    .h-md-100 { height: 100vh; }
}
.btn-round { border-radius: 30px; }
.bg-indigo { background: indigo; }
.text-cyan { color: #35bdff; }

.noLeftPadding{
    padding-left:0px !important;
}
</style>

<!-- End Main -->
@endsection
