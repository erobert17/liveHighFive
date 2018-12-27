<?php $__env->startSection('template_title'); ?>
    <?php echo e(Auth::user()->name); ?>'s' Homepage
<?php $__env->stopSection(); ?>


<div id="fillWithNoobMessage">


</div>

<?php $__env->startSection('template_fastload_css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<script type="text/javascript">
        $(document).ready(function(){

            if(<?php echo e($userHintState); ?> === 2){
     
                if(<?php echo e($user->helpBubbleToggle); ?> == 1){// always 1 until user turns off all hint bubbles
                    $('#fillWithNoobMessage').html("<div class='noobMessage noShowOnMobile'><p class='text-center'>There's a '<strong>Stats</strong>' link in the left menu, below this landing page's link.</p><p class='text-center'>Click it to see metrics for this landing page. </p><div class='text-center'><button id='closeHint' class='text-center'> Close </button><button id='neverShowHints' class='text-center'> Never Show These Hints </button></div></div>");

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
    
    <div class="container">
        
        <input type="hidden" name="userID" value="<?php echo e($user->id); ?>" >
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

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
            <div class="col-md-12">

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

                <?php if( $businessCardCorrect == true): ?>
                  <div class="row vert-offset-bottom-1">
                        <div class="col-md-12">
                                <div class="alert alert-warning">
                                <span class="glyphicon glyphicon-record"></span> <strong>Contact Info Needed</strong>
                                <hr class="message-inner-separator">
                                <p><?php echo $businesscardWarning; ?></p>
                            </div>
                        </div>
                  </div>
                <?php endif; ?>

                <div class="panel panel-primary <?php if (Auth::check() && Auth::user()->hasRole('admin', true)): ?> panel-info  <?php endif; ?>">
                    <div class="panel-heading">
                        Open Houses Landing Pages
                    </div>

                    <div class="panel-body">
                        
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        
                        <div class="row">
                            <div class="col-md-12"><h4>Your Properties</h4></div>
                        </div>

                        <?php if(count($properties) > 0): ?>
                          <div class="row margin1px bottomBorder1 bottomBorder1">
                                <div class="col-xs-2 col-sm-2 col-md-5">Address</div>
                                <div class="col-xs-6 col-sm-6 col-md-5">Property Link</div>
                                <div class="col-xs-6 col-sm-2 col-md-1"></div>
                                <div class="col-xs-6 col-sm-2 col-md-1"></div>
                          </div>
                        <?php endif; ?>
                        <div class="row vert-offset-bottom-1 margin1px">
                            <div class="col-md-12">
                              <?php $oddEven = 0;?>
                              <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($oddEven == 0): ?>
                                  <div class="row propertyRow">
                                    <?php $oddEven = 1;?>
                                <?php else: ?>
                                  <div class="row odd propertyRow">
                                    <?php $oddEven = 0;?>
                                <?php endif; ?>
                                  <div class="col-xs-3 col-sm-3 col-md-5 paddingTop6px"> <?php echo e(substr($prop->address, 0 ,30)); ?>...</div>
                                  <div class="col-xs-5 col-sm-5 col-md-5"> 
                                    <input type="text" style="display:none;" id="linkToCopy<?php echo e($prop->id); ?>" value="<?php echo URL::to('/').'/openHouseLink/'.$user->id.'/'.$prop->id; ?>"></input>
                                    <button type="button" id="copy<?php echo e($prop->id); ?>" data-clipboard-target="#linkToCopy<?php echo e($prop->id); ?>" class="btn btn-success">
                                      Copy Open House Link
                                    </button>
                                    &nbsp;<strong class="copiedLinkCustom copiedLink<?php echo e($prop->id); ?>">Copied!</strong>
                                  </div>
                                  <div class="col-xs-6 col-sm-2 col-md-1"> 
                                    <a href="#" id="<?php echo e($prop->id); ?>" class="editOpenhouse paddingTop6px">Edit</a> 
                                  </div>
                                  <div class="col-xs-6 col-sm-2 col-md-1"> 
                                    <a id="<?php echo e($prop->id); ?>" class="deleteOpenhouse paddingTop6px" href="#">Delete</a> 
                                  </div>
                                </div>
                                <script type="text/javascript">
                                    
                                    $(document).ready(function(){
                                        new Clipboard("#copy<?php echo e($prop->id); ?>", {
                                          text: function(trigger) {
                                            var textToReturn = $("#linkToCopy<?php echo e($prop->id); ?>").val(); 
                                             $(".copiedLink<?php echo e($prop->id); ?>").attr( "style", "display: inline !important;" );
                                              setTimeout(function() { $(".copiedLink<?php echo e($prop->id); ?>").fadeOut(); }, 5000);
                                            return textToReturn;
                                          }
                                        });
                                        
                                    });
                                </script>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>



                        <div class="row vert-offset-bottom-1 vert-offset-top-2">
                            <div class="col-md-4">
                              <?php if($user->subscribed('main') == false && count($properties) >= 3): ?>
                                <button class="addProperty btn btn-primary" disabled>Add Property +</button>
                              <?php else: ?>
                                <button class="addProperty btn btn-primary">Add Property +</button>
                              <?php endif; ?>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                        </div>

                    </div><!-- Panel Body-->

                </div>


            </div>
            
        </div>


    </div>

    <style type="text/css">
      #addProperty > .dz-preview {
          position: absolute !important;
                        left: 39% !important;
                        top: -1% !important;
      }
    </style>
    <div id='map' style="display:none;"></div>
    
    <!-- Modal Create Openhouse-->
    <div class="modal fade" id="addProperty" tabindex="-1" role="dialog" aria-hidden="true">

        <form id="createPropertyForm" action="/lp3/createProperty" method="post">
          <?php echo e(csrf_field()); ?>

          <input type="hidden" name="userId" value="<?php echo e($user->id); ?>" >
          <input type="hidden" name="tempRandomString" value="<?php echo e($tempRandomString); ?>">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">
                  <strong>Create Property</strong>
                </h3>
                <button type="button" class="close closeModalX" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>Property Address</strong></h4>
                        <label class="propertyDetailsSub">Please enter a full address and select a result from the dropdown so that our system can correctly generate a map for the landing page. </label>
                        <input id="createAddress" class="input-lg fullWidth" name="address" placeholder="157 Claremont street, San Francisco, CA" />
                        
                    </div>
                </div>

                <div class="row vert-offset-top-1">
                    <div class="col-md-12">
                        <h4><strong>Price</strong></h4>
                        <strong style="font-size: 20px;">$ </strong><input class="input-lg" name="price" placeholder="157,900" />
                    </div>
                </div>

                <div class="row vert-offset-top-1 topBullets">
                  <input style="display:none;" name="jsonBullets" id="jsonBulletsCreate" value="">

                    <div class="col-md-12">
                        <h4><strong>Top Page Property Details</strong></h4>
                        <label class="propertyDetailsSub"> Add bullet points to give small details about the listing. These show up at the very top of the page under the address and price.</label>
                        <div class="bulletPoints">
                          <div class="bulletsContainer">
                            <input class="input-lg bulletInput" placeholder="2 Bathrooms" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addBullet btn btn-primary">+</button>
                    </div>
                </div>

                <div class="row vert-offset-top-1">
                    <div class="col-md-12">
                        <h4><strong>Breif Property Description</strong></h4>
                        <textarea name="propertyDescription" id="propertyDescription" class="input-lg form-control"></textarea>
                    </div>
                </div>

                <div class="row vert-offset-top-1 additionalBullets">
                  <input style="display:none;" name="jsonInteriorBulletsCreate" id="jsonInteriorBulletsCreate" value="">
                  <input style="display:none;" name="jsonExteriorBulletsCreate" id="jsonExteriorBulletsCreate" value="">
                  <input style="display:none;" name="jsonDimentionsBulletsCreate" id="jsonDimentionsBulletsCreate" value="">
                  
                    <div class="col-md-4">
                        <h4><strong>Interior Details</strong></h4>
                        <div class="bulletInteriorPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletInteriorInput" placeholder="Interior Size: 2000sq ft" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addInteriorBullet btn btn-primary">+</button>
                    </div>

                    <div class="col-md-4">
                        <h4><strong>Exterior Details</strong></h4>
                        <div class="bulletExteriorPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletExteriorInput" placeholder="Lot Size: 0.5 acres" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addExteriorBullet btn btn-primary">+</button>
                    </div>

                    <div class="col-md-4">
                        <h4><strong>Room Dimentions</strong></h4>
                        <div class="bulletDimentionsPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletDimentionsInput" placeholder="Living Room: 29x19" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addDimentionsBullet btn btn-primary">+</button>
                    </div>

                </div>
            </form>
                
                <div class="row vert-offset-top-1 propertyDZ">
                    <div class="col-md-12">
                        <h4><strong>Property Photos</strong></h4>
                        
                            <form method="post" action="/propertyImagesUpload" class="dropzone needsclick dz-clickable" id="propertyImages">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <input type="hidden" name="tempRandomString" value="<?php echo e($tempRandomString); ?>">
                                
                                <?php 
                                    $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/propertyPhotos/backgroundLP3.jpg');    

                                    curl_setopt($ch, CURLOPT_NOBODY, true);
                                    curl_exec($ch);
                                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                    $backgroundExists = false;
                                    if($code == 200){
                                       $backgroundExists = true;                               
                                    }else{
                                        $backgroundExists = false;
                                    }
                                            
                                        curl_close($ch);
                                    ?>

                                      <div class="dz-message needsclick">
                                        Drop files here or click to upload.<br>
                                      </div>

                            </form>
                    </div>
                </div>

                 <style type="text/css">
                    #backgroundLP3Update > .dz-preview {
                        position: absolute !important;
                        left: 39% !important;
                        top: -1% !important;
                    }
                 </style>

                <div class="row vert-offset-top-1 backgroundDZ">
                    <div class="col-md-12">
                        <h4><strong>Single Background Image</strong></h4>
                        
                            <form action="/uploadBackground3" class="dropzone needsclick dz-clickable" id="backgroundLP3">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <input type="hidden" class="propertyId" name="propertyId">
                                <input type="hidden" class="tempRandomString" name="tempRandomString" value="<?php echo e($tempRandomString); ?>">
                                
                                      <div class="dz-message needsclick">
                                        Drop files here or click to upload.<br>
                                      </div>
                            </form>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submitCreateProperty">Save</button>
              </div>
            </div>
          </div>

    </div>


    <!-- Modal Edit Openhouse-->
    <div class="modal fade" id="editProperty" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="editPropertyForm" action="/lp3/editProperty" method="post">
          <?php echo e(csrf_field()); ?>

          <input type="hidden" name="userId" value="<?php echo e($user->id); ?>" >
          <input type="hidden" name="propertyId" class="propertyId" id="propertyId" value="">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">
                  <strong>Edit Property</strong>
                </h3>
                <button type="button" class="close closeModalX" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4><strong>Property Address</strong></h4>

                        <input id="address" class="input-lg fullWidth" name="address" placeholder="157 Claremont street, San Francisco, CA" />
                    </div>
                </div>

                <div class="row vert-offset-top-1">
                    <div class="col-md-12">
                        <h4><strong>Price</strong></h4>
                        <strong style="font-size: 20px;">$ </strong><input class="input-lg" id="price" name="price" placeholder="157,900" />
                    </div>
                </div>

                <div class="row vert-offset-top-1">
                  <input style="display:none;" name="jsonBullets" id="jsonBulletsEdit" value="">
                    <div class="col-md-12">
                        <h4><strong>Top Page Property Details</strong></h4>
                        <label class="propertyDetailsSub"> Add Bullet Points to give small details about the listing. For Example, "5 Bedrooms", "New Kitchen". Use short details, No long sentences.</label>
                        <div class="bulletPoints">
                          <div class="bulletsContainer">
                            <input class="input-lg bulletInput" placeholder="2 Bathrooms" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addBullet btn btn-primary">+</button>
                    </div>
                </div>

                <div class="row vert-offset-top-1 additionalBullets">
                  <input style="display:none;" name="jsonInteriorBulletsUpdate" id="jsonInteriorBulletsUpdate" value="">
                  <input style="display:none;" name="jsonExteriorBulletsUpdate" id="jsonExteriorBulletsUpdate" value="">
                  <input style="display:none;" name="jsonDimentionsBulletsUpdate" id="jsonDimentionsBulletsUpdate" value="">
                  
                    <div class="col-md-4">
                        <h4><strong>Interior Details</strong></h4>
                        <div class="bulletInteriorPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletInteriorInput" placeholder="Interior Size: 2000sq ft" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addInteriorBullet btn btn-primary">+</button>
                    </div>

                    <div class="col-md-4">
                        <h4><strong>Exterior Details</strong></h4>
                        <div class="bulletExteriorPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletExteriorInput" placeholder="Lot Size: 0.5 acres" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addExteriorBullet btn btn-primary">+</button>
                    </div>

                    <div class="col-md-4">
                        <h4><strong>Room Dimentions</strong></h4>
                        <div class="bulletDimentionsPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletDimentionsInput" placeholder="Living Room: 29x19" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addDimentionsBullet btn btn-primary">+</button>
                    </div>

                </div>
            </form>
                  
                <div class="row vert-offset-top-1 topBullets">
                    <div class="col-md-12">
                        <h4><strong>Breif Property Description</strong></h4>
                        <textarea name="propertyDescription" id="propertyDescription" class="input-lg form-control"></textarea>
                    </div>
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

                <div class="row vert-offset-top-1 propertyDZ">
                    <div class="col-md-12 multipleImages">

                            <div class="row">
                              <div id="listExistingPhotos" class="col-md-12">
                                <h4 class="vert-offset-bottom-1"><strong>Existing Photos</strong></h4>
                              </div>
                            </div>

                          <h4 class="vert-offset-bottom-1"><strong>Upload New Property Photos</strong></h4>
                            <form method="post" action="/propertyImagesUpload" class="dropzone needsclick dz-clickable" id="propertyImagesUpdate">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <input type="hidden" id="propertyPhotosPropId" class="propertyId" name="propertyId">
                                
                                <?php 
                                    $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/propertyPhotos/backgroundLP3.jpg');    

                                    curl_setopt($ch, CURLOPT_NOBODY, true);
                                    curl_exec($ch);
                                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                    $backgroundExists = false;
                                    if($code == 200){
                                       $backgroundExists = true;                               
                                    }else{
                                        $backgroundExists = false;
                                    }
                                            
                                        curl_close($ch);
                                    ?>

                                      <div class="dz-message needsclick">
                                        Drop files here or click to upload.<br>
                                      </div>

                            </form>
                    </div>
                </div>

                 <style type="text/css">
                    #backgroundLP3 .dz-preview {
                        position: absolute !important;
                        left: 39% !important;
                        top: -1% !important;
                    }
                 </style>

                <div class="row vert-offset-top-1 backgroundDZ">

                    <div class="col-md-12">
                        <h4><strong>Single Background Image</strong></h4>
                        
                            <form action="/uploadBackground3" class="dropzone needsclick dz-clickable" id="backgroundLP3Update">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <input type="hidden" class="propertyId" name="propertyId">
                                <input type="hidden" class="tempRandomString" name="tempRandomString" value="<?php echo e($tempRandomString); ?>">

                                <?php 
                                    $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/propertyPhotos/backgroundLP3.jpg');    

                                    curl_setopt($ch, CURLOPT_NOBODY, true);
                                    curl_exec($ch);
                                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                    $backgroundExists = false;
                                    if($code == 200){
                                       $backgroundExists = true;                               
                                    }else{
                                        $backgroundExists = false;
                                    }
                                            
                                        curl_close($ch);
                                    ?>
                                
                                      <div class="dz-message needsclick">
                                        Drop files here or click to upload.<br>
                                      </div>
                            </form>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary updateProperty">Save Changes</button>
              </div>
            </div>
          </div>

    </div>

    <script type="text/javascript" src="<?php echo e(asset('js/bullets.js')); ?>"></script>

    <script type="text/javascript">

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.addProperty').click(function(){
            $('#addProperty').modal('show')
        });

        $('.deleteOpenhouse').click(function(){
          var deleteId = $(this).attr('id');
          $(this).parents('.propertyRow').hide('slow', function(){ $(this).parents('.propertyRow').remove(); });;

          $.ajax({
                type: 'POST',
                url: '/deleteOpenhouse',
                data: {
                "propertyId": deleteId
                },
                success:function(data) {
                
                }
          }).done(function( msg ) {
                  
          });

        });


        
        $('body').on('click', '.deletePropPhoto', function(){
          var photoId = $(this).attr('id');

          //$(this).parents('.savedPropPhoto').remove();
          $(this).parents('.savedPropPhoto').hide('slow', function(){ $(this).remove(); });
          $.ajax({
                type: 'POST',
                url: '/deletePropPhoto',
                data: {
                "photoId": photoId
                },
                success:function(data) {
                  
                }
              }).done(function( msg ) {
                  
              });
        });

        $('#editProperty .updateProperty').click(function(){
          var interiorBullets=[]; var exteriorBullets=[]; var dimentionsBullets=[];
            var allBullets = [];
            $('#editProperty .bulletInput').each(function(){
              var b = $(this).val();
              if(b.length > 0){
                allBullets.push(b);
              }
              
            });
            allBullets = JSON.stringify(allBullets);
            $('#editProperty #jsonBulletsEdit').val(allBullets);

            //Additional bullets
            //Additional Bullets
            $('#editProperty .bulletInteriorInput').each(function(){
              var ib = $(this).val();
              if(ib.length > 0){
                interiorBullets.push(ib);
              }
            });
            interiorBullets = JSON.stringify(interiorBullets);
            $('#editProperty #jsonInteriorBulletsUpdate').val(interiorBullets);

            $('#editProperty .bulletExteriorInput').each(function(){
              var ib = $(this).val();
              if(ib.length > 0){
                exteriorBullets.push(ib);
              }
              
            });
            exteriorBullets = JSON.stringify(exteriorBullets);
            $('#editProperty #jsonExteriorBulletsUpdate').val(exteriorBullets);

            $('#editProperty .bulletDimentionsInput').each(function(){
              var ib = $(this).val();
              if(ib.length > 0){
                dimentionsBullets.push(ib);
              }
              
            });
            dimentionsBullets = JSON.stringify(dimentionsBullets);
            $('#editProperty #jsonDimentionsBulletsUpdate').val(dimentionsBullets);
            
            setTimeout(function(){
              $('form#editPropertyForm').submit();
            },500);
        });

        $('.submitCreateProperty').click(function(){
          var allBullets = [];var interiorBullets=[]; var exteriorBullets=[]; var dimentionsBullets=[];
            $('#addProperty .bulletInput').each(function(){
              var b = $(this).val();
              if(b.length > 0){
                allBullets.push(b);
              }
            });
            allBullets = JSON.stringify(allBullets);

            //Additional Bullets
            $('#addProperty .bulletInteriorInput').each(function(){
              var ib = $(this).val();
              if(ib.length > 0){
                interiorBullets.push(ib);
              }
            });
            interiorBullets = JSON.stringify(interiorBullets);
            $('#addProperty #jsonInteriorBulletsCreate').val(interiorBullets);

            $('#addProperty .bulletExteriorInput').each(function(){
              var ib = $(this).val();
              if(ib.length > 0){
                exteriorBullets.push(ib);
              }
            });
            exteriorBullets = JSON.stringify(exteriorBullets);
            $('#addProperty #jsonExteriorBulletsCreate').val(exteriorBullets);

            $('#addProperty .bulletDimentionsInput').each(function(){
              var ib = $(this).val();
              if(ib.length > 0){
                dimentionsBullets.push(ib);
              }
              
            });
            dimentionsBullets = JSON.stringify(dimentionsBullets);
            $('#addProperty #jsonDimentionsBulletsCreate').val(dimentionsBullets);
            
            $('#jsonBulletsCreate').val(allBullets);
            setTimeout(function(){
              $('form#createPropertyForm').submit();
            },500);
            
        });
    });
    </script>

<!-- Property Images Create Prop -->
<script type="text/javascript">

$(document).ready(function(){
    Dropzone.autoDiscover = false;
    Dropzone.options.propertyImages = {
      paramName: "file",
      maxFilesize: 10,
      addRemoveLinks: false,
      dictMaxFilesExceeded: '',
      acceptedFiles: '.jpeg, .jpg, .JPG, .png, .PNG',
      renameFilename: 'avatar.jpg',
      headers: {
        "Pragma": "no-cache"
      },
      clickable: true,
      parallelUploads: 1,
      accept: function(file, done) {
        if (file.name == "justinbieber.jpg") {
          done("Naha, you don't.");
        } else {
          $('#propertyDZ > .dz-message').text('Drop files here to upload').show();
          done();
        }
      },
      init: function() {
        
        this.on("maxfilesexceeded", function(file) {});
        this.on("uploadprogress", function(file) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">';
          html += '</div>';
          html += '</div>';
          
          $('#propertyDZ > .dz-message').html(html).show();

        });
        this.on("maxfilesreached", function(file) {});
        this.on("complete", function(file) {
          //this.removeFile(file);
        });
        this.on("success", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Successful...';
          html += '</div>';
          html += '</div>';
          $('#propertyDZ > .dz-message:first').html(html).show();
           setTimeout(function() {
            $('#propertyDZ > .dz-message:first').text('Drop files here to upload').show();
          }, 1000);
          //$('#newBackground').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/background.jpg?'+Math.random());
          //$('#newBackground:first').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/backgroundLP'+<?php echo e($landingPageNumber); ?>+'.jpg');

          //location.reload();

        });
        this.on("error", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Failed...';
          html += '</div>';
          html += '</div>';
          
          $('#propertyDZ > .dz-message:first').html(html).show();
          setTimeout(function() {
            $('#propertyDZ > .dz-message:first').text('Drop files here to upload').show();
          }, 2000);
        });

      }
    };

    var propertyImages = new Dropzone("#propertyImages");
});

</script>

<!-- Property Images update Prop -->
<script type="text/javascript">
/*
$(document).ready(function(){
    Dropzone.autoDiscover = false;
    Dropzone.options.propertyImages = {
      paramName: "file",
      maxFilesize: 10,
      addRemoveLinks: false,
      dictMaxFilesExceeded: '',
      acceptedFiles: '.jpeg, .jpg, .JPG, .png, .PNG',
      renameFilename: 'avatar.jpg',
      headers: {
        "Pragma": "no-cache"
      },
      clickable: true,
      parallelUploads: 1,
      accept: function(file, done) {
        if (file.name == "justinbieber.jpg") {
          done("Naha, you don't.");
        } else {
          $('#propertyDZ > .dz-message').text('Drop files here to upload').show();
          done();
        }
      },
      init: function() {
        
        this.on("maxfilesexceeded", function(file) {});
        this.on("uploadprogress", function(file) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">';
          html += '</div>';
          html += '</div>';
          
          $('#propertyDZ > .dz-message').html(html).show();

        });
        this.on("maxfilesreached", function(file) {});
        this.on("complete", function(file) {
          //this.removeFile(file);
        });
        this.on("success", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Successful...';
          html += '</div>';
          html += '</div>';
          $('#propertyDZ > .dz-message:first').html(html).show();
           setTimeout(function() {
            $('#propertyDZ > .dz-message:first').text('Drop files here to upload').show();
          }, 1000);
          //$('#newBackground').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/background.jpg?'+Math.random());
          //$('#newBackground:first').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/backgroundLP'+<?php echo e($landingPageNumber); ?>+'.jpg');

          //location.reload();

        });
        this.on("error", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Failed...';
          html += '</div>';
          html += '</div>';
          
          $('#propertyDZ > .dz-message:first').html(html).show();
          setTimeout(function() {
            $('#propertyDZ > .dz-message:first').text('Drop files here to upload').show();
          }, 2000);
        });

      }
    };

    //var propertyImages = new Dropzone("#propertyImagesUpdate");
});
*/
</script>

<!-- Background dropzone -->
<script type="text/javascript">
$(document).ready(function(){
    Dropzone.autoDiscover = false;
    Dropzone.options.backgroundLP3Create = {
      paramName: "file",
      maxFilesize: 10,
      addRemoveLinks: false,
      dictMaxFilesExceeded: '',
      acceptedFiles: '.jpeg, .jpg, .JPG, .png, .PNG',
      renameFilename: 'avatar.jpg',
      headers: {
        "Pragma": "no-cache"
      },
      clickable: true,
      parallelUploads: 1,
      accept: function(file, done) {
        if (file.name == "justinbieber.jpg") {
          done("Naha, you don't.");
        } else {
          $('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
          done();
        }
      },
      init: function() {
        this.on("maxfilesexceeded", function(file) {});
        this.on("uploadprogress", function(file) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">';
          html += '</div>';
          html += '</div>';
          
          //$('#backgroundDZ > .dz-message').html(html).show();

        });
        this.on("maxfilesreached", function(file) {});
        this.on("complete", function(file) {
          this.removeFile(file);
        });
        this.on("success", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Successful...';
          html += '</div>';
          html += '</div>';
          //$('#backgroundDZ > .dz-message').html(html).show();
          setTimeout(function() {
            //$('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
            
          }, 100);
          //$('#newBackground').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/background.jpg?'+Math.random());
          $('#newBackground').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/backgroundLP'+<?php echo e($landingPageNumber); ?>+'.jpg?random='+new Date().getTime());
          
          //location.reload();

        });
        this.on("error", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Failed...';
          html += '</div>';
          html += '</div>';
          //alert(res);
          $('#backgroundDZ > .dz-message').html(html).show();
          setTimeout(function() {
            $('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
          }, 2000);
        });
      }
    };

    //var backgroundLP3Create = new Dropzone("#backgroundLP3");
});
</script>

<!-- Background dropzone Update-->
<script type="text/javascript">
$(document).ready(function(){
    Dropzone.autoDiscover = false;
    Dropzone.options.backgroundLP3 = {
      paramName: "file",
      maxFilesize: 10,
      addRemoveLinks: false,
      dictMaxFilesExceeded: '',
      acceptedFiles: '.jpeg, .jpg, .JPG, .png, .PNG',
      renameFilename: 'avatar.jpg',
      headers: {
        "Pragma": "no-cache"
      },
      clickable: true,
      parallelUploads: 1,
      accept: function(file, done) {
        if (file.name == "justinbieber.jpg") {
          done("Naha, you don't.");
        } else {
          $('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
          done();
        }
      },
      init: function() {
        this.on("maxfilesexceeded", function(file) {});
        this.on("uploadprogress", function(file) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">';
          html += '</div>';
          html += '</div>';
          
          $('#backgroundDZ > .dz-message').html(html).show();

        });
        this.on("maxfilesreached", function(file) {});
        this.on("complete", function(file) {
          this.removeFile(file);
        });
        this.on("success", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Successful...';
          html += '</div>';
          html += '</div>';
          //$('#backgroundDZ > .dz-message').html(html).show();
          setTimeout(function() {
            //$('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
            
          }, 100);
          //$('#newBackground').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/background.jpg?'+Math.random());
          $('#newBackground').attr('src', '/uploads/users/id/<?php echo e($user->id); ?>/backgroundLP'+<?php echo e($landingPageNumber); ?>+'.jpg?random='+new Date().getTime());
        
          //location.reload();

        });
        this.on("error", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Failed...';
          html += '</div>';
          html += '</div>';
          //alert(res);
          $('#backgroundDZ > .dz-message').html(html).show();
          setTimeout(function() {
            $('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
          }, 2000);
        });
      }
    };

    //var backgroundLP3 = new Dropzone("#backgroundLP3Update");
});
</script>



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
        var inputCreate = document.getElementById('createAddress');
        var input = document.getElementById('address');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var options = {
          componentRestrictions: {country: "us"}
         };
        // autocomplete 1
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

        //autocomplete 2
        var autocomplete2 = new google.maps.places.Autocomplete(inputCreate, options);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete2.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete2.addListener('place_changed', function() {
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


<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

    


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>