@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    
        <script type="text/javascript" src="{{asset('js/jscolor.js')}}"></script>
        
        <input type="hidden" name="userID" value="{{ $user->id }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            
            <div class="col-md-6 col-md-offset-3">

                <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="centerBlock">
                        <strong>Your Unique Landing Page Link: &nbsp;</strong>
                        <input id="linkToCopy" value="{{ URL::to('/').'/link'.$landingPageNumber.'/'.$userLink }}" type="text">&nbsp;
                        <button type="button" id="copy" data-clipboard-target="#linkToCopy" class="btn btn-success">Copy</button>
                        
                        &nbsp;<strong class="copiedLink">Copied!</strong>
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

        <div class="row">
            <div class="col-md-6 col-md-offset-3">

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
                    @endif
                    </div>

                    <div class="panel-body">
                        <form action="/saveLandingPage{{$landingPageNumber}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Title:<br>
                                    <input name="title" class="longInput" value="<?php if(isset($landingPage[0]->title)){echo $landingPage[0]->title;} ?>">
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Secondary Title:<br>
                                    <input name="secondaryTitle" class="longInput" value="<?php if(isset($landingPage[0]->secondaryTitle)){echo $landingPage[0]->secondaryTitle;} ?>">
                                </label>
                            </div>
                        </div>
                        <?php 
                        echo '<pre>';
                        var_dump($landingPage);
                        echo '</pre>';
                        ?>
                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Select a text color for Primary and Secondary titles.<br>
                                    <input id="titleColorSelect" name="titleColor" class="jscolor {value:'66ccff'}" val="jscolor {value:'66ccff'}" style="width: 5em;">
                                    <input id="titleColor" class="selectedColor" type="hidden" val="" />
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Disclaimer*<br>
                                    <input type="text" name="disclaimer" value="{{$landingPage[0]->disclaimer}}" id="disclaimer" class="longInput"/> <input class="jscolor {value:'66ccff'}" val="jscolor {value:'66ccff'}" style="width: 5em;">
                                    <input id="disclaimerColor" class="selectedColor" type="hidden" val="" />
                                </label>
                            </div>
                        </div>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Coupon Code<br>
                                    <input type="text" name="coupon" value="{{$landingPage[0]->coupon}}" id="coupon"/>
                                </label>
                            </div>
                        </div>
                    
                        <script src="{{asset('js/php-date-formatter.min.js')}}"></script>
                        <script src="{{asset('js/jquery.mousewheel.js')}}"></script>
                        <script src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Select a background color or upload a background img below.<br>

                                    <input class="jscolor {value:'66ccff'}" val="jscolor {value:'66ccff'}" style="width: 5em;">
                                    <button type="button" class="btn btn-danger" id="jscolorClear">Clear</button>
                                    <input id="backgroundColor" class="selectedColor" type="hidden" val="" />
                                </label>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('body').on('change', '.jscolor', function() {
                                //$(".jscolor").change(function(){ 
                                    var changedColor = $(this).val();

                                    console.log(changedColor);
                                    $(this).parents('label').find('.selectedColor').val(changedColor);
                                });

                                $('#jscolorClear').click(function(){
                                    $(this).parents('label').find('.jscolor').val('');
                                });
                            });
                        </script>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <button class="btn btn-success">Update</button>
                            </div>
                        </div>
                        </form>

                        <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Product Image:</label>
                            </div>

                            
                            <div class="col-md-12">
                                <form action="/uploadProductImg5" method="POST" class="dropzone needsclick dz-clickable" id="avatarDropzone" style="min-height:181px;">
                                                                    
                                <input type="hidden" name="userID" value="{{ $user->id }}" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                    <?php 
                                        $ch = curl_init('http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/uploadProductCouponImg.png');    
                                        
                                        curl_setopt($ch, CURLOPT_NOBODY, true);
                                        curl_exec($ch);
                                        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                        
                                        $backgroundExists = '';
                                        if($code == 200){
                                           $backgroundExists = true;
                                           echo '<img id="newBackground" class="user-avatar" style="border-radius: none;" width="100" height="90" src="http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/uploadProductCouponImg.png" />';   
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

                         <div class="row vert-offset-bottom-1">
                            <div class="col-md-12">
                                <label>Background Image:</label>
                            </div>

                            <style type="text/css">
                                .dz-preview.dz-image-preview {
                                    position: absolute !important;
                                    left: 38% !important;
                                    top: 10% !important;
                                }
                            </style>
                        
                            <div class="col-md-12">
                                <form action="/uploadBackground5" method="POST" class="dropzone needsclick dz-clickable" id="avatarDropzone">
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