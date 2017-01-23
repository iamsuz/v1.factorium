@extends('layouts.main')

@section('title-section')
Configuration | Dashboard | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css-section')

<style type="text/css">
	.config-list-items{
		border: 1px solid #ddd;
		border-radius: 4px;
	}
</style>
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>4])
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="row" style="padding-top:1.2em;">
						
						<div class="col-md-4">
							<div class="thumbnail text-center">
								@if (Session::has('message'))
								@if(Session::get('action') == 'site-favicon')
								<div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
								<h5>{!! Session::get('message') !!}</h5>
								</div>
								@endif
								@endif
								<div class="caption">
									<h3><b>Favicon</b></h3>
									<p><small>This Icon will appear on the title bar of the website page.</small></p>
									<hr>
									<p>
									<label class="input-group-btn">
										<span class="btn btn-primary btn-sm change-favicon-btn" style="cursor: pointer;">
											<strong>Change Favicon</strong>
										</span>
									</label>
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="thumbnail text-center">
								@if (Session::has('message'))
								@if(Session::get('action') == 'site-title')
								<div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
								<h5>{!! Session::get('message') !!}</h5>
								</div>
								@endif
								@endif
								<div class="caption">
									<h3><b>Website Title</b></h3>
									<p><small>This text will appear on the title bar of the website page.</small></p>
									<hr>
									<p>
									<label class="input-group-btn">
										<span class="btn btn-primary btn-sm change-title-btn" style="cursor: pointer;">
											<strong>Change Title</strong>
										</span>
									</label>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="row">
    <div class="text-center">
        <!-- Modal for Site Favicon edit-->
        <div class="modal fade" id="favicon_edit_modal" role="dialog">
            <div class="modal-dialog" style="margin-top: 10%;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Favicon</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row text-center" id="modal_body_container">
                        	<div class="col-md-10 col-md-offset-1">
                        		{!! Form::open(array('route'=>['configuration.updateFavicon'], 'files' => true, 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
	                        		<h5><i><small>Select image in below form and save to display new favicon for the website. Valid extension: png</small></i></h5>
	                        		<br>
	                        		<div class="row favicon-error" style="text-align: -webkit-center;"></div>
	                        		<div class="input-group">
										<label class="input-group-btn">
											<span class="btn btn-primary" style="padding: 10px 12px;">
												Browse&hellip; <input type="file" name="favicon_image_url" id="favicon_image_url" class="form-control" style="display: none;">
											</span>
										</label>
										<input type="text" class="form-control" id="favicon_image_name" name="favicon_image_name" readonly>
									</div>
	                        		<br>
	                        		{!! Form::submit('Save Title', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_favicon_btn')) !!}
                        		{!! Form::close() !!}
                        	</div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
        <!-- Modal for Site Title edit-->
        <div class="modal fade" id="title_text_edit_modal" role="dialog">
            <div class="modal-dialog" style="margin-top: 10%;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Title</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row text-center" id="modal_body_container">
                        	<div class="col-md-10 col-md-offset-1">
                        		{!! Form::open(array('route'=>['configuration.updateSiteTitle'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
	                        		<h5><i><small>Enter the text in below text field and save to display new title for the website.</small></i></h5>
	                        		<br>
	                        		<div class="row title-text-error" style="text-align: -webkit-center;"></div>
	                        		{!! Form::text('title_text_imput', null, array('placeholder'=>'Enter website title', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'title_text_imput')) !!}
									{!! $errors->first('title_text_imput', '<small class="text-danger">:message</small>') !!}
	                        		<br>
	                        		{!! Form::submit('Save Title', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_title_text_btn')) !!}
                        		{!! Form::close() !!}
                        	</div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>
@stop

@section('js-section')

<script type="text/javascript">
	$(document).ready(function(){

		$('.change-title-btn').click(function(){
			$('#title_text_edit_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#title_text_imput').select();
		});

		$('#submit_title_text_btn').click(function(e){
			if($('#title_text_imput').val() == ''){
				e.preventDefault();
				$('.title-text-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Title field is empty</h6></div>')
			}
		});

		$('.change-favicon-btn').click(function(){
			$('#favicon_edit_modal').modal({
				'show':true,
				'backdrop':false,
			});
		});

		$('#modal_close_btn').click(function(){
			$('#favicon_image_url').val('');
			$('#favicon_image_name').val('');
		});

		$('#favicon_image_url').change(function(){
			$('.favicon-error').html('');
			var file = $('#favicon_image_url')[0].files[0];
			if (file){
				fileExtension = (file.name).substr(((file.name).lastIndexOf('.') + 1)).toLowerCase();
				if(fileExtension == 'png'){
					$('#favicon_image_name').val(file.name);
				}
				else{
					$('#favicon_image_url').val('');
					$('#favicon_image_name').val('');
					$('.favicon-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Not a valid file extension. Valid extension: png</h6></div>');
				}
			}
		});

		$('#submit_favicon_btn').click(function(e){
			if($('#favicon_image_url').val() == ''){
				e.preventDefault();
				$('.favicon-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>No Image selected</h6></div>');
			}
			console.log($('#favicon_image_url').val());
		});
	});
</script>
@stop