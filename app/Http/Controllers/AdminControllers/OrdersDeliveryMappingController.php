<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\Core\Order;

class OrdersDeliveryMappingController extends Controller
{
    //
    public function __construct( Setting $setting, Order $order )
    {
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Setting = $setting;
        $this->Order = $order;
    }

    //add listingOrders
    public function displaydeliverymapping()
    {
        $title = array('pageTitle' => Lang::get("labels.ListingOrders"));        

        $message = array();
        $errorMessage = array();        
        
        $ordersData['orders'] = $this->Order->paginator();
        $ordersData['message'] = $message;
        $ordersData['errorMessage'] = $errorMessage;
        $ordersData['currency'] = $this->myVarsetting->getSetting(); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.Ordersdeliverymapping.index", $title)->with('listingOrders', $ordersData)->with('result', $result);
    }
    
    
        
    public function getorderstatus_comments(Request $request){
    	
    	$status_id=$request->orders_status;
    
    
    	$comment=DB::table('orders_status_description')
    	->where('orders_status_id', $status_id)->first();
    
    
    	$orderstatus_comments['data'] = $comment->comments;
    
    	echo json_encode($orderstatus_comments);
    
    }

    //view order detail
    public function vieworderdeliverymapping(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.ViewOrder"));
        $message = array();
        $errorMessage = array();

        //orders data
        $ordersData = $this->Order->detail($request);        
        $deliveryboys = $this->Order->deliveryboys($request);
        // current order status
        $orders_status_history = $this->Order->currentOrderStatusForDeliveryMapping($request);  

        //all statuses 
        $orders_status = $this->Order->orderStatuses();  
        
        $ordersData['message'] = $message;
        $ordersData['errorMessage'] = $errorMessage;
        $ordersData['orders_status'] = $orders_status;
        $ordersData['orders_status_history'] = $orders_status_history;
        $ordersData['deliveryboys'] = $deliveryboys;

        //get function from other controller
        $ordersData['currency'] = $this->myVarsetting->getSetting();
        $result['commonContent'] = $this->Setting->commonContent();

        //dd($ordersData);

        return view("admin.Ordersdeliverymapping.vieworder", $title)->with('data', $ordersData)->with('result', $result);
    }

    //update order
    public function updateOrderdeliverymapping(Request $request)
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
            return redirect()->back()->with('message', Lang::get("labels.OrderStatusChangedMessage"));
        }

    }

    //deleteorders
    public function deleteOrderdeliverymapping(Request $request)
    {       
        //reverse stock
        $this->Order->reverseStock($request);     
        $this->Order->deleteRecord($request);
        
        return redirect()->back()->withErrors([Lang::get("labels.OrderDeletedMessage")]);
    }
    
    // Assigning Delivery Boy 16-09-2020 Bharath
    public function assigndeliveryboy(Request $request)
    {
    	 
    	$this->Order->assigndeliveryboy($request);
    	
     	 return redirect()->back()->with('message', "Delivery Boy Assigned");
     	  
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
            ->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)
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

        $ordersData['message'] = $message;
        $ordersData['errorMessage'] = $errorMessage;
        $ordersData['orders_data'] = $orders_data;
        $ordersData['total_price'] = $total_price;
        $ordersData['orders_status'] = $orders_status;
        $ordersData['orders_status_history'] = $orders_status_history;
        $ordersData['subtotal'] = $subtotal;

        //get function from other controller

        $ordersData['currency'] = $this->myVarsetting->getSetting();
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.Orders.invoiceprint", $title)->with('data', $ordersData)->with('result', $result);

    }

}
