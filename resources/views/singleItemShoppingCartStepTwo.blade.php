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
    <title>{{$product[0]->name}} Shopping Cart Checkout</title>
    
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
          <i class="fas fa-shopping-cart" style="color:lightgray;font-size: 31px; float:right"></i><div class='shoppingCartQty'>{{$qty}}</div>
        </div>
      </div>

  <form id="singleItemCheckoutStepTwo" action="/singleItemCheckoutStepThree" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="qty" value="{{$qty}}">
    <input type="hidden" name="userId" value="{{$userId}}">
    <input  type="hidden" name="productId"  value="{{$product[0]->id}}">
    
    <div class="row vert-offset-top-4">
       
      <div class="col-md-1"></div>
      
      <div class="col-md-4">
        <h2 <?php if($thisLandingPageRow[0]->titleShadow == 1){ echo "class='titleTextShadow'"; } ?> style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;font-family: 'Proxima Nova',sans-serif !important;font-weight: 600;">Personal Info</h2>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="firstName" class="titleTextColor">First Name:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text" name="firstName" class="form-control input-lg" value="" placeholder="John">
            </div>
          </div>  

          <div class="col-md-6">
            <div class="form-group">
              <label for="lastName" class="titleTextColor">Last Name:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text" name="lastName" class="form-control input-lg" value="" placeholder="Doe">
            </div>
          </div> 
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="phone1" class="titleTextColor">Phone Number:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text" name="phone1" class="form-control input-lg" value="" placeholder="1-222-444-5555">
            </div>
          </div>  

          <div class="col-md-6">
            <div class="form-group">
              <label for="phone2" class="titleTextColor">Secondary Phone:</label>
              <input type="text"  name="phone2" class="form-control input-lg" value="" placeholder="">
            </div>
          </div> 
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="email1" class="titleTextColor">Email:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text" name="email1" class="form-control input-lg" value="" placeholder="youremail@gmail.com">
            </div>
          </div>  

          <div class="col-md-6">
            <div class="form-group">
              <label for="email2" class="titleTextColor">Confirm email:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text"  name="email2" class="form-control input-lg" value="" placeholder="">
            </div>
          </div> 
        </div>

      </div>

      <div class="col-md-2"></div>

      <div class="col-md-4">
        <h2 <?php if($thisLandingPageRow[0]->titleShadow == 1){ echo "class='titleTextShadow'"; } ?> style="color:#{{$thisLandingPageRow[0]->titleColor}} !important;font-family: 'Proxima Nova',sans-serif !important;font-weight: 600;">Shipping Info</h2>
        <div class="row">
          
          <div class="col-md-12">
            <div class="form-group">
              <label for="street" class="titleTextColor">Street Address:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text" name="street" class="form-control input-lg" value="" placeholder="123 Evergreen Terras">
            </div>
          </div>  

        </div>

        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label for="city" class="titleTextColor">City:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text" name="city" class="form-control input-lg" value="" placeholder="Springfield">
            </div>
          </div>  
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="country" class="titleTextColor">Country:
                <select name="country" id="country" class=" form-control input-lg" name="country"></option><option value="AF">Afghanistan</option><option value="AX">Åland Islands</option><option value="DZ">Algeria</option><option value="AD">Andorra</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="BD">Bangladesh</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BR">Brazil</option><option value="BG">Bulgaria</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CL">Chile</option><option value="CN">China</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="FK">Falkland Islands</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="DE">Germany</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GG">Guernsey</option><option value="HM">Heard Island and McDonald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong SAR China</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="KE">Kenya</option><option value="KW">Kuwait</option><option value="LV">Latvia</option><option value="LR">Liberia</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macau SAR China</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="MT">Malta</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="MX">Mexico</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MM">Myanmar (Burma)</option><option value="NA">Namibia</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NZ">New Zealand</option><option value="NG">Nigeria</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="NO">Norway</option><option value="PK">Pakistan</option><option value="PS">Palestinian Territories</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="QA">Qatar</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="BL">Saint Barthélemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="SA">Saudi Arabia</option><option value="SC">Seychelles</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="ZA">South Africa</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="TW">Taiwan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB" ">United Kingdom</option><option value="US" selected="selected">United States</option><option value="UY">Uruguay</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option>
                  </select>
              </label>
            </div>
          </div>  

        </div>

        <div class="row">
          
          <div class="col-md-5">
            <div class="form-group">
              <label for="state" class="titleTextColor">State/Province:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <select name="state" title="State/Province" defaultvalue="" class="form-control input-lg">
                            <option value="">Please select state</option>
                        <option value="Alabama">Alabama</option>
                        <option value="Alaska">Alaska</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Arizona">Arizona</option>
                        <option value="Arkansas">Arkansas</option>
                        <option value="California">California</option>
                        <option value="Colorado">Colorado</option>
                        <option value="Connecticut">Connecticut</option>
                        <option value="Delaware">Delaware</option>
                        <option value="District of Columbia">District of Columbia</option>
                        <option value="Federated States Of Micronesia">Federated States Of Micronesia</option>
                        <option value="Florida">Florida</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Guam">Guam</option>
                        <option value="Hawaii">Hawaii</option>
                        <option value="Idaho">Idaho</option>
                        <option value="Illinois">Illinois</option>
                        <option value="Indiana">Indiana</option>
                        <option value="Iowa">Iowa</option>
                        <option value="Kansas">Kansas</option>
                        <option value="Kentucky">Kentucky</option>
                        <option value="Louisiana">Louisiana</option>
                        <option value="Maine">Maine</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Maryland">Maryland</option>
                        <option value="Massachusetts">Massachusetts</option>
                        <option value="Michigan">Michigan</option>
                        <option value="Minnesota">Minnesota</option>
                        <option value="Mississippi">Mississippi</option>
                        <option value="Missouri">Missouri</option>
                        <option value="Montana">Montana</option>
                        <option value="Nebraska">Nebraska</option>
                        <option value="Nevada">Nevada</option>
                        <option value="New Hampshire">New Hampshire</option>
                        <option value="New Jersey">New Jersey</option>
                        <option value="New Mexico">New Mexico</option>
                        <option value="New York">New York</option>
                        <option value="North Carolina">North Carolina</option>
                        <option value="North Dakota">North Dakota</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Ohio">Ohio</option>
                        <option value="Oklahoma">Oklahoma</option>
                        <option value="Oregon">Oregon</option>
                        <option value="Palau">Palau</option>
                        <option value="Pennsylvania">Pennsylvania</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Rhode Island">Rhode Island</option>
                        <option value="South Carolina">South Carolina</option>
                        <option value="South Dakota">South Dakota</option>
                        <option value="Tennessee">Tennessee</option>
                        <option value="Texas">Texas</option>
                        <option value="Utah">Utah</option>
                        <option value="Vermont">Vermont</option>
                        <option value="Virgin Islands">Virgin Islands</option>
                        <option value="Virginia">Virginia</option>
                        <option value="Washington">Washington</option>
                        <option value="West Virginia">West Virginia</option>
                        <option value="Wisconsin">Wisconsin</option>
                        <option value="Wyoming">Wyoming</option>
</select>
            </div>
          </div> 

          <div class="col-md-1">
            <label for="customState" class="titleTextColor" style="font-size:22px;">Or</label>
          </div>

          <div class="col-md-5">
            <div class="form-group">
              <label for="customState" class="titleTextColor">Custom State/Province:</label>
              <input type="text" name="state2" class="form-control input-lg" value="" placeholder="Alberta">
            </div>
          </div>   

        </div>

        <div class="row">
          
          <div class="col-md-4">
            <div class="form-group">
              <label for="zip" class="titleTextColor">Zip-code/Postal code:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <input type="text" name="zip" class="form-control input-lg" value="" placeholder="55555">
            </div>
          </div>  
          
          <div class="col-md-8">
            <div class="form-group">
              <label for="email1" class="titleTextColor">Shipping Plan:<span style="color:red;font-size: 20px;position: absolute;">*</span></label>
              <select name="shippingPlan" id="shippingPlan" class=" form-control input-lg">
                <?php $first = false; ?>
                @foreach($shippingPlans as $plan)
                  <option value="{{$plan->id}}" id="{{$plan->id}}"<?php if($first == false){echo 'selected="selected"'; $first = true;} ?> >{{$plan->name}} - {{$plan->price}}</option>
                @endforeach
              </select>

            </div>
          </div>

        </div>



      </div>

    </div>
  </form>

    <div class="row">
          
          <div class="col-md-7">
          </div>  
          <div class="col-md-5">
            <button type="button" id="proceedToPayment" class="btn btn-lg" style="background:#{{$thisLandingPageRow[0]->buttonColor}}; color:white; float:left; font-weight: 700;font-size: 25px;">Proceed To Payment</button>
          </div>

        </div>

  </div><!-- container end-->

</body>

</html>