@extends('layouts.main')

@section('css-section')
<style type="text/css">
    .navbar-default {
        border-color: #fff ;
    }
</style>
@stop

<!-- Main Content -->
@section('content-section')
<br><br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                {!! csrf_field() !!}
                <fieldset>
                    <div class="text-center">
                    <h1 class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.2s">Reset Password! <br>
                            <small class="wow fadeIn animated" data-wow-duration="1.5s" data-wow-delay="0.3s" style="font-size:.5em">Enter your email.</small>
                        </h1>
                        <br>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-sm-offset-1 col-sm-10">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Send Password Reset Link 
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <br>
                <p class="text-center">Don't have an account yet? <b>{!! Html::linkRoute('users.create', 'Register here') !!}</b></p>
        </div>
    </div>
</div>
@endsection
