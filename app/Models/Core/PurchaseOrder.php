<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Http\Controllers\App\AlertController;

class PurchaseOrder extends Model
{
	protected $table = 'orders';
	public $sortable = ['orders_id', 'customers_name','date_purchased'];
	
	use Sortable;
	 
    public function purchase_orders($request){
    
    	$language_id = '1';
    	$orders_id = $request->id;
    	
    	$purchase_orders = DB::table('purchase_orders')->where('orders_id',$orders_id)->orderBy('orders_id', 'DESC')
    	->get();

    	$index = 0;
        foreach ($purchase_orders as $purchase_orders_data) {
             
            $orders_status_history = DB::table('purchase_orders_status_history')
                ->LeftJoin('purchase_orders_main_status', 'purchase_orders_main_status.purchase_orders_main_status_id', '=', 'purchase_orders_status_history.purchase_orders_status_id')
                ->where('purchase_orders_id', '=', $purchase_orders_data->purchase_orders_id)
                ->select('purchase_orders_status_history.purchase_orders_status_id','purchase_orders_main_status.purchase_orders_main_status_name')
             	->orderBy('purchase_orders_status_history.purchase_orders_status_history_id', 'DESC')->limit(1)->get();
                   
            $purchase_orders[$index]->purchase_orders_status_id = $orders_status_history[0]->purchase_orders_status_id;
            $purchase_orders[$index]->orders_status = $orders_status_history[0]->purchase_orders_main_status_name;
            
            
            $purchase_orders_tax = DB::table('purchase_orders_products')
           ->where('purchase_orders_id', '=', $purchase_orders_data->purchase_orders_id)
           ->sum('products_tax');
           
            $purchase_orders[$index]->tax = $purchase_orders_tax;
            $purchase_orders[$index]->total_price = $purchase_orders_tax + $purchase_orders_data->distributor_order_price;
             
           /* $distributor_wallet = DB::table('distributor_wallet')
            ->where('purchase_orders_id', '=', $purchase_orders_data->purchase_orders_id)
            ->first();
             
            $purchase_orders[$index]->distributor = $distributor_wallet;
             */
            
            
           $index++;
            
        }
     	return $purchase_orders;
    }
    
    
    public function purchaseorder_detail($request){
    
    	$language_id = '1';
    	$purchase_orders_id = $request->id;
    	$ordersData = array();
    	$subtotal  = 0;
    	DB::table('purchase_orders')->where('purchase_orders_id', '=', $purchase_orders_id)
    	->update(['is_seen' => 1]);
    
    	$order = DB::table('purchase_orders')
    	->LeftJoin('purchase_orders_status_history', 'purchase_orders_status_history.purchase_orders_id', '=', 'purchase_orders.purchase_orders_id')
    	->LeftJoin('purchase_orders_main_status', 'purchase_orders_main_status.purchase_orders_main_status_id', '=', 'purchase_orders_status_history.purchase_orders_status_id')
    	->where('purchase_orders.purchase_orders_id', '=', $purchase_orders_id)
    	->orderBy('purchase_orders_status_history.purchase_orders_status_history_id', 'desc')
    	->select('purchase_orders.*','purchase_orders_status_history.purchase_orders_status_id','purchase_orders_main_status.purchase_orders_main_status_id','purchase_orders_main_status.purchase_orders_main_status_name')
    	->get();
    
    	foreach ($order as $data) {
    		$purchase_orders_id = $data->purchase_orders_id;
    
    		$purchase_orders_products = DB::table('purchase_orders_products')
    		->join('products', 'products.products_id', '=', 'purchase_orders_products.products_id')
    		->LeftJoin('image_categories', function ($join) {
    			$join->on('image_categories.image_id', '=', 'products.products_image')
    			->where(function ($query) {
    				$query->where('image_categories.image_type', '=', 'THUMBNAIL')
    				->where('image_categories.image_type', '!=', 'THUMBNAIL')
    				->orWhere('image_categories.image_type', '=', 'ACTUAL');
    			});
    		})
    		
    		->Leftjoin('purchase_orders_status', 'purchase_orders_status.purchase_orders_status_id', '=', 'purchase_orders_products.purchase_order_product_status_id')
    		->select('purchase_orders_products.*', 'image_categories.path as image','purchase_orders_status.purchase_orders_status_name')
    		->where('purchase_orders_products.purchase_orders_id', '=', $purchase_orders_id)->get();
    		$i = 0;
    		$total_price = 0;
    		$total_tax = 0;
    		$total_purchase_tax = 0;
    		$product = array();
    		$subtotal = 0;
    		foreach ($purchase_orders_products as $purchase_orders_products_data) {
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
    
    	$ordersData['orders_data'] = $orders_data;
    	$ordersData['total_price'] = $total_price;
    	$ordersData['subtotal'] = $subtotal;
    	
    	$ordersData['total_purchase_tax'] = $total_purchase_tax;
    	 
    	
    
    	return $ordersData;
    }
    
	
}
