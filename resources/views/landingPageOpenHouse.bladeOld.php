<!DOCTYPE html>
<html class="tinted-image" lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Open House {{$thisProperty[0]->address}}</title>
    
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

    <!-- thumbnail scroll CSS -->
  <style>
    .content{
      overflow: auto;
      position: relative;
      padding: 10px;
      background-color: #333;
      margin: 20px;
      width: 50%;
      height: auto;
      float: left;
    }
    .content li{
      margin: 4px;
      overflow: hidden;
    }
    .content li a{
      display: inline-block;
      border: 7px solid rgba(255,255,255,.1);
    }
    .content.light, .content.light .mTSButton{ background-color: #c2beb2; }
    .content.light li a{ border: 7px solid rgba(255,255,255,.4); }
    #content-1, #content-2{
      width: auto;
      height: 600px;
    }
    #content-1 ul li:first-child{ margin-top: 20px; }
    #content-1 ul li:last-child{ margin-bottom: 20px; }
    #content-2{ padding: 55px 10px; }
    #content-3 .mTSButton{ background-color: #333; }
    #content-5{ background-color: #444; }
    #content-6{ background-color: transparent; }
    #content-6 .mTSButton{
      background-color: rgba(0,0,0,.7);
      -moz-border-radius: 48px; -webkit-border-radius: 48px; border-radius: 48px;
    }
    #content-6 .mTSButtonLeft{ left: 5px; }
    #content-6 .mTSButtonRight{ right: 5px; }
  </style>

  <style type="text/css">
  @media(max-width:1100px){

      .houseBackground{
        background:url('{{ URL::to('/').$thisProperty[0]->path}}')  ;
        min-width:100%;
        min-height:650px;
        background-size: cover;
      }

  }

  @media(min-width:1101px){

      .houseBackground{
        background:url('{{ URL::to('/').$thisProperty[0]->path}}')  ;
        min-width:100%;
        min-height:900px;
        background-size: cover;
      }

  }

  </style>
  <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}">
  <script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>


<body>

    <!-- Page Content -->
    <div class="container houseBackground">
      <div class="row vert-offset-top-3">
        <div class="col-md-1"></div>
        <div class="col-md-3 col-sm-12">
          <h2 class="allCaps khula fontWhite">
          @if ($userProfile->avatar_status == 1)
            <img src="{{ $userProfile->avatar }}" class="khula img-responsive center-block" style="object-fit: cover; max-width:200px;float: left;">
          @else
            <h5 style="font-weight:700;color:#{{$thisLandingPageRow[0]->titleColor}} !important; ">{{$user->company}}</h5>
          @endif
          
        </h2>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-1"></div>
      </div>

      <div class="row vert-offset-top-3">
        <div class="col-md-1"></div>
        <div class="col-md-3 col-sm-12">
          <div class="propertyLocationSearchBox allCaps khula">
            <h5 class="font22" >{{$thisProperty[0]->address}}</h5>
            <h5 class="font27 fontBlack bold" >${{$thisProperty[0]->price}}</h5>
            <?php $allBullets = json_decode($thisProperty[0]->topBullets); ?>
            <ul style="padding: 0; list-style-type: none;">
              @if($thisProperty[0]->topBullets != null)
                @foreach($allBullets as $bullet)
                  <li class="font22 allCaps khula">{{$bullet}}</li>
                @endforeach
              @endif
            </ul>
          </div>
          <a href="#">
            <div class="vert-offset-top-1 tealScheduleButton allCaps khula propertyLocationSearchBox">Schedule A Showing</div>
          </a>
        </div>
        <div class="col-md-7"></div>
        <div class="col-md-1"></div>
      </div>
    </div>
    
    <div class="container"">

      <div class="row">
        <div class="col-md-12">
          <div id="demo">
          <section id="examples" style="max-width: 90%;margin-right: auto !important;margin-left: auto !important;">
          <div id="content-4" class="lp3PropPrevContain">
            <ul>
          @for($i=0; $i < count($thisProperty); $i++)
            @if($thisProperty[$i]->imageName !== null)
              @if($i == 0)
                <li><a href="{{URL::to('/') .$thisProperty[$i]->imageName}}" data-lightbox="propertyImages">
                  <img class="first lp3PropPrevImg" src="{{URL::to('/') .$thisProperty[$i]->imageName}}">
                </a></li>
              @else if($i == count($thisProperty))
                <li><a href="{{URL::to('/') .$thisProperty[$i]->imageName}}" data-lightbox="propertyImages">
                  <img class="last lp3PropPrevImg" src="{{URL::to('/') .$thisProperty[$i]->imageName}}">
                </a></li>
              @endif
            @endif
          @endfor
            </ul>
          </div>
        </section></div>
        </div>
      </div>

      <div class="row vert-offset-top-3 vert-offset-bottom-2">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="row">
          
            <!--  isset($authorAvatar[0]->avatar) -->
            @if(isset($author[0]->userAvatar))
              <div class="col-md-3 col-sm-3"></div>
              <div class="col-md-3 col-sm-3">
                <img src="{{URL::to('/') . $author[0]->userAvatar }}" class="largeUserAvatar">
              </div>
              <div class="col-md-4 col-sm-4 onSmallCenterText">
                <h4>{{$author[0]->company}}</h4>
                <h4>{{$author[0]->phone}}</h4>
                <h4>{{$author[0]->email}}</h4>
              </div>
              <div class="col-md-2 col-sm-2"></div>
            @elseif( isset($authorAvatar[0]->avatar) )
              <div class="col-md-3 col-sm-3"></div>
              <div class="col-md-3 col-sm-3">
                <img src="{{URL::to('/') .$authorAvatar[0]->avatar }}" class="largeUserAvatar">
              </div>
              <div class="col-md-4 col-sm-4 onSmallCenterText">
                <h4>{{$author[0]->company}}</h4>
                <h4>{{$author[0]->phone}}</h4>
                <h4>{{$author[0]->email}}</h4>
              </div>
              <div class="col-md-2 col-sm-2"></div>

            @else
              <div class="col-md-4 col-sm-4"></div>
              <div class="col-md-4 col-sm-4 onSmallCenterText">
                
                <h4>{{$author[0]->company}}</h4>
                <h4>{{$author[0]->phone}}</h4>
                <h4>{{$author[0]->email}}</h4>
              </div>
              <div class="col-md-4"></div>
            @endif
            
          </div>
        </div>
        
        <div class="col-md-4"></div>
      </div>

      <!-- 
      <div class="col-md-3 col-lg-3">
          @if(isset($author[0]->company))
            @if(isset($authorAvatar[0]->avatar))
              <img src="{{URL::to('/') . $authorAvatar[0]->avatar }}" class="largeUserAvatar float-left">
            @endif
            <div>
              <h4>{{$author[0]->company}}</h4>
              <h4>{{$author[0]->phone}}</h4>
              <h4>{{$author[0]->email}}</h4>
          </div>
          @endif

        </div>
      -->

    </div>

    <div style="background-color:#f3f3f3;">

      <div class="container">
        <div class="row vert-offset-top-2 vert-offset-bottom-2">

          <div class="col-md-1"></div>
          <div class="col-md-10" style="text-align: center;">{{$thisProperty[0]->propertyDescription}}</div>
          <div class="col-md-1"></div>

        </div>

        <div class="row vert-offset-top-2 vert-offset-bottom-2">
          
          <?php 

          $bulletsInterior = json_decode($thisProperty[0]->bulletsInterior); 
          $bulletsExterior = json_decode($thisProperty[0]->bulletsExterior); 
          $bulletsDimentions = json_decode($thisProperty[0]->bulletsDimentions); 

          ?>
          <div class="col-md-3"></div>

          <div class="col-md-7">

            <div class="row">

              <div class="col-md-4 col-sm-4 text-center">
                <strong class="fontBlack khula font17">Interior Details</strong>
                <ul style="list-style-type: none;padding: 0;">
                @foreach($bulletsInterior as $bullet)
                  <li>{{$bullet}}</li>
                @endforeach
                </ul>
              </div>

              <div class="col-md-4 col-sm-4 text-center">
                <strong class="fontBlack khula font17">Exterior Details</strong>
                <ul style="list-style-type: none;padding: 0;">
                @foreach($bulletsExterior as $bullet)
                  <li>{{$bullet}}</li>
                @endforeach
                </ul>
              </div>

              <div class="col-md-4 col-sm-4 text-center">
                <strong class="fontBlack khula font17">Dimentions Details</strong>
                <ul style="list-style-type: none;padding: 0;">
                @foreach($bulletsDimentions as $bullet)
                  <li>{{$bullet}}</li>
                @endforeach
                </ul>
              </div>

            </div>

          </div>

          <div class="col-md-2"></div>   

        </div>

      </div>

    </div>

    <div class="container">

      <div id="sendTimesMessage" class="row vert-offset-top-3 vert-offset-bottom-3">
        <div class="col-md-2"></div>
        <div class="col-md-8">

          <h2 class="scheduleShowing fontBlack khula allCaps textCenter bold vert-offset-top-2 vert-offset-bottom-2">Schedule Showing</h2>

          <div class="row">
            <div class="col-md-4 text-center">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <p class="smallCapsText">Name <span class="redDot">*</span></p>
              <input name="name" id="name" class="paddedInput col-sm-12">
            </div>
            <div class="col-md-4 text-center">
              <p class="smallCapsText">Your Email Address <span class="redDot">*</span></p>
              <input name="email" id="email" class="paddedInput col-sm-12">
            </div>
            <div class="col-md-4 text-center">
              <p class="smallCapsText">Phone Number</p>
              <input class="paddedInput col-sm-12" id="phone" name="phone">
            </div>
          </div>

          <div class="row vert-offset-top-1">

              <input type="hidden" id="propertyId" name="propertyId" value="{{$propertyId}}">
              <div class="col-md-8 text-center">
                <p class="smallCapsText">Message</p>
                <textarea name="message" id="message" class="paddedInput col-sm-12" style="height:11em;"></textarea>
              </div>

              <div class="col-md-4">

                <div class="row">
                  <div class="col-md-12 text-center">
                  
                    <p class="smallCapsText">Date First Choice</p>
                    <input id="datepicker1" name="firstChoice" class="paddedInput col-sm-12" style="font-size:10px" placeholder="MM/DD/YYYY">
                  
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 text-center">
                    <p class="smallCapsText">Date Second Choice</p>
                    <input id="datepicker2" name="secondChoice" class="paddedInput col-sm-12" style="font-size:10px" placeholder="MM/DD/YYYY">
                  </div>
                </div>


<script>
    (function($){
      $(window).load(function(){
        
        $("#content-1").mThumbnailScroller({
          axis:"y",
          type:"hover-precise"
        });
        
        $("#content-2").mThumbnailScroller({
          axis:"y",
          type:"click-thumb",
          theme:"buttons-out"
        });
        
        $("#content-3").mThumbnailScroller({
          type:"click-50",
          theme:"buttons-in"
        });
        
        $("#content-4").mThumbnailScroller({
          theme:"hover-classic"
        });
        
        $("#content-5").mThumbnailScroller({
          type:"hover-precise"
        });
        
        $("#content-6").mThumbnailScroller({
          type:"click-25",
        });
        
      });
    })(jQuery);
  </script>
                <script type="text/javascript">
                  $(document).ready(function(){

                    $('.propertyLocationSearchBox').click(function(){
                      $('html,body').animate({
                      scrollTop: $(".scheduleShowing").offset().top},
                      'slow');
                    })
                    

                      $('#datepicker2').datetimepicker({
value:'',
lang:'en',

format: 'Y/m/d H:i',
formatTime: 'g:i a',
formatDate: 'Y/m/d',

startDate:  false, // new Date(), '1986/12/08', '-1970/01/05','-1970/01/05', 

step:15,

timepicker:true,
datepicker:true,


onSelectDate:function() {},
onSelectTime:function() {},
onChangeMonth:function() {},
onChangeDateTime:function() {},
onShow:function() {},
onClose:function() {},
onGenerate:function() {},

withoutCopyright:true,

inverseButton:false,
hours12:false,
next: 'xdsoft_next',
prev : 'xdsoft_prev',
dayOfWeekStart:0,
pick12HourFormat: false,  
yearOffset:0,
beforeShowDay: null
});
                      
                      $('#datepicker1').datetimepicker({
value:'',
lang:'en',

format: 'Y/m/d H:i',
formatTime: 'g:i a',
formatDate: 'Y/m/d',
pick12HourFormat: false,  
startDate:  false, // new Date(), '1986/12/08', '-1970/01/05','-1970/01/05', 

step:15,

timepicker:true,
datepicker:true,


onSelectDate:function() {},
onSelectTime:function() {},
onChangeMonth:function() {},
onChangeDateTime:function() {},
onShow:function() {},
onClose:function() {},
onGenerate:function() {},

withoutCopyright:true,

inverseButton:false,
hours12:false,
next: 'xdsoft_next',
prev : 'xdsoft_prev',
dayOfWeekStart:0,

yearOffset:0,
beforeShowDay: null
});

                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });

                      $('#submitInquryTime').click(function(){
                        var name = $('#sendTimesMessage #name').val();
                        var email = $('#sendTimesMessage #email').val();
                        var phone = $('#sendTimesMessage #phone').val();
                        var message = $('#sendTimesMessage #message').val();
                        var datepicker1 = $('#sendTimesMessage #datepicker1').val();
                        var datepicker2 = $('#sendTimesMessage #datepicker2').val();
                        var propertyId = $('#sendTimesMessage #propertyId').val();
                        if(name.length > 1 && email.length > 1){

                          $.ajax({
                            type: 'POST',
                            url: '/saveShowingInquiry',
                            data: {
                            "_token": "{{ csrf_token() }}",
                            "name": name,
                            "email": email,
                            "phone": phone,
                            "message": message,
                            "datepicker1": datepicker1,
                            "datepicker2": datepicker2,
                            "propertyId": propertyId
                            },
                            success:function(data) {
                              alert('Your inquiry has been sent. Thank you for your submission.');
                              $('#sendTimesMessage input').each(function(){
                                $(this).val('');
                              });
                              $('#sendTimesMessage textarea').val('');
                            }
                          }).done(function( msg ) {
                                            
                          });

                        }else{
                          alert("Name and Email are required.")
                        }

                      });

                  });
                </script>

                <div class="row vert-offset-top-1">
                  <div class="col-md-12 text-center">
                    <button type="button" id="submitInquryTime" class="col-md-12 khula allCaps textCenter bold btn" style="color:white; font-size:15px; background: #3db673;">
                    Schedule A Showing</button>
                  </div>
                </div>
            </div>
            
          </div>

        </div>
        <div class="col-md-2"></div>
      </div>

      @if(count($properties) != 0)

        <div id="inquryArea" class="row vert-offset-top-3 vert-offset-bottom-3">
            <div class="row">
            
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <h2 class="fontBlack khula allCaps textCenter bold vert-offset-top-2 vert-offset-bottom-2">
                  Recent Properties
                </h2>
                <div class="col-md-2"></div>
              </div>
            
            </div>


            <div class="row vert-offset-top-3 vert-offset-bottom-3">
              <div class="col-md-2"></div>
              <div class="col-md-8" style="margin-left: 1em;margin-right: 1em;">
                
                  <div class="row vert-offset-top-1 vert-offset-top-1">
                    <?php $countImage = 0; ?>
                    @foreach($properties as $prop)
                      <!--@if(isset($recentImages[$countImage]))-->
                        <div class="col-md-4">
                          <a href="/openHouseLink/{{$userId}}/{{$prop->id}}">
                            <img class="col-md-12 vert-offset-bottom-1 center-block img-responsive" style="padding:0px; max-height:250px;" src="{{$recentImages[$countImage]}}" /><br>
                            <div class="col-sm-offset-4 col-md-offset-0">
                              <h5 class="orangeTitle">{{$prop->address}}</h5>
                              <p class="blackTitle">${{$prop->price}}</p>
                              <?php $allBullets = json_decode($thisProperty[0]->topBullets); ?>
                              <div class="row">
                                @if($thisProperty[0]->topBullets != null)
                                    @for($i=0; $i < 3; $i++)
                                      @if(isset($allBullets[$i]))
                                        <div class="col-md-4">
                                          <span style="font-size: 12px;color: gray;font-weight: 900;">{{$allBullets[$i]}}</span>
                                        </div>
                                      @endif
                                    @endfor
                                @endif
                              </div>

                              <p class="khula"><?php 
                            
                            echo substr($prop->propertyDescription, 0, 120); ?> . . .</p>

                            </div>

                            
                          </a>
                        </div>
                        <?php $countImage++; ?>
                      
                      <!-- @endif -->
                    @endforeach
                  </div>

              </div>

              <div class="col-md-2"></div>

            </div>

          </div>
        @endif

    </div>
    
  <div class="container-fluid" style="padding:0px !important;">
    @if( isset($thisProperty[0]->geolocation) )
      <div class="row">
          <div class="col-md-12" style="padding:0px !important;">
            <div id="map" style="height:320px !important; width:100% !important;"></div>
          </div>
      </div>
        <?php $locate = json_decode($thisProperty[0]->geolocation); ?>
        <script>
          function initMap() {
            var uluru = {lat: {{$locate[0]}}, lng: {{$locate[1]}}};
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 17,
              center: uluru
            });
            var marker = new google.maps.Marker({
              position: uluru,
              map: map
            });
          }
        </script>
        <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKdZchxVGop6CNDDy-VvwNAw4gJIJAnqA&callback=initMap">
        </script>
    @endif
  </div>

    <div id="mainFooter" class="container-fluid">
      
      <div class="row" style="padding-top: 1em; color: white; font-weight: 900; font-family: 'Khula', sans-serif;">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <span style="float:left;">{{$author[0]->company}}</span>
            <span style="float:right;">{{$author[0]->phone}}</span>
            <span style="float:right; padding-right: 1em;">{{$author[0]->email}}</span>
          </div>
          <div class="col-md-1"></div>
      </div>

    </div>
    <!-- /.container -->

<!--  small confirmation modal for inquiory form -->
<div id="smallConfirmModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      Thank you for your submission.
    </div>
  </div>
</div>

</body>

</html>