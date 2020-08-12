//Functions
function validateForm(form) {
	var formValid = true;
	var error = [];
	form.find('input, textarea, select').each(function() {
		if (!$(this).val() && !$(this).hasClass('ignoreValidation')) {
			formValid = false;
			error.push("#"+$(this).attr('id'));
		}
	});
	return {success: formValid, error: error};
}

function getFormData(form) {
	validationResult = validateForm(form);
	if (validationResult.success) {
		var unindexed_array = form.serializeArray();
		var indexed_array = {};

		$.map(unindexed_array, function(n, i) {
			indexed_array[n['name']] = n['value'];
		});

		return {success: true, formData: indexed_array};
	} else {
		return validationResult;
	}
}

function verifyUserPassword(id, password) {
	var result = {};
	$.ajax({
		async: false,
		type: 'POST',
		url: "/test-code/ajax/verifyUserPassword.php",
		data: {id: id, password: password},
		dataType: 'JSON',
		success: function(data) {
			result = data;
		},
		error: function (jqXHR, exception) {
			var msg = '';
			if (jqXHR.status === 0) {
				msg = 'Not connect.\n Verify Network.';
			} else if (jqXHR.status == 404) {
				msg = 'Requested page not found. [404]';
			} else if (jqXHR.status == 500) {
				msg = 'Internal Server Error [500].';
			} else if (exception === 'parsererror') {
				msg = 'Requested JSON parse failed.';
			} else if (exception === 'timeout') {
				msg = 'Time out error.';
			} else if (exception === 'abort') {
				msg = 'Ajax request aborted.';
			} else {
				msg = 'Uncaught Error.\n' + jqXHR.responseText;
			}
			console.log(msg);
			result = {success: false};
		}
	});
	return result;
}

function selectUserDetails(id) {
	var result = {};
	$.ajax({
		async: false,
		type: 'POST',
		url: "/test-code/ajax/selectUserDetails.php",
		data: {id: id},
		dataType: 'JSON',
		success: function(data) {
			result = data;
		},
		error: function (jqXHR, exception) {
			var msg = '';
			if (jqXHR.status === 0) {
				msg = 'Not connect.\n Verify Network.';
			} else if (jqXHR.status == 404) {
				msg = 'Requested page not found. [404]';
			} else if (jqXHR.status == 500) {
				msg = 'Internal Server Error [500].';
			} else if (exception === 'parsererror') {
				msg = 'Requested JSON parse failed.';
			} else if (exception === 'timeout') {
				msg = 'Time out error.';
			} else if (exception === 'abort') {
				msg = 'Ajax request aborted.';
			} else {
				msg = 'Uncaught Error.\n' + jqXHR.responseText;
			}
			console.log(msg);
			result = {success: false};
		}
	});
	return result;
}

function selectAccountNames() {
	var result = {};
	$.ajax({
		async: false,
		type: 'POST',
		url: "/test-code/ajax/selectAccountNames.php",
		data: null,
		dataType: 'JSON',
		success: function(data) {
			result = data;
		},
		error: function (jqXHR, exception) {
			var msg = '';
			if (jqXHR.status === 0) {
				msg = 'Not connect.\n Verify Network.';
			} else if (jqXHR.status == 404) {
				msg = 'Requested page not found. [404]';
			} else if (jqXHR.status == 500) {
				msg = 'Internal Server Error [500].';
			} else if (exception === 'parsererror') {
				msg = 'Requested JSON parse failed.';
			} else if (exception === 'timeout') {
				msg = 'Time out error.';
			} else if (exception === 'abort') {
				msg = 'Ajax request aborted.';
			} else {
				msg = 'Uncaught Error.\n' + jqXHR.responseText;
			}
			console.log(msg);
			result = {success: false};
		}
	});
	return result;
}

function addUserDetails(userDetails) {
	var result = {};
	$.ajax({
		async: false,
		type: 'POST',
		url: "/test-code/ajax/addUserDetails.php",
		data: userDetails,
		dataType: 'JSON',
		success: function(data) {
			result = data;
		},
		error: function (jqXHR, exception) {
			var msg = '';
			if (jqXHR.status === 0) {
				msg = 'Not connect.\n Verify Network.';
			} else if (jqXHR.status == 404) {
				msg = 'Requested page not found. [404]';
			} else if (jqXHR.status == 500) {
				msg = 'Internal Server Error [500].';
			} else if (exception === 'parsererror') {
				msg = 'Requested JSON parse failed.';
			} else if (exception === 'timeout') {
				msg = 'Time out error.';
			} else if (exception === 'abort') {
				msg = 'Ajax request aborted.';
			} else {
				msg = 'Uncaught Error.\n' + jqXHR.responseText;
			}
			console.log(msg);
			result = {success: false};
		}
	});
	return result;
}

function deleteAccount(id) {
	var result = {};
	$.ajax({
		async: false,
		type: 'POST',
		url: "/test-code/ajax/deleteAccount.php",
		data: {id: id},
		dataType: 'JSON',
		success: function(data) {
			result = data;
		},
		error: function (jqXHR, exception) {
			var msg = '';
			if (jqXHR.status === 0) {
				msg = 'Not connect.\n Verify Network.';
			} else if (jqXHR.status == 404) {
				msg = 'Requested page not found. [404]';
			} else if (jqXHR.status == 500) {
				msg = 'Internal Server Error [500].';
			} else if (exception === 'parsererror') {
				msg = 'Requested JSON parse failed.';
			} else if (exception === 'timeout') {
				msg = 'Time out error.';
			} else if (exception === 'abort') {
				msg = 'Ajax request aborted.';
			} else {
				msg = 'Uncaught Error.\n' + jqXHR.responseText;
			}
			console.log(msg);
			result = {success: false};
		}
	});
	return result;
}

//Events
$(function() {	
	//JavaScript/JQuery code
});