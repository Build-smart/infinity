<?php

namespace App\Models\AppModels;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminSiteSettingController;
use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\App\AppSettingController;
use App\Http\Controllers\App\AlertController;
use App\Models\AppModels\Product;
use DB;
use Lang;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;
use Mail;
use DateTime;
use Auth;
use Carbon;
use Hash;

class Orders extends Model
{

  public static function convertprice($current_price, $requested_currency)
  {
    $required_currency = DB::table('currencies')->where('is_current',1)->where('code', $requested_currency)->first();
    $products_price = $current_price * $required_currency->value;

    return $products_price;
  }

  public static function converttodefaultprice($current_price, $requested_currency)
  {
    $required_currency = DB::table('currencies')->where('is_current',1)->where('code', $requested_currency)->first();
    $products_price = $current_price * $required_currency->value;
    return $products_price;
  }

  public static function currencies($currency_code){
   $currencies = DB::table('currencies')->where('is_current',1)->where('code', $currency_code)->first();
   return $currency_code;
  }

 public static function hyperpaytoken($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){
    $payments_setting = Orders::payments_setting_for_hyperpay($request);

    //check envinment
    if($payments_setting[0]->hyperpay_enviroment == '0'){
      $env_url = "https://test.oppwa.com/v1/checkouts";
    }else{
      $env_url = "https://oppwa.com/v1/checkouts";
    }

    //use currency account currency only e:g. 'SAR'
    $url = $env_url;
    $data = "authentication.userId=" .$payments_setting['userid']->value.
			"&authentication.password=" .$payments_setting['password']->value.
			"&authentication.entityId=" .$payments_setting['entityid']->value.
      "&amount=" . $request->amount.
      "&currency=SAR" .
      "&paymentType=DB".
      "&customer.email=".$request->email.
      "&testMode=INTERNAL".
      "&merchantTransactionId=". uniqid();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseData = curl_exec($ch);
    if(curl_errno($ch)) {
      return curl_error($ch);
    }
    curl_close($ch);

    $data = json_decode($responseData);

    if($data->result->code=='000.200.100'){
      $responseData = array('success'=>'1', 'token'=>$data->id, 'message'=>"Token generated.");
    }else{
      $responseData = array('success'=>'2', 'token'=>array(), 'message'=>$data->result->description);
    }

  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function generatebraintreetoken($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){
    $payments_setting = Orders::payments_setting_for_brain_tree($request);

    //braintree transaction get nonce
    $is_transaction  = '0'; 			# For payment through braintree

    if($payments_setting['merchant_id']->environment == '0'){
			$braintree_environment = 'sandbox';
		}else{
			$environment = 'production';
    }

    $braintree_merchant_id = $payments_setting['merchant_id']->value;
    $braintree_public_key  = $payments_setting['public_key']->value;
    $braintree_private_key = $payments_setting['private_key']->value;

    //for token please check index.php file
    require_once app_path('braintree/index.php');

    $responseData = array('success'=>'1', 'token'=>$clientToken, 'message'=>"Token generated.");
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function getpaymentmethods($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;

  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){

    $result = array();
    $payments_setting = Orders::payments_setting_for_brain_tree($request);

		if($payments_setting['merchant_id']->environment=='0'){
			$braintree_enviroment = 'Test';
		}else{
			$braintree_enviroment = 'Live';
		}

    $braintree_card = array(
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $braintree_enviroment,
			'name' => $payments_setting['merchant_id']->name,
			'public_key' => $payments_setting['public_key']->value,
			'active' => $payments_setting['merchant_id']->status,
			'payment_method'=>$payments_setting['merchant_id']->payment_method,
			'method'=>'braintree_card',
    );

    $braintree_paypal = array(
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $braintree_enviroment,
			'name' => $payments_setting['merchant_id']->sub_name_2,
			'public_key' => $payments_setting['public_key']->value,
			'active' => $payments_setting['merchant_id']->status,
			'payment_method'=>$payments_setting['merchant_id']->payment_method,
			'method' => 'braintree_paypal',
    );

    $payments_setting = Orders::payments_setting_for_stripe($request);

    if($payments_setting['publishable_key']->environment=='0'){
      $stripe_enviroment = 'Test';
    }else{
      $stripe_enviroment = 'Live';
    }

    $stripe = array(
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $stripe_enviroment,
      'name' => $payments_setting['publishable_key']->name,
      'public_key' => $payments_setting['publishable_key']->value,
      'active' => $payments_setting['publishable_key']->status,
			'payment_method'=>$payments_setting['publishable_key']->payment_method,
			'method' => 'stripe',
    );

    $payments_setting = Orders::payments_setting_for_cod($request);

    $cod = array(
      'environment' => '',
      'method' => 'cod',
      'public_key' => '',
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'name' => $payments_setting->name,
      'active' => $payments_setting->status,
			'payment_method'=>'cod'
    );




    $login_id= $request->customers_id;
   
    $wallet_amount = DB::table('wallet')
    ->where('wallet.customer_id', '=', $login_id)
    ->sum('wallet.wallet_amount');
   
   $orders_amount = DB::table('orders')
    ->where('orders.customers_id', '=', $login_id)
    ->where('orders.payment_method', '=', "Buildermart Wallet")
    ->sum('orders.order_price'); 
   
       $remainingwallet_amount = $wallet_amount- $orders_amount;

   
   
     $cartprice= $request->total_price;;
 
if($remainingwallet_amount > $cartprice){

   $payments_setting = Orders::payments_setting_for_buildermart_wallet($request);

    $buildermart_wallet = array(
      'environment' => '',
      'method' => 'buildermart_wallet',
      'public_key' => '',
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'name' => $payments_setting->name,
      'active' => $payments_setting->status,
			'payment_method'=>'cod'
    );

}
  
  /*
  $responseData = array('success'=>'1', 'data'=>$result, 'message'=>"customer id ".$login_id."cartprice  ".$cartprice."wallet ".$wallet_amount." remainingwallet_amount".$remainingwallet_amount);
  
  $orderResponse = json_encode($responseData);
  return $orderResponse;
*/

    $payments_setting = Orders::payments_setting_for_instamojo($request);

    if($payments_setting['auth_token']->environment=='0'){
			$instamojo_enviroment = 'Test';
		}else{
			$instamojo_enviroment = 'Live';
		}

    $instamojo = array(
      'environment' => $instamojo_enviroment,
      'name' => $payments_setting['auth_token']->name,
      'method' => 'instamojo',
      'public_key' => $payments_setting['api_key']->value,
      'auth_token' => $payments_setting['auth_token']->value,
      'client_id' => $payments_setting['client_id']->value,
      'client_secret' => $payments_setting['client_secret']->value,
      'active' => $payments_setting['api_key']->status,
			'payment_method'=>'instamojo',
    );

    $payments_setting = Orders::payments_setting_for_hyperpay($request);

    if($payments_setting['userid']->environment=='0'){
			$hyperpay_enviroment = 'Test';
		}else{
			$hyperpay_enviroment = 'Live';
		}

    $hyperpay = array(
      'method' => 'hyperpay',
      'public_key' => '',
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $hyperpay_enviroment,
      'name' => $payments_setting['userid']->name,
      'active' => $payments_setting['userid']->status,
			'payment_method'=>'hyperpay',
    );

    $payments_setting = Orders::payments_setting_for_razorpay($request);
        
    if ($payments_setting['RAZORPAY_SECRET']->environment == '0') {
        $razorpay_enviroment = 'Test';
    } else {
        $razorpay_enviroment = 'Live';
    }

    $razorpay = array(
      'method' => 'razorpay',
      'public_key' => $payments_setting['RAZORPAY_KEY']->value,
      'auth_token' => '',
      'client_id' => $payments_setting['RAZORPAY_KEY']->value,
      'client_secret' => $payments_setting['RAZORPAY_SECRET']->value,
      'environment' => $razorpay_enviroment,
      'name' => $payments_setting['RAZORPAY_KEY']->name,
      'active' => $payments_setting['RAZORPAY_SECRET']->status,
      'payment_method'=> 'razorpay',
    );

    $payments_setting = Orders::payments_setting_for_paytm($request);
        
    if ($payments_setting['paytm_mid']->environment == '0') {
      $paytm_enviroment = 'Test';
    } else {
        $paytm_enviroment = 'Live';
    }
    
    $paytm = array(
      'method' => 'paytm',
      'public_key' => $payments_setting['paytm_mid']->value,
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $paytm_enviroment,
      'name' => $payments_setting['paytm_mid']->name,
      'active' => $payments_setting['paytm_mid']->status,
      'payment_method'=> 'paytm',
    );

    $payments_setting = Orders::payments_setting_for_directbank($request);     

        if ($payments_setting['account_name']->environment == '0') {
            $enviroment = 'Live';
        } else {
            $enviroment = 'Live';
        }

        $banktransfer = array(

          'method' => 'directbank',
          'public_key' => $payments_setting['account_name']->value,
          'auth_token' => '',
          'client_id' => '',
          'client_secret' => '',
          'environment' => $enviroment,
          'name' => $payments_setting['account_name']->name,
          'active' => $payments_setting['account_name']->status,
          'payment_method'=> 'directbank'
        );

    $payments_setting = Orders::payments_setting_for_paystack($request);
    
    if ($payments_setting['public_key']->environment == '0') {
      $enviroment = 'Test';
    } else {
        $enviroment = 'Live';
    }
    
    $paystack = array(
      'method' => 'paystack',
      'public_key' => $payments_setting['public_key']->value,
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => $payments_setting['secret_key']->value,
      'environment' => $enviroment,
      'name' => $payments_setting['secret_key']->name,
      'active' => $payments_setting['secret_key']->status,
      'payment_method'=> 'paystack',
    );
        


    $result[] = $braintree_card;
    $result[] = $braintree_paypal;
    $result[] = $stripe;
    $result[] = $cod;
    $result[] = $instamojo;
    $result[] = $hyperpay;
    $result[] = $razorpay;
    $result[] = $paytm;
        
          if($remainingwallet_amount > $cartprice){
$result[] = $buildermart_wallet;
        
    }

    
   // $result[9] = $banktransfer;
    //$result[10] = $paystack;

    $responseData = array('success'=>'1', 'data'=>$result, 'message'=>"Payment methods are returned.");
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function payments_setting_for_brain_tree($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*','payment_description.sub_name_1','payment_description.sub_name_2','payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',1)->get()->keyBy('key');

  if(empty($payment_method) or count($payment_method)==0){
    $payments_setting = DB::table('payment_methods_detail')
    ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
    ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
    ->select('payment_methods_detail.*','payment_description.sub_name_1','payment_description.sub_name_2','payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
    ->where('language_id', 1)
    ->where('payment_description.payment_methods_id',1)->get()->keyBy('key');
  }

  return $payments_setting;
}

public static function payments_setting_for_stripe($request){
  $payments_setting = DB::table('payment_methods_detail')
    ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
    ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
    ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
    ->where('language_id', $request->language_id)
    ->where('payment_description.payment_methods_id',2)->get()->keyBy('key');

  if(empty($payment_method) or count($payment_method)==0){
    $payments_setting = DB::table('payment_methods_detail')
      ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
      ->where('language_id', 1)
      ->where('payment_description.payment_methods_id',2)->get()->keyBy('key');
  }

  return $payments_setting;
}

public static function payments_setting_for_cod($request){
  $payments_setting = DB::table('payment_description')
    ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_description.payment_methods_id')
    ->select('payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
    ->where('language_id', $request->language_id)
    ->where('payment_description.payment_methods_id',4)->first();

  if(empty($payment_method) or count($payment_method)==0){
    $payments_setting = DB::table('payment_description')
    ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_description.payment_methods_id')
    ->select('payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
    ->where('language_id', 1)
    ->where('payment_description.payment_methods_id',4)->first();
  }
  return $payments_setting;
}



public static function payments_setting_for_buildermart_wallet($request){
  $payments_setting = DB::table('payment_description')
    ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_description.payment_methods_id')
    ->select('payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
    ->where('language_id', $request->language_id)
    ->where('payment_description.payment_methods_id',12)->first();

  if(empty($payment_method) or count($payment_method)==0){
    $payments_setting = DB::table('payment_description')
    ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_description.payment_methods_id')
    ->select('payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
    ->where('language_id', 1)
    ->where('payment_description.payment_methods_id',12)->first();
  }
  return $payments_setting;
}


public static function payments_setting_for_instamojo($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',5)->get()->keyBy('key');

  if(empty($payment_method) or count($payment_method)==0){
    $payments_setting = DB::table('payment_methods_detail')
      ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
      ->where('language_id', 1)
      ->where('payment_description.payment_methods_id',5)->get()->keyBy('key');
  }

  return $payments_setting;
}

public static function payments_setting_for_directbank($request)
  {
      $payments_setting = DB::table('payment_methods_detail')
        ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
        ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
        ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 
        'payment_methods.payment_method', 'payment_description.sub_name_1')
        ->where('language_id', $request->language_id)
        ->where('payment_description.payment_methods_id', 9)
        ->get()->keyBy('key');

          if(empty($payment_method) or count($payment_method)==0){
            $payments_setting = DB::table('payment_methods_detail')
              ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
              ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
              ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 
              'payment_methods.payment_method', 'payment_description.sub_name_1')
              ->where('language_id', 1)
              ->where('payment_description.payment_methods_id', 9)
              ->get()->keyBy('key');
          }

      return $payments_setting;
}

public static function payments_setting_for_paystack($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',10)->get()->keyBy('key');

  if(empty($payment_method) or count($payment_method)==0){
    $payments_setting = DB::table('payment_methods_detail')
      ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
      ->where('language_id', 1)
      ->where('payment_description.payment_methods_id',10)->get()->keyBy('key');
  }

  return $payments_setting;
}

public static function payments_setting_for_hyperpay($request){
  $payments_setting = DB::table('payment_methods_detail')
    ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
    ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
    ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
    ->where('language_id', $request->language_id)
    ->where('payment_description.payment_methods_id',6)->get()->keyBy('key');
    
    if(empty($payment_method) or count($payment_method)==0){
      $payments_setting = DB::table('payment_methods_detail')
      ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
      ->where('language_id', 1)
      ->where('payment_description.payment_methods_id',6)->get()->keyBy('key');
    }
    return $payments_setting;
}

public static function payments_setting_for_razorpay($request){
    $payments_setting = DB::table('payment_methods_detail')
        ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
        ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
        ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
        ->where('language_id', $request->language_id)
        ->where('payment_description.payment_methods_id', 7)
        ->get()->keyBy('key');

        if(empty($payment_method) or count($payment_method)==0){
          $payments_setting = DB::table('payment_methods_detail')
          ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
          ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
          ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
          ->where('language_id', 1)
          ->where('payment_description.payment_methods_id', 7)
          ->get()->keyBy('key');
        }
    return $payments_setting;
}

public static function payments_setting_for_paytm($request){
  $payments_setting = DB::table('payment_methods_detail')
      ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
      ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
      ->where('language_id', $request->language_id)
      ->where('payment_description.payment_methods_id', 8)
      ->get()->keyBy('key');

      if(empty($payment_method) or count($payment_method)==0){
        $payments_setting = DB::table('payment_methods_detail')
        ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
        ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
        ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
        ->where('language_id', 1)
        ->where('payment_description.payment_methods_id', 8)
        ->get()->keyBy('key');
      }
      
  return $payments_setting;
}

public static function getrate($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);
  
  if($authenticate==1){

    //tax rate
    $tax_zone_id   			=   $request->tax_zone_id;
    $requested_currency =   $request->currency_code;

    $index = '0';
    $total_tax = '0';
    $is_number = true;
    $total_price = 0;
    foreach($request->products as $products_data){
      $final_price = $request->products[$index]['final_price'];
      $total_price += $final_price;
      $products = DB::table('products')
        ->LeftJoin('tax_rates', 'tax_rates.tax_class_id','=','products.products_tax_class_id')
        ->where('tax_rates.tax_zone_id', $tax_zone_id)
        ->where('products_id', $products_data['products_id'])->get();
      if(count($products)>0){
          
         //below line added to get the total quantity with tax.... on 8 jan 2021
            $final_price = $final_price*$request->products[$index]['customers_basket_quantity'];
          
          
        $tax_value = $products[0]->tax_rate/100*$final_price;
        $total_tax = $total_tax+$tax_value;
        $index++;
      }
    }

    if($total_tax>0){
      $total_tax = Orders::convertprice($total_tax, $requested_currency);
      $data['tax'] = $total_tax;
    }else{
      $data['tax'] = '0';
    }


    $countries = DB::table('countries')->where('countries_id','=',$request->country_id)->get();

    //website path
    $websiteURL =  "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $replaceURL = str_replace('getRate','', $websiteURL);
    $requiredURL = $replaceURL.'app/ups/ups.php';


    //default shipping method
    $shippings = DB::table('shipping_methods')->get();
    
		$settings = DB::table('settings')->get();
    
    $result = array();

    foreach($shippings as $shipping_methods){
      //ups shipping rate
      if($shipping_methods->methods_type_link == 'upsShipping' and $shipping_methods->status == '1'){
        $result2= array();
        $is_transaction = '0';

        $ups_shipping = DB::table('ups_shipping')->where('ups_id', '=', '1')->get();

        //shipp from and all credentials
        $accessKey  = $ups_shipping[0]->access_key;
        $userId 	= $ups_shipping[0]->user_name;
        $password 	= $ups_shipping[0]->password;

        //ship from address
        $fromAddress  = $ups_shipping[0]->address_line_1;
        $fromPostalCode  = $ups_shipping[0]->post_code;
        $fromCity  = $ups_shipping[0]->city;
        $fromState  = $ups_shipping[0]->state;
        $fromCountry  = $ups_shipping[0]->country;

        //ship to address
        $toPostalCode = $request->postcode;
        $toCity = $request->city;
        $toState = $request->state;
        $toCountry = $countries[0]->countries_iso_code_2;
        $toAddress = $request->street_address;

        //product detail
        $products_weight = $request->products_weight;
        $products_weight_unit = $request->products_weight_unit;
        $productsWeight = 0;
        //change G or KG to LBS
        if($products_weight_unit=='g'){
          $productsWeight = $products_weight/453.59237;
        }else if($products_weight_unit=='kg'){
          $productsWeight = $products_weight/0.45359237;
        }

        //production or test mode
        if($ups_shipping[0]->shippingEnvironment == 1){ 			#production mode
          $useIntegration = true;
        }else{
          $useIntegration = false;								#test mode
        }

        $serviceData = explode(',',$ups_shipping[0]->serviceType);


        $index = 0;
        $description = DB::table('shipping_description')->where([
                  ['language_id', '=', $request->language_id],
                  ['table_name', '=',  'ups_shipping'],
                ])->get();

        $sub_labels = json_decode($description[0]->sub_labels);

        foreach($serviceData as $value){
          if($value == "US_01")
          {
            $name = $sub_labels->nextDayAir;
            $serviceTtype = "1DA";
          }
          else if ($value == "US_02")
          {
            $name = $sub_labels->secondDayAir;
            $serviceTtype = "2DA";
          }
            else if ($value == "US_03")
          {
            $name = $sub_labels->ground;
            $serviceTtype = "GND";
          }
          else if ($value == "US_12")
          {
            $name = $sub_labels->threeDaySelect;
            $serviceTtype = "3DS";
          }
          else if ($value == "US_13")
          {
            $name = $sub_labels->nextDayAirSaver;
            $serviceTtype = "1DP";
          }
          else if ($value == "US_14")
          {
            $name = $sub_labels->nextDayAirEarlyAM;
            $serviceTtype = "1DM";
          }
          else if ($value == "US_59")
          {
            $name = $sub_labels->secondndDayAirAM;
            $serviceTtype = "2DM";
          }
          else if($value == "IN_07")
          {
            $name = Lang::get("labels.Worldwide Express");
            $serviceTtype = "UPSWWE";
          }
          else if ($value == "IN_08")
          {
            $name = Lang::get("labels.Worldwide Expedited");
            $serviceTtype = "UPSWWX";
          }
          else if ($value == "IN_11")
          {
            $name = Lang::get("labels.Standard");
            $serviceTtype = "UPSSTD";
          }
          else if ($value == "IN_54")
          {
            $name = Lang::get("labels.Worldwide Express Plus");
            $serviceTtype = "UPSWWEXPP";
          }

        $some_data = array(
          'access_key' => $accessKey,  						# UPS License Number
          'user_name' => $userId,								# UPS Username
          'password' => $password, 							# UPS Password
          'pickUpType' => '03',								# Drop Off Location
          'shipToPostalCode' => $toPostalCode, 				# Destination  Postal Code
          'shipToCountryCode' => $toCountry,					# Destination  Country
          'shipFromPostalCode' => $fromPostalCode, 			# Origin Postal Code
          'shipFromCountryCode' => $fromCountry,				# Origin Country
          'residentialIndicator' => 'IN', 					# Residence Shipping and for commercial shipping "COM"
          'cServiceCodes' => $serviceTtype, 					# Sipping rate for UPS Ground
          'packagingType' => '02',
          'packageWeight' => $productsWeight
          );

          $curl = curl_init();
          // You can also set the URL you want to communicate with by doing this:
          // $curl = curl_init('http://localhost/echoservice');

          // We POST the data
          curl_setopt($curl, CURLOPT_POST, 1);
          // Set the url path we want to call
          curl_setopt($curl, CURLOPT_URL, $requiredURL);
          // Make it so the data coming back is put into a string
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          // Insert the data
          curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

          // You can also bunch the above commands into an array if you choose using: curl_setopt_array

          // Send the request
          $rate = curl_exec($curl);
          // Free up the resources $curl is using
          curl_close($curl);
         $ups_description = DB::table('shipping_description')->where('table_name','ups_shipping')->where('language_id',$request->language_id)->get();
         if(!empty($ups_description[0]->name)){
          $methodName = $ups_description[0]->name;
         }else{
          $methodName = 'UPS Shipping';
         }
         if (is_numeric($rate)){
          $rate = Orders::convertprice($rate, $requested_currency);
          $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
          $result2[$index] = array('name'=>$name,'rate'=>$rate,'currencyCode'=>$requested_currency,'shipping_method'=>'upsShipping');
          $index++;
         }
         else{
          $success = array('success'=>'0','message'=>"Selected regions are not supported for UPS shipping", 'name'=>$ups_description[0]->name);
         }

          $success['services'] = $result2;
          $result['upsShipping'] = $success;

        }


      }else if($shipping_methods->methods_type_link == 'flateRate' and $shipping_methods->status == '1'){
                           
        
        $description = DB::table('shipping_description')->where('table_name','flate_rate')->where('language_id',$request->language_id)->get();

        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Flate Rate';
        }

        $ups_shipping = DB::table('flate_rate')->where('id', '=', '1')->get();
        
      /*  if($settings[82]->value <= $total_price){
          $rate = 0;
        }else{
          $rate = Orders::convertprice($ups_shipping[0]->flate_rate, $requested_currency);
        }
        */
         $rate = Orders::convertprice($ups_shipping[0]->flate_rate, $requested_currency);
        $data2 =  array('name'=>$methodName,'rate'=>$rate,'currencyCode'=>$requested_currency,'shipping_method'=>'flateRate');
        if(count($ups_shipping)>0){
          $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
          $success['services'][0] = $data2;
          $result['flateRate'] = $success;
        }


      }else if($shipping_methods->methods_type_link == 'localPickup' and $shipping_methods->status == '1') {
        $description = DB::table('shipping_description')->where('table_name','local_pickup')->where('language_id',$request->language_id)->get();

        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Local Pickup';
        }

        $data2 =  array('name'=>$methodName, 'rate'=>'0', 'currencyCode'=>$requested_currency, 'shipping_method'=>'localPickup');
        $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
        $success['services'][0] = $data2;
        $result['localPickup'] = $success;

      }else if($shipping_methods->methods_type_link == 'freeShipping'  and $shipping_methods->status == '1'){
        $description = DB::table('shipping_description')->where('table_name','free_shipping')->where('language_id',$request->language_id)->get();

        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Free Shipping';
        }

        $data2 =  array('name'=>$methodName,'rate'=>'0','currencyCode'=>$requested_currency,'shipping_method'=>'freeShipping');
        $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
        $success['services'][0] = $data2;
        $result['freeShipping'] = $success;

      }else if($shipping_methods->methods_type_link == 'shippingByWeight'  and $shipping_methods->status == '1'){
        $description = DB::table('shipping_description')->where('table_name','shipping_by_weight')->where('language_id',$request->language_id)->get();
        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Shipping Price';
        }

        $weight = $request->products_weight;

        //check price by weight
        $priceByWeight = DB::table('products_shipping_rates')->where('weight_from','<=',$weight)->where('weight_to','>=',$weight)->get();

        if(!empty($priceByWeight) and count($priceByWeight)>0 ){
          if($settings[82]->value <= $total_price){
            $rate = 0;
          }else{
            $price = $priceByWeight[0]->weight_price;
            $rate = Orders::convertprice($price, $requested_currency);
          }
        }else{
          $rate = 0;
        }

        $data2 =  array('name'=>$methodName,'rate'=>$rate,'currencyCode'=>$requested_currency,'shipping_method'=>'Shipping Price');
        $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
        $success['services'][0] = $data2;
        $result['shippingprice'] = $success;
      }
    }
    $data['shippingMethods'] = $result;

    $responseData = array('success'=>'1', 'data'=>$data, 'message'=>"Data is returned.");
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}


public static function getcoupon($request)
{

  		$result = array();
  		$consumer_data 		 				  =  array();
  		$consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  		$consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  		$consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  		$consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
      $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  		$consumer_data['consumer_url']  	  =  __FUNCTION__;
  		$authController = new AppSettingController();
  		$authenticate = $authController->apiAuthenticate($consumer_data);

  		if($authenticate==1){

  			$coupons = DB::table('coupons')->where('code', '=', $request->code)->get();

  			if(count($coupons)>0){

  				if(!empty($coupons[0]->product_ids)){
  					$product_ids = explode(',', $coupons[0]->product_ids);
  					$coupons[0]->product_ids =  $product_ids;
  				}
  				else{
  					$coupons[0]->product_ids = array();
  				}

  				if(!empty($coupons[0]->exclude_product_ids)){
  					$exclude_product_ids = explode(',', $coupons[0]->exclude_product_ids);
  					$coupons[0]->exclude_product_ids =  $exclude_product_ids;
  				}else{
  					$coupons[0]->exclude_product_ids =  array();
  				}

  				if(!empty($coupons[0]->product_categories)){
  					$product_categories = explode(',', $coupons[0]->product_categories);
  					$coupons[0]->product_categories =  $product_categories;
  				}else{
  					$coupons[0]->product_categories =  array();
  				}

  				if(!empty($coupons[0]->excluded_product_categories)){
  					$excluded_product_categories = explode(',', $coupons[0]->excluded_product_categories);
  					$coupons[0]->excluded_product_categories =  $excluded_product_categories;
  				}else{
  					$coupons[0]->excluded_product_categories = array();
  				}

  				if(!empty($coupons[0]->email_restrictions)){
  					$email_restrictions = explode(',', $coupons[0]->email_restrictions);
  					$coupons[0]->email_restrictions =  $email_restrictions;
  				}else{
  					$coupons[0]->email_restrictions =  array();
  				}

  				if(!empty($coupons[0]->used_by)){
  					$used_by = explode(',', $coupons[0]->used_by);
  					$coupons[0]->used_by =  $used_by;
  				}else{
  					$coupons[0]->used_by =  array();
  				}

  				$responseData = array('success'=>'1', 'data'=>$coupons, 'message'=>"Coupon info is returned.");
  			}else{
  				$responseData = array('success'=>'0', 'data'=>$coupons, 'message'=>"Coupon doesn't exist.");
  			}
  		}else{
  			$responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  		}

  		$orderResponse = json_encode($responseData);

      return $orderResponse;
}




public static function addtoorder($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;

  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);
  $ipAddress = Orders::get_client_ip_env();
$customer_type="";
  if($authenticate==1){
      
    
      // foreach($request->products as $products){
      //   $req = array();
      //   $req['products_id'] = $products['products_id'];
      //   $attr = array();
      //   if (isset($products['attributes'])) {
      //     foreach ($products['attributes'] as $key => $value) {
      //         $attr[$key] = $value['products_options_id'];
      //     }
      //       $req['attributes'] = $attr;

      //   }
        
      //   $check = Product::getquantity($req);
      //   $check = json_decode($check);
      //   if($products['customers_basket_quantity'] > $check->stock){
      //     $responseData = array('success'=>'1', 'data'=>array(),'products_id' => $products['products_id'], 'message'=>"Some Products are out of Stock.");
      //     $orderResponse = json_encode($responseData);
      //     return $orderResponse;
      //   }
      // }

      $guest_status             = $request->guest_status;
      if($guest_status == 1){
        $check = DB::table('users')->where('role_id',2)->where('email',$request->email)->first();
        if($check == null){
          $customers_id = DB::table('users')
                            ->insertGetId([
                              'role_id' => 2,
                              'email' => $request->email,
                              'password' => Hash::make('123456dfdfdf'),
                              'first_name' => $request->delivery_firstname,
                              'last_name' => $request->delivery_lastname,
                              'phone' => $request->customers_telephone
                            ]);
        }
        else{
          $customers_id = $check->id;
        }
      }
      else{
        $customers_id            				=   $request->customers_id;
      }

			$date_added								=	date('Y-m-d h:i:s');
			$customers_telephone            		=   $request->customers_telephone;
			$email            						=   $request->email;
			$delivery_firstname  	          		=   $request->delivery_firstname;
			$delivery_lastname            			=   $request->delivery_lastname;
			$delivery_street_address            	=   $request->delivery_street_address;
			$delivery_suburb            			=   $request->delivery_suburb;
			$delivery_city            				=   $request->delivery_city;
			$delivery_postcode            			=   $request->delivery_postcode;


			$delivery = DB::table('zones')->where('zone_name', '=', $request->delivery_zone)->first();

			if($delivery){
				$delivery_state            				=   $delivery->zone_code;
			}else{
				$delivery_state            				=   'other';
			}

			$delivery_country            			=   $request->delivery_country;
			$billing_firstname            			=   $request->billing_firstname;
			$billing_lastname            			=   $request->billing_lastname;
			$billing_street_address            		=   $request->billing_street_address;
			$billing_suburb	            			=   $request->billing_suburb;
			$billing_city            				=   $request->billing_city;
			$billing_postcode            			=   $request->billing_postcode;

			$billing = DB::table('zones')->where('zone_name', '=', $request->billing_zone)->first();

			if($billing){
				$billing_state            				=   $billing->zone_code;
			}else{
				$billing_state            				=   'other';
			}

			$billing_country            			=   $request->billing_country;
			$payment_method            				=   $request->payment_method;
			$order_information 						=	array();

			$cc_type            				=   $request->cc_type;
			$cc_owner            				=   $request->cc_owner;
			$cc_number            				=   $request->cc_number;
			$cc_expires            				=   $request->cc_expires;
			$last_modified            			=   date('Y-m-d H:i:s');
			$date_purchased            			=   date('Y-m-d H:i:s');
      $order_price						        =   $request->totalPrice;
			$currency_code           				=   $request->currency_code;
      $order_price                    =   Orders::converttodefaultprice($request->totalPrice, $currency_code);
      $shipping_cost            			=   $request->shipping_cost;
      $shipping_cost                  =   Orders::converttodefaultprice($request->shipping_cost, $currency_code);
			$shipping_method            		=   $request->shipping_method;
			$orders_status            			=   '1';
			$orders_date_finished            	=   $request->orders_date_finished;
			$comments            				=   $request->comments;

			//additional fields
			$delivery_phone						=	$request->delivery_phone;
			$billing_phone						=	$request->billing_phone;
			
			//alternate fileds for phone
			
				//additional fields
			$alt_delivery_phone						=	$request->alt_delivery_phone;
			$alt_billing_phone						=	$request->alt_billing_phone;


			$settings = DB::table('settings')->get();
			$currency_value            			=   $request->currency_value;

			//tax info
      $total_tax							=	$request->total_tax;
      $total_tax              = Orders::converttodefaultprice($request->total_tax, $currency_code);

			$products_tax 						= 	1;
			//coupon info
			$is_coupon_applied            		=   $request->is_coupon_applied;

			if($is_coupon_applied==1){

				$code = array();
				$coupon_amount = 0;
				$exclude_product_ids = array();
				$product_categories = array();
				$excluded_product_categories = array();
				$exclude_product_ids = array();

        $coupon_amount    =		$request->coupon_amount;

        //convert price to default currency price
        $coupon_amount = Orders::converttodefaultprice($coupon_amount, $currency_code);

				foreach($request->coupons as $coupons_data){

					//update coupans
					$coupon_id = DB::statement("UPDATE `coupons` SET `used_by`= CONCAT(used_by,',$customers_id') WHERE `code` = '".$coupons_data['code']."'");

				}
				$code = json_encode($request->coupons);

			}else{
				$code            					=   '';
				$coupon_amount            			=   0;
			}

			//payment methods
			$payments_setting = Orders::payments_setting_for_brain_tree($request);

			if($payment_method == 'braintree_card' or $payment_method == 'braintree_paypal'){
				if($payment_method == 'braintree_card'){
          $fieldName = 'sub_name_1';
          $paymentMethodName = 'Braintree Card';
				}else{
          $fieldName = 'sub_name_2';
          $paymentMethodName = 'Braintree Paypal';
        }
        
        // $paymentMethodName = $payments_setting->$fieldName;

				//braintree transaction with nonce
				$is_transaction  = '1'; 			# For payment through braintree
				$nonce    		 =   $request->nonce;

        if($payments_setting['merchant_id']->environment=='0'){
    			$braintree_enviroment = 'Test';
    		}else{
    			$braintree_enviroment = 'Live';
    		}

        $braintree_merchant_id = $payments_setting['merchant_id']->value;
        $braintree_public_key  = $payments_setting['public_key']->value;
        $braintree_private_key = $payments_setting['private_key']->value;

				//brain tree credential
				require_once app_path('braintree/index.php');

				if ($result->success)
				{
				if($result->transaction->id)
					{
						$order_information = array(
							'braintree_id'=>$result->transaction->id,
							'status'=>$result->transaction->status,
							'type'=>$result->transaction->type,
							'currencyIsoCode'=>$result->transaction->currencyIsoCode,
							'amount'=>$result->transaction->amount,
							'merchantAccountId'=>$result->transaction->merchantAccountId,
							'subMerchantAccountId'=>$result->transaction->subMerchantAccountId,
							'masterMerchantAccountId'=>$result->transaction->masterMerchantAccountId,
							//'orderId'=>$result->transaction->orderId,
							'createdAt'=>time(),
	//						'updatedAt'=>$result->transaction->updatedAt->date,
							'token'=>$result->transaction->creditCard['token'],
							'bin'=>$result->transaction->creditCard['bin'],
							'last4'=>$result->transaction->creditCard['last4'],
							'cardType'=>$result->transaction->creditCard['cardType'],
							'expirationMonth'=>$result->transaction->creditCard['expirationMonth'],
							'expirationYear'=>$result->transaction->creditCard['expirationYear'],
							'customerLocation'=>$result->transaction->creditCard['customerLocation'],
							'cardholderName'=>$result->transaction->creditCard['cardholderName']
						);
						$payment_status = "success";
					}
				}
				else
					{
						$payment_status = "failed";
					}

			}else if($payment_method == 'stripe'){				#### stipe payment

        $payments_setting = Orders::payments_setting_for_stripe($request);
				$paymentMethodName = $payments_setting['publishable_key']->name;

				//require file
				require_once app_path('stripe/config.php');

				//get token from app
				$token  = $request->nonce;

				$customer = \Stripe\Customer::create(array(
				  'email' => $email,
				  'source'  => $token
				));

				$charge = \Stripe\Charge::create(array(
				  'customer' => $customer->id,
				  'amount'   => 100*$order_price,
				  'currency' => 'usd'
				));

				 if($charge->paid == true){
					 $order_information = array(
							'paid'=>'true',
							'transaction_id'=>$charge->id,
							'type'=>$charge->outcome->type,
							'balance_transaction'=>$charge->balance_transaction,
							'status'=>$charge->status,
							'currency'=>$charge->currency,
							'amount'=>$charge->amount,
							'created'=>date('d M,Y', $charge->created),
							'dispute'=>$charge->dispute,
							'customer'=>$charge->customer,
							'address_zip'=>$charge->source->address_zip,
							'seller_message'=>$charge->outcome->seller_message,
							'network_status'=>$charge->outcome->network_status,
							'expirationMonth'=>$charge->outcome->type
						);

						$payment_status = "success";

				 }else{
						$payment_status = "failed";
				 }

			}else if($payment_method == 'cod'){

        $payments_setting = Orders::payments_setting_for_cod($request);
				$paymentMethodName =  $payments_setting->name;
				$payment_method = 'Cash on Delivery';
				$payment_status='success';

			} 
			
			
			 //add for builder mart wallet purpose
else if($payment_method == 'buildermart_wallet'){
    
    
    
    

        $payments_setting = Orders::payments_setting_for_buildermart_wallet($request);
$paymentMethodName =  $payments_setting->name;
//$payment_method = 'buildermart_wallet';
$payment_status='success';

}
			
			
			else if($payment_method == 'instamojo'){

        $payments_setting = Orders::payments_setting_for_instamojo($request);
				$paymentMethodName = $payments_setting['auth_token']->name;
				$payment_method = 'Instamojo';
				$payment_status='success';
				$order_information = array('payment_id'=>$request->nonce, 'transaction_id'=>$request->transaction_id);

			}else if($payment_method == 'hyperpay'){
        $payments_setting = Orders::payments_setting_for_hyperpay($request);
				$paymentMethodName = $payments_setting['userid']->name;
				$payment_method = 'Hyperpay';
				$payment_status='success';
			}else if($payment_method == 'razorpay'){
        $payments_setting = Orders::payments_setting_for_razorpay($request);
				$paymentMethodName = $payments_setting['RAZORPAY_KEY']->name;
				$payment_method = 'Razorpay';
				$payment_status='success';
				
				//added on 2 oct 2020
					$order_information = array('payment_id'=>$request->nonce, 'transaction_id'=>$request->transaction_id,'order_payment_id'=>$request->order_payment_id);         
				
				
			}else if($payment_method == 'paytm'){
        $payments_setting = Orders::payments_setting_for_paytm($request);
				$paymentMethodName = $payments_setting['paytm_mid']->name;
				$payment_method = 'Paytm';
				$payment_status='success';
			}else if($payment_method == 'paytm'){
        $payments_setting = Orders::payments_setting_for_directbank($request);
				$paymentMethodName = $payments_setting['account_name']->name;
				$payment_method = 'directbank';
        $payment_status='success';
        $order_information = array(
          'account_name' => $payments_setting['account_name']->value,
          'account_number' => $payments_setting['account_number']->value,
          'payment_method' => $payments_setting['account_name']->payment_method,
          'bank_name' => $payments_setting['bank_name']->value,
          'short_code' => $payments_setting['short_code']->value,
          'iban' => $payments_setting['iban']->value,
          'swift' => $payments_setting['swift']->value,
        );
			}else if($payment_method == 'paystack'){
        $payments_setting = Orders::payments_setting_for_paystack($request);
				$paymentMethodName = $payments_setting['secret_key']->name;
				$payment_method = 'paystack';
        $payment_status='success';
        $order_information = '';
			}


			//check if order is verified
			if($payment_status=='success'){
				if( $payment_method == 'hyperpay'){
				$cyb_orders = DB::table('orders')->where('transaction_id','=',$request->transaction_id)->get();
				$orders_id = $cyb_orders[0]->orders_id;

				//update database
				DB::table('orders')->where('transaction_id','=',$request->transaction_id)->update(
					[	 'customers_id' => $customers_id,
						 'customers_name'  => $delivery_firstname.' '.$delivery_lastname,
						 'customers_street_address' => $delivery_street_address,
						 'customers_suburb'  =>  $delivery_suburb,
						 'customers_city' => $delivery_city,
						 'customers_postcode'  => $delivery_postcode,
						 'customers_state' => $delivery_state,
						 'customers_country'  =>  $delivery_country,
						 'customers_telephone' => $customers_telephone,
						 'email'  => $email,

						 'delivery_name'  =>  $delivery_firstname.' '.$delivery_lastname,
						 'delivery_street_address' => $delivery_street_address,
						 'delivery_suburb'  => $delivery_suburb,
						 'delivery_city' => $delivery_city,
						 'delivery_postcode'  =>  $delivery_postcode,
						 'delivery_state' => $delivery_state,
						 'delivery_country'  => $delivery_country,
						 'billing_name'  => $billing_firstname.' '.$billing_lastname,
						 'billing_street_address' => $billing_street_address,
						 'billing_suburb'  =>  $billing_suburb,
						 'billing_city' => $billing_city,
						 'billing_postcode'  => $billing_postcode,
						 'billing_state' => $billing_state,
						 'billing_country'  =>  $billing_country,

						 'payment_method'  =>  $paymentMethodName,
						 'cc_type' => $cc_type,
						 'cc_owner'  => $cc_owner,
						 'cc_number' =>$cc_number,
						 'cc_expires'  =>  $cc_expires,
						 'last_modified' => $last_modified,
						 'date_purchased'  => $date_purchased,
						 'order_price'  => $order_price,
						 'shipping_cost' =>$shipping_cost,
						 'shipping_method'  =>  $shipping_method,
						 'currency'  =>  $currency_code,
						 'currency_value' => $last_modified,
						 'coupon_code'		 =>		$code,
						 'coupon_amount' 	 =>		$coupon_amount,
						 'total_tax'		 =>		$total_tax,
						 'ordered_source' 	 => 	'2',
						 'delivery_phone'	 =>		$delivery_phone,
						 'billing_phone'	 =>		$billing_phone,
						 
					 
						 'delivery_alternate_phone'	 =>		$alt_delivery_phone	,
	                    'billing_alternate_phone'	 =>		$alt_billing_phone 

					]);

				}else{

				//insert order
				$orders_id = DB::table('orders')->insertGetId(
					[	 'customers_id' => $customers_id,
						 'customers_name'  => $delivery_firstname.' '.$delivery_lastname,
						 'customers_street_address' => $delivery_street_address,
						 'customers_suburb'  =>  $delivery_suburb,
						 'customers_city' => $delivery_city,
						 'customers_postcode'  => $delivery_postcode,
						 'customers_state' => $delivery_state,
						 'customers_country'  =>  $delivery_country,
						 'customers_telephone' => $customers_telephone,
						 'email'  => $email,

						 'delivery_name'  =>  $delivery_firstname.' '.$delivery_lastname,
						 'delivery_street_address' => $delivery_street_address,
						 'delivery_suburb'  => $delivery_suburb,
						 'delivery_city' => $delivery_city,
						 'delivery_postcode'  =>  $delivery_postcode,
						 'delivery_state' => $delivery_state,
						 'delivery_country'  => $delivery_country,

						 'billing_name'  => $billing_firstname.' '.$billing_lastname,
						 'billing_street_address' => $billing_street_address,
						 'billing_suburb'  =>  $billing_suburb,
						 'billing_city' => $billing_city,
						 'billing_postcode'  => $billing_postcode,
						 'billing_state' => $billing_state,
						 'billing_country'  =>  $billing_country,

						 'payment_method'  =>  $paymentMethodName,
						 'cc_type' => $cc_type,
						 'cc_owner'  => $cc_owner,
						 'cc_number' =>$cc_number,
						 'cc_expires'  =>  $cc_expires,
						 'last_modified' => $last_modified,
						 'date_purchased'  => $date_purchased,
						 'order_price'  => $order_price,
						 'shipping_cost' =>$shipping_cost,
						 'shipping_method'  =>  $shipping_method,
						 'currency'  =>  $currency_code,
						 'currency_value' => $last_modified,
						 'order_information' => json_encode($order_information),
						 'coupon_code'		 =>		$code,
						 'coupon_amount' 	 =>		$coupon_amount,
						 'total_tax'		 =>		$total_tax,
						 'ordered_source' 	 => 	'2',
						 'delivery_phone'	 =>		$delivery_phone,
						 'billing_phone'	 =>		$billing_phone,
						 
						 
						 'delivery_alternate_phone'	 =>		$alt_delivery_phone,
	                    'billing_alternate_phone'	 =>		$alt_billing_phone,
	                    'location_id'=> $request->location_id

					]);

				}
				 //orders status history
				 $orders_history_id = DB::table('orders_status_history')->insertGetId(
					[	 'orders_id'  => $orders_id,
						 'orders_status_id' => $orders_status,
						 'date_added'  => $date_added,
						 'customer_notified' =>'1',
						 'order_comments'  =>  $comments,
					    'current_status'=>1
					]);

				 foreach($request->products as $products){
            //dd($products['price'], $currency_code);
            $c_price = str_replace(',','',$products['price']);
            $c_final_price = str_replace(',','',$products['final_price']);
          $price = Orders::converttodefaultprice($c_price, $currency_code);
          $final_price = $c_final_price*$products['customers_basket_quantity'];
          $final_price = Orders::converttodefaultprice($final_price, $currency_code);
          
          //fetching the distributor details 
          $products_data=DB::table('products')->where('products_id',$products['products_id'])->first();
          
          
          //this is for simpel product 
          $orders_products_id = DB::table('orders_products')->insertGetId(
					[
						 'orders_id' 		 => 	$orders_id,
						 'products_id' 	 	 =>		$products['products_id'],
					    
					    'distributor_id' => $products_data->distributor_id,
					    'distributor_products_price' => $products_data->distributor_product_price,
					    'distributor_product_price_percentage' => $products_data->distributor_product_price_percentage,
					    'hsn_sac_code' => $products_data->hsn_sac_code,
					'distributor_final_price'=>$products_data->distributor_product_price * $products['customers_basket_quantity'],
					  'cart_product_price' => $c_price,
						 'products_name'	 => 	$products['products_name'],
						 'products_price'	 =>  	$price,
						 'final_price' 		 =>  	$final_price,
						 'products_tax' 	 =>  	$products_tax,
						 'products_quantity' =>  	$products['customers_basket_quantity'],
					]);

					$inventory_ref_id = DB::table('inventory')->insertGetId([
						'products_id'   		=>   $products['products_id'],
						'reference_code'  		=>   '',
						'stock'  				=>   $products['customers_basket_quantity'],
						'admin_id'  			=>   0,
						'added_date'	  		=>   time(),
						'purchase_price'  		=>   0,
						'stock_type'  			=>   'out',
					]);


//if this is variant below lines 

					if(!empty($products['attributes'])){
						foreach($products['attributes'] as $attribute){
						    
						    //fetching the distributor atrributes details 
						    $product_atrributes_value=DB::table('products_attributes')
						    
						    ->where('products_attributes_id','=',$attribute['products_options_values_id'])
						    ->where('products_id','=',$products['products_id'])
						     ->first();
						     
	 
					 
						    //distributor price and distributor option values price sending to static method for add and sub purpose
						    $distributor_final_price  =   Orders::getDistributorFinalPrice($attribute['price_prefix'],$products_data->distributor_product_price,$product_atrributes_value->distributor_options_values_price);

						    //distributor final price multiply with qty
						    $distributor_final_price_qty = $distributor_final_price * $products['customers_basket_quantity'];
						   
						   
						     
						    //update the distributor final price and cart price $cart_product_price which has discount and varient price for customer
						    $orders_products = DB::table('orders_products')->where('orders_products_id',$orders_products_id)->update(
						        ['distributor_final_price' => $distributor_final_price_qty,
						            'cart_product_price' => $c_price,
						        ]);
						    //sum 
						  
						    
							DB::table('orders_products_attributes')->insert(
							[
								 'orders_id' => $orders_id,
								 'products_id'  => $products['products_id'],
								 'orders_products_id'  => $orders_products_id,
								 'products_options' =>$attribute['products_options'],
								 'products_options_values'  =>  $attribute['products_options_values'],
							    
							    'distributor_options_values_price' => $product_atrributes_value->distributor_options_values_price,
								
							    'options_values_price'  =>  $attribute['options_values_price'],
								 'price_prefix'  =>  $attribute['price_prefix']
							]);
							 

							/*$products_attributes = DB::table('products_attributes')->where([
								['options_id', '=', $attribute['products_options_id']],
								['products_attributes_id', '=', $attribute['products_options_values_id']],
							])->first();*/

						 
							
							DB::table('inventory_detail')->insert([
								'inventory_ref_id'  =>   $inventory_ref_id,
								'products_id'  		=>   $products['products_id'],
							    'attribute_id'		=>   $product_atrributes_value->products_attributes_id,
							]);

						}
					}

				 }
				 
				 //update the sum of distributor final price in orders table
				 $order_distributor_price = DB::table('orders_products')->where('orders_id',$orders_id)->sum('distributor_final_price');
				 
				 DB::table('orders')->where('orders_id',$orders_id)->update(['distributor_order_price' => $order_distributor_price]);				 
				 
				 

				$responseData = array('success'=>'1', 'data'=>array(), 'customer_id' => $customers_id,'message'=>"Order has been placed successfully.");

				//send order email to user
				$order = DB::table('orders')
					->LeftJoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders.orders_id')
					->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
					->where('orders.orders_id', '=', $orders_id)->orderby('orders_status_history.date_added', 'DESC')->get();

			//foreach
			foreach($order as $data){
				$orders_id	 = $data->orders_id;

				$orders_products = DB::table('orders_products')
					->join('products', 'products.products_id','=', 'orders_products.products_id')
					 ->join('image_categories', 'products.products_image', '=', 'image_categories.image_id')
                   ->select('orders_products.*', 'image_categories.path as image')

				//	->select('orders_products.*', 'products.products_image as image')
					->where('orders_products.orders_id', '=', $orders_id)
					->where('image_type', '=', 'THUMBNAIL')->get();

					$i = 0;
					$total_price  = 0;
					$product = array();
					$subtotal = 0;
					foreach($orders_products as $orders_products_data){
						$product_attribute = DB::table('orders_products_attributes')
							->where([
								['orders_products_id', '=', $orders_products_data->orders_products_id],
								['orders_id', '=', $orders_products_data->orders_id],
							])
							->get();

						$orders_products_data->attribute = $product_attribute;
						$product[$i] = $orders_products_data;
						//$total_tax	 = $total_tax+$orders_products_data->products_tax;
						$total_price += $orders_products[$i]->final_price;

						$subtotal += $orders_products[$i]->final_price;

						$i++;
					}

				$data->data = $product;
				$orders_data[] = $data;
			}

				$orders_status_history = DB::table('orders_status_history')
					->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
					->orderBy('orders_status_history.date_added', 'desc')
					->where('orders_id', '=', $orders_id)->get();

				$orders_status = DB::table('orders_status')->get();

				$ordersData['orders_data']		 	 	=	$orders_data;
				$ordersData['total_price']  			=	$total_price;
				$ordersData['orders_status']			=	$orders_status;
							 

				
				$ordersData['orders_status_history']    =	$orders_status_history;
				$ordersData['subtotal']    				=	$subtotal;
			
//	$ordersData['customers_id'] =	$customers_id;
// commented on 31 jan 2022 , as the cashabck to be added on the order completion. 
	// Reward Points Start
		/*		
				$min_cart_value = DB::table('reward_points')
				->where('min_cart_value',"<=",$total_price)
				->orderBy("min_cart_value", "DESC")
				->first();
				 
				$reedem_values = DB::table('reedem_values')
				->first();
				
				if($min_cart_value){
					 
					$reward_points= $min_cart_value->reward_point;
				
					$cashbackamount= $reward_points * $reedem_values->value;
					
					
					$customer_details = DB::table('users')
					->where('id',"=",$customers_id)
					->first();
					
					$customer_type = $customer_details->customer_type;
				
					 
				
					if($customer_type=="BUSINESSOWNER"){
						DB::table('orders')
						->where('customers_id','=',$customers_id)
						->where('orders_id', '=', $orders_id)
						->update(['reward_points' => $reward_points,
								'cashback_amount' => $cashbackamount]);
							
							
					}
				
					 
					 
				}
				
				*/
				//Reward Points End

				//notification/email
			//	$myVar = new AlertController();
			//	$alertSetting = $myVar->orderAlert($ordersData);
				
				
				
			 
				
//send sms 

orderconfirm($orders_id,$delivery_phone);
//send sms 

 
 
 

// Shipping Charges SMS Start
if($customer_type=="CUSTOMER" || $customer_type=="BUSINESSOWNER"){
	 
	 
	$customer_details = DB::table('users')
	->where('users.id',$customers_id)->first();
	 
	$username =$customer_details->first_name . ' ' . $customer_details->last_name;
	 
	$userphone =$customer_details->phone;
	 
	shippingchargessms($orders_id,$username,$userphone);

	 
}
 
 

			}else if($payment_status == "failed"){
				if(!empty($error_cybersource)){
					$return_error = $error_cybersource;
				}else{
					$return_error = 'Error while placing order.';
				}
				$responseData = array('success'=>'0', 'data'=>array(), 'message'=>$error_cybersource);
			}
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}


//adding and substracting the distributor price with distributor option value price
public static function getDistributorFinalPrice($symbol,$distributor_product_original_price, $distributor_options_values_price){
    $distributor_final_price=0;
    if ($symbol == '+') {
        
        $distributor_final_price = floatval($distributor_product_original_price) + floatval($distributor_options_values_price);
         
    }
    if ($symbol == '-') {
        
        
        $distributor_final_price = floatval($distributor_product_original_price) - floatval($distributor_options_values_price);
        
       
        
    }
    
    return $distributor_final_price;
    
}


// modified code on aug 5 2022
public static function XXXaddtoorder($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;

  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);
  $ipAddress = Orders::get_client_ip_env();
$customer_type="";
  if($authenticate==1){
      
    
      // foreach($request->products as $products){
      //   $req = array();
      //   $req['products_id'] = $products['products_id'];
      //   $attr = array();
      //   if (isset($products['attributes'])) {
      //     foreach ($products['attributes'] as $key => $value) {
      //         $attr[$key] = $value['products_options_id'];
      //     }
      //       $req['attributes'] = $attr;

      //   }
        
      //   $check = Product::getquantity($req);
      //   $check = json_decode($check);
      //   if($products['customers_basket_quantity'] > $check->stock){
      //     $responseData = array('success'=>'1', 'data'=>array(),'products_id' => $products['products_id'], 'message'=>"Some Products are out of Stock.");
      //     $orderResponse = json_encode($responseData);
      //     return $orderResponse;
      //   }
      // }

      $guest_status             = $request->guest_status;
      if($guest_status == 1){
        $check = DB::table('users')->where('role_id',2)->where('email',$request->email)->first();
        if($check == null){
          $customers_id = DB::table('users')
                            ->insertGetId([
                              'role_id' => 2,
                              'email' => $request->email,
                              'password' => Hash::make('123456dfdfdf'),
                              'first_name' => $request->delivery_firstname,
                              'last_name' => $request->delivery_lastname,
                              'phone' => $request->customers_telephone
                            ]);
        }
        else{
          $customers_id = $check->id;
        }
      }
      else{
        $customers_id            				=   $request->customers_id;
      }

			$date_added								=	date('Y-m-d h:i:s');
			$customers_telephone            		=   $request->customers_telephone;
			$email            						=   $request->email;
			$delivery_firstname  	          		=   $request->delivery_firstname;
			$delivery_lastname            			=   $request->delivery_lastname;
			$delivery_street_address            	=   $request->delivery_street_address;
			$delivery_suburb            			=   $request->delivery_suburb;
			$delivery_city            				=   $request->delivery_city;
			$delivery_postcode            			=   $request->delivery_postcode;


			$delivery = DB::table('zones')->where('zone_name', '=', $request->delivery_zone)->first();

			if($delivery){
				$delivery_state            				=   $delivery->zone_code;
			}else{
				$delivery_state            				=   'other';
			}

			$delivery_country            			=   $request->delivery_country;
			$billing_firstname            			=   $request->billing_firstname;
			$billing_lastname            			=   $request->billing_lastname;
			$billing_street_address            		=   $request->billing_street_address;
			$billing_suburb	            			=   $request->billing_suburb;
			$billing_city            				=   $request->billing_city;
			$billing_postcode            			=   $request->billing_postcode;

			$billing = DB::table('zones')->where('zone_name', '=', $request->billing_zone)->first();

			if($billing){
				$billing_state            				=   $billing->zone_code;
			}else{
				$billing_state            				=   'other';
			}

			$billing_country            			=   $request->billing_country;
			$payment_method            				=   $request->payment_method;
			$order_information 						=	array();

			$cc_type            				=   $request->cc_type;
			$cc_owner            				=   $request->cc_owner;
			$cc_number            				=   $request->cc_number;
			$cc_expires            				=   $request->cc_expires;
			$last_modified            			=   date('Y-m-d H:i:s');
			$date_purchased            			=   date('Y-m-d H:i:s');
      $order_price						        =   $request->totalPrice;
			$currency_code           				=   $request->currency_code;
      $order_price                    =   Orders::converttodefaultprice($request->totalPrice, $currency_code);
      $shipping_cost            			=   $request->shipping_cost;
      $shipping_cost                  =   Orders::converttodefaultprice($request->shipping_cost, $currency_code);
			$shipping_method            		=   $request->shipping_method;
			$orders_status            			=   '1';
			$orders_date_finished            	=   $request->orders_date_finished;
			$comments            				=   $request->comments;

			//additional fields
			$delivery_phone						=	$request->delivery_phone;
			$billing_phone						=	$request->billing_phone;
			
			//alternate fileds for phone
			
				//additional fields
			$alt_delivery_phone						=	$request->alt_delivery_phone;
			$alt_billing_phone						=	$request->alt_billing_phone;


			$settings = DB::table('settings')->get();
			$currency_value            			=   $request->currency_value;

			//tax info
      $total_tax							=	$request->total_tax;
      $total_tax              = Orders::converttodefaultprice($request->total_tax, $currency_code);

			$products_tax 						= 	1;
			//coupon info
			$is_coupon_applied            		=   $request->is_coupon_applied;

			if($is_coupon_applied==1){

				$code = array();
				$coupon_amount = 0;
				$exclude_product_ids = array();
				$product_categories = array();
				$excluded_product_categories = array();
				$exclude_product_ids = array();

        $coupon_amount    =		$request->coupon_amount;

        //convert price to default currency price
        $coupon_amount = Orders::converttodefaultprice($coupon_amount, $currency_code);

				foreach($request->coupons as $coupons_data){

					//update coupans
					$coupon_id = DB::statement("UPDATE `coupons` SET `used_by`= CONCAT(used_by,',$customers_id') WHERE `code` = '".$coupons_data['code']."'");

				}
				$code = json_encode($request->coupons);

			}else{
				$code            					=   '';
				$coupon_amount            			=   0;
			}

			//payment methods
			$payments_setting = Orders::payments_setting_for_brain_tree($request);

			if($payment_method == 'braintree_card' or $payment_method == 'braintree_paypal'){
				if($payment_method == 'braintree_card'){
          $fieldName = 'sub_name_1';
          $paymentMethodName = 'Braintree Card';
				}else{
          $fieldName = 'sub_name_2';
          $paymentMethodName = 'Braintree Paypal';
        }
        
        // $paymentMethodName = $payments_setting->$fieldName;

				//braintree transaction with nonce
				$is_transaction  = '1'; 			# For payment through braintree
				$nonce    		 =   $request->nonce;

        if($payments_setting['merchant_id']->environment=='0'){
    			$braintree_enviroment = 'Test';
    		}else{
    			$braintree_enviroment = 'Live';
    		}

        $braintree_merchant_id = $payments_setting['merchant_id']->value;
        $braintree_public_key  = $payments_setting['public_key']->value;
        $braintree_private_key = $payments_setting['private_key']->value;

				//brain tree credential
				require_once app_path('braintree/index.php');

				if ($result->success)
				{
				if($result->transaction->id)
					{
						$order_information = array(
							'braintree_id'=>$result->transaction->id,
							'status'=>$result->transaction->status,
							'type'=>$result->transaction->type,
							'currencyIsoCode'=>$result->transaction->currencyIsoCode,
							'amount'=>$result->transaction->amount,
							'merchantAccountId'=>$result->transaction->merchantAccountId,
							'subMerchantAccountId'=>$result->transaction->subMerchantAccountId,
							'masterMerchantAccountId'=>$result->transaction->masterMerchantAccountId,
							//'orderId'=>$result->transaction->orderId,
							'createdAt'=>time(),
	//						'updatedAt'=>$result->transaction->updatedAt->date,
							'token'=>$result->transaction->creditCard['token'],
							'bin'=>$result->transaction->creditCard['bin'],
							'last4'=>$result->transaction->creditCard['last4'],
							'cardType'=>$result->transaction->creditCard['cardType'],
							'expirationMonth'=>$result->transaction->creditCard['expirationMonth'],
							'expirationYear'=>$result->transaction->creditCard['expirationYear'],
							'customerLocation'=>$result->transaction->creditCard['customerLocation'],
							'cardholderName'=>$result->transaction->creditCard['cardholderName']
						);
						$payment_status = "success";
					}
				}
				else
					{
						$payment_status = "failed";
					}

			}else if($payment_method == 'stripe'){				#### stipe payment

        $payments_setting = Orders::payments_setting_for_stripe($request);
				$paymentMethodName = $payments_setting['publishable_key']->name;

				//require file
				require_once app_path('stripe/config.php');

				//get token from app
				$token  = $request->nonce;

				$customer = \Stripe\Customer::create(array(
				  'email' => $email,
				  'source'  => $token
				));

				$charge = \Stripe\Charge::create(array(
				  'customer' => $customer->id,
				  'amount'   => 100*$order_price,
				  'currency' => 'usd'
				));

				 if($charge->paid == true){
					 $order_information = array(
							'paid'=>'true',
							'transaction_id'=>$charge->id,
							'type'=>$charge->outcome->type,
							'balance_transaction'=>$charge->balance_transaction,
							'status'=>$charge->status,
							'currency'=>$charge->currency,
							'amount'=>$charge->amount,
							'created'=>date('d M,Y', $charge->created),
							'dispute'=>$charge->dispute,
							'customer'=>$charge->customer,
							'address_zip'=>$charge->source->address_zip,
							'seller_message'=>$charge->outcome->seller_message,
							'network_status'=>$charge->outcome->network_status,
							'expirationMonth'=>$charge->outcome->type
						);

						$payment_status = "success";

				 }else{
						$payment_status = "failed";
				 }

			}else if($payment_method == 'cod'){

        $payments_setting = Orders::payments_setting_for_cod($request);
				$paymentMethodName =  $payments_setting->name;
				$payment_method = 'Cash on Delivery';
				$payment_status='success';

			} 
			
			
			 //add for builder mart wallet purpose
else if($payment_method == 'buildermart_wallet'){
    
    
    
    

        $payments_setting = Orders::payments_setting_for_buildermart_wallet($request);
$paymentMethodName =  $payments_setting->name;
//$payment_method = 'buildermart_wallet';
$payment_status='success';

}
			
			
			else if($payment_method == 'instamojo'){

        $payments_setting = Orders::payments_setting_for_instamojo($request);
				$paymentMethodName = $payments_setting['auth_token']->name;
				$payment_method = 'Instamojo';
				$payment_status='success';
				$order_information = array('payment_id'=>$request->nonce, 'transaction_id'=>$request->transaction_id);

			}else if($payment_method == 'hyperpay'){
        $payments_setting = Orders::payments_setting_for_hyperpay($request);
				$paymentMethodName = $payments_setting['userid']->name;
				$payment_method = 'Hyperpay';
				$payment_status='success';
			}else if($payment_method == 'razorpay'){
        $payments_setting = Orders::payments_setting_for_razorpay($request);
				$paymentMethodName = $payments_setting['RAZORPAY_KEY']->name;
				$payment_method = 'Razorpay';
				$payment_status='success';
				
				//added on 2 oct 2020
					$order_information = array('payment_id'=>$request->nonce, 'transaction_id'=>$request->transaction_id,'order_payment_id'=>$request->order_payment_id);         
				
				
			}else if($payment_method == 'paytm'){
        $payments_setting = Orders::payments_setting_for_paytm($request);
				$paymentMethodName = $payments_setting['paytm_mid']->name;
				$payment_method = 'Paytm';
				$payment_status='success';
			}else if($payment_method == 'paytm'){
        $payments_setting = Orders::payments_setting_for_directbank($request);
				$paymentMethodName = $payments_setting['account_name']->name;
				$payment_method = 'directbank';
        $payment_status='success';
        $order_information = array(
          'account_name' => $payments_setting['account_name']->value,
          'account_number' => $payments_setting['account_number']->value,
          'payment_method' => $payments_setting['account_name']->payment_method,
          'bank_name' => $payments_setting['bank_name']->value,
          'short_code' => $payments_setting['short_code']->value,
          'iban' => $payments_setting['iban']->value,
          'swift' => $payments_setting['swift']->value,
        );
			}else if($payment_method == 'paystack'){
        $payments_setting = Orders::payments_setting_for_paystack($request);
				$paymentMethodName = $payments_setting['secret_key']->name;
				$payment_method = 'paystack';
        $payment_status='success';
        $order_information = '';
			}


			//check if order is verified
			if($payment_status=='success'){
				if( $payment_method == 'hyperpay'){
				$cyb_orders = DB::table('orders')->where('transaction_id','=',$request->transaction_id)->get();
				$orders_id = $cyb_orders[0]->orders_id;

				//update database
				DB::table('orders')->where('transaction_id','=',$request->transaction_id)->update(
					[	 'customers_id' => $customers_id,
						 'customers_name'  => $delivery_firstname.' '.$delivery_lastname,
						 'customers_street_address' => $delivery_street_address,
						 'customers_suburb'  =>  $delivery_suburb,
						 'customers_city' => $delivery_city,
						 'customers_postcode'  => $delivery_postcode,
						 'customers_state' => $delivery_state,
						 'customers_country'  =>  $delivery_country,
						 'customers_telephone' => $customers_telephone,
						 'email'  => $email,

						 'delivery_name'  =>  $delivery_firstname.' '.$delivery_lastname,
						 'delivery_street_address' => $delivery_street_address,
						 'delivery_suburb'  => $delivery_suburb,
						 'delivery_city' => $delivery_city,
						 'delivery_postcode'  =>  $delivery_postcode,
						 'delivery_state' => $delivery_state,
						 'delivery_country'  => $delivery_country,
						 'billing_name'  => $billing_firstname.' '.$billing_lastname,
						 'billing_street_address' => $billing_street_address,
						 'billing_suburb'  =>  $billing_suburb,
						 'billing_city' => $billing_city,
						 'billing_postcode'  => $billing_postcode,
						 'billing_state' => $billing_state,
						 'billing_country'  =>  $billing_country,

						 'payment_method'  =>  $paymentMethodName,
						 'cc_type' => $cc_type,
						 'cc_owner'  => $cc_owner,
						 'cc_number' =>$cc_number,
						 'cc_expires'  =>  $cc_expires,
						 'last_modified' => $last_modified,
						 'date_purchased'  => $date_purchased,
						 'order_price'  => $order_price,
						 'shipping_cost' =>$shipping_cost,
						 'shipping_method'  =>  $shipping_method,
						 'currency'  =>  $currency_code,
						 'currency_value' => $last_modified,
						 'coupon_code'		 =>		$code,
						 'coupon_amount' 	 =>		$coupon_amount,
						 'total_tax'		 =>		$total_tax,
						 'ordered_source' 	 => 	'2',
						 'delivery_phone'	 =>		$delivery_phone,
						 'billing_phone'	 =>		$billing_phone,
						 
					 
						 'delivery_alternate_phone'	 =>		$alt_delivery_phone	,
	                    'billing_alternate_phone'	 =>		$alt_billing_phone 

					]);

				}else{

				//insert order
				$orders_id = DB::table('orders')->insertGetId(
					[	 'customers_id' => $customers_id,
						 'customers_name'  => $delivery_firstname.' '.$delivery_lastname,
						 'customers_street_address' => $delivery_street_address,
						 'customers_suburb'  =>  $delivery_suburb,
						 'customers_city' => $delivery_city,
						 'customers_postcode'  => $delivery_postcode,
						 'customers_state' => $delivery_state,
						 'customers_country'  =>  $delivery_country,
						 'customers_telephone' => $customers_telephone,
						 'email'  => $email,

						 'delivery_name'  =>  $delivery_firstname.' '.$delivery_lastname,
						 'delivery_street_address' => $delivery_street_address,
						 'delivery_suburb'  => $delivery_suburb,
						 'delivery_city' => $delivery_city,
						 'delivery_postcode'  =>  $delivery_postcode,
						 'delivery_state' => $delivery_state,
						 'delivery_country'  => $delivery_country,

						 'billing_name'  => $billing_firstname.' '.$billing_lastname,
						 'billing_street_address' => $billing_street_address,
						 'billing_suburb'  =>  $billing_suburb,
						 'billing_city' => $billing_city,
						 'billing_postcode'  => $billing_postcode,
						 'billing_state' => $billing_state,
						 'billing_country'  =>  $billing_country,

						 'payment_method'  =>  $paymentMethodName,
						 'cc_type' => $cc_type,
						 'cc_owner'  => $cc_owner,
						 'cc_number' =>$cc_number,
						 'cc_expires'  =>  $cc_expires,
						 'last_modified' => $last_modified,
						 'date_purchased'  => $date_purchased,
						 'order_price'  => $order_price,
						 'shipping_cost' =>$shipping_cost,
						 'shipping_method'  =>  $shipping_method,
						 'currency'  =>  $currency_code,
						 'currency_value' => $last_modified,
						 'order_information' => json_encode($order_information),
						 'coupon_code'		 =>		$code,
						 'coupon_amount' 	 =>		$coupon_amount,
						 'total_tax'		 =>		$total_tax,
						 'ordered_source' 	 => 	'2',
						 'delivery_phone'	 =>		$delivery_phone,
						 'billing_phone'	 =>		$billing_phone,
						 
						 
						 'delivery_alternate_phone'	 =>		$alt_delivery_phone,
	                    'billing_alternate_phone'	 =>		$alt_billing_phone,
	                    'location_id'=> $request->location_id

					]);

				}
				 //orders status history
				 $orders_history_id = DB::table('orders_status_history')->insertGetId(
					[	 'orders_id'  => $orders_id,
						 'orders_status_id' => $orders_status,
						 'date_added'  => $date_added,
						 'customer_notified' =>'1',
						 'order_comments'  =>  $comments
					]);

				 foreach($request->products as $products){
            //dd($products['price'], $currency_code);
            $c_price = str_replace(',','',$products['price']);
            $c_final_price = str_replace(',','',$products['final_price']);
          $price = Orders::converttodefaultprice($c_price, $currency_code);
          $final_price = $c_final_price*$products['customers_basket_quantity'];
          $final_price = Orders::converttodefaultprice($final_price, $currency_code);

					$orders_products_id = DB::table('orders_products')->insertGetId(
					[
						 'orders_id' 		 => 	$orders_id,
						 'products_id' 	 	 =>		$products['products_id'],
						 'products_name'	 => 	$products['products_name'],
						 'products_price'	 =>  	$price,
						 'final_price' 		 =>  	$final_price,
						 'products_tax' 	 =>  	$products_tax,
						 'products_quantity' =>  	$products['customers_basket_quantity'],
					]);

					$inventory_ref_id = DB::table('inventory')->insertGetId([
						'products_id'   		=>   $products['products_id'],
						'reference_code'  		=>   '',
						'stock'  				=>   $products['customers_basket_quantity'],
						'admin_id'  			=>   0,
						'added_date'	  		=>   time(),
						'purchase_price'  		=>   0,
						'stock_type'  			=>   'out',
					]);


					if(!empty($products['attributes'])){
						foreach($products['attributes'] as $attribute){
							DB::table('orders_products_attributes')->insert(
							[
								 'orders_id' => $orders_id,
								 'products_id'  => $products['products_id'],
								 'orders_products_id'  => $orders_products_id,
								 'products_options' =>$attribute['products_options'],
								 'products_options_values'  =>  $attribute['products_options_values'],
								 'options_values_price'  =>  $attribute['options_values_price'],
								 'price_prefix'  =>  $attribute['price_prefix']
							]);

							$products_attributes = DB::table('products_attributes')->where([
								['options_id', '=', $attribute['products_options_id']],
								['products_attributes_id', '=', $attribute['products_options_values_id']],
							])->get();

							DB::table('inventory_detail')->insert([
								'inventory_ref_id'  =>   $inventory_ref_id,
								'products_id'  		=>   $products['products_id'],
								'attribute_id'		=>   $products_attributes[0]->products_attributes_id,
							]);

						}
					}

				 }

				$responseData = array('success'=>'1', 'data'=>array(), 'customer_id' => $customers_id,'message'=>"Order has been placed successfully.");

				//send order email to user
				$order = DB::table('orders')
					->LeftJoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders.orders_id')
					->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
					->where('orders.orders_id', '=', $orders_id)->orderby('orders_status_history.date_added', 'DESC')->get();

			//foreach
			foreach($order as $data){
				$orders_id	 = $data->orders_id;

				$orders_products = DB::table('orders_products')
					->join('products', 'products.products_id','=', 'orders_products.products_id')
					 ->join('image_categories', 'products.products_image', '=', 'image_categories.image_id')
                   ->select('orders_products.*', 'image_categories.path as image')

				//	->select('orders_products.*', 'products.products_image as image')
					->where('orders_products.orders_id', '=', $orders_id)
					->where('image_type', '=', 'THUMBNAIL')->get();

					$i = 0;
					$total_price  = 0;
					$product = array();
					$subtotal = 0;
					foreach($orders_products as $orders_products_data){
						$product_attribute = DB::table('orders_products_attributes')
							->where([
								['orders_products_id', '=', $orders_products_data->orders_products_id],
								['orders_id', '=', $orders_products_data->orders_id],
							])
							->get();

						$orders_products_data->attribute = $product_attribute;
						$product[$i] = $orders_products_data;
						//$total_tax	 = $total_tax+$orders_products_data->products_tax;
						$total_price += $orders_products[$i]->final_price;

						$subtotal += $orders_products[$i]->final_price;

						$i++;
					}

				$data->data = $product;
				$orders_data[] = $data;
			}

				$orders_status_history = DB::table('orders_status_history')
					->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
					->orderBy('orders_status_history.date_added', 'desc')
					->where('orders_id', '=', $orders_id)->get();

				$orders_status = DB::table('orders_status')->get();

				$ordersData['orders_data']		 	 	=	$orders_data;
				$ordersData['total_price']  			=	$total_price;
				$ordersData['orders_status']			=	$orders_status;
							 

				
				$ordersData['orders_status_history']    =	$orders_status_history;
				$ordersData['subtotal']    				=	$subtotal;
			
//	$ordersData['customers_id'] =	$customers_id;
// commented on 31 jan 2022 , as the cashabck to be added on the order completion. 
	// Reward Points Start
		/*		
				$min_cart_value = DB::table('reward_points')
				->where('min_cart_value',"<=",$total_price)
				->orderBy("min_cart_value", "DESC")
				->first();
				 
				$reedem_values = DB::table('reedem_values')
				->first();
				
				if($min_cart_value){
					 
					$reward_points= $min_cart_value->reward_point;
				
					$cashbackamount= $reward_points * $reedem_values->value;
					
					
					$customer_details = DB::table('users')
					->where('id',"=",$customers_id)
					->first();
					
					$customer_type = $customer_details->customer_type;
				
					 
				
					if($customer_type=="BUSINESSOWNER"){
						DB::table('orders')
						->where('customers_id','=',$customers_id)
						->where('orders_id', '=', $orders_id)
						->update(['reward_points' => $reward_points,
								'cashback_amount' => $cashbackamount]);
							
							
					}
				
					 
					 
				}
				
				*/
				//Reward Points End

				//notification/email
			//	$myVar = new AlertController();
			//	$alertSetting = $myVar->orderAlert($ordersData);
				
				
				
			 
				
//send sms 

orderconfirm($orders_id,$delivery_phone);
//send sms 

 
 
 

// Shipping Charges SMS Start
if($customer_type=="CUSTOMER" || $customer_type=="BUSINESSOWNER"){
	 
	 
	$customer_details = DB::table('users')
	->where('users.id',$customers_id)->first();
	 
	$username =$customer_details->first_name . ' ' . $customer_details->last_name;
	 
	$userphone =$customer_details->phone;
	 
	shippingchargessms($orders_id,$username,$userphone);

	 
}
 
 

			}else if($payment_status == "failed"){
				if(!empty($error_cybersource)){
					$return_error = $error_cybersource;
				}else{
					$return_error = 'Error while placing order.';
				}
				$responseData = array('success'=>'0', 'data'=>array(), 'message'=>$error_cybersource);
			}
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}


//get all the status for customers
 public static function getorderstatus($request)
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

  $row = "3";
  //Cancel   3 
  //Return   4
   
$idsArr = explode(',',$row);  
 
 

            $statuses = DB::table('orders_status_description')->whereIn('orders_status_description_id',$idsArr)->get();

            $responseData = array('success' => '1', 'data' => $statuses, 'message' => "Returned all Orders Status.");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $response = json_encode($responseData);
        return $response;
    }




//get all the status for delivery boy
 public static function getorderstatusfor_deliveryboy($request)
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

  $row = "8,9";
  //Delivered to customer
  //Unable to Deliver - Customer Not Available
   
$idsArr = explode(',',$row);  
 
 

            $statuses = DB::table('orders_status_description')->whereIn('orders_status_description_id',$idsArr)->get();

            $responseData = array('success' => '1', 'data' => $statuses, 'message' => "Returned all Orders Status.");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $response = json_encode($responseData);
        return $response;
    }


public static function getorders($request)
{
  $consumer_data 		 				  =  array();
  $customers_id						  =  $request->customers_id;
  $language_id						  =  $request->language_id;
  $requested_currency       =  $request->currency_code;
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){

    $order = DB::table('orders')->orderBy('date_purchased', 'desc')
        ->where([
          ['customers_id', '=', $customers_id],
        ])->get();


    if(count($order) > 0){
      //foreach
      $index = '0';
      foreach($order as $data){
        // $data->total_tax =  Orders::convertprice($data->total_tax, $requested_currency);
        // $data->order_price =  Orders::convertprice($data->order_price, $requested_currency);
        // $data->shipping_cost =  Orders::convertprice($data->shipping_cost, $requested_currency);
        // $data->coupon_amount =  Orders::convertprice($data->coupon_amount, $requested_currency);

        if(!empty($data->product_discount_percentage)){
          $product_ids = explode(',', $coupons[0]->product_ids);
          $data->product_ids =  $product_ids;
        }
        else{
          $data->product_ids = array();
        }

        if(!empty($data->discount_type)){
          $exclude_product_ids = explode(',', $data->discount_type);
          $data->discount_type =  $exclude_product_ids;
        }else{
          $data->discount_type =  array();
        }

        if(!empty($data->amount)){
          $product_categories = explode(',', $data[0]->amount);
          $data->amount =  $product_categories;
        }else{
          $data->amount =  array();
        }

        if(!empty($data->product_ids)){
          $excluded_product_categories = explode(',', $data->product_ids);
          $data->product_ids =  $excluded_product_categories;
        }else{
          $data->product_ids = array();
        }

        if(!empty($data->exclude_product_ids)){
          $email_restrictions = explode(',', $data->exclude_product_ids);
          $data->exclude_product_ids =  $email_restrictions;
        }else{
          $data->exclude_product_ids =  array();
        }

        if(!empty($data->usage_limit)){
          $used_by = explode(',', $data->usage_limit);
          $data->usage_limit =  $used_by;
        }else{
          $data->usage_limit =  array();
        }

        if(!empty($data->product_categories)){
          $used_by = explode(',', $data->product_categories);
          $data->product_categories =  $used_by;
        }else{
          $data->product_categories =  array();
        }

        if(!empty($data->excluded_product_categories)){
          $used_by = explode(',', $data->excluded_product_categories);
          $data->excluded_product_categories =  $used_by;
        }else{
          $data->excluded_product_categories =  array();
        }

        if(!empty($data->coupon_code)){

          $coupon_code =  $data->coupon_code;

          $coupon_datas = array();
          $index_c = 0;
          foreach(json_decode($coupon_code) as $coupon_codes){

            if(!empty($coupon_codes->code)){
              $code = explode(',', $coupon_codes->code);
              $coupon_datas[$index_c]['code'] =  $code[0];
            }else{
              $coupon_datas[$index_c]['code'] =  '';
            }

            if(!empty($coupon_codes->amount)){
              $amount = explode(',', $coupon_codes->amount);
              $amount =  Orders::convertprice($amount[0], $requested_currency);
              //$coupon_datas[$index_c]['amount'] =  $amount;

              $coupon_datas[$index_c]['amount'] = $coupon_codes->amount;
            }else{
              $coupon_datas[$index_c]['amount'] =  '';
            }


            if(!empty($coupon_codes->discount_type)){
              $discount_type = explode(',', $coupon_codes->discount_type);
              $coupon_datas[$index_c]['discount_type'] =  $discount_type[0];
            }else{
              $coupon_datas[$index_c]['discount_type'] =  '';
            }

            $index_c++;
          }
          $order[$index]->coupons = $coupon_datas;
        }
        else{
          $coupon_code =  array();
          $order[$index]->coupons = $coupon_code;
        }

        unset($data->coupon_code);

        $orders_id	 = $data->orders_id;

        $orders_status_history = DB::table('orders_status_history')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->select('orders_status_description.orders_status_name', 'orders_status.orders_status_id', 'orders_status_history.order_comments')
            ->where('orders_id', '=', $orders_id)->orderby('orders_status_history.orders_status_history_id', 'ASC')->get();

        $order[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
        $order[$index]->orders_status = $orders_status_history[0]->orders_status_name;
        $order[$index]->customer_comments = $orders_status_history[0]->order_comments;

        $total_comments = count($orders_status_history);
        $i = 1;

        foreach($orders_status_history as $orders_status_history_data){

          if($total_comments == $i && $i != 1){
            $order[$index]->orders_status_id = $orders_status_history_data->orders_status_id;
            $order[$index]->orders_status = $orders_status_history_data->orders_status_name;
            $order[$index]->admin_comments = $orders_status_history_data->order_comments;
          }else{
            $order[$index]->admin_comments = '';
          }

          $i++;
        }

        $orders_products = DB::table('orders_products')
        ->join('products', 'products.products_id','=', 'orders_products.products_id')
        //to get the individual order status  add on april 20 2023
        ->LeftJoin('product_orders_status', 'product_orders_status.product_orders_status_id','=', 'orders_products.order_product_status_id')
        
        
        ->LeftJoin('image_categories', function ($join) {
          $join->on('image_categories.image_id', '=', 'products.products_image')
              ->where(function ($query) {
                  $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                      ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                      ->orWhere('image_categories.image_type', '=', 'ACTUAL');
              });
        })
    //    ->select('orders_products.*', 'image_categories.path as image')
            //to get the individual order status  add on april 20 2023

    ->select('orders_products.*', 'image_categories.path as image','product_orders_status.product_orders_status_name')


        ->where('orders_products.orders_id', '=', $orders_id)->get();
        $k = 0;
        $product = array();
        foreach($orders_products as $orders_products_data){
          // $orders_products_data->products_price =  Orders::convertprice($orders_products_data->products_price, $requested_currency);
          // $orders_products_data->final_price =  Orders::convertprice($orders_products_data->final_price, $requested_currency);
          //categories
          $categories = DB::table('products_to_categories')
                  ->leftjoin('categories','categories.categories_id','products_to_categories.categories_id')
                  ->leftjoin('categories_description','categories_description.categories_id','products_to_categories.categories_id')
                  ->select('categories.categories_id','categories_description.categories_name',
                  'categories.categories_image','categories.categories_icon', 'categories.parent_id')
                  ->where('products_id','=', $orders_products_data->products_id)
                  ->where('categories_description.language_id','=',$language_id)->get();

          $orders_products_data->categories =  $categories;

          $product_attribute = DB::table('orders_products_attributes')
            ->where([
              ['orders_products_id', '=', $orders_products_data->orders_products_id],
              ['orders_id', '=', $orders_products_data->orders_id],
            ])
            ->get();

          $orders_products_data->attributes = $product_attribute;
          $product[$k] = $orders_products_data;
          $k++;
        }
        $data->data = $product;
        $orders_data[] = $data;
      $index++;
      }
        $responseData = array('success'=>'1', 'data'=>$orders_data, 'message'=>"Returned all orders.");
    }else{
        $orders_data = array();
        $responseData = array('success'=>'0', 'data'=>$orders_data, 'message'=>"Order is not placed yet.");
    }
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}


//delivery boy orders


public static function getordersfordeliveryboy($request)
{
  $consumer_data 		 				  =  array();
  $customers_id						  =  $request->customers_id;
  $language_id						  =  $request->language_id;
  $requested_currency       =  $request->currency_code;
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){
      
      
      $row = "6,7";
$idsArr = explode(',',$row);  

/*
 $ordersfordeliveryboy=DB::table('orders_status_history')->whereIn('orders_status_id',$idsArr)->where([
          ['deliveryboy_user_id', '=', $customers_id],
        ])->orderBy('orders_status_history_id', 'asc')->get();
     */   
     
     $ordersfordeliveryboy = DB::table('orders_status_history')
            ->select(DB::raw("group_concat(orders_id) as orders_idz"))
            ->whereIn('orders_status_id',$idsArr)->where([
          ['deliveryboy_user_id', '=', $customers_id],
        ])->orderBy('orders_status_history_id', 'asc')->get();
        
        
       // $sql="select * from `orders_status_history` where `orders_status_id` in (3, 4, 5) and (`deliveryboy_user_id` = $customers_id)";
       // $result =DB::select($sql)->get();
//$order_idz = $ordersfordeliveryboy->toArray();


//$order_idz = explode(',',$order_idz);

  
   
  //$order_idz=implode(",",$order_idz);
   $row = $ordersfordeliveryboy[0]->orders_idz;
   $idsArr = explode(',',$row);  




 

       $order = DB::table('orders')->orderBy('date_purchased', 'desc')
       ->whereIn('orders_id',$idsArr)->get();
   

  /*  $order = DB::table('orders')->orderBy('customers_id', 'desc')
        ->where([
          ['customers_id', '=', $customers_id],
        ])->get();*/


    if(count($order) > 0){
      //foreach
      $index = '0';
      foreach($order as $data){
        // $data->total_tax =  Orders::convertprice($data->total_tax, $requested_currency);
        // $data->order_price =  Orders::convertprice($data->order_price, $requested_currency);
        // $data->shipping_cost =  Orders::convertprice($data->shipping_cost, $requested_currency);
        // $data->coupon_amount =  Orders::convertprice($data->coupon_amount, $requested_currency);

        if(!empty($data->product_discount_percentage)){
          $product_ids = explode(',', $coupons[0]->product_ids);
          $data->product_ids =  $product_ids;
        }
        else{
          $data->product_ids = array();
        }

        if(!empty($data->discount_type)){
          $exclude_product_ids = explode(',', $data->discount_type);
          $data->discount_type =  $exclude_product_ids;
        }else{
          $data->discount_type =  array();
        }

        if(!empty($data->amount)){
          $product_categories = explode(',', $data[0]->amount);
          $data->amount =  $product_categories;
        }else{
          $data->amount =  array();
        }

        if(!empty($data->product_ids)){
          $excluded_product_categories = explode(',', $data->product_ids);
          $data->product_ids =  $excluded_product_categories;
        }else{
          $data->product_ids = array();
        }

        if(!empty($data->exclude_product_ids)){
          $email_restrictions = explode(',', $data->exclude_product_ids);
          $data->exclude_product_ids =  $email_restrictions;
        }else{
          $data->exclude_product_ids =  array();
        }

        if(!empty($data->usage_limit)){
          $used_by = explode(',', $data->usage_limit);
          $data->usage_limit =  $used_by;
        }else{
          $data->usage_limit =  array();
        }

        if(!empty($data->product_categories)){
          $used_by = explode(',', $data->product_categories);
          $data->product_categories =  $used_by;
        }else{
          $data->product_categories =  array();
        }

        if(!empty($data->excluded_product_categories)){
          $used_by = explode(',', $data->excluded_product_categories);
          $data->excluded_product_categories =  $used_by;
        }else{
          $data->excluded_product_categories =  array();
        }

        if(!empty($data->coupon_code)){

          $coupon_code =  $data->coupon_code;

          $coupon_datas = array();
          $index_c = 0;
          foreach(json_decode($coupon_code) as $coupon_codes){

            if(!empty($coupon_codes->code)){
              $code = explode(',', $coupon_codes->code);
              $coupon_datas[$index_c]['code'] =  $code[0];
            }else{
              $coupon_datas[$index_c]['code'] =  '';
            }

            if(!empty($coupon_codes->amount)){
              $amount = explode(',', $coupon_codes->amount);
              $amount =  Orders::convertprice($amount[0], $requested_currency);
              //$coupon_datas[$index_c]['amount'] =  $amount;

              $coupon_datas[$index_c]['amount'] = $coupon_codes->amount;
            }else{
              $coupon_datas[$index_c]['amount'] =  '';
            }


            if(!empty($coupon_codes->discount_type)){
              $discount_type = explode(',', $coupon_codes->discount_type);
              $coupon_datas[$index_c]['discount_type'] =  $discount_type[0];
            }else{
              $coupon_datas[$index_c]['discount_type'] =  '';
            }

            $index_c++;
          }
          $order[$index]->coupons = $coupon_datas;
        }
        else{
          $coupon_code =  array();
          $order[$index]->coupons = $coupon_code;
        }

        unset($data->coupon_code);

        $orders_id	 = $data->orders_id;

        $orders_status_history = DB::table('orders_status_history')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->select('orders_status_description.orders_status_name', 'orders_status.orders_status_id', 'orders_status_history.order_comments')
            ->where('orders_id', '=', $orders_id)->orderby('orders_status_history.orders_status_history_id', 'ASC')->get();

        $order[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
        $order[$index]->orders_status = $orders_status_history[0]->orders_status_name;
        $order[$index]->customer_comments = $orders_status_history[0]->order_comments;

        $total_comments = count($orders_status_history);
        $i = 1;

        foreach($orders_status_history as $orders_status_history_data){

          if($total_comments == $i && $i != 1){
            $order[$index]->orders_status_id = $orders_status_history_data->orders_status_id;
            $order[$index]->orders_status = $orders_status_history_data->orders_status_name;
            $order[$index]->admin_comments = $orders_status_history_data->order_comments;
          }else{
            $order[$index]->admin_comments = '';
          }

          $i++;
        }

        $orders_products = DB::table('orders_products')
        ->join('products', 'products.products_id','=', 'orders_products.products_id')
        ->LeftJoin('image_categories', function ($join) {
          $join->on('image_categories.image_id', '=', 'products.products_image')
              ->where(function ($query) {
                  $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                      ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                      ->orWhere('image_categories.image_type', '=', 'ACTUAL');
              });
        })
        ->select('orders_products.*', 'image_categories.path as image')
        ->where('orders_products.orders_id', '=', $orders_id)->get();
        $k = 0;
        $product = array();
        foreach($orders_products as $orders_products_data){
          // $orders_products_data->products_price =  Orders::convertprice($orders_products_data->products_price, $requested_currency);
          // $orders_products_data->final_price =  Orders::convertprice($orders_products_data->final_price, $requested_currency);
          //categories
          $categories = DB::table('products_to_categories')
                  ->leftjoin('categories','categories.categories_id','products_to_categories.categories_id')
                  ->leftjoin('categories_description','categories_description.categories_id','products_to_categories.categories_id')
                  ->select('categories.categories_id','categories_description.categories_name',
                  'categories.categories_image','categories.categories_icon', 'categories.parent_id')
                  ->where('products_id','=', $orders_products_data->products_id)
                  ->where('categories_description.language_id','=',$language_id)->get();

          $orders_products_data->categories =  $categories;

          $product_attribute = DB::table('orders_products_attributes')
            ->where([
              ['orders_products_id', '=', $orders_products_data->orders_products_id],
              ['orders_id', '=', $orders_products_data->orders_id],
            ])
            ->get();

          $orders_products_data->attributes = $product_attribute;
          $product[$k] = $orders_products_data;
          $k++;
        }
        $data->data = $product;
        $orders_data[] = $data;
      $index++;
      }
        $responseData = array('success'=>'1', 'data'=>$orders_data, 'message'=>"Returned all orders.");
    }else{
        $orders_data = array();
        $responseData = array('success'=>'0', 'data'=>$orders_data, 'message'=>"Order is not placed yet.");
    }
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}


public static function updatestatus($request)
{

  		$consumer_data 		 				  =  array();
  		$orders_id							  =  $request->orders_id;
  		
  	  		$payment_txt_details							  =  $request->payment_txt_details;
	
  		
  		$consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  		$consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  		$consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  		$consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
      $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  		$consumer_data['consumer_url']  	  =  __FUNCTION__;
  		$authController = new AppSettingController();
  		$authenticate = $authController->apiAuthenticate($consumer_data);

  		if($authenticate==1){

  			$date_added			=    date('Y-m-d h:i:s');
  			$comments			=	  $request->order_comments;
  				$orders_status_description_id			=	  $request->orders_status_description_id;
  			$orders_history_id = DB::table('orders_status_history')->insertGetId(
  				[	 'orders_id'  => $orders_id,
  					 'orders_status_id' => $orders_status_description_id,
  					 'date_added'  => $date_added,
  					 'customer_notified' =>'1',
  					 'order_comments'  =>  $comments
  				]);
  				
  			 
  				
  		/*	DB::table('orders')
              ->where('orders_id',$orders_id)
              ->update(['order_information' => $payment_txt_details]);*/

  			$responseData = array('success'=>'1', 'data'=>array(), 'message'=>"Status has been changed succefully.");

  		}else{
  			$responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  		}
  		$orderResponse = json_encode($responseData);

      return $orderResponse;
}




public static function updatestatusbydeliveryboy($request)
{

  		$consumer_data 		 				  =  array();
  		$orders_id							  =  $request->orders_id;
  		
  	  		$payment_txt_details							  =  $request->payment_txt_details;
	
  		
  		$consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  		$consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  		$consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  		$consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
      $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  		$consumer_data['consumer_url']  	  =  __FUNCTION__;
  		$authController = new AppSettingController();
  		$authenticate = $authController->apiAuthenticate($consumer_data);

  		if($authenticate==1){

  			$date_added			=    date('Y-m-d h:i:s');
  			$comments			=	  $request->order_comments;
  				$orders_status_description_id			=	  $request->orders_status_description_id;
  			$orders_history_id = DB::table('orders_status_history')->insertGetId(
  				[	 'orders_id'  => $orders_id,
  					 'orders_status_id' => $orders_status_description_id,
  					 'date_added'  => $date_added,
  					 'customer_notified' =>'1',
  					 'order_comments'  =>  $comments
  				]);
  				
  			$order= DB::table('orders')->where('orders_id',$orders_id)->get();
  		$payment_method=	$order[0]->payment_method;
  			if($payment_method=='Cash on Delivery'){
  			    	DB::table('orders')
              ->where('orders_id',$orders_id)
              ->update(['order_information' => $payment_txt_details]);
  			}
  	/*			
  	
  	if Cash on Delivery then  update thw ith order information ....
  			DB::table('orders')
              ->where('orders_id',$orders_id)
              ->update(['order_information' => $payment_txt_details]);*/

  			$responseData = array('success'=>'1', 'data'=>array(), 'message'=>"Status has been changed succefully.");

  		}else{
  			$responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  		}
  		$orderResponse = json_encode($responseData);

      return $orderResponse;
}

public static function get_client_ip_env(){
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}
	
	
 
//place order
public static function checkoutorder($request)
{
    $consumer_data 		 				  =  array();
    $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
    $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);
    $ipAddress = Orders::get_client_ip_env();
    $customer_type="";
    if(1){
        
       //fetching the data from the cart 
        $mobilecart = new MobileCart();
        $result = array();
        $cart_items = $mobilecart->myCartOrder($request);
        $result['cart'] = $cart_items;
        
        
        $order_distributor_price=0;
        
        if (count($result['cart']) > 0) {
            
            foreach ($result['cart'] as $products) {
                $req = array();
                $attr = array();
                $req['products_id'] = $products->products_id;
                if (isset($products->productattributes)) {
                    foreach ($products->productattributes as $key => $value) {
                        $attr[$key] = $value->products_attributes_id;
                    }
                    $req['attributes'] = $attr;
                }
               
                $productsquantity = new Product();
                $check = $productsquantity->getquantityinorder($req);
               
                if ($products->customers_basket_quantity > $check['stock']) {
                  //  session(['out_of_stock' => 1]);
                 //   session(['out_of_stock_product' => $products->products_id]);
                   // return redirect('viewcart');
                    
                    $responseData = array('success'=>'0', 'data'=>array(), 'message'=>"out of stock");
                }else{
                  //  session(['out_of_stock' => 0]);
                  //  session(['out_of_stock_product' =>0]);
                }
                
               // $price += $products->final_price * $products->customers_basket_quantity;
               
                
                $order_distributor_price += $products->distributor_final_price * $products->customers_basket_quantity;
                
            }
            
            $order_distributor_price = $order_distributor_price;
        }
        //fetching the data from the cart 
        
        $guest_status             = $request->guest_status;
        if($guest_status == 1){
            $check = DB::table('users')->where('role_id',2)->where('email',$request->email)->first();
            if($check == null){
                $customers_id = DB::table('users')
                ->insertGetId([
                    'role_id' => 2,
                    'email' => $request->email,
                    'password' => Hash::make('123456dfdfdf'),
                    'first_name' => $request->delivery_firstname,
                    'last_name' => $request->delivery_lastname,
                    'phone' => $request->customers_telephone
                ]);
            }
            else{
                $customers_id = $check->id;
            }
        }
        else{
            $customers_id            				=   $request->customers_id;
        }
        
        $date_added								=	date('Y-m-d h:i:s');
        $customers_telephone            		=   $request->customers_telephone;
        $email            						=   $request->email;
        $delivery_firstname  	          		=   $request->delivery_firstname;
        $delivery_lastname            			=   $request->delivery_lastname;
        $delivery_street_address            	=   $request->delivery_street_address;
        $delivery_suburb            			=   $request->delivery_suburb;
        $delivery_city            				=   $request->delivery_city;
        $delivery_postcode            			=   $request->delivery_postcode;
        
        
        $delivery = DB::table('zones')->where('zone_name', '=', $request->delivery_zone)->first();
        
        if($delivery){
            $delivery_state            				=   $delivery->zone_code;
        }else{
            $delivery_state            				=   'other';
        }
        
        $delivery_country            			=   $request->delivery_country;
        $billing_firstname            			=   $request->billing_firstname;
        $billing_lastname            			=   $request->billing_lastname;
        $billing_street_address            		=   $request->billing_street_address;
        $billing_suburb	            			=   $request->billing_suburb;
        $billing_city            				=   $request->billing_city;
        $billing_postcode            			=   $request->billing_postcode;
        
        $billing = DB::table('zones')->where('zone_name', '=', $request->billing_zone)->first();
        
        if($billing){
            $billing_state            				=   $billing->zone_code;
        }else{
            $billing_state            				=   'other';
        }
        
        $billing_country            			=   $request->billing_country;
        $payment_method            				=   $request->payment_method;
        $order_information 						=	array();
        
        $cc_type            				=   $request->cc_type;
        $cc_owner            				=   $request->cc_owner;
        $cc_number            				=   $request->cc_number;
        $cc_expires            				=   $request->cc_expires;
        $last_modified            			=   date('Y-m-d H:i:s');
        $date_purchased            			=   date('Y-m-d H:i:s');
        $order_price						        =   $request->totalPrice;
        $currency_code           				=   $request->currency_code;
        $order_price                    =   Orders::converttodefaultprice($request->totalPrice, $currency_code);
        $shipping_cost            			=   $request->shipping_cost;
        $shipping_cost                  =   Orders::converttodefaultprice($request->shipping_cost, $currency_code);
        $shipping_method            		=   $request->shipping_method;
        $orders_status            			=   '1';
        $orders_date_finished            	=   $request->orders_date_finished;
        $comments            				=   $request->comments;
        
        //additional fields
        $delivery_phone						=	$request->delivery_phone;
        $billing_phone						=	$request->billing_phone;
        
        //alternate fileds for phone
        
        //additional fields
        $alt_delivery_phone						=	$request->alt_delivery_phone;
        $alt_billing_phone						=	$request->alt_billing_phone;
        
        
        $settings = DB::table('settings')->get();
        $currency_value            			=   $request->currency_value;
        
        //tax info
        $total_tax							=	$request->total_tax;
        $total_tax              = Orders::converttodefaultprice($request->total_tax, $currency_code);
        
        $products_tax 						= 	1;
        //coupon info
        $is_coupon_applied            		=   $request->is_coupon_applied;
        
        if($is_coupon_applied==1){
            
            $code = array();
            $coupon_amount = 0;
            $exclude_product_ids = array();
            $product_categories = array();
            $excluded_product_categories = array();
            $exclude_product_ids = array();
            
            $coupon_amount    =		$request->coupon_amount;
            
            //convert price to default currency price
            $coupon_amount = Orders::converttodefaultprice($coupon_amount, $currency_code);
            
            foreach($request->coupons as $coupons_data){
                
                //update coupans
                $coupon_id = DB::statement("UPDATE `coupons` SET `used_by`= CONCAT(used_by,',$customers_id') WHERE `code` = '".$coupons_data['code']."'");
                
            }
            $code = json_encode($request->coupons);
            
        }else{
            $code            					=   '';
            $coupon_amount            			=   0;
        }
        
        //payment methods
        $payments_setting = Orders::payments_setting_for_brain_tree($request);
        
        if($payment_method == 'braintree_card' or $payment_method == 'braintree_paypal'){
            if($payment_method == 'braintree_card'){
                $fieldName = 'sub_name_1';
                $paymentMethodName = 'Braintree Card';
            }else{
                $fieldName = 'sub_name_2';
                $paymentMethodName = 'Braintree Paypal';
            }
            
            // $paymentMethodName = $payments_setting->$fieldName;
            
            //braintree transaction with nonce
            $is_transaction  = '1'; 			# For payment through braintree
            $nonce    		 =   $request->nonce;
            
            if($payments_setting['merchant_id']->environment=='0'){
                $braintree_enviroment = 'Test';
            }else{
                $braintree_enviroment = 'Live';
            }
            
            $braintree_merchant_id = $payments_setting['merchant_id']->value;
            $braintree_public_key  = $payments_setting['public_key']->value;
            $braintree_private_key = $payments_setting['private_key']->value;
            
            //brain tree credential
            require_once app_path('braintree/index.php');
            
            if ($result->success)
            {
                if($result->transaction->id)
                {
                    $order_information = array(
                        'braintree_id'=>$result->transaction->id,
                        'status'=>$result->transaction->status,
                        'type'=>$result->transaction->type,
                        'currencyIsoCode'=>$result->transaction->currencyIsoCode,
                        'amount'=>$result->transaction->amount,
                        'merchantAccountId'=>$result->transaction->merchantAccountId,
                        'subMerchantAccountId'=>$result->transaction->subMerchantAccountId,
                        'masterMerchantAccountId'=>$result->transaction->masterMerchantAccountId,
                        //'orderId'=>$result->transaction->orderId,
                        'createdAt'=>time(),
                        //						'updatedAt'=>$result->transaction->updatedAt->date,
                        'token'=>$result->transaction->creditCard['token'],
                        'bin'=>$result->transaction->creditCard['bin'],
                        'last4'=>$result->transaction->creditCard['last4'],
                        'cardType'=>$result->transaction->creditCard['cardType'],
                        'expirationMonth'=>$result->transaction->creditCard['expirationMonth'],
                        'expirationYear'=>$result->transaction->creditCard['expirationYear'],
                        'customerLocation'=>$result->transaction->creditCard['customerLocation'],
                        'cardholderName'=>$result->transaction->creditCard['cardholderName']
                    );
                    $payment_status = "success";
                }
            }
            else
            {
                $payment_status = "failed";
            }
            
        }else if($payment_method == 'stripe'){				#### stipe payment
            
            $payments_setting = Orders::payments_setting_for_stripe($request);
            $paymentMethodName = $payments_setting['publishable_key']->name;
            
            //require file
            require_once app_path('stripe/config.php');
            
            //get token from app
            $token  = $request->nonce;
            
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source'  => $token
            ));
            
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount'   => 100*$order_price,
                'currency' => 'usd'
            ));
            
            if($charge->paid == true){
                $order_information = array(
                    'paid'=>'true',
                    'transaction_id'=>$charge->id,
                    'type'=>$charge->outcome->type,
                    'balance_transaction'=>$charge->balance_transaction,
                    'status'=>$charge->status,
                    'currency'=>$charge->currency,
                    'amount'=>$charge->amount,
                    'created'=>date('d M,Y', $charge->created),
                    'dispute'=>$charge->dispute,
                    'customer'=>$charge->customer,
                    'address_zip'=>$charge->source->address_zip,
                    'seller_message'=>$charge->outcome->seller_message,
                    'network_status'=>$charge->outcome->network_status,
                    'expirationMonth'=>$charge->outcome->type
                );
                
                $payment_status = "success";
                
            }else{
                $payment_status = "failed";
            }
            
        }else if($payment_method == 'cod'){
            
            $payments_setting = Orders::payments_setting_for_cod($request);
            $paymentMethodName =  $payments_setting->name;
            $payment_method = 'Cash on Delivery';
            $payment_status='success';
            
        }
        
        
        //add for builder mart wallet purpose
        else if($payment_method == 'buildermart_wallet'){
            
            
            
            
            
            $payments_setting = Orders::payments_setting_for_buildermart_wallet($request);
            $paymentMethodName =  $payments_setting->name;
            //$payment_method = 'buildermart_wallet';
            $payment_status='success';
            
        }
        
        
        else if($payment_method == 'instamojo'){
            
            $payments_setting = Orders::payments_setting_for_instamojo($request);
            $paymentMethodName = $payments_setting['auth_token']->name;
            $payment_method = 'Instamojo';
            $payment_status='success';
            $order_information = array('payment_id'=>$request->nonce, 'transaction_id'=>$request->transaction_id);
            
        }else if($payment_method == 'hyperpay'){
            $payments_setting = Orders::payments_setting_for_hyperpay($request);
            $paymentMethodName = $payments_setting['userid']->name;
            $payment_method = 'Hyperpay';
            $payment_status='success';
        }else if($payment_method == 'razorpay'){
            $payments_setting = Orders::payments_setting_for_razorpay($request);
            $paymentMethodName = $payments_setting['RAZORPAY_KEY']->name;
            $payment_method = 'Razorpay';
            $payment_status='success';
            
            //added on 2 oct 2020
            $order_information = array('payment_id'=>$request->nonce, 'transaction_id'=>$request->transaction_id,'order_payment_id'=>$request->order_payment_id);
            
            
        }else if($payment_method == 'paytm'){
            $payments_setting = Orders::payments_setting_for_paytm($request);
            $paymentMethodName = $payments_setting['paytm_mid']->name;
            $payment_method = 'Paytm';
            $payment_status='success';
        }else if($payment_method == 'paytm'){
            $payments_setting = Orders::payments_setting_for_directbank($request);
            $paymentMethodName = $payments_setting['account_name']->name;
            $payment_method = 'directbank';
            $payment_status='success';
            $order_information = array(
                'account_name' => $payments_setting['account_name']->value,
                'account_number' => $payments_setting['account_number']->value,
                'payment_method' => $payments_setting['account_name']->payment_method,
                'bank_name' => $payments_setting['bank_name']->value,
                'short_code' => $payments_setting['short_code']->value,
                'iban' => $payments_setting['iban']->value,
                'swift' => $payments_setting['swift']->value,
            );
        }else if($payment_method == 'paystack'){
            $payments_setting = Orders::payments_setting_for_paystack($request);
            $paymentMethodName = $payments_setting['secret_key']->name;
            $payment_method = 'paystack';
            $payment_status='success';
            $order_information = '';
        }
        
        
        //check if order is verified
        if($payment_status=='success'){
            if( $payment_method == 'hyperpay'){
                $cyb_orders = DB::table('orders')->where('transaction_id','=',$request->transaction_id)->get();
                $orders_id = $cyb_orders[0]->orders_id;
                
                //update database
                DB::table('orders')->where('transaction_id','=',$request->transaction_id)->update(
                    [	 'customers_id' => $customers_id,
                        'customers_name'  => $delivery_firstname.' '.$delivery_lastname,
                        'customers_street_address' => $delivery_street_address,
                        'customers_suburb'  =>  $delivery_suburb,
                        'customers_city' => $delivery_city,
                        'customers_postcode'  => $delivery_postcode,
                        'customers_state' => $delivery_state,
                        'customers_country'  =>  $delivery_country,
                        'customers_telephone' => $customers_telephone,
                        'email'  => $email,
                        
                        'delivery_name'  =>  $delivery_firstname.' '.$delivery_lastname,
                        'delivery_street_address' => $delivery_street_address,
                        'delivery_suburb'  => $delivery_suburb,
                        'delivery_city' => $delivery_city,
                        'delivery_postcode'  =>  $delivery_postcode,
                        'delivery_state' => $delivery_state,
                        'delivery_country'  => $delivery_country,
                        'billing_name'  => $billing_firstname.' '.$billing_lastname,
                        'billing_street_address' => $billing_street_address,
                        'billing_suburb'  =>  $billing_suburb,
                        'billing_city' => $billing_city,
                        'billing_postcode'  => $billing_postcode,
                        'billing_state' => $billing_state,
                        'billing_country'  =>  $billing_country,
                        
                        'payment_method'  =>  $paymentMethodName,
                        'cc_type' => $cc_type,
                        'cc_owner'  => $cc_owner,
                        'cc_number' =>$cc_number,
                        'cc_expires'  =>  $cc_expires,
                        'last_modified' => $last_modified,
                        'date_purchased'  => $date_purchased,
                        'order_price'  => $order_price,
                        
                        'distributor_order_price' => $order_distributor_price,
                        
                        'shipping_cost' =>$shipping_cost,
                        'shipping_method'  =>  $shipping_method,
                        'currency'  =>  $currency_code,
                        'currency_value' => $last_modified,
                        'coupon_code'		 =>		$code,
                        'coupon_amount' 	 =>		$coupon_amount,
                        'total_tax'		 =>		$total_tax,
                        'ordered_source' 	 => 	'2',
                        'delivery_phone'	 =>		$delivery_phone,
                        'billing_phone'	 =>		$billing_phone,
                        
                        
                        'delivery_alternate_phone'	 =>		$alt_delivery_phone	,
                        'billing_alternate_phone'	 =>		$alt_billing_phone
                        
                    ]);
                
            }else{
                
                //insert order
                $orders_id = DB::table('orders')->insertGetId(
                    [	 'customers_id' => $customers_id,
                        'customers_name'  => $delivery_firstname.' '.$delivery_lastname,
                        'customers_street_address' => $delivery_street_address,
                        'customers_suburb'  =>  $delivery_suburb,
                        'customers_city' => $delivery_city,
                        'customers_postcode'  => $delivery_postcode,
                        'customers_state' => $delivery_state,
                        'customers_country'  =>  $delivery_country,
                        'customers_telephone' => $customers_telephone,
                        'email'  => $email,
                        
                        'delivery_name'  =>  $delivery_firstname.' '.$delivery_lastname,
                        'delivery_street_address' => $delivery_street_address,
                        'delivery_suburb'  => $delivery_suburb,
                        'delivery_city' => $delivery_city,
                        'delivery_postcode'  =>  $delivery_postcode,
                        'delivery_state' => $delivery_state,
                        'delivery_country'  => $delivery_country,
                        
                        'billing_name'  => $billing_firstname.' '.$billing_lastname,
                        'billing_street_address' => $billing_street_address,
                        'billing_suburb'  =>  $billing_suburb,
                        'billing_city' => $billing_city,
                        'billing_postcode'  => $billing_postcode,
                        'billing_state' => $billing_state,
                        'billing_country'  =>  $billing_country,
                        
                        'payment_method'  =>  $paymentMethodName,
                        'cc_type' => $cc_type,
                        'cc_owner'  => $cc_owner,
                        'cc_number' =>$cc_number,
                        'cc_expires'  =>  $cc_expires,
                        'last_modified' => $last_modified,
                        'date_purchased'  => $date_purchased,
                        'order_price'  => $order_price,
                        
                        'distributor_order_price' => $order_distributor_price,
                        
                        'shipping_cost' =>$shipping_cost,
                        'shipping_method'  =>  $shipping_method,
                        'currency'  =>  $currency_code,
                        'currency_value' => $last_modified,
                        'order_information' => json_encode($order_information),
                        'coupon_code'		 =>		$code,
                        'coupon_amount' 	 =>		$coupon_amount,
                        'total_tax'		 =>		$total_tax,
                        'ordered_source' 	 => 	'2',
                        'delivery_phone'	 =>		$delivery_phone,
                        'billing_phone'	 =>		$billing_phone,
                        
                        
                        'delivery_alternate_phone'	 =>		$alt_delivery_phone,
                        'billing_alternate_phone'	 =>		$alt_billing_phone,
                        'location_id'=> $request->location_id
                        
                    ]);
                
            }
            //orders status history
            $orders_history_id = DB::table('orders_status_history')->insertGetId(
                [	 'orders_id'  => $orders_id,
                    'orders_status_id' => $orders_status,
                    'date_added'  => $date_added,
                    'customer_notified' =>'1',
                    'order_comments'  =>  $comments,
                    'current_status'=>1
                ]);
            
            // looping the my cart data 
            foreach ($cart_items as $products) {
                
                if($products->product_selected_name){
                    
                    $product_selected_name=	$products->product_selected_name;
                }else{
                    $product_selected_name=	$products->products_name;
                }
                
                
                $producttax_details = DB::table('products')
                ->LeftJoin('tax_rates', 'tax_rates.tax_class_id', '=', 'products.products_tax_class_id')
                ->where('products_id', $products->products_id)->first();
                $productfinaltotalprice =$products->final_price * $products->customers_basket_quantity;
                $tax_value = $productfinaltotalprice + $productfinaltotalprice * $producttax_details->tax_rate / 100 ;
                
                $total_product_tax = $tax_value - $productfinaltotalprice;
                
                //get products info
                $orders_products_id = DB::table('orders_products')->insertGetId(
                    [
                        'orders_id' => $orders_id,
                        'products_id' => $products->products_id,
                        'distributor_id' => $products->distributor_id,
                        'distributor_products_price' => $products->distributor_product_price,
                        'distributor_final_price' => $products->distributor_final_price * $products->customers_basket_quantity,
                        
                        'distributor_product_price_percentage' => $products->distributor_product_price_percentage,
                        'hsn_sac_code' => $products->hsn_sac_code,
                        'cart_product_price' => $products->final_price,
                        'products_name' => $product_selected_name,
                        
                        'products_price' => $products->price,
                        'final_price' => $products->final_price * $products->customers_basket_quantity,
                        'product_tax_rate' => $producttax_details->tax_rate,
                        'products_tax' => $total_product_tax,
                        //  'products_tax' =>  $products->final_price * $products->customers_basket_quantity * 0.18,
                        'products_quantity' => $products->customers_basket_quantity,
                    ]);
                $inventory_ref_id = DB::table('inventory')->insertGetId([
                    'products_id' => $products->products_id,
                    'reference_code' => '',
                    'stock' => $products->customers_basket_quantity,
                    'admin_id' => 0,
                    'added_date' => time(),
                    'purchase_price' => 0,
                    'stock_type' => 'out',
                ]);
                
                if ($guest_status == 1) {
                    DB::table('customers_basket')->where('products_id', $products->products_id)->update(['is_order' => '1']);
                    
                } else {
                    DB::table('customers_basket')->where('customers_id', $customers_id)->where('products_id', $products->products_id)->update(['is_order' => '1']);
                    
                }
                
                if (!empty($products->productattributes) and count($products->productattributes)>0) {
                    
                    foreach ($products->productattributes as $attribute) {
                        DB::table('orders_products_attributes')->insert(
                            [
                                'orders_id' => $orders_id,
                                'products_id' => $products->products_id,
                                'orders_products_id' => $orders_products_id,
                                'products_options' => $attribute->attribute_name,
                                'products_options_values' => $attribute->attribute_value,
                                'distributor_options_values_price' => $attribute->distributor_options_values_price,
                                
                                'options_values_price' => $attribute->values_price,
                                'price_prefix' => $attribute->prefix,
                            ]);
                        
                        DB::table('inventory_detail')->insert([
                            'inventory_ref_id' => $inventory_ref_id,
                            'products_id' => $products->products_id,
                            'attribute_id' => $attribute->products_attributes_id,
                        ]);
                    }
                }
                
            }
            // looping the my cart data 
            $responseData = array('success'=>'1', 'data'=>array(), 'customer_id' => $customers_id,'message'=>"Order has been placed successfully.");
            
            //send order email to user
            $order = DB::table('orders')
            ->LeftJoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders.orders_id')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
            ->where('orders.orders_id', '=', $orders_id)->orderby('orders_status_history.date_added', 'DESC')->get();
            
            //foreach
            foreach($order as $data){
                $orders_id	 = $data->orders_id;
                
                $orders_products = DB::table('orders_products')
                ->join('products', 'products.products_id','=', 'orders_products.products_id')
                ->join('image_categories', 'products.products_image', '=', 'image_categories.image_id')
                ->select('orders_products.*', 'image_categories.path as image')
                
                //	->select('orders_products.*', 'products.products_image as image')
                ->where('orders_products.orders_id', '=', $orders_id)
                ->where('image_type', '=', 'THUMBNAIL')->get();
                
                $i = 0;
                $total_price  = 0;
                $product = array();
                $subtotal = 0;
                foreach($orders_products as $orders_products_data){
                    $product_attribute = DB::table('orders_products_attributes')
                    ->where([
                        ['orders_products_id', '=', $orders_products_data->orders_products_id],
                        ['orders_id', '=', $orders_products_data->orders_id],
                    ])
                    ->get();
                    
                    $orders_products_data->attribute = $product_attribute;
                    $product[$i] = $orders_products_data;
                    //$total_tax	 = $total_tax+$orders_products_data->products_tax;
                    $total_price += $orders_products[$i]->final_price;
                    
                    $subtotal += $orders_products[$i]->final_price;
                    
                    $i++;
                }
                
                $data->data = $product;
                $orders_data[] = $data;
            }
            
            $orders_status_history = DB::table('orders_status_history')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=' ,'orders_status_history.orders_status_id')
            ->orderBy('orders_status_history.date_added', 'desc')
            ->where('orders_id', '=', $orders_id)->get();
            
            $orders_status = DB::table('orders_status')->get();
            
            $ordersData['orders_data']		 	 	=	$orders_data;
            $ordersData['total_price']  			=	$total_price;
            $ordersData['orders_status']			=	$orders_status;
            
            
            
            $ordersData['orders_status_history']    =	$orders_status_history;
            $ordersData['subtotal']    				=	$subtotal;
            
            //	$ordersData['customers_id'] =	$customers_id;
            // commented on 31 jan 2022 , as the cashabck to be added on the order completion.
            // Reward Points Start
            /*
             $min_cart_value = DB::table('reward_points')
             ->where('min_cart_value',"<=",$total_price)
             ->orderBy("min_cart_value", "DESC")
             ->first();
             
             $reedem_values = DB::table('reedem_values')
             ->first();
             
             if($min_cart_value){
             
             $reward_points= $min_cart_value->reward_point;
             
             $cashbackamount= $reward_points * $reedem_values->value;
             
             
             $customer_details = DB::table('users')
             ->where('id',"=",$customers_id)
             ->first();
             
             $customer_type = $customer_details->customer_type;
             
             
             
             if($customer_type=="BUSINESSOWNER"){
             DB::table('orders')
             ->where('customers_id','=',$customers_id)
             ->where('orders_id', '=', $orders_id)
             ->update(['reward_points' => $reward_points,
             'cashback_amount' => $cashbackamount]);
             
             
             }
             
             
             
             }
             
             */
            //Reward Points End
            
            //notification/email
            //	$myVar = new AlertController();
            //	$alertSetting = $myVar->orderAlert($ordersData);
            
            
            
            
            
            //send sms
            
            orderconfirm($orders_id,$delivery_phone);
            //send sms
            
            
            
            
            
            // Shipping Charges SMS Start
            if($customer_type=="CUSTOMER" || $customer_type=="BUSINESSOWNER"){
                
                
                $customer_details = DB::table('users')
                ->where('users.id',$customers_id)->first();
                
                $username =$customer_details->first_name . ' ' . $customer_details->last_name;
                
                $userphone =$customer_details->phone;
                
                shippingchargessms($orders_id,$username,$userphone);
                
                
            }
            
            
            
        }else if($payment_status == "failed"){
            if(!empty($error_cybersource)){
                $return_error = $error_cybersource;
            }else{
                $return_error = 'Error while placing order.';
            }
            $responseData = array('success'=>'0', 'data'=>array(), 'message'=>$error_cybersource);
        }
    }else{
        $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
    }
    $orderResponse = json_encode($responseData);
    
    return $orderResponse;
}

}