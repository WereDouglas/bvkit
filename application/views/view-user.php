
<?php require_once(APPPATH . 'views/header-page.php'); ?>       

    <?php echo $this->session->flashdata('msg'); ?>
   
        <div class=" col-md-12 x_panel">
            <div class="x_title">
                <h2>Users <small>Users</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>DESIGNATION</th>
                            <th>STATUS</th>
                            <th>CONTACT</th>
                            <th>ADDRESS</th>   
                            <th>CATEGORY</th>
                            <th>RESET PASSWORD</th>
                            <th>CREATED:</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        if (is_array($users) && count($users)) {
                            foreach ($users as $loop) {
                                $name = $loop->name;
                                $address = $loop->address;
                                $email = $loop->email;
                                $designation = $loop->designation;
                                $status = $loop->status;
                                $category = $loop->category;
                                $id = $loop->userID;
                                $contact = $loop->contact;
                                $created = $loop->created;
                                ?>  
                                <tr id="<?php echo $id; ?>" class="edit_tr">
                                    <td> 
                                        <?php
                                        if ($loop->image != "") {
                                            ?>
                                            <img  height="50px" width="50px"  src="<?= base_url(); ?>uploads/<?php echo $loop->image; ?>" alt="logo" />
                                            <?php
                                        } else {
                                            ?>
                                            <img  height="50px" width="50px"  src="<?= base_url(); ?>images/user_place.png" alt="logo" />
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="edit_td">
                                        <span id="name_<?php echo $id; ?>" class="text"><?php echo $name; ?></span>
                                        <input type="text" value="<?php echo $name; ?>" class="editbox" id="name_input_<?php echo $id; ?>"
                                    </td>
                                    <td class="edit_td">
                                        <span id="email_<?php echo $id; ?>" class="text"><?php echo $email; ?></span>
                                        <input type="text" value="<?php echo $email; ?>" class="editbox" id="email_input_<?php echo $id; ?>"
                                    </td>
                                    <td class="edit_td">
                                        <span id="designation_<?php echo $id; ?>" class="text"><?php echo $designation; ?></span>                                                       
                                        <select  name="designation" class="editbox" id="designation_input_<?php echo $id; ?>" >
                                            <option value="<?php echo $designation; ?>" /><?php echo $designation; ?>
                                            <option value="Partner" />Partner
                                            <option value="Associate" />Associate
                                            <option value="Contract" />Contract
                                            <option value="Of counsel" />Of counsel
                                            <option value="Clerk" />Clerk
                                            <option value="Paralegal" />Paralegal
                                            <option value="Administrator" />Administrator
                                            <option value="Client" />Client
                                        </select>
                                    </td> 
                                    <td class="edit_td">
                                        <span id="status_<?php echo $id; ?>" class="text"><?php echo $status; ?></span>                                                       
                                        <select  name="status" class="editbox" id="status_input_<?php echo $id; ?>" >
                                            <option value="<?php echo $status; ?>" /><?php echo $status; ?>
                                            <option value="Partner" />Active
                                            <option value="Associate" />Dull

                                        </select>
                                    </td>  

                                    <td class="edit_td">
                                        <span id="contact_<?php echo $id; ?>" class="text"><?php echo $contact; ?></span>
                                        <input type="text" value="<?php echo $contact; ?>" class="editbox" id="contact_input_<?php echo $id; ?>"

                                    </td>
                                    <td class="edit_td">

                                        <span id="address_<?php echo $id; ?>" class="text">
                                            <?php
                                            //echo $abstract;
                                            // strip tags to avoid breaking any html
                                            $string = strip_tags($address);

                                            if (strlen($string) > 10) {

                                                // truncate string
                                                $stringCut = substr($string, 0, 10);

                                                // make sure it ends in a word so assassinate doesn't become ass...
                                                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... <a href="' . base_url() . "index.php/user/finding/" . $loop->id . '">Read More</a>';
                                            }
                                            echo $string;
                                            ?>
                                        </span>
                                        <textarea type="text" value="<?php echo $address; ?>" class="editbox" id="address_input_<?php echo $id; ?>"><?php echo $address; ?></textarea>

                                    </td>
                                    <td class="edit_td">
                                        <span id="category_<?php echo $id; ?>" class="text"><?php echo $category; ?></span>                                                       
                                        <select  name="category" class="editbox" id="category_input_<?php echo $id; ?>" >
                                            <option value="<?php echo $category; ?>" /><?php echo $category; ?>
                                            <option value="Staff" />Staff
                                            <option value="Client" />Client

                                        </select>
                                    </td>    
                                    <td>
                                        <a href="#"  value="<?php echo $loop->id; ?>"  id="myLink" onclick="NavigateToSite(this)" class="tooltip-error text-danger" data-rel="tooltip" title="reset">
                                            <span class="red">
                                                <i class="icon-lock bigger-120 text-danger"></i>
                                                Reset
                                            </span>
                                        </a>
                                    </td>

                                    <td class="edit_td">
                                        <?php echo $created; ?>
                                          </td>   

                                    <td class="center">
                                        <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/user/delete/" . $id; ?>"></a>
                                    </td>

                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
   


<?php require_once(APPPATH . 'views/footer-page.php'); ?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $(".editbox").hide();

        $(".edit_tr").click(function ()
        {
            var ID = $(this).attr('id');
            $("#name_" + ID).hide();
            $("#email_" + ID).hide();
            $("#designation_" + ID).hide();
            $("#status_" + ID).hide();
            $("#address_" + ID).hide();
            $("#contact_" + ID).hide();
            $("#category_" + ID).hide();


            $("#contact_input_" + ID).show();
            $("#name_input_" + ID).show();
            $("#designation_input_" + ID).show();
            $("#status_input_" + ID).show();
            $("#email_input_" + ID).show();
            $("#address_input_" + ID).show();
            $("#category_input_" + ID).show();
            
        }).change(function ()
        {
            var ID = $(this).attr('id');
            var name = $("#name_input_" + ID).val();
            var details = $("#details_input_" + ID).val();
            var contact = $("#contact_input_" + ID).val();
            var email = $("#email_input_" + ID).val();
            var address = $("#address_input_" + ID).val();
            var category = $("#category_input_" + ID).val();
            var designation = $("#designation_input_" + ID).val();
            var status = $("#status_input_" + ID).val();



            var dataString = 'id=' + ID + '&name=' + name + '&address=' + address + '&details=' + details + '&contact=' + contact + '&email=' + email+ '&category=' +category+ '&status=' + status+ '&designation=' + designation;
            $("#name_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#details_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#email_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            $("#contact_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            $("#address_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            if (name.length > 0)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "index.php/user/update/"; ?>",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {
                        $("#name_" + ID).html(name);
                        $("#details_" + ID).html(details);
                        $("#contact_" + ID).html(contact);
                        $("#email_" + ID).html(email);
                        $("#address_" + ID).html(address);
                        $("#category_" + ID).html(category);
                        $("#designation_" + ID).html(designation);
                        $("#status_" + ID).html(status);


                    }
                });
            } else
            {
                alert('Enter something.');
            }

        });

        // Edit input box click action
        $(".editbox").mouseup(function ()
        {
            return false
        });

        // Outside click action
        $(document).mouseup(function ()
        {
            $(".editbox").hide();
            $(".text").show();
        });

        $('#loading').hide();
        $("#email2").blur(function () {

            var user = $(this).val();
            if (user != null) {

                $('#loading').show();
                $.post("<?php echo base_url() ?>index.php/organisation/exists", {
                    user: $(this).val()
                }, function (response) {
                    // alert(response);
                    $('#loading').hide();
                    setTimeout(finishAjax('loading', escape(response)), 400);
                });
            }
            function finishAjax(id, response) {
                $('#' + id).html(unescape(response));
                $('#' + id).fadeIn();
            }


        });

    });
</script>
<script>

    function NavigateToSite(ele) {
        var selectedVal = $(ele).attr("value");
        //var selectedVal = document.getElementById("myLink").getAttribute('value');
        //href= "index.php/patient/add_user/'
        $.post("<?php echo base_url() ?>index.php/admin/reset", {
            id: selectedVal
        }, function (response) {
            alert(response);
        });

    }

</script>