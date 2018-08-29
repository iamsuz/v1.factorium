@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>10])
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
						<hr>
						<dt></dt>
						<dd><h4>Please upload your verified id documents so that we have them on record <br>as part of our KYC AML CTF obligations when you do an investment.</h4></dd><br>
						<dt></dt>
						<dd>
							@if($user->idDoc)
							<h4>You are Investing as
							<b style="color: blue;">{{$user->idDoc->investing_as}}</b></h4><br>
							<a href="/{{$user->idDoc->path}}">Your Doc</a>
							@if($user->idDoc->investing_as == 'Joint Investor')
							<p>Joint Investor Name:<br><b>{{$user->idDoc->joint_first_name}} {{$user->idDoc->joint_last_name}}</b></p>
							<a href="/{{$user->idDoc->joint_id_path}}">Joint Investor Doc</a>
							@endif
							<hr>
							@if($user->idDoc->verified == '1')
							Verified <i class="fa fa-check-circle" aria-hidden="true"></i>
							@elseif($user->idDoc->verified == '-1')
							<span style="color: red;">Verification Failed</span>
							@else
							Not-Verified
							@endif
							@endif
							@if(!$user->idDoc || $user->idDoc->verified == '-1')
							<form class="form-group" action="{{route('users.document.upload',[$user->id])}}" method="POST" enctype="multipart/form-data" rel="form">
								{{ csrf_field() }}
								<div class="row " id="section-2">
									<div class="col-md-12">
										<div >
											<h5>Individual/Joint applications - refer to naming standards for correct forms of registrable title(s)</h5>
											<br>
											<h4>Are you Investing as</h4>
											<input type="radio" name="investing_as" value="Individual Investor" checked> Individual Investor<br>
											<input type="radio" name="investing_as" value="Joint Investor"> Joint Investor<br>
											<input type="radio" name="investing_as" value="Trust or Company"> Trust or Company<br>
											<hr>
										</div>

									</div>
								</div>
								<div class="row " id="section-3">
									<div class="col-md-12">
										<div style="display: none;" id="company_trust">
											<label>Company of Trust Name</label>
											<div class="row">
												<div class="col-md-9">
													<input type="text" name="investing_company_name" class="form-control" placeholder="Trust or Company" required disabled="disabled">
												</div>
											</div><br>
										</div>
										<div id="normal_name">
											<label>Given Name(s)</label>
											<div class="row">
												<div class="col-md-9">
													<input type="text" name="first_name" class="form-control" placeholder="First Name" required @if(!Auth::guest() && $user->first_name) value="{{$user->first_name}}" readonly @endif>
												</div>
											</div><br>
											<label>Surname</label>
											<div class="row">
												<div class="col-md-9">
													<input type="text" name="last_name" class="form-control" placeholder="Last Name" required @if(!Auth::guest() && $user->last_name) value="{{$user->last_name}}" readonly @endif>
												</div>
											</div><br>
										</div>
										<div style="display: none;" id="joint_investor">
											<label>Joint Investor Details</label>
											<div class="row">
												<div class="col-md-6">
													<input type="text" name="joint_investor_first" class="form-control" placeholder="Investor First Name" required disabled="disabled">
												</div>
												<div class="col-md-6">
													<input type="text" name="joint_investor_last" class="form-control" placeholder="Investor Last Name" required disabled="disabled">
												</div>
											</div>
											<br>
											<hr>
										</div>
									</div>
								</div>
								<div class="row " id="section-4">
									<div class="col-md-12">
										<div id="trust_doc" style="display: none;">
											<label>Trust or Company DOCS</label>
											<input type="file" name="trust_or_company_docs" class="form-control" disabled="disabled" required><br>

											<p>Please upload the first and last pages of your trust deed or Company incorporation papers</p>
										</div>
										<div id="normal_id_docs">
											@if(!Auth::guest() && $user->investmentDoc->where('user_id', $user->id AND 'type','normal_name'))
											<div class="row">
												<div class="col-md-6">
												</div>
											</div>
											<br>
											@else
											@endif
											<label>ID DOCS</label>
											<input type="file" name="user_id_doc" class="form-control" required><br>
											<p>If you have not completed your verification process. Please upload a copy of your Driver License or Passport for AML/CTF purposes</p>
										</div>

										<div id="joint_investor_docs" style="display: none;">
											<label>Joint Investor ID DOCS</label>
											<input type="file" name="joint_investor_id_doc" class="form-control" disabled="disabled" required><br>

											<p>Please upload a copy of the joint investors Driver License or Passport for AML/CTF purposes</p>
										</div>
									</div>
								</div>
								<br><br><br>
								<button type="submit" class="btn btn-primary btn-lg" id="checkBtn"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;&nbsp;</strong></button><br><br>
							</form>
							@endif
						</dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
</div>
@endsection
@section('js-section')
<script>
	$(document).ready( function() {
		$("input[name='investing_as']").on('change',function() {
			if($(this).is(':checked') && $(this).val() == 'Individual Investor')
			{
				$('#normal_id_docs').removeAttr('style');
				$('#joint_investor_docs').attr('style','display:none;');
				$('#trust_doc').attr('style','display:none;');
				$('#company_trust').attr('style','display:none;');
				$('#joint_investor').attr('style','display:none;');
				$("input[name='joint_investor_first']").attr('disabled','disabled');
				$("input[name='joint_investor_last']").attr('disabled','disabled');
				$("input[name='investing_company_name']").attr('disabled','disabled');
				$("input[name='user_id_doc']").removeAttr('disabled');
				$("input[name='trust_or_company_docs']").attr('disabled','disabled');
				$("input[name='joint_investor_id_doc']").attr('disabled','disabled');
			}
			else if($(this).is(':checked') && $(this).val() == 'Joint Investor')
			{
				$('#joint_investor_docs').removeAttr('style');
				$('#normal_id_docs').removeAttr('style');
				$('#trust_doc').attr('style','display:none;');
				$('#company_trust').attr('style','display:none;');
				$('#joint_investor').removeAttr('style');
				$("input[name='joint_investor_first']").removeAttr('disabled');
				$("input[name='joint_investor_last']").removeAttr('disabled');
				$("input[name='investing_company_name']").attr('disabled','disabled');
				$("input[name='joint_investor_id_doc']").removeAttr('disabled');
				$("input[name='trust_or_company_docs']").attr('disabled','disabled');
				$("input[name='user_id_doc']").removeAttr('disabled');
			}
			else
			{
				$('#trust_doc').removeAttr('style');
				$('#normal_id_docs').attr('style','display:none;');
				$('#joint_investor_docs').attr('style','display:none;');
				$('#joint_investor').attr('style','display:none;');
				$('#company_trust').removeAttr('style');
				$("input[name='joint_investor_first']").attr('disabled','disabled');
				$("input[name='joint_investor_last']").attr('disabled','disabled');
				$("input[name='investing_company_name']").removeAttr('disabled');
				$("input[name='joint_investor_id_doc']").attr('disabled','disabled');
				$("input[name='trust_or_company_docs']").removeAttr('disabled');
				$("input[name='user_id_doc']").attr('disabled','disabled');
			}

		});

		// Slide and show the aml requirements section
		$('.aml-requirements-link').click(function(e){
			$('.aml-requirements-section').slideToggle();
			if($('.aml-requirements-link i').hasClass('fa-plus')){
				$('.aml-requirements-link i').removeClass('fa-plus');
				$('.aml-requirements-link i').addClass('fa-minus');
			}
			else{
				$('.aml-requirements-link i').removeClass('fa-minus');
				$('.aml-requirements-link i').addClass('fa-plus');
			}
		});

		// Submit Request for Form Filling
		$('.send-form-filling-request').click(function(e){
			if (confirm('This will raise a request for form filling. Do you want to continue ?')) {
				console.log('confirmed');
			} else {
				e.preventDefault();
			}
		});
	});
</script>
@endsection
