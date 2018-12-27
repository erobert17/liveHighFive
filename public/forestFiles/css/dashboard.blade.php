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

                @include('panels.welcome-panel')

                <div class="row widget_countup">
                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">

                            <div id="top_widget1" style="perspective: 486.164px; position: relative; transform-style: preserve-3d;">
                                <div class="front" style="backface-visibility: hidden; transform-style: preserve-3d; position: absolute; z-index: 1; height: 100%; width: 100%; transition: all 0.5s ease-out; transform: rotateX(0deg);">
                                    <div class="bg-primary p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-users" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Pages</div>
                                        <div id="widget_countup1" style="backface-visibility: hidden;">{{$countPages}}</div>
                                        <div class="previous_font" style="backface-visibility: hidden;"> 
                                        @if($isRealestate == true)
                                        	Includes Openhouse Pages
                                        @else
                                        	&nbsp;
                                        @endif

                                    </div>
                                        
                                    </div>
                                </div>

                                <div class="back" style="backface-visibility: hidden; transform-style: preserve-3d; position: relative; z-index: 0; height: 100%; width: 100%; transform: rotateX(-180deg); transition: all 0.5s ease-out;">
                                    <div class="bg-white b_r_5 section_border" style="backface-visibility: hidden;">
                                        <div class="p-t-l-r-15" style="backface-visibility: hidden;">
                                            <div class="float-right m-t-5 text-success" style="backface-visibility: hidden;">
                                                <i class="fa fa-shopping-cart" style="backface-visibility: hidden;"></i>
                                            </div>
                                            <div id="widget_countup22" style="backface-visibility: hidden;"></div>
                                            <div style="backface-visibility: hidden;"></div>

                                        </div>

                                        <div class="row" style="backface-visibility: hidden;">
                                            <div class="col-lg-12" style="backface-visibility: hidden;">
                                                <span id="salesspark-chart" class="spark_line" style="backface-visibility: hidden;"><canvas width="358" height="48" style="display: inline-block; width: 358px; height: 48px; vertical-align: top;"></canvas></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">
                            <div id="top_widget2" style="perspective: 486.164px; position: relative; transform-style: preserve-3d;">
                                <div class="front" style="backface-visibility: hidden; transform-style: preserve-3d; position: absolute; z-index: 1; height: 100%; width: 100%; transition: all 0.5s ease-out;">
                                    <div class="bg-success p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-shopping-cart" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Visits</div>
                                        <div id="widget_countup2" style="backface-visibility: hidden;">{{$totalViews}}</div>
                                        
                                        <div class="previous_font" style="backface-visibility: hidden;">Including sub-page views</div>
                                    </div>
                                </div>

                                <div class="back" style="backface-visibility: hidden; transform-style: preserve-3d; position: relative; z-index: 0; height: 100%; width: 100%; transform: rotateX(-180deg); transition: all 0.5s ease-out;">
                                    <div class="bg-white b_r_5 section_border" style="backface-visibility: hidden;">
                                        <div class="p-t-l-r-15" style="backface-visibility: hidden;">
                                            <div class="float-right m-t-5 text-success" style="backface-visibility: hidden;">
                                                <i class="fa fa-shopping-cart" style="backface-visibility: hidden;"></i>
                                            </div>
                                            <div id="widget_countup22" style="backface-visibility: hidden;"></div>
                                            <div style="backface-visibility: hidden;"></div>

                                        </div>

                                        <div class="row" style="backface-visibility: hidden;">
                                            <div class="col-lg-12" style="backface-visibility: hidden;">
                                                <span id="salesspark-chart" class="spark_line" style="backface-visibility: hidden;"><canvas width="358" height="48" style="display: inline-block; width: 358px; height: 48px; vertical-align: top;"></canvas></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">
                            <div id="top_widget3" style="perspective: 486.164px; position: relative; transform-style: preserve-3d;">
                                <div class="front" style="backface-visibility: hidden; transform-style: preserve-3d; position: absolute; z-index: 1; height: 100%; width: 100%; transition: all 0.5s ease-out;">
                                    <div class="bg-warning p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-comments-o" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Leads</div>
                                        <div id="widget_countup3" style="backface-visibility: hidden;">{{$leads}}</div>
                                        <div class="tag-white " style="backface-visibility: hidden;">
                                            <span id="percent_count3" style="backface-visibility: hidden;">&nbsp; </span>
                                        </div>
                                        <div class="previous_font" style="backface-visibility: hidden;">&nbsp;test</div>
                                    </div>
                                </div>

                                <div class="back" style="backface-visibility: hidden; transform-style: preserve-3d; position: relative; z-index: 0; height: 100%; width: 100%; transform: rotateX(-180deg); transition: all 0.5s ease-out;">
                                    <div class="bg-white b_r_5 section_border" style="backface-visibility: hidden;">
                                        <div class="p-t-l-r-15" style="backface-visibility: hidden;">
                                            <div class="float-right m-t-5 text-warning" style="backface-visibility: hidden;">
                                                <i class="fa fa-comments-o" style="backface-visibility: hidden;"></i>
                                            </div>
                                            <div id="widget_countup32" style="backface-visibility: hidden;"></div>
                                            <div style="backface-visibility: hidden;"></div>
                                        </div>

                                        <div class="row" style="backface-visibility: hidden;">
                                            <div class="col-lg-12" style="backface-visibility: hidden;">
                                                <span id="mousespeed" class="spark_line" style="backface-visibility: hidden;"><canvas style="display: inline-block; width: 337.955px; height: 48px; vertical-align: top;" width="337" height="48"></canvas></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="vert-offset-bottom-1 col-12 col-sm-6 col-xl-3">
                            <div id="top_widget4" style="perspective: 489.802px; position: relative; transform-style: preserve-3d;">
                                <div class="front" style="backface-visibility: hidden; transform-style: preserve-3d; position: absolute; z-index: 1; height: 100%; width: 100%; transition: all 0.5s ease-out;">
                                    <div class="bg-danger p-d-15 b_r_5" style="backface-visibility: hidden;">
                                        <div class="float-right m-t-5" style="backface-visibility: hidden;">
                                            <i class="fa fa-star-o" style="backface-visibility: hidden;"></i>
                                        </div>
                                        <div class="user_font" style="backface-visibility: hidden;">Sales</div>
                                        <div id="widget_countup4" style="backface-visibility: hidden;">{{$orders}}</div>
                                        <div class="tag-white" style="backface-visibility: hidden;">
                                            <span id="percent_count4" style="backface-visibility: hidden;"></span>
                                        </div>
                                        <div class="previous_font" style="backface-visibility: hidden;">Shopping Cart Orders</div>
                                    </div>
                                </div>

                                <div class="back" style="backface-visibility: hidden; transform-style: preserve-3d; position: relative; z-index: 0; height: 100%; width: 100%; transform: rotateX(-180deg); transition: all 0.5s ease-out;">
                                    <div class="bg-white section_border b_r_5" style="backface-visibility: hidden;">
                                        <div class="p-t-l-r-15" style="backface-visibility: hidden;">
                                            <div class="float-right m-t-5 text-danger" style="backface-visibility: hidden;">
                                                <i class="fa fa-star-o" style="backface-visibility: hidden;"></i>
                                            </div>

                                            <div id="widget_countup42" style="backface-visibility: hidden;"></div>
                                            <div style="backface-visibility: hidden;"></div>
                                        </div>
                                        <div class="row" style="backface-visibility: hidden;">
                                            <div class="col-lg-12" style="backface-visibility: hidden;">
                                                <span id="rating" class="spark_line" style="backface-visibility: hidden;"><canvas width="362" height="50" style="display: inline-block; width: 362px; height: 50px; vertical-align: top;"></canvas></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

            </div>
        </div>

        <div class="row">
        	<div class="col-md-10 col-md-offset-1">
        		
        	</div>
        </div>

		

<script type="text/javascript" src="{{asset('/forestFiles/js/chartist.min.js')}}"></script>


@endsection

@section('footer_scripts')
@endsection
