<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Http\Controllers\App\AlertController;

class Order extends Model
{
	protected $table = 'orders';
	public $sortable = ['orders_id', 'customers_name','date_purchased'];
	
	use Sortable;
	
    public function paginator(){

        $language_id = '1';
        $orders = Order::sortable(['orders_id'=>'desc'])->orderBy('orders_id', 'DESC')
            ->where('customers_id', '!=', '')->paginate(40);

        $index = 0;
        $total_price = array();

        foreach ($orders as $orders_data) {
            $orders_products = DB::table('orders_products')->sum('final_price');

            $orders[$index]->total_price = $orders_products;

            $orders_status_history = DB::table('orders_status_history')
                ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
                ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
                ->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
                ->where('orders_status_description.language_id', '=', $language_id)
                ->where('orders_id', '=', $orders_data->orders_id)
                ->where('role_id', '<=', 2)
                ->orderby('orders_status_history.orders_status_history_id', 'DESC')->limit(1)->get();

            $orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            $orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            $index++;

        }
        return $orders;
    }
    
    
    public function filterbycustomerorders($request){

    $filter = $request->FilterBy;
      $parameter = $request->parameter;
        switch ( $filter )
        { 
        	
        	case 'ID':
        		$language_id = '1';
        		$orders = Order::sortable(['orders_id'=>'desc'])
        		->orderBy('orders_id', 'DESC')
        		 ->where('orders_id','=',$parameter)
        		 ->where('customers_id', '!=', '')
        	     ->paginate(10);
        		
        	     
        	     
        		$index = 0;
        		$total_price = array();
        		
        		foreach ($orders as $orders_data) {
        			$orders_products = DB::table('orders_products')->sum('final_price');
        		
        			$orders[$index]->total_price = $orders_products;
        		
        			$orders_status_history = DB::table('orders_status_history')
        			->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
        			->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
        			->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
        			->where('orders_status_description.language_id', '=', $language_id)
        			->where('orders_id', '=', $orders_data->orders_id)
        			->where('role_id', '<=', 2)
        			->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
        		
        			$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
        			$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
        			$index++;
        		
        		}
        	break;
        	
            case 'Name':
            	$language_id = '1';
            	$orders = Order::sortable(['orders_id'=>'desc'])
            	->orderBy('orders_id', 'DESC')
            	 ->where('customers_name', 'LIKE', '%' .  $parameter . '%')
            	->where('customers_id', '!=', '')
            	->paginate(40);
            	$index = 0;
            	$total_price = array();
            	
            	foreach ($orders as $orders_data) {
            		$orders_products = DB::table('orders_products')->sum('final_price');
            	
            		$orders[$index]->total_price = $orders_products;
            	
            		$orders_status_history = DB::table('orders_status_history')
            		->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            		->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            		->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
            		->where('orders_status_description.language_id', '=', $language_id)
            		->where('orders_id', '=', $orders_data->orders_id)
            		->where('role_id', '<=', 2)
            		->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
            	
            		$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            		$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            		$index++;
            	
            	}
             

            break;
            
            case 'Phone':
            	$language_id = '1';
           $orders = Order::sortable(['orders_id'=>'desc'])
            	->orderBy('orders_id', 'DESC')
            	 ->where('delivery_phone', 'LIKE', '%' .  $parameter . '%')
            	->where('customers_id', '!=', '')
            	->paginate(40);
            	
            	$index = 0;
            	$total_price = array();
            	
            	foreach ($orders as $orders_data) {
            		$orders_products = DB::table('orders_products')->sum('final_price');
            	
            		$orders[$index]->total_price = $orders_products;
            	
            		$orders_status_history = DB::table('orders_status_history')
            		->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            		->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            		->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
            		->where('orders_status_description.language_id', '=', $language_id)
            		->where('orders_id', '=', $orders_data->orders_id)
            		->where('role_id', '<=', 2)
            		->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
            	
            		$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            		$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            		$index++;
            	
            	}
            	
            break;
             
           case 'Location':
            $language_id = '1';
           
            $locations =DB::table('location')->where('location_name',$parameter)->first();
            
           $location_id="";
                if($locations){
                $location_id=$locations->id;
                }
                
            $orders = Order::sortable(['orders_id'=>'desc'])
            ->orderBy('orders_id', 'DESC')
            ->where('location_id',$location_id)
            ->where('customers_id', '!=', '')
            ->paginate(40);
           
            $index = 0;
            $total_price = array();
           
            foreach ($orders as $orders_data) {
            $orders_products = DB::table('orders_products')->sum('final_price');
           
            $orders[$index]->total_price = $orders_products;
           
            $orders_status_history = DB::table('orders_status_history')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
            ->where('orders_status_description.language_id', '=', $language_id)
            ->where('orders_id', '=', $orders_data->orders_id)
            ->where('role_id', '<=', 2)
            ->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
           
            $orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            $orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            $index++;
           
            }
           
            break;
             
            default: $orders = $this->paginator();
        }
        return $orders;

    }
    

    public function detail($request){

        $language_id = '1';
        $orders_id = $request->id; 
        $ordersData = array();       
        $subtotal  = 0;
        DB::table('orders')->where('orders_id', '=', $orders_id)
            ->where('customers_id', '!=', '')->update(['is_seen' => 1]);

        $order = DB::table('orders')
            ->LeftJoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders.orders_id')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('users', 'users.id', '=', 'orders.customers_id')
            ->where('orders_status_description.language_id', '=', $language_id)
            ->where('orders_status.role_id', '<=', 2)
            ->where('orders.orders_id', '=', $orders_id)
            
              //fix for displaying by id . for orders status 1 april 2022
              
            //->orderby('orders_status_history.date_added', 'DESC')
             ->orderby('orders_status_history.orders_status_history_id', 'DESC')
            ->get();

        foreach ($order as $data) {
            $orders_id = $data->orders_id;

            $orders_products = DB::table('orders_products')
                ->join('products', 'products.products_id', '=', 'orders_products.products_id')
           //For fetching Individual Product order Status 23-09-2022
                ->leftjoin('product_orders_status', 'product_orders_status.product_orders_status_id', '=', 'orders_products.order_product_status_id') 
                ->LeftJoin('image_categories', function ($join) {
                    $join->on('image_categories.image_id', '=', 'products.products_image')
                        ->where(function ($query) {
                            $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                        });
                })
                ->select('orders_products.*', 'image_categories.path as image','product_orders_status.product_orders_status_name')
                ->where('orders_products.orders_id', '=', $orders_id)->get();
            $i = 0;
            $total_price = 0;
            $total_tax = 0;
            $product = array();
            $subtotal = 0;
            foreach ($orders_products as $orders_products_data) {
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

        $ordersData['orders_data'] = $orders_data;
        $ordersData['total_price'] = $total_price;
        $ordersData['subtotal'] = $subtotal;

        return $ordersData;
    }

    public function currentOrderStatus($request){
        $language_id = 1;
        $status = DB::table('orders_status_history')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->where('orders_status_description.language_id', '=', $language_id)
            ->where('role_id', '<=', 2)
           // ->orderBy('orders_status_history.date_added', 'desc')
           
           //fix for displaying by id . for orders status 1 april 2022
             ->orderBy('orders_status_history.orders_status_history_id', 'desc')
            
            ->where('orders_id', '=', $request->id)->get();
            return $status;
    }
	
	
	public function currentOrderStatusForDeliveryMapping($request){
        $language_id = 1;
        $status = DB::table('orders_status_history')
            ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
           
           ->LeftJoin('users', 'orders_status_history.status_updated_user_id', '=', 'users.id')
      //  ->select('orders_status.orders_status_name','orders_status_history.*', 'users.id as updateduser where users.id=orders_status_history.status_updated_user_id','users.id as deliveryboy where users.id=orders_status_history.status_updated_user_id')
            ->where('orders_status_description.language_id', '=', $language_id)
            ->where('orders_status.role_id', '<=', 2)
             ->orderBy('orders_status_history.date_added', 'desc')
            ->where('orders_status_history.orders_id', '=', $request->id)->get();
            return $status;
    }

    public function orderStatuses(){
        $language_id = 1;
        $status = DB::table('orders_status')
                ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
                ->where('orders_status_description.language_id', '=', $language_id)->where('role_id', '<=', 2)->get();
        return $status;
    }
    
    
    public function productorderStatuses(){
    	$language_id = 1;
    	$status = DB::table('product_orders_status')->get();
    	return $status;
    }

    public function updateRecord($request){
        $date_added = date('Y-m-d h:i:s');
        $orders_status = $request->orders_status;
        $old_orders_status = $request->old_orders_status;

        $comments = $request->comments;
        $orders_id = $request->orders_id;
               $customerID  =  auth()->user()->id;


        $status = DB::table('orders_status')->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->where('orders_status_description.language_id', '=', 1)->where('role_id', '<=', 2)
            ->where('orders_status_description.orders_status_id', '=', $orders_status)
            ->get();


DB::table('orders_status_history')->where('orders_id',$orders_id)->update(
                    ['current_status'=> 0 ]);

        //orders status history
        $orders_history_id = DB::table('orders_status_history')->insertGetId(
            ['orders_id' => $orders_id,
                'orders_status_id' => $orders_status,
                'date_added' => $date_added,
                'customer_notified' => '1',
                'order_comments' => $comments,
            'status_updated_user_id' => $customerID,
            'deliveryboy_user_id' => 'Delivery Boy Not Assigned',
            'current_status'=> 1


            ]);


// 2 is completed....
        if ($orders_status == '2') {

            $orders_products = DB::table('orders_products')->where('orders_id', '=', $orders_id)->get();

            foreach ($orders_products as $products_data) {
                DB::table('products')->where('products_id', $products_data->products_id)->update([
                    'products_quantity' => DB::raw('products_quantity - "' . $products_data->products_quantity . '"'),
                    'products_ordered' => DB::raw('products_ordered + 1'),
                ]);
            }
            
            
            
     //after completing the order status success create the cashback
           
            $orders_data = DB::table('orders')->where('orders_id', '=', $orders_id)->first();
           
            $total_price = $orders_data->order_price;
           
           $customers_id = $orders_data->customers_id;
           
           $customers_data = DB::table('users')->where('id', '=', $customers_id)->first();
           
          $customers_type = $customers_data->customer_type;
           
        $min_cart_value = DB::table('reward_points')
            ->where('min_cart_value',"<=",$total_price)
            ->orderBy("min_cart_value", "DESC")
            ->first();
             
            $reedem_values = DB::table('reedem_values')
                ->first();
           
            if($min_cart_value){
           
            $reward_points= $min_cart_value->reward_point;
           
            $cashbackamount= $reward_points * $reedem_values->value;
             
           
     if($customers_type=="BUSINESSOWNER"){
            DB::table('orders')
->where('customers_id','=',$customers_id)
            ->where('orders_id', '=', $orders_id)
            ->update(['reward_points' => $reward_points,
            'cashback_amount' => $cashbackamount]);


            }

           
           
            }
            //end after completing the order status success create the cashback

            
            
            
            
        }

        if ($orders_status == '3') {

            $orders_products = DB::table('orders_products')->where('orders_id', '=', $orders_id)->get();

            foreach ($orders_products as $products_data) {

                $product_detail = DB::table('products')->where('products_id', $products_data->products_id)->first();
                $date_added = date('Y-m-d h:i:s');
                $inventory_ref_id = DB::table('inventory')->insertGetId([
                    'products_id' => $products_data->products_id,
                    'stock' => $products_data->products_quantity,
                    'admin_id' => auth()->user()->id,
                    'created_at' => $date_added,
                    'stock_type' => 'in',

                ]);
                //dd($product_detail);
                if ($product_detail->products_type == 1) {
                    $product_attribute = DB::table('orders_products_attributes')
                        ->where([
                            ['orders_products_id', '=', $products_data->orders_products_id],
                            ['orders_id', '=', $products_data->orders_id],
                        ])
                        ->get();

                    foreach ($product_attribute as $attribute) {
                        //dd($attribute->products_options,$attribute->products_options_values);
                        $prodocuts_attributes = DB::table('products_attributes')
                            ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_attributes.options_id')
                            ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'options_values_id')
                            ->where('products_options_values_descriptions.options_values_name', $attribute->products_options_values)
                            ->where('products_options_descriptions.options_name', $attribute->products_options)
                            ->select('products_attributes.products_attributes_id')
                            ->first();

                        DB::table('inventory_detail')->insert([
                            'inventory_ref_id' => $inventory_ref_id,
                            'products_id' => $products_data->products_id,
                            'attribute_id' => $prodocuts_attributes->products_attributes_id,
                        ]);

                    }

                }
            }
            
            
            // if The order is canceled The cashback will be 0
            $orders_data = DB::table('orders')->where('orders_id', '=', $orders_id)->first();
             
            $total_price = $orders_data->order_price;
             
            $customers_id = $orders_data->customers_id;
            
            $customers_id = $orders_data->customers_id;
             
            $customers_data = DB::table('users')->where('id', '=', $customers_id)->first();
             
            
            DB::table('orders')
            ->where('customers_id','=',$customers_id)
            ->where('orders_id', '=', $orders_id)
            ->update(['reward_points' => 0,
            		'cashback_amount' => 0]);
            // if The order is canceled The cashback will be 0
            
        }

        $orders = DB::table('orders')->where('orders_id', '=', $orders_id)
            ->where('customers_id', '!=', '')->get();

        $data = array();
        $data['customers_id'] = $orders[0]->customers_id;
        $data['orders_id'] = $orders_id;
        $data['status'] = $status[0]->orders_status_name;

        return 'success';
    }    


    //
    public function fetchorder($request)
    {
        $reportBase = $request->reportBase;
        $language_id = '1';
        $orders = DB::table('orders')
            ->LeftJoin('currencies', 'currencies.code', '=', 'orders.currency')
            ->get();

        $index = 0;
        $total_price = array();
        foreach ($orders as $orders_data) {
            $orders_products = DB::table('orders_products')
                ->select('final_price', DB::raw('SUM(final_price) as total_price'))
                ->where('orders_id', '=', $orders_data->orders_id)
                ->groupBy('final_price')
                ->get();

            $orders[$index]->total_price = $orders_products[0]->total_price;

            $orders_status_history = DB::table('orders_status_history')
                ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
                ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
                ->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
                ->where('orders_id', '=', $orders_data->orders_id)
                ->where('orders_status_description.language_id', '=', $language_id)
                ->where('role_id', '<=', 2)
                ->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();

            $orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            $orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;

            $index++;
        }

        $compeleted_orders = 0;
        $pending_orders = 0;
        foreach ($orders as $orders_data) {

            if ($orders_data->orders_status_id == '2') {
                $compeleted_orders++;
            }
            if ($orders_data->orders_status_id == '1') {
                $pending_orders++;
            }
        }

        $result['orders'] = $orders->chunk(10);
        $result['pending_orders'] = $pending_orders;
        $result['compeleted_orders'] = $compeleted_orders;
        $result['total_orders'] = count($orders);

        $result['inprocess'] = count($orders) - $pending_orders - $compeleted_orders;
        //add to cart orders
        $cart = DB::table('customers_basket')->get();

        $result['cart'] = count($cart);

        //Rencently added products
        $recentProducts = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('products_description.language_id', '=', $language_id)
            ->orderBy('products.products_id', 'DESC')
            ->paginate(8);

        $result['recentProducts'] = $recentProducts;

        //products
        $products = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('products_description.language_id', '=', $language_id)
            ->orderBy('products.products_id', 'DESC')
            ->get();

        //low products & out of stock
        $lowLimit = 0;
        $outOfStock = 0;
        foreach ($products as $products_data) {
            $currentStocks = DB::table('inventory')->where('products_id', $products_data->products_id)->get();
            if (count($currentStocks) > 0) {
                if ($products_data->products_type == 1) {


                } else {
                    $stockIn = 0;

                    foreach ($currentStocks as $currentStock) {
                        $stockIn += $currentStock->stock;
                    }
                    /*print $stocks;
                    print '<br>';*/
                    $orders_products = DB::table('orders_products')
                        ->select(DB::raw('count(orders_products.products_quantity) as stockout'))
                        ->where('products_id', $products_data->products_id)->get();
                    //print($product->products_id);
                    //print '<br>';
                    $stocks = $stockIn - $orders_products[0]->stockout;

                    $manageLevel = DB::table('manage_min_max')->where('products_id', $products_data->products_id)->get();
                    $min_level = 0;
                    $max_level = 0;
                    if (count($manageLevel) > 0) {
                        $min_level = $manageLevel[0]->min_level;
                        $max_level = $manageLevel[0]->max_level;
                    }

                    /*print 'min level'.$min_level;
                    print '<br>';
                    print 'max level'.$max_level;
                    print '<br>';*/

                    if ($stocks >= $min_level) {
                        $lowLimit++;
                    }
                    $stocks = $stockIn - $orders_products[0]->stockout;
                    if ($stocks == 0) {
                        $outOfStock++;
                    }

                }
            } else {
                $outOfStock++;
            }
        }

        $result['lowLimit'] = $lowLimit;
        $result['outOfStock'] = $outOfStock;
        $result['totalProducts'] = count($products);

        $customers = DB::table('customers')
            ->LeftJoin('customers_info', 'customers_info.customers_info_id', '=', 'customers.customers_id')
            ->leftJoin('images', 'images.id', '=', 'customers.customers_picture')
            ->leftJoin('image_categories', 'image_categories.image_id', '=', 'customers.customers_picture')
            ->where('image_categories.image_type', '=', 'THUMBNAIL')
            ->select('customers.created_at', 'customers_id', 'customers_firstname', 'customers_lastname', 'customers_dob', 'email', 'user_name', 'customers_default_address_id', 'customers_telephone', 'customers_fax'
                , 'password', 'customers_picture', 'path')
            ->orderBy('customers.created_at', 'DESC')
            ->get();

        $result['recentCustomers'] = $customers->take(6);
        $result['totalCustomers'] = count($customers);
        $result['reportBase'] = $reportBase;

    //  get function from other controller
    //  $myVar = new AdminSiteSettingController();
    //  $currency = $myVar->getSetting();
    //  $result['currency'] = $currency;

        return $result;
    }

    public function deleteRecord($request){
        DB::table('orders')->where('orders_id', $request->orders_id)->delete();
        DB::table('orders_products')->where('orders_id', $request->orders_id)->delete();
        
        
           //Purchase Orders Delete When Order Is Deleted Start
        $purchase_order_details=  DB::table('purchase_orders')->where('orders_id', $request->orders_id)->get();
       
       foreach($purchase_order_details as  $purchase_order_data){
       	DB::table('purchase_orders_products')->where('purchase_orders_id', $purchase_order_data->purchase_orders_id)->delete();
       	DB::table('purchase_orders_products_attributes')->where('purchase_orders_id', $purchase_order_data->purchase_orders_id)->delete();
       	DB::table('purchase_orders_status_history')->where('purchase_orders_id', $purchase_order_data->purchase_orders_id)->delete();
       	 
       }
         
        DB::table('purchase_orders')->where('orders_id', $request->orders_id)->delete();
        //Purchase Orders Delete When Order Is Deleted End
        
        
        return 'success';
    }

    public function reverseStock($request){
        $orders_products = DB::table('orders_products')->where('orders_id', '=', $request->orders_id)->get();

        foreach ($orders_products as $products_data) {

            $product_detail = DB::table('products')->where('products_id', $products_data->products_id)->first();
            //dd($product_detail);
            $date_added = date('Y-m-d h:i:s');
            $inventory_ref_id = DB::table('inventory')->insertGetId([
                'products_id' => $products_data->products_id,
                'stock' => $products_data->products_quantity,
                'admin_id' => auth()->user()->id,
                'created_at' => $date_added,
                'stock_type' => 'in',

            ]);
            //dd($product_detail);
            if ($product_detail->products_type == 1) {
                $product_attribute = DB::table('orders_products_attributes')
                    ->where([
                        ['orders_products_id', '=', $products_data->orders_products_id],
                        ['orders_id', '=', $products_data->orders_id],
                    ])
                    ->get();

                foreach ($product_attribute as $attribute) {
                    $prodocuts_attributes = DB::table('products_attributes')
                        ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_attributes.options_id')
                        ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'options_values_id')
                        ->where('products_options_values_descriptions.options_values_name', $attribute->products_options_values)
                        ->where('products_options_descriptions.options_name', $attribute->products_options)
                        ->select('products_attributes.products_attributes_id')
                        ->first();

                    DB::table('inventory_detail')->insert([
                        'inventory_ref_id' => $inventory_ref_id,
                        'products_id' => $products_data->products_id,
                        'attribute_id' => $prodocuts_attributes->products_attributes_id,
                    ]);

                }

            }
        }
        return 'success';
    }
	
	
	public function deliveryboys($request){
    $language_id = 1;
    $status = DB::table('users')
        ->where('role_id', '=', 4)
    ->get();
    return $status;
    }
   
    public function assigndeliveryboy($request){
    $language_id = 1;
   
    $customerID  =  $request->deliveryboy_user_id;
    $orders_status_history_id = $request->orders_status_history_id;
   
    $status = DB::table('orders_status_history')
    ->where('orders_status_history_id','=', $orders_status_history_id)
    ->update(['deliveryboy_user_id' =>  $customerID]);
     
     // get the order id for all the order details
    $orderhistory=  DB::table('orders_status_history')
    ->where('orders_status_history_id','=', $orders_status_history_id)
    ->first();
     
     
     $orders_id=$orderhistory->orders_id;
     
     
     
      $order=  DB::table('orders')
    ->where('orders_id','=', $orders_id)
    ->first();
     
     $email=$order->email;
     $ordersData['email']=$email;
     	$myVar = new AlertController();
	 		$alertSetting = $myVar->orderAlertDeliveryBoy($ordersData);
     
     
     
    return $status;
    }
    
    
     public function locationbasedorders(){
    
    	$language_id = '1';
    	$user_location_id = auth()->user()->location_id;
    	
    	 
    	
    	$orders = Order::sortable(['orders_id'=>'desc'])->orderBy('orders_id', 'DESC')
    	->where('location_id','=',$user_location_id)
    	->where('customers_id', '!=', '')->paginate(40);
    
    	$index = 0;
    	$total_price = array();
    	
    	foreach ($orders as $orders_data) {
    		$orders_products = DB::table('orders_products')->sum('final_price');
    
    		$orders[$index]->total_price = $orders_products;
    
    		$orders_status_history = DB::table('orders_status_history')
    		->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
    		->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
    		->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
    		->where('orders_status_description.language_id', '=', 1)
    		->where('orders_id', '=', $orders_data->orders_id)
    		->where('role_id', '<=', 2)
    		->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
    
    		$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
    		$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
    		$index++;
    
    	}
    	return $orders;
    }
    
    
    	///Bharath 04-03-2022 Location Based Orders Filter

	 public function locationfilterbycustomerorders($request){

    $filter = $request->FilterBy;
      $parameter = $request->parameter;
        switch ( $filter )
        { 
        	
        	case 'ID':
        		$language_id = '1';
				
				    	$user_location_id = auth()->user()->location_id;

        		$orders = Order::sortable(['orders_id'=>'desc'])
        		->orderBy('orders_id', 'DESC')
				->where('location_id','=',$user_location_id)
        		 ->where('orders_id','=',$parameter)
        		 ->where('customers_id', '!=', '')
        	     ->paginate(10);
        		
        	     
        	     
        		$index = 0;
        		$total_price = array();
        		
        		foreach ($orders as $orders_data) {
        			$orders_products = DB::table('orders_products')->sum('final_price');
        		
        			$orders[$index]->total_price = $orders_products;
        		
        			$orders_status_history = DB::table('orders_status_history')
        			->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
        			->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
        			->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
        			->where('orders_status_description.language_id', '=', $language_id)
        			->where('orders_id', '=', $orders_data->orders_id)
        			->where('role_id', '<=', 2)
        			->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
        		
        			$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
        			$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
        			$index++;
        		
        		}
        	break;
        	
            case 'Name':
            	$language_id = '1';
				$user_location_id = auth()->user()->location_id;

            	$orders = Order::sortable(['orders_id'=>'desc'])
            	->orderBy('orders_id', 'DESC')
								->where('location_id','=',$user_location_id)

            	 ->where('customers_name', 'LIKE', '%' .  $parameter . '%')
            	->where('customers_id', '!=', '')
            	->paginate(40);
            	$index = 0;
            	$total_price = array();
            	
            	foreach ($orders as $orders_data) {
            		$orders_products = DB::table('orders_products')->sum('final_price');
            	
            		$orders[$index]->total_price = $orders_products;
            	
            		$orders_status_history = DB::table('orders_status_history')
            		->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            		->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            		->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
            		->where('orders_status_description.language_id', '=', $language_id)
            		->where('orders_id', '=', $orders_data->orders_id)
            		->where('role_id', '<=', 2)
            		->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
            	
            		$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            		$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            		$index++;
            	
            	}
             

            break;
            
            case 'Phone':
            	$language_id = '1';
				$user_location_id = auth()->user()->location_id;

           $orders = Order::sortable(['orders_id'=>'desc'])
            	->orderBy('orders_id', 'DESC')
								->where('location_id','=',$user_location_id)

            	 ->where('delivery_phone', 'LIKE', '%' .  $parameter . '%')
            	->where('customers_id', '!=', '')
            	->paginate(40);
            	
            	$index = 0;
            	$total_price = array();
            	
            	foreach ($orders as $orders_data) {
            		$orders_products = DB::table('orders_products')->sum('final_price');
            	
            		$orders[$index]->total_price = $orders_products;
            	
            		$orders_status_history = DB::table('orders_status_history')
            		->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
            		->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            		->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
            		->where('orders_status_description.language_id', '=', $language_id)
            		->where('orders_id', '=', $orders_data->orders_id)
            		->where('role_id', '<=', 2)
            		->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();
            	
            		$orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            		$orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            		$index++;
            	
            	}
            	
            break;

             
            default: $orders = $this->paginator();
        }
        return $orders;

    }
	
	 
	
}
