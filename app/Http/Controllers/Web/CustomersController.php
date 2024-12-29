<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\AlertController;
use App\Models\Web\Cart;
use App\Models\Web\Currency;
use App\Models\Web\Customer;
use App\Models\Web\BusinessOwner;
use App\Models\Web\Index;
use App\Models\Web\Languages;
use App\Models\Web\Products;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Lang;
use Session;
use Socialite;
use Validator;
use Hash;
use Illuminate\Support\Facades\Crypt;

class CustomersController extends Controller
{

    public function __construct(
        Index $index,
        Languages $languages,
        Products $products,
        Currency $currency,
        Customer $customer,
        Cart $cart
    ) {
        $this->index = $index;
        $this->languages = $languages;
        $this->products = $products;
        $this->currencies = $currency;
        $this->customer = $customer;
        $this->cart = $cart;
        $this->theme = new ThemeController();
    }

    public function signup(Request $request)
    {
        $final_theme = $this->theme->theme();
        if (auth()->guard('customer')->check()) {
            return redirect('/');
        } else {
            $title = array('pageTitle' => Lang::get("website.Sign Up"));
            $result = array();
            $result['commonContent'] = $this->index->commonContent();
            return view("login", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
        }
    }

    public function login(Request $request)
    {
        $result = array();
        if (auth()->guard('customer')->check()) {
            return redirect('/');
        } else {
            $result['cart'] = $this->cart->myCart($result);

            if (count($result['cart']) != 0) {
                $result['checkout_button'] = 1;
            } else {
                $result['checkout_button'] = 0;

            }
            $previous_url = Session::get('_previous.url');

            $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            $ref = rtrim($ref, '/');

            session(['previous' => $previous_url]);

            $title = array('pageTitle' => Lang::get("website.Login"));
            $final_theme = $this->theme->theme();

            $result['commonContent'] = $this->index->commonContent();
            return view("auth.login", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
        }

    }
    
    
    
      
    public function create_account(Request $request)
    {
    	$final_theme = $this->theme->theme();
    	if (auth()->guard('customer')->check()) {
    		return redirect('/');
    	} else {
    		$title = array('pageTitle' => "Create Account");
    		$result = array();
    		$result['commonContent'] = $this->index->commonContent();
    		return view("auth.registration", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
    	}
    }
    
    
    public function resendLoginVerificationOTP(Request $request)
    {
    	 
    	//if phone is  not verified
    
     
    	$email = $request->email;
    	$phone = $request->phone;
    	$final_theme = $this->theme->theme();
    	$result = array();
    	$result['commonContent'] = $this->index->commonContent();
    
    	$email = Crypt::decryptString($email);
    	$phone = Crypt::decryptString($phone);
    	
    
     $existUser = DB::table('users')->where('email', $email)->Where('phone', $phone)->first();
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
    	 		
      
    
				 
//\Session::flash('flash_message', 'OTP is send to your mobile....');
                //echo json_encode($userData);
                echo  'OTP is send to your mobile....';
         
       //  return view("web.verifyotp", ['phone' => $phone,'email'=>$email, 'final_theme' => $final_theme])->with('result', $result);
        				
				
            }
             	else if($existUser->is_phone_verified==1){ {
 
             		//\Session::flash('flash_message', 'Mobile Number is Already Verified');
             		echo  'Mobile Number is Already Verified';
         //   	return view("web.verifyotp", ['phone' => $phone,'email'=>$email, 'final_theme' => $final_theme])->with('result', $result);
             		
            //    $responseData = array('success' => '0', 'data' =>array(), 'message' => "Mobile number is already verified...");
            }
        }

        }
       // return view("web.verifyotp", ['phone' => $phone,'email'=>$email, 'final_theme' => $final_theme])->with('result', $result);
        
      // return view("web.verifyotp", ['phone' => $phone,'email'=>$email, 'final_theme' => $final_theme])->with('result', $result);
        
    	//if phone is  verified
     
    	//}
    }

    public function processLogin(Request $request)
    {
        $old_session = Session::getId();

        $result = array();

        //check authentication of email and password
       // $customerInfo = array("email" => $request->email, "password" => $request->password);
      
        //if phone is  not verified
        $email = $request->email;
        $phone = $request->phone;
        $final_theme = $this->theme->theme();
        $result = array();
        $result['commonContent'] = $this->index->commonContent();
        
      //below to check the activation of user of business owner ... generally the admin activates the business ower
      
        $user=null;
        
        if(is_numeric($request->get('email'))){
            $user= DB::table('users')
            ->where('phone',$email)
            ->where("status",1)
            ->whereIn("role_id",[2,18])
            ->first();
            
            if(!$user)  {
                return redirect('login')->with('loginError', "Your Phone number is not Registered.");
            }
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $user= DB::table('users')
            ->where('email',$email)
            ->where("status",1)
            ->whereIn("role_id",[2,18])
            ->first();
            
            if(!$user)  {
                return redirect('login')->with('loginError', "Your Email is not Registered.");
            }
            
        }

         
     if($user!=null){
        if($user->status == 0 && $user->customer_type == "BUSINESSOWNER")  {
        return redirect('login')->with('loginError', "Your Account is not Activated, Please call customer care to activate");
       
        }
     }
            //below to check the activation of user of business owner ... generally the admin activates the business ower
        	
     if($user!=null && $user->phone_verified==0){
        
         $phone= $user->phone;
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
        	\Session::flash('flash_message', 'Mobile Verification Pending');
        	 
//         	$phone=Hash::make($phone);
//         	$email=Hash::make($email);

         	$phone=Crypt::encryptString($phone);
        	$email=Crypt::encryptString($email);
        	 
        	return view("web.verifyotp", ['phone' => $phone,'email'=>$email, 'final_theme' => $final_theme])->with('result', $result);
        	// $responseData = array('success' => '2', 'data' => $existUser, 'message' => "Mobile verification pending...");
        }
         
     /*   
        $user= DB::table('users')
        ->where('email',$email)
        ->first();
       
        
        if($user->status == 0)  {
          return redirect('login')->with('loginError', "Your Email is not Activated, Please call customer care to activate");
         
        } 
 */
        $customerInfo =$this->credentials($request);
       
        //if phone is  verified
        if ($customerInfo && auth()->guard('customer')->attempt($customerInfo) ) {
            $customer = auth()->guard('customer')->user();
            
            if ($customer->role_id != 2) {
                $record = DB::table('settings')->where('id', 94)->first();
                if ($record->value == 'Maintenance' && $customer->role_id == 1) {
                    auth()->attempt($customerInfo);
                } else {
                    Auth::guard('customer')->logout();
                    return redirect('login')->with('loginError', Lang::get("website.You Are Not Allowed With These Credentials!"));
                }
            }
            $result = $this->customer->processLogin($request, $old_session);
            if (!empty(session('previous'))) {
                return Redirect::to(session('previous'));
            } else {
                
                Session::forget('guest_checkout');
                return redirect('/')->with('result', $result);
            }
            } else {
            return redirect('login')->with('loginError', Lang::get("website.Email or password is incorrect"));
        }
       
        //}
    }
    
    
    
  public   function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
            
           // return  $request->validate(['phone'=>$request->get('email'),'password'=>$request->get('password')]);
            
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password')];
          
           // return  $request->validate(['email'=>$request->get('email'),'password'=>$request->get('password')]);
            
        }else{
            
            return array();
            
        }
    
    }

    public function addToCompare(Request $request)
    {
        $cartResponse = $this->customer->addToCompare($request);
        return $cartResponse;
    }

    public function DeleteCompare($id)
    {
        $Response = $this->customer->DeleteCompare($id);
        return redirect()->back()->with($Response);
    }

    public function Compare()
    {
        $result = array();
        $final_theme = $this->theme->theme();
        $result['commonContent'] = $this->index->commonContent();
        $compare = $this->customer->Compare();
        $results = array();
        foreach ($compare as $com) {
            $data = array('products_id' => $com->product_ids, 'page_number' => '0', 'type' => 'compare', 'limit' => '15', 'min_price' => '', 'max_price' => '');
            $newest_products = $this->products->products($data);
            array_push($results, $newest_products);
        }
        $result['products'] = $results;
        return view('web.compare', ['result' => $result, 'final_theme' => $final_theme]);
    }

    public function profile()
    {
        $title = array('pageTitle' => Lang::get("website.Profile"));
        $result['commonContent'] = $this->index->commonContent();
        $final_theme = $this->theme->theme();
        
        $login_id =auth()->guard('customer')->user()->id;
        $cashback_amount = DB::table('orders')
        ->where('orders.customers_id', '=', $login_id)
        ->sum('orders.cashback_amount');
        
        
         
        $cashback_paidamount = DB::table('cashback_transactions')
        ->where('cashback_transactions.user_id', '=', $login_id)
        ->sum('cashback_transactions.request_amount');
        
        
        $totalcashback_amount= $cashback_amount - $cashback_paidamount;
        $result['totalcashback_amount'] = $totalcashback_amount;
        
        $wallet_amount = DB::table('wallet')
        ->where('wallet.customer_id', '=', $login_id)
        ->sum('wallet.wallet_amount');
        
//         $orders_amount = DB::table('orders')
//         ->where('orders.customers_id', '=', $login_id)
//        ->where('orders.payment_method', '=', "Buildermart Wallet")
//         ->sum('orders.order_price');
        
        $orders_amount = DB::table('orders')
        ->leftjoin('orders_status_history','orders_status_history.orders_id','=','orders.orders_id')
        ->where('orders.customers_id', '=', $login_id)
        ->where('orders.payment_method', '=', "Buildermart Wallet")
        ->where('orders_status_history.orders_status_id','!=',3)
        ->where('orders_status_history.current_status',1)
        ->sum('orders.order_price');
        
        
        $remainingwallet_amount = $wallet_amount- $orders_amount;
        
        $result['remainingwallet_amount'] = $remainingwallet_amount;
        
        return view('web.profile', ['result' => $result, 'title' => $title, 'final_theme' => $final_theme]);
    }

    public function updateMyProfile(Request $request)
    {
        $message = $this->customer->updateMyProfile($request);
        return redirect()->back()->with('success', $message);

    }

    public function changePassword()
    {
        $title = array('pageTitle' => Lang::get("website.Change Password"));
        $result['commonContent'] = $this->index->commonContent();
        $final_theme = $this->theme->theme();
        return view('web.changepassword', ['result' => $result, 'title' => $title, 'final_theme' => $final_theme]);
    }

    public function updateMyPassword(Request $request)
    {
        $password = Auth::guard('customer')->user()->password;
        if (Hash::check($request->current_password, $password)) {
            $message = $this->customer->updateMyPassword($request);
            return redirect()->back()->with('success', $message);
        }else{
            return redirect()->back()->with('error', lang::get("website.Current password is invalid"));
        }
    }

    public function logout(REQUEST $request)
    {  
    	DB::table('compare')->where('customer_id', auth()->guard('customer')->user()->id)->delete();
    	 
        Auth::guard('customer')->logout();
        session()->flush();
        $request->session()->forget('customers_id');
        $request->session()->regenerate();
                
        return redirect('/');
    }

    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function handleSocialLoginCallback($social)
    {
        $result = $this->customer->handleSocialLoginCallback($social);
        if (!empty($result)) {
            return redirect('/')->with('result', $result);
        }
    }

    public function createRandomPassword()
    {
        $pass = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        return $pass;
    }

    public function likeMyProduct(Request $request)
    {
        $cartResponse = $this->customer->likeMyProduct($request);
        return $cartResponse;
    }

    public function unlikeMyProduct(Request $request, $id)
    {

        if (!empty(auth()->guard('customer')->user()->id)) {
            $this->customer->unlikeMyProduct($id);
            $message = Lang::get("website.Product is unliked");
            return redirect()->back()->with('success', $message);
        } else {
            return redirect('login')->with('loginError', 'Please login to like product!');
        }

    }

    public function wishlist(Request $request)
    {
        $title = array('pageTitle' => Lang::get("website.Wishlist"));
        $final_theme = $this->theme->theme();
        $result = $this->customer->wishlist($request);
        
        $login_id =auth()->guard('customer')->user()->id;
        $cashback_amount = DB::table('orders')
        ->where('orders.customers_id', '=', $login_id)
        ->sum('orders.cashback_amount');
        
        
         
        $cashback_paidamount = DB::table('cashback_transactions')
        ->where('cashback_transactions.user_id', '=', $login_id)
        ->sum('cashback_transactions.request_amount');
        
        
        $totalcashback_amount= $cashback_amount - $cashback_paidamount;
        $result['totalcashback_amount'] = $totalcashback_amount;
        
        $wallet_amount = DB::table('wallet')
        ->where('wallet.customer_id', '=', $login_id)
        ->sum('wallet.wallet_amount');
        
//         $orders_amount = DB::table('orders')
//         ->where('orders.customers_id', '=', $login_id)
//        ->where('orders.payment_method', '=', "Buildermart Wallet")
//         ->sum('orders.order_price');
         
        $orders_amount = DB::table('orders')
        ->leftjoin('orders_status_history','orders_status_history.orders_id','=','orders.orders_id')
        ->where('orders.customers_id', '=', $login_id)
        ->where('orders.payment_method', '=', "Buildermart Wallet")
        ->where('orders_status_history.orders_status_id','!=',3)
        ->where('orders_status_history.current_status',1)
        ->sum('orders.order_price');
        
        
        
        $remainingwallet_amount = $wallet_amount- $orders_amount;
        
        $result['remainingwallet_amount'] = $remainingwallet_amount;
        
        
        return view("web.wishlist", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
    }

    public function loadMoreWishlist(Request $request)
    {

        $limit = $request->limit;

        $data = array('page_number' => $request->page_number, 'type' => 'wishlist', 'limit' => $limit, 'categories_id' => '', 'search' => '', 'min_price' => '', 'max_price' => '');
        $products = $this->products->products($data);
        $result['products'] = $products;

        $cart = '';
        $myVar = new CartController();
        $result['cartArray'] = $this->products->cartIdArray($cart);
        $result['limit'] = $limit;
        return view("web.wishlistproducts")->with('result', $result);

    }

    public function forgotPassword()
    {
        if (auth()->guard('customer')->check()) {
            return redirect('/');
        } else {

            $title = array('pageTitle' => Lang::get("website.Forgot Password"));
            $final_theme = $this->theme->theme();
            $result = array();
            $result['commonContent'] = $this->index->commonContent();
            return view("web.forgotpassword", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
        }
    }
    
   

    public function processPassword(Request $request)
    {
        $title = array('pageTitle' => Lang::get("website.Forgot Password"));

        $password = $this->createRandomPassword();

        $email = $request->email;
        $postData = array();

        //check email exist
        $existUser = $this->customer->ExistUser($email);
        if (count($existUser) > 0) {
            $this->customer->UpdateExistUser($email, $password);
            $existUser[0]->password = $password;
//email will not be sent.
         //   $myVar = new AlertController();
         //   $alertSetting = $myVar->forgotPasswordAlert($existUser);
            
                	 //  $getExistUser = DB::table('users')->where('email', $email)->first();
                	 
                	 $getExistUser=null;
                	 	   if(is_numeric($email)){
                	   	$getExistUser = DB::table('users')->where('phone', $email)->first(); 
                	   }
                	   elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                	   	$getExistUser = DB::table('users')->where('email', $email)->first(); 
                	   } 
                	   //send password 
                	   $phone=$getExistUser->phone;
                	   temp_password($password,$phone);


            return redirect('login')->with('success', Lang::get("Password has been sent to your registered mobile number."));
        } else {
            return redirect('forgotPassword')->with('error', Lang::get("Email address does not exist"));
        }

    }
    
    //this is while registration ....
    
    public function verifyCustomOTP(Request $request)
    {
    	$title = array('pageTitle' => "Verify OTP");
    
    	//$password = $this->createRandomPassword();
 		$email = $request->email;
    	$phone = $request->phone;
    	$otp = $request->phone_otp_code;
    	$postData = array();
    	$final_theme = $this->theme->theme();
    	$result = array();
    	$result['commonContent'] = $this->index->commonContent();
    	
    	$email = Crypt::decryptString($email);
    	$phone = Crypt::decryptString($phone);
    	 
    	//check email exist
    	//$existUser = $this->customer->ExistUser($email);
    	
    	//Hash::check('email', $email)
    	   $existUser = DB::table('users')->where('email', $email)->Where('phone', $phone)->first();
// code added by Adinarayana - 28 SEP 2020 FOR mobile verification 
 
  if ($existUser->phone_otp_code==$otp) {
              
				 
				 $data = array(
    				'phone_verified'  =>  1
    		);
    
    		$user_edit= DB::table('users')
    		->where('phone',$phone)
			->where('email',$email)
    		->update($data);
    		
    		
    		return redirect('login')->with('success', "Mobile Number Successfully Verified....Please Login");
    	} else {
    		 
    	//	return redirect('verifyotp',['phone' => $phone])->with('error', "Invalid OTP");
    		\Session::flash('flash_message', 'Invalid Otp...');
    		
    	 	return view("web.verifyotp", ['phone' => $phone,'email'=>$email, 'final_theme' => $final_theme])->with('result', $result);
     		
    	
    	}
    
    }
    
  /*  public function verifyotp()
    {
    	 	$title = array('pageTitle' => "Verify Phone Number");
    		$final_theme = $this->theme->theme();
    		$result = array();
    		$result['commonContent'] = $this->index->commonContent();
    		return view("web.verifyotp", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
    	 
    }*/

    public function recoverPassword()
    {
        $title = array('pageTitle' => Lang::get("website.Forgot Password"));
        $final_theme = $this->theme->theme();
        return view("web.recoverPassword", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
    }

    public function subscribeNotification(Request $request)
    {

        $setting = $this->index->commonContent();

        /* Desktop */
        $type = 3;

        session(['device_id' => $request->device_id]);

        if (auth()->guard('customer')->check()) {

            $device_data = array(
                'device_id' => $request->device_id,
                'device_type' => $type,
                'created_at' => time(),
                'updated_at' => time(),
                'ram' => '',
                'status' => '1',
                'processor' => '',
                'device_os' => '',
                'location' => '',
                'device_model' => '',
                'user_id' => auth()->guard('customers')->user()->id,
                'manufacturer' => '',
            );

        } else {

            $device_data = array(
                'device_id' => $request->device_id,
                'device_type' => $type,
                'created_at' => time(),
                'updated_at' => time(),
                'ram' => '',
                'status' => '1',
                'processor' => '',
                'device_os' => '',
                'location' => '',
                'device_model' => '',
                'manufacturer' => '',
            );

        }
        $this->customer->updateDevice($request, $device_data);
        print 'success';
    }

   public function widthdrawcashback()
    {
    	$title = array('pageTitle' => "Widthdraw Cashback");
    	$result['commonContent'] = $this->index->commonContent();
    	$login_id =auth()->guard('customer')->user()->id;
    	$widthdraws = DB::table('cashback_transactions')
    	->where('cashback_transactions.user_id', '=', $login_id)
    	->get();
    	$result['widthdraws'] = $widthdraws;
    	
    	$cashback_amount = DB::table('orders')
    	->where('orders.customers_id', '=', $login_id)
    	->sum('orders.cashback_amount');
    	 
    	 
    	
    	$cashback_paidamount = DB::table('cashback_transactions')
    	->where('cashback_transactions.user_id', '=', $login_id)
    	->sum('cashback_transactions.request_amount');
    	 
    	 
    	$totalcashback_amount= $cashback_amount - $cashback_paidamount;
    	$result['totalcashback_amount'] = $totalcashback_amount;
    	
    	$final_theme = $this->theme->theme();
    	return view('web.withdraw_cashback', ['result' => $result, 'title' => $title, 'final_theme' => $final_theme]);
    }
    
    
    
    public function wallet_history()
    {
    	$title = array('pageTitle' => "Widthdraw Cashback");
    	$result['commonContent'] = $this->index->commonContent();
    	$login_id =auth()->guard('customer')->user()->id;
    	 
    	$wallets = DB::table('wallet')
    	->LeftJoin('users', 'users.id', '=', 'wallet.customer_id')
    	->select('wallet.*','users.first_name','users.last_name')
    	->where('wallet.customer_id',$login_id)
    	->get();
    	$result['wallets'] = $wallets;
    	
    	 $wallet_amount = DB::table('wallet')
            ->where('wallet.customer_id', '=', $login_id)
            ->sum('wallet.wallet_amount');
            
//             $orders_amount = DB::table('orders')
//             ->where('orders.customers_id', '=', $login_id)
//            ->where('orders.payment_method', '=', "Buildermart Wallet")
//             ->sum('orders.order_price');
            
            
            $orders_amount = DB::table('orders')
            ->leftjoin('orders_status_history','orders_status_history.orders_id','=','orders.orders_id')
            ->where('orders.customers_id', '=', $login_id)
            ->where('orders.payment_method', '=', "Buildermart Wallet")
            ->where('orders_status_history.orders_status_id','!=',3)
            ->where('orders_status_history.current_status',1)
            ->sum('orders.order_price');
            
    
            
            $remainingwallet_amount = $wallet_amount- $orders_amount;
            
            $result['remainingwallet_amount'] = $remainingwallet_amount;
    	
    	 
    	$final_theme = $this->theme->theme();
    	return view('web.wallet_history', ['result' => $result, 'title' => $title, 'final_theme' => $final_theme]);
    }
    

   
    
    public function WidthdrawCashbackrequest(Request $request)
    {
    	 
    	
    	
    	$login_id =auth()->guard('customer')->user()->id;
    	$cashback_amount = DB::table('orders')
    	->where('orders.customers_id', '=', $login_id)
    	->sum('orders.cashback_amount');
    	
    	
    
    	$cashback_paidamount = DB::table('cashback_transactions')
    	->where('cashback_transactions.user_id', '=', $login_id)
    	 ->sum('cashback_transactions.request_amount');
    	
    	
    	$totalcashback_amount= $cashback_amount - $cashback_paidamount;
    	
    	
    	
    $requestamount=	$request->request_amount;
    	
    	if($requestamount <= $totalcashback_amount) {
    	
    	$message = DB::table("cashback_transactions")->insert([
                
                'user_id' => $login_id,
                'request_amount' =>$requestamount,
                'request_date' =>date('Y-m-d H:i:s'),
                 'status' => 'PENDING'
            		
            		
            		
            ]);
    	return redirect()->back()->with('success', "Cashback Widthdraw Request is Pending, You Will Receive The Cashback within 24 Hours");
    	
    	}else{
    		
    		return redirect()->back()->with('error', "Your Widthdrawl Amount is Greater Than Cashback Amount");
    	}
    
    }


    public function signupProcess(Request $request)
    {
        $old_session = Session::getId();

        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $gender = $request->gender;
        $email = $request->email;
        $phone = $request->phone;
        
         $customer_type = $request->customer_type;
         $workforce_name = $request->workforce_name;
         
        $password = $request->password;
        $date = date('y-md h:i:s');
        $final_theme = $this->theme->theme();
        $result = array();
        $result['commonContent'] = $this->index->commonContent();
        
        
      //  return redirect('verifyotp',['phone'=>$phone])->with('success', "OTP send to your mobile number");
        
        
        //        //validation start
        $validator = Validator::make(
            array(
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
               // 'customers_gender' => $request->gender,
                'email' => $request->email,
            		'phone' => $request->phone,
                'password' => $request->password,
                're_password' => $request->re_password,
               // 'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
            //		'g-recaptcha-response.required' => 'Please complete the captcha'
            		

            ), array(
                'firstName' => 'required ',
                'lastName' => 'required',
               // 'customers_gender' => 'required',
                'email' => 'required | email',
            	 'phone' => 'required ',
                'password' => 'required',
                're_password' => 'required | same:password',
              //  'g-recaptcha-response' => 'required|recaptcha'

            )
        );
        if ($validator->fails()) {
            return redirect('create_account')->withErrors($validator)->withInput();
        } else {

            $res = $this->customer->signupProcess($request);
            //eheck email already exit
            if ($res['email']!=null && $res['email'] == "true") {
                return redirect('/create_account')->withInput($request->input())->with('error', Lang::get("website.Email already exists"));
            }
            else if ($res['phone']!=null && $res['phone'] == "true") {
            	
            	return redirect('/create_account')->withInput($request->input())->with('error',"Phone already exists");
            	 
            }
            else {
            
                if ($res['insert'] == "true") {
                    if ($res['auth'] == "true") {
                       // $result = $res['result'];
                        
                     //   $result = array();
                        //Session::forget('guest_checkout');
                     //   return redirect('/')->with('result', $result);
                       // return redirect()->action( 'CustomersController@verifyotp', ['phone' => $phone] )->with('success', "OTP send to your mobile number");
                 //  return redirect('verifyotp', ['phone' => $phone]);
                   //     return redirect('/verifyotp')->with('phone',  $phone);
                        
                //    return redirect('verifyotp')->route('phone', [$phone])->with('success', "OTP send to your mobile number");
    		//return view("web.verifyotp", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
			
			
			$phone=Crypt::encryptString($phone);
        	$email=Crypt::encryptString($email);
        	 
                        return view("web.verifyotp", ['phone' => $phone,'email'=>$email, 'final_theme' => $final_theme])->with('result', 	$result );
                        
                        
                    } else {
                        return redirect('create_account')->with('loginError', Lang::get("website.Email or password is incorrect"));
                    }
                } else {
                    return redirect('/create_account')->with('error', Lang::get("website.something is wrong"));
                }
            }

        }
    }

}
