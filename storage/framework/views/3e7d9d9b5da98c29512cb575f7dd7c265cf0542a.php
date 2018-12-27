<?php $__env->startSection('template_title'); ?>
    <?php echo e(Auth::user()->name); ?>'s' Homepage
<?php $__env->stopSection(); ?>

<?php $__env->startSection('template_fastload_css'); ?>

<?php $__env->stopSection(); ?>

<div id="fillWithNoobMessage">


</div>

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('/forestFiles/css/index.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('/forestFiles/css/chartist.min.css')); ?>">


        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="row widget_countup">
                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">

                            <div id="top_widget1" style="perspective: 486.164px; position: relative; transform-style: preserve-3d;">
                                <div class="front">
                                    <div class="bg-primary p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-flag" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Pages</div>
                                        <div id="widget_countup1" style="backface-visibility: hidden;"><?php echo e($countPages); ?></div>
                                        <div class="previous_font" style="backface-visibility: hidden;"> 
                                        <?php if($isRealestate == true): ?>
                                        	Including Open House Pages
                                        <?php else: ?>
                                        	&nbsp;
                                        <?php endif; ?>
                                    </div>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">
                            <div id="top_widget2" style="perspective: 486.164px; position: relative; transform-style: preserve-3d;">
                                <div class="front">
                                    <div class="bg-success p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-eye" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Visits</div>
                                        <div id="widget_countup2" style="backface-visibility: hidden;"><?php echo e($totalViews); ?></div>
                                        
                                        <div class="previous_font" style="backface-visibility: hidden;">Including sub-page views</div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">
                            <div id="top_widget3" style="perspective: 486.164px; position: relative; transform-style: preserve-3d;">
                                <div class="front">
                                    <div class="bg-warning p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-comments-o" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Leads</div>
                                        <div id="widget_countup3" style="backface-visibility: hidden;"><?php echo e($leads); ?></div>
                                        <div class="tag-white " style="backface-visibility: hidden;">
                                            <span id="percent_count3" style="backface-visibility: hidden;"></span>
                                        </div>
                                        <div class="previous_font" style="backface-visibility: hidden;">
                                        &nbsp;
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">
                            <div id="top_widget4" style="perspective: 489.802px; position: relative; transform-style: preserve-3d;">
                                <div class="front" >
                                    <div class="bg-danger p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-shopping-cart" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Sales</div>
                                        <div id="widget_countup4" style="backface-visibility: hidden;"><?php echo e($orders); ?></div>
                                        <div class="tag-white" style="backface-visibility: hidden;">
                                            <span id="percent_count4" style="backface-visibility: hidden;"></span>
                                        </div>
                                        <div class="previous_font" style="backface-visibility: hidden;">Shopping Cart Orders</div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

            </div>
        </div>

        <div class="row ">
        	<div class="col-md-10 col-md-offset-1">
        		<div class="card">
                    <div class="card-header bg-white">
                        
                        <?php if($graphViewsData != null && strlen($graphViewsData) > 2): ?>
                    	   <span class="card-title">Stats From Past Week</span> 
                        <?php else: ?>
                            <span class="card-title">No Page Stats This Week</span>      
                        <?php endif; ?>              
                	</div>
	                <div class="card-body">
	                    <div class="ct-chart"></div>
	                </div>
                </div>
        	</div>
        </div>

		<script type="text/javascript" src="<?php echo e(asset('/forestFiles/js/chartist.min.js')); ?>"></script>

        <!-- Hint Javascript -->
        <script type="text/javascript">
            $(document).ready(function() {
                
                
                if(<?php echo e($userHintState); ?> == 0){
                        if(<?php echo e($user->helpBubbleToggle); ?> == 1){
                            if(<?php echo e($user->helpBubbleState); ?> == 0){
                                
                                $('#fillWithNoobMessage').html("<div class='noobMessage noShowOnMobile'><p class='text-center'><?php echo e($hintText[0]->p1); ?></p><p class='text-center'>Click the '<strong>Your Landing Pages</strong>' link on the left sidebar to setup your landing pages.</p><div class='text-center'><button id='closeHint' class='text-center'> Close </button><button id='neverShowHints' class='text-center'> Never Show These Hints </button></div></div>");

                                $('.noobMessage').css('display', 'block');
                                var glow = $("a:contains('Your Landing Pages')");
                                glow.addClass('noobHintLink');
                                setInterval(function(){
                                    glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
                                }, 500);

                            }
                        }
                    
                }

                $('#closeHint').click(function(){
                    
                    $("a:contains('Your Landing Pages')").removeClass('noobHintLink');
                    $(".noobMessage").fadeOut();
                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "<?php echo e(csrf_token()); ?>",
                      "hintNumber": '0'},
                      //"email": email,
                      success:function(data) {

                      }
                    }).done(function( msg ) {  
                    $(".noobMessage").fadeOut();    
                    });

                });

                $('#neverShowHints').click(function(){

                    $("a:contains('Your Landing Pages')").removeClass('noobHintLink');
                    $('.noobMessage').css('display', 'none');

                    $.ajax({
                      type: 'POST',
                      url: '/neverShowHints',
                      data: {  "_token": "<?php echo e(csrf_token()); ?>"},
                      //"email": email,
                      success:function(data) {
                      }
                    }).done(function( msg ) {  
                    $('.noobMessage').css('display', 'none');     
                    });

                });

            });
        </script>

        <style type="text/css">
            .ct-series-a .ct-bar, .ct-series-a .ct-line, .ct-series-a .ct-point, .ct-series-a .ct-slice-donut{
                stroke:#00bf86 !important;
            }

            .ct-series-b .ct-bar, .ct-series-b .ct-line, .ct-series-b .ct-point, .ct-series-b .ct-slice-donut {
                stroke:#ffa000 !important;
            }

            .ct-series-c .ct-bar, .ct-series-c .ct-line, .ct-series-c .ct-point, .ct-series-c .ct-slice-donut {
                stroke:#ff8080 !important;
            }
        </style>
        
        <script type="text/javascript">
        var array = <?php echo $graphViewsData; ?>;

        var reverseArray = array.reverse(); 

		var data = {
		  // A labels array that can contain any sort of values
		  labels: <?php echo $timeStamps; ?>,
		  // Our series array that contains series objects or in this case series data arrays
		  series: [
		    <?php echo $graphViewsData; ?>,
            <?php echo $graphLeadsData; ?>,
            <?php echo $graphOrdersData; ?>
		  ]
		};

		// As options we currently only set a static size of 300x200 px. We can also omit this and use aspect ratio containers
		// as you saw in the previous example
		var options = {
		  height: 400,
		  axisY: {
		    onlyInteger: true
		  }
		};



		// Create a new line chart object where as first parameter we pass in a selector
		// that is resolving to our chart container element. The Second parameter
		// is the actual data object. As a third parameter we pass in our custom options.
		new Chartist.Line('.ct-chart', data, options);
        </script>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>