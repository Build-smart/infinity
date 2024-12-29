<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\CategoriesController;
use App\Http\Controllers\App\CustomersController;
use App\Http\Controllers\App\LocationController;
use App\Http\Controllers\App\MyProductController;
use App\Http\Controllers\App\NewsController;
use App\Http\Controllers\App\OrderController;
use App\Http\Controllers\App\BannersController;
use App\Http\Controllers\App\AppSettingController;
use App\Http\Controllers\App\PagesController;
use App\Http\Controllers\App\ReviewsController;

use App\Http\Controllers\App\DistributorOrderController;

use App\Http\Controllers\App\DistributorBannersController;
use App\Http\Controllers\App\DistributorController;

use App\Http\Controllers\App\MobileCartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


	/*
	 |--------------------------------------------------------------------------
	 | App Controller Routes
	 |--------------------------------------------------------------------------
	 |
	 | This section contains all Routes of application
	 |
	 |
	 */
	
	Route::group(['namespace' => 'App'], function () {
	
		//Route::post('/uploadimage', 'AppSettingController@uploadimage');
					 	Route::post('/uploadcompanyphoto', [AppSettingController::class, 'uploadcompanyphoto']);

		
				Route::post('/profileuploadimage', [AppSettingController::class, 'uploadimage']);

					Route::post('/uploadresume', [AppSettingController::class, 'uploadresume']);

		Route::post('/getcategories', [CategoriesController::class, 'getcategories']);
		
		//registration url
		Route::post('/registerdevices', [CustomersController::class, 'registerdevices']);
		
		//processregistration url
		Route::post('/processregistration', [CustomersController::class, 'processregistration']);
		
		
		Route::post('/verifyCustomOTP',[CustomersController::class, 'verifyCustomOTP']);
		Route::post('/resendVerificationOTP', [CustomersController::class, 'resendVerificationOTP']);
		
		
		
		Route::post('/verifyLoginProcessOTP',[CustomersController::class, 'verifyLoginProcessOTP']);
		Route::post('/resendLoginVerificationOTP',[CustomersController::class, 'resendLoginVerificationOTP']);
		
		//update customer info url
		Route::post('/updatecustomerinfo', [CustomersController::class, 'updatecustomerinfo']);
		Route::get('/updatepassword', [CustomersController::class, 'updatepassword']);
		
		// login url
		Route::post('/processlogin', [CustomersController::class, 'processlogin']);
		
		Route::post('/processlogin_deliveryboy', [CustomersController::class, 'processlogin_deliveryboy']);
		
		//social login
		Route::post('/facebookregistration', [CustomersController::class, 'facebookregistration']);
		Route::post('/googleregistration', [CustomersController::class, 'googleregistration']);
		
		//push notification setting
		Route::post('/notify_me', [CustomersController::class, 'notify_me']);
		
		// forgot password url
		Route::post('/processforgotpassword', [CustomersController::class, 'processforgotpassword']);
		
		 Route::post('/withdrawCashbackrequest', [CustomersController::class, 'withdrawCashbackrequest']);

		
		//get the wallet history for mobile app
		
		
				Route::post('/getWalletDetails', [CustomersController::class, 'getWalletDetails']);
				Route::post('/getCashbackDetails', [CustomersController::class, 'getCashbackDetails']);
				
				
					Route::post('/getJobPostingList', [CustomersController::class, 'getJobPostingList']);
				

		/*
		 |--------------------------------------------------------------------------
		 | Location Controller Routes
		 |--------------------------------------------------------------------------
		 |
		 | This section contains countries shipping detail
		 | This section contains links of affiliated to address
		 |
		 */
		
		//get country url
		Route::post('/getcountries',[LocationController::class, 'getcountries']);
		
		//get zone url
		Route::post('/getzones', [LocationController::class, 'getzones']);
		
			//get zone url
		Route::post('/getcities', [LocationController::class, 'getcities']);
		
		
		//get all address url
		Route::post('/getalladdress', [LocationController::class, 'getalladdress']);
		
		//address url
		Route::post('/addshippingaddress', [LocationController::class, 'addshippingaddress']);
		
		//update address url
		Route::post('/updateshippingaddress', [LocationController::class, 'updateshippingaddress']);
		
		//update default address url
		Route::post('/updatedefaultaddress', [LocationController::class, 'updatedefaultaddress']);
		
		//delete address url
		Route::post('/deleteshippingaddress', [LocationController::class, 'deleteshippingaddress']);
		
		
		/*
		 |--------------------------------------------------------------------------
		 | Product Controller Routes
		 |--------------------------------------------------------------------------
		 |
		 | This section contains product data
		 | Such as:
		 | top seller, Deals, Liked, categroy wise or category individually and detail of every product.
		 */
		
		
		//get categories
		Route::post('/allcategories', [MyProductController::class, 'allcategories']);
		
		//get all associated partners 
		Route::post('/allAssociatedPartners', [MyProductController::class, 'allAssociatedPartners']);

		
		
		//getAllProducts
		Route::post('/getallproducts', [MyProductController::class, 'getallproducts']);
		
			//getAllProducts
		Route::post('/getsingleproductdetails', [MyProductController::class, 'getsingleproductdetails']);
		
		
		//like products
		Route::post('/likeproduct', [MyProductController::class, 'likeproduct']);
		
		//unlike products
		Route::post('/unlikeproduct',[MyProductController::class, 'unlikeproduct']);
		
		//get filters
		Route::post('/getfilters', [MyProductController::class, 'getfilters']);
		
		

		
		//get getFilterproducts
		Route::post('/getfilterproducts',[MyProductController::class, 'getfilterproducts']);
		
		Route::post('/getsearchdata', [MyProductController::class, 'getsearchdata']);
		
		//getquantity
		Route::post('/getquantity',[MyProductController::class, 'getquantity']);
		
		/*
		 |--------------------------------------------------------------------------
		 | News Controller Routes
		 |--------------------------------------------------------------------------
		 |
		 | This section contains news data
		 | Such as:
		 | top news or category individually and detail of every news.
		
		 */
		
		
		//get categories
		Route::post('/allnewscategories',[NewsController::class, 'allnewscategories']);
		
		//getAllProducts
		Route::post('/getallnews', [NewsController::class, 'getallnews']);
		/*
		
		
		DISTRIBUTOR 
		
		
		*/
		//notifications
		
		//update company store photo.....
						 //	Route::post('/uploadcompanyphoto',[DistributorController::class, 'uploadcompanyphoto']);


//update withdrawrequest purchase order amount request by distributor.....

								Route::post('/updatepurchaseorderamountwithdrawrequest',[DistributorOrderController::class, 'updatepurchaseorderamountwithdrawrequest']);

						Route::post('/getdistributorpurchaseordernotifications',[DistributorOrderController::class, 'getDistributorPurchaseOrderNotifications']);

						Route::post('/updatedistributornotification',[DistributorOrderController::class, 'updatedistributornotification']);


		
		//update main/master purchase order status 
		
				Route::post('/updatepurchaseordermainstatus',[DistributorOrderController::class, 'updatepurchaseordermainstatus']);


// from the wallet this amount status along with rounded up amount is updateed with comments
				Route::post('/updatepurchaseorderamountpaymentrequest',[DistributorOrderController::class, 'updatepurchaseorderamountpaymentrequest']);



	//update rounded amount for purchase order amount this method is used for both roundedup amount and cashdiscount
		
				Route::post('/updaterounduppurchaseorderamount',[DistributorOrderController::class, 'updaterounduppurchaseorderamount']);




		
				//update individual items in a purchase order 
			Route::post('/updatepurchaseorderitemstatus',[DistributorOrderController::class, 'updatepurchaseorderitemstatus']);
	
		
						Route::post('/getdistributorfilters', [DistributorOrderController::class, 'getdistributorfilters']);
						
						
												Route::post('/getdistributorfilteredorders', [DistributorOrderController::class, 'getdistributorfilteredorders']);


// individual status for purchase order items....
												Route::post('/allpurchasestatuscodes', [DistributorOrderController::class, 'allpurchasestatuscodes']);


//this call is for displaying the main purchase orderstatus in tab format... in app

	Route::post('/allpurchasemainstatuscodes', [DistributorOrderController::class, 'allpurchasemainstatuscodes']);


// to call is for allowing distributor to change the main status  
												Route::post('/getpurchasestatuscode_for_distributors', [DistributorOrderController::class, 'getpurchasestatuscode_for_distributors']);

// all  distributors by purchase order status id 
		Route::post('/getdistributororders',[DistributorOrderController::class, 'getdistributororders']);
		
		
		
		
// all  distributors by purchase order pending amount 
//STEP 1
		Route::post('/getdistributorpendingamountorders',[DistributorOrderController::class, 'getdistributorpendingamountorders']);
		
		//STEP 2
		
				Route::post('/getdistributorwalletamountorders',[DistributorOrderController::class, 'getdistributorwalletamountorders']);
		
		//STEP 3
			Route::post('/getdistributorpaidwalletamountorders',[DistributorOrderController::class, 'getdistributorpaidwalletamountorders']);

		
		
		
		
		// all  distributors by purchase order status id 
		Route::post('/getsinglepurchaseorder',[DistributorOrderController::class, 'getsinglepurchaseorder']);
		
		
		
		
		// all the distributors  purchase orders not by status id 
				Route::post('/getalldistributororders',[DistributorOrderController::class, 'getalldistributororders']);
				
				
					//get banners
		Route::get('/getdistributorbanners', [DistributorBannersController::class, 'getdistributorbanners']);



	//get the wallet history for mobile app
		
		
				Route::post('/getDistributorWalletDetails', [DistributorOrderController::class, 'getDistributorWalletDetails']);




// DISTRIBUTOR LOGIN AND REGISTRATION AND OTP 

//distributor api start

//registration url
Route::post('/distributorregisterdevices', [DistributorController::class, 'distributorregisterdevices']);

//processregistration url
Route::post('/distributorprocessregistration', [DistributorController::class, 'distributorprocessregistration']);

//get updated information.....


Route::post('/getUpdatedDistributorInfo', [DistributorController::class, 'getUpdatedDistributorInfo']);
				
Route::post('/distributorverifyCustomOTP',[DistributorController::class, 'distributorverifyCustomOTP']);
Route::post('/distributorresendVerificationOTP', [DistributorController::class, 'distributorresendVerificationOTP']);



Route::post('/distributorverifyLoginProcessOTP',[DistributorController::class, 'distributorverifyLoginProcessOTP']);
Route::post('/distributorresendLoginVerificationOTP',[DistributorController::class, 'distributorresendLoginVerificationOTP']);

//update customer info url
Route::post('/distributorupdatecustomerinfo', [DistributorController::class, 'distributorupdatecustomerinfo']);

Route::post('/distributorbankinfo', [DistributorController::class, 'distributorbankinfo']);


Route::get('/distributorupdatepassword', [DistributorController::class, 'distributorupdatepassword']);

// login url
Route::post('/distributorprocesslogin', [DistributorController::class, 'distributorprocesslogin']);

Route::post('/distributorprocesslogin_deliveryboy', [DistributorController::class, 'distributorprocesslogin_deliveryboy']);

//social login
Route::post('/distributorfacebookregistration', [DistributorController::class, 'distributorfacebookregistration']);
Route::post('/distributorgoogleregistration', [DistributorController::class, 'distributorgoogleregistration']);

//push notification setting
Route::post('/distributornotify_me', [DistributorController::class, 'distributornotify_me']);

// forgot password url
Route::post('/distributorprocessforgotpassword', [DistributorController::class, 'distributorprocessforgotpassword']);

 
//get the wallet history for mobile app

 
// DISTRIBUTOR LOGIN AND REGISTRATION AND OTP 
			/*
		
		
		DISTRIBUTOR 
		
		
		*/
		
		/*
		 |--------------------------------------------------------------------------
		 | Cart Controller Routes
		 |--------------------------------------------------------------------------
		 |
		 | This section contains customer orders
		 |
		 */
Route::post('/addToCart', [MobileCartController::class, 'addToCart']);
Route::post('/viewmobilecart', [MobileCartController::class, 'viewmobilecart']);
Route::post('/updatemobilecart', [MobileCartController::class, 'updatemobilecart']);
Route::post('/mobiledeleteCart', [MobileCartController::class, 'mobiledeleteCart']);
 Route::post('/checkoutorder', [OrderController::class, 'checkoutorder']); 

		//hyperpaytoken
		Route::post('/hyperpaytoken', [OrderController::class, 'hyperpaytoken']);
		
		//hyperpaytoken
		Route::get('/hyperpaypaymentstatus', [OrderController::class, 'hyperpaypaymentstatus']);
		
		//paymentsuccess
		Route::get('/paymentsuccess', [OrderController::class, 'paymentsuccess']);
		
		//paymenterror
		Route::post('/paymenterror', [OrderController::class, 'paymenterror']);
		
		//generateBraintreeToken
		Route::get('/generatebraintreetoken', [OrderController::class, 'generatebraintreetoken']);
		
		//generateBraintreeToken
		Route::get('/instamojotoken', [OrderController::class, 'instamojotoken']);
		
		//add To order
	//	Route::post('/addtoorder', [OrderController::class, 'addtoorder']);
		

		
		//updatestatus
		Route::post('/updatestatus/', [OrderController::class, 'updatestatus']);
		
		Route::post('/updatestatusbydeliveryboy/', [OrderController::class, 'updatestatusbydeliveryboy']);
		
		
		//get all orders
		Route::post('/getorders',[OrderController::class, 'getorders']);
		
	
		
		//get all orders
		Route::post('/getordersfordeliveryboy',[OrderController::class, 'getordersfordeliveryboy']);
		//get all order status
		Route::post('/getorderstatusfor_deliveryboy', [OrderController::class, 'getorderstatusfor_deliveryboy']);
		
		
		Route::post('/getorderstatus',[OrderController::class, 'getorderstatus']);
		
		
		//get default payment method
		Route::post('/getpaymentmethods',[OrderController::class, 'getpaymentmethods']);
		
		//get shipping / tax Rate
		Route::post('/getrate', [OrderController::class, 'getrate']);
		
		//get Coupon
		Route::post('/getcoupon', [OrderController::class, 'getcoupon']);
		
		//paytm hash key
		Route::get('/generatpaytmhashes',[OrderController::class, 'generatpaytmhashes']);
		
		/*
		 |--------------------------------------------------------------------------
		 | Banner Controller Routes
		 |--------------------------------------------------------------------------
		 |
		 | This section contains banners, banner history
		 |
		
		 */
		
		//get banners
		Route::get('/getbanners', [BannersController::class, 'getbanners']);
		
		//banners history
		Route::post('/bannerhistory',[BannersController::class, 'bannerhistory']);
		
		/*
		 |--------------------------------------------------------------------------
		 | App setting Controller Routes
		 |--------------------------------------------------------------------------
		 |
		 | This section contains app  languages
		 |
		
		 */
		Route::get('/sitesetting', [AppSettingController::class, 'sitesetting']);
		
		
		//old app label
		Route::post('/applabels', [AppSettingController::class, 'applabels']);
		
		//new app label
		Route::get('/applabels3', [AppSettingController::class, 'applabels3']);
		Route::post('/contactus', [AppSettingController::class, 'contactus']);
		Route::get('/getlanguages', [AppSettingController::class, 'getlanguages']);
		
		//this will get the location for the products to display not the country -> location ....
				Route::get('/getLocations', [AppSettingController::class, 'getLocations']);
				
				
				

		/*
		 |--------------------------------------------------------------------------
		 | Page Controller Routes
		 |--------------------------------------------------------------------------
		 |
		 | This section contains news data
		 | Such as:
		 | top Page individually and detail of every Page.
		
		 */
		
		//getAllPages
		Route::post('/getallpages',[PagesController::class, 'getallpages']);
		
		/*
		 |--------------------------------------------------------------------------
		 | reviews Controller Routes
		 |--------------------------------------------------------------------------
		 */
		
		Route::post('/givereview', [ReviewsController::class, 'givereview']);
		Route::post('/updatereview',[ReviewsController::class, 'updatereview']);
		Route::get('/getreviews',[ReviewsController::class, 'getreviews']);
		
		/*
		 |--------------------------------------------------------------------------
		 | current location Controller Routes
		 |--------------------------------------------------------------------------
		 */
		
		Route::get('/getlocation', [AppSettingController::class, 'getlocation']);
		
		/*
		 |--------------------------------------------------------------------------
		 | currency location Controller Routes
		 |--------------------------------------------------------------------------
		 */
		
		Route::get('/getcurrencies', [AppSettingController::class, 'getcurrencies']);
		
		
		
		
	});
	