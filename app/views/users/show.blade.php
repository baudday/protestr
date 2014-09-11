@extends('layouts.default')

@section('content')
  @if(Session::get('message'))
    <div class="row">
      <div class="col-xs-12">
        <div class="alert alert-{{ Session::get('message')['class'] }}">
          {{ Session::get('message')['message'] }}
        </div>
      </div>
    </div>
  @endif
  <div class="row">
    <div class="col-md-2">
      <h1>{{{ $user->username }}}</h1>
      {{ gravatar_tag($user->email, array('s' => '132', 'd' => 'identicon')) }}
      @if(Auth::check())
        @if(Auth::user()->username == $user->username)
          <h5><a href="#"><span class="glyphicon glyphicon-pencil"></span> edit profile</a></h5>
        @else
          <h5><a href="#" data-toggle="modal" data-target="#send-message"><span class="glyphicon glyphicon-envelope"></span> send message</a></h5>
        @endif
      @endif
    </div>
    <div class="col-md-5">
      <h2>Protests I started</h2>
      @foreach($user->protests as $protest)
        <h3>{{ link_to_route('protests.show', $protest->mission, $protest->id) }} <small class="time">{{{ $protest->when_date }}}</small></h3>
        <p>{{{ str_limit($protest->history, 140) }}}</p>
      @endforeach
    </div>
    <div class="col-md-5">
      <h2>Protests I'm attending</h2>
      @foreach($user->attending as $protest)
        <h3>{{ link_to_route('protests.show', $protest->mission, $protest->id) }} <small class="time">{{{ $protest->when_date }}}</small></h3>
        <p>{{{ str_limit($protest->history, 140) }}}</p>
      @endforeach
    </div>
  </div>

  <!-- Send Message Modal -->
  <div class="modal fade" id="send-message" tabindex="-1" role="dialog" aria-labelledby="send-message-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="send-message-label">Send message</h4>
        </div>
        <div class="modal-body">
          @include('messages.partials.create_form')
        </div>
      </div>
    </div>
  </div>
@stop
