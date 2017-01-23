@extends('layouts.main')

@section('title-section')
{{$user->first_name}} interests | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>2])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					@foreach($interests as $project)
					<div class="row">
						<div class="col-md-2 text-center">
							<img src="{{asset('assets/images/pitch_image.jpg')}}" width="100" alt="{{$project->title}}" style="padding-top:40%">
						</div>
						<div class="col-md-10">
							<a href="{{route('projects.show', [$project])}}">
							<font style="font-family: SourceSansPro-Bold; font-size:22px;color:#282a73;">{{$project->title}}</font>
							</a>
							<br>
							<font style="font-family: SourceSansPro-Regular; font-size:16px;color:#282a73;">{{substr($project->description, 0, 140)}}...</font>
							@if($project->investment)
							<?php
							$pledged_amount = $pledged_investments->where('project_id', $project->id)->sum('amount');
							$pledged_user_count = $pledged_investments->where('project_id', $project->id)->count();
							$completed_percent= ($pledged_amount/$project->investment->goal_amount)*1;
							?>
							@endif
							<div class="row">
								<div class="col-md-6 text-center">
									<font style="font-family: SourceSansPro-Bold; font-size:16px;color:#282a73;">{{$completed_percent *100}} % Funded</font>
								</div>
								<div class="col-md-6"><font style="font-family: SourceSansPro-Bold; font-size:16px;color:#282a73;">{{$pledged_user_count}} Users shown Interested</font></div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@stop