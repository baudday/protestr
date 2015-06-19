{{ Form::open(['route' => 'updates.store']) }}

{{ Form::hidden('protest_id', $protest->id) }}

<div class="form-group @if($errors->first('title')) has-error has-feedback @endif">
  {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
  {{ Form::text('title', null, [
    'class' => 'form-control input-lg',
    'tabindex' => '1',
    'placeholder' => 'This just in!'
  ]) }}
  @if($errors->first('title'))
    {{ error_message($errors->first('title')) }}
  @endif
</div>

<div class="form-group @if($errors->first('body')) has-error has-feedback @endif">
  {{ Form::label('body', 'What\'s new?', ['class' => 'control-label']) }}
  {{ Form::textarea('body', null, [
    'class' => 'form-control input-lg',
    'id' => 'update-text',
    'tabindex' => '2',
    'rows' => '5',
    'placeholder' => 'Markdown Supported'
  ]) }}
  @if($errors->first('body'))
    {{ error_message($errors->first('body')) }}
  @endif
</div>

<div class="form-group">
  {{ Form::submit('Post Update', ['class' => 'btn btn-lg btn-primary', 'tabindex' => '3' ]) }}
</div>

{{ Form::close() }}
