<div class="list-group">
	<div class="list-group-item"><img src="{{asset('assets/images/default-male.png')}}" width="140" class="img-circle"></div>
	<a href="{{route('dashboard.index')}}" class="list-group-item @if($active == 1) active @endif">Dashboard <i class="fa fa-tachometer pull-right"></i></a>
	<a href="{{route('dashboard.users')}}" class="list-group-item @if($active == 2) active @endif">Users <i class="fa fa-users pull-right"></i></a>
	<a href="{{route('dashboard.projects')}}" class="list-group-item @if($active == 3) active @endif">Projects <i class="fa fa-paperclip pull-right"></i></a>
	<a href="{{route('dashboard.configurations')}}" class="list-group-item @if($active == 4) active @endif">Configurations <i class="fa fa-edit pull-right"></i></a>
	<a href="{{route('dashboard.broadcastMail')}}" class="list-group-item @if($active == 5) active @endif hide">Broadcast <i class="fa fa-envelope pull-right"></i></a>
</div>