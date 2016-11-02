
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
                    <h3 class="content-header">MEDICAL CENTERS</h3>
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
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th class="hidden-phone">City</th>
                                    <th class="hidden-phone">Region</th>
                                    <th class="hidden-phone">Latitude</th>
                                    <th class="hidden-phone">Longitude</th>
                                    <th class="hidden-phone">Type</th>
                                    <th class="hidden-phone">Registration No.</th>
                                    <th class="hidden-phone">Status</th>
                                    <th class="hidden-phone">Created</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (is_array($centers) && count($centers)) {
                                    foreach ($centers as $loop) {
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

                                            <td id="name:<?php echo $loop->centerID; ?>" contenteditable="true">
                                                <?php echo $loop->name; ?>
                                            </td>

                                            <td id="address:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->email; ?></td>
                                            <td id="country:<?php echo $loop->centerID; ?>" contenteditable="true">
                                                <?php echo $loop->country; ?>
                                            </td>
                                            <td id="city:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->city; ?></td>
                                            <td id="region:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->region; ?></td>
                                            <td id="lat:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->lat; ?></td>
                                            <td id="lng:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->lng; ?></td>
                                            <td id="type:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->type; ?></td>
                                            <td id="registrationNo:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->registrationNo; ?></td>
                                            <td id="status:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->status; ?></td>
                                            <td id="created:<?php echo $loop->centerID; ?>" contenteditable="true"><?php echo $loop->created; ?></td>


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
                <h4 class="modal-title" id="myModalLabel">Add Center</h4>
            </div>
            <div class="modal-body">             
                <form id="station-form" parsley-validate novalidate role="form" class="form-horizontal" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/center/create'  method="post">

                    <div class="form-group">

                        <div class="col-sm-10">
                            <input type="text" name="name" placeholder="Full Name" id="inputEmail3" required class="form-control"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-10">
                            <label >Type</label>
                            <select class="form-control" id="type" name="type"> 
                                <option value="Hospital">Hospital</option>
                                <option value="Clinic">Clinic</option>                                   
                            </select>
                        </div><!--/col-sm-9--> 
                    </div><!--/form-group--> 



                    <div class="form-group">
                        <div class="col-sm-10">
                            <div id="locationField">
                                <input id="autocomplete" name="address" class="form-control" placeholder="Enter your address city/town" onFocus="geolocate()" type="text"></input>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" class=" form-control field " id="street_number" disabled="true" placeholder="Street Address"></input>
                    </div>
                    <div>
                        <input type="hidden" class=" form-control field " id="route" disabled="true" placeholder="City"></input>
                    </div>
                    <div>
                        <input class="field form-control" name="city" id="locality" disabled="true" placeholder="State"></input>
                    </div>
                    <br />
                    <div>
                        <input name="region" class="field form-control"id="administrative_area_level_1" disabled="true"></input>
                    </div>
                    <br />
                    <div>
                        <input type="hidden" class="field form-control" id="postal_code"  disabled="true" placeholder="Zip Code"></input>
                    </div>
                    <br />
                    <div>
                        <input name="country" class="field form-control" id="country" disabled="true" placeholder="Country"></input>
                    </div>
                    <br />
                    <div>

                        <script>
                            // This example displays an address form, using the autocomplete feature
                            // of the Google Places API to help users fill in the information.

                            // This example requires the Places library. Include the libraries=places
                            // parameter when you first load the API. For example:
                            // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

                            var placeSearch, autocomplete;
                            var componentForm = {
                                street_number: 'short_name',
                                route: 'long_name',
                                locality: 'long_name',
                                administrative_area_level_1: 'short_name',
                                country: 'long_name',
                                postal_code: 'short_name'
                            };

                            function initAutocomplete() {
                                // Create the autocomplete object, restricting the search to geographical
                                // location types.
                                autocomplete = new google.maps.places.Autocomplete(
                                        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                                        {types: ['geocode']});

                                // When the user selects an address from the dropdown, populate the address
                                // fields in the form.
                                autocomplete.addListener('place_changed', fillInAddress);
                            }

                            function fillInAddress() {
                                // Get the place details from the autocomplete object.
                                var place = autocomplete.getPlace();

                                for (var component in componentForm) {
                                    document.getElementById(component).value = '';
                                    document.getElementById(component).disabled = false;
                                }

                                // Get each component of the address from the place details
                                // and fill the corresponding field on the form.
                                for (var i = 0; i < place.address_components.length; i++) {
                                    var addressType = place.address_components[i].types[0];
                                    if (componentForm[addressType]) {
                                        var val = place.address_components[i][componentForm[addressType]];
                                        document.getElementById(addressType).value = val;
                                    }
                                }
                            }

                            // Bias the autocomplete object to the user's geographical location,
                            // as supplied by the browser's 'navigator.geolocation' object.
                            function geolocate() {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(function (position) {
                                        var geolocation = {
                                            lat: position.coords.latitude,
                                            lng: position.coords.longitude
                                        };
                                        var circle = new google.maps.Circle({
                                            center: geolocation,
                                            radius: position.coords.accuracy
                                        });
                                        autocomplete.setBounds(circle.getBounds());
                                    });
                                }
                            }
                        </script>
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAZn2XZuHCiSmUltMNn0dtUPqbGbyDfgs&libraries=places&callback=initAutocomplete"
                        async defer></script>
                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="text" name="registrationNo" placeholder="Registration No."  class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="text" name="lat" placeholder="Latitude" id="lat"  class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-10">
                                <input type="text" name="lng" placeholder="Longitude" id="lng"  class="form-control"/>
                            </div>
                        </div>
                        <div class="item form-group">                    
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">Logo/Flag picture</label>  
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="file" name="userfile" id="userfile" class="btn-default btn-small"/>
                                <div id="imagePreview" ></div>      
                            </div>
                        </div>


                        <div class="form-group">
                            <div class=" col-sm-10">
                                <div class="checkbox checkbox_margin">


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
                                            $.post('<?php echo base_url() . "index.php/family/updater/"; ?>', field_id + "=" + value, function (data) {
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
