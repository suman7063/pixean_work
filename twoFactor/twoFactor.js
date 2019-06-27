function sendOTP() 
{
	$(".error").html("").hide();
	var number = $("#mobile").val();
	if (number.length >= 10 && number != null) {
		var input = {
			"mobile_number" : number,
			"action" : "send_otp"
		};
		$.ajax({
			// url : 'textLocalController.php',
			url : 'twoFactorController.php',
			type : 'POST',
			data : input,
			success : function(response) {
				$(".container").html(response);
			}
		});
	} else {
		$(".error").html('Please enter a valid number!')
		$(".error").show();
	}
}

function resendOTP() 
{
	$(".error").html("").hide();
	var number = $("#mobile").val();
	// alert(number);
	if (number.length >= 10 && number != null) {
		var input = {
			"mobile_number" : number,
			"action" : "retry_otp"
		};
		$.ajax({
			// url : 'textLocalController.php',
			url : 'twoFactorController.php',
			type : 'POST',
			data : input,
			success : function(response) {
				$(".container").html(response);
			}
		});
	} else {
		$(".error").html('Please enter a valid number!')
		$(".error").show();
	}
}

function verifyOTP() 
{
	$(".error").html("").hide();
	$(".success").html("").hide();
	var userMob = $("#userMob").val();
	var authKey = $("#authKey").val();
	// alert(authKey);
	var otp = $("#mobileOtp").val();
	var input = {
		"otp" : otp,
		"userMob" : userMob,
		"authKey" : authKey,
		"action" : "verify_otp"
	};
	if (otp.length == 6  && otp != null) 
	{
		$.ajax({
			url : 'twoFactorController.php',
			type : 'POST',
			dataType : "json",
			data : input,
			success : function(response) {
				$("." + response.type).html(response.message)
				$("." + response.type).show();
				$("#frm-mobile-verification").hide();
			},

			error : function(ts) {
				alert(ts.responseText);
			}
		});
	} else {
		$(".error").html('You have entered wrong OTP.')
		$(".error").show();
	}
}