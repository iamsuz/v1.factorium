@extends('layouts.main')

@section('title-section')
All Projects | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>Auth::user(), 'active'=>2])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			@foreach($projects as $project)
			<div class="row">
				<div class="col-md-offset-1 col-md-2 text-center">
					<img src="{{asset('assets/images/pitch_image.jpg')}}" width="100" alt="{{$project->title}}" style="padding-top:40%">
				</div>
				<div class="col-md-8">
					<a href="{{route('projects.show', [$project])}}"><h3>{{$project->title}}</h3></a>
					<h3><small>{{substr($project->description, 0, 140)}}...</small></h3>
					@if($project->investment)
					<?php
					$pledged_amount = $pledged_investments->where('project_id', $project->id)->sum('amount');
					$pledged_user_count = $pledged_investments->where('project_id', $project->id)->count();
					$completed_percent= ($pledged_amount/$project->investment->goal_amount)*1;
					?>
					@endif
					<div class="row">
						<div class="col-md-4 text-center">
							<div class="circle" data-value="{{$completed_percent}}" data-size="60" data-thickness="10" data-animation-start-value="1.0" data-reverse="true"></div> <h4><small>{{round(($completed_percent*100), 2)}} % Funded</small></h4>
						</div>
						<h4 class="col-md-4"><small>{{$pledged_user_count}} Users shown Interested</small></h4>
						<div class="col-md-4">
							<a href="{{route('projects.interest', [$project])}}" class="btn btn-primary btn-block" @if(Auth::user() && Auth::user()->investments->contains($project)) data-disabled disabled @endif>
								@if(Auth::user() && Auth::user()->investments->contains($project))
								Already Shown Interest
								@else
								show Interest
								@endif
							</a>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="js/circle-progress.js"></script>
<script type="text/javascript">
	$(function () {
		$('.circle').circleProgress({
			fill: {
				gradient: ["#3D9970"]
			}
		});
	});
</script>
@stop