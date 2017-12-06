@extends('layouts.main')
@section('title-section')
EOI Doc
@stop

@section('css-section')
@parent
@stop
@section('content-section')
<div class="loader-overlay hide" style="display: none;">
	<div class="overlay-loader-image">
	   <img id="loader-image" src="{{ asset('/assets/images/loader.GIF') }}">
	</div>
</div>
<div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        @if ($errors->has())
        <div class="alert alert-danger text-center" style="margin-top: 30px;">
            @foreach ($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
        </div>
        @endif
        @if (Session::has('message'))
            {!! Session::get('message') !!}
        @endif
        <h1 class="text-center">Expression of Interest</h1>
        <h5 style="color: #767676;">** This is a no obligation expression of interest which allows us to determine how much money is likely to come in when the offer is made.</h5>

        {!! Form::open(array('route' => ['projects.eoiStore'], 'class' => 'form', 'id'=>'eoiFormButton')) !!}

        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', $user->first_name. ' '. $user->last_name, array('required', 'class'=>'form-control', 'placeholder'=>'Enter your name')) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Email') !!}
            {!! Form::input('email', 'email_address', $user->email, array('required', 'class'=>'form-control', 'placeholder'=>'Enter your email')) !!}
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Phone number') !!}
            {!! Form::input('number', 'phone_number', $user->phone_number, array('required', 'class'=>'form-control', 'placeholder'=>'Enter your phone number')) !!}
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Amount you would be interested in investing') !!}
            <div class="input-group">
            <span class="input-group-addon">A$</span>
                {!! Form::input('number', 'investment_amount', 5000, array('required', 'class'=>'form-control', 'placeholder'=>'Enter Invesment Amount')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, 'When will you be ready to invest : ', array('style' => 'margin-right: 8px;')) !!}
            {!! Form::select('investment_period', ['Now' => 'Now', '1 month' => '1 month', '2 months' => '2 months', '3 months' => '3 months', '4 months' => '4 months', '5 months' => '5 months', '6 months' => '6 months']) !!}
        </div>
        <br>

        <div class="form-group text-center show-eoi-form-btn">
            {!! Form::submit('Submit', array('class'=>'btn btn-primary btn-block')) !!}
        </div>
        <input type="text" name="project_id" @if($project) value="{{$project->id}}" @endif hidden >
        {!! Form::close() !!}
      </div>
    </div>
</div>

@stop
@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
{!! Html::script('plugins/wow.min.js') !!}
<script>
	$(document).ready(function(){
        $('#eoiFormButton').submit(function() {
            $('.loader-overlay').show(); // show animation
            return true; // allow regular form submission
        });
    });
</script>
@stop