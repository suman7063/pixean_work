<?php
session_start();

class Controller
{
    function __construct() {
        $this->processMobileVerification();
    }
    function processMobileVerification()
    {
       
        switch ($_POST["action"]) {
            case "send_otp":

                $To = "91".$_POST['mobile_number'];
                $_SESSION['$mobile_number'] = $To;

                $YourAPIKey='8e165eae-95b4-11e9-ade6-0200cd936042';
                $From='pixean';

                // $Msg='Your verification otp code is:';

                $otp = rand(100000, 999999);
                $_SESSION['session_otp'] = $otp;

                $Msg = "Your verification otp code is:" . $otp;


                // https://2factor.in/API/R1/?module=TRANS_SMS&apikey=8e165eae-95b4-11e9-ade6-0200cd936042&to=9875409501&from=pixean&msg=SMS_TEXT

                ### DO NOT Change anything below this line

                $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

                $url = "https://2factor.in/API/V1/$YourAPIKey/ADDON_SERVICES/SEND/TSMS"; 



                $ch = curl_init(); 
                curl_setopt($ch,CURLOPT_URL,$url); 
                curl_setopt($ch,CURLOPT_POST,true); 
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
                curl_setopt($ch,CURLOPT_POSTFIELDS,"From=$From&To=$To&Msg=$Msg"); 
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);

                try
                {
                    curl_exec($ch);
                    require_once ("verification-form.php");
                    curl_close($ch);
                    exit();
                }
                catch(Exception $e)
                {
                    die('Error: '.$e->getMessage());
                }

            break;


              case "retry_otp":
              $mobile_number = $_POST['mobile_number'];

              $resendOtp = array(
                    // 'authkey' => $authKey,
                    'authkey' => $authKey,
                    'mobile' => $mobile_number
                );
              $resendUrl = "https://control.msg91.com/api/retryotp.php";
              $curl = curl_init($resendUrl);

                curl_setopt_array($curl, array(
                  // CURLOPT_URL => "https://control.msg91.com/api/verifyRequestOTP.php?authkey=&mobile=&otp=",
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
                
                if ($otp == $_SESSION['session_otp'])
                {
                    unset($_SESSION['session_otp']);
                    echo json_encode(array("type"=>"success", "message"=>"Your mobile number is verified!"));
                }
                else 
                {
                    echo json_encode(array("type"=>"error", "message"=>"Mobile number verification failed"));
                }
                break;
        }
    }
}
$controller = new Controller();
?>