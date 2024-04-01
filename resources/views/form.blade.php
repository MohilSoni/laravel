<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel CRUD using ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        label {
            font-weight: 600;
        }

        .error {
            color: red;
        }

        textarea.address {
            display: block !important;
        }
    </style>
</head>
<body>

<div class="fluid-container p-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>
                        {{ isset($student->id)? 'Edit User':'Add New User' }}
                    </h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.save') }}"
                          method="post"
                          id="validate" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3">
                            <input type="hidden" id="user-id" name="id"
                                   value="{{ isset($student->id) ? $student->id: '' }}">
                            <label for="name" class="form-label">UserName</label>
                            <input type="text"
                                   value="{{ isset($student->username)? $student->username: '' }}{{ old('username') }}"
                                   class="form-control @error('username') is-invalid @enderror" id="name"
                                   name="username">
                            <span class="text-danger">
                                @error('username')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">EmailAddress</label>
                            <input type="email"
                                   value="{{ isset($student->useremail)? $student->useremail: '' }}{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                            <span class="text-danger">
                                @error('email')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mt-3">

                            <label for="password" class="form-label">Password</label>
                            <input style="float: left" type="password"
                                   class="form-control @error('password') is-invalid @enderror" id="password"
                                   name="password">
                            <div class="mt-1">
                                <label id="password-error" class="error" for="password"></label>
                            </div>
                            <span class="text-danger">
                                @error('password')
                                {{ $message }}
                                @enderror
                            </span>

                        </div>
                        <div class="mt-3">
                            <label for="contactnumber" class="form-label">Contact Number</label>
                            <input type="text"
                                   value="{{ isset($student->usercontact)? $student->usercontact: '' }}{{ old('contactnumber') }}"
                                   class="form-control @error('contactnumber') is-invalid @enderror" id="contactnumber"
                                   name="contactnumber">
                            <span class="text-danger">
                                @error('contactnumber')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mt-3">
                            <label for="gendername" class="form-label">Gender</label>
                        </div>
                        <div class="mt-2">
                            <input type="radio" class="form-radio" id="gender" name="gender"
                                   value="male"@php echo old('gender') == 'male' ? 'checked' : ''@endphp @php echo isset($student->usergender) && $student->usergender == 'male' ? 'checked' : '' @endphp>
                            <label for="gender" class="form-label" style="font-weight: 400;">Male</label>
                            <input type="radio" class="form-radio ms-4" id="gender" name="gender"
                                   value="female" @php echo old('gender') == 'female' ? 'checked' : ''@endphp @php echo isset($student->usergender) && $student->usergender == 'female' ? 'checked' : '' @endphp>
                            <label for="gender" class="form-label" style="font-weight: 400;">Female</label>
                            <div class="mt-1">
                                <label id="gender-error" class="error" for="gender"></label>
                            </div>
                        </div>
                        <div>
                        <span class="text-danger">
                            @error('gender')
                            {{ $message }}
                            @enderror
                        </span>
                        </div>
                        <div class="mt-3">
                            <label for="hobbies" class="form-label">Hobbies</label>
                        </div>
                        <div class="mt-2">
                            @php
                                $hobbies = isset($student->userhobbies) ? explode(',', $student->userhobbies) : [];
                            @endphp
                            <input type="checkbox" class="form-checkbox" id="hobbies" name="hobbies[]"
                                   value="Cricket" {{ in_array('Cricket', $hobbies) ? 'checked' : '' }} >
                            <label for="hobbies" class="form-label" style="font-weight: 400;">Cricket</label>
                            <input type="checkbox" class="form-checkbox ms-4" id="hobbies" name="hobbies[]"
                                   value="Football" {{ in_array('Football', $hobbies) ? 'checked' : '' }}>
                            <label for="hobbies" class="form-label" style="font-weight: 400;">Football</label>
                            <input type="checkbox" class="form-checkbox ms-4" id="hobbies" name="hobbies[]"
                                   value="Hockey" {{ in_array('Hockey', $hobbies) ? 'checked' : '' }}>
                            <label for="hobbies" class="form-label" style="font-weight: 400;">Hockey</label>
                            <div class="mt-1">
                                <label id="hobbies[]-error" class="error" for="hobbies[]"></label>
                            </div>
                        </div>
                        <div>
                    <span class="text-danger">
                        @error('hobbies')
                        {{ $message }}
                        @enderror
                    </span>
                        </div>

                        <div class="mt-3">

                            <label for="country" class="form-label">Country</label>
                            <select class="form-select @error('country') is-invalid @enderror" id="country"
                                    name="country">
                                <option value=""></option>
                                <option @php echo old('country') == 'India'? 'selected' : '' @endphp @php echo isset($student->usercountry) && $student->usercountry == 'India' ? 'selected' : '' @endphp>
                                    India
                                </option>
                                <option @php echo old('country') == 'USA'? 'selected' : '' @endphp @php echo isset($student->usercountry) && $student->usercountry == 'USA' ? 'selected' : '' @endphp>
                                    USA
                                </option>
                                <option @php echo old('country') == 'UK'? 'selected' : '' @endphp @php echo isset($student->usercountry) && $student->usercountry == 'UK' ? 'selected' : '' @endphp>
                                    UK
                                </option>
                                <option @php echo old('country') == 'Australia'? 'selected' : '' @endphp @php echo isset($student->usercountry) && $student->usercountry == 'Australia' ? 'selected' : '' @endphp>
                                    Australia
                                </option>
                            </select>
                            <span class="text-danger">
                                @error('country')
                                {{ $message }}
                                @enderror
                    </span>
                        </div>
                        <div class="mt-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="address form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      rows="3">{{ isset($student->useraddress) ? $student->useraddress : '' }}{{ old('address') }}
                    </textarea>

                            <div class="mt-1">
                                <label id="address-error" class="error address" for="address"></label>
                            </div>
                            <span class="text-danger">
                                @error('address')
                                {{ $message }}
                                @enderror
                    </span>
                        </div>
                        <div class="mt-3">
                            <label for="image" class="form-label">Select Image</label>
                            <input type="file"
                                   class="form-control @if(!isset($student->id)) @error('image') is-invalid @enderror @endif"
                                   id="image" name="image">
                            @if(!isset($student->id))
                                <span class="text-danger">
                                    @error('image')
                                    {{ $message }}
                                    @enderror
                            </span>
                            @endif
                        </div>
                        <div class="mt-3 d-flex justify-content-center">
                            @if(isset($student->userimage))
                                <img src="{{ asset('images/'.$student->userimage) }}" width="200px" height="250px"
                                     alt="image"
                                     style="object-fit: contain" id="image">
                            @endif
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <label for="address-input" class="form-label">Search</label>
                                    <input type="text"
                                           class="form-control map-input @error('search') is-invalid @enderror"
                                           placeholder="Search your location"
                                           id="address-input"
                                           name="search"
                                           value="{{ isset($student->id) ? $student->location : '' }}{{ old('search') }}">
                                    <span class="text-danger">
                                        @error('search')
                                        {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-6 mt-2">
                                    <input type="hidden" class="form-control" placeholder="latitude" name="lat"
                                           id="address-latitude"
                                           value="{{ isset($student->id) ? $student->lat : '' }}">
                                </div>
                                <div class="col-6 mt-2">
                                    <input type="hidden" class="form-control" placeholder="longitude" name="lng"
                                           id="address-longitude"
                                           value="{{ isset($student->id) ? $student->lon : '' }}">
                                </div>
                                <div class="col-12 mt-2">
                                    <div id="address-map-container" style="width: 100%; height: 400px;">
                                        <div style="width: 100%; height: 100%" id="address-map"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-center">
                            <button type="submit" name="submit" value="submit"
                                    class="add btn btn-primary">{{ isset($student->id)? 'Edit User':'Add User' }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlBTQzvBudM_ydhSW2cVpLuBoCn-hIjkA&callback=initialize&libraries=places"
    type="text/javascript"
    async defer></script>

<script>
    function initialize() {
        $('form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        const geocoder = new google.maps.Geocoder;
        const inputLocation = document.querySelector(".map-input");
        if (!inputLocation) return;
        const fieldKey = inputLocation.id.replace("-input", "");
        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 22.3038945;
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 70.80215989999999;

        //for map initialization
        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 7,
        });

        //for marker dragging
        const marker = new google.maps.Marker({
            map: map,
            position: {lat: latitude, lng: longitude},
            draggable: true,
        });

        //reverse geocoding to get address when marker is dragged
        google.maps.event.addListener(marker, 'dragend',
            function () {
                let lat = marker.position.lat()
                let lng = marker.position.lng()
                geocoder.geocode({'location': {lat: lat, lng: lng}}, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            $('#address-input').val(results[0].formatted_address);
                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder : ' + status);
                    }
                });
                $('#address-latitude').val(lat)
                $('#address-longitude').val(lng)
            });

        //for autocomplete and reverse geocoding to get address when user types
        const autocomplete = new google.maps.places.Autocomplete(inputLocation);

        autocomplete.key = fieldKey;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            marker.setVisible(false);
            const place = autocomplete.getPlace();
            geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    setLocationCoordinates(autocomplete.key, lat, lng);
                }
            });

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                inputLocation.value = "";
                return;
            }
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            }
            // Otherwise, display the address on the map.
            else {
                map.setCenter(place.geometry.location);
                map.setZoom(13);
            }
            // Set the position of the marker using the place ID and location.
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });
    }

    //for setting latitude and longitude values in input fields when marker is dragged or dropped on map
    function setLocationCoordinates(key, lat, lng) {
        const latitudeField = document.getElementById(key + "-" + "latitude");
        const longitudeField = document.getElementById(key + "-" + "longitude");
        if (latitudeField && longitudeField) {
            latitudeField.value = lat;
            longitudeField.value = lng;
        }
    }

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "Letters and spaces only please");

    $(document).ready(function () {
        $('#validate').validate({
            rules: {
                username: {
                    required: true,
                    lettersonly: true
                },
                email: {
                    required: true
                },
                password: {
                    required: true
                },
                contactnumber: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                gender: {
                    required: true
                },
                "hobbies[]": {
                    required: true
                },
                country: {
                    required: true
                },
                address: {
                    required: true
                },
                image: {
                    required: function () {
                        return $('#image').val() === '' && $('#user-id').val() === '';
                    }
                },
                search: {
                    required: function () {
                        return $('#address-input').val() === '' && $('#user-id').val() === '';
                    }
                }
            },
            messages: {
                username: {
                    required: "Please enter your Name"
                },
                email: {
                    required: "Please enter your EmailAddress"
                },
                password: {
                    required: "Please enter your password"
                },
                contactnumber: {
                    required: "Please enter your contact number"
                },
                gender: {
                    required: "Please select your gender"
                },
                "hobbies[]": {
                    required: "Please select your hobbies"
                },
                country: {
                    required: "Please select your country"
                },
                address: {
                    required: "Please enter your address"
                },
                image: {
                    required: "Please select your Image"
                },
                search: {
                    required: "Please select your location"
                }
            },
            submitHandler: function (form) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('user.save') }}",
                    type: "POST",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    datatype: 'json',
                    success: function (response) {
                        if (response.message === "success") {
                            window.location.href = "{{ route('displayusers') }}";
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert(error.responseText);
                    }
                });
            }
        });
    });

</script>
</body>
</html>




