
@extends('layouts.app')

@section('template_title')
    See Message
@endsection

@section('head')
@endsection




@section('content')

 <div class="container">

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          
             
            @if( isset($canceled) )
              <div class="alert alert-warning">
                <span class="glyphicon glyphicon-record"></span> <strong>Warning</strong>
                <hr class="message-inner-separator">
                <p>Your subscription has been canceled. It will stay active until the end of the current billing cycle.</p>
                <p><a href="/subscribe">Click here</a> to go back to your subscription page.</p>
              </div>
            @endif

          
        </div>
        <div class="col-md-2"></div>
    </div>
</div>


@endsection

