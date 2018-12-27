@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    <!-- date time picker -->
    
        
        <input type="hidden" name="userID" value="{{ $user->id }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            
            <div class="col-md-8 col-md-offset-2">

                <div class="panel-body panel panel-primary @role('admin', true) panel-info  @endrole">
                    <div class="centerBlock">
                        <strong>Your Unique Landing Page Link: &nbsp;</strong>
                        <input id="linkToCopy" value="{{ URL::to('/').'/link'.$landingPageNumber.'/'.$userLink }}" type="text">&nbsp;
                        <button type="button" id="copy" data-clipboard-target="#linkToCopy" class="btn btn-success">Copy</button>
                        
                        &nbsp;<strong class="copiedLink">Copied!</strong>
                    </div>
                </div>
           
                <script type="text/javascript">
                    /*
                    new Clipboard('#copy');
                    $(document).ready(function(){
                        $('#copy').click(function(){
                                $(".copiedLink").attr( "style", "display: inline !important;" )
                                setTimeout(function() { $(".copiedLink").fadeOut(); }, 5000);
                        });
                    });*/
                </script>

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
                        <script>
                          $(document).ready(function() {

                                $('.datepicker').datetimepicker({
                                    format: 'dd/mm/yyyy'
                                });
                            });
                        </script>
                        
<input type="text" name="basic_example_1" id="basic_example_1" value="" class="datepicker">

    
    <p><a href="http://xdsoft.net/jqplugins/datetimepicker/">Homepage</a></p>
    <h3>DateTimePicker</h3>
    <input type="text" value="" id="datetimepicker"/><br><br>
  <h3>DateTimePickers selected by class</h3>
    <input type="text" class="some_class" value="" id="some_class_1"/>
    <input type="text" class="some_class" value="" id="some_class_2"/>
    <h3>Mask DateTimePicker</h3>
    <input type="text" value="" id="datetimepicker_mask"/><br><br>
    <h3>TimePicker</h3>
    <input type="text" id="datetimepicker1"/><br><br>
    <h3>DatePicker</h3>
    <input type="text" id="datetimepicker2"/><br><br>
    <h3>Inline DateTimePicker</h3>
    <!--<div id="console" style="background-color:#fff;color:red">sdfdsfsdf</div>-->
    <input type="text" id="datetimepicker3"/><input type="button" onclick="$('#datetimepicker3').datetimepicker({value:'2011/12/11 12:00'})" value="set inline value 2011/12/11 12:00"/><br><br>
    <h3>Button Trigger</h3>
    <input type="text" value="2013/12/03 18:00" id="datetimepicker4"/><input id="open" type="button" value="open"/><input id="close" type="button" value="close"/><input id="reset" type="button" value="reset"/>
    <h3>TimePicker allows time</h3>
    <input type="text" id="datetimepicker5"/><br><br>
    <h3>Destroy DateTimePicker</h3>
    <input type="text" id="datetimepicker6"/><input id="destroy" type="button" value="destroy"/>
    <h3>Set options runtime DateTimePicker</h3>
    <input type="text" id="datetimepicker7"/>
    <p>If select day is Saturday, the minimum set 11:00, otherwise 8:00</p>
    <h3>onGenerate</h3>
    <input type="text" id="datetimepicker8"/>
    <h3>disable all weekend</h3>
    <input type="text" id="datetimepicker9"/>
    <h3>Default date and time </h3>
    <input type="text" id="default_datetimepicker"/>
    <h3>Show inline</h3>
    <a href="javascript:void(0)" onclick="var si = document.getElementById('show_inline').style; si.display = (si.display=='none')?'block':'none';return false; ">Show/Hide</a>
    <div id="show_inline" style="display:none">
        <input type="text" id="datetimepicker10"/>
    </div>
    <h3>Disable Specific Dates</h3>
    <p>Disable the dates 2 days from now.</p>
    <input type="text" id="datetimepicker11"/>
    <h3>Custom Date Styling</h3>
    <p>Make the background of the date 2 days from now bright red.</p>
    <input type="text" id="datetimepicker12"/>
    <h3>Dark theme</h3>
    <p>thank for this <a href="https://github.com/lampslave">https://github.com/lampslave</a></p>
    <input type="text" id="datetimepicker_dark"/>
    <h3>Date time format and locale</h3>
    <p></p>
    <select id="datetimepicker_format_locale">
        <option value="en">English</option>
        <option value="de">German</option>
        <option value="ru">Russian</option>
        <option value="uk">Ukrainian</option>
        <option value="fr">French</option>
        <option value="es">Spanish</option>
    </select>
    <input type="text" value="D, l, M, F, Y-m-d H:i:s" id="datetimepicker_format_value"/>
    <input type="button" value="applay =>" id="datetimepicker_format_change"/>
    <input type="text" id="datetimepicker_format" class="input input-wide"/>
</body>

<script src="{{asset('js/php-date-formatter.min.js')}}"></script>
<script src="{{asset('js/jquery.mousewheel.js')}}"></script>
<script src="{{asset('js/jquery.datetimepicker.full.js')}}"></script>

<script>/*
window.onerror = function(errorMsg) {
    $('#console').html($('#console').html()+'<br>'+errorMsg)
}*/
$(document).ready(function(){

        
    $.datetimepicker.setLocale('en');

    $('#datetimepicker_format').datetimepicker({value:'2015/04/15 05:03', format: $("#datetimepicker_format_value").val()});
    console.log($('#datetimepicker_format').datetimepicker('getValue'));

    $("#datetimepicker_format_change").on("click", function(e){
        $("#datetimepicker_format").data('xdsoft_datetimepicker').setOptions({format: $("#datetimepicker_format_value").val()});
    });
    $("#datetimepicker_format_locale").on("change", function(e){
        $.datetimepicker.setLocale($(e.currentTarget).val());
    });

    $('#datetimepicker').datetimepicker({
    dayOfWeekStart : 1,
    lang:'en',
    disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
    startDate:  '1986/01/05'
    });
    $('#datetimepicker').datetimepicker({value:'2015/04/15 05:03',step:10});

    $('.some_class').datetimepicker();

    $('#default_datetimepicker').datetimepicker({
        formatTime:'H:i',
        formatDate:'d.m.Y',
        //defaultDate:'8.12.1986', // it's my birthday
        defaultDate:'+03.01.1970', // it's my birthday
        defaultTime:'10:00',
        timepickerScrollbar:false
    });

    $('#datetimepicker10').datetimepicker({
        step:5,
        inline:true
    });
    $('#datetimepicker_mask').datetimepicker({
        mask:'9999/19/39 29:59'
    });

    $('#datetimepicker1').datetimepicker({
        datepicker:false,
        format:'H:i',
        step:5
    });
    $('#datetimepicker2').datetimepicker({
        yearOffset:222,
        lang:'ch',
        timepicker:false,
        format:'d/m/Y',
        formatDate:'Y/m/d',
        minDate:'-1970/01/02', // yesterday is minimum date
        maxDate:'+1970/01/02' // and tommorow is maximum date calendar
    });
    $('#datetimepicker3').datetimepicker({
        inline:true
    });
    $('#datetimepicker4').datetimepicker();
    $('#open').click(function(){
        $('#datetimepicker4').datetimepicker('show');
    });
    $('#close').click(function(){
        $('#datetimepicker4').datetimepicker('hide');
    });
    $('#reset').click(function(){
        $('#datetimepicker4').datetimepicker('reset');
    });
    $('#datetimepicker5').datetimepicker({
        datepicker:false,
        allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
        step:5
    });
    $('#datetimepicker6').datetimepicker();
    $('#destroy').click(function(){
        if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
            $('#datetimepicker6').datetimepicker('destroy');
            this.value = 'create';
        }else{
            $('#datetimepicker6').datetimepicker();
            this.value = 'destroy';
        }
    });
    var logic = function( currentDateTime ){
        if (currentDateTime && currentDateTime.getDay() == 6){
            this.setOptions({
                minTime:'11:00'
            });
        }else
            this.setOptions({
                minTime:'8:00'
            });
    };
    $('#datetimepicker7').datetimepicker({
        onChangeDateTime:logic,
        onShow:logic
    });
    $('#datetimepicker8').datetimepicker({
        onGenerate:function( ct ){
            $(this).find('.xdsoft_date')
                .toggleClass('xdsoft_disabled');
        },
        minDate:'-1970/01/2',
        maxDate:'+1970/01/2',
        timepicker:false
    });
    $('#datetimepicker9').datetimepicker({
        onGenerate:function( ct ){
            $(this).find('.xdsoft_date.xdsoft_weekend')
                .addClass('xdsoft_disabled');
        },
        weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
        timepicker:false
    });
    var dateToDisable = new Date();
        dateToDisable.setDate(dateToDisable.getDate() + 2);
    $('#datetimepicker11').datetimepicker({
        beforeShowDay: function(date) {
            if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
                return [false, ""]
            }

            return [true, ""];
        }
    });
    $('#datetimepicker12').datetimepicker({
        beforeShowDay: function(date) {
            if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
                return [true, "custom-date-style"];
            }

            return [true, ""];
        }
    });
    $('#datetimepicker_dark').datetimepicker({theme:'dark'})

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
                                @if($landingPageNumber == 1)
                                    <form action="/uploadBackground" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                @elseif($landingPageNumber == 2)
                                    <form action="/uploadBackground2" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                @elseif($landingPageNumber == 4)
                                    <form action="/uploadBackground4" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                @elseif($landingPageNumber == 5)
                                    <form action="/uploadBackground5" class="dropzone needsclick dz-clickable" id="avatarDropzone">
                                @endif
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