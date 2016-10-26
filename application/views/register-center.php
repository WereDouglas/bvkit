<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>BV KIT</title>
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/>

        <link href="<?php echo base_url() ?>css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>css/animate.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>plugins/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>plugins/bootstrap-timepicker/compiled/timepicker.css" />
        <link href="<?php echo base_url() ?>css/mine.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="light_theme  fixed_header left_nav_fixed">
        <div class="wrapper">
            <div class="login_page">
                <div class="registration">
                    <div class="logo" ><span class="theme_color"><img src="<?php echo base_url() ?>images/bv.png" width="100" height="60" alt="s-logo" /></span></div>

                    <div class="panel-heading border login_heading">center registration</div>	
                    <?php echo $this->session->flashdata('msg'); ?>
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
                            <div class="alert alert-success">
                                <a href="<?php echo base_url() . "index.php/home"; ?>" >Back to login </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url() ?>js/jquery-2.1.0.js"></script>
        <script src="<?php echo base_url() ?>js/validator.js"></script>
        <script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>js/common-script.js"></script>
        <script src="<?php echo base_url() ?>js/jquery.slimscroll.min.js"></script>
        <script src="<?php echo base_url() ?>js/validator.js"></script>
        <script src="<?php echo base_url() ?>plugins/validation/parsley.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
        <script type="text/javascript" src="<?php echo base_url() ?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> 
        <script type="text/javascript" src="<?php echo base_url() ?>js/form-components.js"></script>       
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
        <script>
            $(document).ready(function () {
                $('#station-form').formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        confirmPassword: {
                            validators: {
                                identical: {
                                    field: 'password',
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        }
                    }
                });
            });
        </script>

    </body>
</html>
