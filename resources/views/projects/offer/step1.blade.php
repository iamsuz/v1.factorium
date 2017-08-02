@extends('projects.offerForm', ['route'=>$action])

@section('form-content')
<div class="col-md-10 col-md-offset-1" style="padding:8em 0;">
	<div>
		<div class="row">
			<div class="col-md-6 col-md-offset-2" data-wow-duration="1.5s" data-wow-delay="0.4s">
				<label class="form-label">Peoject SPV Name</label><br>
				<input class="form-control" type="text" name="project_spv_name" placeholder="Project SPV Name" style="width: 60%;" @if($projects_spv) value="{{$projects_spv->spv_name}}" @endif >
				<h5>Name of the Company established as a special puropose Vehicle for this project that you are investing in</h5>
				<p>
					This Application Form is important. If you are in doubt as to how to deal with it, please contact your stockbroker or professional adviser without delay. You should read the entire prospectus carefully before completing this form. To meet the requirements of the Corporations Act, this Application Form must  not be distributed unless included in, or accompanied by, the prospectus.
				</p>
				<label>I/We apply for *</label>
				<input type="text" name="amount_to_invest" class="form-control" placeholder="$5000" style="width: 60%" id="apply_for" required>
				<h5>Number of Redeemable Preference Shares at $1 per Share or such lesser number of Shares which may be allocated to me/us</h5>
				<label>I/We lodge full Application Money</label>
				<input type="text" name="apply_for" class="form-control" placeholder="$5000" value="A$ 0.00" style="width: 60%" id="application_money">
				<input type="text" name="project_id" value="{{$projects_spv->project_id}}" hidden >
			</div>
		</div>
		<div class="row">
			<div class="text-left col-sm-3 wow fadeIn animated">
				<br>
				<input type="submit" name="submit" class="btn btn-primary btn-block" value="NEXT" id="next_btn">
			</div>
		</div>
	</div>
</div>
@endsection
@section('partial-js-section')
<script>
	$(document).ready(function(){
		var qty=$("#apply_for");
		qty.keyup(function(){
			var total='A$ '+qty.val().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$("#application_money").val(total);
		});
	});
</script>
@endsection