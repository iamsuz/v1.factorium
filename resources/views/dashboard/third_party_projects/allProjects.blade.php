@extends('layouts.main')

@section('title-section')
Projects | Dashboard | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
<style type="text/css">
	tr, th {
		text-align: center;
	}
</style>
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>12])
		</div>
		<div class="col-md-10">
			@if (Session::has('message'))
			{!! Session::get('message') !!}
			@endif
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="projectsTable">
					<thead>
						<tr>
							<th>Title</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($all_projects as $project)
						<tr class="@if(!$project->active) inactive @endif">
							<td>
							<a href="{{$project->project_site}}/projects/{{$project->id}}" target="_blank">{{$project->title}}</a><br><br>
							</td>
							<td>
								<div class="col-md-12"><input type="checkbox" class="third-party-switch" autocomplete="off" data-label-text="Show" data="{{$project->id}}" action="show_splash_page" @if($project->third_party_listing) @if($project->third_party_listing->active) value="1" checked @else value="0" @endif @endif></div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script><script type="text/javascript">
	$(document).ready(function(){
		var projectsTable = $('#projectsTable').DataTable({
			"iDisplayLength": 10,
			"fnInitComplete": thirdPartyListingSwitch()
		});
	});

	function thirdPartyListingSwitch(){
        $('.third-party-switch').bootstrapSwitch();
        $('#projectsTable').on('switchChange.bootstrapSwitch', '.third-party-switch', function () {
            var setVal = $(this).val() == 1? 0 : 1;
            $(this).val(setVal);
            var checkValue = $(this).val();
            var action = $(this).attr('action');
            var project_id = $(this).attr('data');
            $('.loader-overlay').show();
            $.ajax({
                url: '/dashboard/showThirdPartyProject',
                type: 'POST',
                dataType: 'JSON',
                data: {checkValue, action, project_id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done(function(data){
                console.log(data);
                $('.loader-overlay').hide();
            });
        });
    }

</script>
@stop
