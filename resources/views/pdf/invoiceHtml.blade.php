<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style >
		.text-center{
			text-align: center;
		}
	</style>
</head>
<body>
	@if($investment->project->projectspvdetail)
	@if($investment->project->projectspvdetail->certificate_frame)
	<div style="background:url('/assets/images/certificate_frames/{{$investment->project->projectspvdetail->certificate_frame}}');background-position: top center;background-repeat: no-repeat;background-size: 85% 90%;width:100%;height:100%;padding-bottom: 7%;">
		@else
		<div style="padding-top:100px;padding-left:100px;padding-right:100px;margin:-50px;">
			@endif
			@else
			<div style="padding-top:100px;padding-left:100px;padding-right:100px;margin:-50px;">
				@endif
				@if($investment->project->media->where('type', 'spv_logo_image')->first())
				<div class="text-center" style="top:15%;width:100%;position:absolute;z-index:-1;opacity:0.05;"><img src="/{{$investment->project->media->where('type', 'spv_logo_image')->first()->path}}" width="700"></div>
				@endif
				<div class="text-center" style="padding: 10% 20%;">
					<h1>@if($investment->project->share_vs_unit == 1) Redeemable Preference Share @elseif($investment->project->share_vs_unit == 2) Preference Shares @elseif($investment->project->share_vs_unit == 3) Ordinary Shares @else Unit @endif Certificate</h1>
					<br>
					@if($investment->project->media->where('type','spv_logo_image')->first())
					<center><img src="/{{$investment->project->media->where('type','spv_logo_image')->first()->path}}" height="100"></center><br>
					@endif
					@if($investment->project->projectspvdetail)
					{{$investment->project->projectspvdetail->spv_name}}
					@else
					{{'Estate Baron'}}
					@endif
					<br>
					@if($spv=$investment->project->projectspvdetail)
					@if(isset($spv->first()->spv_line_1) && !empty($spv->first()->spv_line_1) && $spv->first()->spv_line_1 != '') {{$spv->spv_line_1}}, @endif @if(isset($spv->first()->spv_line_2) && !empty($spv->first()->spv_line_2) && $spv->first()->spv_line_2 != '') {{$spv->spv_line_2}}, @endif {{$spv->spv_city}}, {{$spv->spv_state}}, {{$spv->spv_postal_code}}
					@endif
					<br>
					@if($investment->project->projectspvdetail)
					{{$investment->project->projectspvdetail->spv_contact_number}}
					@else
					{{'+1 300 033 221'}}
					@endif
					<br><br>
					{{-- Date: {{ $investment->share_certificate_issued_at->toFormattedDateString()}} --}}
					Date: {{Carbon\Carbon::now()->toDateString()}}
					<br><br>
					<p>
						This is to certify @if($investment->investing_as=='Individual Investor'){{$investment->user->first_name}} {{$investment->user->last_name}}@elseif($investment->investing_as == 'Joint Investor'){{$investment->user->first_name}} {{$investment->user->last_name}} and {{$investing->joint_investor_first_name}} {{$investing->joint_investor_last_name}}@elseif($investment->investing_as=='Trust or Company'){{$investing->investing_company}}@else{{$investment->user->first_name}} {{$investment->user->last_name}}@endif @if($investment->user->line_1) of {{$investment->user->line_1}}, @if($investment->user->line_2 != '') {{$investment->user->line_2}}, @endif {{$investment->user->city}}, {{$investment->user->state}}, {{$investment->user->postal_code}}@endif owns @if($result){{$result->balance}} @else {{$investment->amount}} @endif @if($investment->project->share_vs_unit == 1) redeemable preference shares @elseif($investment->project->share_vs_unit == 2) Preference Shares @elseif($investment->project->share_vs_unit == 3) Ordinary shares @else units @endif of @if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->spv_name}}@else Estate Baron @endif.
					</p>
					<br><br>
					@if($investment->project->media->where('type', 'spv_md_sign_image')->first())
					<img src="/{{$investment->project->media->where('type', 'spv_md_sign_image')->first()->path}}" height="50">
					<br>
					@endif
					@if($investment->project->projectspvdetail)
					{{$investment->project->projectspvdetail->spv_md_name}}
					@else
					{{'Moresh Kokane'}}
					@endif
					<br>
					@if($investment->project->md_vs_trustee)
					{{'Managing Director'}}
					@else
					{{'Trustee'}}
					@endif
					<br>
					@if($investment->project->projectspvdetail)
					{{$investment->project->projectspvdetail->spv_name}}
					@else
					{{'Estate Baron'}}
					@endif
				</div>
			</div>
		</body>
		</html>
