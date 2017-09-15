@extends('layouts.main')
@section('title-section')
{{$project->title}} | Dashboard | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
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
					@if (Session::has('message'))
					{!! Session::get('message') !!}
					@endif
					<h3 class="text-center">{{$project->title}}
						<address class="text-center">
							<small>{{$project->location->line_1}}, {{$project->location->line_2}}, {{$project->location->city}}, {{$project->location->postal_code}},{{$project->location->country}}
							</small>
						</address>
					</h3>
				</div>
			</div>
			<ul class="nav nav-tabs" style="margin-top: 2em; width: 100%;">
				<li class="active" style="width: 20%;"><a data-toggle="tab" href="#investors_tab" style="padding: 0em 2em"><h3 class="text-center">Investors</h3></a></li>
				<li style="width: 25%;"><a data-toggle="tab" href="#share_registry_tab" style="padding: 0em 2em"><h3 class="text-center">Share registry</h3></a></li>
				<li style="width: 20%;"><a data-toggle="tab" href="#transactions_tab" style="padding: 0em 2em"><h3 class="text-center">Transactions</h3></a></li>
				<li style="width: 35%;"><a data-toggle="tab" href="#positions_tab" style="padding: 0em 2em"><h3 class="text-center">Position records</h3></a></li>
			</ul>
			<div class="tab-content">
				<div id="investors_tab" class="tab-pane fade in active" style="overflow: auto;">
					<style type="text/css">
						.edit-input{
							display: none;
						}
					</style>
					<br><br>
					<table class="table table-bordered table-striped" id="investorsTable" style="margin-top: 2em;">
						<thead>
							<tr>
								<th>Unique ID</th>
								<th>Investors Details</th>
								<th>Investment Date</th>
								<th>Amount</th>
								<th>Is Money Received</th>
								<th>Share Certificate</th>
								<th>Send Reminder Email</th>
								<th>Investment Confirmation</th>
								<th>Investor Document</th>
								<th>Joint Investor</th>
								<th>Company or Trust</th>
							</tr>
						</thead>
						<tbody>
							@foreach($investments as $investment)
							<tr>
								<td>INV{{$investment->id}}</td>
								<td>
									<div class="col-md-3 text-left">
										<a href="{{route('dashboard.users.show', [$investment->user_id])}}" >
											<b>{{$investment->user->first_name}} {{$investment->user->last_name}}</b>
										</a>
										<br>{{$investment->user->email}}<br>{{$investment->user->phone_number}}
									</div>
								</td>
								<td>
									<div class="col-md-2 text-right">{{$investment->created_at->toFormattedDateString()}}</div>
								</td>
								<td>
									<div class="col-md-1">
										<form action="{{route('dashboard.investment.update', $investment->id)}}" method="POST">
											{{method_field('PATCH')}}
											{{csrf_field()}}
											<a href="#edit" class="edit">${{number_format($investment->amount) }}</a>

											<input type="text" class="edit-input form-control" name="amount" id="amount" value="{{$investment->amount}}" style="width: 100px;">
											<input type="hidden" name="investor" value="{{$investment->user->id}}">
										</form>
									</div>
								</td>
								<td>
									<div class="col-md-2">
										<form action="{{route('dashboard.investment.moneyReceived', $investment->id)}}" method="POST">
											{{method_field('PATCH')}}
											{{csrf_field()}}
											@if($investment->money_received || $investment->accepted)
											<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Money Received</small></i>
											@else
											<input type="submit" name="money_received" class="btn btn-primary money-received-btn" value="Money Received">
											@endif
										</form>
									</div>
								</td>
								<td>
									<div class="col-md-2">
										<form action="{{route('dashboard.investment.accept', $investment->id)}}" method="POST">
											{{method_field('PATCH')}}
											{{csrf_field()}}

											{{-- <input type="checkbox" name="accepted" onChange="this.form.submit()" value={{$investment->accepted ? 0 : 1}} {{$investment->accepted ? 'checked' : '' }}> Money {{$investment->accepted ? 'Received' : 'Not Received' }} --}}
											@if($investment->accepted)
											<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Share certificate issued</small></i>
											@else
											<input type="submit" name="accepted" class="btn btn-primary issue-share-certi-btn" value="Issue share certificate">
											@endif
											<input type="hidden" name="investor" value="{{$investment->user->id}}">
										</form>
									</div>
								</td>
								<td>
									@if($investment->money_received || $investment->accepted)
									@else
									<div class="col-md-1" style="text-align: right;">
										@if(Session::has('action'))
										@if(Session::get('action') == $investment->id)
										<i class="fa fa-check" aria-hidden="true" style="color: #6db980;"></i>
										@else
										<a class="send-investment-reminder" href="{{route('dashboard.investment.reminder', [$investment->id])}}" style="cursor: pointer;" data-toggle="tooltip" title="Send Reminder"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
										@endif
										@else
										<a class="send-investment-reminder" href="{{route('dashboard.investment.reminder', [$investment->id])}}" style="cursor: pointer;" data-toggle="tooltip" title="Send Reminder"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
										@endif
									</div>
									@endif
								</td>
								<td>
									@if($investment->money_received || $investment->accepted)
									@else
									<div class="col-md-1" style="text-align: right;">
										<form action="{{route('dashboard.investment.confirmation', $investment->id)}}" method="POST" id="confirmationForm{{$investment->id}}">
											{{method_field('PATCH')}}
											{{csrf_field()}}
											@if($investment->investment_confirmation == 1)
											<span data-toggle="tooltip" title="Investment Confirmed"><i class="fa fa-check" aria-hidden="true" style="color: #6db980;"></i><i class="fa fa-money" aria-hidden="true" style="color: #6db980;"></i></span>
											@else
											<a id="confirmation{{$investment->id}}" data-toggle="tooltip" title="Investment Confirmation"><i class="fa fa-money" aria-hidden="true"></i></a>
											<input class="hidden" name="investment_confirmation" value="1">
											@endif
											<input type="hidden" name="investor" value="{{$investment->user->id}}">
										</form>
										<script>
											$(document).ready(function() {
												$('#confirmation{{$investment->id}}').click(function(e){
													$('#confirmationForm{{$investment->id}}').submit();
												});
											});
										</script>
									</div>
									@endif
								</td>
								<td>
									@if($investment->userInvestmentDoc->where('type','normal_name')->last())
									<a href="/{{$investment->userInvestmentDoc->where('type','normal_name')->last()->path}}" target="_blank">{{$investment->user->first_name}} {{$investment->user->last_name}} Doc</a>
									<a href="#" class="pop">
										<img src="/{{$investment->userInvestmentDoc->where('type','normal_name')->last()->path}}" style="width: 300px;" class="img-responsive">
									</a>
									<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">              
												<div class="modal-body">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<img src="" class="imagepreview" style="width: 100%;" >
												</div>
											</div>
										</div>
									</div>
									<script>
										$(function() {
											$('.pop').on('click', function() {
												$('.imagepreview').attr('src', $(this).find('img').attr('src'));
												$('#imagemodal').modal('show');   
											});		
										});
									</script>
									@else
									NA
									@endif
								</td>
								<td>
									@if($investment->userInvestmentDoc)
									@if($investment->userInvestmentDoc->where('type','joint_investor')->last())
									<a href="/{{$investment->userInvestmentDoc->where('type','joint_investor')->last()->path}}" target="_blank">{{$investment->investingJoint->joint_investor_first_name}} {{$investment->investingJoint->joint_investor_last_name}} Doc</a>
									<br>
									@else
									NA
									@endif
									@endif
								</td>
								<td>
									@if($investment->userInvestmentDoc)
									@if($investment->userInvestmentDoc->where('type','trust_or_company')->last())
									<a href="/{{$investment->userInvestmentDoc->where('type','trust_or_company')->last()->path}}" target="_blank"> 
										{{$investment->investingJoint->investing_company}} Doc 
									</a>
									@else
									NA
									@endif
									@else 
									NA 
									@endif
								</td>
							</tr>
							{{-- @if($project->projectconfiguration->payment_switch)
							@else
							<div class="col-md-1" style="text-align: right;">
								<form action="{{route('dashboard.investment.confirmation', $investment->id)}}" method="POST" id="confirmationForm{{$investment->id}}">
									{{method_field('PATCH')}}
									{{csrf_field()}}
									@if($investment->investment_confirmation == 1)
									<span data-toggle="tooltip" title="Investment Confirmed"><i class="fa fa-check" aria-hidden="true" style="color: #6db980;"></i><i class="fa fa-money" aria-hidden="true" style="color: #6db980;"></i></span>
									@else
									<a id="confirmation{{$investment->id}}" data-toggle="tooltip" title="Investment Confirmation"><i class="fa fa-money" aria-hidden="true"></i></a>
									<input class="hidden" name="investment_confirmation" value="1">
									@endif
									<input type="hidden" name="investor" value="{{$investment->user->id}}">
								</form>
								<script>
									$(document).ready(function() {
										$('#confirmation{{$investment->id}}').click(function(e){
											$('#confirmationForm{{$investment->id}}').submit();
										});
									});
								</script>
							</div>
							@endif --}}
							@endforeach
						</tbody>
					</table>
				</div>

				<div id="share_registry_tab" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
					<!-- <ul class="list-group">Hello</ul> -->
					<div class="share-registry-actions">
						<button class="btn btn-primary issue-dividend-btn" action="dividend">Issue Dividend</button>
						<button class="btn btn-primary repurchase-shares-btn" action="repurchase">Repurchase</button>
					</div>
					<form action="{{route('dashboard.investment.declareDividend', [$project->id])}}" method="POST">
						{{csrf_field()}}
						<span class="declare-statement hide"><small>Issue Dividend at <input type="number" name="dividend_percent" id="dividend_percent" step="0.01">% annual for the duration of between <input type="Date" name="start_date" id="start_date"> and <input type="Date" name="end_date" id="end_date"> : <input type="submit" class="btn btn-primary declare-dividend-btn" value="Declare"></small></span>
						<input type="hidden" class="investors-list" id="investors_list" name="investors_list">
					</form>
					<form action="{{route('dashboard.investment.declareRepurchase', [$project->id])}}" method="POST">
						{{csrf_field()}}
						<span class="repurcahse-statement hide"><small>Repurchase shares at $<input type="number" name="repurchase_rate" id="repurchase_rate" value="1" step="0.01"> per share : <input type="submit" class="btn btn-primary declare-repurchase-btn" value="Declare"></small></span>
						<input type="hidden" class="investors-list" id="investors_list" name="investors_list">
					</form>
					<form action="{{route('dashboard.investment.statement', [$project->id])}}" method="POST" class="text-right">
						{{csrf_field()}}
						<button type="submit" class="btn btn-default" id="generate_investor_statement"><b>Generate Investor Statement</b></button>
					</form>
					<br><br>
					<div class="">
						<table class="table table-bordered table-striped" id="shareRegistryTable">
							<thead>
								<tr>
									<th class="select-check hide nosort"><input type="checkbox" class="check-all" name=""></th>
									<th>Unique ID</th>
									<th>Share numbers</th>
									<th>Project SPV Name</th>
									<th>Investor Name</th>
									<th>Investment type</th>
									<th>Joint Investor Name</th>
									<th>Entity details</th>
									<th>Phone</th>
									<th>Email</th>
									<th>Address</th>
									<th>Share face value</th>
									<th>Link to share certificate</th>
									<th>TFN</th>
									<th>Investment Documents</th>
									<th>Account Name</th>
									<th>BSB</th>
									<th>Account Number</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($shareInvestments as $shareInvestment)
								<tr @if($shareInvestment->is_cancelled) style="color: #CCC;" @endif>
									<td class="text-center select-check hide">@if(!$shareInvestment->is_cancelled) <input type="checkbox" class="investor-check" name="" value="{{$shareInvestment->id}}"> @endif</td>
									<td>INV{{$shareInvestment->id}}</td>
									<td>@if($shareInvestment->share_number){{$shareInvestment->share_number}}@else{{'NA'}}@endif</td>
									<td>@if($shareInvestment->project->projectspvdetail){{$shareInvestment->project->projectspvdetail->spv_name}}@endif</td>
									<td>{{$shareInvestment->user->first_name}} {{$shareInvestment->user->last_name}}</td>
									<td>{{$shareInvestment->investing_as}}</td>
									<td>@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->joint_investor_first_name.' '.$shareInvestment->investingJoint->joint_investor_last_name}}@else{{'NA'}}@endif</td>
									<td>@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->investing_company}}@else{{'NA'}}@endif</td>
									<td>{{$shareInvestment->user->phone_number}}</td>
									<td>{{$shareInvestment->user->email}}</td>
									<td>
										@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->line_1}},@else{{$shareInvestment->user->line_1}},@endif
										@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->line_2}},@else{{$shareInvestment->user->line_2}},@endif
										@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->city}},@else{{$shareInvestment->user->city}},@endif
										@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->state}},@else{{$shareInvestment->user->state}},@endif
										@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->country}},@else{{$shareInvestment->user->country}},@endif 
										@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->postal_code}}@else{{$shareInvestment->user->postal_code}}@endif

									</td>
									<td>{{$shareInvestment->amount}}</td>
									<td>
										@if($shareInvestment->is_repurchased)
										<strong>Investment is repurchased</strong>
										@else
										@if($shareInvestment->is_cancelled)
-										<strong>Investment record is cancelled</strong>
-										@else
											<a href="{{route('user.view.share', [base64_encode($shareInvestment->id)])}}" target="_blank">
												Share Certificate
											</a>
										@endif
										@endif
									</td>
									<td>
										@if($shareInvestment->investingJoint){{$shareInvestment->investingJoint->tfn}} @else{{$shareInvestment->user->tfn}} @endif
									</td>
									<td>{{-- @if($shareInvestment->userInvestmentDoc) <a href="{{$shareInvestment->userInvestmentDoc->path}}"> {{$shareInvestment->userInvestmentDoc->type}} @else NA @endif</a> --}}</td>
									<td>@if($shareInvestment->investingJoint) {{$shareInvestment->investingJoint->account_name}} @else {{$shareInvestment->user->account_name}} @endif</td>
									<td>@if($shareInvestment->investingJoint) {{$shareInvestment->investingJoint->bsb}} @else {{$shareInvestment->user->bsb}} @endif</td>
									<td>@if($shareInvestment->investingJoint) {{$shareInvestment->investingJoint->account_number}} @else {{$shareInvestment->user->account_number}} @endif</td>
									<td>
										@if($shareInvestment->is_repurchased)
										<strong>Repurchased</strong>
										@else
										@if($shareInvestment->is_cancelled)
										<strong>Cancelled</strong>
										@else
										<a href="{{route('dashboard.investment.cancel', [$shareInvestment->id])}}" class="cancel-investment">cancel</a>
										@endif
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>

				<div id="transactions_tab" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
					<div>
						<table class="table table-bordered table-striped" id="transactionTable">
							<thead>
								<tr>
									<th>Investor Name</th>
									<th>Project SPV Name</th>
									<th>Transaction type</th>
									<th>Date</th>
									<th>Amount($)</th>
									<th>Rate</th>
									<th>Number of shares</th>
								</tr>
							</thead>
							<tbody>
								@foreach($transactions as $transaction)
								<tr>
									<td>{{$transaction->user->first_name}} {{$transaction->user->last_name}}</td>
									<td>@if($transaction->project->projectspvdetail){{$transaction->project->projectspvdetail->spv_name}}@endif</td>
									<td class="text-center">{{$transaction->transaction_type}}</td>
									<td>{{date('m-d-Y', strtotime($transaction->transaction_date))}}</td>
									<td>{{$transaction->amount}}</td>
									<td>{{$transaction->rate}}</td>
									<td>{{$transaction->number_of_shares}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div id="positions_tab" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
					<div>
						@if(!$positions->isempty())
						<p class="text-center"><b>Effective Date:</b> {{date('m-d-Y', strtotime($positions->first()->first()->effective_date))}}</p>
						<p class="text-center"><a href="{{route('dashboard.investment.statement.send', [$project->id])}}" class="btn btn-primary" id="confirm_and_send_btn">CONFIRM AND SEND</a></p>
						@endif
						<table class="table table-bordered table-striped" id="positionTable">
							<thead>
								<tr>
									<th>Investor Name</th>
									<th>Project SPV Name</th>
									<th>Number of Shares</th>
									<th>Current Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach($positions as $userId=>$position)
								<tr>
									<td>{{$position->first()->user->first_name}} {{$position->first()->user->last_name}}</td>
									<td>@if($position->first()->project->projectspvdetail){{$position->first()->project->projectspvdetail->spv_name}}@endif</td>
									<td>{{$position->first()->number_of_shares}}</td>
									<td>{{$position->first()->current_value}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
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
				$('.loader-overlay').show();
			} else {
				e.preventDefault();
			}			
		});

		$('.money-received-btn').click(function(e){
			if (confirm('Are you sure ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
		});

		$('.send-investment-reminder').click(function(e){
			if (confirm('Are you sure ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
		});

		$('.cancel-investment').click(function(e){
			if (confirm('Are you sure ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
		});

		$('#generate_investor_statement').click(function(e){
			if (confirm('Are you sure ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
		});

		$('#confirm_and_send_btn').click(function(e){
			if (confirm('Are you sure ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
		});

		var shareRegistryTable = $('#shareRegistryTable').DataTable({
			"order": [[5, 'desc'], [0, 'desc']],
			"iDisplayLength": 50,
			"aoColumnDefs": [
			  	{
			     	"bSortable": false,
			     	'aTargets': ['nosort']
			  	}
			]
		});
		var investorsTable = $('#investorsTable').DataTable({
			"order": [[5, 'desc'], [0, 'desc']],
			"iDisplayLength": 25
		});
		var transactionTable = $('#transactionTable').DataTable({
			"order": [[3, 'desc']],
			"iDisplayLength": 25
		});
		var positionTable = $('#positionTable').DataTable({
			"iDisplayLength": 25
		});

		// show select checkbox for share registry
		$('.issue-dividend-btn, .repurchase-shares-btn').click(function(e){
			$('.select-check').removeClass('hide');
			$('.share-registry-actions').addClass('hide');
			if($(this).attr('action') == "dividend"){
				$('.declare-statement').removeClass('hide');
			} else {
				$('.repurcahse-statement').removeClass('hide');
			}

			// Selector deselect all investors
			$('.check-all').change(function(e){
				var investors = [];
				if($(this).is(":checked")){
	                $('.investor-check').prop('checked', true);
	                $('.investor-check').each(function() {
		                investors.push($(this).val());
		            });
	            }
	            else{
	                $('.investor-check').prop('checked', false);
	                investors = [];
	            }
	            $('.investors-list').val(investors.join(','));
	        });

			// Set selected investor ids in a hidden field
			$('.investor-check, .check-all').click(function(e){
	        	var investors = [];
	            $('.investor-check').each(function() {
	                if($(this).is(":checked")){
	                    investors.push($(this).val());
	                }
	            });
	            $('.investors-list').val(investors.join(','));
	        });
			
			// Declare dividend
			declareDividend();
			// repurchase shares
			repurchaseShares();
		});
	});

	// Declare dividend
	function declareDividend(){
		$('.declare-dividend-btn').click(function(e){
			var dividendPercent = $('#dividend_percent').val();
			dividendPercent = dividendPercent.toString();
			var startDate = new Date($('#start_date').val());
			var endDate = new Date ($('#end_date').val());
			var investorsList = $('.investors-list').val();

			if(dividendPercent == '' || startDate == '' || endDate == ''){
				e.preventDefault();
				alert('Before declaration enter dividend percent, start date and end date input fields.');
			}
			else {
				if(investorsList == ''){
					e.preventDefault();
					alert('Please select atleast one share registry record.');
				}
			}
		});
	}

	// repurchase shares
	function repurchaseShares(){
		$('.declare-repurchase-btn').click(function(e){
			var repurchaseRate = $('#repurchase_rate').val();
			repurchaseRate = repurchaseRate.toString();
			var investorsList = $('.investors-list').val();

			if(repurchaseRate == ''){
				e.preventDefault();
				alert('Before declaration please enter repurchase rate.');
			}
			else {
				if(investorsList == ''){
					e.preventDefault();
					alert('Please select atleast one share registry record.');
				}
			}
		});
	}
</script>
@endsection