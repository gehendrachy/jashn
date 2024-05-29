@extends('layouts.app')
@section('title', "Log In")
@push('post-css')

@endpush
@section('content')
	<div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Log In
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li>Log In</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row sign d-flex justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-4">
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
            <div class="col-lg-4 col-md-6 col-sm-4 sign-social">

                <div class="social">
                    <div class="login-box">
                        <!-- <h6>Or Continue Using </h6> -->
                        <a href="{{ route('social.login',['provider' => 'facebook']) }}" class="social-button" id="facebook-connect"> <span>Login with Facebook</span></a>
                        <a href="{{ route('social.login',['provider' => 'google']) }}" class="social-button" id="google-connect"> <span>Login with Google</span></a>
                        <!-- <a href="#" class="social-button" id="twitter-connect"> <span>Connect with Twitter</span></a>
                        <a href="#" class="social-button" id="linkedin-connect"> <span>Connect with LinkedIn</span></a> -->
                        <div class="buttons text-left">
                            <p>New member ? <a href="{{ route('user.register') }}">Register Here</a></p>
                        </div>
                    </div>
                    <!-- <hr> -->
                </div>

            </div>
        </div>
    </div>
@endsection
@push('post-scripts')
	<script>

		$("#click-ship").click(function(){
            $("#shipping-address").toggle();
        });
        
	</script>
@endpush