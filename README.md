Twilio SMS
==========
Twilio sms for sending otp messages to the users

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist rbt/yii2-twiliosms "*"
```

or add

```
"rbt/yii2-twiliosms": "*"
```

to the require section of your `composer.json` file.

Configuration
-----

To use this extension, you have to configure the class and twilio account details in your application configuration:
return[
		'components' => [
			'smsotp' =>[
	            'class' => '\twiliosms\sms\Smssendotp',

	            //Twilio Test credentials
	            'Test_Account_id' => 'xxxxxxxxxxxxxxx',
	            'Test_Auth_Token' => 'xxxxxxxxxxxxxxx',
	            'Test_From_Number' => 'xxxxxxxxxxxxxxx',

	            //Twilio Live credentials

	            'Live_Account_id'  => 'xxxxxxxxxxxxxxx',
	            'Live_Auth_Token'  => 'xxxxxxxxxxxxxxx',
	            'Live_From_Number' => 'xxxxxxxxxxxxxxx',
		    //Here specify the mode whether it is live or test	
	            'Send_Otp_Mode' => 'test',
		    
		    // If it is US use +1
	            'Phone_Country_Code' => '+91' 
        	],
        ],
    ]

Usage
-----

Once the extension is installed, follow the below steps to send an otp number to the given phone number and save the otp code into database.

Step 1: Run the below query in your database.

		CREATE TABLE IF NOT EXISTS `sendsms` (
		  `id` int(11) NOT NULL,
		  `phone_number` varchar(15) DEFAULT NULL,
		  `otp_number` varchar(6) DEFAULT NULL,
		  `status` tinyint(4) NOT NULL DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		ALTER TABLE `sendsms` ADD PRIMARY KEY (`id`);

		ALTER TABLE `sendsms` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

Step 2: Generate model Sendsms.php for the table `sendsms`.

Step 3: Create view file sendotp.php file in views/site folder.

		<?php
			use yii\helpers\Html;
			use yii\widgets\ActiveForm;

			/* @var $this yii\web\View */
			/* @var $model app\models\Sendsms */
			/* @var $form ActiveForm */
			$this->title = 'Send OTP';
			$this->params['breadcrumbs'][] = $this->title;
			?>
			<div class="site-sendotp">

				<?php if(Yii::$app->session->hasFlash('successMessage')){?>
				<div class="alert alert-success">
					<?=Yii::$app->session->getFlash('successMessage')?>
			    </div>
			    <?php } ?>

			    <?php if(Yii::$app->session->hasFlash('failureMessage')){?>
				<div class="alert alert-danger">
					<?=Yii::$app->session->getFlash('failureMessage')?>
			    </div>
			    <?php } ?>

			    <?php $form = ActiveForm::begin(); ?>
			        <?= $form->field($model, 'phone_number')->textInput(['type'=>'text','class' => 'phone']); ?> 
			        	    
			        <div class="form-group">
			            <?= Html::submitButton('Send OTP', ['class' => 'btn btn-primary']) ?>
			        </div>
			    <?php ActiveForm::end(); ?>

			</div><!-- site-sendotp -->

Step 4: Create one function like actionSendotp() in site controller.

		<?php
		namespace app\controllers;

		use Yii;
		use yii\filters\AccessControl;
		use yii\web\Controller;
		use yii\web\Response;
		use yii\filters\VerbFilter;
		use app\models\LoginForm;
		use app\models\ContactForm;
		use app\models\Sendsms;

		class SiteController extends Controller
		{
		   
		    /**
		     * Displays send otp page.
		     *
		     * @return string
		     */
		    public function actionSendotp()
		    {
		        $model = new Sendsms();
		        if (Yii::$app->request->post()) {
		            $mobile_number = $_POST['Sendsms']['phone_number'];
		            $otp_message_body = "Your Verification code is:";
		            $send_otp_mode = Yii::$app->smsotp->Send_Otp_Mode;

		            //Sending otp number to the given mobile number.
		            $send_otp = \twiliosms\sms\Smssendotp::sendMessage($mobile_number,$otp_message_body,$send_otp_mode);
		            //echo '<pre>';var_dump($send_otp);
		            //exit;
		            if ( $send_otp != false && $send_otp !='')
		            {
		                $phone_exist = Sendsms::find ()->where ( [ 
		                    'phone_number' => $mobile_number
		                ] )->one ();
		                //Checking phone number is already exist in database or not
		                if ($phone_exist)
		                {
		                    //updating otp code in database.
		                    $update_otp_number = Sendsms::findOne (['phone_number' => $mobile_number]);
		                    $update_otp_number->otp_number = $send_otp;
		                    if ($update_otp_number->update ( false )) {
		                        Yii::$app->session->setFlash('successMessage', "Successfully sent an OTP to your enter phone number");
		                    }
		                    else{
		                         Yii::$app->session->setFlash('failureMessage', "Some Internal server issue occured.");
		                    }

		                }else{
		                    //Inserting phone number and otp number to database.
		                    $model->phone_number = $mobile_number;
		                    $model->otp_number = $send_otp;
		                    if ($model->save ( false )) {
		                        Yii::$app->session->setFlash('successMessage', "Successfully sent an OTP to your enter phone number");
		                    }else{
		                        Yii::$app->session->setFlash('failureMessage', "Some Internal server issue occured.");
		                    }
		                }
		            }else{
		                Yii::$app->session->setFlash('failureMessage', "Unable to send OTP, please try again.!");
		                
		            }
		           
		        }
		        return $this->render('sendotp',['model'=>$model] );
		    }
		}
