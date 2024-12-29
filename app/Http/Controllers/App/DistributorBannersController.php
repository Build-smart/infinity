<?php
namespace App\Http\Controllers\App;

use Validator;
use DB;
use DateTime;
use Hash;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AppModels\DistributorBanner;

class DistributorBannersController extends Controller
{

	//getbanners
	public function getdistributorbanners(Request $request){
		$response = DistributorBanner::getdistributorbanners($request);
		return($response) ;
	}

}
