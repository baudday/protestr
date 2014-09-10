@extends('layouts.default')

@section('css')
  {{ HTML::style('css/messages/show.css') }}
@stop

@section('content')
  <div class="row">
    <div style="padding: 20px;"class="col-md-6 col-md-offset-3">
      <h4>{{ link_to_route('messages.index', 'back to inbox') }}</h4>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1>{{{ $user->username }}}</h1>
        </div>
        <div class="panel-body" id="chat-window">
          @foreach($messages as $message)
            <div class="row">
              <div class="col-xs-12">
                @if($message->sender->id == Auth::user()->id)
                  <div class="pull-right" style="text-align: right;">
                @else
                  <div>
                @endif
                  {{ gravatar_tag($message->sender->email, [
                    's' => 20, 'd' => 'identicon']) }}<br />
                  <small>{{ link_to_route('profile',
                    $message->sender->username, 
                    ['username' => $message->sender->username]) }}
                  </small>
                  <p><small class="time">{{{ date('Y-m-d G:i:s e', $message->created_at->timestamp) }}}</small><br />
                    {{{ $message->message }}}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col-xs-12">
              @include('messages.partials.create_form')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('javascript')
  {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js') }}
  {{ HTML::script('js/timezones.js') }}
  <script type="text/javascript">
    var objDiv = document.getElementById("chat-window");
    objDiv.scrollTop = objDiv.scrollHeight;
    $('.time').html(function(index, value) {
      var format = getFormat(value);
      return moment(value).format(format);
    });
  </script>
@stop
