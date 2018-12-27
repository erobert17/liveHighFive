<?php $__env->startSection('template_title'); ?>
    <?php echo e(Auth::user()->name); ?>'s' Homepage
<?php $__env->stopSection(); ?>

<?php $__env->startSection('template_fastload_css'); ?>
<?php $__env->stopSection(); ?>
    
<div id="fillWithNoobMessage">


</div>

<?php $__env->startSection('content'); ?>
    
    <script type="text/javascript">
        $(document).ready(function(){

            if(<?php echo e($userHintState); ?> === 2){
     
                if(<?php echo e($user->helpBubbleToggle); ?> == 1){// always 1 until user turns off all hint bubbles
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
                          data: {  "_token": "<?php echo e(csrf_token()); ?>",
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
                          data: {  "_token": "<?php echo e(csrf_token()); ?>"},
                          
                          success:function(data) {
                          }
                        }).done(function( msg ) {  
                        $(".noobMessage").fadeOut();       
                        });

                        $(".copyLinkInput").removeClass('noobBackgroundColor');

                    });

        });
    </script>
        <script type="text/javascript" src="<?php echo e(asset('js/jscolor.js')); ?>"></script>
        
        <input type="hidden" name="userID" value="<?php echo e($user->id); ?>" >
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <div class="row">
            
            <div class="col-sm-10 col-sm-offset-2 col-md-8 col-md-offset-3 col-lg-6 col-lg-offset-3">

                <div class="panel-body panel panel-primary <?php if (Auth::check() && Auth::user()->hasRole('admin', true)): ?> panel-info  <?php endif; ?>">
                    <div class="centerBlock">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <strong>Your Unique Landing Page Link: &nbsp;</strong>
                            </div>
                            <div class="col-sm-4 col-md-6">
                                <input id="linkToCopy" style="width:100%" value="<?php echo e(URL::to('/').'/link'.$landingPageNumber.'/'.$userLink); ?>" type="text">&nbsp;
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

                    <div class="panel-body panel panel-primary <?php if (Auth::check() && Auth::user()->hasRole('admin', true)): ?> panel-info  <?php endif; ?>">
                        <div class="centerBlock">
                            <div class="row">
                                <div class="col-sm-8 col-md-8" style="padding-top: 0.5em;color:#954120;">
                                    <strong>Delete This Landing Page</strong>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <a href="/deleteLandingPage/<?php echo e($landingPage[0]->id); ?>">
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

                <?php if( isset($warningTitle) ): ?>

                    <div class="row vert-offset-bottom-1">
                        <div class="col-md-12">
                                <div class="alert alert-warning">
                                <span class="glyphicon glyphicon-record"></span> <strong>Warning</strong>
                                <hr class="message-inner-separator">
                                <p><?php echo $warningTitle; ?></p>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <div class="panel panel-primary <?php if (Auth::check() && Auth::user()->hasRole('admin', true)): ?> panel-info  <?php endif; ?>">
                    <div class="panel-heading">
                        
                        <?php if($landingPageNumber == 1): ?>
                            Property Valuation Landing Page
                        <?php elseif($landingPageNumber == 2): ?>
                            Property Search Landing Page
                        <?php elseif($landingPageNumber == 4): ?>
                            Countdown Landing Page
                        <?php elseif($landingPageNumber == 5): ?>
                            Coupon Landing Page
                        <?php elseif($landingPageNumber == 6): ?>
                            Single Item Shopping Cart
                        <?php endif; ?>

                    </div>

                    <div class="panel-body">
                        <form id="saveLandingPage6" action="/saveLandingPage<?php echo e($landingPageNumber); ?>" method="POST">
                            
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

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
                                        
                                        <?php if(count($shippingPlans) > 0): ?>
                                          <div class="row margin1px bottomBorder1 bottomBorder1">
                                                <div class="col-xs-5 col-md-5">Shipping Plan</div>
                                                <div class="col-xs-5 col-md-5">Price</div>
                                                <div class="col-xs-2 col-md-2 "></div>
                                          </div>
                                        <?php endif; ?>

                                    </div>
                                    
                                </div>

                                <div class="row margin1px">
                                    <div class="col-md-12 plansMother">
                                      
                                        <?php if( count($shippingPlans) > 0 ): ?>
                                            <?php $oddEven = 0;?>

                                          <?php $__currentLoopData = $shippingPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($oddEven == 0): ?>
                                              <div id="<?php echo e($plan->id); ?>" class="row planRow">
                                                <?php $oddEven = 1;?>
                                            <?php else: ?>
                                              <div id="<?php echo e($plan->id); ?>" class="row odd planRow">
                                                <?php $oddEven = 0;?>
                                            <?php endif; ?>
                                            
                                                <div class="col-xs-5 col-md-5"> <input class="planName" style="width:100%;margin-top: 9px;" value="<?php echo e($plan->name); ?>"> </div>
                                                <div class="col-xs-5 col-md-5"> $<input class="planPrice" style="max-width: 85px; margin-top: 9px;" value="<?php echo e($plan->price); ?>"> </div>
                                                <div class="col-xs-2 col-md-2"><a href="#" class="deletePlan" style="text-align: left;margin-top: 9px;">Delete Plan</a></div>
                                              
                                              </div>

                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
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
                                                  data: {  "_token": "<?php echo e(csrf_token()); ?>",
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
                                                      data: {  "_token": "<?php echo e(csrf_token()); ?>",
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
                                                      data: {  "_token": "<?php echo e(csrf_token()); ?>",
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
                                    <?php if($landingPage[0]->titleColor !== NULL && strlen($landingPage[0]->titleColor) > 2 ): ?>
                                        <input id="titleColorSelect" name="titleSelect" class="jscolor 
                                    {value:'<?php echo e($landingPage[0]->titleColor); ?>'}" value="jscolor {value:'<?php echo e($landingPage[0]->titleColor); ?>'}" style="width: 5em;">
                                        <input id="titleColor" name="titleColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="<?php echo e($landingPage[0]->titleColor); ?>" />
                                    <?php else: ?>
                                        <input id="titleColorSelect" name="titleSelect" class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="titleColor" name="titleColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="" />
                                    <?php endif; ?>
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
                                    
                                    <?php if(isset($landingPage[0]) && $landingPage[0]->titleShadow == 1): ?>
                                        <input type="checkbox" style="width: 23px;height: 23px;" name="titleTextShadow" checked="checked" />
                                    <?php else: ?>
                                        <input type="checkbox" style="width: 23px;height: 23px;" name="titleTextShadow" />
                                    <?php endif; ?>
                                </label>
                            </div>
                        </div>
                        
                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-8">
                                <label>Disclaimer*<br>
                                    <?php if( isset($landingPage[0]) ): ?>
                                        <input type="text" name="disclaimer" value="<?php echo e(htmlentities($landingPage[0]->disclaimer)); ?>" id="disclaimer" class="longInput"/>
                                    <?php else: ?>
                                        <input type="text" name="disclaimer" value="" id="disclaimer" class="longInput"/>
                                    <?php endif; ?>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label>Disclaimer Text Color<br>
                                    <?php if($landingPage[0]->disclaimerColor !== NULL && strlen($landingPage[0]->disclaimerColor) > 2 ): ?>
                                        <input id="disclaimerSelect" name="disclaimerSelect" class="jscolor 
                                    {value:'<?php echo e($landingPage[0]->disclaimerColor); ?>'}" value="jscolor {value:'<?php echo e($landingPage[0]->disclaimerColor); ?>'}" style="width: 5em;">
                                        <input id="disclaimerColor" name="disclaimerColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="<?php echo e($landingPage[0]->disclaimerColor); ?>" />
                                    <?php else: ?>
                                        <input id="disclaimerSelect" name="disclaimerSelect" class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="disclaimerColor" name="disclaimerColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="" />
                                    <?php endif; ?>
                                    
                                    
                                </label>
                            </div>
                        </div>

                        
                        <script src="<?php echo e(asset('js/php-date-formatter.min.js')); ?>"></script>
                        <script src="<?php echo e(asset('js/jquery.mousewheel.js')); ?>"></script>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Select a background color or upload a background img at bottom of page:<br>
                                    <?php if($landingPage[0]->backgroundColor !== NULL  && strlen($landingPage[0]->backgroundColor) > 2): ?>
                                        <input id="backgroundSelect"" class="jscolor 
                                    {value:'<?php echo e($landingPage[0]->backgroundColor); ?>'}" value="jscolor {value:'<?php echo e($landingPage[0]->backgroundColor); ?>'}" style="width: 5em;">
                                        <input id="backgroundColor" name="backgroundColor" class="backgroundColor selectedColor saveColorChange saveColorVal" type="hidden" value="<?php echo e($landingPage[0]->backgroundColor); ?>" />
                                    <?php else: ?>
                                        <input id="disclaimerSelect"  class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="backgroundColor" name="backgroundColor" class="backgroundColor selectedColor saveColorChange saveColorVal" type="hidden" value="" />
                                    <?php endif; ?>

                                    <button type="button" class="btn btn-danger" id="jscolorClear">Clear</button>
                                    
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Color of "Add To Cart" Button<br>
                                    <?php if($landingPage[0]->buttonColor !== NULL && strlen($landingPage[0]->buttonColor) > 2 ): ?>
                                        <input id="buttonColorSelect" name="buttonSelect" class="jscolor 
                                    {value:'<?php echo e($landingPage[0]->buttonColor); ?>'}" value="jscolor {value:'<?php echo e($landingPage[0]->buttonColor); ?>'}" style="width: 5em;">
                                        <input id="buttonColor" name="buttonColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="<?php echo e($landingPage[0]->buttonColor); ?>" />
                                    <?php else: ?>
                                        <input id="buttonColorSelect" name="buttonSelect" class="jscolor 
                                    {required:false}" value="" style="width: 5em;">
                                        <input id="buttonColor" name="buttonColor" class="selectedColor saveColorVal saveColorChange" type="hidden" value="" />
                                    <?php endif; ?>
                                    
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


                        <?php if( count($productImages) > 0 ): ?>

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
                                        <?php $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($oddEven == 1): ?>
                                                <div class="row imageRow vert-offset-bottom-1">
                                                <?php $oddEven = 0;?>
                                            <?php else: ?>
                                                <div class="row imageRow odd vert-offset-bottom-1" >
                                                <?php $oddEven = 1;?>
                                            <?php endif; ?>

                                                <div class="col-xs-4 col-md-4">
                                                    <a href="<?php echo e(url('/')); ?>/uploads/users/id/<?php echo e($user->id); ?>/productImages/<?php echo e($image->imageName); ?>" target="_blank">
                                                        <img id="<?php echo e($image->id); ?>" class="productImage"  style="max-width: 50px; max-height: 90px; margin: 1em;" src="<?php echo e(url('/')); ?>/uploads/users/id/<?php echo e($user->id); ?>/productImages/<?php echo e($image->imageName); ?>">
                                                    </a>
                                                </div>
                                                
                                                <div class="col-xs-4 col-md-4">
                                                    <input type="radio" name="featured" value="<?php echo e($image->id); ?>" class="checkmark radiobtn featuredRadio" style="position: relative;left: 28px;top: 36%;" <?php if($image->featured == 1){echo 'checked';} ?> >
                                                </div>

                                                <div class="col-xs-4 col-md-4">
                                                    <a id="<?php echo e($image->id); ?>" class="deleteProductImage"  href="#">
                                                        <i class="fas fa-minus-circle" style="color: #ee1919;position: relative;top: 35%;left:30%;"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                
                        <?php endif; ?>

                        <!-- Background Image-->

                        <?php if( count($backgrounds) > 0 ): ?>

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
                                        <?php $__currentLoopData = $backgrounds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($oddEven == 1): ?>
                                                <div class="row backgroundRow vert-offset-bottom-1">
                                                <?php $oddEven = 0;?>
                                            <?php else: ?>
                                                <div class="row backgroundRow odd vert-offset-bottom-1" >
                                                <?php $oddEven = 1;?>
                                            <?php endif; ?>

                                                <div class="col-xs-4 col-md-4">
                                                    <a href="<?php echo e(url('/')); ?>/uploads/users/id/<?php echo e($user->id); ?>/<?php echo e($image->name); ?>" target="_blank">
                                                        <img id="<?php echo e($image->id); ?>" class="backgroundImage"  style="max-width: 50px; max-height: 90px; margin: 1em;" src="<?php echo e(url('/')); ?>/uploads/users/id/<?php echo e($user->id); ?>/<?php echo e($image->name); ?>">
                                                    </a>
                                                </div>
                                                
                                                <div class="col-xs-4 col-md-4">
                                                    <input type="radio" name="activeBackground" value="<?php echo e($image->id); ?>" class="checkmark radiobtn backgroundActiveCheckbox" style="position: relative;left: 28px;top: 36%;" <?php if($image->active == 1){echo 'checked';} ?> >
                                                </div>

                                                <div class="col-xs-4 col-md-4">
                                                    <a id="<?php echo e($image->id); ?>" class="deleteBackgroundImage"  href="#">
                                                        <i class="fas fa-minus-circle" style="color: #ee1919;position: relative;top: 35%;left:30%;"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                
                        <?php endif; ?>

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
                                                                    
                                <input type="hidden" name="userID" value="<?php echo e($user->id); ?>" >
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                

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
                                    <input type="hidden" name="userID" value="<?php echo e($user->id); ?>" >
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
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
                                                                
                                                                <?php if($backgroundExists == true): ?>
                                                                    <?php if($landingPageNumber == 1): ?>
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP1.jpg')); ?>" />
                                                                    <?php elseif($landingPageNumber == 2): ?>
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP2.jpg')); ?>" />

                                                                    <?php elseif($landingPageNumber == 4): ?>
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP4.jpg')); ?>" />

                                                                    <?php elseif($landingPageNumber == 5): ?>
                                                                    
                                                                        <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP5.jpg')); ?>" />

                                                                    <?php endif; ?>
                                                                <?php elseif($landingPageNumber == 1): ?>

                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/placeholderBG.jpg')); ?>" />

                                                                <?php elseif($landingPageNumber == 2): ?>

                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/placeholderBG2.jpg')); ?>" />

                                                                <?php elseif($landingPageNumber == 4): ?>
                                                                
                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/placeholderBG4.jpg')); ?>" />
                                                                <?php elseif($landingPageNumber == 5): ?>
                                                                
                                                                    <img id="newBackground" class="user-avatar" style=" border-radius: none;" width="100" height="90" src="<?php echo e(asset('uploads/placeholderBG5.jpg')); ?>" />

                                                                <?php endif; ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

    <?php echo $__env->make('scripts.updateBackgroundDZ', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>