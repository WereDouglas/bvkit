<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>BV KIT</title>
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/>
        <?php require_once(APPPATH . 'views/css-page.php'); ?>
    </head>
    <body class="light_theme   fixed_header left_nav_fixed">

        <div class="col-md-12">
             <?php if ($this->session->userdata('physicianID') != "") { ?>
                                <div class="alert col-sm-12">
                                    <h5>Please select patient and initialise a session</h5>
                                    <div class="form-group">
                                        <input class="easyui-combobox" name="patient" id="patient" style="width:100%;"  data-options="
                                               url:'<?php echo base_url() ?>index.php/patient/listing',
                                               method:'get',
                                               valueField:'patientID',
                                               textField:'name',
                                               multiple:false,
                                               panelHeight:'auto'
                                               "/>

                                        <a href="#"  value=""  id="myLink" onclick="NavigateToSite(this)" class="tooltip-error btn btn-success" data-rel="tooltip" title="initialize session">

                                            Initialise

                                        </a>
                                    </div>
                                </div>
                            <?php }?>
            <div id="container">
            </div>
        </div>
        <!-- sidebar chats -->
        <?php require_once(APPPATH . 'views/side-chat.php'); ?>
        <!-- /sidebar chats -->

        <?php require_once(APPPATH . 'views/js-page.php'); ?>

    </body>
</html>



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

<script>

    function NavigateToSite(ele) {
        //var selectedVal = $(".patient").val();
        var selectedVal = document.getElementsByName("patient")[0].value;

        console.log(selectedVal);
        //var selectedVal = document.getElementById("myLink").getAttribute('value');
        //href= "index.php/patient/add_user/'
        $.post("<?php echo base_url() ?>index.php/patient/session", {
            patientID: selectedVal

        }, function (response) {
            alert(response);
        });

    }

</script>

