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
    <title>Open House Scheduler</title>

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
       <div class="row vert-offset-bottom-1">
            <div class="col-md-12 col-sm-12">
                <h1 class="text-center landingPage">What's Your Home's Property Value?</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h1 class="text-center" style="font-size: 23px;">{{$address}}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 vert-offset-bottom-6">
                <h3 class="text-center fontWhite vert-offset-bottom-2 proxFont">Your home's estimated <?php echo date("Y"); ?> value</h3>
                <div class="whiteLine proxFont">
                    <div class="leftLow whiteBall">
                        <span class="headerLabel">Low</span>
                        <span class="text"></span>
                    </div>
                    <div class="middlePrice whiteBall">
                        <span class="headerLabel">Average</span>
                        <span class="text"></span>
                    </div>
                    <div class="rightHigh whiteBall">
                        <span class="headerLabel">High</span>
                        <span class="text"></span>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function(){
            var low = accounting.formatMoney(<?php echo $low ?>, "$", 0);
            var middle = accounting.formatMoney(<?php echo $middle ?>, "$", 0);
            var high = accounting.formatMoney(<?php echo $high ?>, "$", 0);
            $('.leftLow span.text').text(low);
            $('.middlePrice span.text').text(middle);
            $('.rightHigh span.text').text(high);
        });
        </script>
        
            <div class="row vert-offset-top-2">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      @if ($userProfile->avatar_status == 1)
                        <img src="{{ $userProfile->avatar }}" class="khula img-responsive center-block" >
                      @endif
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                        <p class="text-center font20 fontWhite proxFont">{{ $user->name }}</p>
                        <p class="text-center font20 fontWhite proxFont">{{ $user->company }}</p>
                        <p class="text-center font20 fontWhite proxFont">{{ $user->phone }}</p>
                    </div>
                  </div>
                  
                </div>
                <div class="col-md-3"></div>
                
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

            </div>
        

        <div class="row iconsRow vert-offset-top-3 vert-offset-bottom-4">
            
            <div class="col-md-4">
                <i class="fa fa-home" aria-hidden="true"></i>
                <p>Search for your home</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-check" aria-hidden="true"></i>
                <p>Verify Address</p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-line-chart activeIcon" aria-hidden="true"></i>
                <p>Review your home's value</p>
            </div>
            
        </div>
        
        <!-- /.row -->
    </div>
    <!-- /.container -->

    


</body>

</html>