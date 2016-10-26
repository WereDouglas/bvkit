<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>BVKIT</title>
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
            <link href="<?php echo base_url() ?>css/font-awesome.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url() ?>css/animate.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url() ?>css/mine.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="light_theme  fixed_header left_nav_fixed">
        <div class="wrapper">
            <div class="login_page">
                <div class="registration">
                    <div class="logo" ><span class="theme_color"><img src="<?php echo base_url() ?>images/bv.png" width="100" height="60" alt="s-logo" /></span></div>

                    <div class="panel-heading border login_heading">sign in</div>

                    <?php echo $this->session->flashdata('msg'); ?>
                    <form id="station-form" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/home/login'  method="post">

                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" placeholder="Email/Contact" id="email" name="email" class=" form-control field "/>
                            </div>
                        </div>
                        <br></br>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="password" name="password" id="password" placeholder="Password" id="inputPassword3" class=" form-control field "/>
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="col-sm-10">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" id="type" value="patient" checked=""/>User 
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" id="type" value="physician"/>Physician 
                                        </label>
                                    </div>
                                </div>
                           
                        </div>
                        <div class="form-group">
                            <div class=" col-sm-10"> 
                                    <button class="btn btn-default pull-right" type="submit">Sign in</button>
                               
                            </div>
                        </div>
                          <br></br>
                         <a class="btn btn-file alignright " href="<?php echo base_url() . "index.php/home/register_patient"; ?>" >New user </a> 
                          <br></br><a class="btn btn-file alignright " href="<?php echo base_url() . "index.php/home/register_center"; ?>" >New Health Centre </a>
                         <br></br> <a class="btn btn-file alignright " href="<?php echo base_url() . "index.php/home/register_physician"; ?>" >New  practitioner </a>



                    </form>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url() ?>js/jquery-2.1.0.js"></script>
        <script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>js/common-script.js"></script>
        <script src="j<?php echo base_url() ?>s/jquery.slimscroll.min.js"></script>

    </body>
</html>
