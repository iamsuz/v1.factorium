@extends('layouts.main')

@section('title-section')
Create FAQ | @parent
@stop

@section('meta-section')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content-section')

<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			@if (Session::has('message'))
			<div class="alert alert-success text-center" role="alert">
				{!! Session::get('message') !!}
			</div>
			@endif

			@if (count($errors) > 0)
				<div class="alert alert-danger" role="alert">
					<strong>Errors:</strong>
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<h1 class="text-center" style="font-size:2.625em;">Add New Frequently Asked Question</h1>
			<br>
			{!! Form::open(array('route'=>'pages.faq.store')) !!}
				<div class="row" style="background-color: #f2f3f4; padding: 20px; border-radius: 5px;">
					<div class="row form-group">
						{!!Form::label('category', 'Category:', array('class'=>'col-sm-3 control-label'))!!}
						<div class="col-sm-9">
							<select name="category" id="category" class="form-control">
								<option value=""></option>
								@foreach($categories as $key=>$category)
								<option value="{{$key}}">{{$key}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row form-group">
						{!!Form::label('sub_category', 'Sub Category:', array('class'=>'col-sm-3 control-label'))!!}
						<div class="col-sm-9">
							<select name="sub_category" id="sub_category" class="form-control" disabled="true">
							</select>
						</div>
					</div>
					<div class="row form-group">
						{!!Form::label('question', 'Question:', array('class'=>'col-sm-3 control-label'))!!}
						<div class="col-sm-9">
							{!! Form::text('question', null, array('placeholder'=>'Write your Question', 'class'=>'form-control')) !!}
						</div>
					</div>
					<div class="row form-group">
						{!!Form::label('answer', 'Answer:', array('class'=>'col-sm-3 control-label'))!!}
						<div class="col-sm-9">
							{!! Form::textarea('answer', null,  array('placeholder'=>'Write your Answer', 'rows'=>4, 'class'=>'form-control')) !!}
						</div>
					</div>
				</div>
				<br>
				<div class="row form-group">
					{!! Form::submit('Create New FAQ', array('class'=>'btn btn-success btn-lg btn-block')) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

@stop

@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>

<script type="text/javascript">

	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	$(document).ready(function() {
		
		$('#category').on('change', function(){
			var category = $(this).val();
			if(category == ""){
				$('#sub_category').find('option').remove();
				$('#sub_category').attr('disabled', true);
			}
			else{
				$.ajax({
					url: '/pages/faq/recieveSubCategory',
					data: {
						category: category,
						_token: CSRF_TOKEN,
					},
					dataType: 'JSON',
					type: 'POST',
				}).done(function(data){
					$('#sub_category').removeAttr('disabled');
					$('#sub_category').find('option').remove();
					$.each( data, function( index, value ){
						if(category == index){
							if(value == ''){
								$('#sub_category').attr('disabled', true);
							}
							else{
								$.each( value, function( index, value ){
									$('#sub_category').append($('<option>', {
										value: value,
										text: value,
									}));
								});
							}
						}
						
					});
				});
			}
		});

	});
</script>
@endsection