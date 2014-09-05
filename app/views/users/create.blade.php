@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <h1>sign up for protestr</h1>
      {{ Form::open( ['route' => 'users.store'] ) }}

        <div class="form-group @if($errors->first('email')) has-error has-feedback @endif">
          {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
          {{ Form::email('email', null, ['class' => 'form-control', 'tabindex' => '1']) }}
          @if($errors->first('email'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
          @endif
          <span class="danger">{{ $errors->first('email') }}</span>
        </div>

        <div class="form-group @if($errors->first('username')) has-error has-feedback @endif">
          {{ Form::label('username', 'Username', ['class' => 'control-label']) }}
          {{ Form::text('username', null, ['class' => 'form-control', 'tabindex' => '2']) }}
          @if($errors->first('username'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
          @endif
          <span class="danger">{{ $errors->first('username') }}</span>
        </div>

        <div class="form-group @if($errors->first('password')) has-error has-feedback @endif">
          {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
          {{ Form::password('password', ['class' => 'form-control', 'tabindex' => '3']) }}
          @if($errors->first('password'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
          @endif
          <span class="danger">{{ $errors->first('password') }}</span>
        </div>

        <div class="form-group @if($errors->first('password_confirmation')) has-error has-feedback @endif">
          {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) }}
          {{ Form::password('password_confirmation', ['class' => 'form-control', 'tabindex' => '4']) }}
          @if($errors->first('password_confirmation'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
          @endif
          <span class="danger">{{ $errors->first('password_confirmation') }}</span>
        </div>

        <div class="form-group">
          {{ Form::submit('Sign Up', ['class' => 'btn btn-lg btn-primary']) }}
        </div>

      {{ Form::close() }}
    </div>
  </div>
@stop
