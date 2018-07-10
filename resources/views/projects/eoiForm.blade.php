@extends('layouts.project')
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
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('First Name') !!}
                {!! Form::text('first_name', !Auth::guest() ? Auth::user()->first_name : null, array('required', 'class'=>'form-control', 'placeholder'=>'Enter your first name','id'=>'eoi_fname')) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('Last Name') !!}
                {!! Form::text('last_name', !Auth::guest() ? Auth::user()->last_name : null, array('required', 'class'=>'form-control', 'placeholder'=>'Enter your last name','id'=>'eoi_lname')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('Email') !!}
            {!! Form::input('email', 'email', !Auth::guest() ? Auth::user()->email : null, array('required', 'class'=>'form-control', 'placeholder'=>'Enter your email','id'=>'eoi_email')) !!}
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Phone number') !!}
            {!! Form::text('phone_number', !Auth::guest() ? Auth::user()->phone_number : null, array('required', 'class'=>'form-control', 'placeholder'=>'Enter your phone number','id'=>'eoi_phone')) !!}
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Amount you would be interested in investing') !!}
            <div class="input-group">
                <span class="input-group-addon">A$</span>
                {!! Form::input('number', 'investment_amount', $project->investment->minimum_accepted_amount, array('required', 'class'=>'form-control','id'=>'amountEoi' ,'placeholder'=>'Enter Invesment Amount (min '.$project->investment->minimum_accepted_amount.'AUD)')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, 'When will you be ready to invest : ', array('style' => 'margin-right: 8px;')) !!}
            {!! Form::select('investment_period', ['Now' => 'Now', '1 month' => '1 month', '2 months' => '2 months', '3 months' => '3 months', '4 months' => '4 months', '5 months' => '5 months', '6 months' => '6 months'],null,array('id'=>'periodEoi')) !!}
        </div>

        <div class="row">
            <div class="col-md-12">
                <div>
                    <input type="hidden" name="interested_to_buy" value="0">
                    <input type="checkbox" name="interested_to_buy" value="1">  I am also interested in purchasing one of the properties being developed. Please have someone get in touch with me with details
                </div>
            </div>
        </div>
        <br>

        <div class="form-group text-center show-eoi-form-btn">
            {!! Form::submit('Submit', array('class'=>'btn btn-primary btn-block')) !!}
        </div>
        <br>
        <input type="text" name="project_id" @if($project) value="{{$project->id}}" @endif hidden id="projIdEoi">
        {!! Form::close() !!}
    </div>
</div>
</div>
@if(Auth::guest())
@include('partials.loginModal');
@include('partials.registerModal');
@endif
@stop
@section('js-section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
{!! Html::script('plugins/wow.min.js') !!}
<script>
	$(document).ready(function(){
        @if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
        $('#registerModal').modal();
        @endif
        @if(!empty(Session::get('success_code')) && Session::get('success_code') == 6)
        $('#registerModal').modal();
        @endif
        $('#submitform').click(function(){
            $('#submit1').trigger('click');
        });
        $('#eoiFormButton').submit(function(e) {
            @if(Auth::guest())
            e.preventDefault();
            var fname = $('#eoi_fname').val();
            var lname = $('#eoi_lname').val();
            var email = $('#eoi_email').val();
            var phone = $('#eoi_phone').val();
            var password = $('#loginPwdEoi').val();
            var investment_period = $('#periodEoi').find(':selected').text();
            var investment_amount = $('#amountEoi').val();
            var project_id = $('#projIdEoi').val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.post('/users/login/check',{email,_token},function (data) {
                if(data == email){
                    $('#loginEmailEoi').val(email);
                    $('#eoiFName').val(fname);
                    $('#eoiLName').val(lname);
                    $('#eoiPhone').val(phone);
                    $('#eoiInvestmentPeriod').val(investment_period);
                    $('#eoiInvestmentAmount').val(investment_amount);
                    $('#eoiProjectId').val(project_id);
                    $("#loginModal").modal();
                }else{
                    $('#eoiREmail').val(email);
                    $('#eoiRFName').val(fname);
                    $('#eoiRLName').val(lname);
                    $('#eoiRPhone').val(phone);
                    $('#eoiRInvestmentPeriod').val(investment_period);
                    $('#eoiRInvestmentAmount').val(investment_amount);
                    $('#eoiRProjectId').val(project_id);
                    $('#registerModal').modal();
                }
            });
            @else
            $('.loader-overlay').show(); // show animation
            return true; // allow regular form submission
            @endif
        });
    });
</script>
@stop
