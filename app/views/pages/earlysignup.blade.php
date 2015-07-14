<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>protestr</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <link href='http://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,300' rel='stylesheet' type='text/css'>
    {{ HTML::style('packages/bootstrap/css/bootstrap.min.css')}}
    {{ HTML::style('css/earlysignup.css') }}
    {{ HTML::style('css/forms.css') }}
    {{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.1/css/lightbox.css') }}
  </head>
  <body>
    <div class="container-fluid banner">
      <div class="row">
        <div class="col-xs-12">
          <div class="container">
            <div class="row header">
              <div class="col-xs-12">
                <div class="pull-left">
                  <h1 class="logo">protestr</h1>
                  <span class="motto small">Organize protests. Demand change.</span>
                </div>
                <div class="pull-right social">
                  <a href="http://facebook.com/protestr" target="blank"><img src="img/facebook.png" /></a>
                  <a href="http://twitter.com/protestrapp" target="blank"><img src="img/twitter.png" /></a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                @if(isset($message))
                <div class="alert alert-{{ $message['class'] }}">
                  {{ $message['message'] }}
                </div>
                @else
                <h1>pre-register</h1>
                {{ Form::open( ['route' => 'store'] ) }}

                  {{ Form::hidden('u', '89e32eb621b69be47df68487a') }}
                  {{ Form::hidden('id', '2f88e77764') }}

                  <div class="form-group @if($errors->first('email')) has-error has-feedback @endif">
                    {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
                    {{ Form::email('email', null, ['class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Email']) }}
                    @if($errors->first('email'))
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      <div class="input-error"><small>{{ $errors->first('email') }}</small></div>
                    @endif
                  </div>

                  <div class="form-group @if($errors->first('username')) has-error has-feedback @endif">
                    {{ Form::label('username', 'Username', ['class' => 'control-label']) }}
                    {{ Form::text('username', null, ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => 'Username']) }}
                    @if($errors->first('username'))
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      <div class="input-error"><small>{{ $errors->first('username') }}</small></div>
                    @endif
                  </div>

                  <div class="form-group @if($errors->first('password')) has-error has-feedback @endif">
                    {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
                    {{ Form::password('password', ['class' => 'form-control', 'tabindex' => '3', 'placeholder' => 'Password']) }}
                    @if($errors->first('password'))
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      <div class="input-error"><small>{{ $errors->first('password') }}</small></div>
                    @endif
                  </div>

                  <div class="form-group @if($errors->first('password_confirmation')) has-error has-feedback @endif">
                    {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) }}
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'tabindex' => '4', 'placeholder' => 'Confirm Password']) }}
                    @if($errors->first('password_confirmation'))
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      <div class="input-error"><small>{{ $errors->first('password_confirmation') }}</small></div>
                    @endif
                  </div>

                  <div class="form-group">
                    {{ Form::submit('Pre-Register', ['id' => 'submit_signup', 'class' => 'btn btn-lg btn-primary col-xs-12', 'tabindex' => '5']) }}
                  </div>

                {{ Form::close() }}
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container body">
      <div class="row heading-container">
        <div class="col-xs-12">
          <h1 class="heading">Protestr gives ordinary people the tools they need to make a
            difference. Organize and find protests near you and abroad.</h1>
            <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="thumbnail">
            <a href="/img/screens/start.png" data-lightbox="screenshots" data-title="">
              {{ HTML::image('img/screens/start_thumb.png', 'start protest screenshot', ['class' => 'img-circle']) }}
            </a>
            <div class="caption">
              <h3>Start Protests</h3>
              <ul>
                <li>Tell people about your cause and why it's so important
                <li>Give your protest a location and make it easier for others
                    to find</li>
                <li>Protest comes in many forms, not just marches. Protestr
                    allows you to specify how you're going to protest</li>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="thumbnail">
            <a href="/img/screens/find.png" data-lightbox="screenshots" data-title="">
              {{ HTML::image('img/screens/find_thumb.png', 'find protests screenshot', ['class' => 'img-circle']) }}
            </a>
            <div class="caption">
              <h3>Find Protests</h3>
              <ul>
                <li>Find protests locally as well as globally</li>
                <li>Use topics to find causes that matter to you</li>
                <li>Sort by trending or most recent to see what's big or
                    gaining momentum</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
        <div class="thumbnail">
          <a href="/img/screens/update.png" data-lightbox="screenshots" data-title="">
            {{ HTML::image('img/screens/update_thumb.png', 'stay in the loop', ['class' => 'img-circle']) }}
          </a>
          <div class="caption">
            <h3>Stay in the Loop</h3>
            <ul>
              <li>All information vital to attendees is displayed directly
                  on the front page of a protest</li>
              <li>Protestr allows organizers to post updates to keep you
                  up to date on what's happening</li>
              <li>Make your voice heard by being part of the discussion</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <h1>We are Dedicated to Your Privacy</h1>
        <p>Giving out even the most basic information such as your email is,
          and should be, a big deal. We understand that, and do not take
          this point lightly. That's why we try to collect as little of your
          personal information as possible. Upon registration, we only ask
          for an email address and a username.</p>
          <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <h1>You are the Missing Piece</h1>
        <p>As Protestr grows, we'll look to you for guidance on improving the
          platform. We'll listen closely to the needs of the community so that
          Protestr can be as useful as possible. Pre-register today and we will let
          you know when we launch so you can be one of the first to experience
          a revolution in online activism!</p>
          <hr>
      </div>
    </div>
    <div class="row footer">
      <div class="col-xs-12">
        <small>Copyright &copy; 2015 Protestr. All rights reserved.</small>
      </div>
    </div>
    {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.1/js/lightbox-plus-jquery.min.js') }}
  </body>
</html>