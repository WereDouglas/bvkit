<!-- Bootstrap -->
<link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="<?php echo base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!-- NProgress -->
<link href="<?php echo base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
<!-- FullCalendar -->
<link href="<?php echo base_url(); ?>vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>vendors/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">

<!-- Custom styling plus plugins -->
<link href="<?php echo base_url(); ?>build/css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url(); ?>css/mine.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/easyui.css?date=<?php echo date('Y-m-d') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/icon.css?date=<?php echo date('Y-m-d') ?>">
<div class="row container">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- page content -->

        <div class="page-title">
            <div class="title_left">
                <h3>Calendar <small>Click to add/edit events</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="x_content">

            <div id='calendar'></div>

        </div>

        <!-- /page content -->
    </div>

</div>
<div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
            </div>
            <div class="modal-body">
                <div id="testmodal" style="padding: 5px 20px;">
                    <form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/task/create'  method="post">
                        <div class="span12">
                            <div class="row-fluid">
                                <label for="timepicker1">Date</label>
                            </div>
                            <div class="control-group">
                                <input name="date" id="date" type="text" />
<!--                                <input class="easyui-datebox form" name="date" id="starts" width="100px" data-options="formatter:myformatter,parser:myparser" ></input>-->

                            </div>
                            <div class="row-fluid">
                                <label for="form-field-select-4">Choose Attendees</label>



                                <input class="easyui-combobox" name="attend[]" style="width:100%;height:26px" data-options="
                                       url:'<?php echo base_url() ?>index.php/task/users',
                                       method:'get',
                                       valueField:'userID',
                                       textField:'name',

                                       multiple:true,
                                       panelHeight:'auto'
                                       ">
                            </div>
                            <div class="row-fluid">
                                <label for="form-field-select-4">Choose File</label>

                                <input class="easyui-combobox" name="file" style="width:100%;height:26px" data-options="
                                       url:'<?php echo base_url() ?>index.php/task/files',
                                       method:'get',
                                       valueField:'fileID',
                                       textField:'name',
                                       multiple:false,
                                       panelHeight:'auto'
                                       ">
                            </div>

                            <label>
                                <input name="trig" type="checkbox" />
                                <span class="lbl"> Notify parties ?</span>
                            </label>

                            <div class="row-fluid">
                                <label for="timepicker1">Start Time</label>
                            </div>

                            <div class="control-group">
                                <input class="easyui-timespinner" name="startTime" value="01:20" style="width:100%;height:26px">
                            </div>

                            <div class="row-fluid">
                                <label for="timepicker1">End Time</label>
                            </div>

                            <div class="control-group">
                                <input class="easyui-timespinner" name="endTime" value="14:45" style="width:100%;height:26px">
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-field-1">Number of days</label>
                                <div class="control-group">
                                    <input class="form-control" type="text" name="period" value="1"  />
                                </div>

                                <div class="form-group"> 
                                    <label class="control-label" for="form-field-1">Details</label>
                                    <div class="control-group">
                                        <textarea  class="form-control" name="details" class="" placeholder="details" ></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label>Priority</label>
                                    <select class="form-control" id="priority" name="priority" >                                                         
                                        <option value="High" >High</option>
                                        <option value="Medium" >Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit changes</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel2">Edit Calendar Entry</h4>
            </div>
            <div class="modal-body">

                <div id="testmodal2" style="padding: 5px 20px;">
                    <form id="antoform2" class="form-horizontal calender" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title2" name="title2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" style="height:55px;" id="descr2" name="descr"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary antosubmit2">Submit</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
<div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>

<script src="<?php echo base_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="<?php echo base_url(); ?>vendors/nprogress/nprogress.js"></script>
<!-- FullCalendar -->
<script src="<?php echo base_url(); ?>vendors/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>vendors/fullcalendar/dist/fullcalendar.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="<?php echo base_url(); ?>build/js/custom.min.js"></script>
<script src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>-->
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.easyui.min.js"></script>

<!-- FullCalendar -->
<script>
    $(window).load(function () {
        var date = new Date(),
                d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear(),
                started,
                categoryClass;

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                $('#fc_create').click();

                started = start;
                ended = end;
                var allDay = !start.hasTime() && !end.hasTime();
                $("#date").val(moment(start).format("YYYY-MM-DD"));

                $(".antosubmit").on("click", function () {
                    var title = $("#title").val();
                    if (end) {
                        ended = end;
                    }

                    categoryClass = $("#event_type").val();

                    if (title) {
                        calendar.fullCalendar('renderEvent', {
                            title: title,
                            start: started,
                            end: end,
                            allDay: allDay
                        },
                                true // make the event "stick"
                                );
                    }

                    $('#title').val('');

                    calendar.fullCalendar('unselect');

                    $('.antoclose').click();

                    return false;
                });
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#fc_edit').click();
                $('#title2').val(calEvent.title);

                categoryClass = $("#event_type").val();

                $(".antosubmit2").on("click", function () {
                    calEvent.title = $("#title2").val();

                    calendar.fullCalendar('updateEvent', calEvent);
                    $('.antoclose2').click();
                });

                calendar.fullCalendar('unselect');
            },
            editable: true,
            events: [<?php

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    if (is_array($sch)) {
        foreach ($sch as $loop) {
            $mydate = $loop->date;
            $prior = $loop->priority;
            $days = $loop->period;

            $informations = 'START:' . $loop->startTime . ':' . clean($loop->detail);

            $d = (int) date("d", strtotime($mydate));
            $m = (int) date("m", strtotime($mydate)) - 1;
            $y = (int) date("Y", strtotime($mydate));

            switch ($prior) {
                case High:
                    $className = 'label-important';
                    break;
                case Medium:
                    $className = 'label-success';
                    break;
                case Low:
                    $className = 'label-grey';
                    break;
                case File:
                    $className = 'label-blue';
                    break;
            }

            if (is_array($att)) {
                foreach ($att as $val) {
                    if ($val->taskID == $loop->taskID) {

                        if (is_array($users)) {
                            foreach ($users as $user) {
                                if ($user->userID == $val->userID) {
                                    $information .= 'Att:';
                                    $information .= $user->name . ' ';
                                }
                            }
                        }
                    }
                }
            }
            ?>
                        {
                            title: '<?php echo $informations . '-' . $loop->name . '-' . ' ' . $loop->contact . '-' . $loop->email; ?>',
                            start: new Date(<?php echo $y; ?>, <?php echo $m; ?>, <?php echo $d; ?>),
                            className: '<?php echo $className; ?>'

                        },
        <?php
    }
}
?>]
        });
    });
</script>
<script>
    $(document).ready(function () {

        $('.date-picker').datepicker().next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
        $('#id-date-range-picker-1').daterangepicker().prev().on(ace.click_event, function () {
            $(this).next().focus();
        });

        $('#timepicker1').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        })
        $('#colorpicker1').colorpicker();
        $('#simple-colorpicker-1').ace_colorpicker();

    });
</script>
<script type="text/javascript">


    function myformatter(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
    }
    function myparser(s) {
        if (!s)
            return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var d = parseInt(ss[2], 10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(y, m - 1, d);
        } else {
            return new Date();
        }
    }

</script>



