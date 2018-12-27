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

    <title>Your Properties Value</title>
    
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('css/the-big-picture.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-3-vert-offset-shim.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/font-awesome.min.css') }}"
    ><link rel="stylesheet" type="text/css" href="{{asset('/css/bootstrap-slider.min.css') }}"
    >
    <script type="text/javascript" src="{{asset('js/bootstrap-slider.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{asset('js/accounting.js')}}"></script>
    

    <link rel="stylesheet" type="text/css" href="{{asset('/css/main.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- CUSTOM !!!! -->
    <style type="text/css">
    @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/background2.jpg' ))
      
      .full {
        background: url({{asset('uploads/users/id/'.$userId.'/placeholderBG2.jpg')}}) no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        box-shadow: inset 0 0 0 1000px rgba(39, 62, 84, 0.6);
      }
    @else
    /*
      .full {
        background: url({{asset('uploads/placeholderBG2.jpg')}}) no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        box-shadow: inset 0 0 0 1000px rgba(39, 62, 84, 0.6);
      }*/

      .tinted-image {
        width: 100%;
        height: auto;
        
        background: 
          /* top, transparent red */ 
          linear-gradient(
            rgba(39, 62, 84, 0.6), 
            rgba(39, 62, 84, 0.6)
          ),
          /* bottom, image */
          url('http://growyourleads.com/uploads/placeholderBG2.jpg');
          background-position:0px -180px;
      }


    @endif


    </style>
    <!-- CUSTOM !!!! -->
</head>

<body>

    <!-- Page Content -->
    <div class="container">
        <div class="row vert-offset-bottom-1 vert-offset-top-2">
            <div class="col-md-1"></div>
            <div class="col-md-7 col-sm-12">
              
                    <h1 class="fatTitle text-left">Title</h1>

                    <p class="smallFontP text-left vert-offset-bottom-1 landingPageSecondary">Secondary Title</p>
              
            </div>
            <div class="col-md-3 col-sm-12 vert-offset-top-3 propertyLocationSearchBox">
              {!!Form::open(array('route' => 'viewHomeValue')) !!}
              {!!Form::token()!!}

              {!!  Form::label('propertyLocation', 'Property Location', array('class' => 'allCaps')) !!}
              {!! Form::text('propertyLocation', null, array('placeholder' => '123 Evergreen St, Springfield, MI ', 'class' => 'btn inputfieldBottomMargin landingPageDropdown')) !!}

              <br>
              
              {!!  Form::label('propertyType', 'Property Type', array('class' => 'allCaps')) !!} <br>
              
              <select name="propertyType" class="btn inputfieldBottomMargin landingPageDropdown dropdown-toggle bootstrap-select">
                <option value="Any" selected="selected">Any</option>
                <option value="House">House</option>
                <option value="Apartment">Apartment</option>
                <option value="Condo">Condo</option>
                <option value="Townhouse">Townhouse</option>
                <option value="Land">Land</option>
              </select>

              <br>

              {!!  Form::label('propertyFeatures', 'Property Features', array('class' => 'allCaps')) !!}<br>
              
              <select name="propertyFeatures" class="btn inputfieldBottomMargin landingPageDropdown dropdown-toggle bootstrap-select">
                <option value="Any" selected="selected">Any</option>
                <option value="Garage/Parking">Garage/Parking</option>
                <option value="Views">Views</option>
                <option value="Pool/Spa">Pool/Spa</option>
                <option value="Gated">Gated</option>
                <option value="Land">Land</option>
                <option value="Heat/Air Conditioning">Heat/Air Conditioning</option>
                <option value="Walk in Closet">Walk in Closet</option>
                <option value="Washer/Dryer">Washer/Dryer</option>
                <option value="Dishwasher">Dishwasher</option>

              </select>


              <div class="row">
                <div class="col-md-6">
                  {!!  Form::label('bathrooms', 'Bathrooms', array('class' => 'allCaps')) !!}<br>
                  <select name="bathrooms" class="btn inputfieldBottomMargin landingPageDropdown dropdown-toggle bootstrap-select">
                    <option value="1+">1+</option>
                    <option value="2+" selected="selected">2+</option>
                    <option value="3+">3+</option>
                    <option value="4+">4+</option>
                    <option value="5+">5+</option>
                  </select>
                </div>

                <div class="col-md-6">
                  {!!  Form::label('bedrooms', 'Bedrooms', array('class' => 'allCaps')) !!}<br>
                  <select name="bedrooms" class="btn inputfieldBottomMargin landingPageDropdown dropdown-toggle bootstrap-select">
                    <option value="1+">1+</option>
                    <option value="2+" selected="selected">2+</option>
                    <option value="3+">3+</option>
                    <option value="4+">4+</option>
                    <option value="5+">5+</option>
                  </select>
                </div>
              </div>

              {!!  Form::label('price', 'Price($)', array('class' => 'allCaps')) !!}<br>
              <span id="ex6SliderVal" style="position: relative;left: 4em;">$100,000 - $1,000,000</span>
              <input id="priceSlider" style="width:100% !important;" type="text" class="span2 slider inputfieldBottomMargin" data-slider-tooltip="hide" value="" data-slider-min="100000" data-slider-max="1000000" data-slider-step="50000" data-slider-value="[100000, 1000000]"/>

              <style type="text/css">
                
                #ex6SliderVal .slider-selection{
                  background-color: #00d5c1;
                  background: rgb(0, 213, 193);
                }
              </style>

              {!!  Form::label('name', 'Name', array('class' => 'allCaps')) !!}
              {!! Form::text('name', null, array('placeholder' => 'Name', 'class' => 'btn landingPageDropdown inputfieldBottomMargin')) !!}
              

              {!!  Form::label('email', 'Email', array('class' => 'allCaps')) !!}
              {!! Form::text('Email', null, array('placeholder' => 'Email', 'class' => 'btn landingPageDropdown inputfieldBottomMargin')) !!}
              

              {!!  Form::label('phone', 'Phone', array('class' => 'allCaps')) !!}
              {!! Form::text('Phone', null, array('placeholder' => 'Phone', 'class' => 'btn landingPageDropdown inputfieldBottomMargin')) !!}
              

              <script type="text/javascript">
                //var slider = new Slider('#priceSlider', {});
                
                /*
                $('#priceSlider').change(function(){
                  var priceArray = $(this).attr('value');
                  console.log(priceArray);
                  alert(priceArray);
                });*/
                /*
                var r = $('#priceSlider').slider().on('slide', function(){
                  var t = $("#priceSlider").val();
                  alert(t);  
              });*/


              $("#priceSlider").slider();
              $("#priceSlider").on("slide", function(slideEvt) {

                $("#ex6SliderVal").text(slideEvt.value);
              });

              // Without JQuery
              var slider = new Slider("#priceSlider");
              slider.on("slide", function(sliderValue) {
                
                //console.log(sliderValue[0]);
                //var display = accounting.formatMoney(sliderValue[0])+ " - "+accounting.formatMoney(sliderValue[1]);
                
                display1 = accounting.formatMoney(sliderValue[0]);
                display1 = display1.substring(0, display1.indexOf('.'));
                display2 = accounting.formatMoney(sliderValue[1]);
                display2 = display2.substring(0, display2.indexOf('.'));

                var display = display1 + " - " + display2;
                console.log('display '+display);
                document.getElementById("ex6SliderVal").textContent = display;
              });

              </script>

              {!! Form::close() !!}

              <button class="btn" style="width:100%; border-radius: 0px; background:#f4bc65; border-bottom-width: 3px; border-bottom-color: #d89222;">Submit</button>

            </div>

            <div class="col-md-1"></div>
        </div>
            
            <!--<div class="row">
                <form id="mainForm" action="/submitAddress/" method="GET">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="code" value="{{ $code }}">
                <input type="hidden" name="userId" value="{{ $userId }}">
                <div class="col-md-1"></div>
                <div class="col-md-9">
                    
                    <input name="address" id="pac-input" class="bigInput" placeholder="123 Westminster St, Ann Arbor, MI">
                    <label class="customError">You must enter a valid address!</label>
                    
                </div>
                <div class="col-md-1"><button type="button" onClick="submit()" class="btn btn-primary bigButton">Next</button></div>
                </form>
                
                <div class="col-md-1"></div>
            </div>-->
        
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

        <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
        
        <!-- /.row -->
    </div>
    <!-- /.container -->

</body>

</html>