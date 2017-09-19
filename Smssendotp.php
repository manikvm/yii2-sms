<?php
namespace twiliosms\sms;
include('Twilio/autoload.php');
use Yii;
use Twilio\Rest\Client;
class Smssendotp
{
    /**
     * ci instance object
     *
     */
    private $_test_account_id;
    private $_test_from_number;
    private $_test_auth_token;

    private $_live_account_id;
    private $_live_auth_token;
    private $_live_from_number;
    private $phone_country_code;

    /**
     * constructor
     *
     * @param string $config
     */
   
    //Send message
    public function sendMessage($phone_number, $body, $send_otp_mode)
    {
         //Test credentials 
        $_test_account_id = Yii::$app->smsotp->Test_Account_id;
        $_test_auth_token = Yii::$app->smsotp->Test_Auth_Token;
        $_test_from_number = Yii::$app->smsotp->Test_From_Number;

        //Live Credentials
        $_live_account_id = Yii::$app->smsotp->Live_Account_id;
        $_live_auth_token = Yii::$app->smsotp->Live_Auth_Token;
        $_live_from_number = Yii::$app->smsotp->Live_From_Number;

        $phone_country_code = Yii::$app->smsotp->Phone_Country_Code;
        $number = $phone_country_code.trim($phone_number);
        
    	if ($send_otp_mode == 'live')
    	{
    		$AccountSid = $_live_account_id;
    		$AuthToken = $_live_auth_token;
    		$from_number = $_live_from_number;
    		    		
    	}else{
    		$AccountSid = $_test_account_id;
    		$AuthToken = $_test_auth_token;
    		$from_number = $_test_from_number;
    		
    	}
    	// generate "random" 5-digit verification code
    	$code = rand(10000, 99999);
    	
    	$client = new Client($AccountSid, $AuthToken);
    	try {
	    	$message = $client->messages->create(
	    			$number, // Text this number
	    			array(
	    					'from' => $from_number, // From a valid Twilio number
	    					'body' => $body.' '.$code
	    			)
	    	);
            //echo '<pre>';var_dump($message);exit;
    	    //On successfully sending OTP it will return OTP number
            if($message == false){
                return $message;
            }
    		else if ( $message->errorCode == NULL && $message->errorMessage == NULL)
    			return $code;
    	} 
    	catch ( Exception $e ) {

            return false;
    	}
    }
    
    
}
