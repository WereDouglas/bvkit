<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>BV KIT</title>
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/>
        <?php require_once(APPPATH . 'views/css-page.php'); ?>
    </head>
    <body class="light_theme   fixed_header left_nav_fixed">
        <div class="wrapper">
            <!--\\\\\\\ wrapper Start \\\\\\-->
            <?php require_once(APPPATH . 'views/top-bar.php'); ?>
            <!--\\\\\\\ header end \\\\\\-->
            <div class="inner">
                <!--\\\\\\\ inner start \\\\\\-->
                <?php require_once(APPPATH . 'views/left-menu.php'); ?>
                <!--\\\\\\\left_nav end \\\\\\-->
                <div class="contentpanel">
                    <!--\\\\\\\ contentpanel start\\\\\\-->
                    <script language="javascript" type="text/javascript">
                        function resizeIframe(obj) {
                            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                            // obj.style.width = obj.contentWindow.document.body.scrollHeight + 'px';
                        }
                    </script>
                    <iframe id="frame" name="frame" frameborder="no" border="0" onload="resizeIframe(this)" scrolling="no"  style="padding: 10px; min-height:600px;" width="100%" class="span12" src="<?php echo base_url() . "index.php/home/start"; ?>"> </iframe>         

                </div>
                <!--\\\\\\\ content panel end \\\\\\-->
            </div>
            <!--\\\\\\\ inner end\\\\\\-->
        </div>
        <!--\\\\\\\ wrapper end\\\\\\-->
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style=" width: 70%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">New diagnostic session</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div id="container">
                            </div>
                        </div>

                        <form id="station-form" parsley-validate novalidate role="form" class="form-horizontal" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/diagnosis/create'  method="post">

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
                            <?php } else { ?>
                                <div class="alert col-sm-12">
                                    <h5>Please initialise a session</h5>
                                    <div class="form-group">
                                        <input type="hidden" placeholder="Metric used" required name="patient" value="<?php echo $this->session->userdata('patientID'); ?>"  class="form-control"/>


                                        <a href="#"  value=""  id="myLink" onclick="NavigateToSite(this)" class="tooltip-error btn btn-success" data-rel="tooltip" title="initialize session">

                                            Initialise

                                        </a>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="alert col-sm-6">
                                <div class="form-group">

                                    <div class="col-sm-10">
                                        <label >Select diagnosis type</label>
                                        <select class="form-control" id="type" name="type">                     
                                            <option value="Bacteria">Urine pH</option>
                                            <option value="Specific gravity">Specific gravity</option>
                                            <option value="Temperature">Temperature</option>
                                            <option value="Blood">Blood(Coming soon)</option>
                                            <option value="Protein">Protein(Coming soon)</option>
                                            <option value="Glucose">Glucose(Coming soon)</option>
                                            <option value="Ketones">Ketones(Coming soon)</option>
                                            <option value="Nitrites">Nitrites(Coming soon)</option>
                                            <option value="Leukocytes esterase">Leukocytes esterase(Coming soon)</option>
                                            <option value="Bilirubin">Bilirubin(Coming soon)</option>
                                            <option value="Urobilirubin">Urobilirubin(Coming soon)</option>
                                            <option value="Weight">Weight of patient</option>
                                            <option value="Height">Height</option>
                                        </select>
                                    </div><!--/col-sm-9--> 
                                </div><!--/form-group--> 
                                <div class="form-group">

                                    <div class="col-sm-10">
                                        <input type="text" name="qty" placeholder="Quantity" required class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <label>Metric</label>
                                        <select class="form-control" id="metric" name="metric">                     
                                            <option value="mL">mL</option>
                                            <option value="cm3">cm3</option>
                                            <option value="m3">m3</option>
                                            <option value="kg/m3">Kg/m3</option>
                                            <option value="Kg">Kg</option>
                                            <option value="A">A</option>
                                            <option value="mg">mg</option>
                                            <option value="g">g</option>
                                            <option value="C">C</option>
                                            <option value="L">L</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label>Patient Observations</label>
                                        <textarea class="form-control" name="patientNotes"></textarea>
                                    </div>
                                </div><!--/form-group--> 

                            </div>
                            <div class="alert col-sm-6">


                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <label >Medical deductions</label>
                                        <textarea class="form-control" name="medicalNotes"></textarea>
                                    </div>
                                </div><!--/form-group--> 
                                <div class="form-group">

                                    <div class="col-sm-10">
                                        <input type="text" name="results" placeholder="Results" required class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col-md-10 ">
                                        <input type="text" value="" size="16" name="next" id="next" class="form-control form-control-inline input-medium default-date-picker"/>
                                        <label class="control-label">Next appointment</label>
                                    </div>
                                </div><!--/form-group--> 
                                <div class="form-group">
                                    <div class=" col-sm-10">
                                        <button class="btn btn-default pull-right" type="submit">SUBMIT</button>

                                    </div>
                                </div>

                            </div>                          

                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>
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

