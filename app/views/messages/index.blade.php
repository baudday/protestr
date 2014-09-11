@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Inbox <small><span class="glyphicon glyphicon-asterisk"></span> = unread messages</small></h1>
    </div>
  </div>
  @foreach($messages as $message)
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h3>
          <a href="{{ route('messages.show', $message->sender->username) }}">
            @if(!$message->read)
              <span class="glyphicon glyphicon-asterisk"></span>
            @endif
            {{{ $message->sender->username }}}
          </a>
        </h3>
        <p>{{{ str_limit($message->message, 140) }}}</p>
        <p><small class="time">{{{ date('Y-m-d G:i:s e', $message->created_at->timestamp) }}}</small></p>
        <hr>
      </div>
    </div>
  @endforeach
@stop
