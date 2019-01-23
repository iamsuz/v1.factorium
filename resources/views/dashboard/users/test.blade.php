@extends('layouts.main')

@section('title-section')
Users | Dashboard | @parent
@stop

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
@stop
{{-- <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> --}}
@section('content-section')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<table id="example" class="display" style="width:100%">
	<thead>
		<tr>
			<th>ID</th>
			<th>Details</th>
			<th>Notes</th>
			<th>Last Login</th>
			<th>Active</th>
			<th>Registration</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>ID</th>
			<th>Details</th>
			<th>Notes</th>
			<th>Last Login</th>
			<th>Active</th>
			<th>Registration</th>
		</tr>
	</tfoot>
</table>

<script>
	$(document).ready(function() {
		$('#example').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax": "../api/users"
		} );
	} );
</script>
    {{-- {!! Datatable::table()       // these are the column headings to be shown
    ->addColumn(array(
        'id'            => 'ID',
        'first_name'          => 'Name',
        'created_at'    => 'Erstellt'
        ))
    ->setUrl(route('api.users'))   // this is the route where data will be retrieved
    ->render() !!} --}}
    @stop


