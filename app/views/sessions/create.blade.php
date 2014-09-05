@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <h1>login to protestr</h1>
      @if(Session::get('message'))
        <div class="alert alert-{{ Session::get('message')['class'] }}">
          {{ Session::get('message')['message'] }}
        </div>
      @endif
      {{ Form::open( ['route' => 'sessions.store'] ) }}

        <div class="form-group @if($errors->first('email')) has-error has-feedback @endif">
          {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
          {{ Form::email('email', null, [
            'class' => 'form-control',
            'tabindex' => '1',
            'placeholder' => 'Email'
          ]) }}
          @if($errors->first('email'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <div class="input-error"><small>{{ $errors->first('email') }}</small></div>
          @endif
        </div>

        <div class="form-group @if($errors->first('password')) has-error has-feedback @endif">
          {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
          {{ Form::password('password', [
            'class' => 'form-control',
            'tabindex' => '2',
            'placeholder' => 'Password'
          ]) }}
          @if($errors->first('password'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            <div class="input-error"><small>{{ $errors->first('password') }}</small></div>
          @endif
        </div>

        <div class="form-group">
          {{ Form::submit('Login', ['class' => 'btn btn-lg btn-primary' ]) }}
        </div>

      {{ Form::close() }}
    </div>
  </div>
@stop
