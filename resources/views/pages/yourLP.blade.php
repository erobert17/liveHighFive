@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

<div id="fillWithNoobMessage">


</div>

@section('template_fastload_css')
@endsection

@section('content')

    
    <script type="text/javascript">
        $(document).ready(function(){

            if({{$userHintState}} === 2){
     
                if({{$user->helpBubbleToggle}} == 1){// always 1 until user turns off all hint bubbles
                    

                    $('#fillWithNoobMessage').html("<div class='noobMessage noShowOnMobile'><p class='text-center'>There's a '<strong>Stats</strong>' link in the left menu, below this landing page's link.</p><p class='text-center'>Click it to see metrics for this landing page. </p><div class='text-center'><button id='closeHint' class='text-center'> Close </button><button id='neverShowHints' class='text-center'> Never Show These Hints </button></div></div>");

                    $(".noobMessage").delay(100).fadeIn();

                    var glow = $(".statsTab a");
                    glow.addClass('noobHintLink');
                    setInterval(function(){
                        glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
                    }, 500);

                }
            }

                    $('#closeHint').click(function(){

                        $(".noobMessage").fadeOut();  
                        $.ajax({
                          type: 'POST',
                          url: '/changeHintState',
                          data: {  "_token": "{{ csrf_token() }}",
                          "hintNumber": '3'},
                          //"email": email,
                          success:function(data) {

                          }
                        }).done(function( msg ) {  
                            $(".noobMessage").fadeOut();       
                        });

                        $(".copyLinkInput").removeClass('noobBackgroundColor');

                    });

                    $('#neverShowHints').click(function(){

                        $(".noobMessage").fadeOut();  

                        $.ajax({
                          type: 'POST',
                          url: '/neverShowHints',
                          data: {  "_token": "{{ csrf_token() }}"},
                          
                          success:function(data) {
                          }
                        }).done(function( msg ) {  
                        $(".noobMessage").fadeOut();       
                        });

                        $(".copyLinkInput").removeClass('noobBackgroundColor');

                    });

                    $("a:contains('Stats')").click(function(){
                        
                        $.ajax({
                          type: 'POST',
                          url: '/changeHintState',
                          data: {  "_token": "{{ csrf_token() }}",
                          "hintNumber": '3'},
                          //"email": email,
                          success:function(data) {

                          }
                        }).done(function( msg ) {  
                            $(".noobMessage").fadeOut();       
                        });
                    });

        });
    </script>
    <div class="container">
        
        <input type="hidden" name="userID" value="{{ $user->id }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            
            <div class="col-md-8 col-md-offset-2">

                <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="centerBlock">
                        <strong>Your Unique Landing Page Link: &nbsp;</strong>
                        <input id="linkToCopy" value="{{ URL::to('/').'/link'.$landingPageNumber.'/'.$userLink }}" type="text">&nbsp;
                        <button type="button" id="copy" data-clipboard-target="#linkToCopy" class="btn btn-success">Copy</button>
                        
                        &nbsp;<strong class="copiedLink">Copied! </strong>
                    </div>
                </div>
           
                <script type="text/javascript">
                    new Clipboard('#copy');
                    $(document).ready(function(){
                        $('#copy').click(function(){
                                $(".copiedLink").attr( "style", "display: inline !important;" )
                                setTimeout(function() { $(".copiedLink").fadeOut(); }, 5000);
                        });
                    });
                </script>

            </div>
        </div>


        <div class="row" style="text-align: center;">
                <div class="col-sm-8 col-sm-offset-4 col-md-8 col-md-offset-4 col-lg-8 col-lg-offset-2">

                    <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                        <div class="centerBlock">
                            <div class="row">
                                <div class="col-sm-8 col-md-8" style="padding-top: 0.5em;color:#954120;">
                                    <strong>Delete This Landing Page</strong>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <a href="/deleteLandingPage/{{$landingPage[0]->id}}">
                                        <button type="button" class="btn btn-danger text-center">Delete Landing Page</button>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @if( isset($warningTitle) )

                    <div class="row vert-offset-bottom-1">
                        <div class="col-md-12">
                                <div class="alert alert-warning">
                                <span class="glyphicon glyphicon-record"></span> <strong>Warning</strong>
                                <hr class="message-inner-separator">
                                <p>{!! $warningTitle !!}</p>
                            </div>
                        </div>
                    </div>

                @endif

                <div class="panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="panel-heading">
                    @if($landingPageNumber == 1)
                        Property Valuation Landing Page
                    @elseif($landingPageNumber == 2)
                        Property Search Landing Page
                    @endif
                    </div>

                    <div class="panel-body">
                        <form action="/saveLandingPage{{$landingPageNumber}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Title:<br>
                                    <input name="title" class="longInput" value="<?php if(isset($landingPage[0]->title)){echo htmlentities($landingPage[0]->title);} ?>">
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Secondary Title:<br>
                                    <input name="secondaryTitle" class="longInput" value="<?php if(isset($landingPage[0]->secondaryTitle)){echo htmlentities($landingPage[0]->secondaryTitle) ;} ?>">
                                </label>
                            </div>
                        </div>

                        

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <button class="btn btn-success">Update</button>
                            </div>
                        </div>
                        </form>

                         <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Background Image:</label>
                            </div>

                            <style type="text/css">
                                .dz-preview.dz-image-preview {
                                    position: absolute !important;
                                    left: 38% !important;
                                    top: 10% !important;
                                }
                            </style>
                        
                            <div class="col-md-12">
                                @if($landingPageNumber == 1)
                                    <form action="/uploadBackground" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                @else
                                    <form action="/uploadBackground2" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <?php 
                                                                $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/backgroundLP'.$landingPageNumber.'.jpg');    

                                                                curl_setopt($ch, CURLOPT_NOBODY, true);
                                                                curl_exec($ch);
                                                                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                                $backgroundExists = '';
                                                                if($code == 200){
                                                                   $backgroundExists = true;
                                                                   
                                                                }else{
                                                                  $backgroundExists = false;
                                                                }
                                                                ;
                                                                curl_close($ch);

                                                                ?>

                                                                @if($backgroundExists == true)
                                                                    @if($landingPageNumber == 1)
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP1.jpg')}}" />
                                                                    @elseif($landingPageNumber == 2)

                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP2.jpg')}}" />

                                                                    @endif
                                                                @elseif($landingPageNumber == 1)

                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" src="{{asset('uploads/placeholderBG.jpg')}}" />

                                                                @elseif($landingPageNumber == 2)

                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" src="{{asset('uploads/placeholderBG2.jpg')}}" />
                                                                @endif
                                  <div class="dz-message needsclick">
                                    Drop files here or click to upload.<br>
                                    
                                  </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
            
        </div>


    </div>

@endsection

@section('footer_scripts')

    @include('scripts.updateBackgroundDZ')


@endsection