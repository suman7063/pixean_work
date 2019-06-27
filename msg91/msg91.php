<!DOCTYPE html>
<html>
<head>
<title>How to Implement OTP SMS Mobile Verification in PHP with TextLocal</title>
<link href="saCss.css" type="text/css" rel="stylesheet" />
<style type="text/css">
	
</style>
</head>
<body>

	<div class="container">
		<div class="error"></div>
		<form id="frm-mobile-verification">
			<div class="mv-form-heading">Mobile Number Verification</div>

			<div class="mv-form-row">
				<select style="border: none;width: 70px;" id="mv-country-code">
					<option>Select</option>
					<option value="61">Australia: +61</option>
					<option value="975">Bhutan: +975</option>
					<option value="55">Brazil: +55</option>
					<option value="86">China: +86</option>
					<option value="57">Colombia: +57</option>
					<option value="45">Denmark: +45</option>
					<option value="33">France: +33</option>
					<option value="49">Germany: +49</option>
					<option value="852">Hong Kong: +852</option>
					<option value="36">Hungary: +36</option>
					<option value="91">India: +91</option>
					<option value="98">Iran: +98</option>
					<option value="964">Iraq: +964</option>
					<option value="972">Israel: +972</option>
					<option value="39">Italy: +39</option>
					<option value="81">Israel: +81</option>
					<option value="39">Japan: +39</option>
					<option value="52">Mexico: +52</option>
					<option value="1">USA: +1</option>
					<option value="44">UK: +44</option>
				</select>
				<input type="text" id="mobile" class="form-input" placeholder="Enter the 10 digit mobile" onkeyup="this.value=this.value.replace(/[^0-9]+/, '')" maxlength="10">
			</div>
			<div id="error_msg" style="font-size: 15px;color: red;position: relative;top:-30px;"></div>

			<input type="button" class="btnSubmit" value="Send OTP" id="sendOTP">
	
		</form>
	</div>

	<script src="jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="msg91.js"></script>
</body>
</html>