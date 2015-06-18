@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <a href="{{ route('protests.show', $protest->id) }}"><span class="glyphicon glyphicon-chevron-left"></span> back to protest</a>
      <h1>post an update</h1>
      @if(Session::get('message'))
        <div class="alert alert-{{ Session::get('message')['class'] }}">
          {{ Session::get('message')['message'] }}
        </div>
      @endif
      @include('updates.partials.create_form')
    </div>
  </div>
@stop
