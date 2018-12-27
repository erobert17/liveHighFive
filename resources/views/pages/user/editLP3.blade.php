@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    


    <div class="container">
        
        <input type="hidden" name="userID" value="{{ $user->id }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">

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

                @if( $businessCardCorrect == true)
                  <div class="row vert-offset-bottom-1">
                        <div class="col-md-12">
                                <div class="alert alert-warning">
                                <span class="glyphicon glyphicon-record"></span> <strong>Contact Info Needed</strong>
                                <hr class="message-inner-separator">
                                <p>{!! $businesscardWarning !!}</p>
                            </div>
                        </div>
                  </div>
                @endif

                <div class="panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="panel-heading">
                        Open Houses Landing Pages
                    </div>

                    <div class="panel-body">
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="row">
                            <div class="col-md-12"><h4>Your Properties</h4></div>
                        </div>

                        @if(count($properties) > 0)
                          <div class="row margin1px bottomBorder1 bottomBorder1">
                                <div class="col-md-5">Address</div>
                                <div class="col-md-5">Property Link</div>
                                <div class="col-md-1"></div>
                                <div class="col-md-1"></div>
                          </div>
                        @endif
                        <div class="row vert-offset-bottom-1 margin1px">
                            <div class="col-md-12">
                              <?php $oddEven = 0;?>
                              @foreach($properties as $prop)
                                @if($oddEven == 0)
                                  <div class="row propertyRow">
                                    <?php $oddEven = 1;?>
                                @else
                                  <div class="row odd propertyRow">
                                    <?php $oddEven = 0;?>
                                @endif
                                  <div class="col-md-5 paddingTop6px"> {{substr($prop->address, 0 ,40)}}...</div>
                                  <div class="col-md-5"> 
                                    <input type="text" style="display:none;" id="linkToCopy{{$prop->id}}" value="<?php echo URL::to('/').'/openHouseLink/'.$user->id.'/'.$prop->id; ?>"></input>
                                    <button type="button" id="copy{{$prop->id}}" data-clipboard-target="#linkToCopy{{$prop->id}}" class="btn btn-success">
                                      Copy Open House Link
                                    </button>
                                    &nbsp;<strong class="copiedLinkCustom copiedLink{{$prop->id}}">Copied!</strong>
                                  </div>
                                  <div class="col-md-1"> 
                                    <a href="#" id="{{$prop->id}}" class="editOpenhouse paddingTop6px">Edit</a> 
                                  </div>
                                  <div class="col-md-1"> 
                                    <a id="{{$prop->id}}" class="deleteOpenhouse paddingTop6px" href="#">Delete</a> 
                                  </div>
                                </div>
                                <script type="text/javascript">
                                    
                                    $(document).ready(function(){
                                        new Clipboard("#copy{{$prop->id}}", {
                                          text: function(trigger) {
                                            var textToReturn = $("#linkToCopy{{$prop->id}}").val(); 
                                             $(".copiedLink{{$prop->id}}").attr( "style", "display: inline !important;" );
                                              setTimeout(function() { $(".copiedLink{{$prop->id}}").fadeOut(); }, 5000);
                                            return textToReturn;
                                          }
                                        });
                                        
                                    });
                                </script>
                              @endforeach
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-4">
                              @if($user->subscribed('main') == false && count($properties) >= 3)
                                <button class="addProperty btn btn-primary" disabled>Add Property +</button>
                              @else
                                <button class="addProperty btn btn-primary">Add Property +</button>
                              @endif
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

    <!-- Modal Create Openhouse-->
    <div class="modal fade" id="addProperty" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="createPropertyForm" action="/lp3/createProperty" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="userId" value="{{ $user->id }}" >
          <input type="hidden" name="tempRandomString" value="{{ $tempRandomString }}">
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
                        <input class="input-lg fullWidth" name="address" placeholder="157 Claremont street, San Francisco, CA" />
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

                <div class="row vert-offset-top-1 additionalBullets">
                  <input style="display:none;" name="jsonInteriorBulletsCreate" id="jsonInteriorBulletsCreate" value="">
                  
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
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="tempRandomString" value="{{ $tempRandomString }}">
                                
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
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="tempRandomString" value="{{ $tempRandomString }}">
                                
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
          {{ csrf_field() }}
          <input type="hidden" name="userId" value="{{ $user->id }}" >
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
                        <input class="input-lg fullWidth" id="address" name="address" placeholder="157 Claremont street, San Francisco, CA" />
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
                  <input style="display:none;" name="jsonBullets" id="jsonBulletsEdit" value="">
                    
                    <div class="col-md-4">
                        <h4><strong>Interior Details</strong></h4>
                        <div class="bulletInteriorPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletInteriorInput" placeholder="Interior Size: 2000sq ft" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addBullet btn btn-primary">+</button>
                    </div>

                    <div class="col-md-4">
                        <h4><strong>Exterior Details</strong></h4>
                        <div class="bulletExteriorPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletExteriorInput" placeholder="Lot Size: 0.5 acres" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addBullet btn btn-primary">+</button>
                    </div>

                    <div class="col-md-4">
                        <h4><strong>Room Dimentions</strong></h4>
                        <div class="bulletDimentionsPoints bulletsParent">
                          <div class="bulletsContainer">
                            <input class="input-med bulletDimentionsInput" placeholder="Living Room: 29x19" value="" />
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>
                          </div>
                          
                        </div>
                        <button type="button" class="addBullet btn btn-primary">+</button>
                    </div>

                </div>
            </form>
                
                <div class="row vert-offset-top-1 propertyDZ">
                    <div class="col-md-12">
                            <div class="row">
                              <div id="listExistingPhotos" class="col-md-12">
                                <h4 class="vert-offset-bottom-1"><strong>Existing Photos</strong></h4>
                              </div>
                            </div>
                          <h4 class="vert-offset-bottom-1"><strong>Upload New Property Photos</strong></h4>
                            <form method="post" action="/propertyImagesUpload" class="dropzone needsclick dz-clickable" id="propertyImagesUpdate">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" class="propertyId" name="propertyId">

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

    <script type="text/javascript">// Bullets
      $(document).ready(function(){
        $('body').on('click', '.deleteBullet', function(){
          $(this).parents('.bulletsContainer').remove();
        });

        $('.topBullets .addBullet').click(function(){
          $('.bulletPoints').append('<div class="bulletsContainer">\
            <input class="input-lg bulletInput" placeholder="2 Bathrooms" />\
            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
          </div>');
        });

        //bulletInteriorPoints bulletExteriorPoints bulletDimentionsPoints
        
        $('.addInteriorBullet').click(function(){
          $('.bulletInteriorPoints').append('<div class="bulletsContainer">\
            <input class="input-med bulletInteriorInput" value="" />\
            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
            </div>');
        });
        $('.addExteriorBullet').click(function(){
          $('.bulletExteriorPoints').append('<div class="bulletsContainer">\
            <input class="input-med bulletExteriorInput" value="" />\
            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
            </div>');
        });
        $('.addDimentionsBullet').click(function(){
          $('.bulletDimentionsPoints').append('<div class="bulletsContainer">\
            <input class="input-med bulletDimentionsInput" placeholder="Living Room: 29x19" value="" />\
            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
            </div>');
        });

      });
    </script>

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

        $('.editOpenhouse').click(function(){
            var ohId = $(this).attr('id');
            //console.log('ohid '+ohId);
            $('#propertyPhotosPropId').val(ohId);
            $('#propertyId').val(ohId);
            $('.propertyId').each(function(){
            $(this).val(ohId);

          });
            
          setTimeout(function() {
              $.ajax({
                type: 'POST',
                url: '/getOpenhouse',
                data: {
                "propertyId": ohId
                },
                success:function(data) {

                  //var returnedData = JSON.parse(data);
                  //console.log(returnedData);
                  data = JSON.parse(data);
                  console.log(data);
                  //$('#propertyPhotosPropId').val(data[0]['id']);
                 // $('#editProperty #propertyId').val(data[0]['id']);
                  $('#editProperty #address').val(data[0]['address']);
                  $('#editProperty #price').val(data[0]['price']);
                  var allBullets = JSON.parse(data[0]['topBullets']);
                  if(allBullets == null){
                    allBullets = [];
                  }else{
                    $('#editProperty .bulletsContainer').remove();
                  }
                  for (var i = 0; i < allBullets.length; i++) {
                    $('#editProperty .bulletPoints').append('\
                      <div class="bulletsContainer">\
                            <input class="input-lg bulletInput" placeholder="2 Bathrooms" value="'+allBullets[i]+'" />\
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
                          </div>');
                  };

                  $('#editProperty .jqte_editor').html();
                  $('#editProperty #backgroundLP3Update .dz-message').remove();
                  $('#editProperty #backgroundLP3Update').append('<div class="dz-preview dz-processing dz-image-preview">  <div class="dz-image"><img style="width: 100%;" data-dz-thumbnail="" src="'+data[0]['path']+'" id="Oval-2" sketch:type="MSShapeGroup"></path>        </g>      </g>    </svg>  </div></div>');
                  
                  if(data.length > 0){
                    $('#listExistingPhotos').css('display', 'block');

                    for (var i = 0; i < data.length; i++) {
                      if(data[i]['id'] != null){

                        $('#listExistingPhotos').append('\
                          <div class="savedPropPhoto">\
                            <a href="#">\
                              <div id="'+data[i]['id']+'" class="deletePropPhoto numberedCircle boxShadowLeft circleIconLeft">X</div>\
                            </a>\
                            <img class="savedPhoto" src="'+data[i]['imageName']+'">\
                          </div>');
                      }

                    };

                  }

                  console.log(data);
                }
              }).done(function( msg ) {
                  
              });
          }, 500);
          
          $('#editProperty').modal('show');
          

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
                  //alert(data);
                }
              }).done(function( msg ) {
                  
              });
        });

        $('.updateProperty').click(function(){
            var allBullets = [];
            $('#editProperty .bulletInput').each(function(){
              var b = $(this).val();
              allBullets.push(b);
            });
            allBullets = JSON.stringify(allBullets);
            $('#jsonBulletsEdit').val(allBullets);
            
            setTimeout(function(){
              $('form#editPropertyForm').submit();
            },500);
        });

        $('.submitCreateProperty').click(function(){
          var allBullets = [];var interiorBullets=[];
            $('#addProperty .bulletInput').each(function(){
              var b = $(this).val();
              allBullets.push(b);
            });
            allBullets = JSON.stringify(allBullets);

            //Additional Bullets
            $('#addProperty .bulletInteriorInput').each(function(){
              var ib = $(this).val();
              interiorBullets.push(ib);
            });
            interiorBullets = JSON.stringify(interiorBullets);
            $('#jsonInteriorBulletsCreate').val(interiorBullets);
            
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
          //$('#newBackground').attr('src', '/uploads/users/id/{{ $user->id }}/background.jpg?'+Math.random());
          //$('#newBackground:first').attr('src', '/uploads/users/id/{{ $user->id }}/backgroundLP'+{{$landingPageNumber}}+'.jpg');

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
          //$('#newBackground').attr('src', '/uploads/users/id/{{ $user->id }}/background.jpg?'+Math.random());
          //$('#newBackground:first').attr('src', '/uploads/users/id/{{ $user->id }}/backgroundLP'+{{$landingPageNumber}}+'.jpg');

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

    var propertyImages = new Dropzone("#propertyImagesUpdate");
});

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
          //$('#newBackground').attr('src', '/uploads/users/id/{{ $user->id }}/background.jpg?'+Math.random());
          $('#newBackground').attr('src', '/uploads/users/id/{{ $user->id }}/backgroundLP'+{{$landingPageNumber}}+'.jpg?random='+new Date().getTime());
          
          //location.reload();

        });
        this.on("error", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Failed...';
          html += '</div>';
          html += '</div>';
          alert(res);
          $('#backgroundDZ > .dz-message').html(html).show();
          setTimeout(function() {
            $('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
          }, 2000);
        });
      }
    };

    var backgroundLP3Create = new Dropzone("#backgroundLP3");
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
          //$('#newBackground').attr('src', '/uploads/users/id/{{ $user->id }}/background.jpg?'+Math.random());
          $('#newBackground').attr('src', '/uploads/users/id/{{ $user->id }}/backgroundLP'+{{$landingPageNumber}}+'.jpg?random='+new Date().getTime());
        
          //location.reload();

        });
        this.on("error", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Failed...';
          html += '</div>';
          html += '</div>';
          alert(res);
          $('#backgroundDZ > .dz-message').html(html).show();
          setTimeout(function() {
            $('#backgroundDZ > .dz-message').text('Drop files here to upload').show();
          }, 2000);
        });
      }
    };

    var backgroundLP3 = new Dropzone("#backgroundLP3Update");
});
</script>

@endsection

@section('footer_scripts')

    


@endsection