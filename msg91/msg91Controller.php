<?php
session_start();

class Controller
{
    function __construct() {
        $this->processMobileVerification();
    }
    function processMobileVerification()
    {

        $authKey = "282303AFnaSsR75d0f6d71";
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "pixean";
        switch ($_POST["action"]) {
            case "send_otp":
                
                //Your authentication key
                $mobile_number = $_POST['mobile_number'];

                $_SESSION['$mobile_number'] = $mobile_number;
                
                $message = "Your verification otp code is ##OTP##";

                $postData = array(
                    'authkey' => $authKey,
                    'mobile' => $mobile_number,
                    'message' => $message,
                    'sender' => $senderId
                );

                //API URL
                $url="https://control.msg91.com/api/sendotp.php";

                $curl = curl_init($url);

                curl_setopt_array($curl, array(
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS =>  $postData,  
                  CURLOPT_SSL_VERIFYHOST => 0,
                  CURLOPT_SSL_VERIFYPEER => 0,
                ));

                $response = curl_exec($curl);
                $data = json_decode($response);
                // echo $response;
                $err = curl_error($curl);
                curl_close($curl);
                echo $data->type; 

                if($data->type == "success")
                {
                  require_once ("verification-form.php");
                  exit();
                }
                
                else
                {
                  echo $err;
                }
                break;


              case "retry_otp":
              $mobile_number = $_POST['mobile_number'];

              $resendOtp = array(
                    'authkey' => $authKey,
                    'mobile' => $mobile_number
                );
              $resendUrl = "https://control.msg91.com/api/retryotp.php";
              $curl = curl_init($resendUrl);

                curl_setopt_array($curl, array(
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => $resendOtp,
                  CURLOPT_SSL_VERIFYHOST => 0,
                  CURLOPT_SSL_VERIFYPEER => 0,
                 
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) 
                {
                  echo "cURL Error #:" . $err;
                } else 
                {
                  echo $response;
                }
              break;
              case "verify_otp":
                $otp = $_POST['otp'];
                $mobile = $_SESSION['$mobile_number'];

                $postDataOtp = array(
                    'authkey' => $authKey,
                    'mobile' => $mobile,
                    'otp' => $otp
                );


                $otpUrl = "https://control.msg91.com/api/verifyRequestOTP.php";


                $curl = curl_init($otpUrl);

                curl_setopt_array($curl, array(
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => $postDataOtp,
                  CURLOPT_SSL_VERIFYHOST => 0,
                  CURLOPT_SSL_VERIFYPEER => 0,
                
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                  echo "cURL Error #:" . $err;
                } else {
                  echo $response;
                }
                                
                if ($otp == $_SESSION['session_otp']) {
                    unset($_SESSION['session_otp']);
                    echo json_encode(array("type"=>"success", "message"=>"Your mobile number is verified!"));
                } else {
                    echo json_encode(array("type"=>"error", "message"=>"Mobile number verification failed"));
                }
                break;
        }
    }
}
$controller = new Controller();
?>