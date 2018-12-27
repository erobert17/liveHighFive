<!DOCTYPE html>
<html class="tinted-image" lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://growyourleads.com/favicon.ico">

    <title>New Product Countdown Landing Page</title>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>

    <!-- Custom CSS -->
    <link href="{{asset('css/the-big-picture.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-3-vert-offset-shim.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/font-awesome.min.css') }}"
    ><link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-slider.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Khula" rel="stylesheet">

    <script type="text/javascript" src="{{asset('js/bootstrap-slider.min.js')}}"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{asset('js/accounting.js')}}"></script>

    <!-- image scrolling -->
    <link rel="stylesheet" href="{{asset('/css/jquery.mThumbnailScroller.css') }}">
    
    <script src="{{asset('js/jquery.mThumbnailScroller.min.js')}}"></script>
    <!-- lightbox -->
    <link rel="stylesheet" type="text/css" href="{{asset('/css/lightbox.css') }}">
    <script src="{{asset('js/lightbox.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('/css/main.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- CUSTOM !!!! -->
    </head>

<body <?php if(isset($thisLandingPageRow[0]->backgroundColor)){
  echo 'style="background-color:#'.$thisLandingPageRow[0]->backgroundColor.' !important;"';
  } ?> >

  <!-- Modal -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="padding-bottom: 34px;">
          <h5 class="modal-title" id="exampleModalLongTitle" style="border-radius:30px;">Join The Preorder List</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Give us you're email and we'll contact you when preorders are ready.</p>
          <span id="emailError" style="color:red;"></span><br>
          <label>Email: <input type="text" name="email" id="emailInput" class="longInput"></label>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" id="submit">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="finishedModal" tabindex="-1" role="dialog" aria-labelledby="finishedModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="padding-bottom: 34px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Thank you for your email.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#submit').click(function(){
        var userId = '<?php echo $userId; ?>';
        var email = $('#emailInput').val();

        if(email.length > 5 && email.indexOf('@') != -1){
          $('#emailError').text('');
          $.ajax({
            type: 'POST',
            url: '/submitEmailLp4',
            data: {  "_token": "{{ csrf_token() }}",
            "email": email,
             'userId': userId },
            //"email": email,
            success:function(data) {
              //$('.modal-body').html('<h3 style="color: #3097d1;text-align: center;">{{$thisLandingPageRow[0]->coupon}}</h3>');
              ///$('#exampleModalLongTitle').html('Copy the code below and paste it at checkout');
              
            }
          }).done(function( msg ) {
            $("#finishedModal").modal({show: true});
          });

        }else{
          $('#emailError').text('Email Not Valid');
        }
        
      });
    })
  </script>
    <?php
  $bgImg = '';
  if (file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP4.jpg' ) ){
    $bgImg = 'backgroundLP4.jpg';
  }else if(file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP4.png' ) ){
    $bgImg = 'backgroundLP4.png';
  }
  
  ?>

  <style type="text/css">

  @media(max-width:1100px){
    @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/'.$bgImg ) && isset($thisLandingPageRow[0]->backgroundColor) !== true)
      
        .background {
          background: url({{asset('uploads/users/id/'.$userId.'/'.$bgImg)}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
    @elseif(isset($thisLandingPageRow[0]->backgroundColor))
        
        .background{ 
          background-color: #{{$thisLandingPageRow[0]->backgroundColor}}; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }

    @else
        .background{ 
          background:url({{asset('uploads/placeholderBG4.jpg')}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
    @endif

  }

  @media(min-width:1101px){

      @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/'.$bgImg  ) &&isset($thisLandingPageRow[0]->backgroundColor) !== true)
      
        .background {
          background: url({{asset('uploads/users/id/'.$userId.'/'.$bgImg)}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
          
        }
      @elseif(isset($thisLandingPageRow[0]->backgroundColor))
        
        .background{ 
          background-color: #{{$thisLandingPageRow[0]->backgroundColor}}; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }

      @else
        .background{ 
          background:url({{asset('uploads/placeholderBG4.jpg')}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
      @endif
font-weight: 700; font-size:55px
  }

  </style>

  <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}">
  <script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>

    <!-- Page Content -->
    <div class="container-fluid background" style="height: 100%;">

      <div class="row vert-offset-top-1 vert-offset-bottom-1">
        <div class="col-md-4">
          
          @if ($userProfile->avatar_status == 1)
            <img src="{{ $userProfile->avatar }}" class="khula img-responsive center-block" style="object-fit: cover; max-width:200px;float: left;">
          @else

            <h5 style="font-weight:700;color:#{{$thisLandingPageRow[0]->titleColor}} !important; ">{{$user->company}}</h5>
          @endif
          
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>

      <?php 
      //03-21-2018 00:00 +0700
            $countdown = $thisLandingPageRow[0]->countdown;
            $countdown = str_replace('/', '-', $countdown);
            $countdown = str_replace(' -0500', '', $countdown);
            $countdown = str_replace(' -0700', '', $countdown);
            $countdown = str_replace(' +0500', '', $countdown);
            $countdown = str_replace(' +0700', '', $countdown);
            $countdown = str_replace(' +0700', '', $countdown);
            $countdown = str_replace(' +0700', '', $countdown);
            $countdown = str_replace(' +0800', '', $countdown);
            $countdown = str_replace(' +0900', '', $countdown);
            $countdown = str_replace(' -0500', '', $countdown);
            $countdown = str_replace(' -0600', '', $countdown);
            $countdown = str_replace(' -0700', '', $countdown);
            $countdown = str_replace(' -0800', '', $countdown);
            $countdown = str_replace(' -0900', '', $countdown);

            $countdown = $countdown.':00';
            // 08-15-2018 00:00
            // $countdown = substr($countdown, 0, strpos($countdown, '-'));
            // 05-21-2018 00:00:00
         
            $dateString = Datetime::createFromFormat('m-d-Y H:i:s', $countdown)->format('Y-m-d h:i:s'); 
            //$dateString = 'doo da';
            //$dateString = $countdown;
            //'Y-m-d H:i:s'
            //M j, Y H:i:s
            //echo "Format: $format; " . $date->format('M j, Y H:i:s') . "\n";
      ?>
      @if( strlen($dateString) > 2 )
        <div class="row vert-offset-bottom-6 vert-offset-top-2">
          <div class="col-md-12">
              @if($thisLandingPageRow[0]->titleShadow == 1)
                <h1 class="preCountdownText titleTextShadow" style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->preCountdownText}}</h1>
                <h1 id="countdownClock" class="countdownText titleTextShadow" style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;"></h1>
              @else
                <h1 class="preCountdownText" style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->preCountdownText}}</h1>
                <h1 id="countdownClock" class="countdownText" style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;"></h1>
              @endif
          </div>
        </div>
      @endif
      <script>
        $(document).ready(function(){

          var days = 0;
          var hours = 0;
          var minutes = 0;
          var seconds = 0;
          var distance = 0;
          var newTimeClock = 0;
        // Set the date we're counting down to
        //Sep 5, 2018 15:37:25
        <?php 
          //Sep 05, 2019 12:00:00
          $yourDate = date("M d, Y H:i:s", strtotime($dateString) );
          
        ?>
        var countDownDate = new Date("<?php echo $yourDate; ?>").getTime();
        // Update the count down every 1 second
        var x = setInterval(function() {
          // Get todays date and time
          var now = new Date().getTime();
          // Find the distance between now an the count down date
          distance = countDownDate - now;
          console.log("countDownDate "+countDownDate);
          // Time calculations for days, hours, minutes and seconds
          days = Math.floor(distance / (1000 * 60 * 60 * 24));
          hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          seconds = Math.floor((distance % (1000 * 60)) / 1000);
          newTimeClock = days + " days " + hours + " hours "
          + minutes + " mintues " + seconds + " seconds ";
          // Display the result in the element with id="demo"
          if(newTimeClock.indexOf('-') != -1 ){
            newTimeClock = '0 days 0 hours 0 mintues 0 seconds';
          };
          document.getElementById("countdownClock").innerHTML = newTimeClock;

          // If the count down is finished, write some text 
          /*
          alert(distance);
          if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdownClock").innerHTML = "EXPIRED";
          }*/
        }, 1000);


      });
      </script>

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4" style="">
          
          @if($thisLandingPageRow[0]->titleShadow == 1)
            <h1 class="titleTextShadow postCountdownText" style="font-weight: 700; font-size:55px; color:#{{$thisLandingPageRow[0]->titleColor}} !important;" >{{$thisLandingPageRow[0]->title}}</h1>
          @else
            <h1 style="font-weight: 700; font-size:55px; color:#{{$thisLandingPageRow[0]->titleColor}} !important;" >{{$thisLandingPageRow[0]->title}}</h1>
          @endif
          <br>
          <h4 style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->secondaryTitle}}</h4>
          <br>
          <div class="hideOnBigger813">
          <?php

          $ch = curl_init('http://growyourleads.com/uploads/users/id/' .$userId. '/uploadProductCountdownImg.png');    
                                        
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 
          $backgroundExists = '';
          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height: 439px;margin-right: auto; margin-left: auto;" id="" class="img-responsive" src="http://growyourleads.com/uploads/users/id/' .$userId. '/uploadProductCountdownImg.png" />';   
          }else{
            $backgroundExists = false;
          }

          ?>
        </div><br>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong" style="background:#{{$thisLandingPageRow[0]->buttonColor}} !important; color:white;">
            Subscribe For Preorders
          </button>
          <br>
          <h5 style="color:#{{$thisLandingPageRow[0]->disclaimerColor}} !important;">*{{$thisLandingPageRow[0]->disclaimer}}</h5>
        </div>
        <div class="col-md-4 hideOnBigger813"></div>
        <div class="col-md-4 hideOnSmaller812">
          <?php

          $ch = curl_init('http://growyourleads.com/uploads/users/id/' .$userId. '/uploadProductCountdownImg.png');    
                                        
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 
          $backgroundExists = '';
          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height: 439px;margin-right: auto; margin-left: auto;" id="" class="img-responsive" src="http://growyourleads.com/uploads/users/id/' .$userId. '/uploadProductCountdownImg.png" />';   
          }else{
            $backgroundExists = false;
            
            echo '<img style="max-height: 439px;margin-right: auto; margin-left: auto;" id="" class="img-responsive" src="http://growyourleads.com/img/productPlaceholder.jpg" />';   
          }

          ?>
        </div>
        <div class="col-md-2"></div>
      </div>

  </div>

</body>

</html>