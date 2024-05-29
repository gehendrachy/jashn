@extends('layouts.app')
@section('title', "Checkout")
@section('content')

    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Check Out
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li>Check Out</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <br><br>
        <p class="lead">Please Log in / Sign Up to Your Account to continue the checkout process.</p>
        <hr>
        <div class="row align-items-start">
            <div class="col-md-6">

                <div id="login-box">
                    <form action="{{ url('login') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="col-sm-6 control-label" for="input-email">Email</label>
                            <div class="col-sm-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="col-sm-2" for="password">Password</label>
                            <div class="col-sm-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="buttons mt-2">
                            <div class="row">
                                <div class="col-6">
                                    <p>
                                        <label for="remember_me">
                                            <input class="box-checkbox" type="checkbox" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }} value="1"> &nbsp; Keep me signed in
                                        </label>
                                    </p>
                                </div>
                                <div class="col-6 text-right">
                                    @if (Route::has('password.request'))
                                        <p>
                                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                                        </p>
                                    @endif
                                </div>


                                <p class="col-12 col-sm-10 d-flex justify-content-between ">
                                    <button type="submit" class="main-button colored mb-4">Sign in
                                    </button>
                                </p>
                            </div>
                        </div>

                    </form>
                </div>

                <div id="sign-up-box">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-name">Name</label>
                                <input type="text" name="name" placeholder="Name" id="input-name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="inputPhoneNo">Phone Number</label>
                                <input type="text" name="phone" placeholder="+977-123456789" id="inputPhoneNo" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label for="name">Country </label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherCountry" type="text" name="country_name" class="form-control other-country" placeholder="Enter Country Name" value="{{ old('country_name') }}">
                                    <i id="showCountrySelect" class="fa fa-times"></i>
                                </div>
                                <select name="country_id" id="countrySelect" class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select Country</option>
                                    @foreach($countries as $country)
                                        <option {{ old('country_id') == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option value="0">Other</option>
                                </select>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-state">State</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherState" type="text" name="state_name" class="form-control other-country" placeholder="Enter State Name" value="{{ old('state_name') }}">
                                </div>
                                <select name="state_id" id="stateSelect" class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select Country First</option>
                                </select>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-district">District</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherDistrict" type="text" name="district_name" class="form-control other-country" placeholder="Enter District Here" value="{{ old('district_name') }}">
                                </div>
                                <select name="district_id" id="districtSelect" class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select State First</option>
                                </select>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-city">City</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherCity" type="text" name="city_name" class="form-control other-country" placeholder="Enter City Name" value="{{ old('state_name') }}">
                                </div>
                                <select name="city_id" id="citySelect" class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select District First</option>
                                </select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-email">Address</label>
                                <input type="text" name="address" placeholder="eg: Baneswor, Kathmandu" id="" class="form-control">
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="inputEmail">E-Mail</label>
                                <input type="email" name="email" placeholder="E-Mail" id="inputEmail" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="password">Password</label>
                                <input id="passwordInput" type="password" name="password" placeholder="Password" class="form-control" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-confirm">Confirm Password </label>
                                <input id="passwordInputConfirmation" type="password" name="password_confirmation" placeholder="Confirm Password " class="form-control" required>
                                <small id="passwordStatus"></small>
                            </div>
                        </div>
                        <br>
                        <div class="buttons mt-2">
                            <div class="">
                                <div class="promo-registers">
                                    <hr>
                                    <p>
                                        <label for="check1">
                                            <input class="box-checkbox" type="checkbox" name="get_updates_via_sms" id="check1" value="1" checked>&nbsp;
                                            <i class="fas fa-sms"></i>&nbsp;&nbsp;Get Update via SMS [Promotional]
                                        </label>
                                    </p>
                                    <p>
                                        <label for="check2">
                                            <input class="box-checkbox" id="check2" type="checkbox" name="get_updates_via_email" value="1" checked>&nbsp;
                                            <i class="fa fa-envelope"></i>&nbsp;&nbsp;Get Promotional Update via Email
                                        </label>
                                    </p>
                                    <p>
                                        <label for="check3">
                                            <input class="box-checkbox" id="check3" type="checkbox" name="get_updates_on_chrome" value="1" checked>&nbsp;
                                            <i class="fas fa-bell"></i>&nbsp;&nbsp;Get Updates on chrome
                                        </label>
                                    </p>
                                    <hr>
                                </div>
                                <p>
                                    <input id="termsCheck" class="box-checkbox m-0" type="checkbox" name="terms_and_conditions" value="1">
                                    &nbsp;
                                    I have read and agree to the <a href="#"><b>Terms &amp; Conditions</b></a>
                                </p>
                                <!-- <p>
                                    Will get sms/email
                                </p> -->
                                <div class="col-11 d-flex justify-content-between">
                                    <button id="registerButton" type="submit" class="main-button colored mb-4">Register Now</button>
                                    <!-- <strong>Will get sms/email</strong> -->
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-md-6 sign-social">

                <div class="social">
                    <div class="login-box">
                        <!-- <h6>Or Continue Using </h6> -->
                        <a href="{{ route('social.login', 'facebook') }}" class="social-button"
                            id="facebook-connect"> <span>Login with Facebook</span></a>
                        <a href="{{ route('social.login', 'google') }}" class="social-button" id="google-connect">
                            <span>Login with Google</span></a>
                        <!-- <a href="#" class="social-button" id="twitter-connect"> <span>Connect with Twitter</span></a>
                            <a href="#" class="social-button" id="linkedin-connect"> <span>Connect with LinkedIn</span></a> -->

                    </div>
                    <!-- <hr> -->
                </div>

            </div>
            <hr>
            <div class="col-sm-12">
                <div class="buttons text-left reg">
                    <p>Not registered Yet ? <a href="#" id="register-show"><strong>Click Here To Register</strong></a>
                    </p>
                </div>
                <div class="buttons text-left sig">
                    <p>Already Have An Account ? <a href="" id="login-show"><strong>Click Here To Log
                                In</strong></a></p>
                </div>
                <div class="buttons text-left">
                    <p class="mb-0">Want A Quick Checkout Only ? <a href="{{ route('checkout') }}"><strong>Checkout As A Guest.</strong></a>
                    </p>
                    <p><small>Note: <i>Your information will not be saved for next session if you choose to checkout as
                                a guest.</i></small></p>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div id="toogle">
            <h3>See more about Jashn</h3>
            <i class="fa fa-chevron-down arrow" style="padding: 8px;"></i>
        </div>
    </section>
@endsection
@push('post-scripts')
	<script>
        $("#passwordInput, #passwordInputConfirmation").change(function(){
            check_validation();
        });

        $("#termsCheck").click(function(){
            check_validation();
        });

        function check_validation() {
            var password = $("#passwordInput").val();
            var password_cofirmation = $("#passwordInputConfirmation").val();
            if (password != '' && password_cofirmation != '') {
                if (password == password_cofirmation) {
                    $("#passwordStatus").html('Password Matched');
                    $("#passwordStatus").css('color','green');
                }else{
                    $("#passwordStatus").html('Password Confirmation Mis-match');
                    $("#passwordStatus").css('color','red');
                }
            }else{
                $("#passwordStatus").html('');
            }

            console.log(password+"-"+password_cofirmation+"-"+$("#termsCheck").is(':checked'));
            if(password == password_cofirmation && $("#termsCheck").is(':checked')){
                $("#registerButton").attr('disabled', false);
                // console.log('true');
            }else{
                $("#registerButton").attr('disabled', true);
                // console.log('false');
            }
        }

        if ($("#countrySelect").val() != null) {

            if ($("#countrySelect").val() != 0) {

                $(".country-select").show();
                $(".country-select").attr('required', true);

                $(".other-field-wrapper").hide();
                $(".other-country").attr('required', false);
                $(".other-country").attr('disabled', true);

                $("#inputPhoneNo").attr('required', true);
                $("#inputEmail").attr('required', false);

                get_states($("#countrySelect").val());

                if ($("#stateSelect").val() != null) {
                    
                    get_districts($("#stateSelect").val());

                    if ($("#districtSelect").val() != null) {

                        get_cities($("#districtSelect").val());

                    }
                }

            }else{

                $(".country-select").hide();
                $(".country-select").attr('required', false);

                $(".other-field-wrapper").show();
                $(".other-country").attr('required', true);
                $(".other-country").attr('disabled', false);

                $("#inputPhoneNo").attr('required', false);
                $("#inputEmail").attr('required', true);
            }            

        }else{

            $(".country-select").show();
            $(".country-select").attr('required', true);

            $(".other-field-wrapper").hide();
            $(".other-country").attr('required', false);
            $(".other-country").attr('disabled', true);

            $("#inputPhoneNo").attr('required', true);
            $("#inputEmail").attr('required', true);
        }

		$("#countrySelect").change(function(){
            var country_id = $(this).val();
            
            if(country_id != 0){

                $(".country-select").show();
                $(".country-select").attr('required', true);

                $(".other-field-wrapper").hide();
                $(".other-country").attr('required', false);
                $(".other-country").attr('disabled', true);

                $("#inputPhoneNo").attr('required', true);
                $("#inputEmail").attr('required', false);

                get_states(country_id);

            }else{

                $(".country-select").hide();
                $(".country-select").attr('required', false);

                $(".other-field-wrapper").show();
                $(".other-country").attr('required', true);
                $(".other-country").attr('disabled', false);

                $("#inputPhoneNo").attr('required', false);
                $("#inputEmail").attr('required', true);
            }
        });

        function get_states(country_id) {
            $.ajax({
                url: "{{ route('get-states') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    country_id: country_id,
                    state_id: '{{ old('state_id') }}'
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#stateSelect').html(response); 
                    if ($("#stateSelect").val() != null) {

                        get_districts($("#stateSelect").val());
                    }else{

                        $("#districtSelect").html('<option selected disabled>Select State First</option>');
                        $("#citySelect").html('<option selected disabled>Select District First</option>');
                    }
                }
            });
        }

        $("#stateSelect").change(function(){
            var state_id = $(this).val();
            get_districts(state_id);
        });

        function get_districts(state_id) {
            $.ajax({
                url: "{{ route('get-districts') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    state_id: state_id,
                    district_id: '{{ old('district_id') }}'
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#districtSelect').html(response); 

                    if ($("#districtSelect").val() != null) {
                        get_cities($("#districtSelect").val());
                    }else{

                        $("#citySelect").html('<option selected disabled>Select District First</option>');
                    }
                }
            });
        }

        $("#districtSelect").change(function(){
            var district_id = $(this).val();
            get_cities(district_id);
        });

        function get_cities(district_id) {
            $.ajax({
                url: "{{ route('get-cities') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    district_id: district_id,
                    city_id: '{{ old('city_id') }}'
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#citySelect').html(response); 
                }
            });
        }

        $("#showCountrySelect").click(function(){

            $(".country-select").show();
            $(".country-select").attr('required', true);

            $(".other-field-wrapper").hide();
            $(".other-country").attr('required', false);
            $(".other-country").attr('disabled', true);

            $('#countrySelect option:first').prop('selected',true);

            $("#inputPhoneNo").attr('required', true);
            $("#inputEmail").attr('required', true);

            get_states(0);
        });
        
	</script>
    <script>
        $("#register-show").on("click", function (e) {
            e.preventDefault();
            $(".reg").hide();
            $(".sig").show();
            $("#login-box").hide();
            $("#sign-up-box").show();

        });
        $("#login-show").on("click", function (e) {
            e.preventDefault();
            $(".sig").hide();
            $(".reg").show();
            $("#login-box").show();
            $("#sign-up-box").hide();

        });
    </script>
@endpush