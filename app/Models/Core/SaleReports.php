<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\AdminControllers\AlertController;

class SaleReports extends Model
{
    use Sortable;
    public $sortable = ['reviews_id', 'products_id', 'customers_id', 'customers_name', 'reviews_rating', 'reviews_status', 'reviews_read', 'created_at', 'updated_at'];
     public function customersReport($request)
    {
       

        $language_id = '1';
        $report = DB::table('orders');
        if (isset($request->orderid)) {
            $report->where('orders_id', $request->orderid);
        }

        if (isset($request->customers_id)) {
            
            if (isset($request->dateRange)) {
                $range = explode('-', $request->dateRange);

                $startdate = trim($range[0]);
                $enddate = trim($range[1]);

                $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
                $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
                $report->whereBetween('date_purchased', [$dateFrom, $dateTo]);
            }

        
            if (isset($request->orders_status_id)) {

                $orders_status_id = $request->orders_status_id;
                $report->LeftJoin('orders_status_history', function ($join) use ($orders_status_id) {
                    $join->on('orders_status_history.orders_id', '=', 'orders.orders_id')
                        ->orderby('orders_status_history.date_added', 'DESC')->limit(1);
                });

            }
        
            $report->where('customers_id', $request->customers_id);
        }
        $report->orderBy('orders_id','desc');
        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }

        $total_orders_price = $report->sum('order_price');
        // dd($total_orders_price);
        $index = 0;
        $total_price = 0;
        
        foreach ($orders as $orders_data) {
            $orders_status = DB::table('orders_status_history')
                ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
                ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
                ->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
                ->where('orders_status_description.language_id', '=', $language_id)
                ->where('orders_id', '=', $orders_data->orders_id)
                ->where('orders_status.role_id', '<=', 2);
            
            if (isset($request->orders_status_id)) {
                $orders_status->where('orders_status_history.orders_status_id', $request->orders_status_id);
            }

            $orders_status_history = $orders_status->orderby('orders_status_history.orders_status_history_id', 'DESC')->limit(1)->get();

            // $current_boy = DB::table('users')
            //     ->leftjoin('deliveryboy_info', 'users.id', '=', 'deliveryboy_info.users_id')
            //     ->leftjoin('orders_to_delivery_boy', 'orders_to_delivery_boy.deliveryboy_id', '=', 'users.id')
            // ->select('users.id', 'users.first_name', 'users.last_name', 'deliveryboy_info.availability_status')
            //     ->where('orders_to_delivery_boy.orders_id', '=', $orders_data->orders_id)
            //     ->where('users.role_id', 4)
            //     ->where('is_current', 1)
            //     ->first();

            // if ($current_boy) {
            //     $orders[$index]->deliveryboy_name = $current_boy->first_name . ' ' . $current_boy->last_name;
            // } else {
            //     $orders[$index]->deliveryboy_name = '';
            // }
            if(count($orders_status_history) > 0){
                $orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
                $orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            }else{
                unset($orders[$index]);
            }
           
            
            $index++;

        }
        $result = array('orders' => $orders, 'total_price' => $total_orders_price);
        return $result;
    }


public function lowinstock($request)
    {
    $report = DB::table('inventory')
    ->leftjoin('products_description', 'products_description.products_id' ,'=' ,'inventory.products_id')
    ->leftjoin('products', 'inventory.products_id' ,'=' ,'products.products_id')
    ->select('products_description.products_id', 'products_description.products_name','products.products_image','products.products_model')
    ->where('products_description.language_id', 1)
    ->groupby('inventory.products_id')
    ->havingRaw("SUM(IF(stock_type = 'in', stock, 10)) - SUM(IF(stock_type = 'out', stock, 10)) = 0");
   
    if ($request->page and $request->page == 'invioce') {
    $orders = $report->get();
    } else {
    $orders = $report->paginate(50);
    }
   
    return $orders;
   
    }




    public function couponReport($request)
    {
        $report = DB::table('orders');

        if (isset($request->couponcode)) {
            $report->where('coupon_code', $request->couponcode);
        }

        if (isset($request->dateRange)) {
            $range = explode('-', $request->dateRange);

            $startdate = trim($range[0]);
            $enddate = trim($range[1]);

            $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
            $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
            $report->whereBetween('date_purchased', [$dateFrom, $dateTo]);
        }

        $report->select('orders.*')->where('customers_id', '!=', '')->where('coupon_code', '!=', '')->orderby('orders.orders_id', 'ASC')->groupby('orders.orders_id');
        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }

        $total_orders_price = $report->sum('order_price');

        $index = 0;
        $total_price = 0;

        $result = array('orders' => $orders);
        return $result;
    }

    public function customersReportTotal($request)
    {
        $report = DB::table('orders');

        if (isset($request->orderid)) {
            $report->where('orders_id', $request->orderid);
        }

        if (isset($request->customers_id)) {
            $report->where('customers_id', $request->customers_id);
        }

        if (isset($request->dateRange)) {

            $range = explode('-', $request->dateRange);

            $startdate = trim($range[0]);
            $enddate = trim($range[1]);

            $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
            $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
            $report->whereBetween('date_purchased', [$dateFrom, $dateTo]);
        }

        

        if (isset($request->orders_status_id)) {

            $orders_status_id = $request->orders_status_id;
            $report->LeftJoin('orders_status_history', function ($join) use ($orders_status_id) {
                $join->on('orders_status_history.orders_id', '=', 'orders.orders_id')
                    ->orderby('orders_status_history.date_added', 'DESC')->limit(1);
            });

        }

        // $report->groupby('orders.orders_id');

        $prices = $report->sum('order_price');
        return ($prices);
    }

    public function allorderstatuses()
    {
        $statuses = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('languages', 'languages.languages_id', '=', 'orders_status_description.language_id')
            ->where('orders_status_description.language_id', '=', '1')
        // ->where('orders_status.role_id', '=', 2)
            ->orderby('role_id')
            ->get();

        return $statuses;
    }

    public function salesreport($request)
    { 
    	
    	$report = DB::table('orders')
    	->selectRaw("date_purchased,orders_id,count('orders.orders_id') as total_orders,sum(order_price) as total_price");
    	if (isset($request->dateRange)) {
    		$range = explode('-', $request->dateRange);
    	
    		$startdate = trim($range[0]);
    		$enddate = trim($range[1]);
    	
    		$dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
    		$dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
    		$report->whereBetween('date_purchased', [$dateFrom, $dateTo])->groupby(DB::raw('Date(date_purchased)'));
    	}
    	else{
    		$report->whereRaw("date_purchased between (CURDATE() - INTERVAL (select count(orders_id) from orders) DAY)
                        and (CURDATE() - INTERVAL 1 DAY) group by DATE(date_purchased)");
    	}
    	
    	if ($request->page and $request->page == 'invioce') {
    		$orders = $report->get();
    	} else {
    		$orders = $report->paginate(50);
    	}
    	
    	
    	$total_orders_price = DB::table('orders')
    	->sum('order_price');
    	
    	$result = array('orders' => $orders, 'total_price' => $total_orders_price);
    	return $result;
    	
    	
    }

    public function inventoryreport($request)
    {
        $report = DB::table('inventory')
            ->leftjoin('manage_min_max', 'manage_min_max.products_id', '=', 'manage_min_max.products_id')
            ->select('inventory.*', 'manage_min_max.min_level', 'manage_min_max.max_level');

        if (isset($request->products_id)) {
            $report->where('inventory.products_id', $request->products_id);

            if (isset($request->dateRange)) {
                $range = explode('-', $request->dateRange);

                $startdate = trim($range[0]);
                $enddate = trim($range[1]);

                $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
                $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
                $report->whereBetween('created_at', [$dateFrom, $dateTo]);
            }

        } else {
            $report->where('inventory.inventory_ref_id', '');
        }

        if ($request->page and $request->page == 'invioce') {
            $reports = $report->get();
        } else {
            $reports = $report->paginate(50);
        }

        $index = 0;
        foreach ($reports as $data) {

            //current stock
            $prev_stock_in = DB::table('inventory')
                ->where('inventory_ref_id', '<=', $data->inventory_ref_id)
                ->where('stock_type', 'in')
                ->where('inventory.products_id', $request->products_id)
                ->sum('stock');

            $prev_stock_out = DB::table('inventory')
                ->where('inventory_ref_id', '<=', $data->inventory_ref_id)
                ->where('stock_type', 'out')
                ->where('inventory.products_id', $request->products_id)
                ->sum('stock');

            if ($prev_stock_out > 0) {
                $reports[$index]->current_stock = abs($prev_stock_in - $prev_stock_out);
            } else {
                $reports[$index]->current_stock = $prev_stock_in;
            }
            $index++;

        }

        return $reports;

    }

    public function minstock($request)
    {
        $report = DB::table('inventory')
            ->leftjoin('manage_min_max', 'manage_min_max.products_id', '=', 'inventory.products_id')
            ->leftjoin('products_description', 'products_description.products_id', '=', 'inventory.products_id')
            ->select('inventory.products_id', 'products_description.products_name', 'manage_min_max.min_level', DB::raw("( SUM(IF(stock_type = 'in', stock, 0)) -
                    SUM(IF(stock_type = 'out', stock, 0)) ) as 'stocks'", DB::raw("having ( SUM(IF(stock_type = 'in', stock, 0)) -
                    SUM(IF(stock_type = 'out', stock, 0)) )")))
            ->where('manage_min_max.min_level', '>', '0')
            ->where('language_id', 1)
            ->groupby('inventory.products_id');
        //->having(DB::raw("SUM(IF(stock_type = 'in', stock, 0)) - SUM(IF(stock_type = 'out', stock, 0))"))

        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }

        return $orders;

    }

    public function maxstock($request)
    {
        $report = DB::table('inventory')
            ->leftjoin('manage_min_max', 'manage_min_max.products_id', '=', 'inventory.products_id')
            ->leftjoin('products_description', 'products_description.products_id', '=', 'inventory.products_id')
            ->select('inventory.products_id', 'products_description.products_name', 'manage_min_max.max_level', DB::raw("( SUM(IF(stock_type = 'in', stock, 0)) -
                    SUM(IF(stock_type = 'out', stock, 0)) ) as 'stocks'", DB::raw("having ( SUM(IF(stock_type = 'in', stock, 0)) -
                    SUM(IF(stock_type = 'out', stock, 0)) )")))
            ->where('manage_min_max.max_level', '>', '0')
            ->where('language_id', 1)
            ->groupby('inventory.products_id');
            // ->having(DB::raw("(SUM(IF(stock_type = 'in', stock, 0)) - SUM(IF(stock_type = 'out', stock, 0))) >= 123"))
        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }

        return $orders;

    }

    public function outofstock($request)
    {
        $report = DB::table('inventory')
                    ->leftjoin('products_description', 'products_description.products_id' ,'=' ,'inventory.products_id')
                    ->select('products_description.products_id', 'products_description.products_name')
                    ->where('products_description.language_id', 1)
                    ->groupby('inventory.products_id')
                    ->havingRaw("SUM(IF(stock_type = 'in', stock, 0)) - SUM(IF(stock_type = 'out', stock, 0)) = 0");
          
        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }

        return $orders;

    }
    
    public function productsstock(){
    	$setting = new Setting();
    	$myVarsetting = new SiteSettingController($setting);
    	$myVaralter = new AlertController($setting);
    	$language_id      =   '1';
    	$result = array();
    	$message = array();
    	$errorMessage = array();
    	$result['currency'] = $myVarsetting->getSetting();
    	$product = DB::table('products')
    	->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
    	->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
    	->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
    	->LeftJoin('specials', function ($join) {
    
    		$join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
    
    	})
    	->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
    	->where('products_description.language_id', '=', $language_id);
    
    //	$product =  $product->limit(10)->get();
    	//	$product =  $product->get();
        		$product =  $product->paginate(15);
	
    	$result['products'] = $product;
    	$products = $product;
    	$result['message'] = $message;
    	$result['errorMessage'] = $errorMessage;
    	$result2 = array();
    	$index = 0;
    	$stocks = 0;
    	$min_level = 0;
    	$max_level = 0;
    	$purchase_price  = 0;
    	if(count($product)>0){
    		$products_id = $result['products'][0]->products_id;
    		if($result['products'][0]->products_type!=1){
    
    			$currentStocks = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->get();
    			$purchase_price = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->sum('purchase_price');
    
    			if(count($currentStocks)>0){
    				foreach($currentStocks as $currentStock){
    					$stocks += $currentStock->stock;
    				}
    			}
    
    			$manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
    			if(count($manageLevel)>0){
    				$min_level = $manageLevel[0]->min_level;
    				$max_level = $manageLevel[0]->max_level;
    			}
    
    		}
    
    		$result['purchase_price'] = $purchase_price;
    		$result['stocks'] = $stocks;
    		$result['min_level'] = $min_level;
    		$result['max_level'] = $max_level;
    		$products_attribute = DB::table('products_attributes')->where('products_id', '=', 1)->get();
    		$products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    		if(count($products_attribute)>0){
    			$index2 = 0;
    			foreach($products_attribute as $attribute_data){
    				$option_name = DB::table('products_options')
    				->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
    				->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
    				->where('products_options_descriptions.language_id', $language_id)
    				->where('products_options.products_options_id', $attribute_data->options_id)
    				->get();
    				if(count($option_name)>0){
    
    					$temp = array();
    					$temp_option['id'] = $attribute_data->options_id;
    					$temp_option['name'] = $option_name[0]->products_options_name;
    					$attr[$index2]['option'] = $temp_option;
    					// fetch all attributes add join from products_options_values table for option value name
    					$attributes_value_query = DB::table('products_attributes')
    					->where('products_id', '=', $products_id)
    					->where('options_id', '=', $attribute_data->options_id)
    					->get();
    					foreach($attributes_value_query as $products_option_value){
    						$option_value = DB::table('products_options_values')
    						->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
    						->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
    						->where('products_options_values_descriptions.language_id', '=', $language_id)
    						->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
    						->get();
    						if(count($option_value)>0){
    							$attributes = DB::table('products_attributes')
    							->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
    							->get();
    							$temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
    							$temp_i['id'] = $products_option_value->options_values_id;
    							$temp_i['value'] = $option_value[0]->products_options_values_name;
    							$temp_i['price'] = $products_option_value->options_values_price;
    							$temp_i['price_prefix'] = $products_option_value->price_prefix;
    							array_push($temp,$temp_i);
    						}
    
    					}
    
    					$attr[$index2]['values'] = $temp;
    					$result['attributes'] = 	$attr;
    					$index2++;
    
    				}
    			}
    
    		}else{
    			$result['attributes'] = 	array();
    		}
    
    	}else{
    		$result['attributes'] = 	array();
    	}
    
    	return $result;
    }
    
     public static function ajax_attr($id){
    	 
    	$language_id      =   '1';
    	$products_id      =   $id;
     
    
     
     
    	$products_attribute = DB::table('products_attributes')->where('products_id', '=', $products_id)->get();
    	$products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    	if(count($products_attribute)>0){
    		$index2 = 0;
    		foreach($products_attribute as $attribute_data){
    			$option_name = DB::table('products_options')
    			->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
    			->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
    			->where('products_options_descriptions.language_id', $language_id)
    			->where('products_options.products_options_id', $attribute_data->options_id)
    			->get();
    			if(count($option_name)>0){
    
    				$temp = array();
    				$temp_option['id'] = $attribute_data->options_id;
    				$temp_option['name'] = $option_name[0]->products_options_name;
    				$attr[$index2]['option'] = $temp_option;
    				// fetch all attributes add join from products_options_values table for option value name
    				$attributes_value_query = DB::table('products_attributes')
    				->where('products_id', '=', $products_id)
    				->where('options_id', '=', $attribute_data->options_id)
    				->get();
    				foreach($attributes_value_query as $products_option_value){
    					$option_value = DB::table('products_options_values')
    					->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
    					->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
    					->where('products_options_values_descriptions.language_id', '=', $language_id)
    					->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
    					->get();
    					if(count($option_value)>0){
    						$attributes = DB::table('products_attributes')
    						->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
    						->get();
    						$temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
    						$temp_i['id'] = $products_option_value->options_values_id;
    						$temp_i['value'] = $option_value[0]->products_options_values_name;
    						$temp_i['price'] = $products_option_value->options_values_price;
    						$temp_i['price_prefix'] = $products_option_value->price_prefix;
    						array_push($temp,$temp_i);
    					}
    
    				}
    
    				$attr[$index2]['values'] = $temp;
    				$result['attributes'] = 	$attr;
    				$index2++;
    
    			}
    		}
    
    	}else{
    
    		$result['attributes'] = 	array();
    
    	}
    	return $result;
    }
    
    
    public static function ajax_min_max($id){
//     	$setting = new Setting();
//     	$myVarsetting = new SiteSettingController($setting);
//     	$myVaralter = new AlertController($setting);
    	$language_id      =   '1';
    	$products_id      =   $id;
    	$result = array();
    	$message = array();
    	$errorMessage = array();
    	
//     	$result['currency'] = $myVarsetting->getSetting();
    	$product = DB::table('products')
    	->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
    	->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
    	->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
    	->LeftJoin('specials', function ($join) {
    
    		$join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
    
    	})
    	->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
    	->where('products_description.language_id', '=', $language_id);
    
    
    	if ($products_id != null) {
    
    		$product->where('products.products_id', '=', $products_id);
    
    	} else {
    
    		$product->orderBy('products.products_id', 'DESC');
    
    	}
    
    
    	$product =  $product->get();
    	 
    	$result['products'] = $product;
    	
    	 
    	$result['products_id'] = $products_id;
    	$products = $product;
    	$result['message'] = $message;
    	$result['errorMessage'] = $errorMessage;
    	$result2 = array();
    	$index = 0;
    	$stocks = 0;
    	$min_level = 0;
    	$max_level = 0;
    	$stockOut = 0;
    	$purchase_price = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->sum('purchase_price');
    
    	if($result['products'][0]->products_type!=1){
    
    		$stocksin = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'in')->sum('stock');
    		$stockOut = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'out')->sum('stock');
    		$stocks = $stocksin - $stockOut;
    
    		$manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
    		if(count($manageLevel)>0){
    			$min_level = $manageLevel[0]->min_level;
    			$max_level = $manageLevel[0]->max_level;
    		}
    
    	}
     
    	//$result['purchase_price'] = $purchase_price;
    	
    	$result['product_price'] = $result['products'][0]->products_price;
    	
    	$result['stockOut'] = $stockOut;
    	$result['billing_price'] = $result['products'][0]->products_price * $stockOut;
    	$result['stocks'] = $stocks;
    	$result['min_level'] = $min_level;
    	$result['max_level'] = $max_level;
    	$products_attribute = DB::table('products_attributes')->where('products_id', '=', $products_id)->get();
    	$products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    	if(count($products_attribute)>0){
    		$index2 = 0;
    		foreach($products_attribute as $attribute_data){
    			$option_name = DB::table('products_options')
    			->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
    			->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
    			->where('products_options_descriptions.language_id', $language_id)
    			->where('products_options.products_options_id', $attribute_data->options_id)
    			->get();
    			if(count($option_name)>0){
    
    				$temp = array();
    				$temp_option['id'] = $attribute_data->options_id;
    				$temp_option['name'] = $option_name[0]->products_options_name;
    				$attr[$index2]['option'] = $temp_option;
    				// fetch all attributes add join from products_options_values table for option value name
    				$attributes_value_query = DB::table('products_attributes')
    				->where('products_id', '=', $products_id)
    				->where('options_id', '=', $attribute_data->options_id)
    				->get();
    				foreach($attributes_value_query as $products_option_value){
    					$option_value = DB::table('products_options_values')
    					->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
    					->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
    					->where('products_options_values_descriptions.language_id', '=', $language_id)
    					->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
    					->get();
    					if(count($option_value)>0){
    						$attributes = DB::table('products_attributes')
    						->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
    						->get();
    						$temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
    						$temp_i['id'] = $products_option_value->options_values_id;
    						$temp_i['value'] = $option_value[0]->products_options_values_name;
    						$temp_i['price'] = $products_option_value->options_values_price;
    						$temp_i['price_prefix'] = $products_option_value->price_prefix;
    						array_push($temp,$temp_i);
    					}
    
    				}
    
    				$attr[$index2]['values'] = $temp;
    				$result['attributes'] = 	$attr;
    				$index2++;
    
    			}
    		}
    
    	}else{
    
    		$result['attributes'] = 	array();
    
    	}
    	return $result;
    }
    
    
    public static function currentstock($product_id,$attributes){
    	 
    /*	$inventory_ref_id = 0;
    	//$products_id = $request->products_id;
    	$products_id = 14;
//     	$attributes = array_filter($request->attributeid);

//$attributes = array("24", "26");
$attributes=array();
    $attributes[0] = "24";
         $attributes[1] = "26";
		 
		 
    	 $attributes = array_filter($attributeid);
    	$attributeid = implode(',',$attributes);
    	$postAttributes = 2;
   */
   
    // $attributeid=array();
    // $attributeid[0] = $attribute1;
      //   $attributeid[1] = $attribute2;
		// $attributeid = [24, 26];
     	$inventory_ref_id = 0;
    	 $products_id = $product_id;
    	//$products_id = 14;
    	$attributes = array_filter($attributes);
//echo $attributeid;
//die;

    	//$attributes = array_filter($attributeid);
		//print_r($attributeid);
		//die;
	//	$attributes=$attributeid;
    	$attributeid = implode(',',$attributes);
    	$postAttributes = count($attributes);
		
		/*
		foreach($attributes as $attribute){
			echo $attribute;
		}
		*/
		 

    
    	$inventory = DB::table('inventory')->where('products_id', $products_id)->where('stock_type', 'in')->get();
    	
    	
    	$reference_ids =array();
    	$stockIn = 0;
    	$purchasePrice = 0;
    	
    	
    	foreach($inventory as $inventory){
    		$totalAttribute = DB::table('inventory_detail')->where('inventory_detail.inventory_ref_id', '=', $inventory->inventory_ref_id)->get();
    		$totalAttributes = count($totalAttribute);
    
    		if($postAttributes>$totalAttributes){
    			$count = $postAttributes;
    		}elseif($postAttributes<$totalAttributes or $postAttributes==$totalAttributes){
    			$count = $totalAttributes;
    		}
    
    		$individualStock = DB::table('inventory')->leftjoin('inventory_detail', 'inventory_detail.inventory_ref_id', '=', 'inventory.inventory_ref_id')
    		->selectRaw('inventory.*')
    		->whereIn('inventory_detail.attribute_id', [$attributeid])
    		->where(DB::raw('(select count(*) from `inventory_detail` where `inventory_detail`.`attribute_id` in (' . $attributeid . ') and `inventory_ref_id`= "' . $inventory->inventory_ref_id . '")'), '=', $count)
    		->where('inventory.inventory_ref_id', '=', $inventory->inventory_ref_id)
    		->get();
    
    		if(count($individualStock) > 0 ){
    
    			$inventory_ref_id = $individualStock[0]->inventory_ref_id;
    			$stockIn += $individualStock[0]->stock;
    			$purchasePrice += $individualStock[0]->purchase_price;
    
    		}
    	}
    	
    	
    
    	$options_names  = array();
    	$options_values = array();
    	foreach($attributes as $attribute){
    		$productsAttributes = DB::table('products_attributes')
    		->leftJoin('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
    		->leftJoin('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
    		->select('products_attributes.*', 'products_options.products_options_name as options_name', 'products_options_values.products_options_values_name as options_values')
    		->where('products_attributes_id', $attribute)->get();
    		$options_names[] = $productsAttributes[0]->options_name;
    		$options_values[] = $productsAttributes[0]->options_values;
    	}
    	
    	 
    
    	$options_names_count = count($options_names);
    	$options_names = implode ( "','", $options_names);
    	$options_names = "'" . $options_names . "'";
    	$options_values = "'" . implode ( "','", $options_values ) . "'";
    	$orders_products = DB::table('orders_products')->where('products_id', $products_id)->get();
    	$stockOut = 0;
    	$purchaseprice = 0;
    	foreach($orders_products as $orders_product){
    		$totalAttribute = DB::table('orders_products_attributes')->where('orders_products_id', '=', $orders_product->orders_products_id)->get();
    		$totalAttributes = count($totalAttribute);
    		if($postAttributes>$totalAttributes){
    			$count = $postAttributes;
    		}elseif($postAttributes<$totalAttributes or $postAttributes==$totalAttributes){
    			$count = $totalAttributes;
    		}
    		$products = DB::select("select orders_products.* from `orders_products` left join `orders_products_attributes` on `orders_products_attributes`.`orders_products_id` = `orders_products`.`orders_products_id` where `orders_products`.`products_id`='".$products_id."' and `orders_products_attributes`.`products_options` in (".$options_names.") and `orders_products_attributes`.`products_options_values` in (".$options_values.") and (select count(*) from `orders_products_attributes` where `orders_products_attributes`.`products_id` = '".$products_id."' and `orders_products_attributes`.`products_options` in (".$options_names.") and `orders_products_attributes`.`products_options_values` in (".$options_values.") and `orders_products_attributes`.`orders_products_id`= '".$orders_product->orders_products_id."') = ".$count." and `orders_products`.`orders_products_id` = '".$orders_product->orders_products_id."' group by `orders_products_attributes`.`orders_products_id`");
    		if(count($products)>0){
    			$stockOut += $products[0]->products_quantity;
    			$purchaseprice=$orders_product->products_price;
    		}
    	}
    	
     
    	
    	$result = array();
    	$result['options_values']=$options_values;
    	   $result['purchasePrice'] = $purchaseprice;
    	//$result['remainingStock'] = $stockIn - $stockOut;
    	  $result['stockOut']=$stockOut;
    	 
    	 $result['Billing Price'] = $purchaseprice *$stockOut;
    	
    
    	if(!empty($inventory_ref_id)){
    		$inventory_ref_id = $inventory_ref_id;
    		$minMax = DB::table('manage_min_max')->where([['inventory_ref_id', $inventory_ref_id], ['products_id', $products_id]])->get();
    
    	}else{
    		$minMax = '';
    	}
    
    //	$result['inventory_ref_id'] = $inventory_ref_id;
    	//$result['products_id'] = $products_id;
    //	$result['minMax'] = $minMax;
    	//$result['options_values']=$options_values;
    	
    	return $result;
		
		 
    }
    
    
     
    public function locationproductsstock(){
    	$user_location_id = auth()->user()->location_id;
    	 
    	$setting = new Setting();
    	$myVarsetting = new SiteSettingController($setting);
    	$myVaralter = new AlertController($setting);
    	$language_id      =   '1';
    	$result = array();
    	$message = array();
    	$errorMessage = array();
    	$result['currency'] = $myVarsetting->getSetting();
    	$product = DB::table('products')
    	->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
    	->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
    	->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
    	->LeftJoin('specials', function ($join) {
    
    		$join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
    
    	})
    	->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
    	->where('products_description.language_id', '=', $language_id)
    	->where('products.location_id', '=', $user_location_id);
    	//	$product =  $product->limit(10)->get();
    	//	$product =  $product->get();
    	$product =  $product->paginate(15);
    
    	$result['products'] = $product;
    	$products = $product;
    	$result['message'] = $message;
    	$result['errorMessage'] = $errorMessage;
    	$result2 = array();
    	$index = 0;
    	$stocks = 0;
    	$min_level = 0;
    	$max_level = 0;
    	$purchase_price  = 0;
    	if(count($product)>0){
    		$products_id = $result['products'][0]->products_id;
    		if($result['products'][0]->products_type!=1){
    
    			$currentStocks = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->get();
    			$purchase_price = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->sum('purchase_price');
    
    			if(count($currentStocks)>0){
    				foreach($currentStocks as $currentStock){
    					$stocks += $currentStock->stock;
    				}
    			}
    
    			$manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
    			if(count($manageLevel)>0){
    				$min_level = $manageLevel[0]->min_level;
    				$max_level = $manageLevel[0]->max_level;
    			}
    
    		}
    
    		$result['purchase_price'] = $purchase_price;
    		$result['stocks'] = $stocks;
    		$result['min_level'] = $min_level;
    		$result['max_level'] = $max_level;
    		$products_attribute = DB::table('products_attributes')->where('products_id', '=', 1)->get();
    		$products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    		if(count($products_attribute)>0){
    			$index2 = 0;
    			foreach($products_attribute as $attribute_data){
    				$option_name = DB::table('products_options')
    				->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
    				->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
    				->where('products_options_descriptions.language_id', $language_id)
    				->where('products_options.products_options_id', $attribute_data->options_id)
    				->get();
    				if(count($option_name)>0){
    
    					$temp = array();
    					$temp_option['id'] = $attribute_data->options_id;
    					$temp_option['name'] = $option_name[0]->products_options_name;
    					$attr[$index2]['option'] = $temp_option;
    					// fetch all attributes add join from products_options_values table for option value name
    					$attributes_value_query = DB::table('products_attributes')
    					->where('products_id', '=', $products_id)
    					->where('options_id', '=', $attribute_data->options_id)
    					->get();
    					foreach($attributes_value_query as $products_option_value){
    						$option_value = DB::table('products_options_values')
    						->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
    						->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
    						->where('products_options_values_descriptions.language_id', '=', $language_id)
    						->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
    						->get();
    						if(count($option_value)>0){
    							$attributes = DB::table('products_attributes')
    							->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
    							->get();
    							$temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
    							$temp_i['id'] = $products_option_value->options_values_id;
    							$temp_i['value'] = $option_value[0]->products_options_values_name;
    							$temp_i['price'] = $products_option_value->options_values_price;
    							$temp_i['price_prefix'] = $products_option_value->price_prefix;
    							array_push($temp,$temp_i);
    						}
    
    					}
    
    					$attr[$index2]['values'] = $temp;
    					$result['attributes'] = 	$attr;
    					$index2++;
    
    				}
    			}
    
    		}else{
    			$result['attributes'] = 	array();
    		}
    
    	}else{
    		$result['attributes'] = 	array();
    	}
    
    	return $result;
    }
    

}
