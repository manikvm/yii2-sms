<?
include('/Twilio/autoload.php');
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

    /**
     * constructor
     *
     * @param string $config
     */
    public function __construct()
    {
               
        //Test credentials
        $this->_test_account_id = Yii::$app->smsotp->Test_Account_id;
        $this->_test_auth_token = Yii::$app->smsotp->Test_Auth_Token;
        $this->_test_from_number = Yii::$app->smsotp->Test_Auth_Token;

        //Live Credentials
        $this->_live_account_id = Yii::$app->smsotp->Live_Account_id;
        $this->_live_auth_token = Yii::$app->smsotp->Live_Auth_Token;
        $this->_live_from_number = Yii::$app->smsotp->Live_From_Number;

    }

    //Send message
    public function sendMessage($phone_number, $body, $send_otp_mode)
    {
    	if ($send_otp_mode == 'live')
    	{
    		$AccountSid = $this->_live_account_id;
    		$AuthToken = $this->_live_auth_token;
    		$from_number = $this->_live_from_number;
    		$number = PHONE_COUNTRY_CODE.trim($phone_number);
    		
    	}else{
    		$AccountSid = $this->_test_account_id;
    		$AuthToken = $this->_test_auth_token;
    		$from_number = $this->_test_from_number;
    		$number = PHONE_COUNTRY_CODE.trim($phone_number);
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
    	    //On successfully sending OTP it will return OTP number
    		if ( $message->errorCode == NULL && $message->errorMessage == NULL)
    			return $code;
    	} 
    	catch ( Exception $e ) {
    		return false;
    	}
    }
   
}
