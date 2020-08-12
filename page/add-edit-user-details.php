<!DOCTYPE html>
<html>
	<head>
		<?php
			include $_SERVER['DOCUMENT_ROOT']."/test-code/config.php";
			include $_SERVER['DOCUMENT_ROOT']."/test-code/index.php";
			$users = $test_class->selectUsers();
		?>
		<!-- html code -->
	</head>
	<body>
	<!-- Modal -->
		<div class="modal fade" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="userDetailsModalLabel"></h5>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="button" id="modalFooterButton" class="btn"></button>
					</div>
				</div>
			</div>
		</div>

		<form id="userDetails" class="page-content">
			<div class="row col-12 form-group">
				<label for="users">Select a user to edit details</label>
				<select id="users" name="users" class="form-control">
					<option selected disabled hidden>Please select...</option>
					<option id="newUser">New user</option>
					<?php foreach ($users as $user) { ?>
						<option id="<?=$user['id'];?>"><?=$user['username'];?></option>
					<?php } ?>
				</select>
			</div>

			<div class="clearfix section-break account d-none"></div>
			<div class="row col-12 form-group account d-none">
				<label for="username">Login details:</label>
				<input id="username" name="username" class="form-control ignoreValidation" value="" placeholder="Username" />
				<input id="password" name="password" type="password" class="form-control ignoreValidation" value="" placeholder="Password" />
				<div class="clearfix section-break new-password d-none"></div>
				<input id="newPassword" name="password" type="password" class="form-control ignoreValidation new-password d-none" value="" placeholder=" New Password" />
				<input id="confirmPassword" name="confirmPassword" type="password" class="form-control ignoreValidation" value="" placeholder="" />
				<div id="accountAlert" class="alert alert-danger d-none" role="alert"></div>
			</div>

			<div class="clearfix section-break"></div>
			<div class="row col-12 form-group">
				<label for="name">Name:</label>
				<input id="name" name="name" class="form-control" value="" placeholder="Name" />
			</div>
			<div class="row col-12 form-group">
				<label for="address1">Address Line 1:</label>
				<input id="address1" name="address1" class="form-control" value="" placeholder="Address 1" />
			</div>
			<div class="row col-12 form-group">
				<label for="address2">Address Line 2:</label>
				<input id="address2" name="address2" class="form-control ignoreValidation" value="" placeholder="Address 2" />
			</div>
			<div class="row col-12 form-group">
				<label for="city">City:</label>
				<input id="city" name="city" class="form-control" value="" placeholder="City" />
			</div>
			<div class="row col-12 form-group">
				<label for="countyState">County / State:</label>
				<input id="countyState" name="countyState" class="form-control" value="" placeholder="County or State" />
			</div>
			<div class="row col-12 form-group">
				<label for="postcode">Postcode:</label>
				<input id="postcode" name="postcode" class="form-control" value="" placeholder="Postcode" />
			</div>
		</form>
		<div class="button-box">
			<div id="pageAlert" class="alert d-none" role="alert"></div>
			<button type="button" id="userDetailsDelete" class="btn btn-danger float-left d-none">Delete Account</button>
			<button type="button" id="userDetailsSubmit" class="btn btn-success float-right">Submit</button>
		</div>
		<script>
			function clearForm(form, clearInputs=false) {
				form.find('input, textarea, select').each(function() {
					$(this).removeClass("is-valid is-invalid");
					if (clearInputs && $(this).attr('id') != "users") {
						$(this).val("");
						$(this).removeAttr('readonly');
					}
				});
				$('#accountAlert').text("").removeClass('d-block d-none').addClass('d-none'); //Hide and clear password error alert
				$('#pageAlert').text("").removeClass('d-block d-none alert-success alert-warning alert-danger').addClass('d-none'); //Hide and clear page alert
				$('.modal-title').text("");
				$('.modal-body').html('');
				$('#modalFooterButton').text("").removeClass('btn-danger userDetailsDeleteConfirm');
			}

			$(function() {
				$('#users').change(function() {	
					clearForm($('#userDetails'), true);
					
					var selectedID = $(this).find('option:selected').attr('id');
					if (!selectedID) {
						//Nothing selected
						$('#confirmPassword').attr('placeholder', ""); //Clear placeholder from password confirmation input
						$('.account').removeClass('d-block d-none ignoreValidation').addClass('d-none ignoreValidation'); //Hide account inputs
						$('.new-password').removeClass('d-block d-none').addClass('d-none'); //Hide new password
						$('#userDetailsDelete').removeClass('d-block d-none').addClass('d-none'); //Hide delete account button
					} else if (selectedID == "newUser") {
						//New user selected
						$('#confirmPassword').attr('placeholder', "Confirm Password"); //Change placeholder to show which password you are confirming
						$('.account').removeClass('d-block d-none ignoreValidation').addClass('d-block'); //Show account inputs
						$('.new-password').removeClass('d-block d-none').addClass('d-none'); //Hide new password
						$('#userDetailsDelete').removeClass('d-block d-none').addClass('d-none'); //Hide delete account button
					} else {
						//A user is selected
						$('#confirmPassword').attr('placeholder', "Confirm New Password"); //Change placeholder to show which password you are confirming
						$('.account').removeClass('d-block d-none ignoreValidation').addClass('d-block'); //Show account inputs
						$('.new-password').removeClass('d-block d-none').addClass('d-block'); //Show new password
						$('#userDetailsDelete').removeClass('d-block d-none').addClass('d-block'); //Show delete account button

						var userDetails = selectUserDetails(selectedID);
						$('#username').val(userDetails.username).prop('readonly', true)
						$('#name').val(userDetails.name);
						$('#address1').val(userDetails.addressLine1);
						$('#address2').val(userDetails.addressLine2);
						$('#city').val(userDetails.city);
						$('#countyState').val(userDetails.countyState);
						$('#postcode').val(userDetails.postcode);
					}
				});

				$('#userDetailsSubmit').click(function() {
					clearForm($('#userDetails'));
					
					var selectedID = $('#users').find('option:selected').attr('id');
					if (!selectedID) {
						//Nothing selected
					} else if (selectedID == "newUser") {
						//New user must be added
						if ($('#username').val() != "") {
							var accountNames = selectAccountNames();
							var accountClash = false;
							$(accountNames).each(function() {
								if (this.username == $('#username').val()) {
									accountClash = true;
								}
							});
							if (!accountClash) {
								$('#username').removeClass("is-valid is-invalid").addClass("is-valid");
								
								if ($('#password').val() != "" && $('#password').val() == $('#confirmPassword').val()) {
									$('#password').removeClass("is-valid is-invalid").addClass("is-valid");
									$('#confirmPassword').removeClass("is-valid is-invalid").addClass("is-valid");

									var formDataResult = getFormData($('#userDetails'));
									if (formDataResult.success) {						
										//Form valid
										var addResult = addUserDetails(formDataResult.formData);
										if (addResult.success) {
											//Function successful
											$('#pageAlert').text("User added.").removeClass('d-block d-none alert-success alert-warning alert-danger').addClass('d-block alert-success'); //Show page alert
											setTimeout(location.reload.bind(location), 3000); //Reload page after 3 seconds
										} else {
											//Function failed
											$('#pageAlert').text("User failed to add.").removeClass('d-block d-none alert-success alert-warning alert-danger').addClass('d-block alert-danger'); //Show page alert
										}
									} else {
										//Form invalid
										for (var i=0; i<formDataResult.error.length; ++i) {
											$(formDataResult.error[i]).addClass("is-invalid");
										}
									}
								} else {
									$('#password').removeClass("is-valid is-invalid").addClass("is-invalid");
									$('#confirmPassword').removeClass("is-valid is-invalid").addClass("is-invalid");
									$('#accountAlert').text("Password not entered or passwords do not match.").removeClass('d-block d-none').addClass('d-block'); //Show account error alert
								}
							} else {
								$('#username').removeClass("is-valid is-invalid").addClass("is-invalid");
								$('#accountAlert').text("Username already in use.").removeClass('d-block d-none').addClass('d-block'); //Show account error alert
							}
						} else {
							$('#username').removeClass("is-valid is-invalid").addClass("is-invalid");
							$('#accountAlert').text("Username not entered.").removeClass('d-block d-none').addClass('d-block'); //Show account error alert
						}
					} else {
						//User must be edited
					}
				});

				$('#userDetailsDelete').click(function() {
					$('.modal-title').text("Delete Account:"+$('#username').val());
					$('.modal-body').html('<div class="row col-12 form-group"><label for="modalPassword">Please confirm the password for user: "'+$('#username').val()+'"</label><input id="modalPassword" name="modalPassword" type="password" class="form-control ignoreValidation" value="" placeholder="Confirm Password" /><div id="modalAlert" class="alert alert-danger d-none" role="alert"></div></div>');
					$('#modalFooterButton').text("Delete Account").addClass('btn-danger userDetailsDeleteConfirm');
					$('#userDetailsModal').modal('show');
				});

				$('#modalFooterButton').click(function() {
					if ($(this).hasClass('userDetailsDeleteConfirm')) {
						$('#modalPassword').removeClass('is-invalid');
						$('#modalAlert').text("").removeClass('d-block d-none').addClass('d-none');

						if ($('#modalPassword').val() != "") {
							var verifyPasswordResult = verifyUserPassword($('#users').find('option:selected').attr('id'), $('#modalPassword').val());
							if (verifyPasswordResult.success) {
								//Verification didn't fail
								if (verifyPasswordResult.verification) {
									deleteResult = deleteAccount($('#users').find('option:selected').attr('id'));
									if (deleteResult.success) {
										//Function successful
										$('#userDetailsModal').modal('hide');
										$('#pageAlert').text("User deleted.").removeClass('d-block d-none alert-success alert-warning alert-danger').addClass('d-block alert-warning'); //Show page alert
										setTimeout(location.reload.bind(location), 3000); //Reload page after 3 seconds
									} else {
										//Function failed
										$('#modalAlert').text("User failed to add.").removeClass('d-block d-none alert-success').addClass('d-block');
									}
								} else {
									$('#modalAlert').text("Password incorrect. User could not be deleted.").removeClass('d-block d-none').addClass('d-block');
								}
							} else {
								//Verification failed
								$('#modalAlert').text("Password could not be verified.").removeClass('d-block d-none').addClass('d-block');
							}
						} else {
							$('#modalPassword').addClass('is-invalid');
							$('#modalAlert').text("Please enter a password.").removeClass('d-block d-none').addClass('d-block');
						}
					}
				});
			});
		</script>
	</body>
</html>