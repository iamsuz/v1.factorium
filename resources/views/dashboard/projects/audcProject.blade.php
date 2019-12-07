@extends('layouts.main')
@section('title-section')
{{$project->title}} | Dashboard | @parent
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
			@include('dashboard.includes.sidebar', ['active'=>13])
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
				<table class="table table-bordered table-striped" id="investorsTable" style="margin-top: 2em;">
					<thead>
						<tr>
							<th>User Id</th>
							<th>Investors Details</th>
							<th>Purchase Date</th>
							<th>Amount</th>
							{{-- <th>Is Money Received</th> --}}
							<th>Issue Audc</th>
							<th>Transaction Id</th>
							<th>User Wallet</th>
							{{-- <th class="hide">Send Reminder Email</th> --}}
							{{-- <th>Investment Confirmation</th> --}}
							{{-- <th>Investor Document</th> --}}
							{{-- <th>Joint Investor</th> --}}
							{{-- <th>Company or Trust</th> --}}
							@if(!$project->retail_vs_wholesale)<th>Wholesale Investment</th>@endif
							{{-- <th>Application Form</th> --}}
						</tr>
					</thead>
					<tbody>
						@foreach($investments as $investment)
						@if(!$investment->hide_investment)
						<tr id="application{{$investment->id}}"  @if(in_array('1',$investments->pluck('accepted')->toArray()) && App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id != $project->id) @if(!$investment->accepted) style="color: #ccc;" @endif  @endif>
							<td>{{ $investment->user->id}}</td>
							<td>
								<div class="col-md-3 text-left">
									<a href="{{route('dashboard.users.show', [$investment->user_id])}}" >
										<b>{{$investment->user->first_name}} {{$investment->user->last_name}}</b>
									</a>
									<br>{{$investment->user->email}}<br>{{$investment->user->phone_number}}
								</div>
							</td>
							<td>
								<div class="col-md-2 text-right">
									<span class="hide">{{$investment->created_at}}</span>{{$investment->created_at->toFormattedDateString()}}
								</div>
							</td>
							<td>
								<div class="col-md-1">
									<form action="{{route('dashboard.investment.update', [$investment->id])}}" method="POST">
										{{method_field('PATCH')}}
										{{csrf_field()}}
										<a href="#edit" class="edit">${{number_format($investment->amount,2) }}</a>

										<input type="text" class="edit-input form-control" name="amount" id="amount" value="{{$investment->amount}}" style="width: 100px;">
										<input type="hidden" name="investor" value="{{$investment->user->id}}">
									</form>
								</div>
							</td>
							{{-- <td>
								<div class="col-md-2">
									@if(in_array('1',$investments->pluck('accepted')->toArray()) && App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id != $project->id)
									@if(!$investment->accepted)
									<i class="fa fa-times" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;"> Other Investment has been accepted</small></i>
									@else
									<form action="{{route('dashboard.investment.moneyReceived', $investment->id)}}" method="POST">
										{{method_field('PATCH')}}
										{{csrf_field()}}
										@if($investment->money_received || $investment->accepted)
										<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Money Received</small></i>
										@else
										<input type="submit" name="money_received" id="money_received_{{$investment->id}}" class="btn btn-primary money-received-btn" value="Money Received">
										@endif
									</form>
									@endif
									@else
									<form action="{{route('dashboard.investment.moneyReceived', $investment->id)}}" method="POST">
										{{method_field('PATCH')}}
										{{csrf_field()}}
										@if($investment->money_received || $investment->accepted )
										<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Money Received</small></i>
										@else
										<input type="submit" name="money_received" id="money_received_{{$investment->id}}" class="btn btn-primary money-received-btn" value="Money Received">
										@endif
									</form>
									@endif
								</div>
							</td> --}}
							<td>
								<div class="col-md-2">
									@if(in_array('1',$investments->pluck('accepted')->toArray()) && App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id != $project->id)
									@if(!$investment->accepted)
									<i class="fa fa-times" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;"> Other Investment has been accepted</small></i>
									@else
									<form action="{{route('dashboard.investment.accept', $investment->id)}}" method="POST">
										{{method_field('PATCH')}}
										{{csrf_field()}}

										{{-- <input type="checkbox" name="accepted" onChange="this.form.submit()" value={{$investment->accepted ? 0 : 1}} {{$investment->accepted ? 'checked' : '' }}> Money {{$investment->accepted ? 'Received' : 'Not Received' }} --}}
										@if($investment->accepted)
										<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">AUDC issued</small></i>
										@else
										{{-- <input type="submit" name="accepted" class="btn btn-primary issue-share-certi-btn" value="Issue @if($project->share_vs_unit)  @else  @endif Receivable"> --}}
										<button type="button" name="accepted" id="issue_receivable{{$investment->id}}" data="{{$investment->id}}" class="btn btn-primary issue-share-certi-btn">Issue AUDC</button>
										@endif
										<input type="hidden" name="investor" value="{{$investment->user->id}}">
									</form>
									@endif
									@else
									<form action="{{route('dashboard.investment.accept', $investment->id)}}" method="POST">
										{{method_field('PATCH')}}
										{{csrf_field()}}
										{{-- <input type="checkbox" name="accepted" onChange="this.form.submit()" value={{$investment->accepted ? 0 : 1}} {{$investment->accepted ? 'checked' : '' }}> Money {{$investment->accepted ? 'Received' : 'Not Received' }} --}}
										@if($investment->accepted)
										<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">@if($project->share_vs_unit)  @else  @endif AUDCs issued</small></i>
										@else
										{{-- <input type="submit" name="accepted" class="btn btn-primary issue-share-certi-btn" value="Issue @if($project->share_vs_unit)  @else  @endif Receivable"> --}}
										<button type="button" name="accepted" id="issue_receivable{{$investment->id}}" data="{{$investment->id}}" class="btn btn-primary issue-share-certi-btn">Issue AUDC</button>
										@endif
										{{-- <input type="hidden" name="investor" value="{{$investment->user->id}}"> --}}
									</form>
									@endif
								</div>
							</td>
							<td>
								INV{{$investment->id}}
								<a href="{{route('dashboard.application.view', [$investment->id])}}" class="edit-application" style="margin-top: 1.2em;"><br>
									<i class="fa fa-edit" aria-hidden="true"></i>
								</a>
								@if(!$investment->money_received && !$investment->accepted)
								<a href="javascript:void(0);" class="hide-investment" data="{{$investment->id}}"><br>
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
								@endif
							</td>
							<td>{{ $investment->user->wallet_address }}</td>
							{{-- <td class="hide">
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
							</td> --}}
							{{-- <td>
								@if(in_array('1',$investments->pluck('accepted')->toArray()) && App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id != $project->id)
								@if(!$investment->accepted)
								<i class="fa fa-times" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;"> Other Investment has been accepted</small></i>
								@else
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
								@endif
								@endif
							</td> --}}
							{{-- <td>
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
							</td> --}}
							{{-- <td>
								@if($investment->userInvestmentDoc)
								@if($investment->userInvestmentDoc->where('type','joint_investor')->last())
								<a href="/{{$investment->userInvestmentDoc->where('type','joint_investor')->last()->path}}" target="_blank">{{$investment->investingJoint->joint_investor_first_name}} {{$investment->investingJoint->joint_investor_last_name}} Doc</a>
								<br>
								@else
								NA
								@endif
								@endif
							</td> --}}
							{{-- <td>
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
							</td> --}}
							@if(!$project->retail_vs_wholesale)
							<td>
								@if($investment->wholesaleInvestment)<a href="#" data-toggle="modal" data-target="#trigger{{$investment->wholesaleInvestment->investment_investor_id}}">Investment Info</a> @else NA @endif
							</td>
							@endif
							{{-- <td>
								<a href="{{route('user.view.application', [base64_encode($investment->id)])}}" target="_blank">
									View Application Form
								</a>
							</td> --}}
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>
			</div>
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
	$(document).ready(function() {
		$('a.edit').click(function () {
			var dad = $(this).parent();
			$(this).hide();
			dad.find('input[type="text"]').show().focus();
		});
		$('.notifyUser').on('click',function (e) {
			e.preventDefault();
			$('.loader-overlay').show();
			$.ajax({
				url:'/dashboard/investment/'+$('.repaySpanForId').attr('data-id')+'/audc/?fixedDividendPercent='+$('.modal_partial_repay_amount').html(),
				type:'GET',
				data:{},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data);
				if(data){
					$('#offer_link').html('<div class="text-success"><i class="fa fa-check"></i> Sent</div>');
					$('.loader-overlay').hide();
					$('#repayModal').modal('hide');
					$('#partialRepayModal').modal('hide');
					$('#partial_repay_confirm_modal').modal('hide');
				}
			});
		})
		$('#repayBtn').on('click',function (e) {
			$('#repayInvestor').val($('#repayBtn').attr('data-id'));
		});
		$('#partialRepayBtn').on('click',function (e) {
			$('#partialInvestor_list').val($('#partialRepayBtn').attr('data-id'));
			var remainPerc = 100 - $('#partialRepayBtn').attr('data-max');
			$('#fixedDividendPercent').attr('max',remainPerc.toString());
		})
		$('input[type=text]').focusout(function() {
			var dad = $(this).parent();
			dad.submit();
		});
		$('.money-received-btn').click(function(e){
			if (confirm('Are you sure ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
			$('.loader-overlay').show();
			$('.overlay-loader-image').after('<div class="text-center alert alert-info"><h3>It may take a while!</h3><p>Please wait... your request is processed. Do not refresh or reload the page.</p><br></div>');
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

			//Partial repay form percent validation and model trigger
			$('#partialRepayModal').on("click", "#partialRepayPercentBtn", function(e){
				var f = document.getElementById('fixedDividendPercent');
				if(f.checkValidity()) {
					var partialRepayRate = $('#fixedDividendPercent').val();
					$("#modal_partial_repay_rate").html(partialRepayRate);
					var repayAmount = ({{$project->investment->total_projected_costs}} * (partialRepayRate/100)).toFixed(2);
					$(".modal_partial_repay_amount").html(repayAmount);
					$('#partialRepayPercentBtn').attr('data-target', '#partial_repay_confirm_modal');
				} else {
					alert(document.getElementById('fixedDividendPercent').validationMessage);
					$('#partialRepayPercentBtn').removeAttr('data-target', '#partial_repay_confirm_modal');
				}
			});

			// Submit Partial Repayment form
			$('#submit_partial_repay_confirmation').on('click', function(e) {
				$('#partialRepayForm').submit();
			});

		//Ajax call for sending eoi application form link to user (for both send link and resend link buttons)
		$('#expression_of_interest_tab').on('click', '.send-app-form-link', function(e){
			e.preventDefault();
			var project_id = {{$project->id}};
			var eoi_id = $(this).attr('data');
			if (confirm('Are you sure?')) {
				$('.loader-overlay').show();
				$.ajax({
					url: '/dashboard/project/interest/link',
					type: 'POST',
					dataType: 'JSON',
					data: {project_id, eoi_id},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				}).done(function(data){
					if(data){
						$('#offer_link'+eoi_id).html('<div class="text-success"><i class="fa fa-check"></i> Sent</div>');
						$('.loader-overlay').hide();
					}
				});
			}
		});

		//Ajax call for sending eoi application form link to user (for both send link and resend link buttons)
		$('#investors_tab').on('click', '.issue-share-certi-btn', function(e){
			e.preventDefault();
			var project_id = {{$project->id}};
			var investment_id = $(this).attr('data');
			// alert(investment_id);
			if (confirm('Are you sure?')) {
				$('.loader-overlay').show();
				$.ajax({
					url: '/dashboard/projects/'+investment_id+'/investments/accept',
					type: 'PATCH',
					dataType: 'JSON',
					data: {project_id, investment_id},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				}).done(function(data){
					if(data){
						$('.loader-overlay').hide();
						$('#issue_receivable'+investment_id).replaceWith('<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Receivable issued</small></i>')
						$('#money_received_'+investment_id).replaceWith('<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Money Received</small></i>')
						$('.issue-share-certi-btn, .money-received-btn').replaceWith('<i class="fa fa-times" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;"> Other Investment has been accepted</small></i>');
					}
				});
			}
		});

		$('.upload_form').submit(function(e){
			e.preventDefault();
			$('.loader-overlay').show();
			var eoi_id, offer_doc_path, offer_doc_name;
			$.ajax({
				url: '/dashboard/project/upload/offerdoc',
				type: 'POST',
				dataType: 'JSON',
				data: new FormData(this),
				processData: false,
				contentType: false,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			}).done(function(data){
				console.log(data.message);
				console.log(data.status);
				console.log(data.eoi_id);
				if(data){
					$('#offer_link'+data.eoi_id).html('<a class="send-app-form-link" id="send_link'+data.eoi_id+'" href="javascript:void(0);" data="'+data.eoi_id+'"><b>Send link</b></a>');
					$('#new_offer_doc_link'+data.eoi_id).html('<a href="'+data.offer_doc_path+'" target="_blank" download> '+data.offer_doc_name+'</a><i class="fa fa-check success-icon"></i>');
					$('#uploaded_offer_doc_link'+data.eoi_id).hide();
					$('.loader-overlay').hide();
					alert(data.message);
				}
				else
				{
					alert('Something went wrong! Please try again.');
					$('.loader-overlay').hide();
				}
			});
		});

		//Hide application from admin dashboard

		$('.hide-investment').on("click", function(e){
			e.preventDefault();
			var investment_id = $(this).attr('data');
			if (confirm('Are you sure you want to delete this?')) {
				$('.loader-overlay').show();
				$.ajax({
					url: '/dashboard/projects/hideInvestment',
					type: 'PATCH',
					dataType: 'JSON',
					data: {investment_id},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
				}).done(function(data){
					if(data){
						$('.loader-overlay').hide();
						$("#investorsTable").DataTable().row( $('#application' + investment_id) ).remove().draw( false );
					}
				});
			}
		});


		var shareRegistryTable = $('#shareRegistryTable').DataTable({
			"order": [[0, 'desc']],
			"iDisplayLength": 50,
			"aoColumnDefs": [
			{
				"bSortable": false,
				'aTargets': ['nosort']
			}
			]
		});
		var newShareRegistryTable = $('#newShareRegistryTable').DataTable({
			"order": [[0, 'asc']],
			"iDisplayLength": 50
		});
		var investorsTable = $('#investorsTable').DataTable({
			"order": [2, 'desc'],
			"iDisplayLength": 25
		});
		var transactionTable = $('#transactionTable').DataTable({
			"order": [[3, 'desc']],
			"iDisplayLength": 25
		});
		var positionTable = $('#positionTable').DataTable({
			"iDisplayLength": 25
		});
		var eoiTable = $('#eoiTable').DataTable({
			"iDisplayLength": 25
		});
		var expression_of_interest_table = $('#expression_of_interest_table').DataTable({
			"iDisplayLength": 25
		});

		// show select checkbox for share registry
		$('.issue-dividend-btn, .repurchase-shares-btn, .issue-fixed-dividend-btn').click(function(e){
			// $('.select-check').removeClass('hide');
			// $('.share-registry-actions').addClass('hide');
			if($(this).attr('action') == "dividend"){
				$('.declare-statement').removeClass('hide');
			}else if($(this).attr('action') == "fixed-dividend"){
				$('.declare-fixed-statement').removeClass('hide');
			} else {
				$('.repurchase-statement').removeClass('hide');
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
			// Declare fixed dividend
			declareFixedDividend();
			// repurchase shares
			repurchaseShares();
		});

		// Submit dividend form
		$('#submit_dividend_confirmation').on('click', function(e) {
			$('#declare_dividend_form').submit();
		});

		// Apply date picker to html elements to select date
		$( ".datepicker" ).datepicker({
			'dateFormat': 'dd/mm/yy'
		});
        //sendEOIAppFormLink();
    });

	// Declare dividend
	function declareDividend(){
		$('.declare-dividend-btn').click(function(e){
			e.preventDefault();
			var dividendPercent = $('#dividend_percent').val();
			dividendPercent = dividendPercent.toString();
			var startDate = new Date($('#start_date').val());
			var endDate = new Date ($('#end_date').val());
			var investorsList = $('.investors-list').val();

			if(dividendPercent == '' || startDate == '' || endDate == ''){
				alert('Before declaration enter dividend percent, start date and end date input fields.');
			}
			else if(investorsList == ''){
				alert('Please select atleast one @if($project->share_vs_unit) share @else unit @endif registry record.');
			}
			else {
				$('#modal_dividend_rate').html(dividendPercent);
				$('#modal_dividend_start_date').html($('#start_date').val());
				$('#modal_dividend_end_date').html($('#end_date').val());

				$('#dividend_confirm_modal').modal({
					keyboard: false,
					backdrop: 'static'
				});


			}
		});
	}

	// Declare fixed dividend
	function declareFixedDividend(){
		$('.declare-fixed-dividend-btn').click(function(e){
			var dividendPercent = $('#fixed_dividend_percent').val();
			dividendPercent = dividendPercent.toString();
			var investorsList = $('.investors-list').val();

			if(dividendPercent == ''){
				e.preventDefault();
				alert('Before declaration please enter dividend percent.');
			}
			else {
				if(investorsList == ''){
					e.preventDefault();
					alert('Please select atleast one @if($project->share_vs_unit) share @else unit @endif registry record.');
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
					alert('Please select atleast one @if($project->share_vs_unit) share @else unit @endif registry record.');
				}
			}
		});
	}

</script>
@endsection
