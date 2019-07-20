@extends('layouts.main')

@section('title-section')
Create New Project | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
@stop

@section('content-section')
<div class="container">
	<section id="project-form">
		<div class="row ">
			<div class="col-md-6 col-md-offset-3 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
				<br><br>
				@if (Session::has('message'))
				<br>
				{!! Session::get('message') !!}
				<br>
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
				{!! Form::open(array('route'=>'projects.store', 'class'=>'form-horizontal', 'role'=>'form', 'files'=>true)) !!}
				<fieldset>
					<br><br>
					<div class="row">
						<div class=" @if($errors->first('title')){{'has-error'}} @endif">
							<div class="col-md-12">
								<h4 id="name" class="first_color">Receivable Name</h4>
								{!! Form::text('title', null, array('placeholder'=>'Receivable Name', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('title', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<br>
					<div class="row">
						<div class="@if($errors->first('goal_amount')){{'has-error'}} @endif">
							<div class="col-sm-12">
								<h4 class="first_color">Amount</h4>
								{!! Form::input('number', 'goal_amount', null, array('placeholder'=>'Amount', 'class'=>'form-control', 'tabindex'=>'2', 'rows'=>'5')) !!}
								{!! $errors->first('goal_amount', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
				</fieldset>

				<fieldset>
					<br>
					<div class="row">
						<div class="@if($errors->first('description')){{'has-error'}} @endif">
							<div class="col-sm-12">
								<h4 class="first_color">Invoice issued to</h4>
								{!! Form::text('description', null, array('placeholder'=>'Invoice issued to', 'class'=>'form-control', 'tabindex'=>'3', 'rows'=>'5')) !!}
								{!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
				</fieldset>

				<fieldset>
					<br><br>
					<div class="row text-center">
						<div class="col-sm-offset-3 col-sm-6">
							{!! Form::submit('Submit Receivable', array('class'=>'btn btn-n3 h1-faq second_color_btn', 'tabindex'=>'15','style'=>'color:#fff;font-size:1em;border-radius:6px !important;')) !!}
						</div>
					</div>
				</fieldset>
				{!! Form::close() !!}
			</div>
		</div>
	</section>
</div>
@stop
@section('js-section')
{!! Html::script('js/konkrete.js') !!}
@stop
