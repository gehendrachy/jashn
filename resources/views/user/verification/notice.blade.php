@extends('layouts.app')

@section('content')
    <div class="page-title pt32 pb32 bg-light">
	    <div class="container">
	        <div class="row">
	            <div class="col-sm-8">
	                <h3 class="page-title-head">
	                    Verify your Account
	                </h3>
	                <div class="page-list">
	                    <ul class="breadcrumb">
	                        <li><a href="{{ route('home') }}">Home /</a></li>
	                        <li>Verify your Account</li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    <div class="container p-5 rounded">
        <h1>Verify Your Account</h1>
        
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        Before proceeding, please check your email for a verification link. If you did not receive the email,
        <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="d-inline btn btn-link p-0">
                click here to request another
            </button>.
        </form>
    </div>
@endsection