@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>1])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<ul class="list-group">
				<li class="list-group-item">
					<dl class="dl-horizontal">
						<dt></dt>
						<dd><h2>{{$user->first_name}} {{$user->last_name}}</h2></dd>
						<dt></dt>
						<dd>
							<div class="row">
								<div class="col-md-7">
									{{$user->email}}
								</div>
								<div class="col-md-5">
									<a href="{{route('users.edit', $user)}}">edit</a>
								</div>
							</div>
						</dd>
						<dt></dt>
						<dd>{{$user->phone_number}}</dd>
						<hr>
						<dt>Active</dt>
						<dd>@if($user->active) YES @else NO @endif</dd>

						@if($user->gender)
						<dt>Gender</dt>
						<dd>{{$user->gender}}</dd>
						@endif

						{{-- @if($user->date_of_birth)
						<dt>Date of Birth</dt>
						<dd><time datetime="{{$user->date_of_birth}}">{{$user->date_of_birth->toFormattedDateString()}}</time></dd>
						@endif --}}

						@if($user->active && $user->activated_on)
						<dt>Activated on</dt>
						<dd>
							<time datetime="{{$user->activated_on}}">{{$user->activated_on->toFormattedDateString()}}</time>
							<time datetime="{{$user->activated_on}}">( {{$user->activated_on->diffInDays()}} days ago )</time>
						</dd>
						@endif

						@if($user->last_login)
						<dt>Last Login</dt>
						<dd>
							<time datetime="{{$user->last_login}}">{{$user->last_login->toFormattedDateString()}}</time>
							<time datetime="{{$user->last_login}}">( {{$user->last_login->diffInDays()}} days ago )</time>
						</dd>
						@endif

						<dt>{{$user->roles->count()==1 ? 'Role' : 'Roles'}}</dt>
						<dd>
							@foreach($user->roles as $role)
							<div class="row">
								<div class="col-md-7">
									{{ ucfirst($role->role) }}
								</div>
								<div class="col-md-5">
									@if($user->roles->count()>1)
										@if(strcmp($role->role, "admin"))
											<a href="/users/{{$user->id}}/roles/{{$role->role}}/delete">Delete {{ucfirst($role->role)}} role</a>
										@elseif($user->roles->count() == 2)
											@if ($user->roles->contains('role', 'investor'))
												<a href="/users/{{$user->id}}/roles/developer/add">Add Developer role</a>
											@else
												<a href="/users/{{$user->id}}/roles/investor/add">Add Investor role</a>
											@endif
											
										@endif
									@else
									<a href="/users/{{$user->id}}/roles/{{ strcmp($role->role, "investor") == 0 ? 'developer' : 'investor'}}/add">Add {{strcmp($role->role, "investor") == 0 ? 'Developer' : 'Investor'}} role</a>
									@endif
								</div>
							</div>
							@endforeach

						</dd>

						<dt>ID Verification</dt>
						<dd>
							@if($user->verify_id == '2') Your id docs have been verified <i class="fa fa-check" style="color:green" data-toggle="tooltip" title="Verified User"></i> 
							@elseif($user->verify_id == '1') Your id docs have been submitted for verification <i class="fa fa-hourglass-start" style="color:pink" data-toggle="tooltip" title="Submitted"></i> 
							@elseif($user->verify_id == '0') You did not submit your id docs for verification <i class="fa fa-clock-o" data-toggle="tooltip" title="Not submitted"></i> 
							@elseif($user->verify_id == '-1') Your verification failed please <a href="{{route('users.verification', $user)}}">try again</a> <i class="fa fa-refresh" style="color:red" data-toggle="tooltip" title="Try Again (verification failed)"></i> 
							@else <i class="fa fa-clock-o" data-toggle="tooltip" title="Not submitted"></i> @endif
						</dd>
						<dt>Registration Site</dt>
						<dd>
							<a href="{{$user->registration_site}}">{{$user->registration_site}}</a>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
</div>
@stop
