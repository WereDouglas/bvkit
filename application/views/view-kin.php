
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
                    <h3 class="content-header">NEXT OF KIN</h3>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                   <div class="alert alert-info" id="status"></div>
                <div class="porlets-content">
                 
                  
                    <div class="table-responsive scroll">
                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th class="hidden-phone">Contact</th>
                                    <th class="hidden-phone">Relationship</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($kins) && count($kins)) {
                                    foreach ($kins as $loop) {
                                        ?>  
                                        <tr class="odd">
                                            <td> 
                                                <?php
                                                if ($loop->image != "") {
                                                    ?>
                                                    <img  height="50px" width="50px"  src="<?= base_url(); ?>uploads/<?php echo $loop->image; ?>"  />
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img  height="50px" width="50px"  src="<?= base_url(); ?>images/user_place.png"  />
                                                    <?php
                                                }
                                                ?>
                                            </td>

                                            <td id="name:<?php echo $loop->kinID; ?>" contenteditable="true">
                                                <?php echo $loop->name; ?>
                                            </td>
                                            <td id="email:<?php echo $loop->kinID; ?>" contenteditable="true"><?php echo $loop->email; ?></td>

                                            <td id="contact:<?php echo $loop->kinID; ?>" contenteditable="true"><?php echo $loop->contact; ?></td>
                                            <td id="relationship:<?php echo $loop->kinID; ?>" contenteditable="true"><?php echo $loop->relationship; ?></td>


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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add New Kin</h4>
            </div>
            <div class="modal-body"> 

                <form id="station-form" parsley-validate novalidate role="form" class="form-horizontal" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/kin/create'  method="post">

                    <div class="form-group">

                        <div class="col-sm-10">
                            <input type="text" name="name" placeholder="Full Name" required class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" placeholder="Email"   name="email"  class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="number" required  placeholder="Contact" parsley-type="number" name="contact" required  class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-sm-10">
                            <label>Relationship</label> 
                            <input type="text" value="" size="16" class="form-control" name="relationship"/>

                        </div>
                    </div><!--/form-group--> 


                    <div class="item form-group">                    
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">Profile picture</label>  
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" name="userfile" id="userfile" class="btn-default btn-small"/>
                            <div id="imagePreview" ></div>      
                        </div>
                    </div>

                    <div class="form-group">
                        <div class=" col-sm-10">
                            <div class="checkbox checkbox_margin">
                                <label class="lable_margin">

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
                $.post('<?php echo base_url() . "index.php/kin/updater/"; ?>', field_id + "=" + value, function (data) {
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
<script type="text/javascript">
                                $(function () {
                                    $("#userfile").on("change", function ()
                                    {
                                        var files = !!this.files ? this.files : [];
                                        if (!files.length || !window.FileReader)
                                            return; // no file selected, or no FileReader support

                                        if (/^image/.test(files[0].type)) { // only image file
                                            var reader = new FileReader(); // instance of the FileReader
                                            reader.readAsDataURL(files[0]); // read the local file

                                            reader.onloadend = function () { // set image data as background of div
                                                $("#imagePreview").css("background-image", "url(" + this.result + ")");
                                            }
                                        }
                                    });
                                });
        </script>
