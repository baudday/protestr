<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>protestr</title>
    <link href='http://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,300' rel='stylesheet' type='text/css'>
    {{ HTML::style('packages/bootstrap/css/bootstrap.min.css')}}
    {{ HTML::style('css/forms.css') }}
  </head>
  <body>
    @include('layouts.partials.nav')

    <div class="container">
      @yield('content')
    </div>

    {{ HTML::script('packages/jquery/jquery.min.js') }}
    {{ HTML::script('packages/bootstrap/js/bootstrap.min.js') }}
    @yield('javascript')
  </body>
</html>
