<ul class="nav nav-tabs" role="tablist">
  <li class="{{ Request::path() == 'admin/seasons' ? 'active' : '' }}"><a href="{{ URL::route('admin.seasons.index') }}">All Seasons</a></li>
  <li class="{{ substr(Request::path(), 14, 6) == 'create' ? 'active' : '' }}"><a href="{{ URL::route('admin.seasons.create') }}">Add new season</a></li>
</ul>
