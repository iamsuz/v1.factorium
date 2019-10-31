@extends('layouts.main')
@section('title-section')
Dashboard | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style type="text/css">
	.dividend-confirm-table td{ padding: 10px 20px; }
	.dividend-confirm-table{ margin-left:auto;margin-right:auto; }
	.success-icon {
		border: 1px solid;
		padding: 2px;
		border-radius: 20px;
		color: green;
		margin-left: 0.8rem;
	}
	h3{
		font-size: 16px;
	}
</style>
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>14])
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-12">
					@if (Session::has('message'))
					{!! Session::get('message') !!}
					@endif
					<h3 class="text-center">{{$project->title}}</h3>
					<p class="text-center"><strong>Project Wallet Address:</strong></p><p class="text-center"><small >{{ $project->wallet_address }}</small></p>
					@if($balanceAudk)
					<h4 class="text-center">
						@if(isset(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id)) {{App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->token_symbol}}
						@else AUDC
						@endif Balance: {{$balanceAudk->balance}}
					</h4>
					@endif
				</div>	
			</div>
			<div id="investors_tab" class="tab-pane fade in active" style="overflow: auto;">
				<style type="text/css">
					.edit-input{
						display: none;
					}
				</style>
				<br><br>
				<table class="table table-bordered table-striped center" id="redeemsTable" style="margin-top: 2em;">
					<thead>
						<tr>
							<th>Unique ID</th>
							<th>Investors Details</th>
							<th>Redeem Date</th>
							<th>Amount</th>
							<th>Paid type</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($redeemRequests as $redeemRequest)
						<tr>
							<td>INV{{ $redeemRequest->id }}</td>
							<td>{{ $redeemRequest->user->first_name }} </td>
							<td>{{ date("d/m/Y",strtotime($redeemRequest->created_at)) }}</td>
							<td>{{ $redeemRequest->amount }}</td>
							<td>{{ $redeemRequest->paid_in }}</td>
							<td>
								<div class="col-md-2">
									<form action="{{route('dashboard.audc.transfer', $redeemRequest->id)}}" method="POST">
										{{method_field('PATCH')}}
										{{csrf_field()}}
										@if($redeemRequest->confirmed)
										<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Redeem</small></i>
										@else
										<input type="submit" name="redeem_confirm" id="redeem_confirm{{$redeemRequest->id}}" class="btn btn-primary money-received-btn" value="Redeem">
										@endif
										{{-- <input type="hidden" name="admin_address" value="{{Auth::User()->wallet_address}}"> --}}
										<input type="hidden" name="user_address" value="{{$redeemRequest->user->wallet_address}}">
									</form>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/api/fnAddDataAndDisplay.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var redeemsTable = $('#redeemsTable').DataTable({
			"order": [0, 'desc'],
			"iDisplayLength": 25
		});

	});
</script>
@endsection