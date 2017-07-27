<style type="text/css">
/*@page { margin: 0px; }
body { margin: 0px; }
html { margin: 0px;}*/
@page {
	background-color: #fff;
}
.back-img
{
	background: url('/assets/images/certificate_frames/{{$investment->project->projectspvdetail->certificate_frame}}');
	background-position: top center;
	background-repeat: no-repeat;
	background-size: 100%;
	padding-top: 100px;
	padding-left: 100px;
	padding-right: 100px;
	width:100%;
	height:100%;
	margin: -50px;
}
.text-center{
	text-align: center;
}
.watermark{
	top: 15%;
	width: 100%;
	position: absolute;
	z-index: -1;
	opacity: 0.05;
}
</style>
<div @if($investment->project->projectspvdetail) class="back-img" @endif>
	@if($investment->project->media->where('type', 'spv_logo_image')->first())
	<div class="text-center watermark"><img src="{{$investment->project->media->where('type', 'spv_logo_image')->first()->path}}" width="700"></div>
	@endif
	<div class="text-center">
		<h1>Share Certificate</h1>
		<br>
		@if($investment->project->media->where('type', 'spv_logo_image')->first())
		<center><img src="{{$investment->project->media->where('type', 'spv_logo_image')->first()->path}}" height="100"></center>
		<br>
		@endif
		@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->spv_name}}@else Estate Baron @endif
		<br>
		@if($spv=$investment->project->projectspvdetail){{$spv->spv_line_1}}, @if($spv->first()->spv_line_2){{$spv->spv_line_2}},@endif {{$spv->spv_city}}, {{$spv->spv_state}}, {{array_search($spv->spv_country, \App\Http\Utilities\Country::aus())}}, {{$spv->spv_postal_code}}@endif
		<br>
		@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->spv_contact_number}}@else +1 300 033 221 @endif
		<br><br>
		Date: {{ $investment->created_at->toFormattedDateString() }}
		<br><br>
		This is to certify @if($investment->investing_as == 'Individual Investor') {{$investment->user->first_name}} {{$investment->user->last_name}} @elseif($investment->investing_as == 'Joint Investor') {{$investment->user->first_name}} {{$investment->user->last_name}} and {{$investing->joint_investor_first_name}} {{$investing->joint_investor_last_name}} @elseif($investment->investing_as == 'Trust or Company') {{$investing->investing_company}} @else {{$investment->user->first_name}} {{$investment->user->last_name}}@endif @if($investment->user->line_1) of  {{$investment->user->line_1}}, @if($investment->user->line_2){{$investment->user->line_2}},@endif {{$investment->user->city}}, {{$investment->user->state}}, {{$investment->user->postal_code}}@endif owns {{$investment->amount}} redeemable preference shares of @if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->spv_name}}@else Estate Baron @endif numbered {{$shareStart}} to {{$shareEnd}}.
		<br><br>
		@if($investment->project->media->where('type', 'spv_md_sign_image')->first())
		<img src="{{$investment->project->media->where('type', 'spv_md_sign_image')->first()->path}}" height="50">
		<br>
		@endif
		@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->spv_md_name}}@else Moresh Kokane @endif
		<br>
		Managing Director
		<br>
		@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->spv_name}}@else Estate Baron @endif
	</div>
</div>