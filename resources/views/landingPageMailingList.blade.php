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
    <title>Mailing List Landing Page</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-3-vert-offset-shim.css')}}">
    
    <!-- Custom CSS -->
    <!--
    <link href="{{asset('css/the-big-picture.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-3-vert-offset-shim.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/font-awesome.min.css') }}"
    >
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-slider.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Khula" rel="stylesheet">
  -->

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
  }else{echo 'class="background"';} ?> >


<script type="text/javascript">
  $(document).ready(function(){
    $('#submit').click(function(){
      var userId = '<?php echo $userId; ?>';
      var email = $('#emailInput').val();

      if(email.length > 5 && email.indexOf('@') != -1){
        $('#emailError').text('');
        $.ajax({
          type: 'POST',
          url: '/submitEmailLp9',
          data: {  "_token": "{{ csrf_token() }}",
          "email": email,
           'userId': userId },
          //"email": email,
          success:function(data) {
            $('.modal-body').html('<h3 style="color: #3097d1;text-align: center;">{{$thisLandingPageRow[0]->coupon}}</h3>');
            $('#emailInput').replaceWith("<h3 style='text-align:center;color:#{{$thisLandingPageRow[0]->titleColor}};'>Thank you for your submission.</h3>");
            $('#exampleModalLong #submit').remove();
            
          }
        }).done(function( msg ) {
                    
        });

      }else{
        $('#emailError').text('Email Not Valid');
      }
      
    });
  })
</script>
  <?php
  $bgImg = '';
  if (file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP9.jpg' ) ){
    $bgImg = 'backgroundLP9.jpg';
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
          background:url({{asset('uploads/placeholderBG9.jpg')}}) no-repeat center center fixed; 
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
          background:url({{asset('uploads/placeholderBG9.jpg')}}) no-repeat center center fixed; 
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
    <div class="container-fluid" style="height: 100%;">

      <div class="row vert-offset-top-12 vert-offset-bottom-1">
        <div class="col-md-12 ">
          
          @if ($userProfile->avatar_status == 1)
            <img src="{{ $userProfile->avatar }}" class="khula img-responsive center-block" style="object-fit: cover; max-width:200px;">
          @else
            <h5 style="font-weight:700;color:#{{$thisLandingPageRow[0]->titleColor}} !important; ">{{$user->company}}</h5>
          @endif
          
        </div>
      </div>

      <div class="row vert-offset-top-2">
        
        <div class="col-md-12" style="">
          @if($thisLandingPageRow[0]->titleShadow == 1)
            <h1  class="titleTextShadow"  style="font-weight: 700; font-size:66px; text-align: center; color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->title}}</h1>
          @else
            <h1 style="font-weight: 700; text-align: center; font-size:66px; color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->title}}</h1>
          @endif
          
        </div>

      </div>

      <div class="row vert-offset-top-2">
        <div class="col-md-12">
          
          <h4 style="text-align: center; color:#{{$thisLandingPageRow[0]->titleColor}}">{{$thisLandingPageRow[0]->secondaryTitle}}</h4>

        </div>
      </div>

      <div class="row vert-offset-top-2">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          
          <input type="text" name="email" placeholder="your@email.com" id="emailInput" class="form-control"></label>

        </div>
        <div class="col-md-4"></div>

      </div>

      <div class="row vert-offset-top-2">
        <div class="col-md-5"></div>

        <div class="col-md-2 ">            
          <!-- Button trigger modal -->
          @if(isset($thisLandingPageRow[0]->buttonColor))
            <button type="button" id="submit" class="btn btn-primary center-block" data-toggle="modal" data-target="#exampleModalLong" style="background:#{{$thisLandingPageRow[0]->buttonColor}}; color:white; text-align: center;">
              Join Mailing List
            </button>
          @else
            <button type="button" id="submit" class="btn btn-primary center-block" data-toggle="modal" data-target="#exampleModalLong" style="background:#262626; color:white;text-align: center;">
              Join Mailing List
            </button>
          @endif

        </div>
        <div class="col-md-5"></div>
      </div>

      <div class="row vert-offset-top-2">
        <div class="col-md-12">
          
          <h5 class="text-center" style="color:#{{$thisLandingPageRow[0]->disclaimerColor}};">{{$thisLandingPageRow[0]->disclaimer}}</h5>

        </div>
      </div>

  </div>

</body>

</html>