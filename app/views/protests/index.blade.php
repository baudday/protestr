@extends('layouts.default')

@section('css')
  {{ HTML::style('css/protests/index.css') }}
@stop

@section('content')
  <div class="row" ng-app="protestApp" ng-controller="protestsController">
    <div class="col-md-8 col-md-offset-2">
      <div ng-hide="loading">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Trending globally</h1>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="row" ng-repeat="protest in data.global">
                  <div class="col-md-12">
                    <h2>
                      <a href="/protests/<% protest.id %>"><% protest.mission %></a>
                      <small><% UTIL.time(protest.when_date) %></small>
                    </h2>
                    <h4><% protest.type %></h4>
                    <p><% protest.history.substring(0, 140) +"..." %></p>
                    <p>
                      <small><% protest.attendeeCount %> attending</small><br />
                      <small><% protest.address %> <% UTIL.cityState(protest.city, protest.state) %></small>
                    </p>
                  </div>
                </div>

                <div class="row" ng-show="noResults">
                  <div class="col-md-12" style="text-align:center;">
                    <h2>
                      <strong>No protests</strong> anywhere! :(
                      <br />
                      {{ link_to_route('protests.create', 'start one!') }}
                    </h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <ul class="nav" ng-show="data.global.length > 2">
            <li><a class="btn btn-default view-more" href="#">View More...</a></li>
          </ul>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Trending near you</h1>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <div class="row" ng-show="badLocation">
                  <div class="col-md-12" style="text-align: center;">
                    <h2>
                      <span><strong>Oops!</strong> We can't seem to find you! :(</span>
                      <br />
                      <small ng-show="badLocation">For best results, please allow us to use your location</small>
                    </h2>
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

                <div class="row" ng-show="noLocal">
                  <div class="col-md-12" style="text-align:center;">
                    <h2>
                      <strong>No protests</strong> in your area :(
                      <br />
                      {{ link_to_route('protests.create', 'start one!') }}
                    </h2>
                  </div>
                </div>

                <div class="row" ng-repeat="protest in data.local" ng-hide="badLocation || noLocal">
                  <div class="col-md-12">
                    <h2>
                      <a href="/protests/<% protest.id %>"><% protest.mission %></a>
                      <small><% UTIL.time(protest.when_date) %></small>
                    </h2>
                    <h4><% protest.type %></h4>
                    <p><% protest.history.substring(0, 140) +"..." %></p>
                    <p>
                      <small><% protest.attendeeCount %> attending</small><br />
                      <small><% protest.address %> <% UTIL.cityState(protest.city, protest.state) %></small>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <ul class="nav" ng-show="data.local.length > 2">
            <li><a class="btn btn-default view-more" href="#">View More...</a></li>
          </ul>
        </div>
      </div>

      <div style="text-align: center;" ng-show="loading">
        <h2>
          <img src="img/loader.gif" width="20" /> fetching protests...<br />
          <small>For best results, please allow us to use your location</small>
        </h2>
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
