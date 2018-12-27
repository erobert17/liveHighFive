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
    
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

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

      <div class="row vert-offset-top-1 vert-offset-bottom-3">
        <div class="col-md-4">
          @if(isset($authorAvatar[0]->avatar))
              <img src="{{URL::to('/') . $authorAvatar[0]->avatar }}" class="largeUserAvatar" style="float:left!important;margin-left: 0.3em;">
          @endif
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4" style="">
          
          <h1 style="font-weight: 700; font-size:66px">{{$thisLandingPageRow[0]->title}}</h1>
          <br>
          <h4 style="color:white;">{{$thisLandingPageRow[0]->secondaryTitle}}</h4>
          <br>
          <button type="button" class="btn" style="background-color:#262626;">ORDER YOURS NOW</button>
        </div>

        <div class="col-md-4">
          <?php
          $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/uploadProductCountdownImg.jpg');    
                                        
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 
          $backgroundExists = '';
          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height: 578px;float: left;" id="" class=""src="http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/uploadProductCountdownImg.jpg" />';   
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