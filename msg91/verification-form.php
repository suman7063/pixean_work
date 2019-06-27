
<div class="error"></div>
<div class="success">
	<?php
	$userMob = $_SESSION['$mobile_number'];
	?>
</div>
<form id="frm-mobile-verification">
	<div class="form-row">
		<label>OTP is sent to Your Mobile Number:<?php echo $userMob;?></label>		
	</div>

	<div class="form-row">
		<input type="text" id="mobileOtp" class="form-input" placeholder="Enter the OTP" onkeyup="this.value=this.value.replace(/[^0-9]+/, '')" maxlength="4">		
	</div>

	<div class="row">
		<input id="mv-verifyOTP" type="button" class="btnVerify" value="Verify">		
	</div>
	<a href="#" id="mv-resendOTP" style="display: none;margin-left: 80%;"> resend</p>
</form>
