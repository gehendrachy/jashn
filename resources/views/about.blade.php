@extends('layouts.app')
@section('title', $content->title)
@section('content')
	<div class="page-title pt32 pb32 bg-light">
	    <div class="container">
	        <div class="row">
	            <div class="col-sm-8">
	                <h3 class="page-title-head">
	                    {{ $content->title }}
	                </h3>
	                <div class="page-list">
	                    <ul class="breadcrumb">
	                        <li><a href="{{ route('home') }}">Home /</a></li>
	                        <li>{{ $content->title }}</li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<section class="pt40 pb40">
	    <div class="container">
	        <div class="row">
	            <div class="col-sm-12">
	                <h class="robot"><strong>{{ $content->title }}</strong></h>
	                <hr>
	                
	            </div>

	            <div class="col-sm-12">
	                {!! $content->content !!}
	            </div>

	        </div>
	    </div>
	</section>
@endsection