<?php
namespace App\Http\Controllers\App;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;
use Mail;
use DateTime;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon;
use App\Models\AppModels\Customer;

class CustomersController extends Controller
{

	//login
	public function processlogin(Request $request){
    $userResponse = Customer::processlogin($request);
		print $userResponse;
	}

	//login
	public function processlogin_deliveryboy(Request $request){
    $userResponse = Customer::processlogin_deliveryboy($request);
		print $userResponse;
	}



	//registration
	public function processregistration(Request $request){
    $userResponse = Customer::processregistration($request);
		print $userResponse;
	}

	//verifyOTP
	public function verifyCustomOTP(Request $request){
    $userResponse = Customer::verifyCustomOTP($request);
		print $userResponse;
	}
	
	
	//verifyOTP
	public function verifyLoginProcessOTP(Request $request){
    $userResponse = Customer::verifyLoginProcessOTP($request);
		print $userResponse;
	}
	 
	
	//resend otp 
		public function resendVerificationOTP(Request $request){
    $userResponse = Customer::resendVerificationOTP($request);
		print $userResponse;
	}
	
	
		
	//resend otp 
		public function resendLoginVerificationOTP(Request $request){
    $userResponse = Customer::resendLoginVerificationOTP($request);
		print $userResponse;
	}

	//notify_me
	public function notify_me(Request $request){
    $categoryResponse = Customer::notify_me($request);
		print $categoryResponse;
	}

	//update profile
	public function updatecustomerinfo(Request $request){
    $userResponse = Customer::updatecustomerinfo($request);
		print $userResponse;

	}

	//processforgotPassword
	public function processforgotpassword(Request $request){
    $userResponse = Customer::processforgotpassword($request);
		print $userResponse;
	}

	//facebookregistration
	public function facebookregistration(Request $request){
	  $userResponse = Customer::facebookregistration($request);
		print $userResponse;


	}


	//googleregistration
	public function googleregistration(Request $request){
    $userResponse = Customer::googleregistration($request);
		print $userResponse;


		}

	//generate random password
	function createRandomPassword() {
		$pass = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
		return $pass;
	}

	//generate random password
	function registerdevices(Request $request) {
    	$userResponse = Customer::registerdevices($request);
		print $userResponse;
	}

	function updatepassword(Request $request) {
		$userResponse = Customer::updatepassword($request);
		print $userResponse;
	}
	
	
	
	  function getWalletDetails(Request $request) {
    
        	$userResponse = Customer::wallet_history($request);
		print $userResponse;
    }
    
    
	  function getCashbackDetails(Request $request) {
    
        	$userResponse = Customer::cashback_history($request);
		print $userResponse;
    }
    
    
    	  function getJobPostingList(Request $request) {
    
        	$userResponse = Customer::getJobPostingList($request);
		print $userResponse;
    }
    
    
    
    // withdras cashback request
public function withdrawCashbackrequest(Request $request){
$userResponse = Customer::withdrawCashbackrequest($request);
print $userResponse;

}
    
    
 
}
