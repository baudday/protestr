@if (Auth::check())
  <h3>contribute to the discussion</h3>
  @include('comments.partials.create_form')
  <hr>
@endif

<h3>what people are saying...</h3>
<ul class="media-list">
@foreach($comments as $comment)
  <li class="media">
    <div class="media-left">
      {{ gravatar_tag($comment->user->email, [
        's' => 40, 'd' => 'identicon']) }}
    </div>
    <div class="media-body">
      {{ link_to_route('profile', $comment->user->username,
        ['username' => $comment->user->username]) }}
      <small class="time">
        {{ date('Y-m-d G:i:s e', $comment->created_at->timestamp) }}
      </small>
      <br />
      {{ $comment->body }} <br />
      <span id="comment-{{ $comment->id }}-count">
        {{ $comment->upvotes()->count() }}
      </span>
      @if (Auth::check())
        <a class="upvote" href="#" data-id="{{ $comment->id }}"
          data-url="{{ route('protest.comments.update', [$protest->id, $comment->id]) }}">
          <span class="glyphicon glyphicon-thumbs-up"></span>
          <span id="comment-{{ $comment->id }}-vote">
            {{ $comment->upvoted(Auth::user()->id) ? 'upvoted' : 'upvote' }}
          </span>
        </a>
        | <a class="reply" href="#" data-parent-id="{{ $comment->id }}"
          data-toggle="modal" data-target="#reply-form">reply</a>
      @else
        <span class="glyphicon glyphicon-thumbs-up"></span>
      @endif
      <hr>
      @foreach($comment->replies as $reply)
      <div class="media">
        <div class="media-left">
          {{ gravatar_tag($reply->user->email, [
            's' => 40, 'd' => 'identicon']) }}
        </div>
        <div class="media-body">
          {{ link_to_route('profile', $reply->user->username,
            ['username' => $reply->user->username]) }}
          <small class="time">
            {{ date('Y-m-d G:i:s e', $reply->created_at->timestamp) }}
          </small>
          <br />
          {{ $reply->body }} <br />
          <span id="comment-{{ $reply->id }}-count">
            {{ $reply->upvotes }}
          </span>
          @if (Auth::check())
            <a class="upvote" href="#" data-id="{{ $reply->id }}"
              data-url="{{ route('protest.comments.update', [$protest->id, $reply->id]) }}">
              <span class="glyphicon glyphicon-thumbs-up"></span>
              <span id="comment-{{ $reply->id }}-vote">
                {{ $reply->upvoted(Auth::user()->id) ? 'upvoted' : 'upvote' }}
              </span>
            </a>
            | <a class="reply" href="#" data-parent-id="{{ $comment->id }}"
              data-toggle="modal" data-target="#reply-form">reply</a>
          @else
            <span class="glyphicon glyphicon-thumbs-up"></span>
          @endif
          <hr>
        </div>
      </div>
      @endforeach
    </div>
  </li>
@endforeach
</ul>