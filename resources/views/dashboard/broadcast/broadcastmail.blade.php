@extends('layouts.main')

@section('title-section')
Broadcast | Dashboard | @parent
@stop

@section('meta')
<meta name="csrf-token" content="{{csrf_token()}}" />
@endsection

@section('css-section')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
<!-- Summernote -->
{!! Html::style('/assets/plugins/summernote/summernote.css') !!}
<style type="text/css">
	
</style>
@stop

@section('content-section')
<div class="container">
	<br>
	<div class="row">
		<div class="col-md-2">
			@include('dashboard.includes.sidebar', ['active'=>5])
		</div>
		<div class="col-md-10">
            <section>
                @if (Session::has('message'))
                {!! Session::get('message') !!}
                @endif
                <div class="row text-center"><h2>All Investors</h2></div>
                <div class="row" style="border: 1px solid #ddd;max-height: 200px;overflow: auto;">
                    <table class="table">
                    <thead style="background: #ddd;">
                        <tr>
                            <th><input class="select-all-emails" type="checkbox" name="select_all_emails" id="select_all_emails" checked></th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $emailStr=array(); ?>
                        @if(count($investors) == 0)
                        <tr class="text-center"><td colspan="4"><small style="color: #e50000">There are no Investors available</small></td></tr>
                        @else
                            @foreach($investors as $investor)
                            <tr>
                                <td><input class="email-select select-this-email" type="checkbox" name="" id="" value="{{$investor->user->email}}" checked></td>
                                <td>{{$investor->user->first_name}}</td>
                                <td>{{$investor->user->last_name}}</td>
                                <td>{{$investor->user->email}}</td>
                            </tr>
                            <?php array_push($emailStr, $investor->user->email); ?>
                            @endforeach
                            <?php $emailStr = trim(implode(",", $emailStr)); ?>
                        @endif
                    </tbody>
                    </table>
                </div>

                <div class="row text-center"><h2>Broadcast Mail</h2></div>
                <div class="row" style="margin-bottom: 5%;">
                    <form action="{{route('dashboard.mail.broadcast')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="email_string" id="email_string" value="{{$emailStr}}">
                        <small>*Subject</small><br>
                        <input class="form-control" type="text" name="mail_subject">
                        {!! $errors->first('mail_subject', '<small class="text-danger">:message</small>') !!}
                        <br>
                        <small>*Content</small>
                        <textarea class="form-control broadcast-email-body" rows="5" name="mail_content"></textarea><br>
                        <div class="text-right"><input class="btn btn-primary" type="submit" name="broadcast_mail" id="broadcast_mail" value="Send Mail"></div>
                    </form>
                </div>
            </section>	
        </div>
    </div>
</div>
@stop

@section('js-section')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>
<!-- Summernote Email editor -->
{!! Html::script('/assets/plugins/summernote/summernote.min.js') !!}

<script type="text/javascript">
	$(document).ready(function(){
        $('#select_all_emails').change(function(e){
            if($(this).is(":checked")){
                console.log('checked');
                $('.email-select').prop('checked', true);
            }
            else{
                console.log('unchecked');
                $('.email-select').prop('checked', false);
            }
        });

        
        $('.broadcast-email-body').summernote({
            height:300,
        });

        // Show confirm box before email broadcasting
        // Suppress sending mail if there are no emails selected from given list
        $('#broadcast_mail').click(function(e){
            if($('#email_string').val() == ""){
                e.preventDefault();
                alert('select atleast one investor from the list.');
            } 
            else{
                if (!confirm("Are you sure, you wanto to broadcast this message?")) {
                    e.preventDefault();
                }
            }
        });

        createMailList();

    });

    function createMailList(){
        // Select or deselect all email address
        $('.select-all-emails').click(function(e){
            if($(this).is(":checked")){
                var emails = [];
                $('.select-this-email').each(function() {
                    emails.push($(this).val());
                });
                console.log(emails.join(','));
                $('#email_string').val(emails.join(','));
            }
            else{
                $('#email_string').val("");
            }
        });
        // Select checked email address
        $('.select-this-email').click(function(e){
            var emails = [];
            $('.select-this-email').each(function() {
                if($(this).is(":checked")){
                    emails.push($(this).val());
                }
            });
            console.log(emails.join(','));
            $('#email_string').val(emails.join(','));
        });
    }

</script>
@stop