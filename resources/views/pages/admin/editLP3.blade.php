@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    

    <!-- jquery text editor files -->
    <script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $('.jqte-describe').jqte();//text editor for description textarea
        });
    }(jQuery));
    </script>

    <div class="container">
        
        <input type="hidden" name="userID" value="{{ $user->id }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            
            <div class="col-md-8 col-md-offset-2">

                
            </div>
        </div>

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

                <div class="panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="panel-heading">
                        Open Houses Landing Pages
                    </div>

                    <div class="panel-body">
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12"><h4>Your Properties</h4></div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-4">
                                <button class="addProperty btn btn-primary">Add Property +</button>
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

    <!-- Modal -->
    <div class="modal fade" id="addProperty" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="createPropertyForm" action="/lp3/createProperty" method="post">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Create Property</h5>
                <button type="button" class="close closeModalX" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Property Address</h5>
                        <input class="input-lg fullWidth" name="address" placeholder="157 Claremont street, San Francisco, CA" />
                    </div>
                </div>

                <div class="row vert-offset-top-1">
                    <div class="col-md-12">
                        <h5>Price</h5>
                        <strong style="font-size: 20px;">$ </strong><input class="input-lg" name="price" placeholder="157,900" />
                    </div>
                </div>

                <div class="row vert-offset-top-1">
                    <div class="col-md-12">
                        <h5>Property Details</h5>
                        <textarea name="decription" class="jqte-describe input-lg fullWidth" name="propertyDescription"></textarea>
                    </div>
                </div>
            </form>
                
                <div class="row vert-offset-top-1">
                    <div class="col-md-12">
                        <h5>Property Photos</h5>
                        
                            <form action="/propertyImagesUpload" class="dropzone needsclick dz-clickable" id="propertyImages">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

                                        @if($backgroundExists == true)
                                            <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP1.jpg')}}" />
                                        @endif

                                      <div class="dz-message needsclick">
                                        Drop files here or click to upload.<br>
                                      </div>

                            </form>
                    </div>
                </div>

                 <style type="text/css">
                    #avatarDropzone .dz-preview.dz-image-preview {
                        position: absolute !important;
                        left: 39% !important;
                        top: 10% !important;
                    }
                 </style>

                <div class="row vert-offset-top-1">
                    <div class="col-md-12">
                        <h5>Single Background Image</h5>
                        
                            <form action="/uploadBackground3" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <?php 
                                    $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/backgroundLP3.jpg');    

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

                                        @if($backgroundExists == true)
                                            <img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="{{asset('uploads/users/id/' .Auth::user()->id. '/backgroundLP1.jpg')}}" />
                                        @endif

                                      <div class="dz-message needsclick">
                                        Drop files here or click to upload.<br>
                                      </div>
                            </form>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submitCreateProperty">Save changes</button>
              </div>
            </div>
          </div>

    </div>

    <script type="text/javascript">
    $(document).ready(function(){
        $('.addProperty').click(function(){
            $('#addProperty').modal('show')
        });

        $('.submitCreateProperty').click(function(){
            $('form#createPropertyForm').submit();
        });
    });
    </script>

<script type="text/javascript">
$(document).ready(function(){
    Dropzone.autoDiscover = false;
    Dropzone.options.propertyImages = {
      paramName: "file",
      maxFilesize: 10,
      addRemoveLinks: false,
      dictMaxFilesExceeded: '',
      acceptedFiles: '.jpeg, .jpg',
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
          $('.dz-message').text('Drop files here to upload').show();
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
          
          $('.dz-message:first').html(html).show();

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
          $('.dz-message:first').html(html).show();
          setTimeout(function() {
            $('.dz-message:first').text('Drop files here to upload').show();
          }, 2000);
          //$('#newBackground').attr('src', '/uploads/users/id/{{ $user->id }}/background.jpg?'+Math.random());
          $('#newBackground:first').attr('src', '/uploads/users/id/{{ $user->id }}/backgroundLP'+{{$landingPageNumber}}+'.jpg');

          //location.reload();

        });
        this.on("error", function(file, res) {
          var html = '<div class="progress">';
          html += '<div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">';
          html += 'Upload Failed...';
          html += '</div>';
          html += '</div>';
          alert(res);
          $('.dz-message:first').html(html).show();
          setTimeout(function() {
            $('.dz-message:first').text('Drop files here to upload').show();
          }, 2000);
        });
      }
    };

    var avatarDropzone = new Dropzone("#propertyImages");
});
</script>

@endsection

@section('footer_scripts')

    


@endsection