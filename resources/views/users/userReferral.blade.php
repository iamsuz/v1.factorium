@extends('layouts.main')

@section('title-section')
{{$user->first_name}} | @parent
@stop

@section('content-section')
<div class="container">
	<br><br>
	<div class="row">
		<div class="col-md-2">
			@include('partials.sidebar', ['user'=>$user, 'active'=>11])
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
					</dl>
					<table class="table table-striped table-responsive text-center">
						<thead class="text-center">
							<tr>
								<th class="text-center">Firstname</th>
								<th class="text-center">Lastname</th>
								<th class="text-center">Email</th>
								<th class="text-center">KYC Status</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($refUsers))
							@foreach($refUsers as $refUser)
							<tr>
								<td>{{$refUser->first_name}}</td>
								<td>{{$refUser->last_name}}</td>
								<td>{{$refUser->email}}</td>
								<td>@if($refUser->idDoc) @if($refUser->idDoc->verified == 1) KYC Verified @else KYC Not Verified @endif @else KYC not submitted @endif</td>
							</tr>
							@endforeach
							@else
							No Referral yet
							@endif
						</tbody>
					</table>
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
