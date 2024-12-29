<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\Core\Order;
use Carbon\Carbon;

class OrdersController extends Controller
{
    //
    public function __construct( Setting $setting, Order $order )
    {
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Setting = $setting;
        $this->Order = $order;
    }

    //add listingOrders
    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.ListingOrders"));        

        $message = array();
        $errorMessage = array();        
        
        $ordersData['orders'] = $this->Order->paginator();
        $ordersData['message'] = $message;
        $ordersData['errorMessage'] = $errorMessage;
        $ordersData['currency'] = $this->myVarsetting->getSetting(); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.Orders.index", $title)->with('listingOrders', $ordersData)->with('result', $result);
    }
    
    
        public function getorderstatus_comments(Request $request){
    	 
    	$status_id=$request->orders_status;
    
    
    	$comment=DB::table('orders_status_description')
    	->where('orders_status_id', $status_id)->first();
    
    
    	$orderstatus_comments['data'] = $comment->comments;
    
    	echo json_encode($orderstatus_comments);
    
    }

    //view order detail
    public function vieworder(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.ViewOrder"));
        $message = array();
        $errorMessage = array();

        //orders data
        $ordersData = $this->Order->detail($request);        

        // current order status
        $orders_status_history = $this->Order->currentOrderStatus($request);  

        //all statuses 
        $orders_status = $this->Order->orderStatuses();  
       //Individual Product Status
        //For fetching Product order Status 23-09-2022
        $product_orders_status = $this->Order->productorderStatuses();
         
        
        $ordersData['message'] = $message;
        $ordersData['errorMessage'] = $errorMessage;
        $ordersData['orders_status'] = $orders_status;
        $ordersData['product_orders_status'] = $product_orders_status; 
        $ordersData['orders_status_history'] = $orders_status_history;

        //get function from other controller
        $ordersData['currency'] = $this->myVarsetting->getSetting();
        $result['commonContent'] = $this->Setting->commonContent();

        //dd($ordersData);

        return view("admin.Orders.vieworder", $title)->with('data', $ordersData)->with('result', $result);
    }
    
   /* //For updating Product order Status 23-09-2022
    public function product_order_status_update(Request $request)
    {
    	 
    	DB::table('orders_products')->where('orders_products_id', '=', $request->orders_products_id)
    	->update(['order_product_status_id' => $request->order_product_status_id]);
    	 
    	return redirect()->back()->with('message', "Product Status Updated Successfully");
    	 
    }*/
    
     //For updating Product order Status 23-09-2022
    // added sms Code on 24-04-2023 for individual product status
    public function product_order_status_update(Request $request)
    {
    $orders_id= $request->order_id;
   
    DB::table('orders_products')->where('orders_products_id', '=', $request->orders_products_id)
    ->update(['order_product_status_id' => $request->order_product_status_id]);
   
    //SMS FOR CUSTOMERS WHEN ORDER STATUS CHANGED
   
    $status = DB::table('orders_products')
    ->LeftJoin('product_orders_status', 'product_orders_status.product_orders_status_id', '=', 'orders_products.order_product_status_id')
      ->where('orders_products.order_product_status_id', '=', $request->order_product_status_id)
      ->where('orders_products.orders_products_id', '=', $request->orders_products_id)


    ->select('orders_products.*','product_orders_status.product_orders_status_name')
    ->first();
   
    //SMS FOR CUSTOMERS WHEN ORDER STATUS CHANGED
    $order_details = DB::table('orders')->where('orders_id', '=', $orders_id)
    ->first();
   
    $comments = $status->product_orders_status_name;
    $status_name= "Your product $status->products_name is";
   
   
    $user_phone = $order_details->delivery_phone;
    $order_customer_name = $order_details->customers_name;
   
    orderstatussms($orders_id,$order_customer_name,$user_phone,$status_name,$comments);
    //SMS FOR CUSTOMERS WHEN ORDER STATUS CHANGED
   
   
    return redirect()->back()->with('message', "Product Status Updated Successfully");
   
    }

    //For updating Conignment No 23-09-2022
    public function consignment_number_update(Request $request)
    {
    
    	DB::table('orders_products')->where('orders_products_id', '=', $request->orders_products_id)
    	->update(['consignment_no' => $request->consignment_no]);
    
    	return redirect()->back()->with('message', "Coonsignment Number Updated Successfully");
    
    }
    
    
    //update order
    public function updateOrder(Request $request)
    {

        $orders_status = $request->orders_status;
        $old_orders_status = $request->old_orders_status;

        $comments = $request->comments;
        $orders_id = $request->orders_id;

        //get function from other controller
        $setting = $this->myVarsetting->getSetting();       

        if ($old_orders_status == $orders_status) {
            return redirect()->back()->with('error', Lang::get("labels.StatusChangeError"));
        } else {
            //update order
            $orders_status = $this->Order->updateRecord($request);  
            
                        //SMS FOR CUSTOMERS WHEN ORDER STATUS CHANGED

             $status = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->where('orders_status_description.language_id', '=', 1)
            ->where('orders_status_description.orders_status_id', '=', $request->orders_status)
            ->select('orders_status.*','orders_status_description.orders_status_name')
            ->first();
            
            //SMS FOR CUSTOMERS WHEN ORDER STATUS CHANGED
            $order_details = DB::table('orders')->where('orders_id', '=', $orders_id)
           ->first();
            
           
           $status_name= $status->orders_status_name;
           $user_phone = $order_details->delivery_phone;
           $order_customer_name = $order_details->customers_name;
            
            orderstatussms($orders_id,$order_customer_name,$user_phone,$status_name,$comments);
            //SMS FOR CUSTOMERS WHEN ORDER STATUS CHANGED
            
            
            
            
            return redirect()->back()->with('message', Lang::get("labels.OrderStatusChangedMessage"));
        }

    }

    //deleteorders
    public function deleteOrder(Request $request)
    {       
        //reverse stock
        $this->Order->reverseStock($request);     
        $this->Order->deleteRecord($request);
        
        return redirect()->back()->withErrors([Lang::get("labels.OrderDeletedMessage")]);
    }

     //view order detail
    public function invoiceprint(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.ViewOrder"));
        $language_id = '1';
        $orders_id = $request->id;

        $message = array();
        $errorMessage = array();

        DB::table('orders')->where('orders_id', '=', $orders_id)
            ->where('customers_id', '!=', '')->update(['is_seen' => 1]);

        $order = DB::table('orders')
            ->LeftJoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders.orders_id')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('users', 'users.id', '=', 'orders.customers_id')
            ->where('orders_status_description.language_id', '=', $language_id)->where('orders_status.role_id', '<=', 2)
            ->where('orders.orders_id', '=', $orders_id)->orderby('orders_status_history.date_added', 'DESC')->get();

        foreach ($order as $data) {
            $orders_id = $data->orders_id;

            $orders_products = DB::table('orders_products')
                ->join('products', 'products.products_id', '=', 'orders_products.products_id')
                ->select('orders_products.*', 'products.products_image as image')
                ->where('orders_products.orders_id', '=', $orders_id)->get();
            $i = 0;
            $total_price = 0;
            $total_tax = 0;
            $product = array();
            $subtotal = 0;
            foreach ($orders_products as $orders_products_data) {

                //categories
                $categories = DB::table('products_to_categories')
                    ->leftjoin('categories', 'categories.categories_id', 'products_to_categories.categories_id')
                    ->leftjoin('categories_description', 'categories_description.categories_id', 'products_to_categories.categories_id')
                    ->select('categories.categories_id', 'categories_description.categories_name', 'categories.categories_image', 'categories.categories_icon', 'categories.parent_id')
                    ->where('products_id', '=', $orders_products_data->orders_products_id)
                    ->where('categories_description.language_id', '=', $language_id)->get();

                $orders_products_data->categories = $categories;

                $product_attribute = DB::table('orders_products_attributes')
                    ->where([
                        ['orders_products_id', '=', $orders_products_data->orders_products_id],
                        ['orders_id', '=', $orders_products_data->orders_id],
                    ])
                    ->get();

                $orders_products_data->attribute = $product_attribute;
                $product[$i] = $orders_products_data;
                $total_price = $total_price + $orders_products[$i]->final_price;

                $subtotal += $orders_products[$i]->final_price;

                $i++;
            }
            $data->data = $product;
            $orders_data[] = $data;
        }

        $orders_status_history = DB::table('orders_status_history')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)
            ->orderBy('orders_status_history.date_added', 'desc')
            ->where('orders_id', '=', $orders_id)->get();

        $orders_status = DB::table('orders_status')->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)->get();

            $taxable_amount = DB::table('orders_products')->where('orders_id',$orders_id)->sum('products_tax');
            
            
        $ordersData['message'] = $message;
        $ordersData['errorMessage'] = $errorMessage;
        $ordersData['orders_data'] = $orders_data;
        $ordersData['total_price'] = $total_price;
        $ordersData['orders_status'] = $orders_status;
        $ordersData['orders_status_history'] = $orders_status_history;
        $ordersData['subtotal'] = $subtotal;

        $ordersData['sgst_amount'] = $taxable_amount/2;
        
        $ordersData['cgst_amount'] = $taxable_amount/2;
        
        $ordersData['igst_amount'] = $taxable_amount;
        
        
        //get function from other controller

        $ordersData['currency'] = $this->myVarsetting->getSetting();
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.Orders.invoiceprint", $title)->with('data', $ordersData)->with('result', $result);

    }
    
    
    public function filterbycustomerorders(Request $request)
    {
    	$title = array('pageTitle' => Lang::get("labels.ListingOrders"));
    	$filter    = $request->FilterBy;
    	$parameter = $request->parameter;
    	$message = array();
    	$errorMessage = array();
    
    	$ordersData['orders'] = $this->Order->filterbycustomerorders($request);
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    	return view("admin.Orders.index", $title)->with('listingOrders', $ordersData)->with('result', $result)->with('filter',$filter)->with('parameter',$parameter);
    }
    
    
       public function locationorderdisplay()
    {
    	$title = array('pageTitle' => Lang::get("labels.ListingOrders"));
    
    	$message = array();
    	$errorMessage = array();
    
    	$ordersData['orders'] = $this->Order->locationbasedorders();
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    	return view("admin.Orders.locationbasedorders", $title)->with('listingOrders', $ordersData)->with('result', $result);
    }
    
    
    
	///Bharath 04-03-2022 Location Based Orders Filter
public function locationfilterbycustomerorders(Request $request)
    {
            $title = array('pageTitle' => Lang::get("labels.ListingOrders"));
            $filter    = $request->FilterBy;
            $parameter = $request->parameter;
            $message = array();
            $errorMessage = array();
    
            $ordersData['orders'] = $this->Order->locationfilterbycustomerorders($request);
            $ordersData['message'] = $message;
            $ordersData['errorMessage'] = $errorMessage;
            $ordersData['currency'] = $this->myVarsetting->getSetting();
            $result['commonContent'] = $this->Setting->commonContent();
            return view("admin.Orders.locationbasedorders", $title)->with('listingOrders', $ordersData)->with('result', $result)->with('filter',$filter)->with('parameter',$parameter);
    }
    
    
    
    //bharath 
    public function generate_purchase_order(Request $request)
    { 
    	$result['commonContent'] = $this->Setting->commonContent();
    	
    	   
    	$distributors = DB::table('orders_products')->where('orders_id',$request->id)->distinct()->get(['distributor_id']);
    	
    	foreach($distributors as $distributor_data){
    		  
    		$orders = DB::table('orders')->where('orders_id',$request->id)->first();
    	
    		$distributors_total_price = DB::table('orders_products')->where('orders_id',$request->id)->where('distributor_id',$distributor_data->distributor_id)->sum('distributor_final_price');
       		
    		$distributor_details = DB::table('users')->where('id',$distributor_data->distributor_id)->first();
    	 
    		$orders_products = DB::table('orders_products')->where('orders_id',$request->id)->where('distributor_id',$distributor_data->distributor_id)->get();
    		  
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
    						'date_purchased' => $orders->date_purchased,
    						 
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
    				]);
    		 
    		 
    		
    		foreach($orders_products as $orders_products_data){
    			
    			
    			$products = DB::table('products')
    			->LeftJoin('tax_rates', 'tax_rates.tax_class_id', '=', 'products.products_tax_class_id')
     			->where('products_id', $orders_products_data->products_id)->first();
    			
    			$tax_value = $orders_products_data->distributor_final_price + $orders_products_data->distributor_final_price * $products->tax_rate / 100 ;
    			
    		 $total_tax = $tax_value - $orders_products_data->distributor_final_price;
    			 
    			$purchase_orders_products_id = DB::table('purchase_orders_products')->insertGetId(
    					[
    							'purchase_orders_id' => $purchase_orders_id,
    							'products_id' => $orders_products_data->products_id,
    							'distributor_id' => $orders_products_data->distributor_id,
    							'products_name' => $orders_products_data->products_name,
    							'distributor_products_price' => $orders_products_data->distributor_products_price,
     							'distributor_final_price' => $orders_products_data->distributor_final_price,
    			
    							'products_tax' => $total_tax,
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
    
    	$ordersData['purchase_orders'] = $this->Order->purchase_orders($request);
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    	return view("admin.Orders.purchase_orders", $title)->with('listingOrders', $ordersData)->with('result', $result);
    }
    
    
    
    //view order detail
    public function purchaseorder_detail(Request $request)
    {
    
    	$title = array('pageTitle' => Lang::get("labels.ViewOrder"));
    	$message = array();
    	$errorMessage = array();
    
    	//orders data
    	$ordersData = $this->Order->purchaseorder_detail($request);
    
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
    
    	//get function from other controller
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	//dd($ordersData);
    
    	return view("admin.Orders.viewpurchaseorder", $title)->with('data', $ordersData)->with('result', $result);
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
    
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['orders_data'] = $orders_data;
    	$ordersData['total_price'] = $total_price;
//     	$ordersData['orders_status'] = $orders_status;
//     	$ordersData['orders_status_history'] = $orders_status_history;
    	$ordersData['subtotal'] = $subtotal;
    	$ordersData['total_purchase_tax'] = $total_purchase_tax;
    	 
    	//get function from other controller
    
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	return view("admin.Orders.invoiceprint_purchaseorder", $title)->with('data', $ordersData)->with('result', $result);
    
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
    	//orders status history
    	$orders_history_id = DB::table('purchase_orders_status_history')->insertGetId(
    			['purchase_orders_id' => $purchase_orders_id,
    					'purchase_orders_status_id' => $orders_status,
    					'date_added' => $date_added,
    					'customer_notified' => '1',
    					'comments' => $comments,
    					 
    			]);
    	 
    
    	return redirect()->back()->with('message', Lang::get("labels.OrderStatusChangedMessage"));
    	}
    	 
    }
    
    public function consignmentinvoiceprint(Request $request)
    { 
    	$title = array('pageTitle' => Lang::get("labels.ViewOrder"));
    	$language_id = '1';
    	$orders_id = $request->id;
        $consignment_no=$request->consignment_no;
    	
        $message = array();
    	$errorMessage = array();
    
    	DB::table('orders')->where('orders_id', '=', $orders_id)
    	->where('customers_id', '!=', '')->update(['is_seen' => 1]);
    
    	$order = DB::table('orders')
    	->LeftJoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders.orders_id')
    	->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
    	->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
    	->LeftJoin('users', 'users.id', '=', 'orders.customers_id')
    	->where('orders_status_description.language_id', '=', $language_id)->where('orders_status.role_id', '<=', 2)
    	->where('orders.orders_id', '=', $orders_id)->orderby('orders_status_history.date_added', 'DESC')->get();
    
    	foreach ($order as $data) {
    		$orders_id = $data->orders_id;
    
    		$orders_products = DB::table('orders_products')
    		->join('products', 'products.products_id', '=', 'orders_products.products_id')
    		->select('orders_products.*', 'products.products_image as image')
    		->where('orders_products.orders_id', '=', $orders_id)
    		->where('orders_products.consignment_no', '=', $consignment_no)
    		->get();
    		$i = 0;
    		$total_price = 0;
    		$total_tax = 0;
    		$product = array();
    		$subtotal = 0;
    		foreach ($orders_products as $orders_products_data) {
    
    			//categories
    			$categories = DB::table('products_to_categories')
    			->leftjoin('categories', 'categories.categories_id', 'products_to_categories.categories_id')
    			->leftjoin('categories_description', 'categories_description.categories_id', 'products_to_categories.categories_id')
    			->select('categories.categories_id', 'categories_description.categories_name', 'categories.categories_image', 'categories.categories_icon', 'categories.parent_id')
    			->where('products_id', '=', $orders_products_data->orders_products_id)
    			->where('categories_description.language_id', '=', $language_id)->get();
    
    			$orders_products_data->categories = $categories;
    
    			$product_attribute = DB::table('orders_products_attributes')
    			->where([
    					['orders_products_id', '=', $orders_products_data->orders_products_id],
    					['orders_id', '=', $orders_products_data->orders_id],
    			])
    			->get();
    
    			$orders_products_data->attribute = $product_attribute;
    			$product[$i] = $orders_products_data;
    			$total_price = $total_price + $orders_products[$i]->final_price;
    
    			$subtotal += $orders_products[$i]->final_price;
    
    			$i++;
    		}
    		$data->data = $product;
    		$orders_data[] = $data;
    	}
    
    	$orders_status_history = DB::table('orders_status_history')
    	->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
    	->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
    	->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)
    	->orderBy('orders_status_history.date_added', 'desc')
    	->where('orders_id', '=', $orders_id)->get();
    
    	$orders_status = DB::table('orders_status')->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
    	->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)->get();
    
    	$taxable_amount = DB::table('orders_products')->where('orders_id',$orders_id)->sum('products_tax');
    
    
    	$ordersData['message'] = $message;
    	$ordersData['errorMessage'] = $errorMessage;
    	$ordersData['orders_data'] = $orders_data;
    	$ordersData['total_price'] = $total_price;
    	$ordersData['orders_status'] = $orders_status;
    	$ordersData['orders_status_history'] = $orders_status_history;
    	$ordersData['subtotal'] = $subtotal;
    
    	$ordersData['sgst_amount'] = $taxable_amount/2;
    
    	$ordersData['cgst_amount'] = $taxable_amount/2;
    
    	$ordersData['igst_amount'] = $taxable_amount;
    
    
    	//get function from other controller
    
    	$ordersData['currency'] = $this->myVarsetting->getSetting();
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	return view("admin.Orders.consignmentinvoiceprint", $title)->with('data', $ordersData)->with('result', $result);
    
    }
    
    

}
