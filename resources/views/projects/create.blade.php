@extends('layouts.main')

@section('title-section')
Create New Project | @parent
@stop

@section('css-section')
{!! Html::style('plugins/animate.css') !!}
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop

@section('content-section')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
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
			@endif
		</div>
	</div>
	<section id="project-form">
		<div class="row ">
			<div class="col-md-6 col-md-offset-3 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
				{!! Form::open(array('route'=>'projects.store', 'class'=>'form-horizontal', 'role'=>'form', 'files'=>true)) !!}
				{{-- <fieldset>
					<br>
					<div class="row">
						<div class=" @if($errors->first('title')){{'has-error'}} @endif">
							<div class="col-md-12">
								<h4 id="name" class="first_color">Receivable Name</h4>
								{!! Form::text('title', null, array('placeholder'=>'Receivable Name', 'class'=>'form-control', 'tabindex'=>'1')) !!}
								{!! $errors->first('title', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
				</fieldset> --}}

				<fieldset>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<div class="@if($errors->first('invoice_amount')){{'has-error'}} @endif">
										<h4 class="first_color">Amount</h4>
										{!! Form::input('number', 'invoice_amount', null, array('placeholder'=>'Amount', 'class'=>'form-control', 'tabindex'=>'2')) !!}
										{!! $errors->first('invoice_amount', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="@if($errors->first('due_date')){{'has-error'}} @endif">
										<h4 class="first_color">Invoice due date</h4>
										{!! Form::input('date','due_date', null, array('placeholder'=>'DD/MM/YYYY', 'class'=>'form-control', 'tabindex'=>'4', 'min'=>\Carbon\Carbon::now()->toDateString(), 'id'=>'datepicker')) !!}
										{!! $errors->first('due_date', '<small class="text-danger">:message</small>') !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<div class="@if($errors->first('asking_amount')){{'has-error'}} @endif">
								<h4 class="first_color">Asking price</h4>
								{!! Form::input('text', 'asking_amount', null, array('placeholder'=>'Asking Price', 'class'=>'form-control', 'tabindex'=>'3', 'readonly' => 'readonly')) !!}
								{!! $errors->first('asking_amount', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
				</fieldset>


				<fieldset>
					<br>
					<div class="row">
						<div class="@if($errors->first('description')){{'has-error'}} @endif">
							<div class="col-sm-6">
								<h4 class="first_color">Invoice issued to</h4>
								{!! Form::text('description', null, array('placeholder'=>'Invoice issued to', 'class'=>'form-control', 'tabindex'=>'5')) !!}
								{!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
							</div>
							<div class="col-sm-6">
								<h4 class="invoice_issue_from_email first_color">Email</h4>
								{!! Form::email('invoice_issue_from_email', null, array('placeholder'=>'Invoice issued to Email', 'class'=>'form-control', 'tabindex'=>'5')) !!}
								{!! $errors->first('description', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<br>
					<div class="row">
						<div class="@if($errors->first('invoice_issued_from')){{'has-error'}} @endif">
							<div class="col-sm-12">
								<h4 class="first_color">Invoice issued from</h4>
								{!! Form::text('invoice_issued_from', null, array('placeholder'=>'Invoice issued from', 'class'=>'form-control', 'tabindex'=>'6')) !!}
								{!! $errors->first('invoice_issued_from', '<small class="text-danger">:message</small>') !!}
							</div>
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
				<br><br>
				{!! Form::close() !!}
			</div>
		</div>
	</section>
</div>
@stop
@section('js-section')
{!! Html::script('js/konkrete.js') !!}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

	$(document).ready(function () {

		//Disable default html5 datepicker
		$('input[type=date]').on('click', function(event) {
			event.preventDefault();
		});

		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			minDate: new Date(),
			maxDate: '+60D'
		}).datepicker("setDate", new Date().getDay+14);

		// Calculate Asking Price
		$('input[name=invoice_amount], input[name=due_date]').change(function () {
			let invoiceAmount = $('input[name=invoice_amount]').val();
			let dueDate = $('input[name=due_date]').val();

			if (invoiceAmount != '' && dueDate != '') {
				$('.loader-overlay').show();
				$.ajax({
					url: '{{ route('invoice.asking.price') }}',
					type: 'POST',
					dataType: 'JSON',
					data: {
						'invoice_amount': invoiceAmount,
						'due_date': dueDate
					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				}).done(function(data){
					$('.loader-overlay').hide();
					if (!data.status) {
						alert(data.message);
						return;
					}
					$('input[name=asking_amount]').val(data.data.asking_amount);
				});
			}
		});

	});
</script>
@stop
