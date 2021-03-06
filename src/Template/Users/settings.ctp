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
                            <?= $this->Form->create('siteForm',[
                                'id' => 'siteForm',
                                'name' => 'siteForm',
                                'enctype'  =>'multipart/form-data'
                            ])?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Site Name</label>
                                        <input id="sitename" name="sitename" type="text" class="form-control" value="<?php echo $siteSettings['sitename'] ?>">
                                    </div>
                                    <span id="firstErr"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Contact Email</label>
                                        <input id="contact_email" name="contact_email" type="text" class="form-control" value="<?php echo $siteSettings['contact_email'] ?>">
                                    </div>
                                    <span id="lastErr"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Contact Phonenumber</label>
                                        <input id="contact_phone" name="contact_phone" type="text" class="form-control" value="<?php echo $siteSettings['contact_phone'] ?>">
                                    </div>
                                    <span id="emailErr"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Address</label>
                                        <input id="address" name="address" type="text" class="form-control" placeholder="" value="<?php echo $siteSettings['address'] ?>">
                                    </div>
                                    <span id="addressErr"></span>
                                </div>
                            </div>

                            <button type="submit" onclick="return siteSettings()" class="btn btn-primary pull-right">SUBMIT</button>
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
    function siteSettings() {
        $(".error").html('');
        var sitename = $("#sitename").val();
        var contact_email = $("#contact_email").val();
        var contact_phone = $("#contact_phone").val();
        var address = $("#address").val();

        if(sitename == '') {
            $("#firstErr").addClass('error').html('Please enter site name');
            $("#sitename").focus();
            return false;

        }else if(contact_email == '') {
            $("#lastErr").addClass('error').html('Please enter contact email');
            $("#contact_email").focus();
            return false;

        }else if(contact_email != '' && !validateEmail(contact_email)) {
            $("#emailErr").addClass('error').html('Please enter valid email');
            $("#email").focus();
            return false;

        }else if(contact_phone == '') {
            $("#emailErr").addClass('error').html('Please enter contact phonenumber');
            $("#contact_phone").focus();
            return false;

        }else if(address == '') {
            $("#addressErr").addClass('error').html('Please enter driver address');
            $("#address").focus();
            return false;
        }else {
            document.siteForm.submit();
            return false;
        }
        return false;
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