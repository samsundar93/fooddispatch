<div class="main-panel">
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">person</i>
                            <p class="hidden-lg hidden-md">Profile</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-content">
                            <?= $this->Form->create('DrvierForm',[
                                'id' => 'DrvierForm',
                                'name' => 'DrvierForm',
                                'enctype'  =>'multipart/form-data'
                            ])?>
                            <input type="hidden" value="<?php echo $id; ?>" name="id" id="editId">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fist Name</label>
                                        <input id="firstname" name="firstname" type="text" class="form-control" value="<?php echo $driverDetails['firstname'] ?>">
                                    </div>
                                    <span id="firstErr"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Last Name</label>
                                        <input id="lastname" name="lastname" type="text" class="form-control" value="<?php echo $driverDetails['lastname'] ?>">
                                    </div>
                                    <span id="lastErr"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Email</label>
                                        <input id="email" name="email" type="text" class="form-control" value="<?php echo $driverDetails['email'] ?>">
                                    </div>
                                    <span id="emailErr"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Address</label>
                                        <input id="address" name="address" type="text" class="form-control" placeholder="" value="<?php echo $driverDetails['address'] ?>">
                                    </div>
                                    <span id="addressErr"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Phone Number</label>
                                        <input id="phonenumber" name="phone_number" type="text" class="form-control" value="<?php echo $driverDetails['phone_number'] ?>">
                                    </div>
                                    <span id="phoneErr"></span>
                                </div>
                            </div>
                            <button type="submit" onclick="return addDriver()" class="btn btn-primary pull-right">EDIT</button>
                            <div class="clearfix"></div>
                            <?=  $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addDriver() {
        $(".error").html('');
        var editId = $("#editId").val();
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var email = $("#email").val();
        var address = $("#address").val();
        var phone_number = $("#phonenumber").val();

        if(firstname == '') {
            $("#firstErr").addClass('error').html('Please enter driver first name');
            $("#firstname").focus();
            return false;

        }else if(lastname == '') {
            $("#lastErr").addClass('error').html('Please enter driver lastname');
            $("#lastname").focus();
            return false;

        }else if(email == '') {
            $("#emailErr").addClass('error').html('Please enter driver email');
            $("#email").focus();
            return false;

        }else if(email != '' && !validateEmail(email)) {
            $("#emailErr").addClass('error').html('Please enter valid email');
            $("#email").focus();
            return false;

        }else if(address == '') {
            $("#addressErr").addClass('error').html('Please enter driver address');
            $("#address").focus();
            return false;

        }else if(phone_number == '') {
            $("#phoneErr").addClass('error').html('Please enter driver phone number');
            $("#phone_number").focus();
            return false;

        }else {

            $.ajax({
                type   : 'POST',
                url    : baseUrl+'drivers/checkDriver',
                data   : {phone_number:phone_number,id:editId},
                success: function(data){
                    if($.trim(data) == 'false') {
                        $("#phoneErr").addClass('error').html('Phone number already exists');
                        $("#phone_number").focus();
                        return false;
                    }else {
                        document.DrvierForm.submit();
                        return false;
                    }
                }
            });
            return false;
        }
    }

    function validateEmail(sEmail) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }

    $(document).ready(function () {
        initialize();
    });
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.
    var placeSearch, autocomplete,autocomplete1;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initialize() {
        $.ajax({
            type   : 'POST',
            url    : baseUrl+'users/getLocation',
            success: function(data){

                if($.trim(data) != '') {
                    //$("#countryCode").val($.trim(data));
                    var code = $.trim(data);
                }else {
                    //$("#countryCode").val('IND');
                    var code = $.trim('IND');
                }


                // Create the autocomplete object, restricting the search
                autocomplete1 = new google.maps.places.Autocomplete(
                    /** @type {HTMLInputElement} */ (document.getElementById('address')),
                    { types: ['geocode'],componentRestrictions: {country: code} });
                google.maps.event.addListener(autocomplete1, 'place_changed', function() {
                    fillInAddress();
                });

            }
        });


    }

    // The START and END in square brackets define a snippet for our documentation:
    // [START region_fillform]
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete1.getPlace();


        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
            }
        }
    }
    // [END region_fillform]

    // [START region_geolocation]
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = new google.maps.LatLng(
                    position.coords.latitude, position.coords.longitude);
                autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
                    geolocation));
            });
        }
    }
</script>