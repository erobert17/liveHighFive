@extends('layouts.app')


@section('content')

	<div class="container">
		
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading tableHeaderBlue">


						<div class="tab-content">
							<span class="tab-pane active edit_profile">
								Company Branding
								
							</span>
							
						</div>

					</div>
					<div class="panel-body">
						
						<div class="tab-content">

									<div class="tab-pane fade in active edit_profile">
										<div class="row">
											<div class="col-sm-12">
												<strong style="float:left;">Logo</strong>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
				                                <form action="/uploadCompanyLogo" method="POST" class="dropzone needsclick dz-clickable" id="avatarDropzone" style="min-height:181px; border: 1px dashed rgba(0, 0, 0, 0.3); background: rgb(234, 234, 234); min-height: 241px;" >
				                                                                    
				                                <input type="hidden" name="userID" value="{{ $user->id }}" >
				                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                                
				                                    <?php 
				                                        $ch = curl_init('http://www.growyourleads.com/uploads/users/id/' .Auth::user()->id. '/avatar/avatar.png');    
				                                        
				                                        curl_setopt($ch, CURLOPT_NOBODY, true);
				                                        curl_exec($ch);
				                                        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				                                        
				                                        $backgroundExists = '';
				                                        if($code == 200){
				                                           $backgroundExists = true;
				                                           echo '<img id="newBackground" class="user-avatar" style="border-radius: 0px !important;" width="100"  src="http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/avatar/avatar.png" />';   
				                                        }else{
				                                            $backgroundExists = false;
				                                        }
				                                        
				                                        curl_close($ch);

				                                        ?>
				                                    

				                                  <div class="dz-message needsclick" style="display:block !important;">
				                                    Drop files here or click to upload.<br>
				                                    
				                                  </div>


				                                </form>
				                                <center>Not seeing changes? Try <a href="http://www.refreshyourcache.com/en/home/" target="_blank">resetting</a> your browser cache. </center>

				                            </div>
										</div>
										
										<form action="/updateCompanyBranding" method="POST">

											<input type="hidden" name="userID" value="{{ $user->id }}" >
				                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

											<div class="row">
												<div class="col-md-12 vert-offset-top-2">
													<div class="form-group has-feedback row ">
										                <label class="col-md-3 control-label">Company</label>
										                <div class="col-md-9">
										                  	<div class="input-group">
										                    	<div class="input-group">
										                    	<input id="company" class="form-control" placeholder="Company" name="company" type="text" value="{{$user->company}}">
										                    	<label class="input-group-addon" for="company"><i class="fa fa-building-o" aria-hidden="true"></i></label>
										                  		</div>
										                  	</div>
										                  </div>
										            </div>
										        </div>
											</div>

											<div class="form-group has-feedback row ">
								                <label for="url" class="col-md-3 control-label">Website Url</label>
								                <div class="col-md-9">
								                  	<div class="input-group">
								                    	<div class="input-group">
									                    	<input id="url" class="form-control" placeholder="CompanyUrl.com" name="websiteUrl" type="text" value="{{$user->companyUrl}}">
									                    	<label class="input-group-addon" for="url"><i class="fa fa-link" aria-hidden="true"></i></label>
								                  		</div>
								                  	</div>
								                  									                </div>
								            </div>

										    <div class="row">
												<div class="col-md-9 col-md-offset-3">
													<button class="btn btn-success" type="submit" ><i class="fa fa-fw fa-save" aria-hidden="true"></i> Save Changes</button>

										        </div>
										    </div>

										</form>

									</div>

									

									<div class="tab-pane fade edit_account">

										<ul class="nav nav-pills nav-justified margin-bottom-3">
											<li class="bg-info change-pw active">
												<a data-toggle="pill" href="#changepw" class="warning-pill-trigger">
													Change Password
												</a>
											</li>
											<li class="bg-info delete-account">
												<a data-toggle="pill" href="#deleteAccount" class="danger-pill-trigger">
													Delete Account
												</a>
											</li>
										</ul>

										<div class="tab-content">

										    <div id="changepw" class="tab-pane fade in active">

												<h3 class="margin-bottom-1">
													Change Password
												</h3>

												<form method="POST" action="http://growyourleads.com/profile/{{ $user->id }}/updateUserPassword" accept-charset="UTF-8" autocomplete="new-password">

													<input type="hidden" name="userID" value="{{ $user->id }}" >
				                                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
				                                

												    <div class="pw-change-container margin-bottom-2">

														<div class="form-group has-feedback row ">
														  	<label for="password" class="col-md-3 control-label">Password</label>
														  	<div class="col-md-9">
																<div class="hideShowPassword-wrapper" style="position: relative; display: block; vertical-align: baseline; margin: 0px;"><input id="password" class="form-control hideShowPassword-field" placeholder="Password" autocomplete="new-password" name="password" type="password" value="" style="margin: 0px; padding-right: 46px;"><div class="pass-wrapper" style="display: none;"><div class="pass-graybar"><div class="pass-colorbar"></div></div><span class="pass-text"></span></div><button type="button" role="button" aria-label="Show Password" title="Show Password" tabindex="0" class="hideShowPassword-toggle hideShowPassword-toggle-show" aria-pressed="false" style="position: absolute; right: 0px; top: 50%; margin-top: -22px;">Show</button></div>
														        														  	</div>
														</div>

												        <div class="form-group has-feedback row ">
												          	<label for="password_confirmation" class="col-md-3 control-label">Confirm Password</label>
												          	<div class="col-md-9">
												              	<div class="hideShowPassword-wrapper" style="position: relative; display: block; vertical-align: baseline; margin: 0px;"><input id="password_confirmation" class="form-control hideShowPassword-field" placeholder="Confirm Password" name="password_confirmation" type="password" value="" style="margin: 0px; padding-right: 46px;"><button type="button" role="button" aria-label="Show Password" title="Show Password" tabindex="0" class="hideShowPassword-toggle hideShowPassword-toggle-show" aria-pressed="false" style="position: absolute; right: 0px; top: 50%; margin-top: -22px;">Show</button></div>
																<span id="pw_status"></span>
																												          	</div>
												        </div>
												    </div>

												    <div class="form-group row">
													    <div class="col-md-9 col-md-offset-3">
															<button class="btn btn-warning" id="pw_save_trigger" disabled="" type="button" data-submit="Save Changes" data-target="#confirmForm" data-modalclass="modal-warning" data-toggle="modal" data-title="Confirm Save" data-message="Please confirm your changes."><i class="fa fa-fw fa-save" aria-hidden="true"></i> Update Password</button>
														</div>
													</div>
												</form>

	    									</div>

										    <div id="deleteAccount" class="tab-pane fade">

										      	<h3 class="margin-bottom-1 text-center text-danger">
										      		Delete Account
										      	</h3>
										      	<p class="margin-bottom-2 text-center">
													<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
														<strong>Deleting</strong> your account is <u><strong>permanent</strong></u> and <u><strong>cannot</strong></u> be undone.
													<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
										      	</p>

												<hr>

												<div class="row">
													<div class="col-sm-6 col-sm-offset-3 margin-bottom-3 text-center">

														<form method="POST" action="http://growyourleads.com/profile/102/deleteUserAccount" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="fLJWuSAWbJbZXqfzBD3wvDbfA1gBDUp4GMlcVDHt">

															<div class="btn-group btn-group-vertical margin-bottom-2" data-toggle="buttons">
																<label class="btn no-shadow" for="checkConfirmDelete">
																	<input type="checkbox" name="checkConfirmDelete" id="checkConfirmDelete">
																	<i class="fa fa-square-o fa-fw fa-2x"></i>
																	<i class="fa fa-check-square-o fa-fw fa-2x"></i>
																	<span class="margin-left-2"> Confirm Account Deletion</span>
																</label>
															</div>

														    <button class="btn btn-block btn-danger" id="delete_account_trigger" disabled="" type="button" data-toggle="modal" data-submit="Delete My Account" data-target="#confirmForm" data-modalclass="modal-danger" data-title="Confirm Account Deletion" data-message="Are you sure you want to delete your account?"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Delete My Account</button>

														</form>

													</div>
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
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-info">
					<div class="panel-heading">
						
						<div class="tab-content">
							<span class="tab-pane active edit_profile">
								Real Estate Branding
								
							</span>
						</div>

					</div>
					<div class="panel-body">

						
							
								<div class="tab-content">



									<div class="tab-pane fade edit_settings active in">

										<div class="form-group has-feedback row ">
								                <label for="name" class="col-md-3 control-label">User Image</label>
								                <div class="col-md-12">
								                  	<div class="input-group">
								                    	<form action="/uploadUserAvatar" method="POST" class="dropzone needsclick dz-clickable" id="avatarDropzone" style="min-height:181px; border: 1px dashed rgba(0, 0, 0, 0.3); background: rgb(234, 234, 234); min-height: 241px;" >
											                                                                    
															<input type="hidden" name="userID" value="{{ $user->id }}" >
															<input type="hidden" name="_token" value="{{ csrf_token() }}">
															                                
															<?php 
															    $ch = curl_init('http://www.growyourleads.com/uploads/users/id/' .Auth::user()->id. '/avatar/userImg.png');    
															                                        
															    curl_setopt($ch, CURLOPT_NOBODY, true);
															    curl_exec($ch);
															    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
															                                        
															    $backgroundExists = '';
															    if($code == 200){
															       $backgroundExists = true;
															    	echo '<img id="newBackground" class="user-avatar" style="border-radius: 0px !important;" width="100"  src="http://growyourleads.com/uploads/users/id/' .Auth::user()->id. '/avatar/userImg.png" />';   
															    }else{
															        $backgroundExists = false;
															    }
															                                        
															    curl_close($ch);

															?>
															                                    

															<div class="dz-message needsclick" style="display:block !important;">
															        Drop files here or click to upload.<br>
															                                    
															</div>


														</form>
								                  </div>

								                </div>
								        </div>

										<form method="POST" action="/updateUserBranding" >

											<input type="hidden" name="userID" value="{{ $user->id }}" >
				                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                                

								            <div class="form-group has-feedback row ">
								                <label for="name" class="col-md-3 control-label">Full Name</label>
								                <div class="col-md-9">
								                  	<div class="input-group">
								                    	<input id="name" class="form-control" placeholder="Username" name="name" type="text" value="{{$user->name}}">
								                    	<label class="input-group-addon" for="name"><i class="fa fa-fw fa-user }}" aria-hidden="true"></i></label>
								                  	</div>
								                </div>
								            </div>

								            <div class="form-group has-feedback row ">
								                <label for="email" class="col-md-3 control-label">E-mail</label>
								                <div class="col-md-9">
								                  	<div class="input-group">
								                    	<input id="email" class="form-control" placeholder="User Email" name="email" type="text" value="{{$user->email}}">
								                    	<label class="input-group-addon" for="email"><i class="fa fa-fw fa-envelope " aria-hidden="true"></i></label>
								                  	</div>
								                </div>
								            </div>

								            <div class="form-group has-feedback row ">
								                <label for="first_name" class="col-md-3 control-label">First Name</label>
								                <div class="col-md-9">
								                  	<div class="input-group">
								                    	<input id="first_name" class="form-control" placeholder="First Name" name="first_name" type="text" value="{{$user->first_name}}">
								                    	<label class="input-group-addon" for="first_name"><i class="fa fa-fw fa-user" aria-hidden="true"></i></label>
								                  	</div>
								                  									                </div>
								            </div>

								            <div class="form-group has-feedback row ">
								                <label for="last_name" class="col-md-3 control-label">Last Name</label>
								                <div class="col-md-9">
								                  	<div class="input-group margin-bottom-1">
								                    	<input id="last_name" class="form-control" placeholder="Last Name" name="last_name" type="text" value="{{$user->last_name}}">
								                    	<label class="input-group-addon" for="last_name"><i class="fa fa-fw fa-user" aria-hidden="true"></i></label>
								                  	</div>
								                  									                </div>
								            </div>

								            

								          	<div class="form-group has-feedback row ">
								                <label for="phone" class="col-md-3 control-label">Phone</label>
								                <div class="col-md-9">
								                  	<div class="input-group">
								                    	<div class="input-group">
									                    	<input id="phone" class="form-control" placeholder="Phone" name="Phone" type="text" value="{{$user->phone}}">
									                    	<label class="input-group-addon" for="phone"><i class="fa fa-phone" aria-hidden="true"></i></label>
									                  	</div>
								                  	</div>
								                </div>
								            </div>

										    <div class="form-group row">
											    <div class="col-md-9 col-md-offset-3">
													<button class="btn btn-success" type="submit" ><i class="fa fa-fw fa-save" aria-hidden="true"></i> Save Changes</button>
												</div>
											</div>

										</form>

									</div>

									<div class="tab-pane fade edit_account">

										<ul class="nav nav-pills nav-justified margin-bottom-3">
											<li class="bg-info change-pw active">
												<a data-toggle="pill" href="#changepw" class="warning-pill-trigger">
													Change Password
												</a>
											</li>
											<li class="bg-info delete-account">
												<a data-toggle="pill" href="#deleteAccount" class="danger-pill-trigger">
													Delete Account
												</a>
											</li>
										</ul>

										<div class="tab-content">

										    <div id="changepw" class="tab-pane fade in active">

												<h3 class="margin-bottom-1">
													Change Password
												</h3>

												<form method="POST" action="http://growyourleads.com/profile/{{ $user->id }}/updateUserPassword" accept-charset="UTF-8" autocomplete="new-password"><input name="_method" type="hidden" value="PUT"><input name="_token" type="hidden" value="fLJWuSAWbJbZXqfzBD3wvDbfA1gBDUp4GMlcVDHt">

												    <div class="pw-change-container margin-bottom-2">

														<div class="form-group has-feedback row ">
														  	<label for="password" class="col-md-3 control-label">Password</label>
														  	<div class="col-md-9">
																<div class="hideShowPassword-wrapper" style="position: relative; display: block; vertical-align: baseline; margin: 0px;"><input id="password" class="form-control hideShowPassword-field" placeholder="Password" autocomplete="new-password" name="password" type="password" value="" style="margin: 0px; padding-right: 46px;"><div class="pass-wrapper" style="display: none;"><div class="pass-graybar"><div class="pass-colorbar"></div></div><span class="pass-text"></span></div><button type="button" role="button" aria-label="Show Password" title="Show Password" tabindex="0" class="hideShowPassword-toggle hideShowPassword-toggle-show" aria-pressed="false" style="position: absolute; right: 0px; top: 50%; margin-top: -22px;">Show</button></div>
														        														  	</div>
														</div>

												        <div class="form-group has-feedback row ">
												          	<label for="password_confirmation" class="col-md-3 control-label">Confirm Password</label>
												          	<div class="col-md-9">
												              	<div class="hideShowPassword-wrapper" style="position: relative; display: block; vertical-align: baseline; margin: 0px;"><input id="password_confirmation" class="form-control hideShowPassword-field" placeholder="Confirm Password" name="password_confirmation" type="password" value="" style="margin: 0px; padding-right: 46px;"><button type="button" role="button" aria-label="Show Password" title="Show Password" tabindex="0" class="hideShowPassword-toggle hideShowPassword-toggle-show" aria-pressed="false" style="position: absolute; right: 0px; top: 50%; margin-top: -22px;">Show</button></div>
																<span id="pw_status"></span>
																												          	</div>
												        </div>
												    </div>

												    <div class="form-group row">
													    <div class="col-md-9 col-md-offset-3">
															<button class="btn btn-warning" id="pw_save_trigger" disabled="" type="button" data-submit="Save Changes" data-target="#confirmForm" data-modalclass="modal-warning" data-toggle="modal" data-title="Confirm Save" data-message="Please confirm your changes."><i class="fa fa-fw fa-save" aria-hidden="true"></i> Update Password</button>
														</div>
													</div>
												</form>

	    									</div>

										    <div id="deleteAccount" class="tab-pane fade">

										      	<h3 class="margin-bottom-1 text-center text-danger">
										      		Delete Account
										      	</h3>
										      	<p class="margin-bottom-2 text-center">
													<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
														<strong>Deleting</strong> your account is <u><strong>permanent</strong></u> and <u><strong>cannot</strong></u> be undone.
													<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
										      	</p>

												<hr>

												<div class="row">
													<div class="col-sm-6 col-sm-offset-3 margin-bottom-3 text-center">

														<form method="POST" action="http://growyourleads.com/profile/{{ $user->id }}/deleteUserAccount" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="fLJWuSAWbJbZXqfzBD3wvDbfA1gBDUp4GMlcVDHt">

															<div class="btn-group btn-group-vertical margin-bottom-2" data-toggle="buttons">
																<label class="btn no-shadow" for="checkConfirmDelete">
																	<input type="checkbox" name="checkConfirmDelete" id="checkConfirmDelete">
																	<i class="fa fa-square-o fa-fw fa-2x"></i>
																	<i class="fa fa-check-square-o fa-fw fa-2x"></i>
																	<span class="margin-left-2"> Confirm Account Deletion</span>
																</label>
															</div>

														    <button class="btn btn-block btn-danger" id="delete_account_trigger" disabled="" type="button" data-toggle="modal" data-submit="Delete My Account" data-target="#confirmForm" data-modalclass="modal-danger" data-title="Confirm Account Deletion" data-message="Are you sure you want to delete your account?"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Delete My Account</button>

														</form>

													</div>
												</div>
										    </div>
										</div>
									</div>
								</div>

													
					</div>
				</div>
			</div>
		</div>


	</div>

	@include('modals.modal-form')

@endsection

@section('footer_scripts')

	@include('scripts.form-modal-script')
	@include('scripts.gmaps-address-lookup-api3')
	@include('scripts.user-avatar-dz')

	<script type="text/javascript">

		$('.dropdown-menu li a').click(function() {
			$('.dropdown-menu li').removeClass('active');
		});

		$('.profile-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-default');
		});

		$('.settings-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-info');
		});

		$('.admin-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-warning');
			$('.edit_account .nav-pills li, .edit_account .tab-pane').removeClass('active');
			$('#changepw')
				.addClass('active')
				.addClass('in');
			$('.change-pw').addClass('active');
		});

		$('.warning-pill-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-warning');
		});

		$('.danger-pill-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-danger');
		});

		$('#user_basics_form').on('keyup change', 'input, select, textarea', function(){
		    $('#account_save_trigger').attr('disabled', false);
		});

		$('#checkConfirmDelete').change(function() {
		    var submitDelete = $('#delete_account_trigger');
		    var self = $(this);

		    if (self.is(':checked')) {
		        submitDelete.attr('disabled', false);
		    }
		    else {
		    	submitDelete.attr('disabled', true);
		    }
		});



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

	</script>

@endsection
