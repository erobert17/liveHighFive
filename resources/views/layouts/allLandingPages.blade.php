

@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection


@section('content')
    
    <script type="text/javascript">
        $(document).ready(function() {
                
                var findNoobMessage = $('.noobMessage').length;
                
                if({{$userHintState}} === 1){

                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "{{ csrf_token() }}",
                      "hintNumber": '1'},
                      //"email": email,
                      success:function(data) {

                      }
                    }).done(function( msg ) {  
                       
                    });
 
                    if(findNoobMessage > 0){
                        if({{$user->helpBubbleToggle}} == 1){// always 1 until user turns off all hint bubbles
                         
                                $('.noobMessage').css('display', 'block');

                                var glow = $(".copyLinkInput");
                                glow.addClass('noobBackgroundColor');
                                setInterval(function(){
                                    glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
                                }, 500);

                        }
                    }
                }

                if({{$userHintState}} === 2){
 
                    if(findNoobMessage > 0){
                        if({{$user->helpBubbleToggle}} == 1){// always 1 until user turns off all hint bubbles
                                $("#paragraphs").html();
                    
                                $('#p1').text(<?php echo'"'.$hintText[2]->p1.'"'; ?> );
                                $('#p2').text(<?php echo"'".$hintText[2]->p2."'"; ?>);
                            
                                $(".copyLinkInput").removeClass('noobBackgroundColor');// stop red copy button flashing
                                $('#nextHint').remove();
                                $(".noobMessage").delay(100).fadeIn();
                        }
                    }
                }

                $('#closeHint').click(function(){

                    $('.noobMessage').css('display', 'none');
                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "{{ csrf_token() }}",
                      "hintNumber": '1'},
                      //"email": email,
                      success:function(data) {

                      }
                    }).done(function( msg ) {  
                    $('.noobMessage').css('display', 'none');     
                    });

                    $(".copyLinkInput").removeClass('noobBackgroundColor');

                });

                $('#neverShowHints').click(function(){

                    $('.noobMessage').css('display', 'none');

                    $.ajax({
                      type: 'POST',
                      url: '/neverShowHints',
                      data: {  "_token": "{{ csrf_token() }}"},
                      
                      success:function(data) {
                      }
                    }).done(function( msg ) {  
                    $('.noobMessage').css('display', 'none');     
                    });

                    $(".copyLinkInput").removeClass('noobBackgroundColor');

                });

                $('#nextHint').click(function(){
                    
                    $(".noobMessage").fadeOut();
                    $("#paragraphs").html();
                    

                        $('#p1').text(<?php echo'"'.$hintText[2]->p1.'"'; ?> );
                        $('#p2').text(<?php echo"'".$hintText[2]->p2."'"; ?>);
                    
                    $(".copyLinkInput").removeClass('noobBackgroundColor');// stop red copy button flashing
                    $(".noobMessage").delay(500).fadeIn();
                    $('#nextHint').delay(600).remove();
                    //$('.noobMessage').css('display', 'none');
                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "{{ csrf_token() }}",
                      "hintNumber": '1'},
                      //"email": email,
                      success:function(data) {
                      }
                    }).done(function( msg ) {  
                      
                    });

                });

        });
    </script>

    <div class="container">
        <div class="noobMessage noShowOnMobile">
            <div id="paragraphs">
                <p id="p1" class="text-center">{{$hintText[1]->p1}}</p>
                <p id="p2" class="text-center">There's a "<strong class="redFont">Copy</strong>" button below each landing page window.</p>
            </div>
            <div class="text-center">
                <button id="closeHint" class="text-center"> Close </button>
                <button id="nextHint" class="text-center"> Next </button>
                <button id="neverShowHints" class="text-center"> Never Show These Hints </button>
            </div>
        </div>
        <form action="saveLandingPage" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <?php 
        /*
        echo '<pre>';
         var_dump($landingPages);
         echo '</pre>';
         */
         $count = 0;
         $iterate = 0;// used to select numbered array inside $page
         $landingPageNumber = '1';
         ?>

        @foreach($landingPages as $page)

            <div class="row">

                @if($iterate <= 6 && isset($page[$iterate]->type))
                    
                    <?php 
                    
                    if($page[$iterate]->type == 'Home Valuation')
                    {
                        $landingPageNumber = '1';
                    }else if($page[$iterate]->type == 'Property Details')
                    {
                        $landingPageNumber = '2';
                    }else if($page[$iterate]->type == 'Open Houses')
                    {
                        $landingPageNumber = '3';
                    }else if($page[$iterate]->type == 'New Product Countdown')
                    {
                        $landingPageNumber = '4';
                    }else if($page[$iterate]->type == 'New Product Coupon')
                    {
                        $landingPageNumber = '5';
                    }else if($page[$iterate]->type == 'Single Item Shopping Cart')
                    {
                        $landingPageNumber = '6';
                    }
                    
                    ?>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                {{$page[$iterate]->type}}

                                <a href="../edit/landingPage/{{$landingPageNumber}}" class="pull-right fontWhite">Edit</a>
                            </div>

                            <div class="panel-body" style="background-size: cover;height: 21em; width: 100%; background-image: url('http://growyourleads.com/uploads/landingPage{{$landingPageNumber}}Default.jpg')">
                            </div>
                        </div>

                        @if($page[$iterate]->type != 'Open Houses')
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                                        <div class="centerBlock">
                                            <strong>{{$page[$iterate]->type}} Landing Page Link: &nbsp;</strong><br>
                                            <input id="linkToCopy{{$landingPageNumber}}" value="{{ URL::to('/').'/link'.$landingPageNumber.'/'.$userLink }}" type="text">&nbsp;
                                            <button type="button" id="copy{{$landingPageNumber}}" data-clipboard-target="#linkToCopy{{$landingPageNumber}}" class="btn btn-success copyLinkInput">Copy</button>
                                            
                                            &nbsp;<strong class="copiedLink absoTop3p5 copiedLink{{$landingPageNumber}}">Copied!</strong>
                                        </div>
                                    </div>

                                    
                                    <script type="text/javascript">
                                        new Clipboard('#copy{{$landingPageNumber}}');
                                        $(document).ready(function(){
                                            $('#copy{{$landingPageNumber}}').click(function(){
                                                    $(".copiedLink{{$landingPageNumber}}").attr( "style", "display: inline !important;" )
                                                    setTimeout(function() { $(".copiedLink{{$landingPageNumber}}").fadeOut(); }, 5000);
                                            });
                                        });
                                    </script>
                                </div>

                            </div>
                        @endif

                    </div>
                @endif

                    <?php $iterate++;?>

                @if($iterate <= 6 && isset($page[$iterate]->type) )

                        <?php
                            if($page[$iterate]->type == 'Home Valuation')
                            {
                                $landingPageNumber = '1';
                            }else if($page[$iterate]->type == 'Property Details')
                            {
                                $landingPageNumber = '2';
                            }else if($page[$iterate]->type == 'Open Houses')
                            {
                                $landingPageNumber = '3';
                            }else if($page[$iterate]->type == 'New Product Countdown')
                            {
                                $landingPageNumber = '4';
                            }else if($page[$iterate]->type == 'New Product Coupon')
                            {
                                $landingPageNumber = '5';
                            }else if($page[$iterate]->type == 'Single Item Shopping Cart')
                            {
                                $landingPageNumber = '6';
                            }
                        ?>
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    {{$page[$iterate]->type}}

                                    <a href="../edit/landingPage/{{$landingPageNumber}}" class="pull-right fontWhite">Edit</a>
                                </div>

                                    <div class="panel-body" style="background-size: cover;height: 21em; width: 100%; background-image: url('http://growyourleads.com/uploads/landingPage{{$landingPageNumber}}Default.jpg')">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                                        <div class="centerBlock">
                                            <strong>{{$page[$iterate]->type}} Landing Page Link: &nbsp;</strong><br>
                                            <input id="linkToCopy{{$landingPageNumber}}" value="{{ URL::to('/').'/link'.$landingPageNumber.'/'.$userLink }}" type="text">&nbsp;
                                            <button type="button" id="copy{{$landingPageNumber}}" data-clipboard-target="#linkToCopy{{$landingPageNumber}}" class="btn btn-success copyLinkInput">Copy</button>
                                            
                                            &nbsp;<strong class="copiedLink absoTop3p5 copiedLink{{$landingPageNumber}}">Copied!</strong>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        new Clipboard('#copy{{$landingPageNumber}}');
                                        $(document).ready(function(){
                                            $('#copy{{$landingPageNumber}}').click(function(){
                                                    $(".copiedLink{{$landingPageNumber}}").attr( "style", "display: inline !important;" )
                                                    setTimeout(function() { $(".copiedLink{{$landingPageNumber}}").fadeOut(); }, 5000);
                                            });
                                        });
                                    </script>

                                </div>

                            </div>
                        </div>
                @endif

                <?php $iterate = 0;?>

            </div>
            

            @if($count == 0)
                <?php $count = 1; ?>
            @else
                <?php $count = 0; ?>
            @endif

            

        @endforeach
        
        </form>

    </div>

@endsection

@section('footer_scripts')


@endsection