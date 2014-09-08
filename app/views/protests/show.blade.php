@extends('layouts.default')

@section('css')
  {{ HTML::style('css/protests/show.css') }}
@stop

@section('content')
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <div class="protest-header-container">
        <div class="protest-header">
          <h1>{{{ $protest->mission }}} <small>{{ link_to($protest->website, $protest->website, ['target' => 'blank']) }}</small></h1>
          <h4 id="time">{{{ $protest->when_date }}} {{{ $protest->when_time ? date('G:i:s e', strtotime($protest->when_time)) : null }}}</h4>
          <h4>{{ $protest->attendees->count() }} {{ person_or_people($protest->attendees->count()) }} attending</h4>
          {{ Form::open([
            'route' => ['protests.update', $protest->id],
            'method' => 'put'
          ]) }}
          @if(! Auth::check() || ! $protest->attendees->contains(Auth::user()->id))
            {{ Form::hidden('attendees', 'add') }}
            <div class="btn-group">
              <button type="submit" class="btn btn-danger">
                <span class='glyphicon glyphicon-ok'></span> I'm not going
              </button>
              <button type="submit" class="btn btn-default">
                I'm going
              </button>
            </div>
          @else
            {{ Form::hidden('attendees', 'remove') }}
            <div class="btn-group">
              <button type="submit" class="btn btn-default">
                I'm not going
              </button>
              <button type="submit" class="btn btn-primary">
                <span class='glyphicon glyphicon-ok'></span> I'm going
              </button>
            </div>
          @endif
            {{ Form::close() }}
        </div>
      </div>

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
    var time = $('#time').html();
    var format = getFormat(time);
    var moment = moment(time);
    $('#time').html(moment.format(format));
  </script>
@stop
