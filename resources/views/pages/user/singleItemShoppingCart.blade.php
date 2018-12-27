<!DOCTYPE html>
<html class="tinted-image" lang="en">
<!-- Make sure the <html> tag is set to the .full CSS class. Change the background image in the full.css file. -->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{$product[0]->name}} Shopping Cart</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-3-vert-offset-shim.css')}}">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

     <!-- lightbox -->
    <link rel="stylesheet" type="text/css" href="http://growyourleads.com/css/lightbox.css">
    <script src="http://growyourleads.com/js/lightbox.js"></script>

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

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding-bottom: 34px;">
        <h5 class="modal-title" id="exampleModalLongTitle" style="border-radius:30px;">Get the Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Give us you're email and you'll recieve our coupon.</p>
        <span id="emailError" style="color:red;"></span><br>
        <label>Email: <input type="text" name="email" id="emailInput" class="longInput"></label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <button type="button" class="btn btn-primary" id="submit">Submit</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#submit').click(function(){

      var userId = '<?php echo $userId; ?>';
      var email = $('#emailInput').val();
      
    });

  });
</script>

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
    @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/'.$background ) && isset($thisLandingPageRow[0]->backgroundColor) !== true)
      
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

      @if (file_exists( public_path().'/uploads/users/id/'.$userId.'/'.$background  ) && isset($thisLandingPageRow[0]->backgroundColor) !== true)
      
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

  </style>


  <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.datetimepicker.css')}}">
  <script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>

    <!-- Page Content -->
    <div class="container-fluid background" style="height: 100%;">

      <div class="row vert-offset-top-1 vert-offset-bottom-1">
        <div class="col-md-4">
          
          @if ($userProfile[0]->avatar_status == 1)
            <img src="{{ $userProfile[0]->avatar }}" class="khula img-responsive center-block" style="object-fit: cover; max-width:200px;float: left;">
          @else
            <h5 style="font-weight:700;color:#{{$thisLandingPageRow[0]->titleColor}} !important; ">{{$user[0]->company}}</h5>
          @endif
          
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <a href="#" style="float:right;">
            <i class="fas fa-shopping-cart" style="color:white;font-size: 31px;"></i>
          </a>
        </div>
      </div>

      <div class="row vert-offset-top-12">
        <div class="col-md-2"></div>
        <div class="col-md-4" style="">
          @if($thisLandingPageRow[0]->titleShadow == 1)
            <h1 class="titleTextShadow" style="font-weight: 700; font-size:66px; color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->title}}</h1>
          @else
            <h1 style="font-weight: 700; font-size:66px; color:#{{$thisLandingPageRow[0]->titleColor}} !important;">{{$thisLandingPageRow[0]->title}}</h1>
          @endif
          
          <br>
          <h4 style="color:#{{$thisLandingPageRow[0]->titleColor}}">{{$thisLandingPageRow[0]->secondaryTitle}}</h4>
              <form action="/singleItemCheckoutStepTwo" method="POST">
                <input type="hidden" name="userId" value="{{$userId}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                

                <label style="color:#{{$thisLandingPageRow[0]->titleColor}};float:left; font-weight:700; font-size:18px;padding-top: 0.5em;">QTY:&nbsp;</label>
                <div class="input-group vert-offset-bottom-1" style="width:10px;">
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                          <span class="glyphicon glyphicon-minus"></span>
                      </button>
                  </span>
                  
                  <input type="hidden" id="qty" name="qty" value="1">
                  <div class="form-group">
                    <input type="text" id="quanityInput" name="quant[1]" value="1" min="1" max="10" class="form-control input-number input-lg" style="color:black; font-weight:700; font-size:18px;width: 3.5em;height: 36px;">
                  </div>
                  <span class="input-group-btn">
                      <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                          <span class="glyphicon glyphicon-plus"></span>
                      </button>
                  </span>
              </div>

              <!--
                <label style="color:#{{$thisLandingPageRow[0]->titleColor}};float:left; font-weight:700; font-size:18px;padding-top: 0.5em;">QTY:&nbsp;</label>
                <div class="form-group">
                  <input type="text" name="qty" value="1" class="form-control input-lg" style="color:black; font-weight:700; font-size:18px;width: 3.5em;">
                </div>-->

                <style type="text/css">
                  .center{
                    width: 150px;
                    margin: 40px auto;
                  }
                </style>

                

                <!-- Button trigger modal -->
                @if(isset($thisLandingPageRow[0]->buttonColor))
                  <button type="submit" class="btn btn-primary" style="background:#{{$thisLandingPageRow[0]->buttonColor}}; color:white; float:left; font-weight: 700;font-size: 17px;">Checkout
                  </button>
                @else
                  <button type="submit" class="btn btn-primary" style="background:#262626; color:white;float:left; font-weight: 700;font-size: 17px;">Checkout
                  </button>
                @endif

              </form>
              
              <br><br>
          <h5 style="color:#{{$thisLandingPageRow[0]->disclaimerColor}};">{{$thisLandingPageRow[0]->disclaimer}}</h5>
        </div>


        <div class="col-md-4">
          <?php 
          if(isset($featuredProductImage[0]->imageName)){

            $ch = curl_init('http://growyourleads.com//uploads/users/id/'.$userId.'/productImages/'.$featuredProductImage[0]->imageName);    
                                          
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          }else{
            $code = 100;
          }


          $backgroundExists = '';

          if($code == 200){
            $backgroundExists = true;
            echo '<img style="max-height: 439px;margin-right: auto; margin-left: auto;" id="" class="img-responsive" src="http://growyourleads.com//uploads/users/id/'.$userId.'/productImages/'.$featuredProductImage[0]->imageName.' " />';   
          }else{

            if( count($productImages) > 0 ){

              $productImageOne = (string)$productImages[0]->imageName;

              echo '<img style="max-height: 439px;margin-right: auto; margin-left: auto;" id="" class="img-responsive" src="http://growyourleads.com//uploads/users/id/'.$userId.'/productImages/'.$productImageOne.' " />';   

            }else{
              $backgroundExists = false;
            }

            
          }
          ?>
        </div>
        <div class="col-md-2"></div>
      </div>


  </div><!-- container end-->

  <div class="container vert-offset-top-5 vert-offset-bottom-5">
    <?php $lastImgName = '';$countEverySix = 1; ?>
    
    

      @foreach($productImages as $image)

        @if($lastImgName != $image->imageName)
          
          @if($countEverySix == 1)
            <div class="row ">
          @endif

          <div class="col-md-2" style="text-align: center;">
            
            <a href="http://www.growyourleads.com/uploads/users/id/{{$userId}}/productImages/{{$image->imageName}}" data-lightbox="productImg">

              <img class="lp3PropPrevImgProductImg" src="http://www.growyourleads.com/uploads/users/id/{{$userId}}/productImages/{{$image->imageName}}" />
            
            </a>

          </div>
          <?php $lastImgName = $image->imageName;?>
          
          @if($countEverySix == 6)
            <div/>
            <?php $countEverySix=1; ?>
          @else
            <?php $countEverySix++; ?>
          @endif

        @endif

      @endforeach

      
    
    </div>
  </div>

</body>

<script type="text/javascript">
  //plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/

$('#quanityInput').change(function(){
  var quantVal =$(this).val();
  $('#qty').val(quantVal);
})

$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>

</html>