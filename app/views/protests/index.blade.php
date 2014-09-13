@extends('layouts.default')

@section('css')
  {{ HTML::style('css/protests/index.css') }}
@stop

@section('content')
  <div class="row" ng-app="protestApp" ng-controller="protestsController">
    <div class="col-md-8 col-md-offset-2">
      <div ng-hide="loading || error">
        <h1>Trending protests near you</h1>
        <div class="row top-protest">
          <div class="col-md-12">
            <h2>
              <a href="/protests/<% data.top.id %>"><% data.top.mission %></a>
              <small><% UTIL.time(data.top.when_date) %></small>
            </h2>
            <p><% data.top.history.substring(0, 140) +"..." %></p>
            <p>
              <small><% data.top.attendeeCount %> attending</small><br />
              <small><% data.top.address %> <% UTIL.cityState(data.top.city, data.top.state) %></small>
            </p>
            <hr>
          </div>
        </div>
        <div class="row" ng-repeat="col in data.cols">
          <div class="col-md-6" ng-repeat="protest in col">
            <h4>
              <a href="/protests/<% protest.id %>"><% protest.mission %></a>
              <small><% UTIL.time(protest.when_date) %></small>
            </h4>
            <p><% protest.history.substring(0, 140) +"..." %></p>
            <p>
              <small><% protest.attendeeCount %> attending</small><br />
              <small><% protest.address %> <% UTIL.cityState(protest.city, protest.state) %></small>
            </p>
          </div>
        </div>
      </div>

      <div style="text-align: center;" ng-show="loading">
        <h2>
          <img src="img/loader.gif" width="20" /> fetching protests near you...<br />
          <small>For best results, please allow us to use your location</small>
        </h2>
      </div>

      <div style="text-align: center;" ng-show="error">
        <h2>
          <span ng-show="!noResults && !badLocation"><strong>Oops!</strong> We can't seem to find you! :(</span>
          <span ng-show="!noResults && badLocation"><strong>Oops!</strong> We don't recognize that location!</span>
          <span ng-show="noResults && !badLocation">
            <strong>No protests</strong> in your area.
            {{ link_to_route('protests.create', 'start one!') }}
          </span>
          <br />
          <small>For best results, please allow us to use your location</small>
        </h2>
        <div class="form-group col-xs-8 col-xs-offset-2">
          <form ng-submit="submitLocation()">
            <div class="input-group input-group-lg">
              {{ Form::text('address', null, [
                'class' => 'form-control input-lg',
                'tabindex' => '1',
                'placeholder' => 'Where are you?',
                'ng-model' => 'locationData.address'
              ]) }}
              <span class="input-group-btn">
                <button type="submit" class="btn btn-default btn-lg" tabindex="2">Go</button>
              </span>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
@stop

@section('javascript')
  {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.0.1/angular.min.js') }}
  {{ HTML::script('//maps.googleapis.com/maps/api/js?key=AIzaSyC-fp-wfsRUi-JeIiaHGFuXNjsCHe1pWVU')}}
  {{ HTML::script('js/controllers/protests/protestMainCtrl.js') }}
  {{ HTML::script('js/services/protests/protestService.js') }}
  {{ HTML::script('js/services/locationService.js') }}
  {{ HTML::script('js/app.js') }}
@stop
