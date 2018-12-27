

@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

<div id="fillWithNoobMessage">
</div>

@section('content')
    
    <script type="text/javascript">
        $(document).ready(function() {
                
                
                
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

                    
                        if({{$user->helpBubbleToggle}} == 1){// always 1 until user turns off all hint bubbles
                                
                                $('#fillWithNoobMessage').html("<div class='noobMessage noShowOnMobile'><p class='text-center'>There's a '<strong>Stats</strong>' link in the left menu, below this landing page's link.</p><p class='text-center'>Click it to see metrics for this landing page. </p><div class='text-center'><button id='closeHint' class='text-center'> Close </button><button id='neverShowHints' class='text-center'> Never Show These Hints </button></div></div>");

                                $('.noobMessage').css('display', 'block');

                                var glow = $(".copyLinkInput");
                                glow.addClass('noobBackgroundColor');
                                setInterval(function(){
                                    glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
                                }, 500);

                        }
                    
                }

                if({{$userHintState}} === 2){
 
                    
                        if({{$user->helpBubbleToggle}} == 1){// always 1 until user turns off all hint bubbles
                                $("#paragraphs").html();
                    
                                $('#p1').text(<?php echo'"'.$hintText[2]->p1.'"'; ?> );
                                $('#p2').text(<?php echo"'".$hintText[2]->p2."'"; ?>);
                            
                                $(".copyLinkInput").removeClass('noobBackgroundColor');// stop red copy button flashing
                                $('#nextHint').remove();
                                $(".noobMessage").delay(100).fadeIn();
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
        
        <form action="saveLandingPage" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <?php
         $count = 0;
         $iterate = 0;// used to select numbered array inside $page
         $landingPageNumber = '1';
         $alreadyDisplayedAddNewLP = False;
         $countLPsPrinted = 0;
         $oddEvenSwitch = 'odd';
         $typeNamesAlreadyPrinted = [];
         $rowOpenClose = 'open';
         ?>


        @foreach($landingPagePrefabs as $page)

            @if($rowOpenClose == 'open')
                <div class="row">
                <?php $rowOpenClose = 'close'; ?>
            @endif
            

                @if($iterate <= 9 && isset($page->typeName) && !in_array($page->typeName, $typeNamesAlreadyPrinted))
                    @if($countLPsPrinted == 0 || $oddEvenSwitch == 'even')
                        <?php 
                        
                        if($page->typeName == 'Home Valuation')
                        {
                            $landingPageNumber = '1';
                        }else if($page->typeName == 'Property Details')
                        {
                            $landingPageNumber = '2';
                        }else if($page->typeName == 'Open Houses')
                        {
                            $landingPageNumber = '3';
                        }else if($page->typeName == 'New Product Countdown')
                        {
                            $landingPageNumber = '4';
                        }else if($page->typeName == 'New Product Coupon')
                        {
                            $landingPageNumber = '5';
                        }else if($page->typeName == 'Single Item Shopping Cart')
                        {
                            $landingPageNumber = '6';
                        }else if($page->typeName == 'Digital Download')
                        {
                            $landingPageNumber = '7';
                        }else if($page->typeName == 'Appointment')
                        {
                            $landingPageNumber = '8';
                        }else if($page->typeName == 'Mailing List')
                        {
                            $landingPageNumber = '9';
                        }
                        
                        ?>


                        <?php 
                        $typeFound = False;
                        ?>

                        @foreach($allLPsNotYetMadeByUser as $landingPage)
                            @if($landingPage->typeName == $page->typeName)
                                <?php $typeFound = True;?>

                            @endif
                        @endforeach

                        @if($typeFound == True)
                            <?php array_push($typeNamesAlreadyPrinted, $page->typeName);?>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        {{$page->typeName}}
                                    </div>

                                    <div class="panel-body" style="background-size: cover; background-position-x: center;height: 21em; width: 100%; background-image: url('http://growyourleads.com/uploads/landingPage{{$landingPageNumber}}Default.jpg')">
                                    </div>
                                </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                                                <div class="centerBlock">
                                                    <a href="createLP/{{$page->id}}/{{$user->id}}">
                                                        <button type="button" class="btn btn-success copyLinkInput">Create {{$page->typeName}} Landing Page</button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                            </div>
                            <?php 
                            $iterate++;
                            $countLPsPrinted++;
                            $oddEvenSwitch = "odd";
                            
                            ?>

                        @endif

                    @endif



                @endif

                    
                @if($iterate <= 9 && isset($page->typeName) && $countLPsPrinted > 0 && !in_array($page->typeName, $typeNamesAlreadyPrinted) )
                    @if($oddEvenSwitch == 'odd')

                        <?php
                            if($page->typeName == 'Home Valuation')
                            {
                                $landingPageNumber = '1';
                            }else if($page->typeName == 'Property Details')
                            {
                                $landingPageNumber = '2';
                            }else if($page->typeName == 'Open Houses')
                            {
                                $landingPageNumber = '3';
                            }else if($page->typeName == 'New Product Countdown')
                            {
                                $landingPageNumber = '4';
                            }else if($page->typeName == 'New Product Coupon')
                            {
                                $landingPageNumber = '5';
                            }else if($page->typeName == 'Single Item Shopping Cart')
                            {
                                $landingPageNumber = '6';
                            }else if($page->typeName == 'Digital Download')
                            {
                                $landingPageNumber = '7';
                            }else if($page->typeName == 'Appointment')
                            {
                                $landingPageNumber = '8';
                            }else if($page->typeName == 'Mailing List' || $page->typeName == 'Mailing LIst')
                            {
                                $landingPageNumber = '9';
                            }
                            
                        ?>
                        <?php 
                        $typeFound = False;
                        ?>

                        @foreach($allLPsNotYetMadeByUser as $landingPage)
                            
                            @if($landingPage->typeName == $page->typeName)
                                <?php $typeFound = True;?>

                            @endif
                        @endforeach

                        @if($typeFound == True)
                            
                            <?php array_push($typeNamesAlreadyPrinted, $page->typeName);?>

                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        {{$page->typeName}}
                                    </div>

                                    <div class="panel-body" style="background-size: cover; background-position-x: center;height: 21em; width: 100%; background-image: url('http://growyourleads.com/uploads/landingPage{{$landingPageNumber}}Default.jpg')">
                                    </div>
                                </div>

                                
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                                                <div class="centerBlock">
                                                    <a href="createLP/{{$page->id}}/{{$user->id}}">
                                                        <button type="button" class="btn btn-success copyLinkInput">Create {{$page->typeName}} Landing Page</button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                            </div>
                            <?php $iterate++;
                            $countLPsPrinted++;
                            $oddEvenSwitch = 'even';
                            ?>

                            @if($rowOpenClose == 'close')
                                </div><!-- end row-->
                                <?php $rowOpenClose = 'open'; ?>
                            @endif

                        @endif
                    
                    @endif

                @endif


        @endforeach

        
        </form>

    </div>

@endsection

@section('footer_scripts')


@endsection