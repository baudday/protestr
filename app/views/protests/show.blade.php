@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-xs-8">
      <h1>{{{ $protest->mission }}} <small>{{ link_to($protest->website, $protest->website) }}</small></h1>
      <h2><small id="time">{{{ $protest->when_date }}} {{{ $protest->when_time }}} UTC</small></h2>

      <h3>The backstory</h3>
      <p style="white-space: pre-wrap;">{{{ $protest->history }}}</p>

      <h3>Our plan</h3>
      <p style="white-space: pre-wrap;">{{{ $protest->plan }}}</p>
    </div>
  </div>
@stop

@section('javascript')
  {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js') }}
  {{ HTML::script('js/timezones.js') }}
  <script type="text/javascript">
    // Get time object from js/timezones.js
    var time = getTimeObject('{{{ $protest->when_date }}}', '{{{ $protest->when_time }}}');
    // moment from moment.js
    var moment = moment(time.string);
    $('#time').html(
      moment.format(time.format)
    );
  </script>
@stop
