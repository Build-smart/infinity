<?php
 
 
if (! function_exists('otpmsg')) {

	function otpmsg($otpval,$user_phone) {
		 
		 
		$getInvitationMsg = urlencode("Your OTP is: ".$otpval.".\nNote: Please DO NOT SHARE this OTP with anyone. BMLED & BUILDERMART INDIA PRIVATE LIMITED");
		$sms_api_key =  DB::table('sms')
		->first();
		if($sms_api_key->active==1){

			 
			$api_key = $sms_api_key->api_key;
			$sender_id = $sms_api_key->sender_id;
			$getAuthKey = $api_key;
			$getSenderId = $sender_id;
			 
			$authKey = $getAuthKey;
			$senderId = $getSenderId;
			$message1 = $getInvitationMsg;
			$route = "4";
			$postData = array(
					'authkey' => $authKey,
					'mobiles' => $user_phone,
					'message' => $message1,
					'sender' => $senderId,
					'route' => $route
			);
			 
			//   $url="https://control.msg91.com/api/sendhttp.php";
			 
			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$getAuthKey.'&senderid='.$getSenderId.'&channel=2&DCS=0&flashsms=0&number='.$user_phone.'&text='.$message1.'&route=1';
			 
			$ch = curl_init();
			curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
			));
			 
			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			 
			//get response
			$output = curl_exec($ch);
			 
			curl_close($ch);
			 
		}
		 
		 
		 
	}

}

 
 
  
if (! function_exists('orderconfirm')) {

	function orderconfirm($orderdetails,$user_phone) {
		 
		 
	//	$getInvitationMsg = urlencode("Your Order for : ".$orderdetails.".\n is place successfully. CitiBizs");
	
		$getInvitationMsg = urlencode("Your Order is place successfully.  BMLED & BUILDERMART INDIA PRIVATE LIMITED");
		$sms_api_key =  DB::table('sms')
		->first();
		if($sms_api_key->active==1){

			 
			$api_key = $sms_api_key->api_key;
			$sender_id = $sms_api_key->sender_id;
			$getAuthKey = $api_key;
			$getSenderId = $sender_id;
			 
			$authKey = $getAuthKey;
			$senderId = $getSenderId;
			$message1 = $getInvitationMsg;
			$route = "4";
			$postData = array(
					'authkey' => $authKey,
					'mobiles' => $user_phone,
					'message' => $message1,
					'sender' => $senderId,
					'route' => $route
			);
			 
			//   $url="https://control.msg91.com/api/sendhttp.php";
			 
			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$getAuthKey.'&senderid='.$getSenderId.'&channel=2&DCS=0&flashsms=0&number='.$user_phone.'&text='.$message1.'&route=1';
			 
			$ch = curl_init();
			curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
			));
			 
			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			 
			//get response
			$output = curl_exec($ch);
			 
			curl_close($ch);
			 
		}
		 
		 
		 
	}

}

 
 

if (! function_exists('accountactivate')) {

	function accountactivate($user_phone,$user_name) {
			
			
	 	$getInvitationMsg = urlencode("Hi $user_name Your Builder Mart Account is Activated Please Login. BMLED & BUILDERMART INDIA PRIVATE LIMITED");
		$sms_api_key =  DB::table('sms')
		->first();
		if($sms_api_key->active==1){


			$api_key = $sms_api_key->api_key;
			$sender_id = $sms_api_key->sender_id;
			$getAuthKey = $api_key;
			$getSenderId = $sender_id;

			$authKey = $getAuthKey;
			$senderId = $getSenderId;
			$message1 = $getInvitationMsg;
			$route = "4";
			$postData = array(
					'authkey' => $authKey,
					'mobiles' => $user_phone,
					'message' => $message1,
					'sender' => $senderId,
					'route' => $route
			);

			//   $url="https://control.msg91.com/api/sendhttp.php";

			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$getAuthKey.'&senderid='.$getSenderId.'&channel=2&DCS=0&flashsms=0&number='.$user_phone.'&text='.$message1.'&route=1';

			$ch = curl_init();
			curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
			));

			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			//get response
			$output = curl_exec($ch);

			curl_close($ch);

		}
			
			
			
	}

}


if (! function_exists('temp_password')) {

   function temp_password($otpval,$user_phone) { 
         
         
         $getInvitationMsg = urlencode("Your New Generated Password is: ".$otpval.".\nNote: Please DO NOT SHARE this password with anyone. BMLED & BUILDERMART INDIA PRIVATE LIMITED");
         $sms_api_key =  DB::table('sms')
         ->first();
         if($sms_api_key->active==1){
            
               
                 $api_key = $sms_api_key->api_key;
                 $sender_id = $sms_api_key->sender_id;
                 $getAuthKey = $api_key;
                 $getSenderId = $sender_id;
                 
                 $authKey = $getAuthKey;
                 $senderId = $getSenderId;
                 $message1 = $getInvitationMsg;
                 $route = "4";
                 $postData = array(
                     'authkey' => $authKey,
                     'mobiles' => $user_phone,
                     'message' => $message1,
                     'sender' => $senderId,
                     'route' => $route
                 );
                 
                 //   $url="https://control.msg91.com/api/sendhttp.php";
                 
                 $url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$getAuthKey.'&senderid='.$getSenderId.'&channel=2&DCS=0&flashsms=0&number='.$user_phone.'&text='.$message1.'&route=1';
                 
                 $ch = curl_init();
                 curl_setopt_array($ch, array(
                     CURLOPT_URL => $url,
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_POST => true,
                     CURLOPT_POSTFIELDS => $postData
                 ));
                 
                 //Ignore SSL certificate verification
                 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                 
                 //get response
                 $output = curl_exec($ch);
                 
                 curl_close($ch);
             
         }       
         
         
         
     }

}



if (! function_exists('orderstatussms')) {

	function orderstatussms($orders_id,$order_customer_name,$user_phone,$status_name,$comments) {
			
	
 
	
  $getInvitationMsg = urlencode("Hi $order_customer_name Your Order ID is $orders_id. $status_name $comments. BMLED & BUILDER MART INDIA PRIVATE LIMITED");
		
		 
		
		$sms_api_key =  DB::table('sms')
		->first();
		if($sms_api_key->active==1){


			$api_key = $sms_api_key->api_key;
			$sender_id = $sms_api_key->sender_id;
			$getAuthKey = $api_key;
			$getSenderId = $sender_id;

			$authKey = $getAuthKey;
			$senderId = $getSenderId;
			$message1 = $getInvitationMsg;
			$route = "4";
			$postData = array(
					'authkey' => $authKey,
					'mobiles' => $user_phone,
					'message' => $message1,
					'sender' => $senderId,
					'route' => $route
			);

			//   $url="https://control.msg91.com/api/sendhttp.php";

			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$getAuthKey.'&senderid='.$getSenderId.'&channel=2&DCS=0&flashsms=0&number='.$user_phone.'&text='.$message1.'&route=1';

			$ch = curl_init();
			curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
			));

			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			//get response
			$output = curl_exec($ch);

			curl_close($ch);

		}
			
			
			
	}

}





if (! function_exists('shippingchargessms')) {

	function shippingchargessms($orders_id,$username,$userphone) {
			
			
 
		$getInvitationMsg = urlencode("Hi $username, Your Order ID is $orders_id placed successfully. Shipping Charges will be applicable for this order. Our executive will assist you for the shipping prices or delivery prices depending upon Distance once the order is confirmed. In this order the Shipping Charges are not included. BMLED & BUILDERMART INDIA PRIVATE LIMITED");
		$sms_api_key =  DB::table('sms')
		->first();
		if($sms_api_key->active==1){


			$api_key = $sms_api_key->api_key;
			$sender_id = $sms_api_key->sender_id;
			$getAuthKey = $api_key;
			$getSenderId = $sender_id;

			$authKey = $getAuthKey;
			$senderId = $getSenderId;
			$message1 = $getInvitationMsg;
			$route = "4";
			$postData = array(
					'authkey' => $authKey,
					'mobiles' => $userphone,
					'message' => $message1,
					'sender' => $senderId,
					'route' => $route
			);

			//   $url="https://control.msg91.com/api/sendhttp.php";

			$url = 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey='.$getAuthKey.'&senderid='.$getSenderId.'&channel=2&DCS=0&flashsms=0&number='.$userphone.'&text='.$message1.'&route=1';

			$ch = curl_init();
			curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
			));

			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			//get response
			$output = curl_exec($ch);

			curl_close($ch);

		}
			
			
			
	}

}


