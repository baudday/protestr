@extends('layouts.default')

@section('css')
  {{ HTML::style('css/protests/show.css') }}
@stop

@section('content')
  <div class="row">
    <div class="col-sm-2 left-column">
      <ul class="nav nav-pills nav-stacked" role="tablist">
        <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a></li>
        <li role="presentation"><a href="#updates" aria-controls="updates" role="tab" data-toggle="tab">Updates</a></li>
        <li role="presentation"><a href="#discussion" aria-controls="discussion" role="tab" data-toggle="tab">Discussion</a></li>
        @if (Auth::user() && Auth::user()->id == $creator->id)
        <li role="presentation"><a href="#post-update" aria-controls="post-update" role="tab" data-toggle="tab">Post an Update</a></li>
        @endif
      </ul>
    </div>

    <div class="col-sm-10">
      <div class="protest-header-container">
        <div class="protest-header">
          <h1>{{{ $protest->mission }}}</h1>
          <h3>{{{ $protest->type }}}</h3>
          <h4 class="time">{{{ $protest->when_date }}} {{{ $protest->when_time ? date('G:i:s e', strtotime($protest->when_time)) : null }}}</h4>
          @if($protest->address || $protest->city || $protest->state)
            <h4>
              <a href="{{ maps_url([$protest->address, $protest->city, $protest->state]) }}" target="_blank">
                <strong>{{{ $protest->address }}}</strong>
                {{ city_state($protest->city, $protest->state) }}</h4>
              </a>
            </h4>
          @endif
          <h4>{{ link_to($protest->website, $protest->website, ['target' => 'blank']) }}</h4>
          <div>
            {{ Form::open([
              'route' => ['protests.update', $protest->id],
              'method' => 'put'
            ]) }}
            @if(! Auth::check() || ! $protest->attendees->contains(Auth::user()->id))
              {{ Form::hidden('attendees', 'add') }}
              <div class="btn-group">
                <button type="submit" class="btn btn-danger">
                  <span class='glyphicon glyphicon-ok'></span> I'm not going
                </button>
                <button type="submit" class="btn btn-default">
                  I'm going
                </button>
              </div>
            @else
              {{ Form::hidden('attendees', 'remove') }}
              <div class="btn-group">
                <button type="submit" class="btn btn-default">
                  I'm not going
                </button>
                <button type="submit" class="btn btn-primary">
                  <span class='glyphicon glyphicon-ok'></span> I'm going
                </button>
              </div>
            @endif
            {{ Form::close() }}
            <h5>
              <a href="#" data-toggle="modal" data-target="#show-attendees">
                {{ $protest->attendees->count() }} {{ person_or_people($protest->attendees->count()) }} attending
              </a>
            </h5>
          </div>
        </div>
      </div>

      <!-- Begin Tab Stuff -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="info">
          <h2>The backstory</h2>
          <p style="white-space: pre-wrap;">{{{ $protest->history }}}</p>

          <h2>Our plan</h2>
          <p style="white-space: pre-wrap;">{{{ $protest->plan }}}</p>
        </div>

        <div role="tabpanel" class="tab-pane" id="updates">
          @if ($protest->updates->count() > 0)
            @foreach ($protest->updates as $update)
              <h1><strong>{{ $update->title }}</strong> <small class="time">{{ date('Y-m-d G:i:s e', $update->created_at->timestamp) }}</small></h1>
              {{ markdown($update->body) }}
              <hr>
            @endforeach
          @else
            <div style="text-align:center;">
              <h3><strong>No updates...</strong> yet</h3>
            </div>
          @endif
        </div>

        <div role="tabpanel" class="tab-pane" id="discussion">
          <div class="row">
            <div class="col-md-8">
              <h3>what people are saying...</h3>
              @foreach($protest->comments as $comment)
                <div class="row">
                  <div class="col-md-1">
                    {{ gravatar_tag($comment->user->email, [
                      's' => 40, 'd' => 'identicon']) }}
                  </div>
                  <div class="col-md-11">
                    {{ link_to_route('profile', $comment->user->username,
                      ['username' => $comment->user->username]) }}
                    <small class="time">
                      {{ date('Y-m-d G:i:s e', $comment->created_at->timestamp) }}
                    </small>
                    <br />
                    {{ $comment->body }} <br />
                    <span id="comment-{{ $comment->id }}-count">
                      {{ $comment->upvotes->count() }}
                    </span>
                    <a class="upvote" href="#" data-id="{{ $comment->id }}"
                      data-url="{{ route('comments.update', $comment->id) }}">
                      <span class="glyphicon glyphicon-thumbs-up"></span>
                      <span id="comment-{{ $comment->id }}-vote">
                        {{ $comment->upvoted(Auth::user()->id) ? 'upvoted' : 'upvote' }}
                      </span>
                    </a>
                    <hr>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        @if (Auth::user() && Auth::user()->id == $creator->id)
        <div role="tabpanel" class="tab-pane" id="post-update">
          <div class="col-md-6">
            <h3>post an update</h3>
            <hr>
            @include('updates.partials.create_form')
          </div>
          <div class="col-md-6">
            <h3>preview post</h3>
            <hr>
            <div id="update-preview"></div>
          </div>
        </div>
        @endif
      </div>
      <!-- End Tab Stuff -->

    </div>
  </div>

  <!-- Attendees Modal -->
  <div class="modal fade" id="show-attendees" tabindex="-1" role="dialog" aria-labelledby="show-attendees-label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="show-attendees-label">Attendees</h4>
        </div>
        <div class="modal-body">
          @foreach($protest->attendees as $attendee)
            <div class="row">
              <div class="col-xs-12">
                {{ link_to_route('users.show', $attendee->username, $attendee->username) }}
                <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                <hr>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@stop

@section('javascript')
  <script type="text/javascript">
  $('#update-text').keyup(function() {
    $.ajax({
      'method': 'post',
      'url': '{{ route('markdown.preview') }}',
      'data': {'body': $('#update-text').val()},
      'success': function(data) {
        $('#update-preview').html(data.body);
      }
    });
  });

  $('.upvote').on('click', function() {
    var id = $(this).data('id');
    var url = $(this).data('url');
    $.ajax({
      'method': 'patch',
      'url': url,
      success: function(data) {
        $("#comment-" + id + "-count").html(data.newCount);
        $("#comment-" + id + "-vote").html(data.status);
      }
    });

    return false;
  });
  </script>
@stop
