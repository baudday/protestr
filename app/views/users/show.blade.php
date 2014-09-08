@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <h1>{{{ $user->username }}}'s profile</h1>
      {{ gravatar_tag($user->email, array('s' => 200, 'd' => 'identicon')) }}
      <h2>Protests I'm attending</h2>
      @foreach($user->attending as $protest)
        <h3>{{ link_to_route('protests.show', $protest->mission, $protest->id) }} <small class="time">{{{ $protest->when_date }}} UTC</small></h3>
        <p>{{{ str_limit($protest->history) }}}</p>
      @endforeach
    </div>
  </div>
@stop

@section('javascript')
  {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js') }}
  {{ HTML::script('js/timezones.js') }}
  <script type="text/javascript">
    $('.time').each(function(el) {
      var time = getTimeObject($(this).html());
      var moment = moment(time.string);
      $(this).html(moment.format(time.format));
    });
  </script>
@stop
