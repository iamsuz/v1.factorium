@extends('layouts.main')

@section('title-section')
{{$role->role}} | @parent
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title text-center">Role Details</h3>
				</div>
				<ul class="list-group">
					<li class="list-group-item">Role: {{$role->role}}</li>
					<li class="list-group-item">Description: {{$role->description}}</li>
				</ul>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title text-center">All the {{$role->role}}</h3>
				</div>
				<ul class="list-group">
					@foreach($users as $user)
					<li class="list-group-item">{{$user->first_name}} {{$user->last_name}}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@stop