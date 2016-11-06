
<?php require_once(APPPATH . 'views/inner-css.php'); ?>
<style>
    body {
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 13px;
        background-color:#FFFFFF;
    }   

</style>
<style type="text/css" media="screen">

    table{
        border-collapse:collapse;
        border:1px solid #ccc;
    }

    table td{
        border:0px solid #ccc;
        padding: 5px;
    }

    table tr{
        border:1px solid #ccc;
    }
</style>
<div class="col-md-12 col-sm-12 col-xs-12"> <span class="info-box status col-md-12 col-sm-12 col-xs-12" id="status"></span></div>

<div class="col-xs-12">
    <section >
        <div class="profile-user-info profile-user-info-striped col-md-3">

            <?php
            if (is_array($user) && count($user)) {
                foreach ($user as $loop) {
                    $id = $loop->id;
                    $fname = $loop->fname;
                    $lname = $loop->lname;
                    $other = $loop->other;
                    $email = $loop->email;
                    $gender = $loop->gender;
                    $dob = $loop->dob;
                    $country = $loop->country;
                    $image = $loop->image;
                    $password = $loop->password;
                    $cohort = $loop->cohort;
                    $contact = $loop->contact;
                }
            }
            ?>
            <div class="span3 center">
                <span class="profile-picture">
                    <img id="avatar" height="100px" width="120px" class="editable" alt="<?php echo $fname; ?>" src="<?= base_url(); ?>uploads/<?= $image ?>" />
                </span>
                <form  enctype="multipart/form-data" class="form-horizontal form-label-left"  action='<?= base_url(); ?>index.php/student/update_image'  method="post">                                       

                    <div class="form-group">
                        <input type="file"  class="form-control" name="userfile" id="userfile" />
                    </div>  
                    <div class="form-group">
                        <div id="imagePreview" ></div> 
                    </div>                
                    <input type="hidden" class="form-control" name="userID" id="userID" value="<?php echo $id; ?>" />                                                   
                    <input type="hidden" name="namer" id="namer" value="<?php echo $fname . $lname; ?>" />
                    <button id="send"  class="btn btn-default" type="submit" >Update picture</button>


                </form>
            </div>

            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->

        <?php
        if (is_array($user) && count($user)) {
            foreach ($user as $loop) {
                $id = $loop->id;
                $fname = $loop->fname;
                $lname = $loop->lname;
                $other = $loop->other;
                $email = $loop->email;
                $gender = $loop->gender;
                $dob = $loop->dob;
                $country = $loop->country;

                $image = $loop->image;
                $password = $loop->password;
                $cohort = $loop->cohort;
                $contact = $loop->contact;
                $submitted = $loop->submitted;
                ?>  


                <?php
            }
        }
        ?>



        <table class="table zebra-style span8">

            <tbody>


                <?php
                if (is_array($user) && count($user)) {
                    foreach ($user as $loop) {
                        ?>  

                        <tr class="odd">
        <!--                            <td><?php echo $loop->id; ?></td>-->

                        </tr>
                        <tr>
                            <td>NAME:</td>
                            <td id="fname:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->name; ?></td>

                            <td></td>
                            <td></td>

                        </tr>
                      
                       
                        <tr>

                            <td>CONTACT:</td>
                            <td id="contact:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->contact; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>EMAIL:</td>
                            <td id="email:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->email; ?></td>

                            <td></td>
                            <td></td>
                        </tr>
                        <tr>

                            <td>DATE OF BIRTH:</td>
                            <td id="dob:<?php echo $loop->id; ?>" contenteditable="true"><?php echo $loop->dob; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>PASSWORD REST</td>
                            <td>

                                <a href="<?php echo base_url() . "index.php/student/reset/" . $loop->id; ?>" class="tooltip-info qualification" data-rel="tooltip" title="verify">
                                    <span class="red">
                                        <i class="icon-lock bigger-120 text-danger"></i>Reset   </span>
                                </a>


                            </td>
                            <td></td>
                            <td></td>
                        </tr> 
                        <tr>
                            <td> 
                                <h4>Change password</h4>

                            </td>
                            <td>
                                <form id="identicalForm"  enctype="multipart/form-data" class="form-horizontal form-label-left"  action='<?= base_url(); ?>index.php/student/update_password'  method="post">                                       

                                    <div class="form-group">
                                        <label for="email">Password:</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" />                                                   

                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Confirm password:</label>
                                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm password" value="" />

                                    </div> 
                                    <input type="hidden" name="userID" id="userID" value="<?php echo $id; ?>" />     
                                    <button id="send" class="btn btn-default" type="submit" >Change password</button>
                                </form>
                            </td>
                            <td></td>
                            <td></td>
                        </tr> 
                        <tr>
                            <td>   

                            </td>
                            <td>

                            </td>
                            <td></td>
                            <td></td>
                        </tr> 


                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
        <br>
        </div>


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
                        $.post('<?php echo base_url() . "index.php/patient/user/"; ?>', field_id + "=" + value, function (data) {
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
