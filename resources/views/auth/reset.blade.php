@extends('layouts.main')

@section('css-section')
<style type="text/css">
    .navbar-default {
        border-color: #fff ;
    }
</style>
@stop

@section('content-section')
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                {!! csrf_field() !!}
                <fieldset>
                    <div class="text-center">
                        <h1 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">Reset Password! <br>
                        <small class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Enter your email and new password.</small>
                        </h1>
                        <br>
                    </div>
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                        <div class="col-sm-offset-1 col-sm-10">
                            <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="E-Mail Address">

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                        <div class="col-sm-offset-1 col-sm-10">
                            <input type="password" class="form-control" name="password" placeholder="Password">

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <div class="col-sm-offset-1 col-sm-10">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">

                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@stop
