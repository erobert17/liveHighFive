<?php $__env->startSection('template_title'); ?>
    <?php echo e(Auth::user()->name); ?>'s' Homepage
<?php $__env->stopSection(); ?>

<?php $__env->startSection('template_fastload_css'); ?>
<?php $__env->stopSection(); ?>

<div id="fillWithNoobMessage">
</div>

<?php $__env->startSection('content'); ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
                
                
                
                if(<?php echo e($userHintState); ?> === 1){

                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "<?php echo e(csrf_token()); ?>",
                      "hintNumber": '1'},
                      //"email": email,
                      success:function(data) {

                      }
                    }).done(function( msg ) {  
                       
                    });

                    
                        if(<?php echo e($user->helpBubbleToggle); ?> == 1){// always 1 until user turns off all hint bubbles
                                
                                $('#fillWithNoobMessage').html("<div class='noobMessage noShowOnMobile'><p class='text-center'>There's a '<strong>Stats</strong>' link in the left menu, below this landing page's link.</p><p class='text-center'>Click it to see metrics for this landing page. </p><div class='text-center'><button id='closeHint' class='text-center'> Close </button><button id='neverShowHints' class='text-center'> Never Show These Hints </button></div></div>");

                                $('.noobMessage').css('display', 'block');

                                var glow = $(".copyLinkInput");
                                glow.addClass('noobBackgroundColor');
                                setInterval(function(){
                                    glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
                                }, 500);

                        }
                    
                }

                if(<?php echo e($userHintState); ?> === 2){
 
                    
                        if(<?php echo e($user->helpBubbleToggle); ?> == 1){// always 1 until user turns off all hint bubbles
                                $("#paragraphs").html();
                    
                                $('#p1').text(<?php echo'"'.$hintText[2]->p1.'"'; ?> );
                                $('#p2').text(<?php echo"'".$hintText[2]->p2."'"; ?>);
                            
                                $(".copyLinkInput").removeClass('noobBackgroundColor');// stop red copy button flashing
                                $('#nextHint').remove();
                                $(".noobMessage").delay(100).fadeIn();
                        }
                    
                }

                $('#closeHint').click(function(){

                    $('.noobMessage').css('display', 'none');
                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "<?php echo e(csrf_token()); ?>",
                      "hintNumber": '1'},
                      //"email": email,
                      success:function(data) {

                      }
                    }).done(function( msg ) {  
                    $('.noobMessage').css('display', 'none');     
                    });

                    $(".copyLinkInput").removeClass('noobBackgroundColor');

                });

                $('#neverShowHints').click(function(){

                    $('.noobMessage').css('display', 'none');

                    $.ajax({
                      type: 'POST',
                      url: '/neverShowHints',
                      data: {  "_token": "<?php echo e(csrf_token()); ?>"},
                      
                      success:function(data) {
                      }
                    }).done(function( msg ) {  
                    $('.noobMessage').css('display', 'none');     
                    });

                    $(".copyLinkInput").removeClass('noobBackgroundColor');

                });

                $('#nextHint').click(function(){
                    
                    $(".noobMessage").fadeOut();
                    $("#paragraphs").html();
                    

                        $('#p1').text(<?php echo'"'.$hintText[2]->p1.'"'; ?> );
                        $('#p2').text(<?php echo"'".$hintText[2]->p2."'"; ?>);
                    
                    $(".copyLinkInput").removeClass('noobBackgroundColor');// stop red copy button flashing
                    $(".noobMessage").delay(500).fadeIn();
                    $('#nextHint').delay(600).remove();
                    //$('.noobMessage').css('display', 'none');
                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "<?php echo e(csrf_token()); ?>",
                      "hintNumber": '1'},
                      //"email": email,
                      success:function(data) {
                      }
                    }).done(function( msg ) {  
                      
                    });

                });

        });
    </script>

    <div class="container">
        
        <form action="saveLandingPage" method="POST">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        
        <?php
         $count = 0;
         $iterate = 0;// used to select numbered array inside $page
         $landingPageNumber = '1';
         $alreadyDisplayedAddNewLP = False;
         $countLPsPrinted = 0;
         $oddEvenSwitch = 'odd';
         $typeNamesAlreadyPrinted = [];
         $rowOpenClose = 'open';
         ?>


        <?php $__currentLoopData = $landingPagePrefabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if($rowOpenClose == 'open'): ?>
                <div class="row">
                <?php $rowOpenClose = 'close'; ?>
            <?php endif; ?>
            

                <?php if($iterate <= 9 && isset($page->typeName) && !in_array($page->typeName, $typeNamesAlreadyPrinted)): ?>
                    <?php if($countLPsPrinted == 0 || $oddEvenSwitch == 'even'): ?>
                        <?php 
                        
                        if($page->typeName == 'Home Valuation')
                        {
                            $landingPageNumber = '1';
                        }else if($page->typeName == 'Property Details')
                        {
                            $landingPageNumber = '2';
                        }else if($page->typeName == 'Open Houses')
                        {
                            $landingPageNumber = '3';
                        }else if($page->typeName == 'New Product Countdown')
                        {
                            $landingPageNumber = '4';
                        }else if($page->typeName == 'New Product Coupon')
                        {
                            $landingPageNumber = '5';
                        }else if($page->typeName == 'Single Item Shopping Cart')
                        {
                            $landingPageNumber = '6';
                        }else if($page->typeName == 'Digital Download')
                        {
                            $landingPageNumber = '7';
                        }else if($page->typeName == 'Appointment')
                        {
                            $landingPageNumber = '8';
                        }else if($page->typeName == 'Mailing List')
                        {
                            $landingPageNumber = '9';
                        }
                        
                        ?>


                        <?php 
                        $typeFound = False;
                        ?>

                        <?php $__currentLoopData = $allLPsNotYetMadeByUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $landingPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($landingPage->typeName == $page->typeName): ?>
                                <?php $typeFound = True;?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($typeFound == True): ?>
                            <?php array_push($typeNamesAlreadyPrinted, $page->typeName);?>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <?php echo e($page->typeName); ?>

                                    </div>

                                    <div class="panel-body" style="background-size: cover; background-position-x: center;height: 21em; width: 100%; background-image: url('http://growyourleads.com/uploads/landingPage<?php echo e($landingPageNumber); ?>Default.jpg')">
                                    </div>
                                </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="panel-body panel panel-primary <?php if (Auth::check() && Auth::user()->hasRole('admin', true)): ?> panel-info  <?php endif; ?>">
                                                <div class="centerBlock">
                                                    <a href="createLP/<?php echo e($page->id); ?>/<?php echo e($user->id); ?>">
                                                        <button type="button" class="btn btn-success copyLinkInput">Create <?php echo e($page->typeName); ?> Landing Page</button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                            </div>
                            <?php 
                            $iterate++;
                            $countLPsPrinted++;
                            $oddEvenSwitch = "odd";
                            
                            ?>

                        <?php endif; ?>

                    <?php endif; ?>



                <?php endif; ?>

                    
                <?php if($iterate <= 9 && isset($page->typeName) && $countLPsPrinted > 0 && !in_array($page->typeName, $typeNamesAlreadyPrinted) ): ?>
                    <?php if($oddEvenSwitch == 'odd'): ?>

                        <?php
                            if($page->typeName == 'Home Valuation')
                            {
                                $landingPageNumber = '1';
                            }else if($page->typeName == 'Property Details')
                            {
                                $landingPageNumber = '2';
                            }else if($page->typeName == 'Open Houses')
                            {
                                $landingPageNumber = '3';
                            }else if($page->typeName == 'New Product Countdown')
                            {
                                $landingPageNumber = '4';
                            }else if($page->typeName == 'New Product Coupon')
                            {
                                $landingPageNumber = '5';
                            }else if($page->typeName == 'Single Item Shopping Cart')
                            {
                                $landingPageNumber = '6';
                            }else if($page->typeName == 'Digital Download')
                            {
                                $landingPageNumber = '7';
                            }else if($page->typeName == 'Appointment')
                            {
                                $landingPageNumber = '8';
                            }else if($page->typeName == 'Mailing List' || $page->typeName == 'Mailing LIst')
                            {
                                $landingPageNumber = '9';
                            }
                            
                        ?>
                        <?php 
                        $typeFound = False;
                        ?>

                        <?php $__currentLoopData = $allLPsNotYetMadeByUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $landingPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php if($landingPage->typeName == $page->typeName): ?>
                                <?php $typeFound = True;?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($typeFound == True): ?>
                            
                            <?php array_push($typeNamesAlreadyPrinted, $page->typeName);?>

                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <?php echo e($page->typeName); ?>

                                    </div>

                                    <div class="panel-body" style="background-size: cover; background-position-x: center;height: 21em; width: 100%; background-image: url('http://growyourleads.com/uploads/landingPage<?php echo e($landingPageNumber); ?>Default.jpg')">
                                    </div>
                                </div>

                                
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="panel-body panel panel-primary <?php if (Auth::check() && Auth::user()->hasRole('admin', true)): ?> panel-info  <?php endif; ?>">
                                                <div class="centerBlock">
                                                    <a href="createLP/<?php echo e($page->id); ?>/<?php echo e($user->id); ?>">
                                                        <button type="button" class="btn btn-success copyLinkInput">Create <?php echo e($page->typeName); ?> Landing Page</button>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                            </div>
                            <?php $iterate++;
                            $countLPsPrinted++;
                            $oddEvenSwitch = 'even';
                            ?>

                            <?php if($rowOpenClose == 'close'): ?>
                                </div><!-- end row-->
                                <?php $rowOpenClose = 'open'; ?>
                            <?php endif; ?>

                        <?php endif; ?>
                    
                    <?php endif; ?>

                <?php endif; ?>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        </form>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>