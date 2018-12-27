<?php $__env->startSection('template_title'); ?>
	<?php echo e($user->name); ?>'s Profile
<?php $__env->stopSection(); ?>

<?php $__env->startSection('template_fastload_css'); ?>

	#map-canvas{
		min-height: 300px;
		height: 100%;
		width: 100%;
	}

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
							<?php echo Form::open(['url' => 'updateAccountSettings']); ?>

								
								
								<?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if(in_array($ind->number, $userIndustries) ): ?>

										<input type="checkbox" name="<?php echo e($ind->name); ?>" value="<?php echo e($ind->number); ?>" checked> <?php echo e($ind->name); ?><br>
									<?php else: ?>
										<input type="checkbox" name="<?php echo e($ind->name); ?>" value="<?php echo e($ind->number); ?>"> <?php echo e($ind->name); ?><br> 
									<?php endif; ?>

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
								<button type="submit" class="btn btn-success">Update</button>
							<?php echo Form::close(); ?>

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
								<?php echo e(trans('profile.changePwTitle')); ?>

							</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-offset-3 col-xs-offset-2"></div>
						<div class="col-md-6 col-xs-10">
						<form id="submitChangePassForm" method="POST" action="/updateUserPassword" accept-charset="UTF-8" id="passwordChangeForm" autocomplete="new-password">

						<?php echo e(Form::token()); ?>

												    <div class="pw-change-container margin-bottom-2">

														<div class="form-group has-feedback row <?php echo e($errors->has('password') ? ' has-error ' : ''); ?>">
														  	<?php echo Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 control-label'));; ?>

														  	<div class="col-md-12 col-xs-12">
																<?php echo Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'), 'autocomplete' => 'new-password')); ?>

														        <?php if($errors->has('password')): ?>
														            <span class="help-block">
														                <strong><?php echo e($errors->first('password')); ?></strong>
														            </span>
														        <?php endif; ?>
														  	</div>
														</div>

												        <div class="form-group has-feedback row <?php echo e($errors->has('password_confirmation') ? ' has-error ' : ''); ?>">
												          	<?php echo Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-4 control-label'));; ?>

												          	<div class="col-md-12 col-xs-12">
												              	<?php echo Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))); ?>

																<span id="pw_status"></span>
																<?php if($errors->has('password_confirmation')): ?>
																    <span class="help-block">
																        <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
																    </span>
																<?php endif; ?>
												          	</div>
												        </div>
												    </div>

												    <div class="form-group row">
													    <div class="col-md-9 col-xs-9 col-md-offset-3">
															<?php echo Form::button(
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
															)); ?>

														</div>
													</div>
												<?php echo Form::close(); ?>

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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>

	<?php echo $__env->make('scripts.google-maps-geocode-and-map', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>