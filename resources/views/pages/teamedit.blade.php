@extends('layouts.main')
@section('title-section')
Edit | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
    
@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
<!-- JCrop -->
{!! Html::style('/assets/plugins/JCrop/css/jquery.Jcrop.css') !!}
@stop
@section('content-section')
<div class="container">
	<br><br>
	<section>
		@if(isset($aboutus))
		{!! Form::model($aboutus, array('route'=>['pages.team.update', $aboutus], 'class'=>'form-horizontal', 'role'=>'form', 'method'=>'PATCH', 'files'=>true)) !!}
		@else
		{!! Form::open(array('route'=>['pages.team.create'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
		@endif
		<fieldset>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					@if (Session::has('message'))
					{!! Session::get('message') !!}
					@endif
					<h2 class="text-center">Edit your Team details</h2>
					<br>
					<div class="row">
						<div class="form-group text-justify <?php if($errors->first('main_heading')){echo 'has-error';}?>">
							{!!Form::label('main_heading', 'Description', array('class'=>'col-sm-2 control-label'))!!}
							<div class="col-sm-12 <?php if($errors->first('main_heading')){echo 'has-error';}?>">
								{!! Form::text('main_heading', null, array('placeholder'=>'Heading', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('main_heading', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group text-justify <?php if($errors->first('sub_heading')){echo 'has-error';}?>">
							<div class="col-sm-12 <?php if($errors->first('sub_heading')){echo 'has-error';}?>">
								{!! Form::textarea('sub_heading', null, array('placeholder'=>'Sub Heading', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('sub_heading', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group text-justify <?php if($errors->first('content')){echo 'has-error';}?>">
							<div class="col-sm-12 <?php if($errors->first('content')){echo 'has-error';}?>">
								{!! Form::textarea('content', null, array('placeholder'=>'Content', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('content', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-sm-6 col-sm-offset-3">
								{!! Form::submit('Update Details', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'10')) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		{!! Form::close() !!}
		@if($aboutus)
		<h2>Founders</h2>
		@if($member)
		<div class="row">
			@foreach($member->chunk(3) as $sets)
			<div class="row">
				@foreach($sets as $members)
				<div class="col-sm-4 col-md-4">
					<div class="pull-right"> 
						{!! Form::open(['method' => 'DELETE', 'route' => ['team.member.destroy', $aboutus->id, $members->id]]) !!}
						{!! Form::submit('Delete this Member?', ['class' => 'btn btn-danger pull-right']) !!}
						{!! Form::close() !!}
					</div>
					<img class="img-responsive img-circle" width="70%" height="70%" style="margin: 0 auto;" src="{{asset($members->founder_image_url)}}" alt="{{$members->founder_image_url}}" style="max-height: 100%; max-width: 100%;" />
					<div class="caption text-left">
						<h3 class="font-regular" style=" font-size:1.375em; color:#fed405;">
							<b>{{$members->founder_name}}</b>
						</h3>
						<p class="font-regular" style="font-size:1em;color:#282a73; margin-top:-10px;">
							{{$members->founder_subheading}}
						</p>
						<p style="font-size:0.875em;">
							{!! $members->founder_content !!}
						</p>
						<!-- <input type="button" onclick="change2()" id="button2" class="btn btn-xs btn-default" data-toggle="collapse" data-target="#more2" value="Read More"> -->
					</div>
				</div>
				@endforeach
			</div>
			@endforeach
		</div>
		@endif
		{!!Form::open(array('route'=>['team.members.create',$aboutus],'class'=>'form-horizontal','role'=>'form','files'=>true))!!}
		<fieldset>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="row">
						<div class="form-group <?php if($errors->first('founder_name')){echo 'has-error';}?>">
							<div class="col-sm-12 <?php if($errors->first('founder_name')){echo 'has-error';}?>">
								{!! Form::text('founder_name', null, array('placeholder'=>'Founder Name', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('founder_name', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group <?php if($errors->first('founder_subheading')){echo 'has-error';}?>">
							<div class="col-sm-12 <?php if($errors->first('founder_subheading')){echo 'has-error';}?>">
								{!! Form::text('founder_subheading', null, array('placeholder'=>'Founder Subheading(Co-founder)', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('founder_subheading', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group <?php if($errors->first('founder_content')){echo 'has-error';}?>">
							<div class="col-sm-12 <?php if($errors->first('founder_content')){echo 'has-error';}?>">
								{!! Form::textarea('founder_content', null, array('placeholder'=>'Founder Description', 'class'=>'form-control ', 'tabindex'=>'1')) !!}
								{!! $errors->first('founder_content', '<small class="text-danger">:message</small>') !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group @if($errors->first('founder_image_url')){{'has-error'}} @endif">
							<div class="col-sm-12">
								<div class="input-group">
									<label class="input-group-btn">
										<span class="btn btn-primary" style="padding: 10px 12px;">
											Browse&hellip; <input type="file" name="founder_image_url" id="property_img_thumbnail" class="form-control" style="display: none;">
										</span>
									</label>
									<input type="text" class="form-control" id="property_image_name" readonly>
									<input type="hidden" name="aboutus_id" id="aboutus_id" value="{{$aboutus->id}}">
									<input type="hidden" name="founder_img_path" id="founder_img_path" value="">
								</div>
							</div>
							{!! $errors->first('founder_image_url', '<small class="text-danger">:message</small>') !!}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-4">
								{!! Form::submit('Add Members', array('class'=>'btn btn-warning btn-block', 'tabindex'=>'10')) !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		{!! Form::close() !!}
		@endif
	</section>
</div>

<!-- Bootstrap modal box -->
<div class="row">
	<div class="text-center">
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog" style="min-width: 800px;">
                <!-- Modal content-->
                <div class="modal-content">
                	<div class="modal-header">
                      	<button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                      	<h4 class="modal-title">Crop Image</h4>
                  	</div>
                  	<div class="modal-body">
                    	<div class="text-center" id="image_cropbox_container" style="display: inline-block;">
                    	</div>
                	</div>
                	<div class="modal-footer">
	                    <button type="button" class="btn btn-default" id="perform_crop_btn">Perform Crop</button>
	                    <!-- Hidden Fields to refer for JCrop -->
	                    <input type="hidden" name="image_crop" id="image_crop" value="" action="">
	                    <input type="hidden" name="x_coord" id="x_coord" value="">
	                    <input type="hidden" name="y_coord" id="y_coord" value="">
	                    <input type="hidden" name="w_target" id="w_target" value="">
	                    <input type="hidden" name="h_target" id="h_target" value="">
	                    <input type="hidden" name="orig_width" id="orig_width" value="">
	                    <input type="hidden" name="orig_height" id="orig_height" value="">
                	</div>
            	</div>      
        	</div>
    	</div>
	</div>
</div>
@stop
@section('js-section')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
<!-- JCrop -->
{!! Html::script('/assets/plugins/JCrop/js/jquery.Jcrop.js') !!}

<script>
	$(document).ready(function(){
		$('#property_img_thumbnail').change(function(e){
			var file = $('#property_img_thumbnail')[0].files[0];
			if (file){
				$('#property_image_name').val(file.name);
			}
			// Image Crop Functionality
			if($('#property_img_thumbnail').val() != ''){
				$('.loader-overlay').show();
				var formData = new FormData();
                formData.append('founder_image_url', $('#property_img_thumbnail')[0].files[0]);
                formData.append('aboutus_id', $('#aboutus_id').val());
                $.ajax({
                    url: '/pages/team/members/uploadImg',
                    type: 'POST',
                    dataType: 'JSON',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false
                }).done(function(data){
                	if(data.status == 1){
                        console.log(data);
                        var imgPath = data.destPath+'/'+data.fileName;
                        var str1 = $('<div class="col-sm-9" id="founder_img_container"><img src="../../'+imgPath+'" width="530" id="image_cropbox" style="max-width:none !important"><br><span style="font-style: italic; font-size: 13px"><small>Select The Required Area To Crop Logo.</small></span></div><div class="col-sm-2" id="preview_img_container" style="float: right; width:171px; height:171px;"><img width="530" src="../../'+imgPath+'" id="preview_image"></div>');

                        $('#image_cropbox_container').html(str1);
                        $('#myModal').modal({
                            'show': true,
                            'backdrop': false,
                        });

                        $('#image_crop').val(imgPath); //set hidden image value
                        $('#image_crop').attr('action', '');
                        var target_width = 171;
                        var target_height = 171;
                        var origWidth = data.origWidth;
                        var origHeight = data.origHeight;
                        $('#image_cropbox').Jcrop({
                            boxWidth: 530,
                            aspectRatio: 1,
                            keySupport: false,
                            setSelect: [0, 0, target_width, target_height],
                            bgColor: '',
                            onSelect: function(c) {
                                updateCoords(c, target_width, target_height, origWidth, origHeight);
                            },
                            onChange: function(c) {
                                updateCoords(c, target_width, target_height, origWidth, origHeight);
                            },onRelease: setSelect,
                            minSize: [target_width, target_height],
                        });
                        $('.loader-overlay').hide();
                    }
                    else{
                      $('#property_img_thumbnail, #property_img_name').val('');
                      $('.loader-overlay').hide();
                      alert(data.message);
                    }
                });
			}
		});

        performCropOnImage();

        $('#modal_close_btn').click(function(e){
            $('#brand_logo, #brand_logo_name').val('');
        });
	});

	function updateCoords(coords, w, h, origWidth, origHeight){
            var target_width= w;
            var target_height=h;
            //Set New Coordinates
            $('#x_coord').val(coords.x);
            $('#y_coord').val(coords.y);
            $('#w_target').val(coords.w);
            $('#h_target').val(coords.h);
            $('#orig_width').val(origWidth);
            $('#orig_height').val(origHeight);

            // showPreview(coordinates)
            $("<img>").attr("src", $('#image_cropbox').attr("src")).load(function(){
                var rx = target_width / coords.w;
                var ry = target_height / coords.h;

                var realWidth = this.width;
                var realHeight = this.height;

                var newWidth = 530;
                var newHeight = (realHeight/realWidth)*newWidth;
                
                $('#preview_image').css({
                    width: Math.round(rx*newWidth)+'px',
                    height: Math.round(ry*newHeight)+'px',
                    marginLeft: '-'+Math.round(rx*coords.x)+'px',
                    marginTop: '-'+Math.round(ry*coords.y)+'px',
                });

            });
        }

        function setSelect(coords){
            jcrop_api.setSelect([coords.x,coords.y,coords.w,coords.h]);
        }

        function performCropOnImage(){
            $('#perform_crop_btn').click(function(e){
            	$('.loader-overlay').show();
                var imageName = $('#image_crop').val();
                var imgAction = $('#image_crop').attr('action');
                var xValue = $('#x_coord').val();
                var yValue = $('#y_coord').val();
                var wValue = $('#w_target').val();
                var hValue = $('#h_target').val();
                var origWidth = $('#orig_width').val();
                var origHeight = $('#orig_height').val();
                $.ajax({
                    url: '/pages/cropUploadedImage',
                    type: 'POST',
                    data: {
                        imageName: imageName,
                        imgAction: imgAction,
                        xValue: xValue,
                        yValue: yValue,
                        wValue: wValue,
                        hValue: hValue,
                        origWidth: origWidth,
                        origHeight: origHeight,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(data){
                    console.log(data);
                    if(data.status){
                        $('#image_crop').val(data.imageSource);
                        $('#founder_img_path').val(data.imageSource);
                        $('#myModal').modal('toggle');
                        $('.loader-overlay').hide();
                    }
                    else{
                    	$('.loader-overlay').hide();
                        $('#myModal').modal('toggle');
                        alert(data.message);
                    }
                });
            });
        }

</script>
@stop