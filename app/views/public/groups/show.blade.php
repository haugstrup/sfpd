@extends("layout_public")
@section("title")
  Results {{{$group->heat->season->name}}}, {{{$group->heat->name}}}, {{{$group->name}}}
@stop
@section("content")

<ol class="breadcrumb">
  <li><a href="{{{URL::route('standings.show', $group->heat->season->season_id)}}}">{{{$group->heat->season->name}}}</a></li>
  <li><a href="{{{URL::route('results.show', $group->heat->heat_id)}}}">{{{$group->heat->name}}}</a></li>
  <li class="active dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">{{{$group->name}}}<span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
      @foreach($group->heat->groups as $g)
        <li role="presentation"><a role="menuitem" href="{{URL::route('groups.public', $g->group_id)}}">{{{$g->name}}}</a></li>
      @endforeach
    </ul>
  </li>
</ol>

@include('public.groups.group', array('group' => $group))

@stop
