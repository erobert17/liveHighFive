$(document).ready(function(){
 //Add Delete Bullets
 $('body').on('click', '.deleteBullet', function(){
          $(this).parents('.bulletsContainer').remove();
        });

        $('#addProperty .addBullet').click(function(){

          $('#addProperty .bulletPoints').append('<div class="bulletsContainer">\
            <input class="input-lg bulletInput" placeholder="2 Bathrooms" />\
            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
          </div>');

        });

        $('#editProperty .addBullet').click(function(){

          $('#editProperty .bulletPoints').append('<div class="bulletsContainer">\
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
            <input class="input-med bulletDimentionsInput" value="" />\
            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
            </div>');
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
                  $('#editProperty #propertyDescription').val(data[0]['propertyDescription']);
                  //Top Bullets
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
                  //Additional Bullets
                  
                  if(data[0]['bulletsInterior'] === null || data[0]['bulletsInterior'] === 'NULL'){//if no bullets, add placeholder
                    $('#editProperty .bulletInteriorPoints').html('');
                    $('#editProperty .bulletInteriorPoints').append('<div class="bulletsContainer">\
                            <input class="input-med bulletInteriorInput" placeholder="Interior Size: 2000sq ft" value="">\
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
                          </div>');
                  }else{
                    var additionalInteriorBullets = JSON.parse(data[0]['bulletsInterior']);
                    for (var i = 0; i < additionalInteriorBullets.length; i++) {
                      $('#editProperty .bulletInteriorPoints').append('<div class="bulletsContainer">\
                              <input class="input-med bulletInteriorInput" value="'+additionalInteriorBullets[i]+'" />\
                              <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
                            </div>');
                    };
                  }
                 
                  //Exterior
                  if(data[0]['bulletsExterior'] === null || data[0]['bulletsExterior'] === 'NULL'){//if no bullets, add placeholder
                     $('#editProperty .bulletExteriorPoints').html('');
                     $('#editProperty .bulletExteriorPoints').append('<div class="bulletsContainer">\
                            <input class="input-med bulletExteriorInput" placeholder="Heated Garage" value="">\
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
                          </div>');
                  }else{
                    var additionalExteriorBullets = JSON.parse(data[0]['bulletsExterior']);
                    for (var i = 0; i < additionalExteriorBullets.length; i++) {
                      $('#editProperty .bulletExteriorPoints').append('<div class="bulletsContainer">\
                              <input class="input-med bulletExteriorInput" value="'+additionalExteriorBullets[i]+'" />\
                              <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
                            </div>');
                    };
                  }
                  // Dimention
                  if(data[0]['bulletsDimentions'] === null || data[0]['bulletsDimentions'] === 'NULL'){//if no bullets, add placeholder
                     $('#editProperty .bulletDimentionsPoints').html('');
                     $('#editProperty .bulletDimentionsPoints').append('<div class="bulletsContainer">\
                            <input class="input-med bulletDimentionsInput" placeholder="Bathroom: 10x5 sqft" value="">\
                            <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
                          </div>');
                  }else{
                    var additionalDimentionsBullets = JSON.parse(data[0]['bulletsDimentions']);
                    for (var i = 0; i < additionalDimentionsBullets.length; i++) {
                      $('#editProperty .bulletDimentionsPoints').append('<div class="bulletsContainer">\
                              <input class="input-med bulletDimentionsInput" value="'+additionalDimentionsBullets[i]+'" />\
                              <button type="button" class="deleteBullet btn btn-primary">Delete</button>\
                            </div>');
                    };                  
                  }

                  $('#editProperty .jqte_editor').html();
                  $('#backgroundLP3Update .dz-preview').html('<div class="dz-message needsclick">Drop files here or click to upload.<br></div>');

                  if(data[0]['path'] != null){
                    $('#editProperty #backgroundLP3Update .dz-message').remove();
                    $('#editProperty #backgroundLP3Update').append('<div class="dz-preview dz-processing dz-image-preview">  <div class="dz-image"><img style="width: 100%;" data-dz-thumbnail="" src="'+data[0]['path']+'" id="Oval-2" sketch:type="MSShapeGroup"></path>        </g>      </g>    </svg>  </div></div>');
                  }
                  if(data.length > 0){
                    $('#listExistingPhotos').css('display', 'block');
                    
                    for (var i = 0; i < data.length; i++) {

                        $('#listExistingPhotos').append('\
                          <div class="savedPropPhoto">\
                            <a href="#">\
                              <div id="'+data[i]['imageName']+'" class="deletePropPhoto numberedCircle boxShadowLeft circleIconLeft">X</div>\
                            </a>\
                            <img class="savedPhoto" src="'+data[i]['imageName']+'">\
                          </div>');
                      

                    };

                  }

                  console.log(data);
                }
              }).done(function( msg ) {
                  
              });
          }, 500);
          
          $('#editProperty').modal('show');
          

        });


});