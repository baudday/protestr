@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <h1>{{{ $user->username }}}'s profile</h1>
      {{ gravatar_tag($user->email, array('s' => 200, 'd' => 'identicon')) }}
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h2>Protests I started</h2>
      @foreach($user->protests as $protest)
        <h3>{{ link_to_route('protests.show', $protest->mission, $protest->id) }} <small class="time">{{{ $protest->when_date }}}</small></h3>
        <p>{{{ str_limit($protest->history, 140) }}}</p>
      @endforeach
    </div>
    <div class="col-sm-6">
      <h2>Protests I'm attending</h2>
      @foreach($user->attending as $protest)
        <h3>{{ link_to_route('protests.show', $protest->mission, $protest->id) }} <small class="time">{{{ $protest->when_date }}}</small></h3>
        <p>{{{ str_limit($protest->history, 140) }}}</p>
      @endforeach
    </div>
  </div>
@stop

@section('javascript')
  {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js') }}
  {{ HTML::script('js/timezones.js') }}
  <script type="text/javascript">
    $('.time').html(function(index, value) {
      var format = getFormat(value);
      return moment(value).format(format);
    })
  </script>
@stop