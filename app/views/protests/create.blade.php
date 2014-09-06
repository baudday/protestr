@extends('layouts.default')

@section('content')
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1>start a protest</h1>
        </div>

        <div class="panel-body">
          @if(Session::get('message'))
            <div class="alert alert-{{ Session::get('message')['class'] }}">
              {{ Session::get('message')['message'] }}
            </div>
          @endif
          {{ Form::open( ['route' => 'protests.store'] ) }}

            <!-- Protest Info -->
            <fieldset>

              <div class="form-group @if($errors->first('mission')) has-error has-feedback @endif">
                {{ Form::label('mission', 'Your mission', ['class' => 'control-label']) }}
                {{ Form::text('mission', null, [
                  'class' => 'form-control input-lg',
                  'tabindex' => '1',
                  'placeholder' => 'What are you trying to accomplish?'
                ]) }}
                @if($errors->first('mission'))
                  <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  <div class="input-error"><small>{{ $errors->first('mission') }}</small></div>
                @endif
                <small>This should be a short call to action. Why are you arranging this protest?</small>
              </div>

              <div class="form-group @if($errors->first('history')) has-error has-feedback @endif">
                {{ Form::label('history', 'The backstory', ['class' => 'control-label']) }}
                {{ Form::textarea('history', null, [
                  'class' => 'form-control input-lg',
                  'tabindex' => '2',
                  'rows' => '5',
                  'placeholder' => 'What has led up to this and what are you protesting?']) }}
                @if($errors->first('history'))
                  <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  <div class="input-error"><small>{{ $errors->first('history') }}</small></div>
                @endif
                <small>This is where you want to outline exactly why you have decided to arrange a protest.</small>
              </div>

              <div class="form-group @if($errors->first('plan')) has-error has-feedback @endif">
                {{ Form::label('plan', 'Your plan of action', ['class' => 'control-label']) }}
                {{ Form::textarea('plan', null, [
                  'class' => 'form-control input-lg',
                  'tabindex' => '3',
                  'rows' => '9',
                  'placeholder' => 'How exactly is this protest going to go down?'
                ]) }}
                @if($errors->first('plan'))
                  <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  <div class="input-error"><small>{{ $errors->first('plan') }}</small></div>
                @endif
                <small>Go into as much detail here as possible. This is your chance to show everyone you mean business!</small>
              </div>

              <div class="form-group @if($errors->first('website')) has-error has-feedback @endif">
                {{ Form::label('website', 'Website (optional)', ['class' => 'control-label']) }}
                {{ Form::text('website', null, [
                  'class' => 'form-control input-lg',
                  'tabindex' => '4',
                  'placeholder' => 'http://'
                ]) }}
                @if($errors->first('website'))
                  <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  <div class="input-error"><small>{{ $errors->first('website') }}</small></div>
                @endif
              </div>

            </fieldset>

            <!-- Location Info -->
            <fieldset>

              <h3>Where is it? <small>Be as specific or vague as you'd like</small></h3>

              <div class="form-group @if($errors->first('address')) has-error has-feedback @endif">
                {{ Form::label('address', 'Address (optional)', ['class' => 'control-label']) }}
                {{ Form::text('address', null, [
                  'class' => 'form-control input-lg',
                  'tabindex' => '5',
                  'placeholder' => 'Ex: "123 Fake St" or "My Place"'
                ]) }}
                @if($errors->first('address'))
                  <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                @endif
                <span class="danger">{{ $errors->first('address') }}</span>
              </div>

              <div class="row">
                <div class="form-group @if($errors->first('city')) has-error has-feedback @endif col-xs-8">
                  {{ Form::label('city', 'City (optional)', ['class' => 'control-label']) }}
                  {{ Form::text('city', null, [
                    'class' => 'form-control input-lg',
                    'tabindex' => '6',
                    'placeholder' => 'City'
                  ]) }}
                  @if($errors->first('city'))
                    <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  @endif
                  <span class="danger">{{ $errors->first('city') }}</span>
                </div>

                <div class="form-group @if($errors->first('state')) has-error has-feedback @endif col-xs-4">
                  {{ Form::label('state', 'State (optional)', ['class' => 'control-label']) }}
                  {{ Form::select('state', states(), null, [
                    'class' => 'form-control input-lg',
                    'tabindex' => '7'
                  ]) }}
                  @if($errors->first('state'))
                    <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  @endif
                  <span class="danger">{{ $errors->first('state') }}</span>
                </div>
              </div>

            </fieldset>

            <!-- Date/Time Info -->
            <fieldset>

              <h3>When is it?</h3>

              <div class="form-group @if($errors->first('date')) has-error has-feedback @endif">
                {{ Form::label('date', 'Date', ['class' => 'control-label']) }}
                {{ Form::text('date', null, [
                  'class' => 'form-control input-lg',
                  'tabindex' => '8',
                  'placeholder' => 'mm/dd/yyyy'
                ]) }}
                @if($errors->first('date'))
                  <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  <div class="input-error"><small>{{ $errors->first('date') }}</small></div>
                @endif
              </div>

              <div class="row">
                <div class="form-group @if($errors->first('time')) has-error has-feedback @endif col-xs-8">
                  {{ Form::label('time', 'Time (optional)', ['class' => 'control-label']) }}
                  {{ Form::text('time', null, [
                    'class' => 'form-control input-lg',
                    'tabindex' => '9',
                    'placeholder' => '12:00PM']) }}
                  @if($errors->first('time'))
                    <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                    <div class="input-error"><small>{{ $errors->first('time') }}</small></div>
                  @endif
                </div>

                <div class="form-group @if($errors->first('timezone')) has-error has-feedback @endif col-xs-4">
                  {{ Form::label('timezone', 'Timezone (optional)', ['class' => 'control-label']) }}
                  {{ Form::select('timezone', timezones(), null, [
                    'class' => 'form-control input-lg',
                    'tabindex' => '10'
                  ]) }}
                  @if($errors->first('timezone'))
                    <span class="glyphicon glyphicon-remove form-control-feedback "></span>
                  @endif
                  <span class="danger">{{ $errors->first('timezone') }}</span>
                </div>
              </div>

            </fieldset>

            <div class="form-group">
              {{ Form::submit('Start protest', ['class' => 'btn btn-lg btn-primary' ]) }}
            </div>

          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@stop

@section('javascript')
  {{ HTML::script('js/jstz.min.js') }}
  <script type="text/javascript">
    var ts = new Date().toTimeString();
    var patt = /\((\w+)\)/g;
    var tz = patt.exec(ts)[1];
    $('select[name=timezone]').val(tz);
  </script>
@stop
