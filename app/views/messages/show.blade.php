@extends('layouts.default')

@section('content')
  <div class="row">
    <div style="padding: 20px;"class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1>{{{ $user->username }}}</h1>
        </div>
        <div class="panel-body">
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
                  <p>{{{ $message->message }}}</p>
                </div>
              </div>
            </div>
          @endforeach
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
