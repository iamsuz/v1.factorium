@extends('layouts.main')
@section('title-section')
{{$project->title}} | Dashboard | @parent
@stop
@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>3])
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">{{$project->title}}
						<address class="text-center">
							<small>{{$project->location->line_1}}, {{$project->location->line_2}}, {{$project->location->city}}, {{$project->location->postal_code}},{{$project->location->country}}
							</small>
						</address>
					</h3>
				</div>
			</div>
			<h3 class="text-center">Investors</h3>
			<style type="text/css">
				.edit-input{
					display: none;
				}
			</style>
			<ul class="list-group">
				@foreach($investments as $investment)
				<div class="row text-center list-group-item">
					<div class="col-md-3 text-left">
						<a href="{{route('dashboard.users.show', [$investment->user_id])}}" >
							<b>{{$investment->user->first_name}} {{$investment->user->last_name}}</b>
						</a>
						<br>{{$investment->user->email}}<br>{{$investment->user->phone_number}}
					</div>
					<div class="col-md-3">{{$investment->created_at->toFormattedDateString()}}</div>
					<div class="col-md-3">
						<form action="{{route('dashboard.investment.update', $investment->id)}}" method="POST">
							{{method_field('PATCH')}}
							{{csrf_field()}}
							<a href="#" class="edit">${{number_format($investment->amount) }}</a>
							
							<input type="text" class="edit-input form-control" name="amount" id="amount" value="{{$investment->amount}}">
							<input type="hidden" name="investor" value="{{$investment->user->id}}">
						</form>
					</div>
					<div class="col-md-3">
						<form action="{{route('dashboard.investment.accept', $investment->id)}}" method="POST">
							{{method_field('PATCH')}}
							{{csrf_field()}}

							{{-- <input type="checkbox" name="accepted" onChange="this.form.submit()" value={{$investment->accepted ? 0 : 1}} {{$investment->accepted ? 'checked' : '' }}> Money {{$investment->accepted ? 'Received' : 'Not Received' }} --}}
							@if($investment->accepted)
							<i class="fa fa-check" aria-hidden="true" style="color: #6db980">&nbsp;Share certificate issued</i>
							@else
							<input type="submit" name="accepted" class="btn btn-primary issue-share-certi-btn" value="Issue share certificate">
							@endif
							<input type="hidden" name="investor" value="{{$investment->user->id}}">
						</form>
					</div>
				</div>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript">
	$(document).ready(function() {
		$('a.edit').click(function () {
			var dad = $(this).parent();
			$(this).hide();
			dad.find('input[type="text"]').show().focus();
		});

		$('input[type=text]').focusout(function() {
			var dad = $(this).parent();
			dad.submit();
		});

		$('.issue-share-certi-btn').click(function(e){
			if (confirm('Are you sure ?')) {
				console.log('confirmed');
		    } else {
		    	e.preventDefault();
		    }			
		});
	});
</script>
@endsection