@extends('layouts.main')

@section('title-section')
{{$user->first_name}} Notification | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['active'=>15])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<ul class="list-group">
				<li class="list-group-item">
					<div class="text-center">
						<h3>{{$user->first_name}} {{$user->last_name}}<br><small>{{$user->email}}</small></h3>
					</div>
				</li>
			</ul>
			<h3 class="text-center">Buy AUDC Token</h3>
			<div class="">
				<form class="" action="{{route('project.user.audc.buy')}}" method="POST">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6 form-group">
							<label>Amount</label>
							<input type="number" name="amount_to_invest" class="form-control" placeholder="Enter a amount to buy an AUDC" max="10000">
						</div>
						<div class="col-md-6 form-group">
							<label>&nbsp;</label>
							<input type="submit" class="btn btn-primary form-control" name="submit" value="Buy">
						</div>
					</div>
				</form>
			</div>
			<div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="transactionTable">
						<thead>
							<tr>
								<th>Date of purchase</th>
								<th>Amount</th>
								<th>accepted</th>
								<th>Transaction</th>
							</tr>
						</thead>
						<tbody>
							@foreach($project->investors as $investor)
							<tr>
								<td>{{date("d/m/Y",strtotime($investor->created_at))}}</td>
								<td>{{$investor->pivot->amount}}
								</td>
								<td>@if($investor->pivot->accepted == 1) <i>Accepted</i> @else Yet to accept @endif</td>
								<td>
									@if($investor->pivot->transaction_hash){{$investor->pivot->transaction_hash}} @else Waiting for approval @endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<br><br>
</div>
@if(isset($project))
@include('partials.invoiceTermsConfirmationModal')
@endif
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var usersTable = $('#transactionTable').DataTable();
	});
</script>
@stop
