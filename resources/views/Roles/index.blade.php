@extends('layouts.main')

@section('title-section')
All Roles | @parent
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<h3 class="text-center">List of All Roles</h3>
			<br>
			<div class="list-group">
				@foreach($roles as $role)
				{!! Html::linkRoute('roles.show', $role->role, $role->id, ['class'=>'list-group-item']) !!}
				@endforeach
			</div>
		</div>
	</div>
</div>
@stop