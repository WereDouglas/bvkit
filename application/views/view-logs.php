<?php require_once(APPPATH . 'views/css-page.php'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>/js/jquery.js"></script>

<script>
    $(function () {
        $('#container').highcharts({
            title: {
                text: 'Session readings from Device',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: ['1', '2', '3', '4', '5', '6',
                    '7', '8', '9', '10', '11', '12']
            },
            yAxis: {
                title: {
                    text: 'Values'
                },
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                    name: 'Your readings',
                    data: [<?php
if (is_array($logs) && count($logs)) {
    foreach ($logs as $loop) {
        echo $loop->value . ",";
    }
}
?>]
                }, {
                    name: 'average readings',
                    data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                }, {
                    name: 'Sexually active',
                    data: [7.1, 7.1, 7.1, 8.5, 7.1, 7.1, 8, 8, 7.1, 7.1, 7.1, 7.1]
                }

            ]
        });
    });
</script>

</head>

<script src="<?php echo base_url() ?>/js/highcharts.js"></script>
<script src="<?php echo base_url() ?>/js/modules/exporting.js"></script>

<div class="page-content">
    <div class="col-md-12">
        <div id="container">
        </div>

    </div>

</div>

