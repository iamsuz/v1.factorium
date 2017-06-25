<div style="text-align: center;">
	
	<h1>Share Certificate</h1>
	<br><br>

	@if($investment->project->media->where('type', 'spv_logo_image')->first())
	<img src="{{public_path().'/'.$investment->project->media->where('type', 'spv_logo_image')->first()->path}}" width="300">
	<br><br>
	@endif
	@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->first()->spv_name}}@else Estate Baron @endif
	<br>

	@if($spv=$investment->project->projectspvdetail){{$spv->first()->spv_line_1}}, @if($spv->first()->spv_line_2){{$spv->first()->spv_line_2}},@endif {{$spv->first()->spv_city}}, {{$spv->first()->spv_state}}, {{$spv->first()->spv_city}}, {{$spv->first()->spv_postal_code}}@endif
	<br>	

	@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->first()->spv_contact_number}}@else +1 300 033 221 @endif
	<br>

	<br>
	Date: {{ $investment->created_at->toFormattedDateString() }}
	<br><br><br><br>

	This is to certify @if($investment->investing_as == 'Individual Investor') {{$investment->user->first_name}} {{$investment->user->last_name}} @elseif($investment->investing_as == 'Joint Investor') {{$investment->user->first_name}} {{$investment->user->last_name}} and {{$investing->joint_investor_first_name}} {{$investing->joint_investor_last_name}} @elseif($investment->investing_as == 'Trust or Company') {{$investing->investing_company}} @else {{$investment->user->first_name}} {{$investment->user->last_name}}@endif @if($investment->user->line_1) of  {{$investment->user->line_1}}, @if($investment->user->line_2){{$investment->user->line_2}},@endif {{$investment->user->city}}, {{$investment->user->state}}, {{$investment->user->postal_code}}@endif owns {{$investment->amount}} redeemable preference shares of @if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->first()->spv_name}}@else Estate Baron @endif numbered {{$shareStart}} to {{$shareEnd}}.
	<br><br><br><br>

	@if($investment->project->media->where('type', 'spv_md_sign_image')->first())
	<img src="{{public_path().'/'.$investment->project->media->where('type', 'spv_md_sign_image')->first()->path}}" width="150">
	<br>
	@endif
	@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->first()->spv_md_name}}@else Moresh Kokane @endif
	<br>
	Managing Director
	<br>
	@if($investment->project->projectspvdetail){{$investment->project->projectspvdetail->first()->spv_name}}@else Estate Baron @endif

	
</div>