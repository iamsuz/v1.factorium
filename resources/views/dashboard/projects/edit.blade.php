@extends('layouts.main')

@section('title-section')
Edit {{$project->title}} | Dashboard | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>3])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			@if ($errors->has())
			<br>
			<div class="alert alert-danger">
				@foreach ($errors->all() as $error)
				{{ $error }}<br>
				@endforeach
			</div>
			<br>
			@endif
			{!! Form::model($project, array('route'=>['projects.update', $project], 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'PATCH', 'files'=>true)) !!}
			<section>
				<div class="row well">
					<fieldset>
						<div class="col-md-12 center-block">
							<h3 class="text-center"><small><a href="{{route('dashboard.projects.show', [$project])}}" class="pull-left"><i class="fa fa-chevron-left"></i>  BACK</a></small> Edit <i>{{$project->title}}</i></h3>
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
							<div class="text-center">
								<h3 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">Change the Status of project! <br>
									<small class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Activate or Deactivate | Deactivated projects are only seen by admins</small>
								</h3>
							</div>
							<div class="row text-center">
								<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
									<input type="checkbox" name="active-checkbox" id="active-checkbox" autocomplete="off" data-label-text="Active" @if($project->active) checked value="1" @else value="0" @endif>
									<input type="hidden" name="active" id="active" @if($project->active) value="1" @else value="0" @endif>

									<input type="checkbox" name="is_coming_soon_checkbox" id="is_coming_soon_checkbox" data-label-text="upcoming" @if($project->is_coming_soon) value="1" checked @else value="0" @endif>
									<input type="hidden" name="is_coming_soon" id="is_coming_soon" @if($project->is_coming_soon) value="1" @else value="0" @endif>

									<input type="checkbox" name="show_invest_now_button_checkbox" id="show_invest_now_button_checkbox" data-label-text="Invest Now" @if($project->show_invest_now_button) value="1" checked @else value="0" @endif>
									<input type="hidden" name="show_invest_now_button" id="show_invest_now_button" @if($project->show_invest_now_button) value="1" @else value="0" @endif>

									<br><br>
									<h3>Venture</h3>
									<input type="radio" name="property_type" data-label-text="Prop-Dev" value="1" @if($project->property_type == '1') checked @endif class="switch-radio1">
									<input type="radio" name="property_type" data-label-text="Business" value="2" @if($project->property_type == '2') checked @endif class="switch-radio1">
									
									<!-- <input type="checkbox" name="venture-checkbox" id="venture-checkbox" autocomplete="off" data-label-text="Venture" data-on-text="Prop-Dev" data-off-text="Business" data-off-color="warning" @if($project->property_type == '1') checked value="1" @else value="0" @endif> -->
									<br><br>
									<h3>Download PDF Page</h3>
									<input type="checkbox" name="show_download_pdf_page_checkbox" id="show_download_pdf_page_checkbox" autocomplete="off" data-label-text="Show" @if($project->show_download_pdf_page) value="1" checked @else value="0" @endif >
									<input type="hidden" name="show_download_pdf_page" id="show_download_pdf_page" @if($project->show_download_pdf_page) value="1" @else value="0" @endif>

									<br><br>
									<div class="hide" id="invite-developer">s
										<br>
										<br>
										<div class="row">
											<div class="col-md-offset-3 col-md-6">
												<input type="text" name="developerEmail" class="form-control" placeholder="Enter Developers Email">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('button_label')){{'has-error'}} @endif">
									{!!Form::label('button_label', 'Button Label', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('button_label', null, array('placeholder'=>'Button Label to be Displayed during Investment', 'class'=>'form-control ', 'tabindex'=>'3')) !!}
										{!! $errors->first('button_label', '<small class="text-danger">:message</small>') !!}
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
								@if(file_exists(public_path('assets/documents/projects/'.$project->id.'/section_32.pdf')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/section_32.pdf" target="_blank">Section-32</a>
								</div>
								@elseif(file_exists(public_path('assets/documents/projects/'.$project->id.'/section_32.doc')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/section_32.doc" target="_blank">Section-32</a>
									<br><br>
								</div>
								@else
								<div class="form-group @if($errors->first('doc1')){{'has-error'}} @endif">
									{!!Form::label('doc1', 'Section-32', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc1', array('class'=>'form-control', 'tabindex'=>'9','placeholder'=>'Only Pdf or Doc')) !!}
										{!! $errors->first('doc1', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
								@endif
							</div>
							<div class="row">
								@if(file_exists(public_path('assets/documents/projects/'.$project->id.'/plans_permit.pdf')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/plans_permit.pdf" target="_blank">Plans and Permit</a>
								</div>
								@elseif(file_exists(public_path('assets/documents/projects/'.$project->id.'/plans_permit.doc')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/plans_permit.doc" target="_blank">Plans and Permit</a>
									<br><br>
								</div>
								@else
								<div class="form-group @if($errors->first('doc2')){{'has-error'}} @endif">
									{!!Form::label('doc2', 'Plans and Permit', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc2', array('class'=>'form-control', 'tabindex'=>'10')) !!}
										{!! $errors->first('doc2', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
								@endif
							</div>
							<div class="row">
								@if(file_exists(public_path('assets/documents/projects/'.$project->id.'/feasiblity_study.pdf')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/feasiblity_study.pdf" target="_blank">Feasibility Study</a>
								</div>
								@elseif(file_exists(public_path('assets/documents/projects/'.$project->id.'/feasiblity_study.doc')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/feasiblity_study.doc" target="_blank">Feasibility Study</a>
									<br><br>
								</div>
								@else
								<div class="form-group @if($errors->first('doc3')){{'has-error'}} @endif">
									{!!Form::label('doc3', 'Feasibility Study', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc3', array('class'=>'form-control', 'tabindex'=>'11')) !!}
										{!! $errors->first('doc3', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
								@endif
							</div>
							<div class="row">
								@if(file_exists(public_path('assets/documents/projects/'.$project->id.'/optional_doc1.pdf')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/optional_doc1.pdf" target="_blank">Optional Doc 1</a>
								</div>
								@elseif(file_exists(public_path('assets/documents/projects/'.$project->id.'/optional_doc1.doc')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/optional_doc1.doc" target="_blank">Optional Doc 1</a>
									<br><br>
								</div>
								@else
								<div class="form-group @if($errors->first('doc4')){{'has-error'}} @endif">
									{!!Form::label('doc4', 'Optional Doc 1', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc4', array('class'=>'form-control', 'tabindex'=>'13')) !!}
										{!! $errors->first('doc4', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
								@endif
							</div>
							<div class="row">
								@if(file_exists(public_path('assets/documents/projects/'.$project->id.'/optional_doc2.pdf')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/optional_doc2.pdf" target="_blank">Optional Doc 2</a>
								</div>
								@elseif(file_exists(public_path('assets/documents/projects/'.$project->id.'/optional_doc2.doc')))
								<div class="col-sm-9 col-sm-offset-2">
									<a href="/assets/documents/projects/{{$project->id}}/optional_doc2.doc" target="_blank">Optional Doc 2</a>
									<br><br>
								</div>
								@else
								<div class="form-group @if($errors->first('doc5')){{'has-error'}} @endif">
									{!!Form::label('doc5', 'Optional Doc 2', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::file('doc5', array('class'=>'form-control', 'tabindex'=>'14')) !!}
										{!! $errors->first('doc5', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
								@endif
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
													{!! Form::text('goal_amount', $project->investment?$project->investment->goal_amount:null, array('placeholder'=>'Funds Required', 'class'=>'form-control', 'tabindex'=>'3','required'=>'yes')) !!}
													{!! $errors->first('goal_amount','<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('minimum_accepted_amount', 'Min amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('minimum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('minimum_accepted_amount', $project->investment?$project->investment->minimum_accepted_amount:null, array('placeholder'=>'Minimum Accepted', 'class'=>'form-control', 'tabindex'=>'4','required'=>'yes')) !!}
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
									{!!Form::label('total_projected_costs', 'Total Cost', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('total_projected_costs')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('total_projected_costs', $project->investment?$project->investment->total_projected_costs:null, array('placeholder'=>'Total Cost', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('total_projected_costs', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('maximum_accepted_amount', 'Max amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('maximum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('maximum_accepted_amount', $project->investment?$project->investment->maximum_accepted_amount:null, array('placeholder'=>'Maximum Accepted', 'class'=>'form-control', 'tabindex'=>'6','required'=>'yes')) !!}
													{!! $errors->first('maximum_accepted_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('total_debt') && $errors->first('total_equity')){{'has-error'}} @endif">
									{!!Form::label('total_debt', 'Total Debt', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('total_debt')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('total_debt', $project->investment?$project->investment->total_debt:null, array('placeholder'=>'Total Debt', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('total_debt', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('total_equity', 'Total Equity', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('total_equity')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('total_equity', $project->investment?$project->investment->total_equity:null, array('placeholder'=>'Total Equity', 'class'=>'form-control', 'tabindex'=>'6','required'=>'yes')) !!}
													{!! $errors->first('total_equity', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('projected_return') && $errors->first('hold_period')){{'has-error'}} @endif">
									{!!Form::label('projected_returns', 'Projected Return', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('projected_returns')){{'has-error'}} @endif">
												<div class="input-group">
													{!! Form::text('projected_returns', $project->investment?$project->investment->projected_returns:null, array('placeholder'=>'Projected Returns', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('projected_returns', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">%</div>
												</div>
											</div>
											{!!Form::label('hold_period', 'Hold period', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('hold_period')){{'has-error'}} @endif">
												<div class="input-group">
													{!! Form::text('hold_period', $project->investment?$project->investment->hold_period:null, array('placeholder'=>'Hold Period', 'class'=>'form-control', 'tabindex'=>'6','required'=>'yes')) !!}
													{!! $errors->first('hold_period', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">months</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('developer_equity')){{'has-error'}} @endif">
									{!!Form::label('developer_equity', 'Developer Equity', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('developer_equity')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('developer_equity', $project->investment?$project->investment->developer_equity:null, array('placeholder'=>'developer equity', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('developer_equity', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('fund_raising_start_date')){{'has-error'}} @endif">
									{!!Form::label('fund_raising_start_date', 'fund raising start date', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('fund_raising_start_date')){{'has-error'}} @endif">
												<div class="">
													{!! Form::input('date', 'fund_raising_start_date', $project->investment->fund_raising_start_date?$project->investment->fund_raising_start_date->toDateString():null, array('placeholder'=>'fund raising start date', 'class'=>'form-control')) !!}
													{!! $errors->first('fund_raising_start_date', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('fund_raising_close_date', 'fund raising close date', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('fund_raising_close_date')){{'has-error'}} @endif">
												<div class="">
													{!! Form::input('date', 'fund_raising_close_date', $project->investment->fund_raising_close_date?$project->investment->fund_raising_close_date->toDateString():null, array('placeholder'=>'fund raising close date', 'class'=>'form-control')) !!}
													{!! $errors->first('fund_raising_close_date', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('proposer')){{'has-error'}} @endif">
									{!!Form::label('proposer', 'Developer', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('proposer')){{'has-error'}} @endif">
												{!! Form::text('proposer', $project->investment?$project->investment->proposer:null, array('placeholder'=>'Developer', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('proposer', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('summary')){{'has-error'}} @endif">
									{!!Form::label('summary', 'Summary', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('summary')){{'has-error'}} @endif">
												{!! Form::textarea('summary', $project->investment?$project->investment->summary:null, array('placeholder'=>'Summary', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('summary', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('security_long')){{'has-error'}} @endif">
									{!!Form::label('security_long', 'Security Long', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('security_long')){{'has-error'}} @endif">
												{!! Form::textarea('security_long', $project->investment?$project->investment->security_long:null, array('placeholder'=>'Security Long', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('security_long', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('rationale')){{'has-error'}} @endif">
									{!!Form::label('rationale', 'Rationale', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('rationale')){{'has-error'}} @endif">
												{!! Form::textarea('rationale', $project->investment?$project->investment->rationale:null, array('placeholder'=>'rationale', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('rationale', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('current_status')){{'has-error'}} @endif">
									{!!Form::label('current_status', 'Current Status', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('current_status')){{'has-error'}} @endif">
												{!! Form::textarea('current_status', $project->investment?$project->investment->current_status:null, array('placeholder'=>'Current Status', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('current_status', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('marketability')){{'has-error'}} @endif">
									{!!Form::label('marketability', 'Marketability', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('marketability')){{'has-error'}} @endif">
												{!! Form::textarea('marketability', $project->investment?$project->investment->marketability:null, array('placeholder'=>'marketability', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('marketability', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('residents')){{'has-error'}} @endif">
									{!!Form::label('residents', 'Residents', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('residents')){{'has-error'}} @endif">
												{!! Form::textarea('residents', $project->investment?$project->investment->residents:null, array('placeholder'=>'residents', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('residents', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('risk')){{'has-error'}} @endif">
									{!!Form::label('risk', 'Risk', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('risk')){{'has-error'}} @endif">
												{!! Form::textarea('risk', $project->investment?$project->investment->risk:null, array('placeholder'=>'risk', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('risk', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('how_to_invest')){{'has-error'}} @endif">
									{!!Form::label('how_to_invest', 'How To Invest', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('how_to_invest')){{'has-error'}} @endif">
												{!! Form::textarea('how_to_invest', $project->investment?$project->investment->how_to_invest:null, array('placeholder'=>'how to invest', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('how_to_invest', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('bank') && $errors->first('bank_account_name')){{'has-error'}} @endif">
									{!!Form::label('bank', 'Bank', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('bank')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bank', $project->investment?$project->investment->bank:null, array('placeholder'=>'Bank Name', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('bank', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('bank_account_name', 'Account Name', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('bank_account_name')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bank_account_name', $project->investment?$project->investment->bank_account_name:null, array('placeholder'=>'Account Name', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('bank_account_name', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('bsb') && $errors->first('bank_account_number')){{'has-error'}} @endif">
									{!!Form::label('bsb', 'BSB', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('bsb')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bsb', $project->investment?$project->investment->bsb:null, array('placeholder'=>'BSB', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('bsb', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('bank_account_number', 'Account Number', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('bank_account_number')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bank_account_number', $project->investment?$project->investment->bank_account_number:null, array('placeholder'=>'Account Number', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('bank_account_number', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('bank_reference') && $errors->first('embedded_offer_doc_link')){{'has-error'}} @endif">
									{!!Form::label('bank_reference', 'Reference', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('bank_reference')){{'has-error'}} @endif">
												{!! Form::text('bank_reference', $project->investment?$project->investment->bank_reference:null, array('placeholder'=>'Bank Reference', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('bank_reference', '<small class="text-danger">:message</small>') !!}
											</div>
											{!!Form::label('embedded_offer_doc_link', 'Embedded Offer Doc link', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('embedded_offer_doc_link')){{'has-error'}} @endif">
												{!! Form::text('embedded_offer_doc_link', $project->investment?$project->investment->embedded_offer_doc_link:null, array('placeholder'=>'embedded offer doc link', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('embedded_offer_doc_link', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('PDS_part_1_link') && $errors->first('PDS_part_2_link')){{'has-error'}} @endif">
									{!!Form::label('PDS_part_1_link', 'PDS Part 1 link', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('PDS_part_1_link')){{'has-error'}} @endif">
												{!! Form::text('PDS_part_1_link', $project->investment?$project->investment->PDS_part_1_link:null, array('placeholder'=>'PDS Part 1 link', 'class'=>'form-control')) !!}
												{!! $errors->first('PDS_part_1_link', '<small class="text-danger">:message</small>') !!}
											</div>
											{!!Form::label('PDS_part_2_link', 'PDS Part 2 link', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('PDS_part_2_link')){{'has-error'}} @endif">
												{!! Form::text('PDS_part_2_link', $project->investment?$project->investment->PDS_part_2_link:null, array('placeholder'=>'PDS Part 2 Link', 'class'=>'form-control', 'tabindex'=>'6')) !!}
												{!! $errors->first('PDS_part_2_link', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('exit_d')){{'has-error'}} @endif">
									{!!Form::label('exit_d', 'Investor Distributor', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('exit_d')){{'has-error'}} @endif">
												{!! Form::textarea('exit_d', $project->investment?$project->investment->exit_d:null, array('placeholder'=>'Investor Distributor', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('exit_d', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('investment_type')){{'has-error'}} @endif">
									{!!Form::label('investment_type', 'Investment Type', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('investment_type')){{'has-error'}} @endif">
												{!! Form::textarea('investment_type', $project->investment?$project->investment->investment_type:null, array('placeholder'=>'Investment Type', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('investment_type', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('security')){{'has-error'}} @endif">
									{!!Form::label('security', 'Security', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('security')){{'has-error'}} @endif">
												{!! Form::textarea('security', $project->investment?$project->investment->security:null, array('placeholder'=>'Security', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('security', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('expected_returns_long')){{'has-error'}} @endif">
									{!!Form::label('expected_returns_long', 'Expected Returns', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('expected_returns_long')){{'has-error'}} @endif">
												{!! Form::textarea('expected_returns_long', $project->investment?$project->investment->expected_returns_long:null, array('placeholder'=>'Expected Returns', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('expected_returns_long', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('returns_paid_as')){{'has-error'}} @endif">
									{!!Form::label('returns_paid_as', 'Returns Paid As', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('returns_paid_as')){{'has-error'}} @endif">
												{!! Form::textarea('returns_paid_as', $project->investment?$project->investment->returns_paid_as:null, array('placeholder'=>'Returns Paid As', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('returns_paid_as', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('taxation')){{'has-error'}} @endif">
									{!!Form::label('taxation', 'Taxation', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('taxation')){{'has-error'}} @endif">
												{!! Form::textarea('taxation', $project->investment?$project->investment->taxation:null, array('placeholder'=>'Taxation', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('taxation', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('plans_permit_url')){{'has-error'}} @endif">
									{!!Form::label('plans_permit_url', 'Plans and Permit Document', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('plans_permit_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('plans_permit_url', $project->investment?$project->investment->plans_permit_url:null, array('placeholder'=>'Plans and Permit Document URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('plans_permit_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('construction_contract_url', 'Construction Contract', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('construction_contract_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('construction_contract_url', $project->investment?$project->investment->construction_contract_url:null, array('placeholder'=>'Construction contract URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('construction_contract_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('consultancy_agency_agreement_url')){{'has-error'}} @endif">
									{!!Form::label('consultancy_agency_agreement_url', 'Consultancy and Agency Agreement', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('consultancy_agency_agreement_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('consultancy_agency_agreement_url', $project->investment?$project->investment->consultancy_agency_agreement_url:null, array('placeholder'=>'Consultancy and Agency agreement URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('consultancy_agency_agreement_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('debt_details_url', 'Debt Details Document', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('debt_details_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('debt_details_url', $project->investment?$project->investment->debt_details_url:null, array('placeholder'=>'debt details URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('debt_details_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('master_pds_url')){{'has-error'}} @endif">
									{!!Form::label('master_pds_url', 'Master PDS Document', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('master_pds_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('master_pds_url', $project->investment?$project->investment->master_pds_url:null, array('placeholder'=>'Master PDS URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('master_pds_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('caveats_url', 'Caveats Document', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('caveats_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('caveats_url', $project->investment?$project->investment->caveats_url:null, array('placeholder'=>'caveats URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('caveats_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('land_ownership_url')){{'has-error'}} @endif">
									{!!Form::label('land_ownership_url', 'Land Ownership Document', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('land_ownership_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('land_ownership_url', $project->investment?$project->investment->land_ownership_url:null, array('placeholder'=>'land ownership URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('land_ownership_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('valuation_report_url', 'Valuation Report Document', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('valuation_report_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('valuation_report_url', $project->investment?$project->investment->valuation_report_url:null, array('placeholder'=>'valuation report URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('valuation_report_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('investments_structure_video_url')){{'has-error'}} @endif">
									{!!Form::label('investments_structure_video_url', 'Investment Structure Video URL', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('investments_structure_video_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('investments_structure_video_url', $project->investment?$project->investment->investments_structure_video_url:null, array('placeholder'=>'Investment Structure Video URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('investments_structure_video_url', '<small class="text-danger">:message</small>') !!}
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
			<div class="row well hide">
				<div class="col-md-12">
					<fieldset>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-9">
									{!! Form::submit('Update Above Info', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
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
													{!! Form::text('goal_amount', $project->investment?$project->investment->goal_amount:null, array('placeholder'=>'Funds Required', 'class'=>'form-control', 'tabindex'=>'3','required'=>'yes')) !!}
													{!! $errors->first('goal_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('minimum_accepted_amount', 'Min amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('minimum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('minimum_accepted_amount', $project->investment?$project->investment->minimum_accepted_amount:null, array('placeholder'=>'Minimum Accepted', 'class'=>'form-control', 'tabindex'=>'4','required'=>'yes')) !!}
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
													{!! Form::text('total_projected_costs', $project->investment?$project->investment->total_projected_costs:null, array('placeholder'=>'Total Projected Costs', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('total_projected_costs', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('maximum_accepted_amount', 'Max amount', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('maximum_accepted_amount')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('maximum_accepted_amount', $project->investment?$project->investment->maximum_accepted_amount:null, array('placeholder'=>'Maximum Accepted', 'class'=>'form-control', 'tabindex'=>'6','required'=>'yes')) !!}
													{!! $errors->first('maximum_accepted_amount', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('total_debt') && $errors->first('total_equity')){{'has-error'}} @endif">
									{!!Form::label('total_debt', 'Total Debt', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('total_debt')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('total_debt', $project->investment?$project->investment->total_debt:null, array('placeholder'=>'Total Debt', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('total_debt', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
											{!!Form::label('total_equity', 'Total Equity', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('total_equity')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('total_equity', $project->investment?$project->investment->total_equity:null, array('placeholder'=>'Total Equity', 'class'=>'form-control', 'tabindex'=>'6','required'=>'yes')) !!}
													{!! $errors->first('total_equity', '<small class="text-danger">:message</small>') !!}
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
													{!! Form::text('projected_returns', $project->investment?$project->investment->projected_returns:null, array('placeholder'=>'Projected Returns', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('projected_returns', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">%</div>
												</div>
											</div>
											{!!Form::label('hold_period', 'Hold period', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('hold_period')){{'has-error'}} @endif">
												<div class="input-group">
													{!! Form::text('hold_period', $project->investment?$project->investment->hold_period:null, array('placeholder'=>'Hold Period', 'class'=>'form-control', 'tabindex'=>'6','required'=>'yes')) !!}
													{!! $errors->first('hold_period', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">months</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('developer_equity')){{'has-error'}} @endif">
									{!!Form::label('developer_equity', 'Developer Equity', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('developer_equity')){{'has-error'}} @endif">
												<div class="input-group">
													<div class="input-group-addon">$</div>
													{!! Form::text('developer_equity', $project->investment?$project->investment->developer_equity:null, array('placeholder'=>'developer equity', 'class'=>'form-control', 'tabindex'=>'5','required'=>'yes')) !!}
													{!! $errors->first('developer_equity', '<small class="text-danger">:message</small>') !!}
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('fund_raising_start_date')){{'has-error'}} @endif">
									{!!Form::label('fund_raising_start_date', 'fund raising startdate', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('fund_raising_start_date')){{'has-error'}} @endif">
												<div class="">
													{!! Form::input('date', 'fund_raising_start_date',null, array('placeholder'=>'fund raising startdate', 'class'=>'form-control')) !!}
													{!! $errors->first('fund_raising_start_date', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('fund_raising_close_date', 'fund raising closedate', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('fund_raising_close_date')){{'has-error'}} @endif">
												<div class="">
													{!! Form::input('date', 'fund_raising_close_date',null, array('placeholder'=>'fund raising closedate', 'class'=>'form-control')) !!}
													{!! $errors->first('fund_raising_close_date', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('proposer')){{'has-error'}} @endif">
									{!!Form::label('proposer', 'Developer', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('proposer')){{'has-error'}} @endif">
												{!! Form::text('proposer', $project->investment?$project->investment->proposer:null, array('placeholder'=>'Developer', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('proposer', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('summary')){{'has-error'}} @endif">
									{!!Form::label('summary', 'Summary', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('summary')){{'has-error'}} @endif">
												{!! Form::textarea('summary', $project->investment?$project->investment->summary:null, array('placeholder'=>'Summary', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('summary', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('security_long')){{'has-error'}} @endif">
									{!!Form::label('security_long', 'Security Long', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('security_long')){{'has-error'}} @endif">
												{!! Form::textarea('security_long', $project->investment?$project->investment->security_long:null, array('placeholder'=>'Security Long', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('security_long', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('rationale')){{'has-error'}} @endif">
									{!!Form::label('rationale', 'Rationale', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('rationale')){{'has-error'}} @endif">
												{!! Form::textarea('rationale', $project->investment?$project->investment->rationale:null, array('placeholder'=>'rationale', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('rationale', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('current_status')){{'has-error'}} @endif">
									{!!Form::label('current_status', 'Current Status', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('current_status')){{'has-error'}} @endif">
												{!! Form::textarea('current_status', $project->investment?$project->investment->current_status:null, array('placeholder'=>'current status', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('current_status', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('marketability')){{'has-error'}} @endif">
									{!!Form::label('marketability', 'Marketability', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('marketability')){{'has-error'}} @endif">
												{!! Form::textarea('marketability', $project->investment?$project->investment->marketability:null, array('placeholder'=>'marketability', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('marketability', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('residents')){{'has-error'}} @endif">
									{!!Form::label('residents', 'Residents', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('residents')){{'has-error'}} @endif">
												{!! Form::textarea('residents', $project->investment?$project->investment->residents:null, array('placeholder'=>'residents', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('residents', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('risk')){{'has-error'}} @endif">
									{!!Form::label('risk', 'Risk', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('risk')){{'has-error'}} @endif">
												{!! Form::textarea('risk', $project->investment?$project->investment->risk:null, array('placeholder'=>'risk', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('risk', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('how_to_invest')){{'has-error'}} @endif">
									{!!Form::label('how_to_invest', 'How To Invest', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('how_to_invest')){{'has-error'}} @endif">
												{!! Form::textarea('how_to_invest', $project->investment?$project->investment->how_to_invest:null, array('placeholder'=>'how to invest', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('how_to_invest', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('bank') && $errors->first('bank_account_name')){{'has-error'}} @endif">
									{!!Form::label('bank', 'Bank', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('bank')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bank', $project->investment?$project->investment->bank:null, array('placeholder'=>'Bank Name', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('bank', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('bank_account_name', 'Account Name', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('bank_account_name')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bank_account_name', $project->investment?$project->investment->bank_account_name:null, array('placeholder'=>'Account Name', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('bank_account_name', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('bsb') && $errors->first('bank_account_number')){{'has-error'}} @endif">
									{!!Form::label('bsb', 'BSB', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('bsb')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bsb', $project->investment?$project->investment->bsb:null, array('placeholder'=>'BSB', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('bsb', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('bank_account_number', 'Account Number', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('bank_account_number')){{'has-error'}} @endif">
												<div class="input-group" style="width:100%;">
													{!! Form::text('bank_account_number', $project->investment?$project->investment->bank_account_number:null, array('placeholder'=>'Account Number', 'class'=>'form-control', 'tabindex'=>'6')) !!}
													{!! $errors->first('bank_account_number', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('bank_reference') && $errors->first('embedded_offer_doc_link')){{'has-error'}} @endif">
									{!!Form::label('bank_reference', 'Reference', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('bank_reference')){{'has-error'}} @endif">
												{!! Form::text('bank_reference', $project->investment?$project->investment->bank_reference:null, array('placeholder'=>'Bank Reference', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('bank_reference', '<small class="text-danger">:message</small>') !!}
											</div>
											{!!Form::label('embedded_offer_doc_link', 'Embedded Offer Doc link', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('embedded_offer_doc_link')){{'has-error'}} @endif">
												{!! Form::text('embedded_offer_doc_link', $project->investment?$project->investment->embedded_offer_doc_link:null, array('placeholder'=>'embedded offer doc link', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('embedded_offer_doc_link', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('PDS_part_1_link') && $errors->first('PDS_part_2_link')){{'has-error'}} @endif">
									{!!Form::label('PDS_part_1_link', 'PDS Part 1 link', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('PDS_part_1_link')){{'has-error'}} @endif">
												{!! Form::text('PDS_part_1_link', $project->investment?$project->investment->PDS_part_1_link:null, array('placeholder'=>'PDS Part 1 link', 'class'=>'form-control')) !!}
												{!! $errors->first('PDS_part_1_link', '<small class="text-danger">:message</small>') !!}
											</div>
											{!!Form::label('PDS_part_2_link', 'PDS Part 2 link', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('PDS_part_2_link')){{'has-error'}} @endif">
												{!! Form::text('PDS_part_2_link', $project->investment?$project->investment->PDS_part_2_link:null, array('placeholder'=>'PDS Part 2 Link', 'class'=>'form-control', 'tabindex'=>'6')) !!}
												{!! $errors->first('PDS_part_2_link', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('exit_d')){{'has-error'}} @endif">
									{!!Form::label('exit_d', 'Investor Distributor', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('exit_d')){{'has-error'}} @endif">
												{!! Form::textarea('exit_d', $project->investment?$project->investment->exit_d:null, array('placeholder'=>'Investor Distributor', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('exit_d', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('investment_type')){{'has-error'}} @endif">
									{!!Form::label('investment_type', 'Investment Type', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('investment_type')){{'has-error'}} @endif">
												{!! Form::textarea('investment_type', $project->investment?$project->investment->investment_type:null, array('placeholder'=>'Investment Type', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('investment_type', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('security')){{'has-error'}} @endif">
									{!!Form::label('security', 'Security', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('security')){{'has-error'}} @endif">
												{!! Form::textarea('security', $project->investment?$project->investment->security:null, array('placeholder'=>'Security', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('security', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('expected_returns_long')){{'has-error'}} @endif">
									{!!Form::label('expected_returns_long', 'Expected Returns', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('expected_returns_long')){{'has-error'}} @endif">
												{!! Form::textarea('expected_returns_long', $project->investment?$project->investment->expected_returns_long:null, array('placeholder'=>'Expected Returns', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('expected_returns_long', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('returns_paid_as')){{'has-error'}} @endif">
									{!!Form::label('returns_paid_as', 'Returns Paid As', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('returns_paid_as')){{'has-error'}} @endif">
												{!! Form::textarea('returns_paid_as', $project->investment?$project->investment->returns_paid_as:null, array('placeholder'=>'Returns Paid As', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('returns_paid_as', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('taxation')){{'has-error'}} @endif">
									{!!Form::label('taxation', 'Taxation', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 @if($errors->first('taxation')){{'has-error'}} @endif">
												{!! Form::textarea('taxation', $project->investment?$project->investment->taxation:null, array('placeholder'=>'Taxation', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
												{!! $errors->first('taxation', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('plans_permit_url')){{'has-error'}} @endif">
									{!!Form::label('plans_permit_url', 'Plans and Permit Document', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('plans_permit_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('plans_permit_url', $project->investment?$project->investment->plans_permit_url:null, array('placeholder'=>'Plans and Permit Document URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('plans_permit_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('construction_contract_url', 'Construction Contract', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('construction_contract_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('construction_contract_url', $project->investment?$project->investment->construction_contract_url:null, array('placeholder'=>'Construction contract URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('construction_contract_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('consultancy_agency_agreement_url')){{'has-error'}} @endif">
									{!!Form::label('consultancy_agency_agreement_url', 'Consultancy and Agency Agreement', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('consultancy_agency_agreement_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('consultancy_agency_agreement_url', $project->investment?$project->investment->consultancy_agency_agreement_url:null, array('placeholder'=>'Consultancy and Agency agreement URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('consultancy_agency_agreement_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('debt_details_url', 'Debt Details Document', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('debt_details_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('debt_details_url', $project->investment?$project->investment->debt_details_url:null, array('placeholder'=>'debt details URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('debt_details_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('master_pds_url')){{'has-error'}} @endif">
									{!!Form::label('master_pds_url', 'Master PDS Document', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('master_pds_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('master_pds_url', $project->investment?$project->investment->master_pds_url:null, array('placeholder'=>'Master PDS URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('master_pds_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('caveats_url', 'Caveats Document', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('caveats_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('caveats_url', $project->investment?$project->investment->caveats_url:null, array('placeholder'=>'caveats URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('caveats_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('land_ownership_url')){{'has-error'}} @endif">
									{!!Form::label('land_ownership_url', 'Land Ownership Document', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('land_ownership_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('land_ownership_url', $project->investment?$project->investment->land_ownership_url:null, array('placeholder'=>'land ownership URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('land_ownership_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('valuation_report_url', 'Valuation Report Document', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('valuation_report_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('valuation_report_url', $project->investment?$project->investment->valuation_report_url:null, array('placeholder'=>'valuation report URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('valuation_report_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('consent_url')){{'has-error'}} @endif">
									{!!Form::label('consent_url', 'Consents Document', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('consent_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('consent_url', $project->investment?$project->investment->consent_url:null, array('placeholder'=>'Consents URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('consent_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
											{!!Form::label('spv_url', 'SPV Document', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('spv_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('spv_url', $project->investment?$project->investment->spv_url:null, array('placeholder'=>'SPV Document URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('spv_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('investments_structure_video_url')){{'has-error'}} @endif">
									{!!Form::label('investments_structure_video_url', 'Investment Structure Video URL', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-5 @if($errors->first('investments_structure_video_url')){{'has-error'}} @endif">
												<div class="">
													{!! Form::text('investments_structure_video_url', $project->investment?$project->investment->investments_structure_video_url:null, array('placeholder'=>'Investment Structure Video URL', 'class'=>'form-control', 'tabindex'=>'5')) !!}
													{!! $errors->first('investments_structure_video_url', '<small class="text-danger">:message</small>') !!}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
										{!! Form::submit('Add New Details', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
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
				<div class="row well">
					<div class="col-md-12">
						<div class="row">
							@foreach($project->projectFAQs as $faq)
							<div class="col-md-offset-2 col-md-7">
								<b>{{$faq->question}}</b>
								{{$faq->id}}
								<p class="text-justify">{{$faq->answer}}</p>
							</div>
							<div class="col-md-2"> 
								{!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $faq->id, $project->id]]) !!}
								{!! Form::submit('Delete this FAQ?', ['class' => 'btn btn-danger']) !!}
								{!! Form::close() !!}
							</div>
							@endforeach
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.faq', $project->id], 'class'=>'form-horizontal', 'role'=>'form')) !!}
								<fieldset>
									<div class="row">
										<div class="form-group @if($errors->first('question')){{'has-error'}} @endif">
											{!!Form::label('question', 'Question', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('question')){{'has-error'}} @endif">
														{!! Form::text('question', null, array('placeholder'=>'Question', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
														{!! $errors->first('question', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('answer')){{'has-error'}} @endif">
											{!!Form::label('answer', 'Answer', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('answer')){{'has-error'}} @endif">
														{!! Form::textarea('answer', null, array('placeholder'=>'Answer', 'class'=>'form-control', 'tabindex'=>'5', 'rows'=>'3')) !!}
														{!! $errors->first('answer', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-9">
												{!! Form::submit('Add New FAQ', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
											</div>
										</div>
									</div>
								</fieldset>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					Add Image For Main Image 1366 X 500
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								@foreach($project->media->chunk(1) as $set)
								<div class="row">
									@foreach($set as $photo)
									@if($photo->type === 'main_image')
									<div class="col-md-4">
										<div class="thumbnail">
											<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
											<div class="caption">
												{{$photo->type}}
												<a href="#" class="pull-right">Delete</a>
											</div>
										</div>
									</div>
									@else
									{{-- <h4>Add a Marketability Image</h4> --}}
									@endif
									@endforeach
								</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.storePhoto', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					Add Image For Marketability
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								@foreach($project->media->chunk(1) as $set)
								<div class="row">
									@foreach($set as $photo)
									@if($photo->type === 'marketability')
									<div class="col-md-4">
										<div class="thumbnail">
											<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
											<div class="caption">
												{{$photo->type}}
												<a href="#" class="pull-right">Delete</a>
											</div>
										</div>
									</div>
									@else
									{{-- <h4>Add a Marketability Image</h4> --}}
									@endif
									@endforeach
								</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.storePhotoMarketability', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					Add Image For Developer
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								@foreach($project->media->chunk(1) as $set)
								<div class="row">
									@foreach($set as $photo)
									@if($photo->type === 'project_developer')
									<div class="col-md-4">
										<div class="thumbnail">
											<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
											<div class="caption">
												{{$photo->type}}
												<a href="#" class="pull-right">Delete</a>
											</div>
										</div>
									</div>
									@else
									{{-- <h4>Add a Marketability Image</h4> --}}
									@endif
									@endforeach
								</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.storePhotoProjectDeveloper', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					Add Image For Investment Structure
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								@foreach($project->media->chunk(1) as $set)
								<div class="row">
									@foreach($set as $photo)
									@if($photo->type === 'investment_structure')
									<div class="col-md-4">
										<div class="thumbnail">
											<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
											<div class="caption">
												{{$photo->type}}
												<a href="#" class="pull-right">Delete</a>
											</div>
										</div>
									</div>
									@else
									{{-- <h4>Add a Marketability Image</h4> --}}
									@endif
									@endforeach
								</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.storePhotoInvestmentStructure', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					Add Image For Exit
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								@foreach($project->media->chunk(1) as $set)
								<div class="row">
									@foreach($set as $photo)
									@if($photo->type === 'exit_image')
									<div class="col-md-4">
										<div class="thumbnail">
											<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
											<div class="caption">
												{{$photo->type}}
												<a href="#" class="pull-right">Delete</a>
											</div>
										</div>
									</div>
									@else
									{{-- <h4>Add a Exit Image</h4> --}}
									@endif
									@endforeach
								</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.storePhotoExit', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					Add Image For Project Thumbnail 1024 X 683
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								@foreach($project->media->chunk(1) as $set)
								<div class="row">
									@foreach($set as $photo)
									@if($photo->type === 'project_thumbnail')
									<div class="col-md-4">
										<div class="thumbnail">
											<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
											<div class="caption">
												{{$photo->type}}
												<a href="#" class="pull-right">Delete</a>
											</div>
										</div>
									</div>
									@else
									{{-- <h4>Add a Marketability Image</h4> --}}
									@endif
									@endforeach
								</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.storePhotoProjectThumbnail', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section>
				<div class="row well">
					Add Image For Residents
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								@foreach($project->media->chunk(1) as $set)
								<div class="row">
									@foreach($set as $photo)
									@if($photo->type === 'residents')
									<div class="col-md-4">
										<div class="thumbnail">
											<img src="/{{$photo->path}}" alt="{{$photo->caption}}" class="img-responsive">
											<div class="caption">
												{{$photo->type}}
												<a href="#" class="pull-right">Delete</a>
											</div>
										</div>
									</div>
									@else
									{{-- <h4>Add a Residents Image 2</h4> --}}
									@endif
									@endforeach
								</div>
								@endforeach
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.storePhotoResidents1', $project->id], 'class'=>'form-horizontal dropzone', 'role'=>'form', 'files'=>true)) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#invite-only-label').click(function() {
			$('#invite-developer').removeClass('hide');
		});
		$("#is_coming_soon_checkbox").bootstrapSwitch();
		$('#is_coming_soon_checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#is_coming_soon').val(setVal);
		});
		$("#active-checkbox").bootstrapSwitch();
		$('#active-checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#active').val(setVal);
		});
		$("#venture-checkbox").bootstrapSwitch();
		$('#venture-checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#venture').val(setVal);
		});
		$("#show_invest_now_button_checkbox").bootstrapSwitch();
		$('#show_invest_now_button_checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#show_invest_now_button').val(setVal);
		});
		$(".property_type").bootstrapSwitch();
		// $('#property_type').on('switchChange.bootstrapSwitch', function () {
			// var setVal = $(this).val() == 1? 0 : 1;
			// $(this).val(setVal);
			// $('#venture').val(setVal);
		// });
		$("[name='property_type']").bootstrapSwitch();
		$('input[name="property_type"]').on('change', function(){
			if ($(this).val()=='1') {
         		//change to "show update"
         		$("#name").text("Development Name");
         		$("#location").text("Development Location");
         		$("#plan").text("Upload Development Proposal");
         		$("#ven").addClass("hide");
         		$("#pro-dev").removeClass("hide");
         		$("#ven1").addClass("hide");
         		$("#pro-dev1").removeClass("hide");
         	} else  {
         		$("#name").text("Venture Name");
         		$("#location").text("Venture Location");
         		$("#plan").text("Upload Investment Proposal");
         		$("#ven").removeClass("hide");
         		$("#pro-dev").addClass("hide");
         		$("#ven1").removeClass("hide");
         		$("#pro-dev1").addClass("hide");
         	}
         });
		$("#show_download_pdf_page_checkbox").bootstrapSwitch();
		$('#show_download_pdf_page_checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#show_download_pdf_page').val(setVal);
		});
	});
</script>
@stop