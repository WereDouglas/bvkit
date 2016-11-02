
<?php require_once(APPPATH . 'views/inner-css.php'); ?>
<style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 13px;
        background-color:#FFFFFF;
    }   

</style>
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                    <a href="javascript:void(0);" class="add_user" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-square"></i> <span> New</span> </a>
                    <h3 class="content-header">ANALYSIS</h3>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <div class="alert alert-info" id="status"></div>
                <div class="porlets-content">

                    <div class="table-responsive scroll">
                        <table  class="display table table-bordered table-striped scroll" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th class="hidden-phone">Date</th>
                                    <th>Patient</th>
                                    <th>Contact</th>
                                    <th>Diagnostic type</th>
                                    <th>Metric</th>
                                    <th class="hidden-phone">Quantity</th>
                                    <th class="hidden-phone">Symptoms/signs</th>
                                    <th class="hidden-phone">Status</th>
                                    <th class="hidden-phone">Deduction</th>
                                    <th class="hidden-phone">Conclusion</th>
                                    <th class="hidden-phone">Physician notes</th>
                                    <th class="hidden-phone">Physician</th>                                  
                                    <th class="hidden-phone">Results</th>
                                    <th class="hidden-phone">Next</th>                                   
                                    <th class="hidden-phone">View</th>
                                    <th class="hidden-phone">Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($analysis) && count($analysis)) {
                                    foreach ($analysis as $loop) {
                                        ?>  
                                        <tr class="odd">
                                            <td> 
                                                <?php echo $loop->stamp; ?>
                                            </td>
                                            <td> 
                                                <?php echo $loop->name; ?>
                                            </td>
                                            <td> 
                                                <?php echo $loop->contact; ?>
                                            </td>
                                            <td> 
                                                <?php echo $loop->type; ?>
                                            </td>
                                            <td> 
                                                <?php echo $loop->metric; ?>
                                            </td>
                                            <td> 
                                                <?php echo $loop->qty; ?>
                                            </td>
                                            <td id="symptoms:<?php echo $loop->ID; ?>" contenteditable="true">
                                                <?php echo $loop->symptoms; ?>
                                            </td>
                                            <td id="status:<?php echo $loop->ID; ?>" contenteditable="true">
                                                <?php echo $loop->status; ?>
                                            </td>
                                            <td id="deduction:<?php echo $loop->ID; ?>" contenteditable="true">
                                                <?php echo $loop->deduction; ?>
                                            </td>
                                            <td id="conclusion:<?php echo $loop->ID; ?>" contenteditable="true">
                                                <?php echo $loop->conclusion; ?>
                                            </td>

                                            <td id="medicalNotes:<?php echo $loop->ID; ?>" contenteditable="true">
                                                <?php echo $loop->medicalNotes; ?>
                                            </td>
                                            <td> 
                                                <?php echo $loop->physician; ?>
                                            </td>

                                            <td id="results:<?php echo $loop->ID; ?>" contenteditable="true"><?php echo $loop->results; ?></td>

                                            <td id="next:<?php echo $loop->ID; ?>" contenteditable="true"><?php echo $loop->next; ?></td>


                                            <td class="edit_td">
                                                <a class="btn btn-primary btn-xs" href="<?php echo base_url() . "index.php/diagnosis/details/" . $loop->sessionID;
                                        ;
                                                ?>"><li class="fa fa-folder">View</li></a>

                                            </td> 
                                            <td class="center">
                                                <a class="btn btn-danger btn-xs" href="<?php echo base_url() . "index.php/diagnosis/delete/" . $loop->sessionID;
                                           ;
                                           ?>"><li class="fa fa-trash">Delete</li></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody>

                        </table>
                    </div><!--/table-responsive-->
                </div><!--/porlets-content-->
            </div><!--/block-web--> 
        </div><!--/col-md-12--> 
    </div><!--/row-->           
</div><!--/page-content end--> 
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Initalize</h4>
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


<!-- /sidebar chats -->  
<?php require_once(APPPATH . 'views/inner-js.php'); ?>
<script>
    $(document).ready(function () {
        $("#status").hide();
        $(function () {
            //acknowledgement message
            var message_status = $("#status");
            $("td[contenteditable=true]").blur(function () {
                var field_id = $(this).attr("id");
                var value = $(this).text();
                $.post('<?php echo base_url() . "index.php/diagnosis/updater/"; ?>', field_id + "=" + value, function (data) {
                    if (data != '')
                    {
                        message_status.show();
                        message_status.text(data);
                        //hide the message
                        setTimeout(function () {
                            message_status.hide()
                        }, 4000);
                    }
                });
            });

        });
    });
</script>

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
