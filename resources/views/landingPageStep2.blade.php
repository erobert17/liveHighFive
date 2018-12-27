<!DOCTYPE html>
<html class="full" lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://growyourleads.com/favicon.ico">
    <title>How much is your home worth?</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('css/the-big-picture.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-3-vert-offset-shim.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/timeline.css') }}">
    <script type="text/javascript" src="{{ asset('js/accounting.min.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
    <style type="text/css">
    @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/backgroundLP1.jpg' ))
      
      .full {
        background: url({{asset('uploads/users/id/'.$userId.'/backgroundLP1.jpg')}}) no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
    @else
      .full {
        background: url({{asset('uploads/placeholderBG.jpg')}}) no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
    @endif

    </style>
</head>

<body>

   
    <!-- Page Content -->
    <div class="container">
       <div class="row vert-offset-bottom-2">
            <div class="col-md-12 col-sm-12">
                <h1 class="text-center landingPage">What's Your Home's Property Value?</h1>
                <p class="secondary text-center vert-offset-bottom-1">We've Found Your Property</p>
            </div>
        </div>


        @if( isset($lastSoldDate) == true)
          <div class="row">
              <div class="col-md-12">
                  <ol>
              
                    <li class="single">
                      <script>
                      $(document).ready(function(){
                          var date = "{{$lastSoldDate}}";
                          var price = accounting.formatMoney({{$lastSoldPrice}});
                          $('#titleLastSale').text('Last Sale');
                          $('#datePrice').text(date+' '+price);
                          $('#describe').text(date+' '+price);

                      });
                      </script>
                       <span id="titleLastSale"></span><br>
                       <span id="datePrice"></span>
                      <span id="describe" class="details">
                        Description of point 2
                      </span>
                    </li>
                    
                  </ol> 
              </div>
          </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <p class="secondaryText text-center">Enter your contact information and we'll run the calculation.</p>
            </div>
        </div>
        
            <div class="row">
                
                <div class="col-md-6">
                  <div id="map"></div>
                </div>
                  
                  <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <form id="mainForm" action="/submitContactInfo" method="POST">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="code" value="{{ $code }}">
                              <input type="hidden" name="userId" value="{{ $userId }}">
                              <input type="hidden" name="address" value="{{ $address }}">
                            <input id="userName" name="userName" class="bigInput vert-offset-top-1" placeholder="Your Name"><br>
                            <label class="userName customError">You must enter a valid name</label>

                            <input id="email" name="email" class="bigInput vert-offset-top-1" placeholder="Valid Email"><br>
                            <label class="email customError">You must enter a valid email</label>

                            <input id="cell" name="cell" class="bigInput vert-offset-top-1" placeholder="Cell Number"><br>
                            <label class="cell customError">You must enter a valid cell number</label>
                        </div>
                    </div>
                    </form>
                    <div class="row">
                        
                        <div class="col-md-12 col-xs-12 vert-offset-top-1 text-align">
                            <button type="button" onClick="submit()" class="btn btn-primary bigButton">Next</button>
                        </div>
                        
                    </div>

                  </div>
                  
                

        <script>
        
        function submit(){
                var userNameVal = $('#userName').val();
                var emailVal = $('#email').val();
                var cellVal = $('#cell').val();

                
                if(userNameVal.length == 0){
                    $('.userName').css('display','inline');
                } 
                if(emailVal.length == 0){
                    $('.email').css('display','inline');
                }
                if(cellVal.length == 0){
                    $('.cell').css('display','inline');
                }
                if(userNameVal.length > 0 && emailVal.length > 0 && emailVal.length > 0){
                    $('#mainForm').submit();
                }
                
        }
        </script>
                <div class="col-md-1"></div>

            </div>
        

        <div class="row iconsRow vert-offset-top-5 vert-offset-bottom-4">
            
            <div class="col-md-4 col-sm-4">
                <i class="fa fa-home" aria-hidden="true"></i>
                <p>Search for your home</p>
            </div>
            <div class="col-md-4 col-sm-4">
                <i class="fa fa-check activeIcon" aria-hidden="true"></i>
                <p>Verify Address</p>
            </div>
            <div class="col-md-4 col-sm-4">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
                <p>Review your home's value</p>
            </div>
            
        </div>
        
        <!-- /.row -->
    </div>
    <!-- /.container -->

    

    
    
    
    <script>
        var geocoder;
        var map;
        function initMap() {
          geocoder = new google.maps.Geocoder();
          var latlng = new google.maps.LatLng(-34.397, 150.644);
          var mapOptions = {
            zoom: 15,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.HYBRID
          }
          map = new google.maps.Map(document.getElementById('map'), mapOptions);
          codeAddress('<?php echo $address; ?>');
        }

        function codeAddress(inputAddress) {
          var address = inputAddress;
          geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == 'OK') {
              map.setCenter(results[0].geometry.location);
              var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
          });
        }

  
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKdZchxVGop6CNDDy-VvwNAw4gJIJAnqA&libraries=places&callback=initMap"
        async defer></script>

    <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyBKdZchxVGop6CNDDy-VvwNAw4gJIJAnqA">
    </script>-->


</body>

</html>