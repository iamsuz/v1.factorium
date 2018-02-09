<div style="text-align: center; font-size: 11px;">
	<div>
		@if($project->media->where('type', 'spv_logo_image')->first())
		<center><img src="{{$project->media->where('type', 'spv_logo_image')->first()->path}}" height="100"></center>
		@endif
		@if($project->projectspvdetail){{$project->projectspvdetail->spv_name}} <br>@endif
		@if($spv=$project->projectspvdetail){{$spv->spv_line_1}}, @if($spv->first()->spv_line_2){{$spv->spv_line_2}},@endif {{$spv->spv_city}}, {{$spv->spv_state}}, {{array_search($spv->spv_country, \App\Http\Utilities\Country::aus())}}, {{$spv->spv_postal_code}} <br>@endif
		@if($project->projectspvdetail){{$project->projectspvdetail->spv_contact_number}} <br>@endif
		<br><br>
		
		<h3>
			@if($project->projectspvdetail){{$project->projectspvdetail->spv_name}} -@endif
			INVESTMENT STATEMENT {{date('d-m-Y', strtotime($position->effective_date))}}
		</h3>
		<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
			<tbody>
				<tr>
					<td style="width: 50%;"><b>Investor Name</b></td>
					<td style="width: 50%;">{{$position->user->first_name}} {{$position->user->last_name}}</td>
				</tr>
				<tr>
					<td><b>Address</b></td>
					<td>
						{{$position->user->line_1}}, 
						@if($position->user->line_2){{$position->user->line_2}}, @endif
						{{$position->user->city}}, 
						{{$position->user->state}}, 
						{{$position->user->country}}, 
						{{$position->user->postal_code}}
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<h3>
			INVESTMENT BALANCE
		</h3>
		<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
			<tbody>
				<tr>
					<td style="width: 50%;"><b>@if($project->share_vs_unit) Shares @else Units @endif held as of {{date('d-m-Y', strtotime($position->effective_date))}}</b></td>
					<td style="width: 50%;">{{$position->number_of_shares}}</td>
				</tr>
				<tr>
					<td><b>@if($project->share_vs_unit) Share @else Unit @endif face value</b></td>
					<td>{{$position->current_value}}</td>
				</tr>
			</tbody>
		</table>
		<br>
		<h3>
			TRANSACTIONS
		</h3>
		<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
			<thead>
				<tr>
					<th style="width: 25%;">Date</th>
					<th style="width: 25%;">Transaction Type</th>
					<th style="width: 25%;">Amount</th>
					<th style="width: 25%;">Rate</th>
				</tr>
			</thead>
			<tbody>
				@foreach($transactions as $transaction)
				<tr>
					<td>{{date('d-m-Y', strtotime($transaction->transaction_date))}}</td>
					<td>{{$transaction->transaction_type}}</td>
					<td>{{$transaction->amount}}</td>
					<td>{{$transaction->rate}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>