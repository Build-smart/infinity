<?php

namespace App\Models\AppModels;

use App\Http\Controllers\App\AlertController;
use App\Http\Controllers\App\AppSettingController;
use Auth;
use DB;
use File;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Customer extends Model
{
    
    
    public static function credentials($request)
        {
          if(is_numeric($request->email)){
            return ['phone'=>$request->email,'password'=>$request->password,'role_id' => 2];
          }
          elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->email, 'password'=>$request->password,'role_id' => 2];
          }
          return ['email' => $request->email, 'password'=>$request->password,'role_id' => 2];
        }

    public static function processlogin($request)
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate==1) {

            $email = $request->email;
            $password = $request->password;
 
          
	//	  $customerInfo = array("email" => $email, "password" => $password, 'role_id' => 2);
		  
		  
		  $customerInfo =Customer::credentials($request);
		  
            if (Auth::attempt($customerInfo)) {

$existUser=null;

 
if(is_numeric($email)){
             $existUser = DB::table('users')
                    ->where('phone', $email)->where('status', '1')->first();
                    
                    
          }
          elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $existUser = DB::table('users')
                    ->where('email', $email)->where('status', '1')->first();
          }
          

					
						if($existUser!=null && $existUser->phone_verified==0){
    	    	    
    	    	    
    	      $phone= $existUser->phone;
         $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg =otpmsg($otpval,$phone);
         		$data = array(
    	 		//	'is_phone_verified'  =>  0,
    	 				'phone_otp_code'  =>  $otpval
    	 			
    	 	        );
    	 		
    	 			$user_edit= DB::table('users')
                ->where('phone',$phone)
                ->update($data);
    	 		
     
         	  
      $existUser = array();
                $responseData = array('success' => '2', 'data' => $existUser, 'message' => "Mobile verification pending...");
    	    	}
					

                else if($existUser!=null && $existUser->phone_verified==1){

                    $customers_id = $existUser->id;

                    //update record of customers_info
                    $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
                    $customers_info_id = $customers_id;
                    $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
                    $customers_info_number_of_logons = '1';
                    $customers_info_date_account_created = date('Y-m-d H:i:s');
                    $global_product_notifications = '1';

                    if (count($existUserInfo) > 0) {
                        //update customers_info table
                        DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                            'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                            'global_product_notifications' => $global_product_notifications,
                            'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                        ]);

                    } else {
                        //insert customers_info table
                        $customers_default_address_id = DB::table('customers_info')->insertGetId(
                            ['customers_info_id' => $customers_info_id,
                                'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                'customers_info_number_of_logons' => $customers_info_number_of_logons,
                                'customers_info_date_account_created' => $customers_info_date_account_created,
                                'global_product_notifications' => $global_product_notifications,
                            ]
                        );

                        DB::table('users')->where('id', $customers_id)->update([
                            'default_address_id' => $customers_default_address_id,
                        ]);
                    }

                    //check if already login or not
                    $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

                    if (count($already_login) > 0) {
                        DB::table('whos_online')
                            ->where('customer_id', $customers_id)
                            ->update([
                                'full_name' => $existUser->first_name . ' ' . $existUser->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                            ]);
                    } else {
                        DB::table('whos_online')
                            ->insert([
                                'full_name' => $existUser->first_name . ' ' . $existUser->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                                'customer_id' => $customers_id,
                            ]);
                    }

                    //get liked products id
                    $products = DB::table('liked_products')->select('liked_products_id as products_id')
                        ->where('liked_customers_id', '=', $customers_id)
                        ->get();

                    if (count($products) > 0) {
                        $liked_products = $products;
                    } else {
                        $liked_products = array();
                    }

                    $existUser->liked_products = $products;
					
					$existUserx=array();
					
					
					
					   DB::table('customers_basket')
                    ->where('session_id', $consumer_data['consumer_device_id'])
                      ->where('is_order','=', 0)
                    ->update([
                        'customers_id' => $customers_id,
                    ]);
                    
                    DB::table('customers_basket_attributes')
                    ->where('session_id', $consumer_data['consumer_device_id'])
                     
                    ->update([
                        'customers_id' => $customers_id,
                    ]);
                    
                    
					
$existUserx[0]=$existUser;
     $responseData = array('success' => '1', 'data' => $existUserx, 'message' => 'Data has been returned successfully!');

                } else {
                    $responseData = array('success' => '0', 'data' => array(), 'message' => "Your account is inactive , please call customer care to activate.");

                }
            } else {
                $existUser = array();
                $responseData = array('success' => '0', 'data' => array(), 'message' => "Invalid email or password.");

            }
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }


  public static function processlogin_deliveryboy($request)
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $email = $request->email;
            $password = $request->password;

           // $customerInfo = array("email" => $email, "password" => $password, 'role_id' => 2);
			 $customerInfo = array("email" => $email, "password" => $password, 'role_id' => 4);
            if (Auth::attempt($customerInfo)) {

                $existUser = DB::table('users')
                    ->where('email', $email)->where('status', '1')->first();
					
						if($existUser && $existUser->phone_verified==0){
    	    	    
    	    	    
    	      $phone= $existUser->phone;
         $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg =otpmsg($otpval,$phone);
         		$data = array(
    	 		//	'is_phone_verified'  =>  0,
    	 				'phone_otp_code'  =>  $otpval
    	 			
    	 	        );
    	 		
    	 			$user_edit= DB::table('users')
                ->where('phone',$phone)
                ->update($data);
    	 		
     
         	  
      $existUser = array();
                $responseData = array('success' => '2', 'data' => $existUser, 'message' => "Mobile verification pending...");
    	    	}
					

                else if($existUser && $existUser->phone_verified==1){

                    $customers_id = $existUser->id;

                    //update record of customers_info
                    $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
                    $customers_info_id = $customers_id;
                    $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
                    $customers_info_number_of_logons = '1';
                    $customers_info_date_account_created = date('Y-m-d H:i:s');
                    $global_product_notifications = '1';

                    if (count($existUserInfo) > 0) {
                        //update customers_info table
                        DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                            'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                            'global_product_notifications' => $global_product_notifications,
                            'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                        ]);

                    } else {
                        //insert customers_info table
                        $customers_default_address_id = DB::table('customers_info')->insertGetId(
                            ['customers_info_id' => $customers_info_id,
                                'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                'customers_info_number_of_logons' => $customers_info_number_of_logons,
                                'customers_info_date_account_created' => $customers_info_date_account_created,
                                'global_product_notifications' => $global_product_notifications,
                            ]
                        );

                        DB::table('users')->where('id', $customers_id)->update([
                            'default_address_id' => $customers_default_address_id,
                        ]);
                    }

                    //check if already login or not
                    $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

                    if (count($already_login) > 0) {
                        DB::table('whos_online')
                            ->where('customer_id', $customers_id)
                            ->update([
                                'full_name' => $existUser->first_name . ' ' . $existUser->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                            ]);
                    } else {
                        DB::table('whos_online')
                            ->insert([
                                'full_name' => $existUser->first_name . ' ' . $existUser->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                                'customer_id' => $customers_id,
                            ]);
                    }

                    //get liked products id
                    $products = DB::table('liked_products')->select('liked_products_id as products_id')
                        ->where('liked_customers_id', '=', $customers_id)
                        ->get();

                    if (count($products) > 0) {
                        $liked_products = $products;
                    } else {
                        $liked_products = array();
                    }

                    $existUser->liked_products = $products;
					
					$existUserx=array();
					
$existUserx[0]=$existUser;
     $responseData = array('success' => '1', 'data' => $existUserx, 'message' => 'Data has been returned successfully!');

                } else {
                    $responseData = array('success' => '0', 'data' => array(), 'message' => "Your account is inactive , please call customer care to activate.");

                }
            } else {
                $existUser = array();
                $responseData = array('success' => '0', 'data' => array(), 'message' => "Invalid email or password.");

            }
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }



//verify otp 

  public static function verifyCustomOTP($request)
    {
          $email = $request->email;
       
        $customers_telephone = $request->customers_telephone;
        $otp = $request->otp;        
        $customers_info_date_account_created = date('y-m-d h:i:s');

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $validator = Validator::make($request->all(), [
            
                'email' => 'required | email',
                
                'customers_telephone' => 'required',
                'otp' => 'required',
            ]);
            $errors = array();
            if ($validator->fails()){
                $e_index = 0;
                foreach($validator->errors()->messages() as $key=>$errorsmsges){
                    $errors[$e_index++] = $errorsmsges[0];                    
                }
            }
            
            if(count($errors)>0){
                $responseData = array('success' => '0', 'data' => array(), 'message' => "Some paramters are missing.");
            }else{

            //check email existance
            $existUser = DB::table('users')->where('email', $email)->Where('phone', $customers_telephone)->first();
// code added by Adinarayana - 28 SEP 2020 FOR mobile verification 

  if ($existUser  && $existUser->phone_otp_code==$otp) {
                 
				 
				 $data = array(
    				'phone_verified'  =>  1
    		);
    
    		$user_edit= DB::table('users')
    		->where('phone',$customers_telephone)
			->where('email',$email)
    		->update($data);
    
				 
                $responseData = array('success' => '1', 'data' => array(), 'message' => "OTP is verified....");
				
				
            }
              else {
 
    	 			 
                $responseData = array('success' => '0', 'data' =>array(), 'message' => "Invalid OTP");
            }
        }

        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);
        print $userResponse;
    }


//verify otp 







//verify login  otp 

  public static function verifyLoginProcessOTP($request)
    {
       //   $email = $request->email;
       
        $email_or_phone = $request->email_or_phone;
        $otp = $request->otp;        
        $customers_info_date_account_created = date('y-m-d h:i:s');

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $validator = Validator::make($request->all(), [
            
              // 'email' => 'required | email',
                
                'email_or_phone' => 'required',
                'otp' => 'required',
            ]);
            $errors = array();
            if ($validator->fails()){
                $e_index = 0;
                foreach($validator->errors()->messages() as $key=>$errorsmsges){
                    $errors[$e_index++] = $errorsmsges[0];                    
                }
            }
            
            if(count($errors)>0){
                $responseData = array('success' => '0', 'data' => array(), 'message' => "Some paramters are missing.");
            }else{

            //check email existance
            $existUser = DB::table('users')->where('email', $email_or_phone)->orWhere('phone', $email_or_phone)->first();
// code added by Adinarayana - 28 SEP 2020 FOR mobile verification 

  if ($existUser  && $existUser->phone_otp_code==$otp) {
                 
				 
				 $data = array(
    				'phone_verified'  =>  1
    		);
    
    		$user_edit= DB::table('users')
    		->where('phone',$email_or_phone)
			->orwhere('email',$email_or_phone)
    		->update($data);
    
				 
                $responseData = array('success' => '1', 'data' => array(), 'message' => "OTP is verified....");
				
				
            }
              else {
 
    	 			 
                $responseData = array('success' => '0', 'data' =>array(), 'message' => "Invalid OTP");
            }
        }

        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);
        print $userResponse;
    }


//verify login otp 



//resend Verification OTP   

  public static function resendVerificationOTP($request)
    {
          $email = $request->email;
       
        $customers_telephone = $request->customers_telephone;
       // $otp = $request->otp;        
        $customers_info_date_account_created = date('y-m-d h:i:s');

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $validator = Validator::make($request->all(), [
            
                'email' => 'required | email',
                
                'customers_telephone' => 'required',
              //  'otp' => 'required',
            ]);
            $errors = array();
            if ($validator->fails()){
                $e_index = 0;
                foreach($validator->errors()->messages() as $key=>$errorsmsges){
                    $errors[$e_index++] = $errorsmsges[0];                    
                }
            }
            
            if(count($errors)>0){
                $responseData = array('success' => '0', 'data' => array(), 'message' => "Some paramters are missing.");
            }else{

            //check email existance
            $existUser = DB::table('users')->where('email', $email)->Where('phone', $customers_telephone)->first();
// code added by Adinarayana - 28 SEP 2020 FOR mobile verification 

  if ($existUser!=null) {
                 
				  	if($existUser->phone_verified==0){
    	    	    
    	    	    
    	      $phone= $existUser->phone;
         $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg =otpmsg($otpval,$phone);
         		$data = array(
    	 		//	'is_phone_verified'  =>  0,
    	 				'phone_otp_code'  =>  $otpval
    	 			
    	 	        );
    	 		
    	 			$user_edit= DB::table('users')
                ->where('phone',$phone)
                ->update($data);
    	 		
      
    
				 
                $responseData = array('success' => '1', 'data' => array(), 'message' => "OTP is send to your mobile....");
				
				
            }
             	else if($existUser->is_phone_verified==1){ {
 
    	 			 
                $responseData = array('success' => '0', 'data' =>array(), 'message' => "Mobile number is already verified...");
            }
        }

        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);
        print $userResponse;
    }

		}
	}
//resend Verification OTP   







//resend login Verification OTP   

  public static function resendLoginVerificationOTP($request)
    {
          
       
        $email_or_phone = $request->email_or_phone;
       // $otp = $request->otp;        
        $customers_info_date_account_created = date('y-m-d h:i:s');

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $validator = Validator::make($request->all(), [
            
             //   'email' => 'required | email',
                
                'email_or_phone' => 'required',
              //  'otp' => 'required',
            ]);
            $errors = array();
            if ($validator->fails()){
                $e_index = 0;
                foreach($validator->errors()->messages() as $key=>$errorsmsges){
                    $errors[$e_index++] = $errorsmsges[0];                    
                }
            }
            
            if(count($errors)>0){
                $responseData = array('success' => '0', 'data' => array(), 'message' => "Some paramters are missing.");
            }else{

            //check email existance
            $existUser = DB::table('users')->where('email', $email_or_phone)->orWhere('phone', $email_or_phone)->first();
// code added by Adinarayana - 28 SEP 2020 FOR mobile verification 

  if ($existUser!=null) {
                 
				  	if($existUser->phone_verified==0){
    	    	    
    	    	    
    	      $phone= $existUser->phone;
         $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg =otpmsg($otpval,$phone);
         		$data = array(
    	 		//	'is_phone_verified'  =>  0,
    	 				'phone_otp_code'  =>  $otpval
    	 			
    	 	        );
    	 		
    	 			$user_edit= DB::table('users')
                ->where('phone',$phone)
                ->update($data);
    	 		
      
    
				 
                $responseData = array('success' => '1', 'data' => array(), 'message' => "OTP is send to your mobile....");
				
				
            }
             	else if($existUser->is_phone_verified==1){ {
 
    	 			 
                $responseData = array('success' => '0', 'data' =>array(), 'message' => "Mobile number is already verified...");
            }
        }

        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);
        print $userResponse;
    }

		}
	}
//resend login Verification OTP   


    public static function processregistration($request)
    {
        $customers_firstname = $request->customers_firstname;
        $customers_lastname = $request->customers_lastname;
        $email = $request->email;
        $password = $request->password;
        $customers_telephone = $request->customers_telephone;
        $customers_gender = $request->customers_gender;   
        
                $customers_type = $request->customers_type;        
                $work_force = $request->work_force;        

        $customers_info_date_account_created = date('y-m-d h:i:s');

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $validator = Validator::make($request->all(), [
                'customers_firstname' => 'required',
                'customers_lastname' => 'required',
                'email' => 'required | email',
                'password' => 'required',
                'customers_telephone' => 'required',
                'customers_type' => 'required',
            ]);
            $errors = array();
            if ($validator->fails()){
                $e_index = 0;
                foreach($validator->errors()->messages() as $key=>$errorsmsges){
                    $errors[$e_index++] = $errorsmsges[0];                    
                }
            }
            
            if(count($errors)>0){
                $responseData = array('success' => '0', 'data' => array(), 'message' => "Some paramters are missing.");
            }else{

            //check email existance
            $existUser = DB::table('users')->where('email', $email)->orWhere('phone', $customers_telephone)->first();
// code added by Adinarayana - 28 SEP 2020 FOR mobile unique

  if ($existUser  && $existUser->phone==$customers_telephone) {
                //response if email already exit
                $postData = array();
                $responseData = array('success' => '0', 'data' => $postData, 'message' => "Phone number already exists");
            }
            else if ($existUser && $existUser->email==$email) {
                //response if email already exit
                $postData = array();
                $responseData = array('success' => '0', 'data' => $postData, 'message' => "Email address already exists");
            } else {


    	 				 
    	 			 	$chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               otpmsg($otpval,$customers_telephone); 
			  
			  
			  $status='';
               if($customers_type == "BUSINESSOWNER"){
               	$status = '0';
               }else{
               	$status ='1';
               }
			  
			 
                //insert data into customer
                $customers_id = DB::table('users')->insertGetId([
                    'role_id' => 2,
                    'first_name' => $customers_firstname,
                    'last_name' => $customers_lastname,
                    'phone' => $customers_telephone,
                    'gender'=>  $customers_gender,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'customer_type'=>$customers_type,
                    'status' => $status,
                    'created_at' => date('y-m-d h:i:s'),
					'phone_otp_code'=>$otpval,
					'workforce_name'=>$work_force
                ]);

                $userData = DB::table('users')
                    ->where('users.id', '=', $customers_id)->where('status', '1')->get();
                $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");
            }
        }

        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);
        print $userResponse;
    }

    public static function notify_me($request)
    {
        $device_id = $request->device_id;
        $is_notify = $request->is_notify;
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $devices = DB::table('devices')->where('device_id', $device_id)->get();
            if (!empty($devices[0]->customers_id)) {
                $customers = DB::table('users')->where('id', $devices[0]->customers_id)->get();

                if (count($customers) > 0) {

                    foreach ($customers as $customers_data) {

                        DB::table('devices')->where('user_id', $customers_data->customers_id)->update([
                            'is_notify' => $is_notify,
                        ]);
                    }

                }
            } else {

                DB::table('devices')->where('device_id', $device_id)->update([
                    'is_notify' => $is_notify,
                ]);
            }

            $responseData = array('success' => '1', 'data' => '', 'message' => "Notification setting has been changed successfully!");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $categoryResponse = json_encode($responseData);

        return $categoryResponse;
    }

    public static function updatecustomerinfo($request)
    {
        $customers_id            			=   $request->customers_id;
        $customers_firstname            	=   $request->customers_firstname;
        $customers_lastname           		=   $request->customers_lastname;
        $customers_telephone          		=   $request->customers_telephone;
        $customers_gender          		   	=   $request->customers_gender;
        $customers_dob          		   		=   $request->customers_dob;
	//	 $customer_password          		   		=   $request->customer_password;
	
	        $image_id          		   		=   $request->image_id;

	
        $customers_info_date_account_last_modified 	=   date('y-m-d h:i:s');
        $consumer_data 		 				  =  array();
        $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
        $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
        $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
        $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
        $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
        $consumer_data['consumer_url']  	  =  __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if($authenticate==1){
        $cehckexist = DB::table('users')->where('id', $customers_id)->where('role_id', 2)->first();
            if($cehckexist){

                $customer_data = array(
                    'role_id' => 2,
                    'first_name'			 =>  $customers_firstname,
                    'last_name'			 =>  $customers_lastname,
                    'phone'			 =>  $customers_telephone,
                    'gender'				 =>  $customers_gender,
                    'dob'					 =>  $customers_dob,
                    'avatar'=>$image_id,
					//'password'=>Hash::make($customer_password);
                );


            //update into customer
            DB::table('users')->where('id', $customers_id)->update($customer_data);

            DB::table('customers_info')->where('customers_info_id', $customers_id)->update(['customers_info_date_account_last_modified'   =>   $customers_info_date_account_last_modified]);

            $userData = DB::table('users')
                ->select('users.*')->where('users.id', '=', $customers_id)->where('status', '1')->get();

            $responseData = array('success'=>'1', 'data'=>$userData, 'message'=>"Customer information has been Updated successfully");


            }else{
            $responseData = array('success'=>'3', 'data'=>array(),  'message'=>"Record not found.");
            }

        }else{
            $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }


    public static function updatepassword($request)
    {
    $customers_id            					=   $request->customers_id;
    $customers_info_date_account_last_modified 	=   date('y-m-d h:i:s');
    $consumer_data 		 				  =  array();
    $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
    $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);


    if($authenticate==1){
        $cehckexist = DB::table('users')->where('id', $customers_id)->where('role_id', 2)->first();
            if($cehckexist){
                $oldpassword    = $request->oldpassword;
                $newPassword    = $request->newpassword;

                $content = DB::table('users')->where('id', $customers_id)->first();

                $customerInfo = array("email" => $cehckexist->email, "password" => $oldpassword);

                if (Auth::attempt($customerInfo)) {

                    DB::table('users')->where('id', $customers_id)->update([
                    'password'			 =>  Hash::make($newPassword)
                    ]);

                    //get user data
                    $userData = DB::table('users')
                        ->select('users.*')
                        ->where('users.id', '=', $customers_id)->where('status', '1')->get();
                    $responseData = array('success'=>'1', 'data'=>$userData, 'message'=>"Information has been Updated successfully");
                }else{
                    $responseData = array('success'=>'2', 'data'=>array(),  'message'=>"current password does not match.");
                }
        }else{
            $responseData = array('success'=>'3', 'data'=>array(),  'message'=>"Record not found.");
        }

        }else{
            $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
        }

        $userResponse = json_encode($responseData);
        return $userResponse;
    }

    public static function processforgotpassword($request)
    {

        $email = $request->email;
        $postData = array();

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            //check email exist
            $existUser = DB::table('users')->where('email', $email)->orWhere('phone', $email)->get();

            if (count($existUser) > 0) {
                $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);




  if(is_numeric($email)){
               DB::table('users')->where('phone', $email)->update([
                    'password' => Hash::make($password),
                ]);
          }
          elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
               DB::table('users')->where('email', $email)->update([
                    'password' => Hash::make($password),
                ]);
          }
       


            

                $existUser[0]->password = $password;

               $myVar = new AlertController();
               
               //below code is for sending email.
               
              //  $alertSetting = $myVar->forgotPasswordAlert($existUser);
                $responseData = array('success' => '1', 'data' => $postData, 'message' => "Your password has been sent to your Mobile.");
				
				
				//send to mobile phone 
				
					    temp_password($password,$existUser[0]->phone);
				
				
            } else {
                $responseData = array('success' => '0', 'data' => $postData, 'message' => "Email address doesn't exist!");
            }
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function facebookregistration($request)
    {
        require_once app_path('vendor/autoload.php');
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {
            //get function from other controller
            $myVar = new AppSettingController();
            $setting = $myVar->getSetting();

            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $access_token = $request->access_token;

            $fb = new \Facebook\Facebook([
                'app_id' => $setting['facebook_app_id'],
                'app_secret' => $setting['facebook_secret_id'],
                'default_graph_version' => 'v2.2',
            ]);

            try {
                $response = $fb->get('/me?fields=id,name,email,first_name,last_name,gender,public_key', $access_token);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
            }

            $user = $response->getGraphUser();

            $fb_id = $user['id'];
            $customers_firstname = $user['first_name'];
            $customers_lastname = $user['last_name'];
            $name = $user['name'];
            if (empty($user['gender']) or $user['gender'] == 'male') {
                $customers_gender = '0';
            } else {
                $customers_gender = '1';
            }
            if (!empty($user['email'])) {
                $email = $user['email'];
            } else {
                $email = '';
            }

            //user information
            $fb_data = array(
                'fb_id' => $fb_id,
            );
            $customer_data = array(
                'role_id' => 2,
                'first_name' => $customers_firstname,
                'last_name' => $customers_lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            );

           // $existUser = DB::table('customers')->where('fb_id', '=', $fb_id)->get();
           $existUser = DB::table('users')->where('email', '=', $email)->get();
            if (count($existUser) > 0) {

                $customers_id = $existUser[0]->id;
                $success = "2";
                $message = "Customer record has been updated.";
                //update data of customer
                DB::table('customers')->where('user_id', '=', $customers_id)->update($fb_data);
            } else {
                $success = "1";
                $message = "Customer account has been created.";
                //insert data of customer
                $customers_id = DB::table('users')->insertGetId($customer_data);
                DB::table('customers')->insertGetId([
                    'fb_id' => $fb_id,
                    'user_id' => $customers_id,

                ]);

            }

            $userData = DB::table('users')->where('id', '=', $customers_id)->get();

            //update record of customers_info
            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
            $customers_info_id = $customers_id;
            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
            $customers_info_number_of_logons = '1';
            $customers_info_date_account_created = date('Y-m-d H:i:s');
            $global_product_notifications = '1';

            if (count($existUserInfo) > 0) {
                //update customers_info table
                DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                    'global_product_notifications' => $global_product_notifications,
                    'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                ]);

            } else {
                //insert customers_info table
                $customers_default_address_id = DB::table('customers_info')->insertGetId([
                    'customers_info_id' => $customers_info_id,
                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                    'customers_info_number_of_logons' => $customers_info_number_of_logons,
                    'customers_info_date_account_created' => $customers_info_date_account_created,
                    'global_product_notifications' => $global_product_notifications,
                ]);

            }

            //check if already login or not
            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();
            if (count($already_login) > 0) {
                DB::table('whos_online')
                    ->where('customer_id', $customers_id)
                    ->update([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                    ]);
            } else {
                DB::table('whos_online')
                    ->insert([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                        'customer_id' => $customers_id,
                    ]);
            }

            $responseData = array('success' => $success, 'data' => $userData, 'message' => $message);
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function googleregistration($request)
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            //gmail user information
            $access_token = $request->idToken;
            $google_id = $request->userId;
            $customers_firstname = $request->givenName;
            $customers_lastname = $request->familyName;
            $email = $request->email;

            //user information
            $google_data = array(
                'google_id' => $google_id,
            );

            $customer_data = array(
                'role_id' => 2,
                'first_name' => $customers_firstname,
                'last_name' => $customers_lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            );

            $existUser = DB::table('users')->where('email', '=', $email)->get();
            if (count($existUser) > 0) {
                $customers_id = $existUser[0]->id;
                DB::table('users')->where('id', $customers_id)->update($customer_data);
            } else {
                //insert data into customer
                $customers_id = DB::table('users')->insertGetId($customer_data);
                DB::table('customers')->insertGetId([
                    'google_id' => $google_id,
                    'user_id' => $customers_id,
                ]);

            }

            $userData = DB::table('users')->where('id', '=', $customers_id)->get();

            //update record of customers_info
            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
            $customers_info_id = $customers_id;
            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
            $customers_info_number_of_logons = '1';
            $customers_info_date_account_created = date('Y-m-d H:i:s');
            $customers_info_date_account_last_modified = date('Y-m-d H:i:s');
            $global_product_notifications = '1';

            if (count($existUserInfo) > 0) {
                $success = '2';
            } else {
                //insert customers_info table
                $customers_default_address_id = DB::table('customers_info')->insertGetId(
                    [
                        'customers_info_id' => $customers_info_id,
                        'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                        'customers_info_number_of_logons' => $customers_info_number_of_logons,
                        'customers_info_date_account_created' => $customers_info_date_account_created,
                        'global_product_notifications' => $global_product_notifications,
                    ]
                );
                $success = '1';
            }

            //check if already login or not
            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

            if (count($already_login) > 0) {
                DB::table('whos_online')
                    ->where('customer_id', $customers_id)
                    ->update([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                    ]);
            } else {

                DB::table('whos_online')
                    ->insert([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                        'customer_id' => $customers_id,
                    ]);
            }

            //$userData = $request->all();
            $responseData = array('success' => $success, 'data' => $userData, 'message' => "Login successfully");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function registerdevices($request)
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
$whathappend="";
        if ($authenticate == 1) {

            $myVar = new AppSettingController();
            $setting = $myVar->getSetting();

            $device_type = $request->device_type;

            if ($device_type == 'iOS') { /* iphone */
                $type = 1;
            } elseif ($device_type == 'Android') { /* android */
                $type = 2;
            } elseif ($device_type == 'Desktop') { /* other */
                $type = 3;
            }

            if (!empty($request->customers_id)) {

                $device_data = array(
                    'device_id' => $request->device_id,
                    'device_type' => $type,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'ram' => $request->ram,
                    'status' => '1',
                    'processor' => $request->processor,
                    'device_os' => $request->device_os,
                    'location' => $request->location,
                    'device_model' => $request->device_model,
                    'user_id' => $request->customers_id,
                    'manufacturer' => $request->manufacturer,
                );
                
                $whathappend.=" customer id  ".$request->customers_id;

            } else {

                $device_data = array(
                    'device_id' => $request->device_id,
                    'device_type' => $type,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => '1',
                    'ram' => $request->ram,
                    'processor' => $request->processor,
                    'device_os' => $request->device_os,
                    'location' => $request->location,
                    'device_model' => $request->device_model,
                    'manufacturer' => $request->manufacturer,
                );
                
                                $whathappend.=" no customer id";


            }

            //check device exist
            $device_id = DB::table('devices')->where('device_id', '=', $request->device_id)->get();

            if (count($device_id) > 0) {

                $dataexist = DB::table('devices')->where('device_id', '=', $request->device_id)->where('user_id', '!=', '0')->get();

                DB::table('devices')
                    ->where('device_id', $request->device_id)
                    ->update($device_data);

                if (count($dataexist) >= 0) {
                    
                      $whathappend.="  device exists in database ";
                    
                    $userData = DB::table('users')->where('id', '=', $request->customers_id)->get();
                    //notification
                    $myVar = new AlertController();
                    $alertSetting = $myVar->createUserAlert($userData);
                }
            } else {
                $device_id = DB::table('devices')->insertGetId($device_data);
                
                                      $whathappend.="  new device regisgtered . ";

            }

            $responseData = array('success' => '1', 'data' => array(), 'message' => "Device is registered.".$whathappend);
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }
    
    
    
    
    
    
    
    
      public static function wallet_history($request)
    {
      
   $consumer_data = array();
      $consumer_data['consumer_key'] = request()->header('consumer-key');
      $consumer_data['consumer_secret'] = request()->header('consumer-secret');
      $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
      $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
      $consumer_data['consumer_ip'] = request()->header('consumer-ip');
      $consumer_data['consumer_url'] = __FUNCTION__;
      $authController = new AppSettingController();
     $authenticate = $authController->apiAuthenticate($consumer_data);
        $customer_id=  $request->customers_id;
 
        if ($authenticate==1) {
      $wallethistory = DB::table('wallet')
    	->LeftJoin('users', 'users.id', '=', 'wallet.customer_id')
    	->select('wallet.*','users.first_name','users.last_name')
    	->where('wallet.customer_id',$customer_id)
    	->get();
    	
    	//get the balance 
    	
    	
    	 $wallet_amount = DB::table('wallet')
            ->where('wallet.customer_id', '=', $customer_id)
            ->sum('wallet.wallet_amount');
    	
    	  $orders_amount = DB::table('orders')
            ->where('orders.customers_id', '=', $customer_id)
           ->where('orders.payment_method', '=', "Buildermart Wallet")
            ->sum('orders.order_price');
            
    
            
            $remainingwallet_amount = $wallet_amount- $orders_amount;
            
       //   $wallethistory['remainingwallet_amount'] = $remainingwallet_amount;
            
              
             $responseData = array('success' => '1', 'data' => $wallethistory,'remainingwallet_amount'=>$remainingwallet_amount, 'message' => "Returned all wallet data.");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }

        $categoryResponse = json_encode($responseData);
        print $categoryResponse;
          
    }
    
    
    
    
    
      public static function cashback_history($request)
    {
      
   $consumer_data = array();
      $consumer_data['consumer_key'] = request()->header('consumer-key');
      $consumer_data['consumer_secret'] = request()->header('consumer-secret');
      $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
      $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
      $consumer_data['consumer_ip'] = request()->header('consumer-ip');
      $consumer_data['consumer_url'] = __FUNCTION__;
      $authController = new AppSettingController();
     $authenticate = $authController->apiAuthenticate($consumer_data); 
        $customer_id=  $request->customers_id;
 
        if ($authenticate==1) {
      
      
      
      $cashback_request = DB::table('cashback_transactions')
    	->where('cashback_transactions.user_id', '=', $customer_id)
    	->get();
    
    	
    	$cashback_amount = DB::table('orders')
    	->where('orders.customers_id', '=', $customer_id)
    	->sum('orders.cashback_amount');
    	 
    	 
    	
    	$cashback_paidamount = DB::table('cashback_transactions')
    	->where('cashback_transactions.user_id', '=', $customer_id)
    	->sum('cashback_transactions.request_amount');
    	 
    	 
    	$balancecashback_amount= $cashback_amount - $cashback_paidamount;
     
    	
            
              
             $responseData = array('success' => '1', 'data' => $cashback_request,'remainingcashback_amount'=>$balancecashback_amount,'cashback_amount'=>$cashback_amount, 'message' => "Returned all wallet data.");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }

        $categoryResponse = json_encode($responseData);
        print $categoryResponse;
          
    }
    
    
      public static function withdrawCashbackrequest($request)
    {
    $customers_id             =   $request->customers_id;
   $customers_info_date_account_last_modified =   date('y-m-d h:i:s');
    $consumer_data  =  array();
    $consumer_data['consumer_key']  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']  =  request()->header('consumer-nonce');
    $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']    = request()->header('consumer-ip');
    $consumer_data['consumer_url']    =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);  
 
    if($authenticate==1){
   
    
   
    $cashback_amount = DB::table('orders')
    ->where('orders.customers_id', '=', $customers_id)
    ->sum('orders.cashback_amount');
   
   
   
    $cashback_paidamount = DB::table('cashback_transactions')
    ->where('cashback_transactions.user_id', '=', $customers_id)
    ->sum('cashback_transactions.request_amount');
   
   
    $balancecashback_amount= $cashback_amount - $cashback_paidamount;
   
   
    $requestamount= $request->request_amount;
   
   
   
    if($requestamount>0 && $requestamount <= $balancecashback_amount) {
   
    $message = DB::table("cashback_transactions")->insert([
   
    'user_id' => $customers_id,
    'request_amount' =>$requestamount,
    'request_date' =>date('Y-m-d H:i:s'),
    'status' => 'PENDING'
   
   
   
    ]);
    
    //afte transaction get the balance 
    $cashback_amount = DB::table('orders')
    ->where('orders.customers_id', '=', $customers_id)
    ->sum('orders.cashback_amount');
   
   
   
    $cashback_paidamount = DB::table('cashback_transactions')
    ->where('cashback_transactions.user_id', '=', $customers_id)
    ->sum('cashback_transactions.request_amount');
   
   
    $balancecashback_amount= $cashback_amount - $cashback_paidamount;
   
    
    //after transaction get the balanc e
      
      $cashback_request = DB::table('cashback_transactions')
    	->where('cashback_transactions.user_id', '=', $customers_id)
    	->get();
   
    $responseData = array('success'=>'1','data'=>$cashback_request, 'message'=>"Cashback Withdrawl Request is Pending, You Will Receive The Cashback within 24 Hours",'remainingcashback_amount'=>$balancecashback_amount,'cashback_amount'=>$cashback_amount,);
   
   
    }else{
   
   
    $responseData = array('success'=>'0','message'=>"Your Withdrawl Amount is Greater Than Cashback Amount");
   
    }
   
   
   
    }else{
    $responseData = array('success'=>'0', 'message'=>"Unauthenticated call.");
      }
   
    $userResponse = json_encode($responseData);
    return $userResponse;
    }





 
      public static function getJobPostingList($request)
    {
      
   $consumer_data = array();
      $consumer_data['consumer_key'] = request()->header('consumer-key');
      $consumer_data['consumer_secret'] = request()->header('consumer-secret');
      $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
      $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
      $consumer_data['consumer_ip'] = request()->header('consumer-ip');
      $consumer_data['consumer_url'] = __FUNCTION__;
      $authController = new AppSettingController();
     $authenticate = $authController->apiAuthenticate($consumer_data); 
       
 
        if ($authenticate==1) {
      
      
      
      $jobslist = DB::table('jobs')
    	->where('status', '=', 1)
    	->get();
    
     
            
              
             $responseData = array('success' => '1', 'data' => $jobslist, 'message' => "Returned all jobs data.");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }

        $categoryResponse = json_encode($responseData);
        print $categoryResponse;
          
    }
    
    

}
