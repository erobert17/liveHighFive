<div class="noobMessage">
    <p class="text-center">Click the "Your Landing Pages" link on the left sidebar to setup your landing pages.</p>
    <button id="closeHint" class="text-center"> Close </button>
    <button id="neverShowHints" class="text-center"> Never Show These Hints </button>
</div>

@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')

<link rel="stylesheet" href="{{asset('/forestFiles/css/index.css')}}">
<link rel="stylesheet" href="{{asset('/forestFiles/css/chartist.min.css')}}">

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
                                        <div id="widget_countup1" style="backface-visibility: hidden;">{{$countPages}}</div>
                                        <div class="previous_font" style="backface-visibility: hidden;"> 
                                        @if($isRealestate == true)
                                        	Including Open House Pages
                                        @else
                                        	&nbsp;
                                        @endif
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
                                        <div id="widget_countup2" style="backface-visibility: hidden;">{{$totalViews}}</div>
                                        
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
                                        <div id="widget_countup3" style="backface-visibility: hidden;">{{$leads}}</div>
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
                                        <div id="widget_countup4" style="backface-visibility: hidden;">{{$orders}}</div>
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
                    	<span class="card-title">View Stats</span>                    
                	</div>
	                <div class="card-body">
	                    <div class="ct-chart"></div>
	                </div>
                </div>
        	</div>
        </div>

		<script type="text/javascript" src="{{asset('/forestFiles/js/chartist.min.js')}}"></script>

        <!-- Hint Javascript -->
        <script type="text/javascript">
            $(document).ready(function() {

                var findNoobMessage = $('.noobMessage').length;
                if({{$userHintState}} == 0){
                    if(findNoobMessage > 0){
                        if({{$user->helpBubbleToggle}} == 1){
                            if({{$user->helpBubbleState}} == 0){
                                
                                var glow = $("a:contains('Your Landing Pages')");
                                glow.addClass('noobHintLink');
                                setInterval(function(){
                                    glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
                                }, 1000);

                                /*
                                $( "a:contains('Your Landing Pages')" ).animate({ color: '#1fdada' }, 1000).animate({ color: 'white' }, 1000);
                                */
                            
                            }
                        }
                    }
                }


                $('.closeHint').click(function(){
                    $.ajax({
                      type: 'POST',
                      url: '/changeHintState',
                      data: {  "_token": "{{ csrf_token() }}",
                      "hintNumber": 0},
                      //"email": email,
                      success:function(data) {
                        
                      }
                    }).done(function( msg ) {
                                
                    });

                });

            });
        </script>

        <script type="text/javascript">
		var data = {
		  // A labels array that can contain any sort of values
		  labels: <?php echo $timeStamps1; ?>,
		  // Our series array that contains series objects or in this case series data arrays
		  series: [
		    <?php echo $graphData; ?>
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


@endsection

@section('footer_scripts')
@endsection
