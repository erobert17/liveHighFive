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
    <title>{{$product->name}} Shopping Cart Payment</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-3-vert-offset-shim.css')}}">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

     <!-- lightbox -->
    <link rel="stylesheet" type="text/css" href="http://growyourleads.com/css/lightbox.css">
    <script src="http://growyourleads.com/js/lightbox.js"></script>


    <script type="text/javascript" src="{{asset('js/shoppingCartValidate.js')}}"></script>
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

<body>
  
  <?php
    $bgImg = '';
    if (file_exists(public_path().'/uploads/users/id/'.$userId.'/'.$background ) ){
      $bgImg = $background;
    }else if(file_exists( public_path().'/uploads/users/id/'.$userId.'/'.$background ) ){
      $bgImg = $background;
    }else{
      $bgImg = 'backgroundLP6.png';
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
          background:url({{asset('uploads/placeholderBG6.jpg')}}) no-repeat center center fixed; 
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
          background:url({{asset('uploads/placeholderBG6.jpg')}}) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
      @endif
font-weight: 700; font-size:55px
  }

  .titleTextColor {
    color:#{{$thisLandingPageRow[0]->titleColor}} !important;
  }

  </style>

  <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}">
  <script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>

  <!-- Page Content -->
    
  <div class="container-fluid background" style="height: 100%;">

    <div class="row vert-offset-top-6">
      <div class="col-md-4"></div>
      
      <div class="col-md-4 vert-offset-top-1 vert-offset-bottom-1" style="background: white;border-radius: 31px;    padding-bottom: 1em;padding-top: 1em;">
        
        <div class="row">
          <div class="col-md-6"><strong >Product:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->productName}}</span></div>
        </div>

        <div class="row" style="background: #80808030;">
          <div class="col-md-6"><strong >Quantity:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->qty}}</span></div>
        </div>

        <div class="row">
          <div class="col-md-6"><strong >Price:</strong></div>
          <div class="col-md-6"><span class="floatLeft">${{$thisOrder->price}}</span></div>
        </div>

        <div class="row">
          <div class="col-md-6"><strong >Total Price:</strong></div>
          <div class="col-md-6"><span class="floatLeft">${{$totalPriceHuman}}</span></div>
        </div>

        <div class="row" style="border-top: 1px solid black;background: #80808030;">
          <div class="col-md-6"><strong >Name:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->firstName}} {{$thisOrder->lastName}}</span></div>
        </div>
      
        <div class="row">
          <div class="col-md-6"><strong >Phone:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->phone1}}</span></div>
        </div>

        <div class="row" style="background: #80808030;">
          <div class="col-md-6"><strong >Alt Phone:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->phone2}}</span></div>
        </div>

        <div class="row">
          <div class="col-md-6"><strong >Email:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->email}}</span></div>
        </div>

        <div class="row" style="background: #80808030;">
          <div class="col-md-6"><strong >Address:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->streetAddress}}</span></div>
        </div>

        <div class="row">
          <div class="col-md-6"><strong >City:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->city}}</span></div>
        </div>

        <div class="row" style="background: #80808030;">
          <div class="col-md-6"><strong >State:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->state}}</span></div>
        </div>

        <div class="row">
          <div class="col-md-6"><strong >Custom State:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->customState}}</span></div>
        </div>

        <div class="row" style="background: #80808030;">
          <div class="col-md-6"><strong >Zip/Postal Code:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->zip}}</span></div>
        </div>

        <div class="row">
          <div class="col-md-6"><strong >Country:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$thisOrder->country}}</span></div>
        </div>

        <div class="row">
          <div class="col-md-6"><strong >Shipping Plan:</strong></div>
          <div class="col-md-6"><span class="floatLeft">{{$shippingPlans->name}} - {{$shippingPlans->price}}</span></div>
        </div>

      </div>

      <div class="col-md-4"></div>
    
    </div>

    <div class="row vert-offset-top-2 vert-offset-bottom-2">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        
        <form action="/checkoutFinal" method="POST">
          <input type="hidden" name="orderId" value="{{$orderId}}">
          {{ csrf_field() }}
          <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{$stripeKey}}"
            data-name="{{$thisOrder->productName}}"
            data-description="{{$thisOrder->productName}}"
            data-amount="{{ $totalPrice }}"
            data-email="{{ $userEmail }}"
            data-locale="auto">
          </script>
        </form>

      </div>
      
      </div>
      <div class="col-md-4"></div>
    </div>  

  </div><!-- container end-->

</body>

</html>