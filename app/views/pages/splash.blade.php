<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>protestr</title>
    <link href='http://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,300' rel='stylesheet' type='text/css'>
    {{ HTML::style('packages/bootstrap/css/bootstrap.min.css')}}
    {{ HTML::style('css/forms.css') }}
    {{ HTML::style('css/splash.css') }}
  </head>
  <body>
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
          <div class="title">
            <h1>protestr</h1>
            <p>Organize protests. Demand change.</p>
          </div>
          @if(isset($message))
            <div class="alert alert-{{ $message['class'] }}">
              {{ $message['message'] }}
            </div>
          @else
            {{ Form::open( ['route' => 'store'] ) }}
              <div class="input-group input-group-lg @if($errors->first('email')) has-error @endif">
                {{ Form::email('email', null, [
                  'class' => 'form-control input-lg',
                  'tabindex' => '1',
                  'placeholder' => 'Get notified when we go live'
                ]) }}
                <span class="input-group-btn">
                  <button class="btn btn-default btn-lg @if($errors->first('email')) has-error @endif" type="submit">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </button>
                </span>
              </div>
              {{ Form::hidden('u', '89e32eb621b69be47df68487a') }}
              {{ Form::hidden('id', '2f88e77764') }}
              @if($errors->first('email'))
                <div class="input-error"><small>{{ $errors->first('email') }}</small></div>
              @endif
            {{ Form::close() }}
          @endif
          <div class="social">
            <a href="http://facebook.com/protestr" target="blank"><img src="img/facebook.png" /></a>
            <a href="http://twitter.com/protestrapp" target="blank"><img src="img/twitter.png" /></a><br />
          </div>
        </div>
      </div>
    </div>

    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
            <a href="http://erlibird.com/go/protestr" target="blank">
              <img src="http://erlibird.s3.amazonaws.com/images/trans-black-sm-featured.png" class="erlibird">
            </a>
          </div>
        </div>
      </div>
    </div>
    {{ HTML::script('packages/jquery/jquery.min.js') }}
    <script type="text/javascript">
      $(function() {
        $img = $( '<img src="{{ splash_background() }}" />');
        $img.on('load', function() {
          $('body').css('background-image', 'url("{{ splash_background() }}")');
          $('body').css('background-position', 'center center');
          $('body').css('background-attachment', 'fixed');
        })
      })
    </script>
  </body>
</html>
