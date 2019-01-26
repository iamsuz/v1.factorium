@extends('layouts.main')
@section('title-section')
{{$project->title}} | Dashboard | @parent
@stop
@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>3])
		</div>
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<h3 class="text-center">{{$project->title}}
								<small><a href="{{route('dashboard.projects.edit', [$project])}}" class="pull-right">EDIT</a></small>
							</h3>
							<p class="text-center">{!! $project->description !!}</p>
							<address class="text-center">
								<b>{{$project->location->line_1}}, {{$project->location->line_2}}, {{$project->location->city}}, {{$project->location->postal_code}},{{$project->location->country}}</b>
							</address>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h4 class="text-center">Developer: <a href="{{route('dashboard.users.show', [$project->user])}}">{{$project->user->first_name}} {{$project->user->last_name}}</a> ({{$project->user->email}})</h4>
							<h4 class="text-center">Developer As: @if($project->investment) {{$project->investment->proposer}} @else Not set yet @endif</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							{!! Form::open(array('route'=>['dashboard.projects.toggleStatus', $project], 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'PATCH')) !!}
							<fieldset>
								<div class="text-center">
									<h3 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">Change the Status of project! <br>
										<small class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Activate it, keep it private for admins or deactivate it.</small>
									</h3>
								</div>
								<div class="row text-center">
									<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-primary @if($project->active == 2) active @endif eb-checkbox">
												<input type="radio" name="active" id="private" autocomplete="off" value="2" tabindex="1" @if($project->active == 2) checked @endif >
												Private
											</label>
											<label class="btn btn-primary eb-checkbox @if($project->active == 1) active @endif">
												<input type="radio" name="active" id="activate" autocomplete="off" value="1" tabindex="2" @if($project->active == 1) checked @endif >
												@if($project->active == 1) Activated @else Activate @endif
											</label>
											<label class="btn btn-primary eb-checkbox @if($project->active == 0) active @endif">
												<input type="radio" name="active" id="deactivate" autocomplete="off" value="0" tabindex="3" @if($project->active == 0) checked @endif >
												@if($project->active == 0) Deactivated @else Deactivate @endif
											</label>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="form-group">
										<div class="col-sm-offset-5 col-sm-2">
											{!! Form::submit('Submit', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'6')) !!}
										</div>
									</div>
								</div>
							</fieldset>
							{!! Form::close() !!}
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left">Goal Amount:<b> @if($project->investment)${{number_format($project->investment->goal_amount)}} @else Not set yet @endif</b></h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-right"> Collected:<b>@if($project->investment) ${{number_format($investments->sum('amount'))}} @else Not set yet @endif</b></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left">Min Accepted:<b>@if($project->investment) ${{number_format($project->investment->minimum_accepted_amount)}} @else Not set yet @endif</b></h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-right">Max Accepted:<b>@if($project->investment) ${{number_format($project->investment->maximum_accepted_amount)}} @else Not set yet @endif</b></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left">Total Costs:<b>@if($project->investment) ${{number_format($project->investment->total_projected_costs)}} @else Not set yet @endif</b></h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-right">Projected Return:<b>@if($project->investment) {{$project->investment->projected_returns}} % @else Not set yet @endif</b></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left">Total Debt:<b>@if($project->investment) ${{number_format($project->investment->total_debt)}} @else Not set yet @endif</b></h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-right">Total Equity:<b>@if($project->investment) ${{number_format($project->investment->total_equity)}} @else Not set yet @endif</b></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left"><b>Summary:</b>@if($project->investment) {{$project->investment->summary}} @else Not set yet @endif</h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-left"><b>Security Long:</b>@if($project->investment) {{$project->investment->security_long}} @else Not set yet @endif</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left"><b>Rationale:</b>@if($project->investment) {{$project->investment->rationale}} @else Not set yet @endif</h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-left"><b>Current Status:</b>@if($project->investment) {{$project->investment->current_status}} @else Not set yet @endif</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left"><b>Exit:</b>@if($project->investment) {{$project->investment->exit}} @else Not set yet @endif</h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-left"><b>Investment Type:</b>@if($project->investment) {{$project->investment->investment_type}} @else Not set yet @endif</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left"><b>Security:</b>@if($project->investment) {{$project->investment->security}} @else Not set yet @endif</h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-left"><b>Expected Returns:</b>@if($project->investment) {{$project->investment->expected_returns_long}} @else Not set yet @endif</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left"><b>Returns Paid As:</b>@if($project->investment) {{$project->investment->returns_paid_as}} @else Not set yet @endif</h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-left"><b>Taxation:</b>@if($project->investment) {{$project->investment->taxation}} @else Not set yet @endif</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<h4 class="text-left"><b>Marketability:</b>@if($project->investment) {{$project->investment->marketability}} @else Not set yet @endif</h4>
						</div>
						<div class="col-md-6">
							<h4 class="text-left"><b>Taxation:</b>@if($project->investment) {{$project->investment->taxation}} @else Not set yet @endif</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							@foreach($project->media->chunk(3) as $set)
							<div class="row">
								@foreach($set as $photo)
								<div class="col-md-4">
									<div class="thumbnail">
										<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
										<div class="caption">
											{{$photo->type}}
										</div>
									</div>
								</div>
								@endforeach
							</div>
							@endforeach
						</div>
					</div>
					<h3 class="text-center">Investors</h3>
					<ul class="list-group">
						@foreach($project->investors as $investor)
						<a href="{{route('dashboard.users.show', [$investor])}}" class="list-group-item">
							<div class="row text-center">
								<div class="col-md-4 text-left"><b>{{$investor->first_name}} {{$investor->last_name}}</b><br>{{$investor->email}}<br>{{$investor->phone_number}}</div>
								<div class="col-md-4">{{$investor->created_at->toFormattedDateString()}}</div>
								<div class="col-md-4">${{number_format($investments->where('user_id', $investor->id)->first()->amount) }}</div>
							</div>
						</a>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@stop