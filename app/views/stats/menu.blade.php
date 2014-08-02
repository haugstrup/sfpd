<ul class="nav nav-tabs" role="tablist">
  <li class="{{ substr(Request::path(), 12, 8) == 'machines' ? 'active' : '' }}"><a href="{{ URL::route('admin.stats.machines') }}">Stats</a></li>
  <li class="{{ substr(Request::path(), 12, 10) == 'activities' ? 'active' : '' }}"><a href="{{ URL::route('admin.stats.activities') }}">Activity log</a></li>
</ul>
