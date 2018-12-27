<!DOCTYPE html>
<html lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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
  }else{ echo 'style="background-color: #3886e7; !important;"'; } ?> >


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
  if (file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP7.jpg' ) ){
    $bgImg = 'backgroundLP7.jpg';
  }else if(file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP7.png' ) ){
    $bgImg = 'backgroundLP7.png';
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
          background:url({{asset('uploads/placeholderBG5.jpg')}}) no-repeat center center fixed; 
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
          background:url({{asset('uploads/placeholderBG5.jpg')}}) no-repeat center center fixed; 
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

          $ch = curl_init('http://growyourleads.com/uploads/users/id/' .$userId. '/uploadDigitalDownloadProductImg.png');    
                                        
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 
          $backgroundExists = '';
          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height: 439px;margin-right: auto; margin-left: auto;" id="" class="img-responsive" src="http://growyourleads.com/uploads/users/id/' .$userId. '/uploadDigitalDownloadProductImg.png" />';   
          }else{
            $backgroundExists = false;
          }

          ?>
        </div><br>
          <a href="{{$thisLandingPageRow[0]->digitalDownloadUrl}}">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong" style="background:#{{$thisLandingPageRow[0]->buttonColor}} !important; color:white;">
            Download
          </button>
          </a>
          <br>
          <h5 style="color:#{{$thisLandingPageRow[0]->disclaimerColor}} !important;">*{{$thisLandingPageRow[0]->disclaimer}}</h5>
        </div>
        <div class="col-md-4 hideOnBigger813"></div>
        <div class="col-md-4 hideOnSmaller812">
          <?php

          $ch = curl_init('http://growyourleads.com/uploads/users/id/' .$userId. '/uploadDigitalDownloadProductImg.png');    
                                        
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 
          $backgroundExists = '';
          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height: 439px;margin-right: auto; margin-left: auto;" id="" class="img-responsive" src="http://growyourleads.com/uploads/users/id/' .$userId. '/uploadDigitalDownloadProductImg.png" />';   
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