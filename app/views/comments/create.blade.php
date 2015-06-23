@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      @if(Session::get('comment'))
        <div class="alert alert-{{ Session::get('comment')['class'] }}">
          {{ Session::get('comment')['comment'] }}
        </div>
      @endif
      @include('comments.partials.create_form')
    </div>
  </div>
@stop
