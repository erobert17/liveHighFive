    <link rel="stylesheet" href="{{asset('/forestFiles/css/components.css')}}" />
    <link rel="stylesheet" href="{{asset('/forestFiles/css/custom.css')}}" />
    <!-- end of global styles-->
    <link rel="stylesheet" href="{{asset('/forestFiles/css/chartist.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/forestFiles/css/jquery.circliful.css')}}">
    <link rel="stylesheet" href="{{asset('/forestFiles/css/index.css')}}">

<style type="text/css">
    body{
    position: fixed;
    width: 100%;
    height: 100%;
    }

</style>
<div class="container">
    <div class="row widget_countup">
                        
                        <div class="col-12 col-sm-6 col-xl-3">

                            <div id="top_widget1">
                                <div class="front">
                                    <div class="bg-primary p-d-15 b_r_5">
                                        <div class="float-right m-t-5">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="user_font">Users</div>
                                        <div id="widget_countup1">{{$countPages}}</div>
                                        <div class="tag-white">
                                            <span id="percent_count1">85</span>%
                                        </div>
                                        <div class="previous_font">Yearly Users stats</div>
                                    </div>
                                </div>
                                <div class="back">
                                    <div class="bg-white b_r_5 section_border">
                                        <div class="p-t-l-r-15">
                                            <div class="float-right m-t-5">
                                                <i class="fa fa-users text-primary"></i>
                                            </div>
                                            <div id="widget_countup12">{{$countPages}}</div>
                                            <div>Users</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span id="visitsspark-chart" class="spark_line"></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3 media_max_573">
                            <div id="top_widget2">
                                <div class="front">
                                    <div class="bg-success p-d-15 b_r_5">
                                        <div class="float-right m-t-5">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="user_font">Sales</div>
                                        <div id="widget_countup2">1,140</div>
                                        <div class="tag-white">
                                            <span id="percent_count2">60</span>%
                                        </div>
                                        <div class="previous_font">Sales per month</div>
                                    </div>
                                </div>

                                <div class="back">
                                    <div class="bg-white b_r_5 section_border">
                                        <div class="p-t-l-r-15">
                                            <div class="float-right m-t-5 text-success">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                            <div id="widget_countup22">1,140</div>
                                            <div>Sales</div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span id="salesspark-chart" class="spark_line"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 media_max_1199">
                            <div id="top_widget3">
                                <div class="front">
                                    <div class="bg-warning p-d-15 b_r_5">
                                        <div class="float-right m-t-5">
                                            <i class="fa fa-comments-o"></i>
                                        </div>
                                        <div class="user_font">Comments</div>
                                        <div id="widget_countup3">85</div>
                                        <div class="tag-white ">
                                            <span id="percent_count3">30</span>%
                                        </div>
                                        <div class="previous_font">Monthly comments</div>
                                    </div>
                                </div>

                                <div class="back">
                                    <div class="bg-white b_r_5 section_border">
                                        <div class="p-t-l-r-15">
                                            <div class="float-right m-t-5 text-warning">
                                                <i class="fa fa-comments-o"></i>
                                            </div>
                                            <div id="widget_countup32">85</div>
                                            <div>Comments</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span id="mousespeed" class="spark_line"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 media_max_1199">
                            <div id="top_widget4">
                                <div class="front">
                                    <div class="bg-danger p-d-15 b_r_5">
                                        <div class="float-right m-t-5">
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="user_font">Rating</div>
                                        <div id="widget_countup4">8</div>
                                        <div class="tag-white">
                                            <span id="percent_count4">80</span>%
                                        </div>
                                        <div class="previous_font">This month ratings </div>
                                    </div>
                                </div>

                                <div class="back">
                                    <div class="bg-white section_border b_r_5">
                                        <div class="p-t-l-r-15">
                                            <div class="float-right m-t-5 text-danger">
                                                <i class="fa fa-star-o"></i>
                                            </div>

                                            <div id="widget_countup42">8</div>
                                            <div>Rating</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span id="rating" class="spark_line"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

    </div>
</div>


<script src="{{asset('/forestFiles/js/components.js')}}"></script>
<script src="{{asset('/forestFiles/js/custom.js')}}"></script>
<!--end of global scripts-->
<!--  plugin scripts -->
<script src="{{asset('/forestFiles/js/countUp.min.js')}}"></script>
<script src="{{asset('/forestFiles/js/jquery.flip.min.js')}}"></script>
<script src="{{asset('/forestFiles/js/jquery.sparkline.js')}}"></script>
<script src="{{asset('/forestFiles/js/chartist.min.js')}}"></script>
<script src="{{asset('/forestFiles/js/chartist-tooltip.js')}}"></script>
<script src="{{asset('/forestFiles/js/swiper.min.js')}}"></script>
<script src="{{asset('/forestFiles/js/jquery.circliful.min.js')}}"></script>
<script src="{{asset('/forestFiles/js/jquery.flot.js')}}" ></script>
<script src="{{asset('/forestFiles/js/jquery.flot.resize.js')}}"></script>
<!--end of plugin scripts-->

<script type="text/javascript">
    "use strict";
$(document).ready(function() {
    $("#visitsspark-chart").sparkline([209, 210, 209, 210, 210, 211, 212, 210, 210, 211, 213, 212, 211, 210, 212, 211, 210, 212], {
        type: 'line',
        width: '100%',
        height: '48',
        lineColor: '#4fb7fe',
        fillColor: '#e7f5ff',
        tooltipSuffix: 'Users'
    });
    function spark_sales() {
        var barParentdiv = $('#salesspark-chart').closest('div');
        var barCount = [209, 210, 209, 210, 210, 211, 212, 210, 210, 211, 213, 212, 211, 210, 212, 211, 210, 212];
        var barSpacing = 2;
        $("#salesspark-chart").sparkline(barCount, {
            type: 'bar',
            width: '100%',
            barWidth: (barParentdiv.width() - (barCount.length * barSpacing)) / barCount.length,
            height: '48',
            barSpacing: barSpacing,
            barColor: '#9bd5ff',
            tooltipSuffix: ' Sales'
        });
        $('#salesspark-chart').sparkline([209, 210, 209, 210, 210, 211, 212, 210, 210, 211, 213, 212, 211, 210, 212, 211, 210, 212],
            {
                composite: true,
                fillColor: false,
                width: "100%",
                spotColor: '#f0ad4e',
                lineColor: '#EF6F6C',
                tooltipSuffix: ' Sales'
            });

    }

    spark_sales();


    function spark_loader() {
        var lpoints = [];
        for (var i = 0; i < 20; i++) {
            var load = 5 + parseInt(Math.random() * 90 - 5);
            if (load < 25) {
                load = 25;
            }
            if (load > 100) {
                load = 90;
            }
            lpoints.push(load);
        }
        $('#mousespeed').sparkline(lpoints, {
            type: 'line',
            height: "48px",
            width: "100%",
            lineColor: '#4fb7fe',
            fillColor: '#e7f5ff',
            tooltipSuffix: ' Comments'
        });
        setTimeout(spark_loader, 1800);
    }

    spark_loader();


    function spark_sales1() {
        var barParentdiv = $('#rating').closest('div');
        var barCount = [1, 2, 3, 2, 5, 3, 5, 6, 5, 6, 5, 7, 8, 8, 6, 7, 4, 3, 5, 4, 2, 3, 5, 3, 2, 1];
        var barSpacing = 2;
        $("#rating").sparkline(barCount, {
            type: 'bar',
            width: '100%',
            barWidth: (barParentdiv.width() - (barCount.length * barSpacing)) / barCount.length,
            height: '50',
            barSpacing: barSpacing,
            barColor: '#9bd5ff',
            tooltipSuffix: ' Rating'
        });
    }

    spark_sales1();

//   flip js

    $("#top_widget1, #top_widget2, #top_widget3, #top_widget4").flip({
        axis: 'x',
        trigger: 'hover'
    });


    var options = {
        useEasing: true,
        useGrouping: true,
        decimal: '.',
        prefix: '',
        suffix: ''
    };
    new CountUp("widget_countup1", 0, {{$countPages}}, 0, 5.0, options).start();
    new CountUp("widget_countup2", 0, 1140, 0, 5.0, options).start();
    new CountUp("widget_countup3", 0, 85, 0, 7.0, options).start();
    new CountUp("widget_countup4", 0, 8, 0, 9.0, options).start();


//=================================main chart================================

// Chartist
    var Chartist1 = new Chartist.Line('#chart1', {
        labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        series: [{
            label: 'Views',
            data: [{meta: 'Views', value: 4},
                {meta: 'Views', value: 6},
                {meta: 'Views', value: 4},
                {meta: 'Views', value: 7},
                {meta: 'Views', value: 4},
                {meta: 'Views', value: 6},
                {meta: 'Views', value: 3},
                {meta: 'Views', value: 7},
                {meta: 'Views', value: 3},
                {meta: 'Views', value: 6},

                {meta: 'Views', value: 4},
                {meta: 'Views', value: 6}]
        },

            {
                label: 'Sales',
                data: [{meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 4},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 4},
                    {meta: 'Sales', value: 1},
                    {meta: 'Sales', value: 3}]
            }]
    }, {
        height: 300,
        fullWidth: true,
        low: 0,
        high: 7,
        showArea: true,
        axisY: {
            onlyInteger: true,
            offset: 20
        }
        ,
        plugins: [
            Chartist.plugins.tooltip()
        ]
    });

    Chartist1.on('draw', function (data) {


        if (data.type === 'point') {
            data.element.animate({
                y1: {
                    begin: 100 * data.index,
                    dur: 2000,
                    from: data.y + 1000,
                    to: data.y,
                    easing: Chartist.Svg.Easing.easeOutQuint
                },
                y2: {
                    begin: 100 * data.index,
                    dur: 2000,
                    from: data.y + 1000,
                    to: data.y,
                    easing: Chartist.Svg.Easing.easeOutQuint
                }
            });
        }

        if (data.type === 'line' || data.type === 'area') {
            data.element.animate({
                d: {
                    begin: 2000 * data.index,
                    dur: 2000,
                    from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                    to: data.path.clone().stringify(),
                    easing: Chartist.Svg.Easing.easeOutQuint
                }
            });
        }
    });


//===============================coding docs desingi=====================================

    $('#myStat').circliful({
        animationStep: 5,
        fillColor: '#4fb7fe',
        foregroundBorderWidth: 5,
        percent: 40
    });
    $('#myStat2').circliful({
        animationStep: 5,
        fillColor: '#00cc99',
        foregroundBorderWidth: 5,
        percent: 60
    });
    $('#myStat3').circliful({
        animationStep: 5,
        fillColor: '#ff9933',
        foregroundBorderWidth: 5,
        percent: 75
    });


    //server load
    var flot2 = function() {
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        var data = [],
            totalPoints = 100;

        function getRandomData() {
            if (data.length > 0)
                data = data.slice(1);
            // Do a random walk
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;
                if (y < 0) {
                    y = 0;
                } else if (y > 100) {
                    y = 100;
                }
                data.push(y);
            }
            // Zip the generated y values with the x values
            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }
            return res;
        }
        var plot2 = $.plot("#order_realtime", [getRandomData()], {
            series: {
                shadowSize: 0 // Drawing is faster without shadows
            },
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                show: false
            },
            colors: ["#22BAA0"],
            legend: {
                show: false
            },
            grid: {
                color: "#AFAFAF",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'},
            tooltip: true,
            tooltipOpts: {
                content: "Y: %y",
                defaultTheme: false
            }
        });

        function update() {
            plot2.setData([getRandomData()]);
            plot2.draw();
            setTimeout(update, 30);
        }
        update();
    };
    flot2();



    //server load
    var flot3 = function() {
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        var data = [],
            totalPoints = 100;

        function getRandomData() {
            if (data.length > 0)
                data = data.slice(1);
            // Do a random walk
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;
                if (y < 0) {
                    y = 0;
                } else if (y > 100) {
                    y = 100;
                }
                data.push(y);
            }
            // Zip the generated y values with the x values
            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }
            return res;
        }
        var plot3 = $.plot("#sale_realtime", [getRandomData()], {
            series: {
                shadowSize: 0 // Drawing is faster without shadows
            },
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                show: false
            },
            colors: ["#4fb7fe"],
            legend: {
                show: false
            },
            grid: {
                color: "#AFAFAF",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'},
            tooltip: true,
            tooltipOpts: {
                content: "Y: %y",
                defaultTheme: false
            }
        });

        function update() {
            plot3.setData([getRandomData()]);
            plot3.draw();
            setTimeout(update, 30);
        }
        update();
    };
    flot3();




    //server load
    var flot4 = function() {
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        var data = [],
            totalPoints = 100;

        function getRandomData() {
            if (data.length > 0)
                data = data.slice(1);
            // Do a random walk
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50,
                    y = prev + Math.random() * 10 - 5;
                if (y < 0) {
                    y = 0;
                } else if (y > 100) {
                    y = 100;
                }
                data.push(y);
            }
            // Zip the generated y values with the x values
            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }
            return res;
        }
        var plot4 = $.plot("#users_realtime", [getRandomData()], {
            series: {
                shadowSize: 0 // Drawing is faster without shadows
            },
            yaxis: {
                min: 0,
                max: 100
            },
            xaxis: {
                show: false
            },
            colors: ["#ff9933"],
            legend: {
                show: false
            },
            grid: {
                color: "#AFAFAF",
                hoverable: true,
                borderWidth: 0,
                backgroundColor: '#FFF'},
            tooltip: true,
            tooltipOpts: {
                content: "Y: %y",
                defaultTheme: false
            }
        });

        function update() {
            plot4.setData([getRandomData()]);
            plot4.draw();
            setTimeout(update, 30);
        }
        update();
    };
    flot4();
    // ==================================monthly up laod=================================

    $("#test-circle").circliful({
        animation: 1,
        animationStep: 1,
        foregroundBorderWidth: 15,
        backgroundBorderWidth: 15,
        percent: 75,
        textSize: 28,
        textStyle: 'font-size: 12px;',
        textColor: '#666',
        multiPercentage: 1,
        percentages: [10, 20, 30]
    });

    function spark_sales_upload() {
        var barParentdiv = $('#monthly_upload').closest('div');
        var barCount = [71, 72, 73, 72, 75, 73, 75, 76, 75, 76, 75, 77, 78, 78, 76, 77, 74, 73, 75, 74, 72, 73, 75, 74, 73, 72, 71];
        var barSpacing = 2;
        $("#monthly_upload").sparkline(barCount, {
            type: 'bar',
            width: '100%',
            barWidth: (barParentdiv.width() - (barCount.length * barSpacing)) / barCount.length,
            height: '50',
            barSpacing: barSpacing,
            barColor: '#4FB7FE',
            tooltipSuffix: '%'
        });
    }
    spark_sales_upload();

    $(window).on('resize', function () {
        Chartist1.update();
        spark_sales();
        spark_sales1();
        spark_sales_upload();

    });
});
</script>