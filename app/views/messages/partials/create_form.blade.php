{{ Form::open( [
  'route' => 'messages.store',
  'class' => 'form-horizontal'
] ) }}

  {{ Form::hidden('to_id', $user->id) }}
  {{ Form::hidden('to_username', $user->username) }}

  <div class="form-group">
    {{ Form::label('to', 'To', ['class' => 'control-label col-sm-2']) }}
    <div class="col-sm-10">
      <h4>{{{ $user->username }}}</h4>
    </div>
  </div>

<!--   <div class="form-group">
    {{ Form::label('subject', 'Subject', ['class' => 'control-label col-sm-2']) }}
    <div class="col-sm-10">
      {{ Form::text('subject', null, [
        'class' => 'form-control input-lg',
        'tabindex' => '1',
        'placeholder' => 'Subject'
      ]) }}
    </div>
  </div> -->

  <div class="form-group @if($errors->first('message')) has-error has-feedback @endif">
    {{ Form::label('message', 'Message', ['class' => 'control-label col-sm-2']) }}
    <div class="col-sm-10">
      {{ Form::textarea('message', null, [
        'class' => 'form-control input-lg',
        'tabindex' => '2',
        'rows' => '3',
        'placeholder' => 'What\'s up?']) }}
      @if($errors->first('message'))
        <span class="glyphicon glyphicon-remove form-control-feedback "></span>
        <div class="input-error"><small>{{ $errors->first('message') }}</small></div>
      @endif
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      <button type="submit" class="btn btn-primary btn-lg">Send</button>
    </div>
  </div>
{{ Form::close() }}