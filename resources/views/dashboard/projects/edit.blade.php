@extends('layouts.main')

@section('title-section')
Edit {{$project->title}} | Dashboard | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{csrf_token()}}" />
@endsection

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
				@if(!$project->projectspvdetail)
				<div class="alert alert-danger text-center">Please add the <b>Project SPV Details</b> to make the project <b>Live</b>. You can still make the status of the project as <b>Upcoming</b> or <b>EOI</b>.</div>
				@endif
					<fieldset>
						<div class="col-md-12 center-block">
							<h3 class="text-center"><small>{{-- <a href="{{route('dashboard.projects.show', [$project])}}" class="pull-left hide"><i class="fa fa-chevron-left"></i>  BACK</a> --}}</small> Edit <i>{{$project->title}}</i></h3>
							<br>
							<div class="row" style="display: none;">
								<div class="form-group @if($errors->first('title')){{'has-error'}} @endif">
									{!!Form::label('title', 'Title', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::text('title', null, array('placeholder'=>'Project Title', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
										{!! $errors->first('title', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							{{--<div class="row">
								<div class="form-group @if($errors->first('description')){{'has-error'}} @endif">
									{!!Form::label('description', 'Description', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::textarea('description', null, array('placeholder'=>'Description', 'class'=>'form-control', 'tabindex'=>'2', 'rows'=>'3')) !!}
										{!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>--}}
							<div style="display: none;" class="row">
								<div class="form-group @if($errors->first('additional_info')){{'has-error'}} @endif">
									{!!Form::label('additional_info', 'Additional Info', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										{!! Form::textarea('additional_info', null, array('placeholder'=>'Additional Information', 'class'=>'form-control', 'tabindex'=>'12', 'rows'=>'3')) !!}
										{!! $errors->first('additional_info', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
							<div class="text-center">
								<h3 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">Change the Status of Project <br>
									{{-- <small class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Activate or Deactivate | Deactivated projects are only seen by admins</small> --}}
								</h3>
							</div>
							<div class="row text-center">
								<div class="col-md-12 wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.4s">
									{{-- <input type="checkbox" name="active-checkbox" id="active-checkbox" autocomplete="off" data-label-text="Active" @if(!$project->projectspvdetail && $project->is_coming_soon == '0') disabled @endif @if($project->active) checked value="1" @else value="0" @endif>
									<input type="hidden" name="active" id="active" @if($project->active) value="1" @else value="0" @endif>

									<input type="checkbox" name="is_coming_soon_checkbox" id="is_coming_soon_checkbox" data-label-text="upcoming" @if($project->is_coming_soon) value="1" checked @else value="0" @endif>
									<input type="hidden" name="is_coming_soon" id="is_coming_soon" @if($project->is_coming_soon) value="1" @else value="0" @endif>

									<input type="checkbox" name="show_invest_now_button_checkbox" id="show_invest_now_button_checkbox" data-label-text="Invest Now" @if($project->show_invest_now_button) value="1" checked @else value="0" @endif>
									<input type="hidden" name="show_invest_now_button" id="show_invest_now_button" @if($project->show_invest_now_button) value="1" @else value="0" @endif>

									<input type="checkbox" name="eoi_button_checkbox" id="eoi_button_checkbox" data-label-text="EOI" @if($project->eoi_button) value="1" checked @else value="0" @endif>
									<input type="hidden" name="eoi_button" id="eoi_button" @if($project->eoi_button) value="1" @else value="0" @endif> --}}

									{{-- <br><br>
									<h3>Venture</h3>
									<input type="radio" name="property_type" data-label-text="Prop-Dev" value="1" @if($project->property_type == '1') checked @endif class="switch-radio1">
									<input type="radio" name="property_type" data-label-text="Business" value="2" @if($project->property_type == '2') checked @endif class="switch-radio1"> --}}

									<!-- <input type="checkbox" name="venture-checkbox" id="venture-checkbox" autocomplete="off" data-label-text="Venture" data-on-text="Prop-Dev" data-off-text="Business" data-off-color="warning" @if($project->property_type == '1') checked value="1" @else value="0" @endif> -->
									{{-- <br><br>
									<h3>Download PDF Page</h3>
									<input type="checkbox" name="show_download_pdf_page_checkbox" id="show_download_pdf_page_checkbox" autocomplete="off" data-label-text="Show" @if($project->show_download_pdf_page) value="1" checked @else value="0" @endif >
									<input type="hidden" name="show_download_pdf_page" id="show_download_pdf_page" @if($project->show_download_pdf_page) value="1" @else value="0" @endif> --}}
									<br>

									<div class="btn-group project-progress-3way-switch" data-toggle="buttons">
									      <label class="btn btn-default @if(!$project->active) active @endif">
									        <input type="radio" name="project_status" value="inactive"> Inactive
									      </label>
									      <label class="btn btn-default @if($project->active && !$project->is_coming_soon && !$project->is_funding_closed && !$project->eoi_button) active @endif" @if(!$project->projectspvdetail) disabled="disabled" style="pointer-events: none;" @endif>
									        <input type="radio" name="project_status" value="active"> Live
									      </label>
									      <label class="btn btn-default @if($project->is_coming_soon && !$project->is_funding_closed && !$project->eoi_button && $project->active) active @endif">
									        <input type="radio" name="project_status" value="upcoming"> Upcoming
									      </label>
									      <label class="btn btn-default @if(!$project->is_coming_soon && $project->eoi_button && !$project->is_funding_closed && $project->active) active @endif">
									        <input type="radio" name="project_status" value="eoi"> EOI
									      </label>
									      <label class="btn btn-default @if(!$project->is_coming_soon && !$project->eoi_button && $project->is_funding_closed && $project->active) active @endif" @if(!$project->projectspvdetail) disabled="disabled" style="pointer-events: none;" @endif>
									        <input type="radio" name="project_status" value="funding_closed"> Close Funding
									      </label>
									</div>
									<br>
									<h3>Share vs Unit</h3>
									<div class="btn-group project-progress-3way-switch" data-toggle="buttons">
										<label class="btn btn-default @if($project->share_vs_unit == 1) active @endif">
									        <input type="radio" name="share_vs_unit" value="1"> Share
									      </label>
									      <label class="btn btn-default @if($project->share_vs_unit == 0) active @endif" >
									        <input type="radio" name="share_vs_unit" value="0"> Unit
									      </label>
									</div>
									<br><br>
									<h3>MD vs Trustee</h3>
									<div class="btn-group project-progress-3way-switch" data-toggle="buttons">
										<label class="btn btn-default @if($project->md_vs_trustee == 1) active @endif">
									        <input type="radio" name="md_vs_trustee" value="1"> MD
									      </label>
									      <label class="btn btn-default @if($project->md_vs_trustee == 0) active @endif" >
									        <input type="radio" name="md_vs_trustee" value="0"> Trustee
									      </label>
									</div>

									<br><br>
									<h3>Retail project vs Wholesale project</h3>
									<div class="btn-group project-progress-3way-switch" data-toggle="buttons">
										<label class="btn btn-default @if($project->retail_vs_wholesale == 1) active @endif">
									        <input type="radio" name="retail_vs_wholesale" value="1"> Retail
									      </label>
									      <label class="btn btn-default @if($project->retail_vs_wholesale == 0) active @endif" >
									        <input type="radio" name="retail_vs_wholesale" value="0"> Wholesale
									      </label>
									</div>

									<br><br>
									<h3>Show interested to buy property checkbox</h3>
									<div class="btn-group project-progress-3way-switch" data-toggle="buttons">
										<label class="btn btn-default @if($project->show_interested_to_buy_checkbox == 1) active @endif">
									        <input type="radio" name="show_interested_to_buy_checkbox" value="1"> On
									      </label>
									      <label class="btn btn-default @if($project->show_interested_to_buy_checkbox == 0) active @endif" >
									        <input type="radio" name="show_interested_to_buy_checkbox" value="0"> Off
									      </label>
									</div>

									<br><br><br>
									<div class="row">
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-8">
												{!! Form::submit('Update', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
											</div>
										</div>
									</div>
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
							<div style="display: none;" class="row">
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
			<section style="display: none;">
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
												{!! Form::text('state', $project->location->state, array('placeholder'=>'State', 'class'=>'form-control', 'tabindex'=>'6')) !!}
												{!! $errors->first('state', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group @if($errors->first('postal_code') && $errors->first('country')){{'has-error'}} @endif">
									{!!Form::label('postal_code', 'Postal Code', array('class'=>'col-sm-2 control-label'))!!}
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-6 @if($errors->first('postal_code')){{'has-error'}} @endif">
												{!! Form::text('postal_code', $project->location->postal_code, array('placeholder'=>'Postal Code', 'class'=>'form-control', 'tabindex'=>'7')) !!}
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
			<section style="display: none;">
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
			<section style="display: none;">
				<div class="row well">
					<div class="col-md-12">
						<fieldset>
							<div class="row" style="display: none;">
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
							<div class="row" style="display: none;">
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
											<div class="col-sm-5 style="display: none;" @if($errors->first('maximum_accepted_amount')){{'has-error'}} @endif">
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
							<div style="display: none;" class="row">
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
							<div class="row" style="display: none;">
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
							<div style="display: none;" class="row">
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
							<div class="row" style="display: none;">
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
							<div class="row" style="display: none;">
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
							<div class="row" style="display: none;">
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
							{{--<div class="row">
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
							</div>--}}
							<div class="row" style="display: none;">
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
							<div class="row" style="display: none;">
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
							<div class="row hide">
								<div class="form-group @if($errors->first('bank_reference') && $errors->first('embedded_offer_doc_link')){{'has-error'}} @endif">
<!-- 									{!!Form::label('bank_reference', 'Reference', array('class'=>'col-sm-2 control-label'))!!} -->
									<div class="col-sm-9">
<!-- 										<div class="row">
											<div class="col-sm-5 @if($errors->first('bank_reference')){{'has-error'}} @endif">
												{!! Form::text('bank_reference', $project->investment?$project->investment->bank_reference:null, array('placeholder'=>'Bank Reference', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('bank_reference', '<small class="text-danger">:message</small>') !!}
											</div> -->
											{!!Form::label('embedded_offer_doc_link', 'Embedded Offer Doc link', array('class'=>'col-sm-3 control-label'))!!}
											<div class="col-sm-5 @if($errors->first('embedded_offer_doc_link')){{'has-error'}} @endif">
												{!! Form::text('embedded_offer_doc_link', $project->investment?$project->investment->embedded_offer_doc_link:null, array('placeholder'=>'embedded offer doc link', 'class'=>'form-control', 'tabindex'=>'5')) !!}
												{!! $errors->first('embedded_offer_doc_link', '<small class="text-danger">:message</small>') !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							{{--<div class="row">
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
							</div>--}}
							{{--<div class="row">
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
							</div>--}}
							<div style="display: none;" class="row">
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
							<div style="display: none;" class="row">
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
							<div style="display: none;" class="row">
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
							<div style="display: none;" class="row">
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
							<div style="display: none;" class="row">
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
							<div class="row" style="display: none;">
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
			<section style="display: none;">
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
											<div class="col-sm-9 @if($errors->first('embedded_offer_doc_link')){{'has-error'}} @endif">
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
			<!-- <section>
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
			</section> -->
			<section>
				<div class="row well">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								{!! Form::open(array('route'=>['projects.projectSPVDetails', $project->id], 'class'=>'form-horizontal', 'role'=>'form')) !!}
								<fieldset>
									<div class="row">
										<div class="form-group @if($errors->first('spv_name')){{'has-error'}} @endif">
											{!!Form::label('spv_name', 'Project SPV Name', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('spv_name')){{'has-error'}} @endif">
														{!! Form::text('spv_name', $project->projectspvdetail?$project->projectspvdetail->spv_name:null, array('placeholder'=>'SPV Name', 'class'=>'form-control', 'tabindex'=>'21', 'id'=>'spv_name')) !!}
														{!! $errors->first('spv_name', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_line_1') || $errors->first('spv_line_2')){{'has-error'}} @endif">
											{!!Form::label('spv_line_1', 'Address Lines', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-6 @if($errors->first('spv_line_1')){{'has-error'}} @endif">
														{!! Form::text('spv_line_1', $project->projectspvdetail?$project->projectspvdetail->spv_line_1:null, array('placeholder'=>'line 1', 'class'=>'form-control', 'tabindex'=>'22', 'id'=>'spv_line_1')) !!}
														{!! $errors->first('spv_line_1', '<small class="text-danger">:message</small>') !!}
													</div>
													<div class="col-sm-6 @if($errors->first('spv_line_2')){{'has-error'}} @endif">
														{!! Form::text('spv_line_2', $project->projectspvdetail?$project->projectspvdetail->spv_line_2:null, array('placeholder'=>'line 2', 'class'=>'form-control', 'tabindex'=>'23', 'id'=>'spv_line_2')) !!}
														{!! $errors->first('spv_line_2', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_city') && $errors->first('spv_state')){{'has-error'}} @endif">
											{!!Form::label('spv_city', 'City', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-6 @if($errors->first('spv_city')){{'has-error'}} @endif">
														{!! Form::text('spv_city', $project->projectspvdetail?$project->projectspvdetail->spv_city:null, array('placeholder'=>'City', 'class'=>'form-control', 'tabindex'=>'24', 'id'=>'spv_city')) !!}
														{!! $errors->first('spv_city', '<small class="text-danger">:message</small>') !!}
													</div>
													<div class="col-sm-6 @if($errors->first('spv_state')){{'has-error'}} @endif">
														{!! Form::text('spv_state', $project->projectspvdetail?$project->projectspvdetail->spv_state:null, array('placeholder'=>'State', 'class'=>'form-control', 'tabindex'=>'25', 'id'=>'spv_state')) !!}
														{!! $errors->first('spv_state', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_postal_code') || $errors->first('spv_country')){{'has-error'}} @endif">
											{!!Form::label('spv_postal_code', 'Postal Code', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-6 @if($errors->first('spv_postal_code')){{'has-error'}} @endif">
														{!! Form::text('spv_postal_code', $project->projectspvdetail?$project->projectspvdetail->spv_postal_code:null, array('placeholder'=>'Postal Code', 'class'=>'form-control', 'tabindex'=>'26', 'id'=>'spv_postal_code')) !!}
														{!! $errors->first('spv_postal_code', '<small class="text-danger">:message</small>') !!}
													</div>
													<div class="col-sm-6 @if($errors->first('spv_country')){{'has-error'}} @endif">
														<select name="spv_country" class="form-control" tabindex="27" id="spv_country">
															@foreach(\App\Http\Utilities\Country::aus() as $country => $code)
															<option value="{{$code}}" @if($project->projectspvdetail)@if($project->projectspvdetail->spv_country == $code) selected @endif @endif>{{$country}}</option>
															@endforeach
														</select>
														{!! $errors->first('spv_country', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_contact_number')){{'has-error'}} @endif">
											{!!Form::label('spv_contact_number', 'Project SPV Contact Number', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('spv_contact_number')){{'has-error'}} @endif">
														{!! Form::input('text', 'spv_contact_number', $project->projectspvdetail?$project->projectspvdetail->spv_contact_number:null, array('placeholder'=>'Contact Number', 'class'=>'form-control', 'tabindex'=>'28', 'id'=>'spv_contact_number')) !!}
														{!! $errors->first('spv_contact_number', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_email')){{'has-error'}} @endif">
											{!!Form::label('spv_email', 'Project SPV Email', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('spv_email')){{'has-error'}} @endif">
														{!! Form::email('spv_email', $project->projectspvdetail?$project->projectspvdetail->spv_email:null, array('placeholder'=>'Email', 'class'=>'form-control', 'tabindex'=>'29', 'id'=>'spv_email')) !!}
														{!! $errors->first('spv_email', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_md_name')){{'has-error'}} @endif">
											@if($project->md_vs_trustee)
											{!!Form::label('spv_md_name', 'Project MD Name', array('class'=>'col-sm-2 control-label'))!!}
											@else
											{!!Form::label('spv_md_name', 'Project Trustee Name', array('class'=>'col-sm-2 control-label'))!!}
											@endif
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('spv_md_name')){{'has-error'}} @endif">
														{!! Form::Text('spv_md_name', $project->projectspvdetail?$project->projectspvdetail->spv_md_name:null, array('placeholder'=>'Project SPV MD Name', 'class'=>'form-control', 'tabindex'=>'30', 'id'=>'spv_md_name')) !!}
														{!! $errors->first('spv_md_name', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_logo')){{'has-error'}} @endif">
											{!!Form::label('spv_logo', 'Logo Image', array('class'=>'col-sm-2 control-label'))!!}
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('spv_logo')){{'has-error'}} @endif">
														<div class="input-group">
															<label class="input-group-btn">
																<span class="btn btn-primary" style="padding: 10px 12px;">
																	Browse&hellip; <input type="file" name="spv_logo" id="spv_logo" class="form-control" style="display: none;">
																</span>
															</label>
															<input type="text" class="form-control" id="spv_logo_name" name="spv_logo_name" value="@if(!$project->media->where('type', 'spv_logo_image')->isEmpty()){{$project->media->where('type', 'spv_logo_image')->first()->filename}}@endif" readonly>
															<input type="hidden" name="spv_logo_image_path" id="spv_logo_image_path" value="">
															<input type="hidden" id="spv_logo_full_path" value="@if(!$project->media->where('type', 'spv_logo_image')->isEmpty()){{$project->media->where('type', 'spv_logo_image')->first()->path}}@endif">
														</div>
														<div class="row spv_logo_error" style="text-align: -webkit-center;"></div>
														{!! $errors->first('spv_logo', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group @if($errors->first('spv_md_sign')){{'has-error'}} @endif">
											@if($project->md_vs_trustee)
											{!!Form::label('spv_md_sign', 'Project SPV MD Signature', array('class'=>'col-sm-2 control-label'))!!}
											@else
											{!!Form::label('spv_md_sign', 'Project Trustee Signature', array('class'=>'col-sm-2 control-label'))!!}
											@endif
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-12 @if($errors->first('spv_md_sign')){{'has-error'}} @endif">
														<div class="input-group">
															<label class="input-group-btn">
																<span class="btn btn-primary" style="padding: 10px 12px;">
																	Browse&hellip; <input type="file" name="spv_md_sign" id="spv_md_sign" class="form-control" style="display: none;">
																</span>
															</label>
															<input type="text" class="form-control" id="spv_md_sign_name" name="spv_md_sign_name" value="@if(!$project->media->where('type', 'spv_md_sign_image')->isEmpty()){{$project->media->where('type', 'spv_md_sign_image')->first()->filename}}@endif" readonly>
															<input type="hidden" name="spv_md_sign_image_path" id="spv_md_sign_image_path" value="">
															<input type="hidden" id="spv_md_sign_full_path" value="@if(!$project->media->where('type', 'spv_md_sign_image')->isEmpty()){{$project->media->where('type', 'spv_md_sign_image')->first()->path}}@endif">
														</div>
														<div class="row spv_md_sign_error" style="text-align: -webkit-center;"></div>
														{!! $errors->first('spv_md_sign', '<small class="text-danger">:message</small>') !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group">
											<div class="col-sm-11">
												<div class="row">
													<div class="col-sm-12">
														<div class="input-group certi-frames" style="float: right;">
															<input type="radio" name="certificate_frame" value="frame1.jpg" class="hide" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame1.jpg") checked @endif @endif>
															<input type="radio" name="certificate_frame" value="frame2.jpg" class="hide" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame2.jpg") checked @endif @endif>
															<input type="radio" name="certificate_frame" value="frame3.jpg" class="hide" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame3.jpg") checked @endif @endif>
															<input type="radio" name="certificate_frame" value="frame4.jpg" class="hide" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame4.jpg") checked @endif @endif>
															<input type="radio" name="certificate_frame" value="frame5.jpg" class="hide" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame5.jpg") checked @endif @endif>
															<input type="radio" name="certificate_frame" value="" class="hide" @if($project->projectspvdetail) @if(!$project->projectspvdetail->certificate_frame) checked @endif @endif>
															<img class="certificate-thumb" src="{{asset('assets/images/certificate_frames/frame1_thumb.jpg')}}" width="160px" height="120" selection="frame1.jpg" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame1.jpg") style="border: 1px solid #666;" @endif @endif>
															<img class="certificate-thumb" src="{{asset('assets/images/certificate_frames/frame2_thumb.jpg')}}" width="160px" height="120" selection="frame2.jpg" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame2.jpg") style="border: 1px solid #666;" @endif @endif>
															<img class="certificate-thumb" src="{{asset('assets/images/certificate_frames/frame3_thumb.jpg')}}" width="160px" height="120" selection="frame3.jpg" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame3.jpg") style="border: 1px solid #666;" @endif @endif>
															<img class="certificate-thumb" src="{{asset('assets/images/certificate_frames/frame4_thumb.jpg')}}" width="160px" height="120" selection="frame4.jpg" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame4.jpg") style="border: 1px solid #666;" @endif @endif>
															<img class="certificate-thumb" src="{{asset('assets/images/certificate_frames/frame5_thumb.jpg')}}" width="160px" height="120" selection="frame5.jpg" @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="frame5.jpg") style="border: 1px solid #666;" @endif @endif>
															<div class="certificate-thumb text-center" selection="" style="width: 160px; height: 120px; background-color: #fff; float: left; border: 1px dotted #ddd; padding: 45px; @if($project->projectspvdetail) @if($project->projectspvdetail->certificate_frame=="") border: 1px solid #666; @endif @endif"><span><b>None</b></span></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row text-center">
										<p><a id="show_certificate_preview">+Preview</a></p>
										<div class="col-md-10 col-md-offset-1 certificate-preview" style=" border: 1px solid #eee; display: none; background-color: #fff; font-size: 13px;"></div>
									</div>
									<br>
									<div class="row">
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-9">
												{!! Form::submit('Update Certificate details', array('class'=>'btn btn-danger btn-block', 'tabindex'=>'7')) !!}
											</div>
										</div>
									</div>
									<input type="hidden" name="current_project_id" id="current_project_id" value="{{$project->id}}">
								</fieldset>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</section>
			<section style="display: none;">
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
			<section style="display: none;">
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
			<section style="display: none;">
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
			<section style="display: none;">
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
			<section style="display: none;">
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
			<section style="display: none;">
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
			<section style="display: none;">
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

<div class="row">
    <div class="text-center">
    	<!-- Project SPV Logo Crop modal -->
        <div class="modal fade" id="image_crop_modal" role="dialog" style="overflow: scroll;">
            <div class="modal-dialog" style="min-width: 800px;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crop Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="text-center" id="image_cropbox_container" style="display: inline-block;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="perform_crop_btn">Perform Crop</button>
                        <!-- Hidden Fields to refer for JCrop -->
                        <input type="hidden" name="image_crop" id="image_crop" value="" action="">
                        <input type="hidden" name="image_action" id="image_action" value="">
                        <input type="hidden" name="x_coord" id="x_coord" value="">
                        <input type="hidden" name="y_coord" id="y_coord" value="">
                        <input type="hidden" name="w_target" id="w_target" value="">
                        <input type="hidden" name="h_target" id="h_target" value="">
                        <input type="hidden" name="orig_width" id="orig_width" value="">
                        <input type="hidden" name="orig_height" id="orig_height" value="">
                    </div>
                </div>
            </div>
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

		//Bootstrap switch to change project status

		/*$("#is_coming_soon_checkbox").bootstrapSwitch();
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
		});*/

		/*$("#venture-checkbox").bootstrapSwitch();
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
		$("#eoi_button_checkbox").bootstrapSwitch();
		$('#eoi_button_checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#eoi_button').val(setVal);
		});
		$(".property_type").bootstrapSwitch();
		$('#property_type').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#venture').val(setVal);
		});*/
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
		$("#share_vs_unit_checkbox").bootstrapSwitch({
			onText: "Share",
			offText: "Unit",
			offColor: 'primary',
		});
		$('#share_vs_unit_checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#share_vs_unit').val(setVal);
		})
		$("#md_vs_trustee_checkbox").bootstrapSwitch({
			onText: "MD",
			offText: "Trustee",
			offColor: 'primary',
		});
		$('#md_vs_trustee_checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#md_vs_trustee').val(setVal);
		})
		$("#retail_vs_wholesale_checkbox").bootstrapSwitch({
			onText: "Retail",
			offText: "Wholesale",
			offColor: 'primary',
		});
		$('#retail_vs_wholesale_checkbox').on('switchChange.bootstrapSwitch', function () {
			var setVal = $(this).val() == 1? 0 : 1;
			$(this).val(setVal);
			$('#retail_vs_wholesale').val(setVal);
		})

		$('#modal_close_btn').click(function(){
			$('#spv_logo, #spv_md_sign').val('');
			$('#spv_logo_name, #spv_md_sign_name').val('');
		});

		$('.certificate-thumb').click(function(){
			$('.certificate-thumb').css('border', 'none');
			$(this).css('border', '1px solid #666');
			var selectedImg = $(this).attr('selection');
			$('input[name="certificate_frame"][value="' + selectedImg + '"]').prop('checked', true);
		});

		//Upload Project SPV Logo
		uploadProjectSPVLogo();
		performCropOnImage();
		uploadProjectSpvMDSign();
		previewShareCertificate();
	});

	function uploadProjectSPVLogo(){
		$('#spv_logo').change(function(){
			$('.spv_logo_error').html('');
			var file = $('#spv_logo')[0].files[0];
			if (file){
				fileExtension = (file.name).substr(((file.name).lastIndexOf('.') + 1)).toLowerCase();
				if(fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg'){
					$('#spv_logo_name').val(file.name);

					var formData = new FormData();
	                formData.append('spv_logo', $('#spv_logo')[0].files[0]);
	                $('.loader-overlay').show();
	                $.ajax({
	                    url: '/configuration/updateProjectSpvLogo',
	                    type: 'POST',
	                    dataType: 'JSON',
	                    data: formData,
	                    headers: {
	                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                    },
	                    contentType: false,
	                    processData: false
	                }).done(function(data){
	                	if(data.status == 1){
                            console.log(data);
                            var imgPath = data.destPath+data.fileName;
                            var str1 = $('<div class="col-sm-9"><img src="../../../'+imgPath+'" width="530" id="image_cropbox" style="max-width:none !important"><br><span style="font-style: italic; font-size: 13px"><small>Select The Required Area To Crop Logo.</small></span></div><div class="col-sm-2" id="preview_spv_logo_img" style="float: right;"><img width="530" src="../../../'+imgPath+'" id="preview_image"></div>');

                            $('#image_cropbox_container').html(str1);
                            $('#favicon_edit_modal').modal('hide');
                            $('#image_crop_modal').modal({
                                'show': true,
                                'backdrop': false,
                            });

                            $('#image_crop').val(imgPath); //set hidden image value
                            $('#image_crop').attr('action', 'spv_logo_image');
                            var target_width = 150;
                            var target_height = 50;
                            var origWidth = data.origWidth;
                            var origHeight = data.origHeight;
                            $('#image_cropbox').Jcrop({
                                boxWidth: 530,
                                // aspectRatio: 3/1,
                                keySupport: false,
                                setSelect: [0, 0, target_width, target_height],
                                bgColor: '',
                                onSelect: function(c) {
                                    updateCoords(c, target_width, target_height, origWidth, origHeight);
                                },
                                onChange: function(c) {
                                    updateCoords(c, target_width, target_height, origWidth, origHeight);
                                },onRelease: setSelect,
                                minSize: [target_width, target_height],
                            });
                            $('.loader-overlay').hide();
                        }
                        else{
                          $('.loader-overlay').hide();
                          $('#spv_logo, #spv_logo_name').val('');
                          $('.spv_logo_error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>'+data.message+'</h6></div>');
                        }
	                });
				}
				else{
					$('#spv_logo').val('');
					$('#spv_logo_name').val('');
					$('.spv_logo_error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Not a valid file extension. Valid extension: png, jpg, jpeg</h6></div>');
				}
			}
		});
	}

	function updateCoords(coords, w, h, origWidth, origHeight){
	    var target_width= w;
	    var target_height=h;
        //Set New Coordinates
        $('#x_coord').val(coords.x);
        $('#y_coord').val(coords.y);
        $('#w_target').val(coords.w);
        $('#h_target').val(coords.h);
        $('#orig_width').val(origWidth);
        $('#orig_height').val(origHeight);

        // showPreview(coordinates)
        $("<img>").attr("src", $('#image_cropbox').attr("src")).load(function(){
            var rx = target_width / coords.w;
            var ry = target_height / coords.h;

            var realWidth = this.width;
            var realHeight = this.height;

            var newWidth = 530;
            var newHeight = (realHeight/realWidth)*newWidth;

            $('#preview_image').css({
                width: Math.round(rx*newWidth)+'px',
                height: Math.round(ry*newHeight)+'px',
                marginLeft: '-'+Math.round(rx*coords.x)+'px',
                marginTop: '-'+Math.round(ry*coords.y)+'px',
            });

        });
    }

    function setSelect(coords){
        jcrop_api.setSelect([coords.x,coords.y,coords.w,coords.h]);
    }

    function performCropOnImage(){
        $('#perform_crop_btn').click(function(e){
            $('.loader-overlay').show();
            var imageName = $('#image_crop').val();
            var imgAction = $('#image_crop').attr('action');
            var xValue = $('#x_coord').val();
            var yValue = $('#y_coord').val();
            var wValue = $('#w_target').val();
            var hValue = $('#h_target').val();
            var origWidth = $('#orig_width').val();
            var origHeight = $('#orig_height').val();
            var hiwImgAction = $('#image_action').val();
            var currentProjectId = $('#current_project_id').val();
            console.log(imageName+'|'+xValue+'|'+yValue+'|'+wValue+'|'+hValue);
            $.ajax({
                url: '/configuration/cropUploadedImage',
                type: 'POST',
                data: {
                    imageName: imageName,
                    imgAction: imgAction,
                    xValue: xValue,
                    yValue: yValue,
                    wValue: wValue,
                    hValue: hValue,
                    origWidth: origWidth,
                    origHeight: origHeight,
                    hiwImgAction: hiwImgAction,
                    currentProjectId: currentProjectId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done(function(data){
                console.log(data);
                $('#image_crop_modal').modal('toggle');
                $('.loader-overlay').hide();
                if(data.status){
                    $('#image_crop').val(data.imageSource);
                    if (imgAction == 'spv_logo_image'){
                    	$('#spv_logo_image_path').val(data.imageSource);
                    }
                    else if(imgAction == 'spv_md_sign_image'){
                    	$('#spv_md_sign_image_path').val(data.imageSource);
                    }
                    // location.reload('/');
                }
                else{
                    // $('#image_crop_modal').modal('toggle');
                    if (imgAction == 'spv_logo_image'){
                      	$('#spv_logo, #spv_logo_name').val('');
                  	}
                  	else if(imgAction == 'spv_md_sign_image'){
                  		$('#spv_md_sign, #spv_md_sign_name').val('');
                  	}
                  	alert(data.message);
                }
        	});
        });
    }

    function uploadProjectSpvMDSign(){
    	$('#spv_md_sign').change(function(){
			$('.spv_md_sign_error').html('');
			var file = $('#spv_md_sign')[0].files[0];
			if (file){
				fileExtension = (file.name).substr(((file.name).lastIndexOf('.') + 1)).toLowerCase();
				if(fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg'){
					$('#spv_md_sign_name').val(file.name);

					var formData = new FormData();
	                formData.append('spv_md_sign', $('#spv_md_sign')[0].files[0]);
	                $('.loader-overlay').show();
	                $.ajax({
	                    url: '/configuration/updateProjectSpvMDSign',
	                    type: 'POST',
	                    dataType: 'JSON',
	                    data: formData,
	                    headers: {
	                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                    },
	                    contentType: false,
	                    processData: false
	                }).done(function(data){
	                	if(data.status == 1){
                            console.log(data);
                            var imgPath = data.destPath+data.fileName;
                            var str1 = $('<div class="col-sm-9"><img src="../../../'+imgPath+'" width="530" id="image_cropbox" style="max-width:none !important"><br><span style="font-style: italic; font-size: 13px"><small>Select The Required Area To Crop Logo.</small></span></div><div class="col-sm-2" id="preview_spv_md_sign_image" style="float: right;"><img width="530" src="../../../'+imgPath+'" id="preview_image"></div>');

                            $('#image_cropbox_container').html(str1);
                            $('#favicon_edit_modal').modal('hide');
                            $('#image_crop_modal').modal({
                                'show': true,
                                'backdrop': false,
                            });

                            $('#image_crop').val(imgPath); //set hidden image value
                            $('#image_crop').attr('action', 'spv_md_sign_image');
                            var target_width = 160;
                            var target_height = 120;
                            var origWidth = data.origWidth;
                            var origHeight = data.origHeight;
                            $('#image_cropbox').Jcrop({
                                boxWidth: 530,
                                // aspectRatio: 4/3,
                                keySupport: false,
                                setSelect: [0, 0, target_width, target_height],
                                bgColor: '',
                                onSelect: function(c) {
                                    updateCoords(c, target_width, target_height, origWidth, origHeight);
                                },
                                onChange: function(c) {
                                    updateCoords(c, target_width, target_height, origWidth, origHeight);
                                },onRelease: setSelect,
                                minSize: [target_width, target_height],
                            });
                            $('.loader-overlay').hide();
                        }
                        else{
                          $('.loader-overlay').hide();
                          $('#spv_md_sign, #spv_md_sign_name').val('');
                          $('.spv_md_sign_error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>'+data.message+'</h6></div>');
                        }
	                });
				}
				else{
					$('#spv_md_sign').val('');
					$('#spv_md_sign_name').val('');
					$('.spv_md_sign_error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Not a valid file extension. Valid extension: png, jpg, jpeg</h6></div>');
				}
			}
		});
    }

    function previewShareCertificate(){
    	$('#show_certificate_preview').click(function(e){
    		e.preventDefault();
    		var name = $('#spv_name').val();
    		var line1 = $('#spv_line_1').val();
    		var line2 = $('#spv_line_2').val();
    		var city = $('#spv_city').val();
    		var state = $('#spv_state').val();
    		var postal = $('#spv_postal_code').val();
    		var country = $('#spv_country').val();
    		var number = $('#spv_contact_number').val();
    		var mdName = $('#spv_md_name').val();
    		var logo = $('#spv_logo_full_path').val();
    		var mdSign = $('#spv_md_sign_full_path').val();
    		var frame = $('input[name="certificate_frame"]:checked').val();
    		if(frame != ''){
    			$('.certificate-preview').css('background','url(../../../assets/images/certificate_frames/'+frame+') no-repeat');
    			$('.certificate-preview').css('background-size', '100% 100%');
    		}
    		$('.certificate-preview').html('<div class="text-center" style="top: 20%;width: 100%;position: absolute;opacity: 0.05;"><img src="../../../'+logo+'" width="700"></div><div style="text-align: center; margin:8em 6em;"><h1>@if($project->share_vs_unit)Share @else Unit @endif Certificate</h1><br><br><img src="../../../'+logo+'" width="300"><br>'+name+'<br>'+line1+',@if(isset($project->projectspvdetail->spv_line_2)) '+line2+', @endif '+city+', '+state+', '+country+', '+postal+' <br>'+number+'<br><br>Date: Date<br><br><br>This is to certify Mr. XYZ of address_line_1, address_line2, city, state, 3001 owns 200 @if($project->share_vs_unit) redeemable preference shares @else units @endif of '+name+' numbered 1 to 200.<br><br><br><img src="../../../'+mdSign+'" width="150"><br>'+mdName+'<br>@if($project->md_vs_trustee)Managing Director @else Trustee @endif<br>'+name+'</div>').toggle();


    	});
    }

</script>
@stop
