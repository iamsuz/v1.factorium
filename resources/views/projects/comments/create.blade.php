@extends('layouts.main')

@section('title-section')
Project Comments | @parent
@stop

@section('css-section')
@stop

@section('content-section')
<div class="container">
	{!! Form::open(array('route'=>['projects.{projects}.comments.store', $project], 'class'=>'form-horizontal', 'role'=>'form')) !!}
	<section id="comment-form">
		<div class="row chunk-box">
			<div class="col-md-1">
				<img src="{{asset('assets/images/default-male.png')}}" width="70" class="img-circle">
			</div>
			<div class="col-md-11 wow fadeIn animated" data-wow-duration="0.8s" data-wow-delay="0.5s">
				<fieldset>
					<div class="row">
						<div class="form-group @if($errors->first('text')){{'has-error'}} @endif">
							<div class="col-sm-12">
								{!! Form::textarea('text', null, array('placeholder'=>'Write a comment', 'class'=>'form-control', 'rows'=>'3')) !!}
								{!! $errors->first('text', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-sm-offset-10 col-sm-2">
								{!! Form::submit('Post', array('class'=>'btn btn-danger btn-lg btn-block', 'tabindex'=>'15')) !!}
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</section>
	{!! Form::close() !!}
</div>
@stop

@section('js-section')
@stop
