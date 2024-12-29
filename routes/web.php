<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\CustomersController;
use App\Http\Controllers\Web\PaytmController;
use App\Http\Controllers\Web\RazorpayController;
use App\Http\Controllers\Web\WebSettingController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\OrdersController;
use App\Http\Controllers\Web\ShippingAddressController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\MidtransController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
if(file_exists(storage_path('installed'))){
	$check = DB::table('settings')->where('id', 94)->first();
	if($check->value == 'Maintenance'){
		$middleware = ['installer','env'];
	}
	else{
		$middleware = ['installer'];
	}
}
else{
	$middleware = ['installer'];
}

Route::get('/maintance',[IndexController::class, 'maintance']);

Route::group(['namespace' => 'Web','middleware' => ['installer']], function () {
//login customer
Route::get('/login',[CustomersController::class, 'login']);
Route::post('/process-login',[CustomersController::class, 'processLogin']);
Route::get('/logout',[CustomersController::class, 'logout'])->middleware('Customer');
});

	Route::group(['namespace' => 'Web','middleware' => $middleware], function () {
		Route::get('general_error/{msg}', function($msg) {
			return view('errors.general_error',['msg' => $msg]);
		});
// route for to show payment form using get method
Route::get('pay', [RazorpayController::class, 'pay'])->name('pay');
Route::post('/paytm-callback',[PaytmController::class, 'paytmCallback']);
Route::get('/store_paytm',[PaytmController::class, 'store']);
// route for make payment request using post method
Route::post('dopayment',[RazorpayController::class, 'dopayment'])->name('dopayment');




//home page
Route::get('/',[IndexController::class, 'index']);
Route::post('/change_language',[WebSettingController::class, 'changeLanguage']);
Route::post('/change_currency', [WebSettingController::class, 'changeCurrency']);
Route::post('/addToCart',[CartController::class, 'addToCart']);
Route::post('/addToCartFixed',[CartController::class, 'addToCartFixed']);
Route::post('/addToCartResponsive',[CartController::class, 'addToCartResponsive']);


Route::post('/change_location',[WebSettingController::class, 'changeLocation']);


Route::post('/modal_show',[ProductsController::class, 'ModalShow']);
Route::post('/reviews', [ProductsController::class, 'reviews']);
Route::get('/deleteCart', [CartController::class, 'deleteCart']);
Route::get('/viewcart', [CartController::class, 'viewcart']);
Route::get('/editcart/{id}/{slug}', [CartController::class, 'editcart']);
Route::post('/updateCart', [CartController::class, 'updateCart']);
Route::post('/updatesinglecart',[CartController::class, 'updatesinglecart']);
Route::get('/cartButton',[CartController::class, 'cartButton']);

Route::get('/profile', [CustomersController::class, 'profile'])->middleware('Customer');
Route::get('/change-password', [CustomersController::class, 'changePassword'])->middleware('Customer');



//Widthdraw Requests
Route::get('/widthdrawcashback', [CustomersController::class, 'widthdrawcashback'])->middleware('Customer');
Route::post('/WidthdrawCashbackrequest', [CustomersController::class, 'WidthdrawCashbackrequest'])->middleware('Customer');
Route::get('/wallet_history', [CustomersController::class, 'wallet_history'])->middleware('Customer');


Route::get('/wishlist',[CustomersController::class, 'wishlist'])->middleware('Customer');
Route::post('/updateMyProfile', [CustomersController::class, 'updateMyProfile'])->middleware('Customer');
Route::post('/updateMyPassword', [CustomersController::class, 'updateMyPassword'])->middleware('Customer');
Route::get('UnlikeMyProduct/{id}',[CustomersController::class, 'unlikeMyProduct'])->middleware('Customer');
Route::post('likeMyProduct',[CustomersController::class, 'likeMyProduct']);
Route::post('addToCompare', [CustomersController::class, 'addToCompare']);
Route::get('compare',[CustomersController::class, 'Compare'])->middleware('Customer');
Route::get('deletecompare/{id}', [CustomersController::class, 'DeleteCompare'])->middleware('Customer');
Route::get('/orders', [OrdersController::class, 'orders'])->middleware('Customer');
Route::get('/view-order/{id}', [OrdersController::class, 'viewOrder'])->middleware('Customer');
Route::post('/updatestatus/', [OrdersController::class, 'updatestatus'])->middleware('Customer');
Route::get('/shipping-address', [ShippingAddressController::class, 'shippingAddress'])->middleware('Customer');
Route::post('/addMyAddress', [ShippingAddressController::class, 'addMyAddress'])->middleware('Customer');
Route::post('/myDefaultAddress', [ShippingAddressController::class, 'myDefaultAddress'])->middleware('Customer');
Route::post('/update-address', [ShippingAddressController::class, 'updateAddress'])->middleware('Customer');
Route::get('/delete-address/{id}',[ShippingAddressController::class, 'deleteAddress'])->middleware('Customer');
Route::post('/ajaxZones',[ShippingAddressController::class, 'ajaxZones']);
Route::post('/ajaxcities',[ShippingAddressController::class, 'ajaxcities']);

//news section
Route::get('/news', [NewsController::class, 'news']);
Route::get('/news-detail/{slug}', [NewsController::class, 'newsDetail']);
Route::post('/loadMoreNews', [NewsController::class, 'loadMoreNews']);
Route::get('/page', [IndexController::class, 'page']);
Route::get('/shop', [ProductsController::class, 'shop']);
Route::post('/shop', [ProductsController::class, 'shop']);
Route::get('/product-detail/{slug}', [ProductsController::class, 'productDetail']);
Route::post('/filterProducts', [ProductsController::class, 'filterProducts']);
Route::post('/getquantity', [ProductsController::class, 'getquantity']);



Route::get('/searchshop', [ProductsController::class, 'searchshop']);



Route::get('/guest_checkout', [OrdersController::class, 'guest_checkout']);
Route::get('/checkout', [OrdersController::class, 'checkout'])->middleware('Customer');
Route::post('/checkout_shipping_address', [OrdersController::class, 'checkout_shipping_address'])->middleware('Customer');
Route::post('/checkout_billing_address', [OrdersController::class, 'checkout_billing_address'])->middleware('Customer');
Route::post('/checkout_payment_method', [OrdersController::class, 'checkout_payment_method'])->middleware('Customer');
Route::post('/paymentComponent', [OrdersController::class, 'paymentComponent'])->middleware('Customer');
Route::post('/place_order',[OrdersController::class, 'place_order'])->middleware('Customer');
Route::get('/orders', [OrdersController::class, 'orders'])->middleware('Customer');
Route::post('/updatestatus/', [OrdersController::class, 'updatestatus'])->middleware('Customer');
Route::post('/myorders', [OrdersController::class, 'myorders'])->middleware('Customer');
Route::get('/stripeForm', [OrdersController::class, 'stripeForm'])->middleware('Customer');
Route::get('/view-order/{id}',[OrdersController::class, 'viewOrder'])->middleware('Customer');
Route::post('/pay-instamojo', [OrdersController::class, 'payIinstamojo'])->middleware('Customer');
Route::get('/thankyou',[OrdersController::class, 'thankyou'])->middleware('Customer');

//paystack
Route::get('/paystack/transaction', [OrdersController::class, 'paystackTransaction'])->middleware('Customer');
Route::get('/paystack/verify/transaction', [OrdersController::class, 'authorizepaystackTransaction'])->middleware('Customer');

//paystack
Route::get('/midtrans/transaction', [MidtransController::class, 'midtransTransaction'])->middleware('Customer');
// Route::get('/midtrans/verify/transaction', 'OrdersController@authorize<idtransTransaction')->middleware('Customer');

Route::get('/checkout/hyperpay',[OrdersController::class, 'hyperpay'])->middleware('Customer');
Route::get('/checkout/hyperpay/checkpayment', [OrdersController::class, 'checkpayment'])->middleware('Customer');
Route::post('/checkout/payment/changeresponsestatus', [OrdersController::class, 'changeresponsestatus'])->middleware('Customer');
Route::post('/apply_coupon', [CartController::class, 'apply_coupon']);
Route::get('/removeCoupon/{id}', [CartController::class, 'removeCoupon'])->middleware('Customer');

Route::get('/signup', [CustomersController::class, 'signup']);
Route::get('/logoutt', [CustomersController::class, 'logout'])->middleware('Customer');
Route::post('/signupProcess', [CustomersController::class, 'signupProcess']);
Route::get('/forgotPassword',[CustomersController::class, 'forgotPassword']);
Route::get('/recoverPassword',[CustomersController::class, 'recoverPassword']);
Route::post('/processPassword', [CustomersController::class, 'processPassword']);

//Bharath Verify Otp 01-10-2020
Route::post('/verifyotp', [CustomersController::class, 'verifyotp']);
Route::post('/verifyCustomOTP', [CustomersController::class, 'verifyCustomOTP']);

Route::post('/resendLoginVerificationOTP', [CustomersController::class, 'resendLoginVerificationOTP']);

// Create Account Page
Route::get('/create_account', [CustomersController::class, 'create_account']);


Route::get('login/{social}',[CustomersController::class, 'socialLogin']);
Route::get('login/{social}/callback', [CustomersController::class, 'handleSocialLoginCallback']);
Route::post('/commentsOrder', [OrdersController::class, 'commentsOrder']);
Route::post('/subscribeNotification/', [CustomersController::class, 'subscribeNotification']);
Route::get('/contact', [IndexController::class, 'contactus']);

Route::get('/constructions', [IndexController::class, 'constructions']);
Route::get('/cost_calculator', [IndexController::class, 'cost_calculator']);


//for mobile webview
Route::get('/mobile_constructions', [IndexController::class, 'mobile_constructions']);
Route::get('/mobile_cost_calculator', [IndexController::class, 'mobile_cost_calculator']);
Route::get('/mobile_aboutus', [IndexController::class, 'mobile_aboutus']);

Route::get('/mobile_careers', [IndexController::class, 'mobile_careers']);

Route::get('/careers', [IndexController::class, 'careers']);
Route::get('/aboutus', [IndexController::class, 'aboutus']);

Route::get('/job/job_details/{id}', [IndexController::class, 'jobdetails']);
Route::post('/appliedjob', [IndexController::class, 'applied_job']);


Route::post('/processContactUs', [IndexController::class, 'processContactUs']);

Route::get('/setcookie',[IndexController::class, 'setcookie']);
Route::get('/newsletter',[IndexController::class, 'newsletter']);

Route::get('/subscribeMail',[IndexController::class, 'subscribeMail']);
Route::get('/setSession', [IndexController::class, 'setSession']);
});

Route::get('/test',[IndexController::class, 'test1']);

