@extends("layout_public")
@section("title")
  Results {{{$season->name}}}, {{{$heat->name}}}
@stop
@section("content")

<ol class="breadcrumb">
  <li><a href="{{{URL::route('standings.show', $season->season_id)}}}">{{{$season->name}}}</a></li>
  <li class="active dropdown">
    <a class="dropdown-toggle" href="3" data-toggle="dropdown" aria-expanded="false">{{{$heat->name}}}<span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
      @foreach($heats as $h)
        <li role="presentation"><a role="menuitem" href="{{URL::route('results.show', $h->heat_id)}}">{{{$season->name}}} {{{$h->name}}}</a></li>
      @endforeach
    </ul>
  </li>
</ol>

<ul class="list-unstyled">
  @foreach($heat->groups as $group)
    @if(count($group->games) > 0)
    <li>
      @include('public.groups.group', array('group' => $group))
    </li>
    @endif
  @endforeach
</ul>

@stop
