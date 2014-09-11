<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>protestr</title>
    <link href='http://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,300' rel='stylesheet' type='text/css'>
    {{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/global.css') }}
    {{ HTML::style('css/forms.css') }}
    @yield('css')
  </head>
  <body>
    @include('layouts.partials.nav')

    <div class="container">
      @yield('content')
    </div>

    {{ HTML::script('packages/jquery/jquery.min.js') }}
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
    {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js') }}
    {{ HTML::script('js/timezones.js') }}
    {{ HTML::script('js/global.js') }}
    @yield('javascript')
  </body>
</html>
