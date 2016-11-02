<div class="header_bar magento_thm">
    <!--\\\\\\\ header Start \\\\\\-->
    <div class="brand" style="background-color: #37ADB2;padding-bottom: 10px;"> 
        <!--\\\\\\\ brand Start \\\\\\-->
        <div  ><span class="theme_color"><img src="<?php echo base_url() ?>images/bv.png" width="100" height="60" alt="s-logo" /></span></div>

    </div>
    <!--\\\\\\\ brand end \\\\\\-->
    <div class="header_top_bar"> <a href="javascript:void(0);" class="menutoggle"> <i class="fa fa-bars"></i> </a>
        <div class="top_left">
            <div class="top_left_menu">
                <ul>
                    <li> <a href="javascript:void(0);"> <i class="fa fa-repeat"></i> </a> </li>
                    <li> <a href="javascript:void(0);"> <i class="fa fa-th-large"></i> </a> </li>
                </ul>
            </div>
        </div>
        <a href="javascript:void(0);" class="add_user" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-square"></i> <span> New diagnosis</span> </a>
        <div class="top_right_bar">
            <div class="top_right">
                <div class="top_right_menu">
                    <ul>
                        <li class="dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"> Diagnostics today <span class="badge badge">8</span> </a>
                            <ul class="drop_down_task dropdown-menu">
                                <div class="top_pointer"></div>
                                <li>
                                    <p class="number">You have 7 pending tasks</p>
                                </li>
                                <li> <a href="task.html" class="task">
                                        <div class="green_status task_height" style="width:80%;"></div>
                                        <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right green_label">80%</span> </div>
                                        <div class="task_detail">Task details goes here</div>
                                    </a> </li>
                                <li> <a href="task.html" class="task">
                                        <div class="yellow_status task_height" style="width:50%;"></div>
                                        <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right yellow_label">50%</span> </div>
                                        <div class="task_detail">Task details goes here</div>
                                    </a> </li>
                                <li> <a href="task.html" class="task">
                                        <div class="blue_status task_height" style="width:70%;"></div>
                                        <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right blue_label">70%</span> </div>
                                        <div class="task_detail">Task details goes here</div>
                                    </a> </li>
                                <li> <a href="task.html" class="task">
                                        <div class="red_status task_height" style="width:85%;"></div>
                                        <div class="task_head"> <span class="pull-left">Task Heading</span> <span class="pull-right red_label">85%</span> </div>
                                        <div class="task_detail">Task details goes here</div>
                                    </a> </li>
                                <li> <span class="new"> <a href="task.html" class="pull_left">Create New</a> <a href="task.html" class="pull-right">View All</a> </span> </li>
                            </ul>
                        </li>
                        <li class="dropdown"> <a href="javascript:void(0);" data-toggle="dropdown">Pending review <span class="badge badge color_1">4</span> </a>
                            <ul class="drop_down_task dropdown-menu">
                                <div class="top_pointer"></div>
                                <li>
                                    <p class="number">You have 4 mails</p>
                                </li>
                                <li> <a href="readmail.html" class="mail"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
                                <li> <a href="readmail.html" class="mail"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
                                <li> <a href="readmail.html" class="mail red_color"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
                                <li> <a href="readmail.html" class="mail"> <span class="photo"><img src="images/user.png" /></span> <span class="subject"> <span class="from">sarat m</span> <span class="time">just now</span> </span> <span class="message">Hello,this is an example msg.</span> </a> </li>
                            </ul>
                        </li>
                        <li class="dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"> notification <span class="badge badge color_2">6</span> </a>
                            <div class="notification_drop_down dropdown-menu">
                                <div class="top_pointer"></div>
                                <div class="box"> <a href="calendar.html"> <span class="block primery_2"> <i class="fa fa-calendar-o"></i> </span> <span class="block_text">Calendar</span> </a> </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="user_admin dropdown"> <a href="javascript:void(0);" data-toggle="dropdown"><img height="40px" width="40px" src="<?= base_url(); ?>uploads/<?php echo $this->session->userdata('image'); ?>" /> <span class="user_adminname"><?php echo $this->session->userdata('name'); ?></span> <b class="caret"></b> </a>
                <ul class="dropdown-menu">
                    <div class="top_pointer"></div>
                    <li> <a href="profile.html"><i class="fa fa-user"></i> Profile</a> </li>
                    <li> <a href="help.html"><i class="fa fa-question-circle"></i> Help</a> </li>

                    <li> <a href="<?php echo base_url() . "index.php/home/logout"; ?>"><i class="fa fa-power-off"></i> Logout</a> </li>
                </ul>
            </div>
            <a href="javascript:;" class="toggle-menu menu-right push-body jPushMenuBtn rightbar-switch"><i class="fa fa-comment chat"></i></a> </div>
    </div>
</div>