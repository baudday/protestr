@extends('layouts.default')

@section('css')
  {{ HTML::style('css/protests/index.css') }}
@stop

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>trending protests</h1>
      <div class="row top-protest">
        <div class="col-md-12">
          <h2>
            {{ link_to_route('protests.show', $top->mission, $top->id) }}
            <small class="time">{{ $top->when_date }}</small>
          </h2>
          <p>{{ str_limit($top->history, 140) }}</p>
          <p>
            <small>{{ $top->attendeeCount }} {{ person_or_people($top->attendeeCount) }} attending</small><br />
            <small>{{ $top->address }} {{ city_state($top->city, $top->state) }}</small>
          </p>
          <hr>
        </div>
      </div>
      @foreach(array_chunk($protests->toArray(), 2) as $row)
        <div class="row">
          @foreach($row as $protest)
            <div class="col-md-6">
              <h4>
                {{ link_to_route('protests.show', $protest['mission'], $protest['id']) }}
                <small class="time">{{ $protest['when_date'] }}</small>
              </h4>
              <p>{{ str_limit($protest['history'], 140) }}</p>
              <p>
                <small>{{ $protest['attendeeCount'] }} {{ person_or_people($protest['attendeeCount']) }} attending</small><br />
                <small>{{ $protest['address'] }} {{ city_state($protest['city'], $protest['state']) }}</small>
              </p>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </div>
@stop
