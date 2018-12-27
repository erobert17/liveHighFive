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

    <title>Appointments Landing Page</title>
    
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
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}">
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
<!-- Modal -->
<div class="modal fade" id="thanksForScheduling" tabindex="-1" role="dialog" aria-labelledby="thanksForSchedulingTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding-bottom: 12px;">
        <h4 class="modal-title" id="thanksForSchedulingTitle" style="border-radius:30px;">Thanks for scheduling a appointment.</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>We've recieved your schedule request and will confirm via email. Thanks</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  .error{
    color:orange;
  }
</style>

<script type="text/javascript">
  $(document).ready(function(){

    $('#submitButton').click(function(){
      var userId = '<?php echo $userId; ?>';
      var name = $('#name').val();
      var email = $('#email').val();
      var phone = $('#phone').val();
      var timeDate = $('#countDownDateTime').val();
      var errors = 0;
      if(name.length > 2){
        $('#nameError').text('');
      }else{
        $('#nameError').text('Name Required');
        errors++;
      }

      if(email.length > 5 && email.indexOf('@') != -1){
        $('#emailError').text('');
      }else{
        $('#emailError').text('Email Not Valid');
        errors++;
      }

      if(phone.length > 5){
        $('#phoneError').text('');
      }else{
        $('#phoneError').text('Phone Not Valid');
        error++;
      }

      if(timeDate.length > 5){
        $('#countDownDateTimeError').text('');
      }else{
        $('#countDownDateTimeError').text('Time & Date Requird');
        errors++;
      }
      
      if(errors === 0){
        console.log('errors equal zero');
        $('#appointmentForm')[0].submit();

      }else{
        errors = 0;
      }
      
    });

    $('#countDownDateTime').datetimepicker({
      timeFormat: 'HH:mm z',
      timezoneList: [ 
        { value: -300, label: 'Eastern'}, 
        { value: -360, label: 'Central' }, 
        { value: -420, label: 'Mountain' }, 
        { value: -480, label: 'Pacific' } 
                                        ]
    });



  })
</script>
  <?php
  $bgImg = '';
  if (file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP8.jpg' ) ){
    $bgImg = 'backgroundLP8.jpg';
  }else if(file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP5.png' ) ){
    $bgImg = 'backgroundLP5.png';
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

  <script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>
  <script src="{{asset('js/php-date-formatter.min.js')}}"></script>
  <script src="{{asset('js/jquery.mousewheel.js')}}"></script>
  <script src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>
  
    <!-- Page Content -->
    <div class="container-fluid" style="height: 100%;">

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
            <h1  class="titleTextShadow"  style="font-weight: 700; font-size:66px; color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->title}}</h1>
          @else
            <h1 style="font-weight: 700; font-size:66px; color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->title}}</h1>
          @endif
          
          <br>
          <h4 style="color:#{{$thisLandingPageRow[0]->titleColor}}">{{$thisLandingPageRow[0]->secondaryTitle}}</h4>
          <br>
        <div class="col-md-7" style="">
            <form id="appointmentForm" enctype="multipart/form-data"  method="POST" action="/submitAppointment">
              <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
              <input type="hidden" name="userId" id="userId" value="{{ $userId }}" />
              <div class="row vert-offset-bottom-1">
                <div class="col-md-12">
                  <label style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;">Name</label>
                  <span id="nameError" class="error"></span>
                  <input type="text" class="float-left form-control" id="name" name="name" placeholder="Name" value="" />
                </div>
              </div>

              <div class="row vert-offset-bottom-1">
                <div class="col-md-12">
                  <label style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;">Email</label>
                  <span id="emailError" class="error"></span>
                  <input type="text" class="float-left form-control" id="email" name="email" placeholder="Email@your.com" value=""/>
                </div>
              </div>

              <div class="row vert-offset-bottom-1">
                <div class="col-md-12">
                  <label style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;">Phone</label>
                  <span id="phoneError" class="error"></span>
                  <input type="text" class="float-left form-control" id="phone" name="phone" placeholder="123-456-7890" value=""/>
                </div>
              </div>

              <div class="row vert-offset-bottom-1">
                <div class="col-md-12">
                  <label style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;">Date & Time</label>
                  <span id="countDownDateTimeError" class="error"></span>
                  <input type="text" id="countDownDateTime" id="timeDate" name="timeDate" class="float-left form-control" placeholder="Click to Select Date & Time" value=""/>
                  
                </div>
              </div>

              <div class="row vert-offset-bottom-1">
                <div class="col-md-12">

                  @if(isset($thisLandingPageRow[0]->buttonColor))
                    <button type="button" class="btn btn-primary" id="submitButton" data-toggle="modal" data-target="#exampleModalLong" style="background:#{{$thisLandingPageRow[0]->buttonColor}} !important; color:white;">
                      Submit Time & Date
                    </button>
                  @else
                    <button type="button" class="btn btn-primary" id="submitButton" data-toggle="modal" data-target="#exampleModalLong">
                      Submit Time & Date
                    </button>
                  @endif
                </div>
              </div>

              <div class="row vert-offset-bottom-1">
                <div class="col-md-12">
                  <h5 style="color:#{{$thisLandingPageRow[0]->disclaimerColor}};">{{$thisLandingPageRow[0]->disclaimer}}</h5>
                </div>
              </div>

            </form>

          </div>
          
        </div>

        <div class="col-md-4 vert-offset-top-1 ">
          <?php
          $ch = curl_init('http://growyourleads.com/uploads/users/id/' .$userId. '/uploadAppointmentProductImg.png');    
                                        
          curl_setopt($ch, CURLOPT_NOBODY, true);
          curl_exec($ch);
          $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 
          $backgroundExists = '';
          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height:600px;float:left;" id="" class="img-responsive vert-offset-bottom-10" src="http://growyourleads.com/uploads/users/id/' .$userId. '/uploadAppointmentProductImg.png" />';   
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