@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | Dashboard | @parent
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
				<li class="list-group-item"><dl class="dl-horizontal">
					<dt></dt>
					<dd><h2>{{$user->first_name}} {{$user->last_name}}</h2> <a href="/dashboard/users/{{$user->id}}/edit">Edit</a></dd>
					<dt></dt>
					<dd>{{$user->email}}</dd>
					<dt></dt>
					<dd>{{$user->phone_number}}</dd>
					<hr>
					<dt>Active</dt>
					<dd>@if($user->active) YES @else NO @endif</dd>

					@if($user->gender)
					<dt>Gender</dt>
					<dd>{{$user->gender}}</dd>
					@endif

					@if($user->date_of_birth)
					<dt>Date of Birth</dt>
					<dd><time datetime="{{$user->date_of_birth}}">{{$user->date_of_birth->toFormattedDateString()}}</time></dd>
					@endif

					@if($user->active && $user->activated_on)
					<dt>Activated on</dt>
					<dd>
						<time datetime="{{$user->activated_on}}">{{$user->activated_on->toFormattedDateString()}}</time>
						<time datetime="{{$user->activated_on}}">( {{$user->activated_on->diffInDays()}} days ago )</time>
					</dd>
					@endif

					@if($user->last_login)
					<dt>Last Login</dt>
					<dd>
						<time datetime="{{$user->last_login}}">{{$user->last_login->toFormattedDateString()}}</time>
						<time datetime="{{$user->last_login}}">( {{$user->last_login->diffInDays()}} days ago )</time>
					</dd>
					@endif

					<!-- <dt>ID Verification</dt>
					<dd>
						@if($user->verify_id == '2') Id docs have been verified <i class="fa fa-check" style="color:green" data-toggle="tooltip" title="Verified User"></i> 
						@elseif($user->verify_id == '1') Id docs have been submitted for verification <i class="fa fa-hourglass-start" style="color:pink" data-toggle="tooltip" title="Submitted"></i> 
						@elseif($user->verify_id == '0') Did not submit id docs for verification <i class="fa fa-clock-o" data-toggle="tooltip" title="Not submitted"></i> 
						@elseif($user->verify_id == '-1') Verification failed please <i class="fa fa-refresh" style="color:red" data-toggle="tooltip" title="Try Again (verification failed)"></i> 
						@else <i class="fa fa-clock-o" data-toggle="tooltip" title="Not submitted"></i> @endif
					</dd>
					<hr>
					<dt>verify ID</dt>
					<dd>
						@if($user->investmentDoc->where('user_id',$user->id)->last())
						<a href="/{{$user->investmentDoc->where('user_id',$user->id)->last()->path}}">verify ID documents</a>
						@endif
					</dd> -->
					<dt>Change status</dt>
					<dd>
						@if($user->active && $user->activated_on) <a href="{{route('dashboard.users.deactivate', [$user])}}">Deactivate</a>
						@else Not Active <br> <a href="{{route('dashboard.users.activate', [$user])}}">Activate</a>@endif
					</dd>
					<hr>
					<dd>
						<?php 
							$user_id = $user->id;
		 				?>
						<a href="{{route('dashboard.users.investments', [$user_id])}}" style="font-size: 1.3em;">User Investments</a>
					</dd>
				</dl>
			</li>
		</ul>
{{--  		<ul class="list-group">
			@if($user->investments->count())
			@foreach($user->investments as $project)
			<a href="{{route('dashboard.projects.show', [$project])}}" class="list-group-item">{{$project->title}} <i class="fa fa-angle-right pull-right"></i></a>
			@endforeach
			@else
			<li class="list-group-item text-center alert alert-warning">Not Shown any Interest </li>
			@endif
		</ul> --}}
	</div>
</div>
@stop
