<?php require_once(APPPATH . 'views/css-page.php'); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>/js/jquery.js"></script>

        <script>
            var chart; // global

            /**
             * Request data from the server, add it to the graph and set a timeout to request again
             */
            function requestData() {
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/logs/data',
                    success: function (point) {
                        var series = chart.series[0],
                                shift = series.data.length > 20; // shift if the series is longer than 20

                        // add the point
                        chart.series[0].addPoint(eval(point), true, shift);

                        // call it again after one second
                        setTimeout(requestData, 1000);
                    },
                    cache: false
                });
            }

            $(document).ready(function () {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        defaultSeriesType: 'spline',
                        events: {
                            load: requestData
                        }
                    },
                    title: {
                        text: 'Analysis levels'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150,
                        maxZoom: 20 * 1000
                    },
                    yAxis: {
                        minPadding: 0.2,
                        maxPadding: 0.2,
                        title: {
                            text: 'Value',
                            margin: 80
                        }
                    },
                    series: [{
                            name: 'Diagnosis data',
                            data: []
                        }]
                });
            });
        </script>
        <script>
            var chart2; // global

            /**
             * Request data from the server, add it to the graph and set a timeout to request again
             */
            function requestData2() {
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/logs/data',
                    success: function (point) {
                        var series = chart2.series[0],
                                shift = series.data.length > 20; // shift if the series is longer than 20

                        // add the point
                        chart2.series[0].addPoint(eval(point), true, shift);

                        // call it again after one second
                        setTimeout(requestData2, 1000);
                    },
                    cache: false
                });
            }

            $(document).ready(function () {
                chart2 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container2',
                        defaultSeriesType: 'spline',
                        events: {
                            load: requestData2
                        }
                    },
                    title: {
                        text: 'Temperature levels'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150,
                        maxZoom: 20 * 1000
                    },
                    yAxis: {
                        minPadding: 0.2,
                        maxPadding: 0.2,
                        title: {
                            text: 'Temperature',
                            margin: 80
                        }
                    },
                    series: [{
                            name: 'Diagnosis data',
                            data: []
                        }]
                });
            });
        </script>
    </head>
  
        <script src="<?php echo base_url() ?>/js/highcharts.js"></script>
        <script src="<?php echo base_url() ?>/js/modules/exporting.js"></script>
        <style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 13px;
        background-color:#FFFFFF;
    }   

</style>
<div class="page-content">
        <div class="col-md-12">
            <div id="container">
            </div>

        </div>
        <div class="col-md-6">
            <div id="container2" ></div>
        </div>
</div>

