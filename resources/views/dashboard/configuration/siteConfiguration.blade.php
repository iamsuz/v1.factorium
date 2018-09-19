@extends('layouts.main')

@section('title-section')
Configuration | Dashboard | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{csrf_token()}}" />
@endsection

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
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
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'website-name')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Website Name</b></h3>
                                    <p><small>This will be the reference name for the website.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-site-name-btn" style="cursor: pointer;">
                                                <strong>Change Website Name</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'client-name')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Client Name</b></h3>
                                    <p><small>This will be the client name who owns the website.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-client-name-btn" style="cursor: pointer;">
                                                <strong>Change Client Name</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'mail_setting')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Mailer Email</b></h3>
                                    <p><small>This will be the email address from which all emails will be sent.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-mailer-email-btn" style="cursor: pointer;">
                                                <strong>Change Email address</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="display: none;">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'embedded_link')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Embedded Link</b></h3>
                                    <p><small>This is the link embedded the interest form for projects.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-intrest-embed-link-btn" style="cursor: pointer;">
                                                <strong>Change Embed Link</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'tag_manager')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Tag Manager</b></h3>
                                    <p><small>This script will be added in the head and body section of the layouts.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-tag-manager-btn" style="cursor: pointer;">
                                                <strong>Change Tag Manager</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'conversion_pixel')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Conversion pixel</b></h3>
                                    <p><small>This code will be added on confirm page once user invest in project.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-conversion-pixel-btn" style="cursor: pointer;">
                                                <strong>Change Conversion Pixel</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'change_prospectus')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Prospectus Text</b></h3>
                                    <p><small>This will replace all the instances of prospectus with entered word.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-prospectus-text-btn" style="cursor: pointer;">
                                                <strong>Change Prospectus Text</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'change_legal_details')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Legal Details</b></h3>
                                    <p><small>Edit Licensee name, AFSL and CAR number.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-legal-details-btn" style="cursor: pointer;">
                                                <strong>Change Legal Details</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail text-center">
                                @if (Session::has('message'))
                                @if(Session::get('action') == 'change_konkrete_bonus_allocation')
                                <div style="background-color: #c9ffd5;color: #027039;width: 100%;padding: 1px;">
                                    <h5>{!! Session::get('message') !!}</h5>
                                </div>
                                @endif
                                @endif
                                <div class="caption">
                                    <h3><b>Konkrete Bonus</b></h3>
                                    <p><small>Edit the konkrete bonus allocation on this site.</small></p>
                                    <hr>
                                    <p>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary btn-sm change-konkrete-bonus-allocation-btn" style="cursor: pointer;">
                                                <strong>Change Konkrete Bonus Allocation</strong>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section style="padding: 5% 0%;">
                <div class="col-md-offset-1 col-md-10">
                    <h2 class="text-center">Items Visibility</h2>
                    <hr>
                    <div class="row" style="padding: 0px 10px;">
                        <div class="col-md-6">Splash Page</div>
                        <div class="col-md-6 text-right"><input type="checkbox" class="common-switch-class" autocomplete="off" data-label-text="Show" action="show_splash_page" @if(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->show_splash_page) value="1" checked @else value="0" @endif></div>
                    </div>
                    <hr>
                    <!-- <div class="row" style="padding: 0px 10px;">
                        <div class="col-md-6">Welcome Flash Message</div>
                        <div class="col-md-6 text-right"><input type="checkbox" class="common-switch-class splash-page-switch" autocomplete="off" data-label-text="Show" action="show_splash_message" @if(App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->show_splash_message) value="1" checked @else value="0" @endif></div>
                    </div>
                    <hr> -->

                </div>
            </section>
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
                        {!! Form::button('Upload Image', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_favicon_btn')) !!}
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
                      {!! Form::text('title_text_imput', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->title_text, array('placeholder'=>'Enter website title', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'title_text_imput')) !!}
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
<!-- Mailer Modal -->
<div class="modal fade" id="mailer_email_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%; width: 70%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Mail Configuration</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                    @if($siteconfiguration->mailSetting)
                    {!! Form::model($mail_setting, array('route'=>['configuration.updatemailsettings',$mail_setting], 'method'=>'PATCH', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                    @else
                        {!! Form::open(array('route'=>['configuration.createmailsettings'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        @endif
                        <h5><i><small>Enter the email in below text field and save to display new email for the website.</small></i></h5>
                        <br>
                        <div class="row title-text-error" style="text-align: -webkit-center;">
                            {!!Form::label('driver', 'Driver', array('class'=>'col-sm-2 control-label'))!!}
                            <div class="col-md-4">
                                {!! Form::text('driver', null, array('placeholder'=>'Enter MAIL_Driver (smtp)', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'mail_driver','required' => 'required')) !!}
                                {!! $errors->first('driver', '<small class="text-danger">:message</small>') !!}
                                <br>
                            </div>
                            <div class="col-md-2">
                                <label>
                                    <h4 class="text-center">Encryption</h4>
                                </label>
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('encryption', null, array('placeholder'=>'Enter EMAIL_ENCRYPTION (tls)', 'class'=>'form-control ', 'tabindex'=>'2', 'id'=>'mail_ecryption','required' => 'required')) !!}
                                {!! $errors->first('encryption', '<small class="text-danger">:message</small>') !!}
                                <br>
                            </div>
                        </div>
                        <div class="row title-text-error" style="text-align: -webkit-center;">
                            <div class="col-md-2">
                                <label>
                                    <h4 class="text-center">Host</h4>
                                </label>
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('host', null, array('placeholder'=>'Enter MAIL_HOST (smtp.gmail.com)', 'class'=>'form-control ', 'tabindex'=>'3', 'id'=>'mail_host', 'required' => 'required')) !!}
                                {!! $errors->first('host', '<small class="text-danger">:message</small>') !!}
                                <br>
                            </div>
                            <div class="col-md-2">
                                <label>
                                    <h4 class="text-center">PORT</h4>
                                </label>
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('port', null, array('placeholder'=>'Enter EMAIL_PORT (587)', 'class'=>'form-control ', 'tabindex'=>'4', 'id'=>'mail_port','required' => 'required')) !!}
                                {!! $errors->first('port', '<small class="text-danger">:message</small>') !!}
                                <br>
                            </div>
                        </div>
                        <div class="row title-text-error">
                            <div class="col-md-2">
                                <label>
                                    <h4 class="text-center">From</h4>
                                </label>
                            </div>
                            <div class="col-md-10">
                                {!! Form::text('from', null, array('placeholder'=>'Enter MAIL_FROM (info@estatebaron.com)', 'class'=>'form-control ', 'tabindex'=>'5', 'id'=>'mail_from','required' => 'required')) !!}
                                {!! $errors->first('from', '<small class="text-danger">:message</small>') !!}
                                <br>
                            </div>
                        </div>
                        <div class="row title-text-error">
                        <div class="col-md-2">
                                <label>
                                    <h4 class="text-center">Username</h4>
                                </label>
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('username', null, array('placeholder'=>'Enter email (info@estatebaron.com)', 'class'=>'form-control ', 'tabindex'=>'6', 'id'=>'mail_username','required' => 'required')) !!}
                                {!! $errors->first('username', '<small class="text-danger">:message</small>') !!}
                                <br>
                            </div>
                            <div class="col-md-2">
                                <label>
                                    <h4 class="text-center">Password</h4>
                                </label>
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('password',null, array('placeholder'=>'Enter MAIL_PASSWORD', 'class'=>'form-control ', 'tabindex'=>'7', 'id'=>'mail_password','required' => 'required')) !!}
                                {!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
                                <br>
                            </div>
                        </div>
                        {!! Form::submit('Change Mail Settings', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_title_text_btn')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Favicon Crop modal -->
<div class="modal fade" id="image_crop_modal" role="dialog" style="overflow: scroll;">
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
                <input type="hidden" name="image_action" id="image_action" value="">
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
<!-- Modal for Site Name edit-->
<div class="modal fade" id="site_name_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Website Name</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateWebsiteName'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the text in below text field and save to display new name for the website.</small></i></h5>
                        <br>
                        <div class="row site-name-error" style="text-align: -webkit-center;"></div>
                        {!! Form::text('site_name_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->website_name, array('placeholder'=>'Enter website name', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'site_name_input')) !!}
                        {!! $errors->first('site_name_input', '<small class="text-danger">:message</small>') !!}
                        <br>
                        {!! Form::submit('Save Website Name', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_website_name_btn')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Client Name edit-->
<div class="modal fade" id="client_name_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Client Name</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateClientName'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the text in below text field and save to display new client name for the website.</small></i></h5>
                        <br>
                        <div class="row client-name-error" style="text-align: -webkit-center;"></div>
                        {!! Form::text('client_name_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->client_name, array('placeholder'=>'Enter client name', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'client_name_input')) !!}
                        {!! $errors->first('client_name_input', '<small class="text-danger">:message</small>') !!}
                        <br>
                        {!! Form::submit('Save Client Name', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_client_name_btn')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Emedd link edit-->
<div class="modal fade" id="embedd_link_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Embed Interest Link</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateInterestFormLink'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the text in below text field and save to update the project interest form link.</small></i></h5>
                        <br>
                        <div class="row interest-link-error" style="text-align: -webkit-center;"></div>
                        {!! Form::text('interest_link_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->embedded_offer_doc_link, array('placeholder'=>'Enter Project Interest Form Link', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'interest_link_input')) !!}
                        {!! $errors->first('interest_link_input', '<small class="text-danger">:message</small>') !!}
                        <br>
                        {!! Form::submit('Save Interest Link', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_interest_link_btn')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Tag Manager edit-->
<div class="modal fade" id="tag_manager_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Tag Manager</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateTagManager'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the text in below text field and save to update the site tag manager scripts.</small></i></h5>
                        <br>
                        <div class="row tag-manager-error" style="text-align: -webkit-center;"></div>
                        {!! Form::textarea('tag_manager_header_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->tag_manager_header, array('placeholder'=>'Enter tag manager header text', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'tag_manager_header_input', 'rows'=>'5')) !!}
                        {!! $errors->first('tag_manager_header_input', '<small class="text-danger">:message</small>') !!}
                        <br>
                        {!! Form::textarea('tag_manager_body_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->tag_manager_body, array('placeholder'=>'Enter tag manager body text', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'tag_manager_body_input', 'rows'=>'3')) !!}
                        {!! $errors->first('tag_manager_body_input', '<small class="text-danger">:message</small>') !!}
                        <br>
                        {!! Form::submit('Save Tag Manager', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_tag_manager_btn')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Conversion pixel edit-->
<div class="modal fade" id="conversion_pixel_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Conversion Pixel</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateConversionPixel'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the text in below text field and save to update the site conversion pixel scripts.</small></i></h5>
                        <br>
                        <div class="row conversion-pixel-error" style="text-align: -webkit-center;"></div>
                        {!! Form::textarea('conversion_pixel_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->conversion_pixel, array('placeholder'=>'Enter Conversion pixel text', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'conversion_pixel_input', 'rows'=>'5')) !!}
                        {!! $errors->first('conversion_pixel_input', '<small class="text-danger">:message</small>') !!}
                        <br>
                        {!! Form::submit('Save Conversion Pixel', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'id'=>'submit_conversion_pixel_btn')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Changing Prospectus Text on all pages -->
<div class="modal fade" id="change_prospectus_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Prospectus Text</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateProspectusText'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the text in below text field and save to update the prospectus text for the website.</small></i></h5>
                        <br>
                        <div class="row prospectus-text-error" style="text-align: -webkit-center;"></div>
                        {!! Form::text('prospectus_text_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->prospectus_text, array('placeholder'=>'Enter Prospectus Text', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'prospectus_text_input')) !!}
                        <br>
                        {!! Form::submit('Save Prospectus Text', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'2', 'style'=>'margin-bottom: 20px; margin-top: 10px;')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Changing AFSL, licensee name, CAR number -->
<div class="modal fade" id="change_legal_details_edit_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Legal Details</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateLegalDetails'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the text in below text field and save to update the legal details for the website.</small></i></h5>
                        <div class="row " style="text-align: -webkit-center;"></div>
                        <label for="licensee_name_input" style="text-align: left;" class="pull-left">Licensee Name:</label>
                        {!! Form::text('licensee_name_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->licensee_name, array('placeholder'=>'Enter Licensee Name', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'licensee_name_input', 'required' => 'required')) !!}
                        <br>
                        <label for="afsl_no" style="text-align: left;" class="pull-left">AFSL Number:</label>
                        {!! Form::text('afsl_no_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->afsl_no, array('placeholder'=>'Enter AFSL Number', 'class'=>'form-control ', 'tabindex'=>'2', 'id'=>'afsl_no', 'required' => 'required')) !!}
                        <br>
                        <label for="car_no" style="text-align: left;" class="pull-left">CAR Number:</label>
                        {!! Form::text('car_no_input', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->car_no, array('placeholder'=>'Enter CAR Number', 'class'=>'form-control ', 'tabindex'=>'3', 'id'=>'car_no', 'required' => 'required')) !!}
                        <br>
                        {!! Form::submit('Save Details', array('class'=>'btn btn-primary col-md-4 col-md-offset-4', 'tabindex'=>'4', 'style'=>'margin-bottom: 20px; margin-top: 10px;', 'required' => 'required')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Changing Konkrete Bonus Allocation -->
<div class="modal fade" id="change_konkrete_bonus_allocation_modal" role="dialog">
    <div class="modal-dialog" style="margin-top: 10%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="modal_close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Konkrete Bonus Allocation</h4>
            </div>
            <div class="modal-body">
                <div class="row text-center" id="modal_body_container">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::open(array('route'=>['configuration.updateKonkreteAllocationChanges'], 'method'=>'POST', 'class'=>'form-horizontal', 'role'=>'form')) !!}
                        <h5><i><small>Enter the Konkrete amount you would like to allocate to users on this site.</small></i></h5>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="daily_login_bonus" style="text-align: left;" class="pull-left">Daily Login Bonus:</label>
                                {!! Form::input('number', 'daily_login_bonus_konkrete', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete, array('placeholder'=>'Enter konkrete amount for daily login bonus', 'class'=>'form-control ', 'tabindex'=>'1', 'id'=>'daily_login_bonus', 'required' => 'required', 'type'=>'number', 'min'=>'1', 'title'=>'Enter konkrete amount for daily login bonus')) !!}
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="user_sign_up" style="text-align: left;" class="pull-left">User Sign Up:</label>
                                {!! Form::input('number', 'user_sign_up_konkrete', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete, array('placeholder'=>'Enter konkrete amount for user sign up', 'class'=>'form-control ', 'tabindex'=>'2', 'id'=>'user_sign_up', 'required' => 'required', 'min'=>'1', 'title'=>'Enter konkrete amount for user sign up')) !!}
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="kyc_upload" style="text-align: left;" class="pull-left">KYC Submission:</label>
                                {!! Form::input('number', 'kyc_upload_konkrete', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->kyc_upload_konkrete, array('placeholder'=>'Enter konkrete amount given on KYC upload', 'class'=>'form-control ', 'tabindex'=>'3', 'id'=>'kyc_upload', 'required' => 'required', 'min'=>'1', 'title'=>'Enter konkrete amount given on KYC upload')) !!}
                                <br>
                            </div>
                            <div class="col-md-6">
                                <label for="kyc_approval" style="text-align: left;" class="pull-left">KYC Approval:</label>
                                {!! Form::input('number', 'kyc_approval_konkrete', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->kyc_approval_konkrete, array('placeholder'=>'Enter konkrete amount given on KYC approval', 'class'=>'form-control ', 'tabindex'=>'4', 'id'=>'kyc_approval', 'required' => 'required', 'min'=>'1', 'title'=>'Enter konkrete amount given on KYC approval')) !!}
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="referral" style="text-align: left;" class="pull-left">Referrer:</label>
                                {!! Form::input('number', 'referrer_konkrete', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->referrer_konkrete, array('placeholder'=>'Enter konkrete amount for referrer', 'class'=>'form-control ', 'tabindex'=>'5', 'id'=>'referral', 'required' => 'required', 'title'=>'Enter konkrete amount for referrer')) !!}
                                <br>
                            </div>
                            <div class="col-md-6">
                                <label for="referee" style="text-align: left;" class="pull-left">Referee:</label>
                                {!! Form::input('number', 'referee_konkrete', App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->referee_konkrete, array('placeholder'=>'Enter konkrete amount for referee', 'class'=>'form-control ', 'tabindex'=>'6', 'id'=>'referral', 'required' => 'required', 'min'=>'1', 'title'=>'Enter konkrete amount for referee')) !!}
                                <br>
                            </div>
                        </div>

                        {!! Form::submit('Save Konkrete Amounts', array('class'=>'btn btn-primary col-md-6 col-md-offset-3', 'tabindex'=>'7', 'style'=>'margin-bottom: 20px; margin-top: 10px;')) !!}
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
        $('.change-tag-manager-btn').click(function(){
            $('#tag_manager_edit_modal').modal({
                'show':true,
                'backdrop':false,
            });
        });

        $('.change-conversion-pixel-btn').click(function(){
            $('#conversion_pixel_edit_modal').modal({
                'show':true,
                'backdrop':false,
            });
        });

        $('#submit_conversion_pixel_btn').click(function(e){
            if($('#conversion_pixel_input').val()==''){
                e.preventDefault();
                $('.conversion-pixel-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Conversion Pixel required</h6></div>')
            }
        });

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

        $('.change-site-name-btn').click(function(){
            $('#site_name_edit_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#site_name_input').select();
        });

        $('#submit_website_name_btn').click(function(e){
            if($('#site_name_input').val() == ''){
                e.preventDefault();
                $('.site-name-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Website name field is empty</h6></div>')
            }
        });
        $('.change-mailer-email-btn').click(function(){
            $('#mailer_email_edit_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#site_name_input').select();
        });

        $('#submit_website_name_btn').click(function(e){
            if($('#site_name_input').val() == ''){
                e.preventDefault();
                $('.site-name-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Website name field is empty</h6></div>')
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
            $('.favicon-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>No Image selected</h6></div>');
        }
        else{
            var formData = new FormData();
            formData.append('favicon_image_url', $('#favicon_image_url')[0].files[0]);
            $('.loader-overlay').show();
            $.ajax({
                url: '/configuration/updateFavicon',
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
                var imgPath = data.fileName;
                var str1 = $('<div class="col-sm-9"><img src="../../'+imgPath+'" width="530" id="image_cropbox" style="max-width:none !important"><br><span style="font-style: italic; font-size: 13px"><small>Select The Required Area To Crop Logo.</small></span></div><div class="col-sm-2" id="preview_favicon_img" style="float: right;"><img width="530" src="../../'+imgPath+'" id="preview_image"></div>');

                $('#image_cropbox_container').html(str1);
                $('#favicon_edit_modal').modal('hide');
                $('#image_crop_modal').modal({
                    'show': true,
                    'backdrop': false,
                });

                            $('#image_crop').val(imgPath); //set hidden image value
                            $('#image_crop').attr('action', 'favicon image');
                            var target_width = 150;
                            var target_height = 150;
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
                          $('.loader-overlay').hide();
                          $('#favicon_image_url, #favicon_image_name').val('');
                          $('.favicon-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>'+data.message+'</h6></div>');
                      }
                  });
        }
        performCropOnImage();
    });
        // Additional functionality functions
        editProspectusText();
        editClientName();
        editVisibilityOfSiteConfigItems();
        editProjectInterestEmbedLink();
        editLegalDetails();
        changeKonkreteBonusAllocation();
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
            var hiwImgAction = $('#image_action').val();
            console.log(imageName+'|'+xValue+'|'+yValue+'|'+wValue+'|'+hValue);
            $.ajax({
                url: '/configuration/cropUploadedImage',
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
                    hiwImgAction: hiwImgAction,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done(function(data){
                console.log(data);
                if(data.status){
                    $('#image_crop').val(data.imageSource);
                    location.reload('/');
                }
                else{
                    $('.loader-overlay').hide();
                    $('#image_crop_modal').modal('toggle');
                    if (imgAction == 'favicon image'){
                     $('#favicon_image_url, #favicon_image_name').val('');
                 }
                 alert(data.message);
             }

         });
        });
    }

    function editProspectusText(){
        $('.change-prospectus-text-btn').click(function(){
            $('#change_prospectus_edit_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#prospectus_text_input').select();
        });
    }

    function editLegalDetails(){
        $('.change-legal-details-btn').click(function(){
            $('#change_legal_details_edit_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#licensee_name_input').select();
        });
    }

    function changeKonkreteBonusAllocation(){
        $('.change-konkrete-bonus-allocation-btn').click(function(){
            $('#change_konkrete_bonus_allocation_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#daily_login_bonus').select();
        });
    }

    function editClientName(){
        $('.change-client-name-btn').click(function(){
            $('#client_name_edit_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#client_name_input').select();
        });

        $('#submit_client_name_btn').click(function(e){
            if($('#client_name_input').val() == ''){
                e.preventDefault();
                $('.client-name-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Client name field is empty</h6></div>')
            }
        });
    }

    function editVisibilityOfSiteConfigItems(){
        $('.common-switch-class').bootstrapSwitch();
        $('.common-switch-class').on('switchChange.bootstrapSwitch', function () {
            var setVal = $(this).val() == 1? 0 : 1;
            $(this).val(setVal);
            var checkValue = $(this).val();
            var action = $(this).attr('action');
            $('.loader-overlay').show();
            $.ajax({
                url: '/configuration/edit/visibilityOfSiteItems',
                type: 'POST',
                dataType: 'JSON',
                data: {checkValue, action},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done(function(data){
                console.log(data);
                $('.loader-overlay').hide();
            });
        });
    }

    function editProjectInterestEmbedLink(){
        $('.change-intrest-embed-link-btn').click(function(){
            $('#embedd_link_edit_modal').modal({
                'show': true,
                'backdrop': false,
            });
            $('#interest_link_input').select();
        });

        $('#submit_interest_link_btn').click(function(e){
            if($('#interest_link_input').val() == ''){
                e.preventDefault();
                $('.interest-link-error').html('<div style="color:#ea0000; border-radius:5px; width:80%"><h6>Interest Link field is empty</h6></div>')
            }
        });
    }
</script>
@stop
