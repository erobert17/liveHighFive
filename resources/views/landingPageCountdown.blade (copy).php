<!DOCTYPE html>
<html class="tinted-image" lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>New Product Countdown Landing Page</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
    <script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>

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

<body>

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
                      
          });

        }else{
          $('#emailError').text('Email Not Valid');
        }
        
      });
    })
  </script>

  <style type="text/css">
  @media(max-width:1100px){
    @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP4.jpg' ))
      
        .background {
          background: url({{asset('uploads/users/id/'.$userId.'/backgroundLP4.jpg')}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
    @else
        
        
        .background {
          background:url({{asset('uploads/placeholderBG4.jpg')}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
      
    @endif

  }

  @media(min-width:1101px){

      @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP4.jpg' ))
      
        .background {
          background: url({{asset('uploads/users/id/'.$userId.'/backgroundLP4.jpg')}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
          box-shadow: inset 0 0 0 1000px rgba(39, 62, 84, 0.6);
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

  </style>


  <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}">
  <script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>

    <!-- Page Content -->
    <div class="container-fluid background" style="height: 55em;">

      <div class="row vert-offset-top-1 vert-offset-bottom-1">
        <div class="col-md-4">
          
          @if ($userProfile->avatar_status == 1)
            <img src="{{ $userProfile->avatar }}" class="khula img-responsive center-block" style="object-fit: cover; max-width:200px;float: left;">
          @endif
          
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>

      <?php 
      echo '<pre>';
      var_dump($thisLandingPageRow[0]->countdown);
      echo '</pre>';
            $countdown = $thisLandingPageRow[0]->countdown;
            $countdown = str_replace('/', '-', $countdown);
            $countdown = str_replace(' -0500', '', $countdown);
            echo '$countdown:: ',$countdown;
            $format = 'm-d-Y H:i';
            $date = DateTime::createFromFormat($format, $countdown);
            //Testing length var, not used to display date
            //echo '$date '.$date;
            //$dateString = $date;
            $dateString = $date->format('Y-m-d H:i:s');
            echo '$dateString '.$dateString;
            //'Y-m-d H:i:s'
            //M j, Y H:i:s
            //echo "Format: $format; " . $date->format('M j, Y H:i:s') . "\n";
      ?>
      @if( strlen($dateString) > 2 )
        <div class="row vert-offset-bottom-1">
          <div class="col-md-12">

              <h1 class="preCountdownText">We Launch In</h1>
              <h1 id="countdownClock" class="countdownText"></h1>
          </div>
        </div>
      @endif
      <script>
      // Set the date we're counting down to
      //Sep 5, 2018 15:37:25
      //var countDownDate = new Date("<?php echo $date->format('M j, Y H:i:s'); ?>").getTime();
      var countDownDate = new Date("<?php echo $dateString; ?>").getTime();
      // Update the count down every 1 second
      var x = setInterval(function() {
        // Get todays date and time
        var now = new Date().getTime();
        // Find the distance between now an the count down date
        var distance = countDownDate - now;
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("countdownClock").innerHTML = days + " days " + hours + " hours "
        + minutes + " mintues " + seconds + " seconds ";

        // If the count down is finished, write some text 
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("countdownClock").innerHTML = "EXPIRED";
        }
      }, 1000);
      </script>

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4" style="">
          <h1 style="font-weight: 700; font-size:55px">{{$thisLandingPageRow[0]->title}}</h1>
          <br>
          <h4 style="color:white;">{{$thisLandingPageRow[0]->secondaryTitle}}</h4>
          <br>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong" style="background:#262626; color:white;">
            Subscribe For Preorders
          </button>
          <br>
          <h5>*{{$thisLandingPageRow[0]->disclaimer}}</h5>
        </div>

        <div class="col-md-4">
          <?php
          $ch = curl_init('http://growyourleads.com/uploads/users/id/' .$userId. '/uploadProductCountdownImg.png');    
                                        
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 
          $backgroundExists = '';
          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height: 439px;float: left;" id="" class=""src="http://growyourleads.com/uploads/users/id/' .$userId. '/uploadProductCountdownImg.png" />';   
          }else{
            $backgroundExists = false;
          }

          ?>
        </div>
        <div class="col-md-2"></div>
      </div>

  </div>

</body>

</html>