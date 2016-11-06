<div class="left_nav">
    <!--\\\\\\\left_nav start \\\\\\-->

    <div class="left_nav_slidebar">
        <ul>
            <li class="left_nav_active theme_border"><a href="javascript:void(0);"><i class="fa fa-home"></i> PROFILE <span class="left_nav_pointer"></span> <span class="plus"><i class="fa fa-plus"></i></span> </a>
                <ul class="opened" style="display:block">
                    <li> <a target="frame" href="<?php echo base_url() . "index.php/patient/profile"; ?>" > <span>&nbsp;</span> <i class="fa fa-circle "></i> <b>My profile</b> </a> </li>

                    <?php if ($this->session->userdata('sessionName') == "patient") { ?>
                        <li> <a target="frame" href="<?php echo base_url() . "index.php/physician/"; ?>" class="left_nav_sub_active"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Next of kin</b> </a> </li>
                        <li> <a target="frame" href="<?php echo base_url() . "index.php/physician/mine"; ?>" class="left_nav_sub_active"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Family</b> </a> </li>
                    <?php } ?>
                </ul>
            </li>
            <?php if ($this->session->userdata('sessionName') == "patient") { ?>
                <li> <a href="javascript:void(0);"> <i class="fa fa-edit"></i> PHYSICIANS <span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a target="frame" href="<?php echo base_url() . "index.php/physician/"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>View</b> </a> </li>
                        <li> <a target="frame" href="<?php echo base_url() . "index.php/physician/mine"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>My doctors</b> </a> </li>

                    </ul>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('sessionName') == "physician") { ?>
                <li> <a href="javascript:void(0);"> <i class="fa fa-edit"></i> PATIENTS<span class="plus"><i class="fa fa-plus"></i></span></a>
                    <ul>
                        <li> <a target="frame" href="<?php echo base_url() . "index.php/patient/mine"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>View</b> </a> </li>
                    </ul>
                </li>
            <?php } ?>
            <li> <a href="javascript:void(0);"> <i class="fa fa-tasks"></i> DIAGNOSTICS <span class="plus"><i class="fa fa-plus"></i></span></a>
                <ul>
                    <li> <a target="frame" href="<?php echo base_url() . "index.php/diagnosis/analysis"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Analysis</b> </a> </li>
                    <li> <a target="frame" href="<?php echo base_url() . "index.php/diagnosis/view"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>View live diagnosis</b> </a> </li>

                </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-users icon"></i> MEDICAL ANALYSIS <span class="plus"><i class="fa fa-plus"></i></span> </a>
                <ul>
                    <li> <a href="todo.html"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>To-Do</b> </a> </li>
                </ul>
            </li>
            <li> <a href="javascript:void(0);"> <i class="fa fa-users icon"></i> MEDICAL CENTERS <span class="plus"><i class="fa fa-plus"></i></span> </a>
                <ul>
                    <li> <a target="frame" href="<?php echo base_url() . "index.php/center"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>List</b> </a> </li>
                    <li> <a target="frame" href="<?php echo base_url() . "index.php/center/map"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Map</b> </a> </li>

                </ul>
            </li>
             <li> <a href="javascript:void(0);"> <i class="fa fa-users icon"></i> INFECTIONS<span class="plus"><i class="fa fa-plus"></i></span> </a>
                <ul>
                    <li> <a target="frame" href="<?php echo base_url() . "index.php/infection"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>List</b> </a> </li>
                   
                </ul>
            </li>
        </ul>
    </div>
</div>