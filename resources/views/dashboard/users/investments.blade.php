@extends('layouts.main')

@section('title-section')
{{$user->first_name}} Investments | Dashboard | @parent
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>2])
		</div>
		<div class="col-md-10">
			<ul class="list-group">
				<li class="list-group-item">
					<div class="text-center">
						<h3>{{$user->first_name}} {{$user->last_name}}<br><small>{{$user->email}}</small></h3>
					</div>
				</li>
			</ul>
			<h3 class="text-center">Investments</h3>
			<ul class="list-group">
				@if($user->investments->count())
				@foreach($user->investments as $project)
				<a href="{{route('dashboard.projects.show', [$project])}}" class="list-group-item">{{$project->title}}</a>
				@endforeach
				@else
				<li class="list-group-item text-center alert alert-warning">Not Shown any Interest</li>
				@endif
			</ul>
		</div>
	</div>
</div>
@stop
