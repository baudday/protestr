<div role="tabpanel" class="tab-pane active" id="global">
  <div class="row">
    <div class="col-xs-12">
      <ul class="nav nav-pills sort-menu">
          <li role="presentation" ng-class="getClass('/global/trending')">
            <a href="#global/trending" ng-click="changeTab('global')">Trending</a>
          </li>
          <li role="presentation" ng-class="getClass('/global/newest')">
            <a href="#global/newest" ng-click="changeTab('global', 'newest')">Most Recent</a>
          </li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="row" ng-repeat="protest in data.global">
        <div class="col-md-12">
          <h2>
            <a href="/protests/<% protest.id %>"><% protest.mission %></a>
            <small><% UTIL.time(protest.when_date) %></small>
          </h2>
          <h4>
            <a href="/topics/<% protest.topic.slug %>"><% protest.topic.name %></a> | <% protest.type %>
          </h4>
          <p><% protest.history.substring(0, 140) +"..." %></p>
          <p>
            <small><% protest.attendeeCount %> attending</small><br />
            <small><% protest.address %> <% UTIL.cityState(protest.city, protest.state) %></small>
          </p>
        </div>
      </div>

      <div class="row" ng-show="data.global.length < 10 && data.global.length > 0">
        <div class="col-md-12" style="text-align:center;">
          <hr>
          <h2>
            <strong>That's all folks!</strong>
            <br />
            {{ link_to_route('protests.create', 'start your own protest') }}
          </h2>
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
  <ul class="nav" ng-show="data.global.length > 9">
    <li><a class="btn btn-default view-more" href="" ng-click="loadMore('global')">View More...</a></li>
  </ul>
</div>
