@extends('projects.offerForm', ['route'=>$action])

@section('form-content')
<div class="col-md-10 col-md-offset-1" style="padding:8em 0;">
	<div class="row">
		<div class="col-md-6 col-md-offset-4 " data-wow-duration="1.5s" data-wow-delay="0.4s">
			<h5 class="text-left wow fadeIn animated">Individual/Joint applications - refer to naming standards for correct forms of registrable title(s) <br>
			</h5>
			{{-- <h3 class="text-left">Are you ready to begin crowdfunding your deposit?</h3> --}}
			<br>
			<h4>Are you investing as</h4>
			<br>
			<div class="btn-group forn-control" data-toggle="buttons">
				<input type="radio" name="individual_investor" id="investor_role" autocomplete="off" value="2" checked tabindex="1"> Yes, Let's do this!
				<br><br>
				<input type="radio" name="sell_or_fund" id="developer_role" autocomplete="off" value="1" tabindex="2"> I need more information on how it will work for me
				<br><br>
				<input type="radio" name="sell_or_fund" id="developer_role" autocomplete="off" value="3" tabindex="3"> I need more information on how it will work for me
			</div>
		</div>
	</div>
	<div class="row">
		<div class="text-left col-sm-3 wow fadeIn animated">
			<br>
			<input type="submit" name="submit" class="btn btn-primary btn-block" value="PREVIOUS">
			<input type="submit" name="submit" class="btn btn-primary btn-block" value="NEXT">
		</div>
	</div>
</div>

@endsection