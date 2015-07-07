@extends('layouts.default')

@section('css')
  {{ HTML::style('css/protests/index.css') }}
@stop

@section('content')
  <div class="row">
    <div class="col-md-8" ng-app="protestApp" ng-controller="protestsController">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
          <a id="global-tab" href="#global" aria-controls="global" role="tab" data-toggle="tab" ng-click="changeTab('global')">Global Protests</a>
        </li>
        <li role="presentation">
          <a id="local-tab" href="#local" aria-controls="local" role="tab" data-toggle="tab" ng-click="changeTab('local')">Nearby Protests</a>
        </li>
      </ul>
      <div class="tab-content" ng-hide="loading">
        @include('protests.partials.global')
        @include('protests.partials.local')
      </div>

      <div style="text-align: center;" ng-show="loading">
        <h2>
          {{ HTML::image('img/loader.gif', 'Loading', ['width' => '20']) }} fetching protests...<br />
          <small>For best results, please allow us to use your location</small>
        </h2>
      </div>

    </div>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2>Topics</h2>
          <hr>
          <ul class="nav nav-pills nav-stacked">
            @foreach($topics as $topic)
              <li role="presentation" class = "{{ isset($slug) && $slug == $topic->slug ? 'active' : ''}}">{{ link_to_route('topics.show', $topic->name, $topic->slug) }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@stop

@section('javascript')
  <script type="text/javascript">
    @if(isset($page_topic))
      window.apiUrl = '/api/v1/protests?topic={{ $page_topic->slug }}&'
    @else
      window.apiUrl = '/api/v1/protests?';
    @endif
  </script>
  {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.0.1/angular.min.js') }}
  {{ HTML::script('js/controllers/protests/protestMainCtrl.js') }}
  {{ HTML::script('js/services/protests/protestService.js') }}
  {{ HTML::script('js/services/locationService.js') }}
  {{ HTML::script('js/app.js') }}
@stop
