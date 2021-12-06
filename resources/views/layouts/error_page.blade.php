@extends('layouts.public', ['seo' => false])

@section('title', $code)

@section('content')
	<div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url({{ asset('img/error.jpg') }});">
		<h1 class="font-weight-boldest text-dark-75 mt-15">{{ $code }}</h1>
		<p class="font-size-h3 text-muted font-weight-normal">{{ !empty($exception->getMessage()) ? $exception->getMessage() : __('errors.'.$code.'.message') }}</p>
		<a href="{{ route('home') }}" class="text-hover-primary"><i class="fa fa-home"></i> {{ __('global.home') }}</a>
	</div>
@endsection