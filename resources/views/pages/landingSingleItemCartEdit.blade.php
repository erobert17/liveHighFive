@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection
    
<div id="fillWithNoobMessage">


</div>

@section('content')
    
    <script type="text/javascript">
        $(document).ready(function(){

            if({{$userHintState}} === 2){
     
                if({{$user->helpBubbleToggle}} == 1){// always 1 until user turns off all hint bubbles
                    $('#fillWithNoobMessage').html("<div class='noobMessage noShowOnMobile'><p class='text-center'>There's a '<strong>Orders</strong>' link in the left menu, below this landing page's link.</p><p class='text-center'>Click it to see metrics for this landing page. </p><div class='text-center'><button id='closeHint' class='text-center'> Close </button><button id='neverShowHints' class='text-center'> Never Show These Hints </button></div></div>");

                    $(".noobMessage").delay(100).fadeIn();
                    var glow = $(".statsTab a");
                    glow.addClass('noobHintLink');
                    setInterval(function(){
                        glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
                    }, 500);

                }
            }

                    $('#closeHint').click(function(){

                        $(".noobMessage").fadeOut();  
                        $.ajax({
                          type: 'POST',
                          url: '/changeHintState',
                          data: {  "_token": "{{ csrf_token() }}",
                          "hintNumber": '3'},
                          //"email": email,
                          success:function(data) {

                          }
                        }).done(function( msg ) {  
                        $(".noobMessage").fadeOut();       
                        });

                        $(".copyLinkInput").removeClass('noobBackgroundColor');

                    });

                    $('#neverShowHints').click(function(){

                        $(".noobMessage").fadeOut();  

                        $.ajax({
                          type: 'POST',
                          url: '/neverShowHints',
                          data: {  "_token": "{{ csrf_token() }}"},
                          
                          success:function(data) {
                          }
                        }).done(function( msg ) {  
                        $(".noobMessage").fadeOut();       
                        });

                        $(".copyLinkInput").removeClass('noobBackgroundColor');

                    });

        });
    </script>
        <script type="text/javascript" src="{{asset('js/jscolor.js')}}"></script>
        
        <input type="hidden" name="userID" value="{{ $user->id }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            
            <div class="col-sm-10 col-sm-offset-2 col-md-8 col-md-offset-3 col-lg-6 col-lg-offset-3">

                <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="centerBlock">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <strong>Your Unique Landing Page Link: &nbsp;</strong>
                            </div>
                            <div class="col-sm-4 col-md-6">
                                <input id="linkToCopy" style="width:100%" value="{{ URL::to('/').'/link'.$landingPageNumber.'/'.$userLink }}" type="text">&nbsp;
                            </div>
                            <div class="col-sm-4 col-md-2">
                                <button type="button" id="copy" data-clipboard-target="#linkToCopy" class="btn btn-success floatRight">Copy</button>
                                &nbsp;<strong class="copiedLink">Copied!</strong>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
           
                <script type="text/javascript">
                    new Clipboard('#copy');
                    $(document).ready(function(){
                        $('#copy').click(function(){
                                $(".copiedLink").attr( "style", "display: inline !important;" )
                                setTimeout(function() { $(".copiedLink").fadeOut(); }, 5000);
                        });
                    });
                </script>

            </div>
        </div>

        <div class="row" style="text-align: center;">
                <div class="col-sm-8 col-sm-offset-4 col-md-8 col-md-offset-4 col-lg-6 col-lg-offset-3">

                    <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                        <div class="centerBlock">
                            <div class="row">
                                <div class="col-sm-8 col-md-8" style="padding-top: 0.5em;color:#954120;">
                                    <strong>Delete This Landing Page</strong>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <a href="/deleteLandingPage/{{$landingPage[0]->id}}">
                                        <button type="button" class="btn btn-danger text-center">Delete Landing Page</button>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
        </div>

        <div class="row">
            <div class="col-sm-10 col-sm-offset-2 col-md-8 col-md-offset-3 col-lg-6 col-lg-offset-3">

                @if( isset($warningTitle) )

                    <div class="row vert-offset-bottom-1">
                        <div class="col-md-12">
                                <div class="alert alert-warning">
                                <span class="glyphicon glyphicon-record"></span> <strong>Warning</strong>
                                <hr class="message-inner-separator">
                                <p>{!! $warningTitle !!}</p>
                            </div>
                        </div>
                    </div>

                @endif

                <div class="panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="panel-heading">
                        
                        @if($landingPageNumber == 1)
                            Property Valuation Landing Page
                        @elseif($landingPageNumber == 2)
                            Property Search Landing Page
                        @elseif($landingPageNumber == 4)
                            Countdown Landing Page
                        @elseif($landingPageNumber == 5)
                            Coupon Landing Page
                        @elseif($landingPageNumber == 6)
                            Single Item Shopping Cart
                        @endif

                    </div>

                    <div class="panel-body">
                        <form id="saveLandingPage6" action="/saveLandingPage{{$landingPageNumber}}" method="POST">
                            
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-7">
                                <label>Product Name:<br>
                                    <input name="productName" placeholder="Chrome Coffee Blender" class="longInput" value="<?php if(isset($product[0]->name)){echo htmlentities($product[0]->name) ;} ?>">
                                </label>
                            </div>
                            <div class="col-md-5">
                                <label>Price:<br>
                                    $<input type="text" placeholder="59.99" name="productPrice" style="max-width: 85px;" value="<?php if(isset($product[0]->price)){echo htmlentities($product[0]->price) ;} ?>">
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-2">
                            <div class="col-md-12">
                                <div class="row vert-offset-bottom-1">
                                   
                                    <div class="col-md-12">
                                        <label>Shipping Plans:<br></label>
                                        
                                        @if(count($shippingPlans) > 0)
                                          <div class="row margin1px bottomBorder1 bottomBorder1">
                                                <div class="col-xs-5 col-md-5">Shipping Plan</div>
                                                <div class="col-xs-5 col-md-5">Price</div>
                                                <div class="col-xs-2 col-md-2 "></div>
                                          </div>
                                        @endif

                                    </div>
                                    
                                </div>

                                <div class="row margin1px">
                                    <div class="col-md-12 plansMother">
                                      
                                        @if( count($shippingPlans) > 0 )
                                            <?php $oddEven = 0;?>

                                          @foreach($shippingPlans as $plan)
                                            @if($oddEven == 0)
                                              <div id="{{$plan->id}}" class="row planRow">
                                                <?php $oddEven = 1;?>
                                            @else
                                              <div id="{{$plan->id}}" class="row odd planRow">
                                                <?php $oddEven = 0;?>
                                            @endif
                                            
                                                <div class="col-xs-5 col-md-5"> <input class="planName" style="width:100%;margin-top: 9px;" value="{{$plan->name}}"> </div>
                                                <div class="col-xs-5 col-md-5"> $<input class="planPrice" style="max-width: 85px; margin-top: 9px;" value="{{$plan->price}}"> </div>
                                                <div class="col-xs-2 col-md-2"><a href="#" class="deletePlan" style="text-align: left;margin-top: 9px;">Delete Plan</a></div>
                                              
                                              </div>

                                          @endforeach
                                        @endif
                                        </div>
                                    </div>
                            
                                </div>

                                <div class="row margin1px">
                                    <div class="col-md-12">
                                        <button id="addPlan" class="addProperty btn btn-primary" type="button" style="float:left;">Add Plan</button>
                                    </div>
                                </div>

                                <input type="hidden" id="shippingPlansJson" name="shippingPlansJson" value="">

                                <script type="text/javascript">
                                        $(document).ready(function(){

                                            $('#addPlan').click(function(){
                                                var countPlans = $('.planName').length;
                                                countPlans = countPlans+1;
                                                $('.plansMother').append('\
                                                <div class="row planRow">\
                                                    <div class="col-md-5"> <input class="planName" name="planName_'+countPlans+'" style="width:100%;" value=""> </div>\
                                                    <div class="col-md-5"> $<input class="planPrice" name="planPrice_'+countPlans+'" value=""> </div>\
                                                    <div class="col-md-2"><a href="#" class="deletePlan" style="text-align: left;">Delete Plan</a></div>\
                                              </div>');
                                            });

                                            $('.plansMother').on('click', '.deletePlan', function(){
                                                $(this).parents('.planRow').remove();
                                                var thisRowId = $(this).parents('.planRow').attr('id');
                                                
                                                $.ajax({
                                                  type: 'POST',
                                                  url: '/deleteShippingPlan',
                                                  data: {  "_token": "{{ csrf_token() }}",
                                                   'rowId': thisRowId },
                                                  success:function(data) {
                                                    
                                                  }
                                                }).done(function( msg ) {
                                                console.log( "Handler for .change() called." );
                                                });
                                            });

                                        $(document).ready(function(){
                                            $(document).on("change", ".planName", function(){
                                                var thisRowId = $(this).parents('.planRow').attr('id');
                                                if(thisRowId == null){
                                                    $(this).parents('.planRow').attr('id','tempIdChange');
                                                }
                                                var newName= $(this).val();
                                                var newPrice = $(this).parents('.planRow').find('.planPrice').val();
                                                if(newName.length > 0){
                                                    $.ajax({
                                                      type: 'POST',
                                                      url: '/saveShippingPlan',
                                                      data: {  "_token": "{{ csrf_token() }}",
                                                      "newName": newName,
                                                      "newPrice": newPrice,
                                                       'rowId': thisRowId },
                                                      success:function(data) {
                                                        if(thisRowId == null){
                                                            var returnedId = String(data);
                                                            $('#tempIdChange').attr('id',returnedId);
                                                        }    
                                                      }
                                                    }).done(function( msg ) {
                                                    console.log( "Handler for .change() called." );
                                                    });
                                                }
                                            });

                                            $(document).on("change", ".planPrice", function(){
                                                var thisRowId = $(this).parents('.planRow').attr('id');
                                                if(thisRowId == null){
                                                    $(this).parents('.planRow').attr('id','tempIdChange');
                                                }
                                                
                                                var newName = $(this).parents('.planRow').find('.planName').val();
                                                var newPrice = $(this).val();
                                                if(newPrice.length > 0){
                                                    
                                                    $.ajax({
                                                      type: 'POST',
                                                      url: '/saveShippingPlan',
                                                      data: {  "_token": "{{ csrf_token() }}",
                                                      "newName": newName,
                                                      "newPrice": newPrice,
                                                       'rowId': thisRowId },
                                                      success:function(data) {
                                                        if(thisRowId == null){
                                                            var returnedId = String(data);
                                                            $('#tempIdChange').attr('id',returnedId);
                                                        }     
                                                      }
                                                    }).done(function( msg ) {
                                                    console.log( "Handler for .change() called." );
                                                    });

                                                }
                                            });

                                        });



                                    });
                                </script>

                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label><a href="https://stripe.com/docs/keys">Stripe API Key</a>(used for credit card payment processing):<br>
                                    <input name="stripeKey" class="longInput" value="<?php if(isset($user->stripeKey)){ echo $user->stripeKey; } ?>">
                                </label>                                             
                            </div>
                        </div>

                        <hr />

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-8">
                                <label>Title:<br>
                                    <input name="title" class="longInput" value="<?php if(isset($landingPage[0]->title)){echo htmlentities($landingPage[0]->title);} ?>">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>Title Text Color<br>
                                    @if($landingPage[0]->titleColor !== NULL && strlen($landingPage[0]->titleColor) > 2 )
                                        <input id="titleColorSelect" name="titleSelect" class="jscolor 
                                    {value:'{{ $landingPage[0]->titleColor }}'}" value="jscolor {value:'{{ $landingPage[0]->titleColor }}'}" style="width: 5em;">
                                        <input id="titleColor" name="titleColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="{{ $landingPage[0]->titleColor }}" />
                                    @else
                                        <input id="titleColorSelect" name="titleSelect" class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="titleColor" name="titleColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="" />
                                    @endif
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-8">
                                <label>Secondary Title:<br>
                                    <input name="secondaryTitle" class="longInput" value="<?php if(isset($landingPage[0]->secondaryTitle)){echo htmlentities($landingPage[0]->secondaryTitle) ;} ?>">
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label>Title Text Background Shadow<br>
                                    
                                    @if(isset($landingPage[0]) && $landingPage[0]->titleShadow == 1)
                                        <input type="checkbox" style="width: 23px;height: 23px;" name="titleTextShadow" checked="checked" />
                                    @else
                                        <input type="checkbox" style="width: 23px;height: 23px;" name="titleTextShadow" />
                                    @endif
                                </label>
                            </div>
                        </div>
                        
                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-8">
                                <label>Disclaimer*<br>
                                    @if( isset($landingPage[0]) )
                                        <input type="text" name="disclaimer" value="{{ htmlentities($landingPage[0]->disclaimer) }}" id="disclaimer" class="longInput"/>
                                    @else
                                        <input type="text" name="disclaimer" value="" id="disclaimer" class="longInput"/>
                                    @endif
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>Disclaimer Text Color<br>
                                    @if($landingPage[0]->disclaimerColor !== NULL && strlen($landingPage[0]->disclaimerColor) > 2 )
                                        <input id="disclaimerSelect" name="disclaimerSelect" class="jscolor 
                                    {value:'{{ $landingPage[0]->disclaimerColor }}'}" value="jscolor {value:'{{ $landingPage[0]->disclaimerColor }}'}" style="width: 5em;">
                                        <input id="disclaimerColor" name="disclaimerColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="{{ $landingPage[0]->disclaimerColor }}" />
                                    @else
                                        <input id="disclaimerSelect" name="disclaimerSelect" class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="disclaimerColor" name="disclaimerColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="" />
                                    @endif
                                    
                                    
                                </label>
                            </div>
                        </div>

                        
                        <script src="{{asset('js/php-date-formatter.min.js')}}"></script>
                        <script src="{{asset('js/jquery.mousewheel.js')}}"></script>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Select a background color or upload a background img at bottom of page:<br>
                                    @if($landingPage[0]->backgroundColor !== NULL  && strlen($landingPage[0]->backgroundColor) > 2)
                                        <input id="backgroundSelect"" class="jscolor 
                                    {value:'{{ $landingPage[0]->backgroundColor }}'}" value="jscolor {value:'{{ $landingPage[0]->backgroundColor }}'}" style="width: 5em;">
                                        <input id="backgroundColor" name="backgroundColor" class="backgroundColor selectedColor saveColorChange saveColorVal" type="hidden" value="{{$landingPage[0]->backgroundColor }}" />
                                    @else
                                        <input id="disclaimerSelect"  class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="backgroundColor" name="backgroundColor" class="backgroundColor selectedColor saveColorChange saveColorVal" type="hidden" value="" />
                                    @endif

                                    <button type="button" class="btn btn-danger" id="jscolorClear">Clear</button>
                                    
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Color of "Add To Cart" Button<br>
                                    @if($landingPage[0]->buttonColor !== NULL && strlen($landingPage[0]->buttonColor) > 2 )
                                        <input id="buttonColorSelect" name="buttonSelect" class="jscolor 
                                    {value:'{{ $landingPage[0]->buttonColor }}'}" value="jscolor {value:'{{ $landingPage[0]->buttonColor }}'}" style="width: 5em;">
                                        <input id="buttonColor" name="buttonColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="{{ $landingPage[0]->buttonColor }}" />
                                    @else
                                        <input id="buttonColorSelect" name="buttonSelect" class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="buttonColor" name="buttonColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="" />
                                    @endif
                                    
                                </label>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                
                                $('body').on('change', '.jscolor', function() {
                                //$(".jscolor").change(function(){ 
                                    var changedColor = $(this).val();

                                    console.log(changedColor);
                                    $(this).parent('label').find('.selectedColor').val(changedColor);

                                });

                                $('#jscolorClear').click(function(){
                                    $(this).parent('label').find('.jscolor').val('');
                                    $(this).parent('label').find('.selectedColor').val('');
                                });
                            });
                        </script>


                        @if( count($productImages) > 0 )

                            <div class="row vert-offset-bottom-1">
                                <div class="col-xs-1 col-md-2"></div>
                                <div class="col-xs-10 col-md-10">
                                    <label>Existing Product Images:</label>
                                </div>
                            </div>

                                <div class="row" class="leftMargin15OnNotSmall">
                                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                                        <?php $oddEven = 0;?>
                                        <div class="row" style="border-bottom: solid 1px black;">
                                            <div class="col-xs-4 col-md-4"><label>Existing Image</label></div>
                                            <div class="col-xs-4 col-md-4"><strong>Featured Image</strong></div>
                                            <div class="col-xs-4 col-md-4"><strong>Delete</strong></div>
                                        </div>
                                        @foreach($productImages as $image)
                                            @if($oddEven == 1)
                                                <div class="row imageRow vert-offset-bottom-1">
                                                <?php $oddEven = 0;?>
                                            @else
                                                <div class="row imageRow odd vert-offset-bottom-1" >
                                                <?php $oddEven = 1;?>
                                            @endif

                                                <div class="col-xs-4 col-md-4">
                                                    <a href="{{url('/')}}/uploads/users/id/{{$user->id}}/productImages/{{$image->imageName}}" target="_blank">
                                                        <img id="{{$image->id}}" class="productImage"  style="max-width: 50px; max-height: 90px; margin: 1em;" src="{{url('/')}}/uploads/users/id/{{$user->id}}/productImages/{{$image->imageName}}">
                                                    </a>
                                                </div>
                                                
                                                <div class="col-xs-4 col-md-4">
                                                    <input type="radio" name="featured" value="{{$image->id}}" class="checkmark radiobtn featuredRadio" style="position: relative;left: 28px;top: 36%;" <?php if($image->featured == 1){echo 'checked';} ?> >
                                                </div>

                                                <div class="col-xs-4 col-md-4">
                                                    <a id="{{$image->id}}" class="deleteProductImage"  href="#">
                                                        <i class="fas fa-minus-circle" style="color: #ee1919;position: relative;top: 35%;left:30%;"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                <input type="hidden" id="imagesToDelete" name="imagesToDelete" value="">
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        var imagesToDelete = [];
                                        $('.deleteProductImage').click(function(e){
                                            var imageId = $(this).attr('id');
                                            imagesToDelete.push(imageId);
                                            imagesToDeleteJson = JSON.stringify(imagesToDelete);
                                            $('#imagesToDelete').val(imagesToDeleteJson);
                                            $(this).parents('.imageRow').remove();

                                            e.preventDefault();
                                        });
                                    });
                                </script>
                                
                        @endif

                        <!-- Background Image-->

                        @if( count($backgrounds) > 0 )

                            <div class="row vert-offset-bottom-1 vert-offset-top-3">
                                <div class="col-xs-1 col-md-2"></div>
                                <div class="col-xs-10 col-md-10">
                                    <label>Existing Background Images:</label>
                                </div>
                            </div>

                                <div class="row" class="leftMargin15OnNotSmall">
                                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                                        <?php $oddEven = 0;?>
                                        <div class="row" style="border-bottom: solid 1px black;">
                                            <div class="col-xs-4 col-md-4"><label>Existing Image</label></div>
                                            <div class="col-xs-4 col-md-4"><strong>Currently Used Image</strong></div>
                                            <div class="col-xs-4 col-md-4"><strong>Delete</strong></div>
                                        </div>
                                        @foreach($backgrounds as $image)
                                            @if($oddEven == 1)
                                                <div class="row backgroundRow vert-offset-bottom-1">
                                                <?php $oddEven = 0;?>
                                            @else
                                                <div class="row backgroundRow odd vert-offset-bottom-1" >
                                                <?php $oddEven = 1;?>
                                            @endif

                                                <div class="col-xs-4 col-md-4">
                                                    <a href="{{url('/')}}/uploads/users/id/{{$user->id}}/{{$image->name}}" target="_blank">
                                                        <img id="{{$image->id}}" class="backgroundImage"  style="max-width: 50px; max-height: 90px; margin: 1em;" src="{{url('/')}}/uploads/users/id/{{$user->id}}/{{$image->name}}">
                                                    </a>
                                                </div>
                                                
                                                <div class="col-xs-4 col-md-4">
                                                    <input type="radio" name="activeBackground" value="{{$image->id}}" class="checkmark radiobtn backgroundActiveCheckbox" style="position: relative;left: 28px;top: 36%;" <?php if($image->active == 1){echo 'checked';} ?> >
                                                </div>

                                                <div class="col-xs-4 col-md-4">
                                                    <a id="{{$image->id}}" class="deleteBackgroundImage"  href="#">
                                                        <i class="fas fa-minus-circle" style="color: #ee1919;position: relative;top: 35%;left:30%;"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                <input type="hidden" id="backgroundImagesToDelete" name="backgroundImagesToDelete" value="">
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        var bgImagesToDelete = [];
                                        $('.deleteBackgroundImage').click(function(e){
                                            var bgImageId = $(this).attr('id');
                                            bgImagesToDelete.push(bgImageId);
                                            bgImagesToDeleteJson = JSON.stringify(bgImagesToDelete);
                                            console.log(bgImagesToDeleteJson);
                                            $('#backgroundImagesToDelete').val(bgImagesToDeleteJson);
                                            $(this).parents('.backgroundRow').remove();

                                            e.preventDefault();
                                        });
                                    });
                                </script>
                                
                        @endif

                        <div class="row vert-offset-bottom-2 vert-offset-top-2">
                            <div class="col-md-12">
                                <button type="button" id="updateSubmitForm" class="btn btn-success">Update</button>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                var shippingPlans = [];
                                $('#updateSubmitForm').click(function(){
                                    $('#shippingPlansJson').val(JSON.stringify(shippingPlans));
                                    $('#saveLandingPage6').submit();

                                });
                            });
                        </script>


                        </form>

                        
                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Product Images:</label>
                            </div>

                            <div class="col-md-12 multipleImages" >
                                <form action="/uploadProductImg6" method="POST" class="dropzone needsclick dz-clickable" id="avatarDropzone" style="min-height:181px;">
                                                                    
                                <input type="hidden" name="userID" value="{{ $user->id }}" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                

                                  <div class="dz-message needsclick">
                                    Drop files here or click to upload.<br>
                                    
                                  </div>


                                </form>
                            </div>
                        </div>

                         <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Background Image:</label>
                            </div>

                            <style type="text/css">
                                .dz-preview.dz-image-preview {
                                    position: absolute;
                                    left: 38% !important;
                                    top: 10% !important;
                                }

                                .multipleImages .dz-preview.dz-image-preview {
                                    position: relative !important;
                                    left: 0px !important;
                                    top: 0px !important;
                                }


                            </style>
                        
                            <div class="col-md-12">
                                <form action="/uploadBackground6" method="POST" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                    <input type="hidden" name="userID" value="{{ $user->id }}" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <?php 
                                                                $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/backgroundLP'.$landingPageNumber.'.jpg');    

                                                                curl_setopt($ch, CURLOPT_NOBODY, true);
                                                                curl_exec($ch);
                                                                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                                $backgroundExists = '';
                                                                if($code == 200){
                                                                   $backgroundExists = true;
                                                                   
                                                                }else{
                                                                  $backgroundExists = false;
                                                                }
                                                                ;
                                                                curl_close($ch);

                                                                ?>
                                                                
                                                                @if($backgroundExists == true)
                                                                    @if($landingPageNumber == 1)
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP1.jpg')}}" />
                                                                    @elseif($landingPageNumber == 2)
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP2.jpg')}}" />

                                                                    @elseif($landingPageNumber == 4)
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP4.jpg')}}" />

                                                                    @elseif($landingPageNumber == 5)
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP5.jpg')}}" />

                                                                    @endif
                                                                @elseif($landingPageNumber == 1)

                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="{{asset('uploads/placeholderBG.jpg')}}" />

                                                                @elseif($landingPageNumber == 2)

                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="{{asset('uploads/placeholderBG2.jpg')}}" />

                                                                @elseif($landingPageNumber == 4)
                                                                
                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="{{asset('uploads/placeholderBG4.jpg')}}" />
                                                                @elseif($landingPageNumber == 5)
                                                                
                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="{{asset('uploads/placeholderBG5.jpg')}}" />

                                                                @endif
                                  <div class="dz-message needsclick">
                                    Drop files here or click to upload.<br>
                                    
                                  </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
            
        </div>


    </div>

@endsection

@section('footer_scripts')

    @include('scripts.updateBackgroundDZ')


@endsection