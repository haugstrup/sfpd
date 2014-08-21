<ul class="nav nav-tabs" role="tablist">
  <li class="{{ strlen(Request::path()) == 15 || Request::path() == 'admin' ? 'active' : '' }}"><a href="{{ URL::route('admin.seasons.show', array($season->season_id)) }}">{{{$season->name}}}</a></li>
  <li class="{{ substr(Request::path(), 16, 4) == 'edit' ? 'active' : '' }}"><a href="{{ URL::route('admin.seasons.edit', array($season->season_id)) }}">Edit</a></li>
  <li class="{{ substr(Request::path(), 16, 7) == 'players' ? 'active' : '' }}"><a href="{{ URL::route('admin.seasons.players', array($season->season_id)) }}">Administer players</a></li>
</ul>
