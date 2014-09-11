<nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">protestr</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/">home</a></li>
        <li>{{ link_to_route('protests.index', 'protests') }}</li>
        <li>{{ link_to_route('protests.create', 'start a protest') }}</li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              {{ gravatar_tag(Auth::user()->email, array('s' => 20, 'd' => 'identicon')) }}
              {{ Auth::user()->username }}
              @if(Auth::user()->unreadMessageCount() > 0)
                <span class="badge">{{ Auth::user()->unreadMessageCount() }}</span>
              @endif
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>{{ link_to_route('profile', 'profile', [
                'username' => Auth::user()->username]) }}</li>
              <li>
                <a href="{{ route('messages.index') }}">messages
                  @if(Auth::user()->unreadMessageCount() > 0)
                    <span class="badge pull-right">{{ Auth::user()->unreadMessageCount() }}</span>
                  @endif
                </a>
              </li>
              <li class="divider"></li>
              <li>{{ link_to_route('logout', 'logout') }}</li>
            </ul>
          </li>
        @else
          <li><a href="/signup">sign up</a></li>
          <li><a href="/login">login</a></li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>