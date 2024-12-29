<?php
namespace App\Http\Controllers\App;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\AppModels\Distributor;
use Image;

use Illuminate\Support\Str;



  
class DistributorController extends Controller
{

	//login
	public function distributorprocesslogin(Request $request){
    $userResponse = Distributor::distributorprocesslogin($request);
		print $userResponse;
	}



	//login
	public function getUpdatedDistributorInfo(Request $request){
    $userResponse = Distributor::getUpdatedDistributorInfo($request);
		print $userResponse;
	}


	//login
	public function distributorprocesslogin_deliveryboy(Request $request){
    $userResponse = Distributor::distributorprocesslogin_deliveryboy($request);
		print $userResponse;
	}



	//registration
	public function distributorprocessregistration(Request $request){
    $userResponse = Distributor::distributorprocessregistration($request);
		print $userResponse;
	}

	//verifyOTP
	public function distributorverifyCustomOTP(Request $request){
    $userResponse = Distributor::distributorverifyCustomOTP($request);
		print $userResponse;
	}
	
	
	//verifyOTP
	public function distributorverifyLoginProcessOTP(Request $request){
    $userResponse = Distributor::distributorverifyLoginProcessOTP($request);
		print $userResponse;
	}
	 
	
	//resend otp 
		public function distributorresendVerificationOTP(Request $request){
    $userResponse = Distributor::distributorresendVerificationOTP($request);
		print $userResponse;
	}
	
	
		
	//resend otp 
		public function distributorresendLoginVerificationOTP(Request $request){
    $userResponse = Distributor::distributorresendLoginVerificationOTP($request);
		print $userResponse;
	}

	//notify_me
	public function distributornotify_me(Request $request){
    $categoryResponse = Distributor::distributornotify_me($request);
		print $categoryResponse;
	}

	//update profile
	public function distributorupdatecustomerinfo(Request $request){
    $userResponse = Distributor::distributorupdatecustomerinfo($request);
		print $userResponse;

	}
	
	
	
	//update bank details of the distributor
	public function distributorbankinfo(Request $request){
    $userResponse = Distributor::distributorbankinfo($request);
		print $userResponse;

	}


	//processforgotPassword
	public function distributorprocessforgotpassword(Request $request){
    $userResponse = Distributor::distributorprocessforgotpassword($request);
		print $userResponse;
	}

	//facebookregistration
	public function distributorfacebookregistration(Request $request){
	  $userResponse = Distributor::distributorfacebookregistration($request);
		print $userResponse;


	}


	//googleregistration
	public function distributorgoogleregistration(Request $request){
    $userResponse = Distributor::distributorgoogleregistration($request);
		print $userResponse;


		}

	//generate random password
	function createRandomPassword() {
		$pass = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
		return $pass;
	}

	//generate random password
	function distributorregisterdevices(Request $request) {
    	$userResponse = Distributor::distributorregisterdevices($request);
		print $userResponse;
	}

	function distributorupdatepassword(Request $request) {
		$userResponse = Distributor::distributorupdatepassword($request);
		print $userResponse;
	}
	
	
	
	  function distributorgetWalletDetails(Request $request) {
    
        	$userResponse = Distributor::distributorwallet_history($request);
		print $userResponse;
    }
    
    
	  function distributorgetCashbackDetails(Request $request) {
    
        	$userResponse = Distributor::distributorcashback_history($request);
		print $userResponse;
    }
    
    
    	  function distributorgetJobPostingList(Request $request) {
    
        	$userResponse = Distributor::distributorgetJobPostingList($request);
		print $userResponse;
    }
    
    
    
    // withdras cashback request
public function distributorwithdrawCashbackrequest(Request $request){
$userResponse = Distributor::distributorwithdrawCashbackrequest($request);
print $userResponse;

}


 public function uploadcompanyphoto(Request $request)
    { 
        
        $userResponse = Distributor::uploadcompanyphoto($request);
print $userResponse;  
    	    
       
}
    
    
    
 
}
