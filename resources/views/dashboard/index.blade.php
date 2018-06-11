@extends('layouts.main')

@section('title-section')
Dashboard | @parent
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>1])
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="row" style="padding-top:1.2em;">
						<div class="col-md-4">
							<div class="thumbnail text-center">
								<div class="caption">
									<h3><b>{{$users->count()}}</b></h3>
									<h4><small>Total Users</small> </h4>
									<P><small>({{$users->where('active', '0')->count()}} Inactive Users)</small></P>
									<P><a href="{{route('dashboard.users')}}" class="btn btn-primary btn-sm" role="button">All Users</a></P>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="thumbnail text-center">
								<div class="caption">
									<h3><b>{{$projects->count()}}</b></h3>
									<h4><small>Projects</small> </h4>
									<P><small>({{$projects->where('active', '0')->count()}} Inactive &amp; {{$projects->where('active', '2')->count()}} Private Projects)</small></P>
									<p><a href="{{route('dashboard.projects')}}" class="btn btn-primary btn-sm" role="button">All Projects</a></p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="thumbnail text-center">
								<div class="caption" style="margin-bottom: 2.475em;">

									<h3><b>${{number_format($pledged_investments) }}</b></h3>
									<h4><small>Funds Raised</small> </h4>
									<p><small>(${{ number_format($total_goal - $pledged_investments) }} amount remaining)</small></p>
									{{-- <p><a href="#" class="btn btn-default btn-sm" role="button">Investors</a></p> --}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
