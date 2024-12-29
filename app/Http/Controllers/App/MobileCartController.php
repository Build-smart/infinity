<?php
namespace App\Http\Controllers\App;

//use Mail;
//validator is builtin class in laravel
 
use App\Models\Web\Index;
//for password encryption or hash protected
 

//for authenitcate login data
use Carbon;
use App\Models\AppModels\MobileCart;
use App\Models\AppModels\Customer;

//for requesting a value
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

//for Carbon a value
use Lang;
use Session;

class MobileCartController extends Controller
{

    public function __construct(
        Index $index,
        
        MobileCart $mobilecart
    ) {
        $this->index = $index;
       
        $this->mobilecart = $mobilecart;
    
    }
    
    
    public function viewmobilecart(Request $request)
    {
    
    	$title = array('pageTitle' => Lang::get("website.View Cart"));
    	$result = array();
    	$data = array();
    	//$result['commonContent'] = $this->index->commonContent();
    ///	$final_theme = $this->theme->theme();
    
    	$categoryResponse = $this->mobilecart->viewmobilecart($request);
    	//apply coupon
//     	if (session('coupon')) {
//     		$session_coupon_data = session('coupon');
//     		session(['coupon' => array()]);
//     		$response = array();
//     		if (!empty($session_coupon_data)) {
//     			foreach ($session_coupon_data as $key => $session_coupon) {
//     				$response = $this->cart->common_apply_coupon($session_coupon->code);
//     			}
//     		}
//     	}
    //	return view("web.carts.viewcart", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
    	print $categoryResponse;
    
    }
 
 

    //addToCart
    public function addToCart(Request $request)
    {
        $categoryResponse = $this->mobilecart->addToCart($request); 
        if (!empty($categoryResponse['status']) && $categoryResponse['status'] == 'exceed') {
            print $categoryResponse;
        } 
		print $categoryResponse;
    }

    //updateCart
    public function updatemobilecart(Request $request)
    {
    
    //	if (empty(session('customers_id'))) {
    //		$customers_id = '';
    //	} else {
      		$customers_id = $request->customers_id;
      		$customers_basket_id = $request->customers_basket_id;
      	       		$device_id = $request->device_id;

      		$products_id = $request->products_id;
      		$quantity = $request->quantity;
    //	} 
    	//$session_id = Session::getId();
    //	foreach ($request->cart as $key => $customers_basket_id) {
    	$categoryResponse=	$this->mobilecart->updatemobilecart($customers_basket_id, $customers_id, $device_id, $quantity,$products_id);
    //	}
    
    print	$categoryResponse;
    
    
    
    }
    
    public function mobiledeleteCart(Request $request)
    {
    
    	$categoryResponse = $this->mobilecart->mobiledeleteCart($request);
    	//apply coupon
//     	if (!empty(session('coupon')) and count(session('coupon')) > 0) {
//     		$session_coupon_data = session('coupon');
//     		session(['coupon' => array()]);
//     		if (count($session_coupon_data) == '2') {
//     			$response = array();
//     			if (!empty($session_coupon_data)) {
//     				foreach ($session_coupon_data as $key => $session_coupon) {
//     					$response = $this->cart->common_apply_coupon($session_coupon->code);
//     				}
//     			}
//     		}
//     	}

     
    	print $categoryResponse;
    	
    
//     	if (!empty($request->type) and $request->type == 'header cart') {
//     		$result['commonContent'] = $this->index->commonContent();
//     		if (empty($check)) {
//     			$message = Lang::get("website.Cart item has been deleted successfully");
//     			return redirect('/')->with('message', $message);
    
//     		} else {
//     			$message = Lang::get("website.Cart item has been deleted successfully");
//     			$final_theme = $this->index->finalTheme();
//     			return view("web.headers.cartButtons.cartButton".$final_theme->header)->with('result', $result);
//     		}
//     	} else {
//     		if (empty($check)) {
//     			$message = Lang::get("website.Cart item has been deleted successfully");
//     			return redirect('/')->with('message', $message);
    
//     		} else {
//     			$message = Lang::get("website.Cart item has been deleted successfully");
//     			return redirect()->back()->with('message', $message);
//     		}
//     	}
    }
    

}
