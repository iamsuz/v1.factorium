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
			@include('dashboard.includes.sidebar', ['active'=>3])
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-12">
					@if (Session::has('message'))
					{!! Session::get('message') !!}
					@endif
					<h3 class="text-center">{{$project->title}}
						{{-- <address class="text-center">
							<small>{{$project->location->line_1}}, {{$project->location->line_2}}, {{$project->location->city}}, {{$project->location->postal_code}},{{$project->location->country}}
							</small>
						</address> --}}
					</h3>
					<p class="text-center"><strong>Project Wallet Address:</strong></p><p class="text-center"><small >{{ $project->wallet_address }}</small></p>
					{{-- @if($balanceAudk)
					<h4 class="text-center">
						@if(isset(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id)) {{App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->token_symbol}}
						@else AUDK
						@endif Balance: {{$balanceAudk->balance}}
					</h4>
					@endif --}}
				</div>
			</div>
			<ul class="nav nav-tabs" style="margin-top: 2em; width: 100%;">
				<li class="active" style="width: 20%;"><a data-toggle="tab" href="#investors_tab" style="padding: 0em 2em"><h3 class="text-center">Applications</h3></a></li>
				<li style="width: 30%;"><a data-toggle="tab" href="#accepted_applications" style="padding: 0em 2em"><h3 class="text-center">Accepted applications</h3></a></li>
				<li style="width: 20%;" class="hide"><a data-toggle="tab" href="#transactions_tab" style="padding: 0em 2em"><h3 class="text-center">Transactions</h3></a></li>
				<li style="width: 30%;" class="hide"><a data-toggle="tab" href="#positions_tab" style="padding: 0em 2em"><h3 class="text-center">Position records</h3></a></li>
				<li class="hide"><a data-toggle="tab" href="#eoi_tab" style="padding: 0em 2em"><h3 class="text-center">EOI (Coming Soon)</h3></a></li>
				<li class="hide"><a data-toggle="tab" href="#expression_of_interest_tab" style="padding: 0em 2em"><h3 class="text-center">Project EOI</h3></a></li>
				<li class="hide"><a data-toggle="tab" href="#share_registry_new_tab" style="padding: 0em 2em"><h3 class="text-center">Share Registry</h3></a></li>
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
								<th>Invoice Asking Amount</th>
								<th>Invoice Amount</th>
								<th>Is Money Received</th>
								<th>@if($project->share_vs_unit)  @else  @endif Receivable</th>
								<th>Send Reminder Email</th>
								<th>Investment Confirmation</th>
								<th>Investor Document</th>
								<th>Joint Investor</th>
								<th>Company or Trust</th>
								@if(!$project->retail_vs_wholesale)<th>Wholesale Investment</th>@endif
								<th>Application Form</th>
								{{-- <th>Interested to Buy</th> --}}
							</tr>
						</thead>
						<tbody>
							@foreach($investments as $investment)
							@if(!$investment->hide_investment)
							<tr id="application{{$investment->id}}"  @if(in_array('1',$investments->pluck('accepted')->toArray()) && App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->audk_default_project_id != $project->id) @if(!$investment->accepted) style="color: #ccc;" @endif  @endif>
								<td>INV{{$investment->id}}
									<a href="{{route('dashboard.application.view', [$investment->id])}}" class="edit-application" style="margin-top: 1.2em;"><br>
										<i class="fa fa-edit" aria-hidden="true"></i>
									</a>
									@if(!$investment->money_received && !$investment->accepted)
												{{-- <form action="{{route('dashboard.investment.hideInvestment', $investment->id)}}" method="POST">
												{{method_field('PATCH')}}
												{{csrf_field()}} --}}
												{{-- <a class="send-app-form-link" href="javascript:void(0);" data="{{$projectsEoi->id}}" onclick="sendEOIAppFormLink()"><b>Resend link</b></a> --}}
												<a href="javascript:void(0);" class="hide-investment" data="{{$investment->id}}"><br>
													<i class="fa fa-trash" aria-hidden="true"></i>
												</a>
												@endif
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
														<form action="{{route('dashboard.investment.update', [$investment->id])}}" method="POST">
															{{method_field('PATCH')}}
															{{csrf_field()}}
															<a href="#edit" class="edit">${{number_format($investment->amount,2) }}</a>

															<input type="text" class="edit-input form-control" name="amount" id="amount" value="{{$investment->amount}}" style="width: 100px;">
															<input type="hidden" name="investor" value="{{$investment->user->id}}">
														</form>
													</div>
												</td>
												<td>
													<div class="col-md-1">
														{{-- <a href="#invoice_amount">${{number_format($investment->amount) }}</a> --}}
														<div href="#invoice_amount">@if($project->investment)${{number_format($project->investment->total_projected_costs,2)}} @else Not Specified @endif</div>
													</div>
												</td>
												<td>
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
												</td>
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
															<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">Receivable issued</small></i>
															@else
															{{-- <input type="submit" name="accepted" class="btn btn-primary issue-share-certi-btn" value="Issue @if($project->share_vs_unit)  @else  @endif Receivable"> --}}
															<button type="button" name="accepted" id="issue_receivable{{$investment->id}}" data="{{$investment->id}}" class="btn btn-primary issue-share-certi-btn">Issue Receivable</button>
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
															<i class="fa fa-check" aria-hidden="true" style="color: #6db980;">&nbsp;<br><small style=" font-family: SourceSansPro-Regular;">@if($project->share_vs_unit)  @else  @endif Receivable issued</small></i>
															@else
															{{-- <input type="submit" name="accepted" class="btn btn-primary issue-share-certi-btn" value="Issue @if($project->share_vs_unit)  @else  @endif Receivable"> --}}
															<button type="button" name="accepted" id="issue_receivable{{$investment->id}}" data="{{$investment->id}}" class="btn btn-primary issue-share-certi-btn">Issue Receivable</button>
															@endif
															{{-- <input type="hidden" name="investor" value="{{$investment->user->id}}"> --}}
														</form>
														@endif
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
												@if(!$project->retail_vs_wholesale)
												<td>@if($investment->wholesaleInvestment)<a href="#" data-toggle="modal" data-target="#trigger{{$investment->wholesaleInvestment->investment_investor_id}}">Investment Info</a> @else NA @endif</td>
												@endif
												<td>
													<a href="{{route('user.view.application', [base64_encode($investment->id)])}}" target="_blank">
														View Application Form
													</a>
												</td>
												{{-- <td>
													@if($investment->interested_to_buy) Yes @else No @endif
												</td> --}}
											</tr>

											<!-- Modal for wholesale investments-->
											@if($investment->wholesaleInvestment)
											<div class="modal fade" id="trigger{{$investment->wholesaleInvestment->investment_investor_id}}" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h3 class="modal-title text-center">Wholesale Investment Info</h3>
														</div>
														<div class="modal-body row" style="margin: 1px;">
															<div class="col-md-12">
																<label class="form-label"><h4>Which option closely describes you?</h4></label>
																@if($investment->wholesaleInvestment->wholesale_investing_as == 'Wholesale Investor (Net Asset $2,500,000 plus)')
																<textarea class="form-control" disabled="" style="cursor: default;">I have net assets of at least $2,500,000 or a gross income for each of the last 2 financial investors of at lease $2,50,000 a year.</textarea><br />
																<h4>Accountant's details:</h4><hr>
																<label for="asd" class="form-label"><b>Name and firm of qualified accountant</b></label>
																<input type="text" name="accountant_name_firm_txt" id="asd" class="form-control" value="@if($investment->wholesaleInvestment->accountant_name_and_firm){{$investment->wholesaleInvestment->accountant_name_and_firm}} @else No user input @endif" disabled="" style="cursor: default;"><br />
																<label for="asda" class="form-label"><b>Qualified accountant's professional body and membership designation</b></label>
																<input type="text" name="accountant_designation_txt" id="asda" class="form-control" value="@if($investment->wholesaleInvestment->accountant_professional_body_designation){{$investment->wholesaleInvestment->accountant_professional_body_designation}} @else No user input @endif" disabled="" style="cursor: default;"><br />
																<label for="asds" class="form-label"><b>Email</b></label>
																<input type="email" name="accountant_email_txt" id="asds" class="form-control" value="@if($investment->wholesaleInvestment->accountant_email){{$investment->wholesaleInvestment->accountant_email}} @else No user input @endif" disabled="" style="cursor: default;"><br />
																<label for="asdd" class="form-label"><b>Phone</b></label>
																@if($investment->wholesaleInvestment->accountant_phone)
																<input type="number" name="accountant_phone_txt" id="asdd" class="form-control" value="{{$investment->wholesaleInvestment->accountant_phone}}" disabled="" style="cursor: default;"><br />
																@else
																<input type="text" name="accountant_phone_txt" id="asdd" class="form-control" value="No user input" disabled="" style="cursor: default;"><br />
																@endif
																@elseif($investment->wholesaleInvestment->wholesale_investing_as == 'Sophisticated Investor')
																<textarea rows="3" type="text" class="form-control" disabled="" style="cursor: default;">I have experience as to: the merits of the offer; the value of the securities; the risk involved in accepting the offer; my own information needs; the adequacy of the information provided.</textarea><br />
																<h4>Experienced Investor Information:</h4><hr>
																<label for="asd" class="form-label"><b>Equity investment experience:</b></label>
																<textarea rows="4" id="asd" class="form-control" disabled="" style="cursor: default;">@if($investment->wholesaleInvestment->equity_investment_experience_text){{$investment->wholesaleInvestment->equity_investment_experience_text}} @else No user input @endif</textarea> <br />
																<label for="qwe" class="form-label"><b>How much investment experience do you have?</b></label>
																<input type="text" id="qwe" class="form-control" value="@if($investment->wholesaleInvestment->experience_period){{$investment->wholesaleInvestment->experience_period}} @else No user input @endif" disabled="" style="cursor: default;"><br />
																<label for="fgh" class="form-label"><b>What experience do you have with unlisted invesments ?</b></label>
																<textarea rows="4" id="fgh" class="form-control" disabled="" style="cursor: default;">@if($investment->wholesaleInvestment->unlisted_investment_experience_text){{$investment->wholesaleInvestment->unlisted_investment_experience_text}} @else No user input @endif</textarea> <br />
																<label for="zxc" class="form-label" style="cursor: default;"><b>Do you clearly understand the risks of investing with this offer ?</b></label>
																<textarea rows="4" id="zxc" class="form-control" disabled="" style="cursor: default;">@if($investment->wholesaleInvestment->understand_risk_text){{$investment->wholesaleInvestment->understand_risk_text}} @else No user input @endif</textarea> <br />
																@elseif($investment->wholesaleInvestment->wholesale_investing_as == 'Inexperienced Investor')
																<input type="text" class="form-control" value="I have no experience in property, securities or similar" disabled="" style="cursor: default;"><br />
																@else
																<input type="text" class="form-control" value="No user input" disabled="" style="cursor: default;"><br />
																@endif
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>

												</div>
											</div>
											@endif

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
								@endif
								@endforeach
							</tbody>
						</table>
					</div>

					<div id="accepted_applications" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
						<!-- <ul class="list-group">Hello</ul> -->
						<div class="share-registry-actions">
							<button class="btn btn-primary issue-dividend-btn hide" action="dividend">Issue Dividend Annualized</button>
							<button class="btn btn-primary issue-fixed-dividend-btn hide" action="fixed-dividend" style="margin: 0 1rem;">Issue Fixed Dividend</button>
						</div>
						<form id="declare_dividend_form" action="{{route('dashboard.investment.declareDividend', [$project->id])}}" method="POST">
							{{csrf_field()}}
							<span class="declare-statement hide"><small>Issue Dividend at <input type="number" name="dividend_percent" id="dividend_percent" step="0.01">% annual for the duration of between <input type="text" name="start_date" id="start_date" class="datepicker" placeholder="DD/MM/YYYY" readonly="readonly"> and <input type="text" name="end_date" id="end_date" class="datepicker" placeholder="DD/MM/YYYY" readonly="readonly"> : <input type="submit" class="btn btn-primary declare-dividend-btn" value="Declare"></small></span>
							<input type="hidden" class="investors-list" id="investors_list" name="investors_list">
						</form>
						<form action="{{route('dashboard.investment.declareFixedDividend', [$project->id])}}" method="POST">
							{{csrf_field()}}
							<span class="declare-fixed-statement hide"><small>Issue Dividend at <input type="number" name="fixed_dividend_percent" id="fixed_dividend_percent" step="0.01"> %  <input type="submit" class="btn btn-primary declare-fixed-dividend-btn" value="Declare"></small></span>
							<input type="hidden" class="investors-list" id="investors_list" name="investors_list">
						</form>
						<form action="{{route('dashboard.investment.declareRepurchase', [$project->id])}}" method="POST">
							{{csrf_field()}}
							<span class="repurchase-statement hide"><small>Repurchase @if($project->share_vs_unit) shares @else units @endif at $<input type="number" name="repurchase_rate" id="repurchase_rate" value="1" step="0.01"> per @if($project->share_vs_unit) share @else unit @endif: <input type="submit" class="btn btn-primary declare-repurchase-btn" value="Declare"></small></span>
							<input type="hidden" class="investors-list" id="investors_list" name="investors_list">
						</form>
						<form action="{{route('dashboard.investment.statement', [$project->id])}}" method="POST" class="text-right ">
							{{csrf_field()}}
							<button type="submit" class="btn btn-default hide" id="generate_investor_statement"><b>Generate Investor Statement</b></button>
						</form>
						<br><br>
						<div class="">
							<table class="table table-bordered table-striped" id="shareRegistryTable">
								<thead>
									<tr>
										<th class="select-check hide nosort"><input type="checkbox" class="check-all" name=""></th>
										<th>Unique ID</th>
										{{-- <th>@if($project->share_vs_unit) Share @else Unit @endif numbers</th> --}}
										<th>Invoice name</th>
										<th>Investor Name</th>
										<th>Investment type</th>
										<th>Joint Investor Name</th>
										<th>Entity details</th>
										<th>Phone</th>
										<th>Email</th>
										<th>Address</th>
										<th>@if($project->share_vs_unit) Invoice @else Unit @endif asking amount</th>
										<th>@if($project->share_vs_unit) Invoice @else unit @endif amount</th>
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
									<tr @if($shareInvestment->is_cancelled || $shareInvestment->partial_repay_percentage == '100') style="color: #CCC;" @endif>
										<td class="text-center select-check hide">

											@if(!$shareInvestment->is_cancelled) <input type="checkbox" class="investor-check" name="" value="{{$shareInvestment->id}}"> @endif</td>
											<td>INV{{$shareInvestment->id}}</td>
											{{-- <td>@if($shareInvestment->share_number){{$shareInvestment->share_number}}@else{{'NA'}}@endif</td> --}}
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
											<td class="text-center">${{$shareInvestment->amount}}</td>
											<td class="text-center">
												@if($shareInvestment->is_repurchased)
												<strong>Investment is repurchased</strong>
												@else
												@if($shareInvestment->is_cancelled)
												<strong>Investment record is cancelled</strong>
												@else
												@if($project->share_vs_unit)
												${{ $shareInvestment->investment->total_projected_costs }}
												{{-- <a href="{{route('user.view.share', [base64_encode($shareInvestment->id)])}}" target="_blank">
													Share Certificate
												</a> --}}
												@else
												<a href="{{route('user.view.unit', [base64_encode($shareInvestment->id)])}}" target="_blank">
													Unit Certificate
												</a>
												@endif
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
											<td class="text-center">
												@if($shareInvestment->is_repurchased || $shareInvestment->partial_repay_percentage == '100')
												<strong>Repurchased</strong>
												@else
												@if($shareInvestment->is_cancelled)
												<strong>Cancelled</strong>
												@else
												<a href="{{route('dashboard.investment.cancel', [$shareInvestment->id])}}" class="cancel-investment">cancel</a><br><br>
												<span data-id="{{$shareInvestment->id}}" class="hidden repaySpanForId"></span>
												<button class="btn btn-primary" @if($shareInvestment->is_partial_repay) disabled="disabled" @else  action="repurchase" data-toggle="modal" data-target="#repayModal" id="repayBtn" data-id="{{$shareInvestment->id}}"  @endif>Repay</button><br><br>
												<button class="btn btn-primary" data-toggle="modal" data-target="#partialRepayModal" id="partialRepayBtn" data-id="{{$shareInvestment->id}}" data-max="{{ $shareInvestment->partial_repay_percentage }}">Partial Repay</button>
												@endif
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>

						</div>
						<div id="share_registry_tab" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
							<!-- <ul class="list-group">Hello</ul> -->
							<br><br>
							<div class="">
								<table class="table table-bordered table-striped" id="shareRegistryTable">
									<thead>
										<tr>
											<th class="select-check hide nosort"><input type="checkbox" class="check-all" name=""></th>
											{{-- <th>Unique ID</th> --}}
											{{-- <th>@if($project->share_vs_unit) Share @else Unit @endif numbers</th> --}}
											<th>Project SPV Name</th>
											<th>Investor Name</th>
											<th>Investment type</th>
											<th>Joint Investor Name</th>
											<th>Entity details</th>
											<th>Phone</th>
											<th>Email</th>
											<th>Address</th>
											<th>@if($project->share_vs_unit) Share @else Unit @endif face value</th>
											<th>Link to @if($project->share_vs_unit) share @else unit @endif certificate</th>
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
											{{-- <td class="text-center select-check hide">@if(!$shareInvestment->is_cancelled) <input type="checkbox" class="investor-check" name="" value="{{$shareInvestment->id}}"> @endif</td> --}}
											{{-- <td>INV{{$shareInvestment->id}}</td> --}}
											{{-- <td>@if($shareInvestment->share_number){{$shareInvestment->share_number}}@else{{'NA'}}@endif</td> --}}
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
												<strong>Investment record is cancelled</strong>
												@else
												@if($project->share_vs_unit)
												<a href="{{route('user.view.share', [base64_encode($shareInvestment->id)])}}" target="_blank">
													Share Certificate
												</a>
												@else
												<a href="{{route('user.view.unit', [base64_encode($shareInvestment->id)])}}" target="_blank">
													Unit Certificate
												</a>
												@endif
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
								<table class="table table-bordered table-striped text-center" id="transactionTable">
									<thead>
										<tr>
											<th>Investor Name</th>
											<th>Project SPV Name</th>
											<th>Transaction type</th>
											<th>Date</th>
											<th>Amount</th>
											<th>Rate</th>
											<th>Number of @if($project->share_vs_unit) shares @else units @endif</th>
										</tr>
									</thead>
									<tbody>
										@foreach($transactions as $transaction)
										{{-- cpunt {{count($transaction)}} --}}
										{{-- {{ $transaction->sum('number_of_shares') }} --}}
										<tr>
											<td>{{$transaction->first()->user->first_name}} {{$transaction->first()->user->last_name}}</td>
											<td>@if($transaction->first()->project->projectspvdetail){{$transaction->first()->project->projectspvdetail->spv_name}}@endif</td>
											<td class="text-center">@if($transaction->first()->transaction_type == "DIVIDEND") {{"ANNUALIZED DIVIDEND"}} @else {{$transaction->first()->transaction_type}} @endif</td>
											<td>{{date('m-d-Y', strtotime($transaction->first()->transaction_date))}}</td>
											<td>${{ $transaction->sum('amount') }}</td>
											<td>{{$transaction->first()->rate}}</td>
											<td>{{ $transaction->sum('number_of_shares') }}</td>
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
											<th>Number of @if($project->share_vs_unit) shares @else units @endif</th>
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
						<div id="eoi_tab" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
							<div>
								<table class="table table-bordered table-striped" id="eoiTable">
									<thead>
										<tr>
											<th>User Email</th>
											<th>User Phone Number</th>
											<th>EOI Timestamp</th>
										</tr>
									</thead>
									<tbody>
										@foreach($projectsInterests as $projectsInterest)
										<tr>
											<td>{{$projectsInterest->email}}</td>
											<td>{{$projectsInterest->phone_number}}</td>
											<td>{{date('Y-m-d h:m:s', strtotime($projectsInterest->created_at))}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div id="expression_of_interest_tab" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
							<div>
								<table class="table table-bordered table-striped" id="expression_of_interest_table">
									<thead>
										<tr>
											<th class="text-center">User Name</th>
											<th>Application Link</th>
											<th>Offer Document</th>
											<th class="text-center">User Email</th>
											<th class="text-center">User Phone Number</th>
											<th class="text-center">Amount</th>
											<th class="text-center">Investment Expected</th>
											<th class="text-center">EOI Timestamp</th>
											<th>Interested to buy</th>
										</tr>
									</thead>
									<tbody class="text-center">
										@foreach($projectsEois as $projectsEoi)
										<tr>
											<td>{{$projectsEoi->user_name}}</td>
											<td id="offer_link{{$projectsEoi->id}}">
												@if($projectsEoi->offer_doc_path)
												@if($projectsEoi->is_link_sent)
												<a class="send-app-form-link" id="send_link{{$projectsEoi->id}}" href="javascript:void(0);" data="{{$projectsEoi->id}}"{{--  onclick="sendEOIAppFormLink()" --}}><b>Resend link</b></a>
												@else
												<a class="send-app-form-link" id="send_link{{$projectsEoi->id}}" href="javascript:void(0);" data="{{$projectsEoi->id}}"{{--  onclick="sendEOIAppFormLink()" --}}><b>Send link</b></a>
												@endif
												@else
												<span class="text-danger"><small><small>Offer document must be uploaded before accepting the EOI request</small></small></span>
												@endif
											</td>
											<td>
												@if($projectsEoi->offer_doc_path)
												<a href="{{$projectsEoi->offer_doc_path}}" id="uploaded_offer_doc_link{{$projectsEoi->id}}" target="_blank" download>
													{{$projectsEoi->offer_doc_name}}
												</a>
												@endif
												<div id="new_offer_doc_link{{$projectsEoi->id}}"></div>
												<form{{--  action="{{route('dashboard.upload.offerDoc')}}" --}} class="upload_form" id="upload_form" rel="form" method="POST" enctype="multipart/form-data">
												{!! csrf_field() !!}
												<input type="file" name="offer_doc" id="offer_doc" required="required">
												{!! $errors->first('offer_doc', '<small class="text-danger">:message</small>') !!}
												<input type="hidden" name="eoi_id" value="{{$projectsEoi->id}}">
												<input type="submit" name="upload_offer_doc" id="upload_offer_doc" value="Upload" class="btn btn-primary upload-offer-doc upload_offer_doc" data="{{$projectsEoi->id}}">
											</form>
										</td>
										<td>{{$projectsEoi->user_email}}</td>
										<td>{{$projectsEoi->phone_number}}</td>
										<td>${{number_format($projectsEoi->investment_amount,2)}}</td>
										<td>{{$projectsEoi->invesment_period}}</td>
										<td>{{date('Y-m-d h:m:s', strtotime($projectsEoi->created_at))}}</td>
										<td>
											@if($projectsEoi->interested_to_buy) Yes @else No @endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>

					<div id="share_registry_new_tab" class="tab-pane fade" style="margin-top: 2em;overflow: auto;">
						<div>
							<div>
								<i><strong>Records last updated on:</strong> @if($investorTokensJobDetails){{$investorTokensJobDetails->created_at}}@endif</i>
							</div>
							<br>
							<table class="table table-bordered table-striped" id="newShareRegistryTable">
								<thead>
									<tr>
										<th>Investor Name</th>
										<th>Share Certificate</th>
										<th>Email</th>
										<th>Project SPV Name</th>
										<th>Token Balance</th>
									</tr>
								</thead>
								<tbody>
									@foreach($investorTokens as $investorRecord)
									<tr>
										<td>{{$investorRecord->user->first_name}} {{$investorRecord->user->last_name}}</td>
										<td>
											@if($project->share_vs_unit)
											<a href="{{route('admin.view.share', [base64_encode($investorRecord->id)])}}" target="_blank">
												Share Certificate
											</a>
											@else
											<a href="{{route('admin.view.unit', [base64_encode($investorRecord->id)])}}" target="_blank">
												Unit Certificate
											</a>
											@endif
										</td>
										<td>{{$investorRecord->user->email}}</td>
										<td>@if($investorRecord->project->projectspvdetail){{$investorRecord->project->projectspvdetail->spv_name}}@endif</td>
										<td>{{$investorRecord->tokens}} {{$investorRecord->symbol}}</td>
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
	@include('dashboard.includes.repayModal')
	@include('dashboard.includes.partialRepayModal')

	<!--Dividend confirm Modal -->
	<div id="dividend_confirm_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">CONFIRM DIVIDEND</h4>
				</div>
				<div class="modal-body" style="padding: 15px 30px;">
					<p class="text-center">
						<i><small>** Please check and confirm the below dividend details.</small></i>
					</p><br>
					<div class="text-center">
						<h2>{{$project->title}}</h2>
						<small>{{$project->location->line_1}}, {{$project->location->line_2}}, {{$project->location->city}}, {{$project->location->postal_code}},{{$project->location->country}}</small>
					</div><br>
					<table class="table-striped dividend-confirm-table" border="0" cellpadding="10">
						<tbody>
							<tr>
								<td><b>Dividend Rate: </b></td>
								<td><small><span id="modal_dividend_rate"></span>%</small></td>
							</tr>
							<tr>
								<td><b>Start Date <small>(DD/MM/YYYY)</small>: </b></td>
								<td><small><span id="modal_dividend_start_date"></span></small></td>
							</tr>
							<tr>
								<td>End Date <small>(DD/MM/YYYY)</small>:</td>
								<td><small><span id="modal_dividend_end_date"></span></small></td>
							</tr>
						</tbody>
					</table>
					<br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="submit_dividend_confirmation">Confirm</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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

			// $('.issue-share-certi-btn').click(function(e){
			// 	if (confirm('Are you sure ?')) {
			// 		console.log('confirmed');
			// 		$('.loader-overlay').show();
			// 	} else {
			// 		e.preventDefault();
			// 	}
			// });

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
			"order": [[5, 'desc'], [0, 'desc']],
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
			// else {
			// 	// $('#modal_dividend_rate').html(dividendPercent);
			// 	// $('#modal_dividend_start_date').html($('#start_date').val());
			// 	// $('#modal_dividend_end_date').html($('#end_date').val());

			// 	$('#partial_repay_confirm_modal').modal({
			// 		keyboard: false,
			// 		backdrop: 'static'
			// 	});
			// }
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

	{{--

	function sendEOIAppFormLink(){
	$('#expression_of_interest_tab').on('click', '.send-app-form-link', function(e){
		e.preventDefault();
		var project_id = {{$project->id}};
		var eoi_id = $(this).attr('data');
		if (confirm('Are you sure you want to delete this?')) {
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

	--}}
	// }

</script>
@endsection
