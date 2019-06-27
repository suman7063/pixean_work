$(document).ready(function() 
{   
	$("#mv-resendOTP").hide();
	
	// function sendOTP() 
	$('#sendOTP').click(function()
	{
		$(".error").html("").hide();
		var number = $("#mobile").val();

		if(number.length<7)
	    // $("#error_msg").html("enter atleast 5 digits in the input box");
		{
			$(".error").html('enter atleast 7 digits in the input box');
			$(".error").show();
		}

		else
		{
			var select = $("#mv-country-code").val();
			var phoneWithCode = select+number;
			var input = {
				"mobile_number" : phoneWithCode,
				"action" : "send_otp"
			};
			$.ajax({
				// url : 'textLocalController.php',
				url : 'msg91Controller.php',
				type : 'POST',
				data : input,
				success : function(response) {
					$(".container").html(response);
					setTimeout(function(){$("#mv-resendOTP").show();},40000);//resend option show after 40 send
				}
			});
		}
	});

	$(document).on('click','#mv-verifyOTP',function()
	{
		$(".error").html("").hide();
		$(".success").html("").hide();
		// alert("hiii");

		var otp = $("#mobileOtp").val();
		var input = {
			"otp" : otp,
			"action" : "verify_otp"
		};
		if (otp.length == 4 && otp != null) 
		{
			$.ajax({
				url : 'msg91Controller.php',
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
	});

	$(document).on('click','#mv-resendOTP',function()
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
				url : 'msg91Controller.php',
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
	});
});