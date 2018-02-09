@extends('layouts.main')

@section('title-section')
Edit Project | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
@stop

@section('content-section')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			{!! Form::model($project, array('route'=>['projects.update', $project], 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'PATCH', 'files'=>true)) !!}
			<section>
				<div class="row well">
					<fieldset>
						<div class="col-md-12 center-block">
							<h3 class="text-center"><small><a href="{{route('projects.show', [$project])}}" class="pull-left"><i class="fa fa-chevron-left"></i>  BACK</a></small> Edit <i>{{$project->title}}</i></h3>
							<br>
							<div class="row">
								<div class="form-group @if($errors->first('title')){{'has-error'}} @endif">
									{!!Form::label('title', 'Title', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('title', null, array('placeholder'=>'Project Title', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
										{!! $errors->first('title', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('description')){{'has-error'}} @endif">
									{!!Form::label('description', 'Description', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::textarea('description', null, array('placeholder'=>'Description', 'class'=>'form-control', 'tabindex'=>'2', 'rows'=>'3')) !!}
										{!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('additional_info')){{'has-error'}} @endif">
									{!!Form::label('additional_info', 'Additional Info', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::textarea('additional_info', null, array('placeholder'=>'Additional Information', 'class'=>'form-control', 'tabindex'=>'12', 'rows'=>'3')) !!}
										{!! $errors->first('additional_info', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</section>
			<section>
				<div class="row well">
					<div class="col-md-12">
						<fieldset>
							<div class="row">
								<div class="form-group @if($errors->first('line_1') && $errors->first('line_2')){{'has-error'}} @endif">
									{!!Form::label('line_1', 'Lines', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('line_1')){{'has-error'}} @endif">
												{!! Form::text('line_1', $project->location->line_1, array('placeholder'=>'line 1', 'class'=>'form-control', 'tabindex'=>'3')) !!}
												{!! $errors->first('line_1', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('line_2')){{'has-error'}} @endif">
												{!! Form::text('line_2', $project->location->line_2, array('placeholder'=>'line 2', 'class'=>'form-control', 'tabindex'=>'4')) !!}
												{!! $errors->first('line_2', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('city') && $errors->first('state')){{'has-error'}} @endif">
									{!!Form::label('city', 'City', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('city')){{'has-error'}} @endif">
												{!! Form::text('city', $project->location->city, array('placeholder'=>'City', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('city', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('state')){{'has-error'}} @endif">
												{!! Form::text('state', $project->location->state, array('placeholder'=>'state', 'class'=>'form-control', 'tabindex'=>'6')) !!}
												{!! $errors->first('state', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif">
									{!!Form::label('postal_code', 'postal code', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif">
												{!! Form::text('postal_code', $project->location->postal_code, array('placeholder'=>'postal code', 'class'=>'form-control', 'tabindex'=>'7')) !!}
												{!! $errors->first('postal_code', '<small class="text-danger">:message</small>') !!}
											</div>
											<div class="col-sm-6 @if($errors->first('country')){{'has-error'}} @endif">
												<select name="country" class="form-control" tabindex="8">
													@foreach(\App\Http\Utilities\Country::aus() as $country => $code)
													<option value="{{$code}}" @if($project->location->country_code == $code) selected @endif>{{$country}}</option>
													@endforeach
												</select>
												{!! $errors->first('country', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					<div class="col-md-12">
						<fieldset>
							<div class="row">
								<div class="form-group @if($errors->first('doc1')){{'has-error'}} @endif">
									{!!Form::label('doc1', 'Doc 1', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc1', array('class'=>'form-control', 'tabindex'=>'9')) !!}
										{!! $errors->first('doc1', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('doc2')){{'has-error'}} @endif">
									{!!Form::label('doc2', 'Doc 2', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc2', array('class'=>'form-control', 'tabindex'=>'10')) !!}
										{!! $errors->first('doc2', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('doc3')){{'has-error'}} @endif">
									{!!Form::label('doc3', 'Doc 3', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc3', array('class'=>'form-control', 'tabindex'=>'11')) !!}
										{!! $errors->first('doc3', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('doc4')){{'has-error'}} @endif">
									{!!Form::label('doc4', 'Doc 4', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc4', array('class'=>'form-control', 'tabindex'=>'13')) !!}
										{!! $errors->first('doc4', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('doc5')){{'has-error'}} @endif">
									{!!Form::label('doc5', 'Doc 5', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc5', array('class'=>'form-control', 'tabindex'=>'14')) !!}
										{!! $errors->first('doc5', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</section>
			@if($project->investment)
			<section>
				<div class="row well">
					<div class="col-md-12">
						<fieldset>
							<div class="row">
								<div class="form-group @if($errors->first('goal_amount') && $errors->first('minimum_accepted_amount')){{'has-error'}} @endif">
									{!!Form::label('goal_amount', 'Goal Amount', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('goal_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('goal_amount', $project->investment?$project->investment->goal_amount:null, array('placeholder'=>'Funds Required', 'class'=>'form-control', 'tabindex'=>'3')) !!}
													{!! $errors->first('goal_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('minimum_accepted_amount', 'Min amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('minimum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('minimum_accepted_amount', $project->investment?$project->investment->minimum_accepted_amount:null, array('placeholder'=>'Minimum Accepted', 'class'=>'form-control', 'tabindex'=>'4')) !!}
													{!! $errors->first('minimum_accepted_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('total_projected_costs') && $errors->first('maximum_accepted_amount')){{'has-error'}} @endif">
									{!!Form::label('total_projected_costs', 'Total Costs', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('total_projected_costs')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('total_projected_costs', $project->investment?$project->investment->total_projected_costs:null, array('placeholder'=>'Total Projected Cost', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('total_projected_costs', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('maximum_accepted_amount', 'Max amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('maximum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('maximum_accepted_amount', $project->investment?$project->investment->maximum_accepted_amount:null, array('placeholder'=>'Maximum Accepted', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('maximum_accepted_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('minimum_capital_raising') && $errors->first('maximum_capital_raising')){{'has-error'}} @endif">
									{!!Form::label('minimum_capital_raising', 'Min Capital', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('minimum_capital_raising')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('minimum_capital_raising', $project->investment?$project->investment->minimum_capital_raising:null, array('placeholder'=>'Minimum Capital Raising', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('minimum_capital_raising', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('maximum_capital_raising', 'Max Capital', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('maximum_capital_raising')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('maximum_capital_raising', $project->investment?$project->investment->maximum_capital_raising:null, array('placeholder'=>'Maximum Capital Raising', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('maximum_capital_raising', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('projected_returns') && $errors->first('hold_period')){{'has-error'}} @endif">
									{!!Form::label('projected_returns', 'Projected Return', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('projected_returns')){{'has-error'}} @endif">
												<div class="input-group">
													{!! Form::text('projected_returns', $project->investment?$project->investment->projected_returns:null, array('placeholder'=>'Projected Returns', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('projected_returns', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">%</div>
												</div>
											</div>
											{!!Form::label('hold_period', 'Hold period', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('hold_period')){{'has-error'}} @endif">
												<div class="input-group">
													{!! Form::text('hold_period', $project->investment?$project->investment->hold_period:null, array('placeholder'=>'Hold Period', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('hold_period', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">months</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
										{!! Form::submit('Update', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</section>
			{!! Form::close() !!}
			@else

			<div class="row well">
				<div class="col-md-12">
					<fieldset>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-9">
									{!! Form::submit('Update', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			{!! Form::close() !!}
			<section>
				<div class="row well">
					<div class="col-md-12">
						{!! Form::open(array('route'=>['projects.investments', $project->id], 'class'=>'form-horizontal', 'role'=>'form')) !!}
						<fieldset>
							<div class="row">
								<div class="form-group @if($errors->first('goal_amount') && $errors->first('minimum_accepted_amount')){{'has-error'}} @endif">
									{!!Form::label('goal_amount', 'Goal Amount', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('goal_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('goal_amount', $project->investment?$project->investment->goal_amount:null, array('placeholder'=>'Funds Required', 'class'=>'form-control', 'tabindex'=>'3')) !!}
													{!! $errors->first('goal_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('minimum_accepted_amount', 'Min amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('minimum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('minimum_accepted_amount', $project->investment?$project->investment->minimum_accepted_amount:null, array('placeholder'=>'Minimum Accepted', 'class'=>'form-control', 'tabindex'=>'4')) !!}
													{!! $errors->first('minimum_accepted_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('total_projected_costs') && $errors->first('maximum_accepted_amount')){{'has-error'}} @endif">
									{!!Form::label('total_projected_costs', 'Total Costs', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('total_projected_costs')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('total_projected_costs', $project->investment?$project->investment->total_projected_costs:null, array('placeholder'=>'Total Projected Cost', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('total_projected_costs', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('maximum_accepted_amount', 'Max amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('maximum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('maximum_accepted_amount', $project->investment?$project->investment->maximum_accepted_amount:null, array('placeholder'=>'Maximum Accepted', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('maximum_accepted_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('minimum_capital_raising') && $errors->first('maximum_capital_raising')){{'has-error'}} @endif">
									{!!Form::label('minimum_capital_raising', 'Min Capital', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('minimum_capital_raising')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('minimum_capital_raising', $project->investment?$project->investment->minimum_capital_raising:null, array('placeholder'=>'Minimum Capital Raising', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('minimum_capital_raising', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('maximum_capital_raising', 'Max Capital', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('maximum_capital_raising')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('maximum_capital_raising', $project->investment?$project->investment->maximum_capital_raising:null, array('placeholder'=>'Maximum Capital Raising', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('maximum_capital_raising', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('projected_returns') && $errors->first('hold_period')){{'has-error'}} @endif">
									{!!Form::label('projected_returns', 'Projected Return', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('projected_returns')){{'has-error'}} @endif">
												<div class="input-group">
													{!! Form::text('projected_returns', $project->investment?$project->investment->projected_returns:null, array('placeholder'=>'Projected Returns', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('projected_returns', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">%</div>
												</div>
											</div>
											{!!Form::label('hold_period', 'Hold period', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('hold_period')){{'has-error'}} @endif">
												<div class="input-group">
													{!! Form::text('hold_period', $project->investment?$project->investment->hold_period:null, array('placeholder'=>'Hold Period', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('hold_period', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">months</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
										{!! Form::submit('Add Investment Info', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
									</div>
								</div>
							</div>
						</fieldset>
						{!! Form::close() !!}
					</div>
				</div>
			</section>
			@endif

			<section>
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(array('route'=>['projects.storePhoto', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
						{!! Form::close() !!}
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						@foreach($project->media->chunk(3) as $set)
						<div class="row">
							@foreach($set as $photo)
							<div class="col-md-4">
								<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
							</div>
							@endforeach
						</div>
						@endforeach
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
@stop