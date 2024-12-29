<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\Core\PurchaseOrder;
use App\Http\Controllers\Web\AlertController;

use Carbon\Carbon;

class PurchaseOrdersController extends Controller
{
    //
    public function __construct( Setting $setting, PurchaseOrder $purchaseorder )
    {
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Setting = $setting;
        $this->PurchaseOrder = $purchaseorder;
    }
 
    //bharath 
    public function generate_purchase_order(Request $request)
    { 
    	$result['commonContent'] = $this->Setting->commonContent();
    	
    	   
    	$distributors = DB::table('orders_products')->where('orders_id',$request->id)->distinct()->get(['distributor_id']);
    	
    	
    	
    		
    	foreach($distributors as $distributor_data){
    	
    		$distributors_total_price = DB::table('orders_products')->where('orders_id',$request->id)->where('distributor_id',$distributor_data->distributor_id)->sum('distributor_final_price');
    		
    	if($distributor_data->distributor_id  == 0 || $distributors_total_price == 0){
    		return redirect()->back()->with('error', "Purchase order cannot be raised, because the order has no distributor and distributor price, please update all the products with distributor and distributor price, this should be done before the customer raises order.");
    		 
    	}
    	
    	/*if($distributors_total_price == 0){
    		return redirect()->back()->with('error', "Purchase order cannot be raised, because the order has no distributor and distributor price, please update all the products with distributor and distributor price, this should be done before the customer raises order.");
    		 
    	}*/
    	
    	
    	}
    	
    	
    	foreach($distributors as $distributor_data){
    		  
    		$orders = DB::table('orders')->where('orders_id',$request->id)->first();
    	
    		$distributors_total_price = DB::table('orders_products')->where('orders_id',$request->id)->where('distributor_id',$distributor_data->distributor_id)->sum('distributor_final_price');
       		
    		$distributor_details = DB::table('users')->where('id',$distributor_data->distributor_id)->first();
    	 
    		$orders_products = DB::table('orders_products')->where('orders_id',$request->id)->where('distributor_id',$distributor_data->distributor_id)->get();
    		  
    		  
    	/*	  if($distributor_data->distributor_id  == 0){
    return redirect()->back()->with('error', "Purchase order cannot be raised, because the order has no distributor and distributor price, please update all the products with distributor and distributor price, this should be done before the customer raises order.");
   
    }

    if($distributors_total_price == 0){
    return redirect()->back()->with('error', "Purchase order cannot be raised, because the order has no distributor and distributor price, please update all the products with distributor and distributor price, this should be done before the customer raises order.");
   
    }*/
    		      		$date_added = date('Y-m-d h:i:s');

    		  
    		$purchase_orders_id = DB::table('purchase_orders')->insertGetId(
    				[       'orders_id' => $request->id,
    						'customers_name' => $distributor_details->first_name,
    						'customers_street_address' => $distributor_details->distributor_address,
    						'customers_company' => $distributor_details->company_name,
    						'distributor_id' =>  $distributor_data->distributor_id,
    						'email' => $distributor_details->email,
    						'customers_telephone' => $distributor_details->phone,
    						'gst' => $distributor_details->gst,
    						'delivery_name' => $result['commonContent']['setting']['company_name'],
    						'delivery_street_address' =>  $result['commonContent']['setting']['headquaters'],
    						'delivery_phone' => $result['commonContent']['setting']['headquaters_inquiry_number'],
    					
    						'billing_name' => $result['commonContent']['setting']['company_name'],
    						'billing_street_address' => $result['commonContent']['setting']['headquaters'],
    						'billing_phone' =>  $result['commonContent']['setting']['headquaters_inquiry_number'],
    						'payment_method' => $orders->payment_method,
    					 
    						'last_modified' => $orders->last_modified,
    						'date_purchased' =>$date_added,
    						 
    						'distributor_order_price' => $distributors_total_price,
    						'shipping_cost' => $orders->shipping_cost,
    						'shipping_method' => $orders->shipping_method,
    					 
    						'currency' => $orders->currency,
    						'order_information' =>$orders->order_information,
    					 
    						 
    						'total_tax' => $orders->total_tax,
    						'ordered_source' => $orders->ordered_source,
    						 
    				]);
    		
    		$purchase_orders_main_status= DB::table('purchase_orders_main_status')->where('purchase_orders_main_status_id',1)->first();
    		 
    		 
    		$date_added = date('Y-m-d h:i:s');
    		//orders status history
    		$purchase_orders_history_id = DB::table('purchase_orders_status_history')->insertGetId(
    				['purchase_orders_id' => $purchase_orders_id,
    						'purchase_orders_status_id' => 1,
    						'date_added' => $date_added,
    						'customer_notified' => '1',
    						'comments' => $purchase_orders_main_status->comments,
    						'current_status' => 1,


    				]);
    		 
    		 
    		$grand_total_tax=0;
    		foreach($orders_products as $orders_products_data){
    			
    			
    			$products = DB::table('products')
    			->LeftJoin('tax_rates', 'tax_rates.tax_class_id', '=', 'products.products_tax_class_id')
     			->where('products_id', $orders_products_data->products_id)->first();
    			
    			$tax_value = $orders_products_data->distributor_final_price + $orders_products_data->distributor_final_price * $products->tax_rate / 100 ;
    			
    		 $total_tax = $tax_value - $orders_products_data->distributor_final_price;
    			 $grand_total_tax=$grand_total_tax+$total_tax;
    			$purchase_orders_products_id = DB::table('purchase_orders_products')->insertGetId(
    					[
    							'purchase_orders_id' => $purchase_orders_id,
    							'products_id' => $orders_products_data->products_id,
    							'distributor_id' => $orders_products_data->distributor_id,
    							'products_name' => $orders_products_data->products_name,
    							
    							'hsn_sac_code' => $orders_products_data->hsn_sac_code,
    								
    		'distributor_product_price_percentage' => $orders_products_data->distributor_product_price_percentage,
    							
    							'distributor_products_price' => $orders_products_data->distributor_products_price,
     							'distributor_final_price' => $orders_products_data->distributor_final_price,
    			
    							'products_tax' => $total_tax,
    					        'product_tax_rate'=> $products->tax_rate,
     							'products_quantity' => $orders_products_data->products_quantity,
    					]);
    	
    			
    			
 	$orders_products_attributes = DB::table('orders_products_attributes')->where('orders_id',$request->id)->where('orders_products_id',$orders_products_data->orders_products_id)->get();
    			
    			
    			foreach ($orders_products_attributes as $orders_products_attributes_data) {
    				 
    				 
    				DB::table('purchase_orders_products_attributes')->insert(
    						[
    								'purchase_orders_id' => $purchase_orders_id,
    								'products_id' => $orders_products_attributes_data->products_id,
    								'purchase_orders_products_id' => $purchase_orders_products_id,
    								'products_options' => $orders_products_attributes_data->products_options,
    								'products_options_values' => $orders_products_attributes_data->products_options_values,
     								'distributor_options_values_price' => $orders_products_attributes_data->distributor_options_values_price,
    								'price_prefix' => $orders_products_attributes_data->price_prefix,
    						]);
    				 
    			}
    			 
    			
    		}
    		
    		
    		
    		 	DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_orders_id)
    		 	->where('orders_id', '=', $request->id)
    	->update(['total_tax' => $grand_total_tax,'roundup_purchaseorder_amount' => $distributors_total_price+$grand_total_tax,
    	'roundup_cashdiscount_final_amount' => $distributors_total_price+$grand_total_tax]);
    	
    	//sending notificaitons to distributor
    	
    	
    	$date_added = date('Y-m-d');
    	
    	$title = "New Purchase Order Raised";
    	$totalPrice=$distributors_total_price+$grand_total_tax;
    	$description = "Purchase Order is Raised for amount of Rs.$totalPrice on Date $date_added. Waiting for speedy dispatch of order";
    	$distributor_id=$distributor_data->distributor_id;
    	$distributor_notifications = DB::table('distributor_notifications')->insertGetId(
    			[       'purchase_order_id' => $purchase_orders_id,
    					'distributor_id' =>  $distributor_data->distributor_id,
    					'title' => $title,
    					'description' => $description,
    					'notification_date' => $date_added,
    					 
    						
    			]);
    	
    	
    	
    	//notification/email
    	$myVar = new AlertController();
    	$alertSetting = $myVar->purchaseorderAlert($description,$title,$distributor_id);
    		  
    	
    	//end of sending notification to distributor
    	
    	
    		  
    	}
    	
    	
    	
    	
    	DB::table('orders')->where('orders_id', '=', $request->id)
    	->update(['is_purchase_order_raised' => 1]);
    	 
    	 
     
    		return redirect('admin/orders/display');
    	 
    }
    
    
    
    public function purchase_orders(Request $request)
    {
    	$title = array('pageTitle' => Lang::get("labels.ListingOrders"));
    
    	$message = array();
    	$errorMessage = array();
    
    	$ordersData['purchase_orders'] = $this->PurchaseOrder->purchase_orders($request);
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    	return view("admin.purchaseorders.purchase_orders", $title)->with('listingOrders', $ordersData)->with('result', $result);
    }
    
    
    
    //view order detail
    public function purchaseorder_detail(Request $request)
    {
    
    	$title = array('pageTitle' => Lang::get("labels.ViewOrder"));
    	$message = array();
    	$errorMessage = array();
    
    	//orders data
    	$ordersData = $this->PurchaseOrder->purchaseorder_detail($request);
    
    	// current order status
    	$orders_status_history = DB::table("purchase_orders_status_history")
     	->LeftJoin('purchase_orders_main_status', 'purchase_orders_main_status.purchase_orders_main_status_id', '=', 'purchase_orders_status_history.purchase_orders_status_id')
    	->select('purchase_orders_status_history.purchase_orders_status_id','purchase_orders_status_history.date_added','purchase_orders_main_status.purchase_orders_main_status_name','purchase_orders_main_status.comments')
    	->where('purchase_orders_id',$request->id)
        ->orderBy('purchase_orders_status_history.purchase_orders_status_history_id', 'desc')
    	->get();
    
    	//all statuses
    	$orders_status = DB::table("purchase_orders_status")->get();
    	
    	$orders_main_status = DB::table("purchase_orders_main_status")->get();
    
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['orders_status'] = $orders_status;
    	$ordersData['orders_main_status'] = $orders_main_status;
    	$ordersData['orders_status_history'] = $orders_status_history;
    	
    	
    	
    $distributors = DB::table('users')->where('customer_type','DISTRIBUTOR')->where('status','1')->get();
    	$result['distributors'] = $distributors;
    	
    	
    	
    	//get function from other controller
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	//dd($ordersData);
    
    	return view("admin.purchaseorders.viewpurchaseorder", $title)->with('data', $ordersData)->with('result', $result);
    }
    
    
    
    //view order detail
    public function invoiceprint_purchaseorder(Request $request)
    {
    
    	$title = array('pageTitle' => Lang::get("labels.ViewOrder"));
    	$language_id = '1';
    	$purchase_orders_id = $request->id;
    
    	$message = array();
    	$errorMessage = array();
    	DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_orders_id)
    	->update(['is_seen' => 1]);
    	 
    	$order = DB::table('purchase_orders')
    	 ->where('purchase_orders.purchase_orders_id', '=', $purchase_orders_id)->get();
    
    	foreach ($order as $data) {
    		$purchase_orders_id = $data->purchase_orders_id; 
    		
    		$purchase_orders_products = DB::table('purchase_orders_products')
    		->join('products', 'products.products_id', '=', 'purchase_orders_products.products_id')
    		->select('purchase_orders_products.*', 'products.products_image as image')
    		->where('purchase_orders_products.purchase_orders_id', '=', $purchase_orders_id)->get();
    		$i = 0;
    		$total_price = 0;
    		$total_tax = 0;
    		$product = array();
    		$subtotal = 0;
    		$total_purchase_tax = 0;
    		foreach ($purchase_orders_products as $purchase_orders_products_data) {
    
    			//categories
    			$categories = DB::table('products_to_categories')
    			->leftjoin('categories', 'categories.categories_id', 'products_to_categories.categories_id')
    			->leftjoin('categories_description', 'categories_description.categories_id', 'products_to_categories.categories_id')
    			->select('categories.categories_id', 'categories_description.categories_name', 'categories.categories_image', 'categories.categories_icon', 'categories.parent_id')
    			->where('products_id', '=', $purchase_orders_products_data->purchase_orders_products_id)
    			->where('categories_description.language_id', '=', $language_id)->get();
    
    			$purchase_orders_products_data->categories = $categories;
    
    			$product_attribute = DB::table('purchase_orders_products_attributes')
    			->where([
    					['purchase_orders_products_id', '=', $purchase_orders_products_data->purchase_orders_products_id],
    					['purchase_orders_id', '=', $purchase_orders_products_data->purchase_orders_id],
    			])
    			->get();
    
    			$purchase_orders_products_data->attribute = $product_attribute;
    			$product[$i] = $purchase_orders_products_data;
    			$total_price = $total_price + $purchase_orders_products[$i]->distributor_final_price;
    
    			$subtotal += $purchase_orders_products[$i]->distributor_final_price;
    			$total_purchase_tax += $purchase_orders_products[$i]->products_tax;
    			 
    			$i++;
    		}
    		$data->data = $product;
    		$orders_data[] = $data;
    	}
    
//     	$orders_status_history = DB::table('orders_status_history')
//     	->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
//     	->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
//     	->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)
//     	->orderBy('orders_status_history.date_added', 'desc')
//     	->where('orders_id', '=', $orders_id)->get();
    
//     	$orders_status = DB::table('orders_status')->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
//     	->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)->get();
    
    	$taxable_amount = DB::table('purchase_orders_products')->where('purchase_orders_id',$purchase_orders_id)->sum('products_tax');
    	
    	
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['orders_data'] = $orders_data;
    	$ordersData['total_price'] = $total_price;
//     	$ordersData['orders_status'] = $orders_status;
//     	$ordersData['orders_status_history'] = $orders_status_history;
    	$ordersData['subtotal'] = $subtotal;
    	$ordersData['total_purchase_tax'] = $total_purchase_tax;
    	
    	$ordersData['sgst_amount'] = $taxable_amount/2;
    	
    	$ordersData['cgst_amount'] = $taxable_amount/2;
    	
    	$ordersData['igst_amount'] = $taxable_amount;
    	 
    	//get function from other controller
    
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	return view("admin.purchaseorders.invoiceprint_purchaseorder", $title)->with('data', $ordersData)->with('result', $result);
    
    }
    
    
    public function purchase_order_status_update(Request $request)
    {  
    	
    	DB::table('purchase_orders_products')->where('purchase_orders_products_id', '=', $request->purchase_orders_products_id)
    	->update(['purchase_order_product_status_id' => $request->purchase_order_product_status_id]);
     
            return redirect()->back()->with('message', Lang::get("labels.OrderStatusChangedMessage"));
    	
    }
    
    
    public function updatepurchaseorderrecord(Request $request){
    	$date_added = date('Y-m-d h:i:s');
    	$orders_status = $request->orders_status;
    	$old_orders_status = $request->old_orders_status;
    
    	$comments = $request->comments;
    	$purchase_orders_id = $request->purchase_orders_id;
    	$customerID  =  auth()->user()->id;
    

    	if ($old_orders_status == $orders_status) {
    		return redirect()->back()->with('error', Lang::get("labels.StatusChangeError"));
    	} else {
    	    
    	    
    	    
    	    
    	    	DB::table('purchase_orders_status_history')->where('purchase_orders_id', '=', $purchase_orders_id)
    		->update(['current_status' => 0]);
    		 
    		 
    		 
    		 
    	//orders status history
    	$orders_history_id = DB::table('purchase_orders_status_history')->insertGetId(
    			['purchase_orders_id' => $purchase_orders_id,
    					'purchase_orders_status_id' => $orders_status,
    					'date_added' => $date_added,
    					'customer_notified' => '1',
    					'comments' => $comments,
    					 'current_status' => 1
    					 
    			]);
    	 
    
    	return redirect()->back()->with('message', Lang::get("labels.OrderStatusChangedMessage"));
    	}
    	 
    }
    
    
     // Regenerating the purchase order of product not available in the purchase order for particular Distributor 03-06-2022
   
    public function regenerate_purchase_order(Request $request)
    {
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	$purchase_orders_products_id =	$request->purchase_orders_products_id;
    	
    	$distributor_id =	$request->distributor_id;
      	
    	$purchase_orders_products = DB::table('purchase_orders_products')->where('purchase_orders_products_id',$purchase_orders_products_id)->first();
    	 
    	$purchase_order_id =$purchase_orders_products->purchase_orders_id;
    	 
    	$total_tax = $purchase_orders_products->products_tax;
    	
    	$distributor_order_price = $purchase_orders_products->distributor_final_price;
    	
    	$previous_distributor_id = $purchase_orders_products->distributor_id;
    	  
    	$purchase_orders = DB::table('purchase_orders')->where('purchase_orders_id',$purchase_order_id)->first();
     
    	$orders_id =  $purchase_orders->orders_id;
    	 
    	$distributor_details = DB::table('users')->where('id',$distributor_id)->first();
    		   
    	$purchase_orders_id = DB::table('purchase_orders')->insertGetId(
    				[       'orders_id' => $orders_id,
    						'customers_name' => $distributor_details->first_name,
    						'customers_street_address' => $distributor_details->distributor_address,
    						'customers_company' => $distributor_details->company_name,
    						'distributor_id' =>  $distributor_id,
    						'email' => $distributor_details->email,
    						'customers_telephone' => $distributor_details->phone,
    						'gst' => $distributor_details->gst,
    						'delivery_name' => $result['commonContent']['setting']['company_name'],
    						'delivery_street_address' =>  $result['commonContent']['setting']['headquaters'],
    						'delivery_phone' => $result['commonContent']['setting']['headquaters_inquiry_number'],
    						'billing_name' => $result['commonContent']['setting']['company_name'],
    						'billing_street_address' => $result['commonContent']['setting']['headquaters'],
    						'billing_phone' =>  $result['commonContent']['setting']['headquaters_inquiry_number'],
    						'payment_method' => $purchase_orders->payment_method,
    						'last_modified' => $purchase_orders->last_modified,
    						'date_purchased' => $purchase_orders->date_purchased,
    						'distributor_order_price' => $distributor_order_price,
    						'shipping_cost' => $purchase_orders->shipping_cost,
    						'shipping_method' => $purchase_orders->shipping_method,
    						'currency' => $purchase_orders->currency,
    						'order_information' =>$purchase_orders->order_information,
    						'total_tax' => $total_tax,
    						'ordered_source' => $purchase_orders->ordered_source,
    						'roundup_purchaseorder_amount' =>  $distributor_order_price+$total_tax,
    				]);
    
    	$purchase_orders_main_status= DB::table('purchase_orders_main_status')->where('purchase_orders_main_status_id',1)->first();
    		 
    	$date_added = date('Y-m-d h:i:s');
    		//orders status history
    	$purchase_orders_history_id = DB::table('purchase_orders_status_history')->insertGetId(
    				['purchase_orders_id' => $purchase_orders_id,
    						'purchase_orders_status_id' => 1,
    						'date_added' => $date_added,
    						'customer_notified' => '1',
    						'comments' => $purchase_orders_main_status->comments,
    						'current_status' => 1,
    				]);
    		 
    	DB::table('purchase_orders_products')->where('purchase_orders_products_id', '=', $purchase_orders_products_id)
     		->update(['purchase_orders_id' => $purchase_orders_id,
     				  'purchase_order_product_status_id'=>1,
     				'previous_distributor_id' =>$previous_distributor_id,
     				'distributor_id' =>$distributor_id,
     		]); 
    		
     	DB::table('purchase_orders_products_attributes')->where('purchase_orders_products_id', '=', $purchase_orders_products_id)
     		->update(['purchase_orders_id' => $purchase_orders_id]);
     		
     	$purchase_orders_products = DB::table('purchase_orders_products')->where('purchase_orders_id',$purchase_order_id)->get();
     		
     	if(count($purchase_orders_products)>0){

     		$distributor_order_total_price = DB::table('purchase_orders_products')->where('purchase_orders_id',$purchase_order_id)->sum('distributor_final_price');
     			
     		$distributor_order_total_tax = DB::table('purchase_orders_products')->where('purchase_orders_id',$purchase_order_id)->sum('products_tax');
     			 
     		DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_order_id)
     			->update(['distributor_order_price' => $distributor_order_total_price,
     					'total_tax' =>  $distributor_order_total_tax,
     					'roundup_purchaseorder_amount' =>  $distributor_order_total_price+$distributor_order_total_tax,
     			]);
     			 
     	}else{
     		DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_order_id)
     		->update(['obsolete_purchase_order' => 1]);
     	}
     		 
    	$date_added = date('Y-m-d');
    		 
    	$title = "New Purchase Order Raised";
    	$totalPrice=$distributor_order_price+$total_tax;
    	$description = "Purchase Order is Raised for amount of Rs.$totalPrice on Date $date_added. Waiting for speedy dispatch of order";
    	$distributor_id=$distributor_id;
    	$distributor_notifications = DB::table('distributor_notifications')->insertGetId(
    				[       'purchase_order_id' => $purchase_orders_id,
    						'distributor_id' =>  $distributor_id,
    						'title' => $title,
    						'description' => $description,
    						'notification_date' => $date_added,
    				]);
    
    	//notification/email
    	$myVar = new AlertController();
    	$alertSetting = $myVar->purchaseorderAlert($description,$title,$distributor_id);
     	
     	return redirect('admin/orders/display')->with('message', "New Purchase Order is generated For Not Available Product");
    		
    }
    
      public function addwalletdate(Request $request)
    {
    	$purchase_order_id=$request->purchase_order_id;
    	
    	$added_wallet_date=$request->added_wallet_date;
    	 
    	$data =   	DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_order_id)
     		->update(['purchaseorder_creditpayment_date' => $added_wallet_date]);
    
    	if($data){
    		 
    		$data=array('status' => "SUCCESS", 'content' => $data);
    
    	}else{
    		 
    		$data=array('status' => "FAIL", 'content' => $data);
    	}
    
    	return response()->json($data);
    }
    
    
    
    public function distributorwallet(Request $request){
    
    	$language_id = '1';
    	$purchase_orders_id = $request->id;
    	$title = array('pageTitle' => "Distributor Wallet List");
    
    	$distributorwallet = DB::table('purchase_orders')->where('purchase_orders_id',$purchase_orders_id)
     	->first();
     
    	$result['distributorwallet'] = $distributorwallet;
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	return view("admin.distributors.distributor_wallet")->with('result', $result);
    }
    
     
    //editunit
    public function editdistributorwallet(Request $request)
    {
    	$title = array('pageTitle' => "Edit Distributor Wallet");
    	$result = array();
    	 
    
     	$distributorwallets = DB::table('purchase_orders')->where('purchase_orders_id', $request->id)->first();
    	$result['distributorwallets'] = $distributorwallets;
    
    	$result['commonContent'] = $this->Setting->commonContent();
    	return view("admin.distributors.distributorwallet_edit", $title)->with('result', $result);
    }
    
    //updateunit
    public function updatedistributorwallet(Request $request)
    {
    	 $orders_status = DB::table('purchase_orders')->where('purchase_orders_id', '=', $request->id)->update([

          'payment_transaction_details' => $request->payment_transaction_details,
        		'is_paid' => $request->is_paid,        		  
        ]);
       
       
       //notification to be displayed on the admin panel
       	 
    	 $notification_update = DB::table('distributor_notifications')->where('purchase_order_id', '=', $request->id)
    	 ->where('type', '=', "ADMIN")->update(['is_seen' =>1]);
    	 
       
       
       $notification_update = DB::table('distributor_notifications')->where('purchase_order_id', '=', $request->id)
         ->where('type', '=', "DISCOUNT")->update(['is_seen' =>1]);
       
       
       //Start Notification For Purchase Order Amount Paid  
        $date_added = date('Y-m-d');
         
        $distributorwallets = DB::table('purchase_orders')->where('purchase_orders_id', $request->id)->first();
         
        $purchase_order_id =$distributorwallets->purchase_orders_id;
       
        $distributor_id =$distributorwallets->distributor_id;
        
        $total_amount=$distributorwallets->roundup_purchaseorder_amount;
        
        $title = "Purchase Order Amount Paid"; 
        
        $description= "Your Purchase order amount Rs.$total_amount of Purchase Order ID #$purchase_order_id is $request->payment_transaction_details";
         
         
        $distributor_notifications = DB::table('distributor_notifications')->insertGetId(
    			[       'purchase_order_id' => $purchase_order_id,
    					'distributor_id' =>  $distributor_id,
    					'title' => $title,
    					'description' => $description,
    					'notification_date' => $date_added,
    					 
    						
    			]);
        
        //notification/email
        $myVar = new AlertController();
        $alertSetting = $myVar->purchaseorderAlert($description,$title,$distributor_id);
        //End Notification For Purchase Order Amount Paid
        
    	$message = "Distributor Wallet Updated Successfully";
    	return redirect()->back()->withErrors([$message]);
    }
    
    
    //discount method accepted or rejected by the admin...
    
   
    public function discountacceptreject(Request $request)
    {
    	$purchase_order_id=$request->purchase_order_id;
    	 
    	$is_discount=$request->is_discount;
    $purchase_order =DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_order_id)
    	->first();
    	
    	$roundupamount = $purchase_order->roundup_purchaseorder_amount;
    	
    	$discountamount = $purchase_order->cashdiscount_purchaseorder_amount;
    	 
    	$totalamount = $purchase_order->distributor_order_price + $purchase_order->total_tax;
    	  
    	$discountedamount = $roundupamount-$discountamount; 
    	 
    	if($is_discount == 1){
    		
    		$data =   	DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_order_id)
    		->update(['roundup_cashdiscount_final_amount' => $discountedamount,
    				'is_discount' => $is_discount,
    		]);
    		
    		
    	}else{
    		
    		$data =   	DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_order_id)
    		->update(['is_discount' => $is_discount
    		]);
    	} 
    	
    	
    	if($data){
    		 
    		$data=array('status' => "SUCCESS", 'content' => "Discount Accepted Successfully");
    
    	}else{
    		 
    		$data=array('status' => "FAIL", 'content' => "Discount Rejected Successfully");
    	}
    
    	return response()->json($data);
    }
    

}
