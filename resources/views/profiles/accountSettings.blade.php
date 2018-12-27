@extends('layouts.app')

@section('template_title')
	{{ $user->name }}'s Profile
@endsection

@section('template_fastload_css')

	#map-canvas{
		min-height: 300px;
		height: 100%;
		width: 100%;
	}

@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading tableHeaderBlue">

						Account Settings

					</div>
					<div class="row vert-offset-top-2 vert-offset-bottom-2">
						<div class="col-md-5 col-xs-4">
							
							
						</div>

						<div class="col-md-4 col-xs-5">
							<strong>Your industries</strong><br>
							<form action="/updateAccountSettings" mehtod="POST">
							{!! Form::open(['url' => 'updateAccountSettings']) !!}
								
								
								@foreach($industries as $ind)
									@if(in_array($ind->number, $userIndustries) )

										<input type="checkbox" name="{{$ind->name}}" value="{{$ind->number}}" checked> {{$ind->name}}<br>
									@else
										<input type="checkbox" name="{{$ind->name}}" value="{{$ind->number}}"> {{$ind->name}}<br> 
									@endif

								@endforeach	
								<button type="submit" class="btn btn-success">Update</button>
							{!! Form::close() !!}
						</div>

						<div class="col-md-3 col-xs-3"></div>
						
					</div>
				</div>
			</div>
		</div>

<script type="text/javascript" >
	$(document).ready(function(){
			$('#pw_save_trigger').click(function(){
			$('#submitChangePassForm').submit();
		});
	});
</script>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading tableHeaderBlue">

						Change Password

					</div>
					<div class="row vert-offset-top-2 vert-offset-bottom-2">
						<div class="col-md-12 col-md-offset-3  col-xs-offset-1">
							<h3 class="margin-bottom-1">
								{{ trans('profile.changePwTitle') }}
							</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-offset-3 col-xs-offset-2"></div>
						<div class="col-md-6 col-xs-10">
						<form id="submitChangePassForm" method="POST" action="/updateUserPassword" accept-charset="UTF-8" id="passwordChangeForm" autocomplete="new-password">

						{{Form::token()}}
												    <div class="pw-change-container margin-bottom-2">

														<div class="form-group has-feedback row {{ $errors->has('password') ? ' has-error ' : '' }}">
														  	{!! Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 control-label')); !!}
														  	<div class="col-md-12 col-xs-12">
																{!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'), 'autocomplete' => 'new-password')) !!}
														        @if ($errors->has('password'))
														            <span class="help-block">
														                <strong>{{ $errors->first('password') }}</strong>
														            </span>
														        @endif
														  	</div>
														</div>

												        <div class="form-group has-feedback row {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">
												          	{!! Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-4 control-label')); !!}
												          	<div class="col-md-12 col-xs-12">
												              	{!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))) !!}
																<span id="pw_status"></span>
																@if ($errors->has('password_confirmation'))
																    <span class="help-block">
																        <strong>{{ $errors->first('password_confirmation') }}</strong>
																    </span>
																@endif
												          	</div>
												        </div>
												    </div>

												    <div class="form-group row">
													    <div class="col-md-9 col-xs-9 col-md-offset-3">
															{!! Form::button(
																'<i class="fa fa-fw fa-save" aria-hidden="true"></i> ' . trans('profile.submitPWButton'),
																 array(
																	'class' 		 	=> 'btn btn-warning',
																	'id' 				=> 'pw_save_trigger',
																	'disabled'			=> true,
																	'type' 			 	=> 'button',
																	'data-submit'       => trans('profile.submitButton'),
																	'data-target' 		=> '#confirmForm',
																	'data-modalClass' 	=> 'modal-warning',
																	'data-toggle' 		=> 'modal',
																	'data-title' 		=> trans('modals.edit_user__modal_text_confirm_title'),
																	'data-message' 		=> trans('modals.edit_user__modal_text_confirm_message')
															)) !!}
														</div>
													</div>
												{!! Form::close() !!}
						</form>
						</div>
						<div class="col-md-4 col-xs-4"></div>
					</div>
				</div>
			</div>
		</div>
		

		</div>
	</div>

	<script>

		$("#password_confirmation").keyup(function() {
			checkPasswordMatch();
		});

		$("#password, #password_confirmation").keyup(function() {
			enableSubmitPWCheck();
		});

		$('#password, #password_confirmation').hidePassword(true);

		$('#password').password({
			shortPass: 'The password is too short',
			badPass: 'Weak - Try combining letters & numbers',
			goodPass: 'Medium - Try using special charecters',
			strongPass: 'Strong password',
			containsUsername: 'The password contains the username',
			enterPass: false,
			showPercent: false,
			showText: true,
			animate: true,
			animateSpeed: 50,
			username: false, // select the username field (selector or jQuery instance) for better password checks
			usernamePartialMatch: true,
			minimumLength: 6
		});
		

		function checkPasswordMatch() {
		    var password = $("#password").val();
		    var confirmPassword = $("#password_confirmation").val();
		    if (password != confirmPassword) {
		        $("#pw_status").html("Passwords do not match!");
		    }
		    else {
		        $("#pw_status").html("Passwords match.");
		    }
		}

		function enableSubmitPWCheck() {
		    var password = $("#password").val();
		    var confirmPassword = $("#password_confirmation").val();
		    var submitChange = $('#pw_save_trigger');
		    if (password != confirmPassword) {
		       	submitChange.attr('disabled', true);
		    }
		    else {
		        submitChange.attr('disabled', false);
		    }
		}

		$(document).ready(function(){
			$('#pw_save_trigger').click(function(){
				alert();
				$('#submitChangePassForm').submit();
			});
		});

	</script>

@endsection

@section('footer_scripts')

	@include('scripts.google-maps-geocode-and-map')

@endsection