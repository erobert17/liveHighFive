<!DOCTYPE html>
<html class="full" lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Your Properties Value</title>
    <link rel="shortcut icon" href="http://growyourleads.com/favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('css/the-big-picture.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-3-vert-offset-shim.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/font-awesome.min.css') }}">
    
    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/main.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- CUSTOM !!!! -->
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
    <!-- CUSTOM !!!! -->
</head>

<body>
  
    <!-- Page Content -->
    <div class="container">
        <div class="row vert-offset-bottom-1 vert-offset-top-2">
            <div class="col-md-12 col-sm-12">
                <h1 class="text-center landingPage">{!! $lp->title !!}</h1>
                <p class="secondary text-center vert-offset-bottom-1 landingPageSecondary">{!! $lp->secondaryTitle !!}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p class="secondaryText text-center">Search your address below and select a valid result from the drop down</p>
            </div>
        </div>
            
            <div class="row">
                <form id="mainForm" action="/submitAddress/" method="GET">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="code" value="{{ $code }}">
                <input type="hidden" name="userId" value="{{ $userId }}">
                <div class="col-md-1"></div>
                <div class="col-md-9">
                    
                    <input name="address" id="pac-input" class="bigInput" placeholder="123 Westminster St, Ann Arbor, MI">
                    <label class="customError">You must enter a valid address!</label>
                    
                </div>
                <div class="col-md-1 col-sm-12 text-center"><button type="button" onClick="submit()" class="btn btn-primary bigButton">Next</button></div>
                </form>
                
                <div class="col-md-1"></div>
            </div>
        
         <script>
         $(document).ready(function(){
          
          var returnError = "<?php if(isset($returnError) ){ echo $returnError; } ?>";
          if(returnError.length > 1){
            $('.customError').css('display','inline');
            $('.customError').text(returnError);
          }
          });
        
          function submit(){
                  var thisVal = $('#pac-input').val();
                  var error = "You must search for a address and select a valid result from the drop down.";
                  var readyToRun = 1;
                  if(thisVal.length == 0){
                      readyToRun = 0;
                      $('.customError').css('display','inline');
                      $('.customError').text(error);
                  }
                  if(thisVal.indexOf(' ') < 1){
                    readyToRun = 0;
                    $('.customError').css('display','inline');
                    $('.customError').text(error);
                  }

                  if(readyToRun == 1){
                      $('#mainForm').submit();
                  }
                  
          }
        </script>

        <div class="row iconsRow vert-offset-top-5">
            
            <div class="col-md-4 col-sm-4">
                <i class="fa fa-home activeIcon" aria-hidden="true"></i>
                <p>Search for your home</p>
            </div>
            <div class="col-md-4 col-sm-4">
                <i class="fa fa-check" aria-hidden="true"></i>
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

    

    <div id='map' style="display:none;"></div>
    

    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var options = {
          componentRestrictions: {country: "us"}
         };

        var autocomplete = new google.maps.places.Autocomplete(input, options);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            //window.alert("No details available for input: '" + place.name + "');
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKdZchxVGop6CNDDy-VvwNAw4gJIJAnqA&libraries=places&callback=initMap"
        async defer></script>

</body>

</html>