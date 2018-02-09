@extends('layouts.main')

@section('title-section')
All Users | @parent
@stop

@section('css-section')
@parent

@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<h3 class="text-center">List of All Users</h3>
			<br>
			<div class="list-group">
				@foreach($users as $user)
				<a href="{{route('users.show', [$user])}}" class="list-group-item">
					<div class="row">
						<div class="col-md-1">
							<img src="/assets/images/default-{{ $user->gender }}.png" width="50" alt="{{ $user->first_name }} {{ $user->last_name}}" class="img-circle">
						</div>
						<div class="col-md-9">
							<h4 class="list-group-item-heading">{{ $user->first_name }} {{ $user->last_name}}</h4>
							<p class="list-group-item-text"><small>{{ $user->email }}</small> | <small>{{ $user->phone_number }}</small></p>
							<p class="list-group-item-text"><small>@if($user->active) Active @else Not Active @endif</small></p>
						</div>
						<div class="col-md-2"><small>@if($user->last_login){{$user->last_login->diffForHumans()}}@else Not logged in yet @endif</small></div>
					</div>
				</a>
				@endforeach
			</div>
			{!! $users->render() !!}
		</div>
	</div>
</div>
@stop

@section('js-section')
@stop