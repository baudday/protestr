{{ Form::open( [
  'route' => ['protest.comments.store', $protest->id]
] ) }}

  {{ Form::hidden('parent', 0, ['class' => 'parent-comment-field']) }}

  <div class="row">
    <div class="form-group col-xs-12 @if($errors->first('comment')) has-error has-feedback @endif">
      <div class="col-sm-10">
        {{ Form::textarea('comment', null, [
          'class' => 'form-control input-lg',
          'tabindex' => '2',
          'rows' => '3',
          'placeholder' => 'What do you have to say?']) }}
        @if($errors->first('comment'))
          <span class="glyphicon glyphicon-remove form-control-feedback "></span>
          <div class="input-error"><small>{{ $errors->first('comment') }}</small></div>
        @endif
      </div>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-xs-12">
      <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-lg" tabindex="2">Post</button>
      </div>
    </div>
  </div>
{{ Form::close() }}