<?php

namespace App\Models\AppModels;

use App\Models\Web\Index;
use App\Models\AppModels\Product;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Session;
use App\Http\Controllers\App\AppSettingController;

class MobileCart extends Model
{
    
   
	 public function viewmobilecart($request)
    {
        
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        
        if (1) {
            
         if (empty($request->customers_id)) 
         {
          //$device_id =  $request->device_id;
             $result = MobileCart::showCartByDeviceId($request);
          } 
         else
          {
          //  $customers_id = $request->customers_id;
              $result = MobileCart::showCartByCustomerId($request);
            }
            
            
            
            return ($result);
        }
        else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
    
        
    }
    
    
    
    
    public function showCartByCustomerId($request)
	{
		
		
		$consumer_data = array();
		$consumer_data['consumer_key'] = request()->header('consumer-key');
		$consumer_data['consumer_secret'] = request()->header('consumer-secret');
		$consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
		$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
		$consumer_data['consumer_ip'] = request()->header('consumer-ip');
		$consumer_data['consumer_url'] = __FUNCTION__;
		
		$authController = new AppSettingController();
		$authenticate = $authController->apiAuthenticate($consumer_data);
		
		if ( 1) {
		 
		$cart = DB::table('customers_basket')
		->join('products', 'products.products_id', '=', 'customers_basket.products_id')
		->join('products_description', 'products_description.products_id', '=', 'products.products_id')
		->LeftJoin('image_categories', function ($join) {
			$join->on('image_categories.image_id', '=', 'products.products_image')
			->where(function ($query) {
				$query->where('image_categories.image_type', '=', 'THUMBNAIL')
				->where('image_categories.image_type', '!=', 'THUMBNAIL')
				->orWhere('image_categories.image_type', '=', 'ACTUAL');
			});
		})
		->select('customers_basket.*',
				'image_categories.path as image_path', 'products.products_model as model',
				'products.products_type as products_type', 'products.products_min_order as min_order', 'products.products_max_stock as max_order',
				'products.products_image as image',
				'products.distributor_product_price_percentage as distributor_product_price_percentage','products.hsn_sac_code as hsn_sac_code',
				'products_description.products_name as products_name', 'products.products_price as price', 'products.distributor_product_price as distributor_product_price','products.distributor_id as distributor_id',
				'products.products_weight as weight', 'products.products_weight_unit as unit', 'products.products_slug')
				->where([
						['customers_basket.is_order', '=', '0'],
						['products_description.language_id', '=', $request->language_id],
				]);
	
// 				if (empty(session('customers_id'))) {
// 					$cart->where('customers_basket.session_id', '=', Session::getId());
// 				} else {
// 					$cart->where('customers_basket.customers_id', '=', session('customers_id'));
// 				}
				 				$cart->where('customers_basket.customers_id', '=', $request->customers_id);
				
			/*	if (!empty($request->customers_basket_id)) {
					$cart->where('customers_basket.customers_basket_id', '=', $request->customers_basket_id);
				}*/
	
				$baskit = $cart->get();
				
				
			 
				
				$total_carts = count($baskit);
				$result = array();
				$customers_basket_product=array();
				
				             
				$grand_total_tax=0;
				$index = 0;
				if ($total_carts > 0) {
					foreach ($baskit as $cart_data) {
					    
 
//array_push($customers_basket_product, array('customers_basket_product' => $cart_data));

			//	array_push($result,$customers_basket_product);
	 
					  
				 //  $customers_basket_product['customers_basket_product'] = $cart_data;

		//	 array_push($result, $customers_basket_product);
			//	$customers_basket_product = array('customers_basket_product' => $cart_data);


						//products_image
						$default_images = DB::table('image_categories')
						->where('image_id', '=', $cart_data->image)
						->where('image_type', 'THUMBNAIL')
						->first();
	
						if ($default_images) {
							$cart_data->image_path = $default_images->path;
						} else {
							$default_images = DB::table('image_categories')
							->where('image_id', '=', $cart_data->image)
							->where('image_type', 'Medium')
							->first();
	
							if ($default_images) {
								$cart_data->image_path = $default_images->path;
							} else {
								$default_images = DB::table('image_categories')
								->where('image_id', '=', $cart_data->image)
								->where('image_type', 'ACTUAL')
								->first();
								$cart_data->image_path = $default_images->path;
							}
	
						}
	
	
						//categories
						$categories = DB::table('products_to_categories')
						->leftjoin('categories', 'categories.categories_id', 'products_to_categories.categories_id')
						->leftjoin('categories_description', 'categories_description.categories_id', 'products_to_categories.categories_id')
						->select('categories.categories_id', 'categories_description.categories_name', 'categories.categories_image', 'categories.categories_icon', 'categories.parent_id')
						->where('products_id', '=', $cart_data->products_id)
						->where('categories_description.language_id', '=', $request->language_id)->get();
						if(!empty($categories) and count($categories)>0){
							$cart_data->categories = $categories;
						}else{
							$cart_data->categories = array();
						}
						
			 		$products = DB::table('products')
                        ->LeftJoin('tax_rates', 'tax_rates.tax_class_id', '=', 'products.products_tax_class_id')
                        ->where('products_id', $cart_data->products_id)->first();
                        $product_total_price=$cart_data->final_price*$cart_data->customers_basket_quantity;
                        $tax_value = $product_total_price + $product_total_price * $products->tax_rate / 100 ;
                            
                        $total_tax = $tax_value - $product_total_price;
                        $grand_total_tax= $grand_total_tax + $total_tax;
						  
						   
				 	array_push($result, $cart_data);

				 		 	 
 						//default product
						$stocks = 0;
						if ($cart_data->products_type == '0') {
	
							$currentStocks = DB::table('inventory')->where('products_id', $cart_data->products_id)->get();
							if (count($currentStocks) > 0) {
								foreach ($currentStocks as $currentStock) {
									$stocks += $currentStock->stock;
								}
							}
	
							if (!empty($cart_data->max_order) and $cart_data->max_order != 0) {
								if ($cart_data->max_order >= $stocks) {
									$result[$index]->max_order = $stocks;
								}
							} else {
								$result[$index]->max_order = $stocks;
							}
							
								$result[$index]->individual_product_tax = $total_tax;
							$index++;
	
						} else {
		  
							$attributes = DB::table('customers_basket_attributes')
							->join('products_options', 'products_options.products_options_id', '=', 'customers_basket_attributes.products_options_id')
							->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'customers_basket_attributes.products_options_id')
							->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')
							->leftjoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')
							->leftjoin('products_attributes', function ($join) {
								$join->on('customers_basket_attributes.products_id', '=', 'products_attributes.products_id')->on('customers_basket_attributes.products_options_id', '=', 'products_attributes.options_id')->on('customers_basket_attributes.products_options_values_id', '=', 'products_attributes.options_values_id');
							})
							// ->select('products_options_descriptions.options_name as attribute_name', 'products_options_values_descriptions.options_values_name as attribute_value', 'customers_basket_attributes.products_options_id as options_id', 'customers_basket_attributes.products_options_values_id as options_values_id', 'products_attributes.price_prefix as prefix', 'products_attributes.products_attributes_id as products_attributes_id', 'products_attributes.options_values_price as values_price')
								->select('products_options_descriptions.options_name as attribute_name', 'products_options_values_descriptions.options_values_name as attribute_value', 'customers_basket_attributes.products_options_id as options_id', 'customers_basket_attributes.products_options_values_id as options_values_id', 'products_attributes.price_prefix as prefix', 'products_attributes.products_attributes_id as products_attributes_id', 'products_attributes.options_values_price as values_price','products_attributes.distributor_options_values_price as distributor_options_values_price')
	
								->where('customers_basket_attributes.products_id', '=', $cart_data->products_id)
								->where('customers_basket_id', '=', $cart_data->customers_basket_id)
								->where('products_options_descriptions.language_id', '=', $request->language_id)
								->where('products_options_values_descriptions.language_id', '=', $request->language_id);
	
							//	if (empty(session('customers_id'))) {
								//	$attributes->where('customers_basket_attributes.session_id', '=', Session::getId());
								//} else {
									$attributes->where('customers_basket_attributes.customers_id', '=', $request->customers_id);
							//	}
	
								$attributes_data = $attributes->get();
	
								//if($index==0){
								$products_attributes_id = array();
								//}
	
								foreach ($attributes_data as $attributes_datas) {
									if ($cart_data->products_type == '1') {
										$products_attributes_id[] = $attributes_datas->products_attributes_id;
	
									}
	
								}
								$myVar = new Product();
	
								$qunatity['products_id'] = $cart_data->products_id;
								$qunatity['attributes'] = $products_attributes_id;
 								$content = $myVar->productQuantity($qunatity);
								$stocks = $content['remainingStock'];
								if (!empty($cart_data->max_order) and $cart_data->max_order != 0) {
									if ($cart_data->max_order >= $stocks) {
										$result[$index]->max_order = $stocks;
									}
								} else {
									$result[$index]->max_order = $stocks;
								}
	
								$result[$index]->attributes_id = $products_attributes_id;
	
								$result2 = array();
								if (!empty($cart_data->coupon_id)) {
									//coupon
									$coupons = explode(',', $cart_data->coupon_id);
									$index2 = 0;
									foreach ($coupons as $coupons_data) {
										$coupons = DB::table('coupons')->where('coupans_id', '=', $coupons_data)->get();
										$result2[$index2++] = $coupons[0];
									}
	
								}
	
								$result[$index]->coupons = $result2;
								$result[$index]->productattributes = $attributes_data;
								$result[$index]->individual_product_tax = $total_tax;
							//	$result[$index]->grand_total_tax = $grand_total_tax;
								
								
								$index++;
								
							 //	array_push($result, array('customers_basket_product' => $cart_data));
						}
						
					

					}
									  
//array_push($result, array('grand_total_tax' => $grand_total_tax));
				 
				}
				
			 
				
				$responseData = array('success' => '1', 'data' => $result, 'message' => "Returned all cart products.");
				
			 } else {
          $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
      }
      $categoryResponse = json_encode($responseData);

      return $categoryResponse;
				
				//return ($result);
	}
	
	
	
	public function showCartByDeviceId($request)
	{
	    
	    
	    $consumer_data = array();
	    $consumer_data['consumer_key'] = request()->header('consumer-key');
	    $consumer_data['consumer_secret'] = request()->header('consumer-secret');
	    $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
	    $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
	    $consumer_data['consumer_ip'] = request()->header('consumer-ip');
	    $consumer_data['consumer_url'] = __FUNCTION__;
	    
	    $authController = new AppSettingController();
	    $authenticate = $authController->apiAuthenticate($consumer_data);
	    
	    if ( 1) {
	        
	        $cart = DB::table('customers_basket')
	        ->join('products', 'products.products_id', '=', 'customers_basket.products_id')
	        ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
	        ->LeftJoin('image_categories', function ($join) {
	            $join->on('image_categories.image_id', '=', 'products.products_image')
	            ->where(function ($query) {
	                $query->where('image_categories.image_type', '=', 'THUMBNAIL')
	                ->where('image_categories.image_type', '!=', 'THUMBNAIL')
	                ->orWhere('image_categories.image_type', '=', 'ACTUAL');
	            });
	        })
	        ->select('customers_basket.*',
	            'image_categories.path as image_path', 'products.products_model as model',
	            'products.products_type as products_type', 'products.products_min_order as min_order', 'products.products_max_stock as max_order',
	            'products.products_image as image',
	            'products.distributor_product_price_percentage as distributor_product_price_percentage','products.hsn_sac_code as hsn_sac_code',
	            'products_description.products_name as products_name', 'products.products_price as price', 'products.distributor_product_price as distributor_product_price','products.distributor_id as distributor_id',
	            'products.products_weight as weight', 'products.products_weight_unit as unit', 'products.products_slug')
	            ->where([
	                ['customers_basket.is_order', '=', '0'],
	                ['products_description.language_id', '=', $request->language_id],
	            ]);
	            
	            // 				if (empty(session('customers_id'))) {
	            // 					$cart->where('customers_basket.session_id', '=', Session::getId());
	            // 				} else {
	            // 					$cart->where('customers_basket.customers_id', '=', session('customers_id'));
	            // 				}
	            $cart->where('customers_basket.session_id', '=', $request->device_id);
	                
	                /*	if (!empty($request->customers_basket_id)) {
	                 $cart->where('customers_basket.customers_basket_id', '=', $request->customers_basket_id);
	                 }*/
	                
	                $baskit = $cart->get();
	                
	                
	                
	                
	                $total_carts = count($baskit);
	                $result = array();
	                $customers_basket_product=array();
	                
	                
	                $grand_total_tax=0;
	                $index = 0;
	                if ($total_carts > 0) {
	                    foreach ($baskit as $cart_data) {
	                        
	                        
	                        //array_push($customers_basket_product, array('customers_basket_product' => $cart_data));
	                        
	                        //	array_push($result,$customers_basket_product);
	                        
	                        
	                        //  $customers_basket_product['customers_basket_product'] = $cart_data;
	                        
	                        //	 array_push($result, $customers_basket_product);
	                        //	$customers_basket_product = array('customers_basket_product' => $cart_data);
	                        
	                        
	                        //products_image
	                        $default_images = DB::table('image_categories')
	                        ->where('image_id', '=', $cart_data->image)
	                        ->where('image_type', 'THUMBNAIL')
	                        ->first();
	                        
	                        if ($default_images) {
	                            $cart_data->image_path = $default_images->path;
	                        } else {
	                            $default_images = DB::table('image_categories')
	                            ->where('image_id', '=', $cart_data->image)
	                            ->where('image_type', 'Medium')
	                            ->first();
	                            
	                            if ($default_images) {
	                                $cart_data->image_path = $default_images->path;
	                            } else {
	                                $default_images = DB::table('image_categories')
	                                ->where('image_id', '=', $cart_data->image)
	                                ->where('image_type', 'ACTUAL')
	                                ->first();
	                                $cart_data->image_path = $default_images->path;
	                            }
	                            
	                        }
	                        
	                        
	                        //categories
	                        $categories = DB::table('products_to_categories')
	                        ->leftjoin('categories', 'categories.categories_id', 'products_to_categories.categories_id')
	                        ->leftjoin('categories_description', 'categories_description.categories_id', 'products_to_categories.categories_id')
	                        ->select('categories.categories_id', 'categories_description.categories_name', 'categories.categories_image', 'categories.categories_icon', 'categories.parent_id')
	                        ->where('products_id', '=', $cart_data->products_id)
	                        ->where('categories_description.language_id', '=', $request->language_id)->get();
	                        if(!empty($categories) and count($categories)>0){
	                            $cart_data->categories = $categories;
	                        }else{
	                            $cart_data->categories = array();
	                        }
	                        
	                        $products = DB::table('products')
	                        ->LeftJoin('tax_rates', 'tax_rates.tax_class_id', '=', 'products.products_tax_class_id')
	                        ->where('products_id', $cart_data->products_id)->first();
	                        $product_total_price=$cart_data->final_price*$cart_data->customers_basket_quantity;
	                        $tax_value = $product_total_price + $product_total_price * $products->tax_rate / 100 ;
	                        
	                        $total_tax = $tax_value - $product_total_price;
	                        $grand_total_tax= $grand_total_tax + $total_tax;
	                        
	                        
	                        array_push($result, $cart_data);
	                        
	                        
	                        //default product
	                        $stocks = 0;
	                        if ($cart_data->products_type == '0') {
	                            
	                            $currentStocks = DB::table('inventory')->where('products_id', $cart_data->products_id)->get();
	                            if (count($currentStocks) > 0) {
	                                foreach ($currentStocks as $currentStock) {
	                                    $stocks += $currentStock->stock;
	                                }
	                            }
	                            
	                            if (!empty($cart_data->max_order) and $cart_data->max_order != 0) {
	                                if ($cart_data->max_order >= $stocks) {
	                                    $result[$index]->max_order = $stocks;
	                                }
	                            } else {
	                                $result[$index]->max_order = $stocks;
	                            }
	                            
	                            $result[$index]->individual_product_tax = $total_tax;
	                            $index++;
	                            
	                        } else {
	                            
	                            $attributes = DB::table('customers_basket_attributes')
	                            ->join('products_options', 'products_options.products_options_id', '=', 'customers_basket_attributes.products_options_id')
	                            ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'customers_basket_attributes.products_options_id')
	                            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')
	                            ->leftjoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')
	                            ->leftjoin('products_attributes', function ($join) {
	                                $join->on('customers_basket_attributes.products_id', '=', 'products_attributes.products_id')->on('customers_basket_attributes.products_options_id', '=', 'products_attributes.options_id')->on('customers_basket_attributes.products_options_values_id', '=', 'products_attributes.options_values_id');
	                            })
	                            // ->select('products_options_descriptions.options_name as attribute_name', 'products_options_values_descriptions.options_values_name as attribute_value', 'customers_basket_attributes.products_options_id as options_id', 'customers_basket_attributes.products_options_values_id as options_values_id', 'products_attributes.price_prefix as prefix', 'products_attributes.products_attributes_id as products_attributes_id', 'products_attributes.options_values_price as values_price')
	                                ->select('products_options_descriptions.options_name as attribute_name', 'products_options_values_descriptions.options_values_name as attribute_value', 'customers_basket_attributes.products_options_id as options_id', 'customers_basket_attributes.products_options_values_id as options_values_id', 'products_attributes.price_prefix as prefix', 'products_attributes.products_attributes_id as products_attributes_id', 'products_attributes.options_values_price as values_price','products_attributes.distributor_options_values_price as distributor_options_values_price')
	                                
	                                ->where('customers_basket_attributes.products_id', '=', $cart_data->products_id)
	                                ->where('customers_basket_id', '=', $cart_data->customers_basket_id)
	                                ->where('products_options_descriptions.language_id', '=', $request->language_id)
	                                ->where('products_options_values_descriptions.language_id', '=', $request->language_id);
	                                
	                                //	if (empty(session('customers_id'))) {
	                                //	$attributes->where('customers_basket_attributes.session_id', '=', Session::getId());
	                                //} else {
	                                $attributes->where('customers_basket_attributes.session_id', '=', $request->device_id);
	                                //	}
	                                
	                                $attributes_data = $attributes->get();
	                                
	                                //if($index==0){
	                                $products_attributes_id = array();
	                                //}
	                                
	                                foreach ($attributes_data as $attributes_datas) {
	                                    if ($cart_data->products_type == '1') {
	                                        $products_attributes_id[] = $attributes_datas->products_attributes_id;
	                                        
	                                    }
	                                    
	                                }
	                                $myVar = new Product();
	                                
	                                $qunatity['products_id'] = $cart_data->products_id;
	                                $qunatity['attributes'] = $products_attributes_id;
	                                $content = $myVar->productQuantity($qunatity);
	                                $stocks = $content['remainingStock'];
	                                if (!empty($cart_data->max_order) and $cart_data->max_order != 0) {
	                                    if ($cart_data->max_order >= $stocks) {
	                                        $result[$index]->max_order = $stocks;
	                                    }
	                                } else {
	                                    $result[$index]->max_order = $stocks;
	                                }
	                                
	                                $result[$index]->attributes_id = $products_attributes_id;
	                                
	                                $result2 = array();
	                                if (!empty($cart_data->coupon_id)) {
	                                    //coupon
	                                    $coupons = explode(',', $cart_data->coupon_id);
	                                    $index2 = 0;
	                                    foreach ($coupons as $coupons_data) {
	                                        $coupons = DB::table('coupons')->where('coupans_id', '=', $coupons_data)->get();
	                                        $result2[$index2++] = $coupons[0];
	                                    }
	                                    
	                                }
	                                
	                                $result[$index]->coupons = $result2;
	                                $result[$index]->productattributes = $attributes_data;
	                                $result[$index]->individual_product_tax = $total_tax;
	                                //	$result[$index]->grand_total_tax = $grand_total_tax;
	                                
	                                
	                                $index++;
	                                
	                                //	array_push($result, array('customers_basket_product' => $cart_data));
	                                }
	                                
	                                
	                                
	                    }
	                    
	                    //array_push($result, array('grand_total_tax' => $grand_total_tax));
	                    
	                }
	                
	                
	                
	                $responseData = array('success' => '1', 'data' => $result, 'message' => "Returned all cart products.");
	                
	} else {
	    $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
	}
	$categoryResponse = json_encode($responseData);
	
	return $categoryResponse;
	
	//return ($result);
}
	
 
 
public function addToCart($request)
{
    
    $consumer_data = array();
    $consumer_data['consumer_key'] = request()->header('consumer-key');
    $consumer_data['consumer_secret'] = request()->header('consumer-secret');
    $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
    $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
    $consumer_data['consumer_ip'] = request()->header('consumer-ip');
    $consumer_data['consumer_url'] = __FUNCTION__;
    
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);
    
    if (1) {
        
        if (empty($request->customers_id))
        {
          //  echo "customer:".$request->customers_id;
          //  echo "device:".$request->device_id;
            //$device_id =  $request->device_id;
            $result = MobileCart::addToCartByDeviceId($request);
        }
        else
        {
          //  echo "customer1:".$request->customers_id;
          //  echo "device1:".$request->device_id;
            //  $customers_id = $request->customers_id;
            $result = MobileCart::addToCartByCustomerId($request);
        }
        
        
        
        return ($result);
    }
    else {
        $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
    }
    
    
}
    
public function addToCartByCustomerId($request)
    { 
        
        
     
        $index = new Index();
        $products = new Product();
        
        $products_id = $request->products_id;
        // bHarath 10-02-2022  Product Selected  Attrribute Name
        $product_selected_name= $request->product_selected_name;
        
        $location_id = $request->location_id;
      //  if (empty($request->customers_id)) {
       //     $customers_id = '';
       // } else {
            $customers_id = $request->customers_id;
       // }
            $device_id =  request()->header('consumer-device-id');
        //   $session_id = Session::getId();
        $customers_basket_date_added = date('Y-m-d H:i:s');
        
        
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        
        if (1) {
            
            //         if (!empty($request->limit)) {
            //             $limit = $request->limit;
            //         } else {
            //             $limit = 15;
            //         }
            
            //min_price
            //         if (!empty($request->min_price)) {
            //             $min_price = $request->min_price;
            //         } else {
            //             $min_price = '';
            //         }
                
            //max_price
            //         if (!empty($request->max_price)) {
            //             $max_price = $request->max_price;
            //         } else {
            //             $max_price = '';
            //         }
                
            //         if (empty($customers_id)) {
            
            //             $exist = DB::table('customers_basket')->where([
            //               //  ['session_id', '=', $session_id],
            //                 ['products_id', '=', $products_id],
            //                 ['is_order', '=', 0],
            //             ])->get();
            
            //         } else {
            
            $exist = DB::table('customers_basket')->where([
                ['customers_id', '=', $customers_id],
                ['products_id', '=', $products_id],
                ['is_order', '=', 0],
            ])->get();
            
                      
            //   }
            $isFlash = DB::table('flash_sale')->where('products_id', $products_id)
            ->where('flash_expires_date', '>=', time())->where('flash_status', '=', 1)
            ->get();
            //get products detail  is not default
            if (!empty($isFlash) and count($isFlash) > 0) {
                $type = "flashsale";
            } else {
                $type = "";
            }
            
            $data = array('page_number' => '0', 'type' => $type, 'location_id'=>$location_id,'language_id' => 1,'customers_id' => $customers_id, 'products_id' => $request->products_id, 'limit' => '15', 'min_price' => '', 'max_price' => '');
            $detail = $products->addtocartproductdetails($data);
            
            
            $result['detail'] = $detail;
            
//             if ($result['detail']['product_data'][0]->products_type == 0) {
                
//                 //check lower value to match with added stock
//                 if ($result['detail']['product_data'][0]->products_max_stock != null and $result['detail']['product_data'][0]->products_max_stock < $result['detail']['product_data'][0]->defaultStock) {
//                     $default_stock = $result['detail']['product_data'][0]->products_max_stock;
//                 } else {
//                     $default_stock = $result['detail']['product_data'][0]->defaultStock;
//                 }
                
//                 if (!empty($exist) and count($exist) > 0) {
                    
                    
//                     $count = $exist[0]->customers_basket_quantity + $request->quantity;
//                     $remain = $result['detail']['product_data'][0]->defaultStock - $exist[0]->customers_basket_quantity;
                    
//                     if ($count > $default_stock) {
                        
//                         // return array('status' => 'exceed', 'defaultStock' => $result['detail']['product_data'][0]->defaultStock, 'already_added' => $exist[0]->customers_basket_quantity, 'remain_pieces' => $remain);
//                     }
                    
//                     // if ($count >= $result['detail']['product_data'][0]->defaultStock || $count > $result['detail']['product_data'][0]->products_max_stock and $result['detail']['product_data'][0]->products_max_stock != null) {
                    
//                     //     return array('status' => 'exceed', 'defaultStock' => $result['detail']['product_data'][0]->defaultStock, 'already_added' => $exist[0]->customers_basket_quantity, 'remain_pieces' => $remain);
//                     // }
//                 } else {
                    
//                     //if ($request->quantity > $result['detail']['product_data'][0]->defaultStock || $request->quantity > $result['detail']['product_data'][0]->products_max_stock and $result['detail']['product_data'][0]->products_max_stock != null) {
//                     if ($request->quantity > $default_stock) {
//                         $count = $request->quantity;
//                         $remain = $result['detail']['product_data'][0]->defaultStock - $count;
//                         // return array('status' => 'exceed');
//                     }
//                 }
//         }
        
        
        
        //change of price on the attribute change
        //Bharath  discounted price to change mrp and attribute price value
        $discount_percentage ="";
        
        
        
        if (!empty($result['detail']['product_data'][0]->flash_price)) {
            $final_price = $result['detail']['product_data'][0]->flash_price + 0;
        } elseif (!empty($result['detail']['product_data'][0]->discount_price)) {
            $final_price = $result['detail']['product_data'][0]->discount_price + 0;
            
            
            
            //Bharath  discounted price to change mrp and attribute price value
            $discounted_price = $result['detail']['product_data'][0]->products_price  - $result['detail']['product_data'][0]->discount_price;
            
            $discount_percentage = $discounted_price/$result['detail']['product_data'][0]->products_price*100;
            //Bharath  discounted price to change mrp and attribute price value
            
        } else {
            $final_price = $result['detail']['product_data'][0]->products_price + 0;
        }
        //Bharath  discounted price to change mrp and attribute price value
        $product_price =$result['detail']['product_data'][0]->products_price + 0;
        
        
        $distributor_product_original_price =$result['detail']['product_data'][0]->distributor_product_price + 0;
        $product_distributor_id = $result['detail']['product_data'][0]->distributor_id;
        
        
        
        
        //$variables_prices = 0
        if ($result['detail']['product_data'][0]->products_type == 1) {
            
            
            $attributeid = $request->attributes_id;
            $attribute_price = 0;
            if (!empty($attributeid) && count($attributeid) > 0) {
                
                foreach ($attributeid as $attribute) {
                    $attribute = DB::table('products_attributes')->where('products_attributes_id', $attribute)->first();
                    $symbol = $attribute->price_prefix;
                    $values_price = $attribute->options_values_price;
                    
                    
                    $distributor_options_values_price = $attribute->distributor_options_values_price;
                    
                    
                    
                    /*  if ($symbol == '+') {
                     $final_price = intval($final_price) + intval($values_price);
                     }
                     if ($symbol == '-') {
                     $final_price = intval($final_price) - intval($values_price);
                     }*/
                    
                    
                    
                    //Bharath
                    if ($symbol == '+') {
                        
                        $product_price= $product_price + intval($values_price);
                        $distributor_product_original_price = $distributor_product_original_price +intval($distributor_options_values_price);
                        
                        if($discount_percentage==""){
                            
                            $final_price = $product_price;
                        }else{
                            $discount_price = $product_price - $product_price*$discount_percentage/100;
                            
                            $final_price = $discount_price;
                        }
                        
                        
                    }
                    if ($symbol == '-') {
                        
                        
                        $product_price= $product_price - intval($values_price);
                        $distributor_product_original_price = $distributor_product_original_price - intval($distributor_options_values_price);
                        
                        if($discount_percentage==""){
                            
                            $final_price = $product_price;
                        }else{
                            $discount_price = $product_price - $product_price*$discount_percentage/100;
                            
                            
                            $final_price = $discount_price;
                            
                        }
                        //Bharath
                        
                        
                    }
                    
                    
                }
               
            }
            
        }
        
//         //check quantity
//         if ($result['detail']['product_data'][0]->products_type == 1) {
//             $qunatity['products_id'] = $request->products_id;
//             $qunatity['attributes'] = $attributeid;
            
//             $content = $products->productQuantity($qunatity);
//             //dd($content);
//             $stocks = $content['remainingStock'];
            
//         } else {
//             $stocks = $result['detail']['product_data'][0]->defaultStock;
            
//         }
        
//         if ($stocks <= $result['detail']['product_data'][0]->products_max_stock or $result['detail']['product_data'][0]->products_max_stock ==0) {
//             $stocksToValid = $stocks;
//         } else {
            $stocksToValid = $result['detail']['product_data'][0]->products_max_stock;
//         }
        
        //check variable stock limit
        if (!empty($exist) and count($exist) > 0) {
            $count = $exist[0]->customers_basket_quantity + $request->customers_basket_quantity;
            if ($count > $stocksToValid) {
                //    return array('status' => 'exceed');
                $responseData = array('success' => '1',  'status' => "exceed");
                
            }
        }
        
        if (empty($request->customers_basket_quantity)) {
            $customers_basket_quantity = 1;
        } else {
            $customers_basket_quantity = $request->customers_basket_quantity;
        }
        
        if ($stocksToValid > $customers_basket_quantity) {
            $customers_basket_quantity = $result['detail']['product_data'][0]->products_min_order;
        }
        
        //quantity is not default
        if (empty($request->quantity)) {
            $customers_basket_quantity = 1;
        } else {
            $customers_basket_quantity = $request->quantity;
        }
        
        
     /*   if ($request->customers_basket_id) {
            
            
            $basket_id = $request->customers_basket_id;
            DB::table('customers_basket')->where('customers_basket_id', '=', $basket_id)->update(
                [
                    'customers_id' => $customers_id,
                    'products_id' => $products_id,
                    'product_selected_name' => $product_selected_name,
                    'session_id' => $device_id,
                 //   'customers_basket_quantity' => $customers_basket_quantity,
                                                 'customers_basket_quantity' => DB::raw('customers_basket_quantity+' . $customers_basket_quantity),

                    'final_price' => $final_price,
                    'distributor_final_price' => $distributor_product_original_price,
                    'distributor_id'=>$product_distributor_id,
                    'customers_basket_date_added' => $customers_basket_date_added,
                ]);
            
            if (count($request->productattributes) > 0) {
                foreach ($request->productattributes as $option_id) {
                    
                    
                    DB::table('customers_basket_attributes')->where([
                        ['customers_basket_id', '=', $basket_id],
                        ['products_id', '=', $products_id],
                        ['products_options_id', '=', $option_id['options_id']],
                    ])->update(
                        [
                            'customers_id' => $customers_id,
                            'products_options_values_id' => $option_id['options_values_id'],
                            'session_id' => $device_id,
                        ]);
                }
                
            }
        } else {*/
            
            
            
            //insert into cart
            if (count($exist) == 0) {
                
                  
                
                $customers_basket_id = DB::table('customers_basket')->insertGetId(
                    [
                        'customers_id' => $customers_id,
                        'products_id' => $products_id,
                        'product_selected_name' => $product_selected_name,
                        'session_id' => $device_id,
                        'customers_basket_quantity' => $customers_basket_quantity,
                        'final_price' => $final_price,
                        'distributor_final_price' => $distributor_product_original_price,
                        'distributor_id'=>$product_distributor_id,
                        'customers_basket_date_added' => $customers_basket_date_added,
                    ]);
                
                if (!empty($request->productattributes) && count($request->productattributes) > 0) {
                    foreach ($request->productattributes as $option_id) {
                        
                        DB::table('customers_basket_attributes')->insert(
                            [
                                'customers_id' => $customers_id,
                                'products_id' => $products_id,
                                'products_options_id' => $option_id['options_id'],
                                'products_options_values_id' => $option_id['options_values_id'],
                                'session_id' => $device_id,
                                'customers_basket_id' => $customers_basket_id,
                            ]);
                        
                    }
                    
                } 
              else if (!empty($detail['product_data'][0]->attributes)) {
                  
                
        
                    
                    foreach ($detail['product_data'][0]->attributes as $attribute) {
                        
                        DB::table('customers_basket_attributes')->insert(
                            [
                                'customers_id' => $customers_id,
                                'products_id' => $products_id,
                                'products_options_id' => $attribute['option']['id'],
                                'products_options_values_id' => $attribute['values'][0]['id'],
                                'session_id' => $device_id,
                                'customers_basket_id' => $customers_basket_id,
                            ]);
                    }
                }
                
                
            } else {
                
                
              
        
        
                $existAttribute = '0';
                $totalAttribute = '0';
                $basket_id = '0';
                
              //  print_r($request->option_id);
              //  die;
                
                if (!empty($request->productattributes)) {
                    
                    
                    if (count($request->productattributes) > 0) {
                        
                        foreach ($exist as $exists) {
                            $totalAttribute = '0';
                            foreach ($request->productattributes as $option_id) {
                                
                                
                                $checkexistAttributes = DB::table('customers_basket_attributes')->where([
                                    ['customers_basket_id', '=', $exists->customers_basket_id],
                                    ['products_id', '=', $products_id],
                                    ['products_options_id', '=', $option_id['options_id']],
                                    ['customers_id', '=', $customers_id],
                                    ['products_options_values_id', '=', $option_id['options_values_id']],
                                   // ['session_id', '=', $device_id],
                                ])->get();
                                $totalAttribute++;
                                if (count($checkexistAttributes) > 0) {
                                    $existAttribute++;
                                } else {
                                    $existAttribute = 0;
                                }
                                
                            }
                            
                            if ($totalAttribute == $existAttribute) {
                                $basket_id = $exists->customers_basket_id;
                            }
                        }
                        
                    }
                   else if (!empty($detail['product_data'][0]->attributes)) {
                        
                        //print_r($detail['product_data'][0]->attributes);
                        // die;
                        
                        foreach ($exist as $exists) {
                            $totalAttribute = '0';
                            foreach ($detail['product_data'][0]->attributes as $attribute) {
                                $checkexistAttributes = DB::table('customers_basket_attributes')->where([
                                    ['customers_basket_id', '=', $exists->customers_basket_id],
                                    ['products_id', '=', $products_id],
                                    ['products_options_id', '=', $attribute['option']['id']],
                                    ['customers_id', '=', $customers_id],
                                    ['products_options_values_id', '=', $attribute['values'][0]['id']],
                                    ['products_options_id', '=', $option_id],
                                ])->get();
                                $totalAttribute++;
                                if (count($checkexistAttributes) > 0) {
                                    $existAttribute++;
                                } else {
                                    $existAttribute = 0;
                                }
                                if ($totalAttribute == $existAttribute) {
                                    $basket_id = $exists->customers_basket_id;
                                }
                            }
                        }
                        
                    }
                    
                    //attribute exist
                    if ($basket_id == 0) {
                      
                        $customers_basket_id = DB::table('customers_basket')->insertGetId(
                            [
                                'customers_id' => $customers_id,
                                'products_id' => $products_id,
                                'product_selected_name' => $product_selected_name,
                                'session_id' => $device_id,
                                'customers_basket_quantity' => $customers_basket_quantity,
                                'final_price' => $final_price,
                                'distributor_final_price' => $distributor_product_original_price,
                                'distributor_id'=>$product_distributor_id,
                                'customers_basket_date_added' => $customers_basket_date_added,
                            ]);
                        
                        if (count($request->productattributes) > 0) {
                            foreach ($request->productattributes as $option_id) {
                                
                                DB::table('customers_basket_attributes')->insert(
                                    [
                                        'customers_id' => $customers_id,
                                        'products_id' => $products_id,
                                        'products_options_id' => $option_id['options_id'],
                                        'products_options_values_id' => $option_id['options_values_id'],
                                        'session_id' => $device_id,
                                        'customers_basket_id' => $customers_basket_id,
                                    ]);
                                
                            }
                            
                        } 
                       else if (!empty($detail['product_data'][0]->attributes)) {
                            
                            foreach ($detail['product_data'][0]->attributes as $attribute) {
                                
                                DB::table('customers_basket_attributes')->insert(
                                    [
                                        'customers_id' => $customers_id,
                                        'products_id' => $products_id,
                                        'products_options_id' => $attribute['option']['id'],
                                        'products_options_values_id' => $attribute['values'][0]['id'],
                                        'session_id' => $device_id,
                                        'customers_basket_id' => $customers_basket_id,
                                    ]);
                            }
                        }
                        
                    } else {
                        //  print_r($basket_id." ".$customers_basket_quantity);
                        // die;
                        
                        //update into cart
                        DB::table('customers_basket')->where('customers_basket_id', '=', $basket_id)->update(
                            [
                                'customers_id' => $customers_id,
                                'products_id' => $products_id,
                                'product_selected_name' => $product_selected_name,
                                'session_id' => $device_id,
                                'customers_basket_quantity' => DB::raw('customers_basket_quantity+' . $customers_basket_quantity),
                                'final_price' => $final_price,
                                'distributor_final_price' => $distributor_product_original_price,
                                'distributor_id'=>$product_distributor_id,
                                'customers_basket_date_added' => $customers_basket_date_added,
                            ]);
                        
                        if (count($request->productattributes) > 0) {
                            foreach ($request->productattributes as $option_id) {
                                
                                DB::table('customers_basket_attributes')->where([
                                    ['customers_basket_id', '=', $basket_id],
                                    ['products_id', '=', $products_id],
                                    ['products_options_id', '=', $option_id['options_id']],
                                ])->update(
                                    [
                                        'customers_id' => $customers_id,
                                        'products_options_values_id' => $option_id['options_values_id'],
                                        'session_id' => $device_id,
                                    ]);
                            }
                            
                        } 
                       else if (!empty($detail['product_data'][0]->attributes)) {
                            
                            foreach ($detail['product_data'][0]->attributes as $attribute) {
                                
                                DB::table('customers_basket_attributes')->where([
                                    ['customers_basket_id', '=', $basket_id],
                                    ['products_id', '=', $products_id],
                                    ['products_options_id', '=', $option_id],
                                ])->update(
                                    [
                                        'customers_id' => $customers_id,
                                        'products_id' => $products_id,
                                        'products_options_id' => $attribute['option']['id'],
                                        'products_options_values_id' => $attribute['values'][0]['id'],
                                        'session_id' => $device_id,
                                        'customers_basket_id' => $customers_basket_id,
                                    ]);
                            }
                        }
                        
                    }
                    
                } else {
                    //update into cart
                    
                 //   print_r($exist[0]->customers_basket_id." ".$customers_basket_quantity);
                  //  die;
                    
                    DB::table('customers_basket')->where('customers_basket_id', '=', $exist[0]->customers_basket_id)->update(
                        [
                            'customers_id' => $customers_id,
                            'products_id' => $products_id,
                            'product_selected_name' => $product_selected_name,
                            'session_id' => $device_id,
                            'customers_basket_quantity' => DB::raw('customers_basket_quantity+' . $customers_basket_quantity),
                            'final_price' => $final_price,
                            'distributor_final_price' => $distributor_product_original_price,
                            'distributor_id'=>$product_distributor_id,
                            'customers_basket_date_added' => $customers_basket_date_added,
                        ]);
                    
                }
                //apply coupon
                //                 if (count(session('coupon')) > 0) {
                //                     $session_coupon_data = session('coupon');
                //                     session(['coupon' => array()]);
                //                     $response = array();
                //                     if (!empty($session_coupon_data)) {
                //                         foreach ($session_coupon_data as $key => $session_coupon) {
                //                             $response = $this->common_apply_coupon($session_coupon->code);
                //                         }
                //                     }
                //                 }
                
                }
           // }
            //  $result['commonContent'] = $index->commonContent();
            //  $responseData = array('success' => '1', 'product_data' => array(), 'message' => "Unauthenticated call.");
            $responseData = array('success' => '1',  'status' => "Product Added to cart",'message' => "All OK".$products_id);
            
        } else {
            $responseData = array('success' => '0', 'status' => "Unauthenticated call.");
        }
        $categoryResponse = json_encode($responseData);
        
        return $categoryResponse;
        
    
        
    }
    
    
    public function addToCartByDeviceId($request)
    {
        
        
        
        $index = new Index();
        $products = new Product();
        
        $products_id = $request->products_id;
        // bHarath 10-02-2022  Product Selected  Attrribute Name
        $product_selected_name= $request->product_selected_name;
        
        $location_id = $request->location_id;
       // if (empty($request->device_id)) {
      //      $device_id = '';
      //  } else {
            $device_id = $request->device_id;
            $customers_id="";
     //   }
        
        //   $session_id = Session::getId();
        $customers_basket_date_added = date('Y-m-d H:i:s');
        
        
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        $consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);
        
        if (1) {
            
            //         if (!empty($request->limit)) {
            //             $limit = $request->limit;
            //         } else {
            //             $limit = 15;
            //         }
            
            //min_price
            //         if (!empty($request->min_price)) {
            //             $min_price = $request->min_price;
            //         } else {
            //             $min_price = '';
            //         }
            
            //max_price
            //         if (!empty($request->max_price)) {
            //             $max_price = $request->max_price;
            //         } else {
            //             $max_price = '';
            //         }
            
            //         if (empty($customers_id)) {
            
            //             $exist = DB::table('customers_basket')->where([
            //               //  ['session_id', '=', $session_id],
            //                 ['products_id', '=', $products_id],
            //                 ['is_order', '=', 0],
            //             ])->get();
            
            //         } else {
            
            $exist = DB::table('customers_basket')->where([
                ['session_id', '=', $device_id],
                ['products_id', '=', $products_id],
                ['is_order', '=', 0],
            ])->get();
            
            
            
            
            //   }
            $isFlash = DB::table('flash_sale')->where('products_id', $products_id)
            ->where('flash_expires_date', '>=', time())->where('flash_status', '=', 1)
            ->get();
            //get products detail  is not default
            if (!empty($isFlash) and count($isFlash) > 0) {
                $type = "flashsale";
            } else {
                $type = "";
            }
            
            $data = array('page_number' => '0', 'type' => $type, 'location_id'=>$location_id,'language_id' => 1,'customers_id' => $customers_id, 'products_id' => $request->products_id, 'limit' => '15', 'min_price' => '', 'max_price' => '');
            $detail = $products->addtocartproductdetails($data);
            
            
            $result['detail'] = $detail;
            
//             if ($result['detail']['product_data'][0]->products_type == 0) {
                
//                 //check lower value to match with added stock
//                 if ($result['detail']['product_data'][0]->products_max_stock != null and $result['detail']['product_data'][0]->products_max_stock < $result['detail']['product_data'][0]->defaultStock) {
//                     $default_stock = $result['detail']['product_data'][0]->products_max_stock;
//                 } else {
//                     $default_stock = $result['detail']['product_data'][0]->defaultStock;
//                 }
                
//                 if (!empty($exist) and count($exist) > 0) {
                    
                    
//                     $count = $exist[0]->customers_basket_quantity + $request->quantity;
//                     $remain = $result['detail']['product_data'][0]->defaultStock - $exist[0]->customers_basket_quantity;
                    
//                     if ($count > $default_stock) {
                        
//                         // return array('status' => 'exceed', 'defaultStock' => $result['detail']['product_data'][0]->defaultStock, 'already_added' => $exist[0]->customers_basket_quantity, 'remain_pieces' => $remain);
//                     }
                    
//                     // if ($count >= $result['detail']['product_data'][0]->defaultStock || $count > $result['detail']['product_data'][0]->products_max_stock and $result['detail']['product_data'][0]->products_max_stock != null) {
                    
//                     //     return array('status' => 'exceed', 'defaultStock' => $result['detail']['product_data'][0]->defaultStock, 'already_added' => $exist[0]->customers_basket_quantity, 'remain_pieces' => $remain);
//                     // }
//                 } else {
                    
//                     //if ($request->quantity > $result['detail']['product_data'][0]->defaultStock || $request->quantity > $result['detail']['product_data'][0]->products_max_stock and $result['detail']['product_data'][0]->products_max_stock != null) {
//                     if ($request->quantity > $default_stock) {
//                         $count = $request->quantity;
//                         $remain = $result['detail']['product_data'][0]->defaultStock - $count;
//                         // return array('status' => 'exceed');
//                     }
//                 }
//             }
            
            
            
            //change of price on the attribute change
            //Bharath  discounted price to change mrp and attribute price value
            $discount_percentage ="";
            
            
            
            if (!empty($result['detail']['product_data'][0]->flash_price)) {
                $final_price = $result['detail']['product_data'][0]->flash_price + 0;
            } elseif (!empty($result['detail']['product_data'][0]->discount_price)) {
                $final_price = $result['detail']['product_data'][0]->discount_price + 0;
                
                
                
                //Bharath  discounted price to change mrp and attribute price value
                $discounted_price = $result['detail']['product_data'][0]->products_price  - $result['detail']['product_data'][0]->discount_price;
                
                $discount_percentage = $discounted_price/$result['detail']['product_data'][0]->products_price*100;
                //Bharath  discounted price to change mrp and attribute price value
                
            } else {
                $final_price = $result['detail']['product_data'][0]->products_price + 0;
            }
            //Bharath  discounted price to change mrp and attribute price value
            $product_price =$result['detail']['product_data'][0]->products_price + 0;
            
            
            $distributor_product_original_price =$result['detail']['product_data'][0]->distributor_product_price + 0;
            $product_distributor_id = $result['detail']['product_data'][0]->distributor_id;
            
            
            
            
            //$variables_prices = 0
            if ($result['detail']['product_data'][0]->products_type == 1) {
                
                
                $attributeid = $request->attributes_id;
                $attribute_price = 0;
                if (!empty($attributeid) && count($attributeid) > 0) {
                    
                    foreach ($attributeid as $attribute) {
                        $attribute = DB::table('products_attributes')->where('products_attributes_id', $attribute)->first();
                        $symbol = $attribute->price_prefix;
                        $values_price = $attribute->options_values_price;
                        
                        
                        $distributor_options_values_price = $attribute->distributor_options_values_price;
                        
                        
                        
                        /*  if ($symbol == '+') {
                         $final_price = intval($final_price) + intval($values_price);
                         }
                         if ($symbol == '-') {
                         $final_price = intval($final_price) - intval($values_price);
                         }*/
                        
                        
                        
                        //Bharath
                        if ($symbol == '+') {
                            
                            $product_price= $product_price + intval($values_price);
                            $distributor_product_original_price = $distributor_product_original_price +intval($distributor_options_values_price);
                            
                            if($discount_percentage==""){
                                
                                $final_price = $product_price;
                            }else{
                                $discount_price = $product_price - $product_price*$discount_percentage/100;
                                
                                $final_price = $discount_price;
                            }
                            
                            
                        }
                        if ($symbol == '-') {
                            
                            
                            $product_price= $product_price - intval($values_price);
                            $distributor_product_original_price = $distributor_product_original_price - intval($distributor_options_values_price);
                            
                            if($discount_percentage==""){
                                
                                $final_price = $product_price;
                            }else{
                                $discount_price = $product_price - $product_price*$discount_percentage/100;
                                
                                
                                $final_price = $discount_price;
                                
                            }
                            //Bharath
                            
                            
                        }
                        
                        
                    }
                    
                }
                
            }
            
//             //check quantity
//             if ($result['detail']['product_data'][0]->products_type == 1) {
//                 $qunatity['products_id'] = $request->products_id;
//                 $qunatity['attributes'] = $attributeid;
                
//                 $content = $products->productQuantity($qunatity);
//                 //dd($content);
//                 $stocks = $content['remainingStock'];
                
//             } else {
//                 $stocks = $result['detail']['product_data'][0]->defaultStock;
                
//             }
            
//             if ($stocks <= $result['detail']['product_data'][0]->products_max_stock or $result['detail']['product_data'][0]->products_max_stock ==0) {
//                 $stocksToValid = $stocks;
//             } else {
                $stocksToValid = $result['detail']['product_data'][0]->products_max_stock;
//             }
            
            //check variable stock limit
            if (!empty($exist) and count($exist) > 0) {
                $count = $exist[0]->customers_basket_quantity + $request->customers_basket_quantity;
                if ($count > $stocksToValid) {
                    //    return array('status' => 'exceed');
                    $responseData = array('success' => '1',  'status' => "exceed");
                    
                }
            }
            
            if (empty($request->customers_basket_quantity)) {
                $customers_basket_quantity = 1;
            } else {
                $customers_basket_quantity = $request->customers_basket_quantity;
            }
            
            if ($stocksToValid > $customers_basket_quantity) {
                $customers_basket_quantity = $result['detail']['product_data'][0]->products_min_order;
            }
            
            //quantity is not default
            if (empty($request->quantity)) {
                $customers_basket_quantity = 1;
            } else {
                $customers_basket_quantity = $request->quantity;
            }
            
            if ($request->customers_basket_id) {
                
                
                $basket_id = $request->customers_basket_id;
                DB::table('customers_basket')->where('customers_basket_id', '=', $basket_id)->update(
                    [
                        'customers_id' => "",
                        'products_id' => $products_id,
                        'product_selected_name' => $product_selected_name,
                        'session_id' => $device_id,
                        'customers_basket_quantity' => $customers_basket_quantity,
                        'final_price' => $final_price,
                        'distributor_final_price' => $distributor_product_original_price,
                        'distributor_id'=>$product_distributor_id,
                        'customers_basket_date_added' => $customers_basket_date_added,
                    ]);
                
                if (count($request->productattributes) > 0) {
                    foreach ($request->productattributes as $option_id) {
                        
                        
                        DB::table('customers_basket_attributes')->where([
                            ['customers_basket_id', '=', $basket_id],
                            ['products_id', '=', $products_id],
                            ['products_options_id', '=', $option_id['options_id']],
                        ])->update(
                            [
                                'customers_id' => "",
                                'products_options_values_id' => $option_id['options_values_id'],
                                'session_id' =>$device_id,
                            ]);
                    }
                    
                }
            } else {
                
                
                
                //insert into cart
                if (count($exist) == 0) {
                    
                    $customers_basket_id = DB::table('customers_basket')->insertGetId(
                        [
                            'customers_id' =>"",
                            'products_id' => $products_id,
                            'product_selected_name' => $product_selected_name,
                            'session_id' =>$device_id,
                            'customers_basket_quantity' => $customers_basket_quantity,
                            'final_price' => $final_price,
                            'distributor_final_price' => $distributor_product_original_price,
                            'distributor_id'=>$product_distributor_id,
                            'customers_basket_date_added' => $customers_basket_date_added,
                        ]);
                    
                    if (!empty($request->productattributes) && count($request->productattributes) > 0) {
                        foreach ($request->productattributes as $option_id) {
                            
                            DB::table('customers_basket_attributes')->insert(
                                [
                                    'customers_id' =>"", 
                                    'products_id' => $products_id,
                                    'products_options_id' => $option_id['options_id'],
                                    'products_options_values_id' => $option_id['options_values_id'],
                                    'session_id' => $device_id,
                                    'customers_basket_id' => $customers_basket_id,
                                ]);
                            
                        }
                        
                    }
                    else if (!empty($detail['product_data'][0]->attributes)) {
                        
                        foreach ($detail['product_data'][0]->attributes as $attribute) {
                            
                            DB::table('customers_basket_attributes')->insert(
                                [
                                    'customers_id' => "",
                                    'products_id' => $products_id,
                                    'products_options_id' => $attribute['option']['id'],
                                    'products_options_values_id' => $attribute['values'][0]['id'],
                                    'session_id' => $device_id,
                                    'customers_basket_id' => $customers_basket_id,
                                ]);
                        }
                    }
                } else {
                    
                    $existAttribute = '0';
                    $totalAttribute = '0';
                    $basket_id = '0';
                    
                    //  print_r($request->option_id);
                    //  die;
                    
                    if (!empty($request->productattributes)) {
                        
                        
                        if (count($request->productattributes) > 0) {
                            
                            foreach ($exist as $exists) {
                                $totalAttribute = '0';
                                foreach ($request->productattributes as $option_id) {
                                    
                                    
                                    $checkexistAttributes = DB::table('customers_basket_attributes')->where([
                                        ['customers_basket_id', '=', $exists->customers_basket_id],
                                        ['products_id', '=', $products_id],
                                        ['products_options_id', '=', $option_id['options_id']],
                                        ['customers_id', '=',  ""],
                                        ['products_options_values_id', '=', $option_id['options_values_id']],
                                        ['session_id', '=', $device_id],
                                    ])->get();
                                    $totalAttribute++;
                                    if (count($checkexistAttributes) > 0) {
                                        $existAttribute++;
                                    } else {
                                        $existAttribute = 0;
                                    }
                                    
                                }
                                
                                if ($totalAttribute == $existAttribute) {
                                    $basket_id = $exists->customers_basket_id;
                                }
                            }
                            
                        }
                        else if (!empty($detail['product_data'][0]->attributes)) {
                            
                            //print_r($detail['product_data'][0]->attributes);
                            // die;
                            
                            foreach ($exist as $exists) {
                                $totalAttribute = '0';
                                foreach ($detail['product_data'][0]->attributes as $attribute) {
                                    $checkexistAttributes = DB::table('customers_basket_attributes')->where([
                                        ['customers_basket_id', '=', $exists->customers_basket_id],
                                        ['products_id', '=', $products_id],
                                        ['products_options_id', '=', $attribute['option']['id']],
                                        ['customers_id', '=', ""],
                                        ['products_options_values_id', '=', $attribute['values'][0]['id']],
                                        ['products_options_id', '=', $option_id],
                                    ])->get();
                                    $totalAttribute++;
                                    if (count($checkexistAttributes) > 0) {
                                        $existAttribute++;
                                    } else {
                                        $existAttribute = 0;
                                    }
                                    if ($totalAttribute == $existAttribute) {
                                        $basket_id = $exists->customers_basket_id;
                                    }
                                }
                            }
                            
                        }
                        
                        //attribute exist
                        if ($basket_id == 0) {
                            
                            $customers_basket_id = DB::table('customers_basket')->insertGetId(
                                [
                                    'customers_id' => "",
                                    'products_id' => $products_id,
                                    'product_selected_name' => $product_selected_name,
                                    'session_id' => $device_id,
                                    'customers_basket_quantity' => $customers_basket_quantity,
                                    'final_price' => $final_price,
                                    'distributor_final_price' => $distributor_product_original_price,
                                    'distributor_id'=>$product_distributor_id,
                                    'customers_basket_date_added' => $customers_basket_date_added,
                                ]);
                            
                            if (count($request->productattributes) > 0) {
                                foreach ($request->productattributes as $option_id) {
                                    
                                    DB::table('customers_basket_attributes')->insert(
                                        [
                                            'customers_id' => "",
                                            'products_id' => $products_id,
                                            'products_options_id' => $option_id['options_id'],
                                            'products_options_values_id' => $option_id['options_values_id'],
                                            'session_id' => $device_id,
                                            'customers_basket_id' => $customers_basket_id,
                                        ]);
                                    
                                }
                                
                            }
                            else if (!empty($detail['product_data'][0]->attributes)) {
                                
                                foreach ($detail['product_data'][0]->attributes as $attribute) {
                                    
                                    DB::table('customers_basket_attributes')->insert(
                                        [
                                            'customers_id' => "",
                                            'products_id' => $products_id,
                                            'products_options_id' => $attribute['option']['id'],
                                            'products_options_values_id' => $attribute['values'][0]['id'],
                                            'session_id' => $device_id,
                                            'customers_basket_id' => $customers_basket_id,
                                        ]);
                                }
                            }
                            
                        } else {
                            //  print_r($basket_id." ".$customers_basket_quantity);
                            // die;
                            
                            //update into cart
                            DB::table('customers_basket')->where('customers_basket_id', '=', $basket_id)->update(
                                [
                                    'customers_id' => "",
                                    'products_id' => $products_id,
                                    'product_selected_name' => $product_selected_name,
                                    'session_id' => $device_id,
                                    'customers_basket_quantity' => DB::raw('customers_basket_quantity+' . $customers_basket_quantity),
                                    'final_price' => $final_price,
                                    'distributor_final_price' => $distributor_product_original_price,
                                    'distributor_id'=>$product_distributor_id,
                                    'customers_basket_date_added' => $customers_basket_date_added,
                                ]);
                            
                            if (count($request->productattributes) > 0) {
                                foreach ($request->productattributes as $option_id) {
                                    
                                    DB::table('customers_basket_attributes')->where([
                                        ['customers_basket_id', '=', $basket_id],
                                        ['products_id', '=', $products_id],
                                        ['products_options_id', '=', $option_id['options_id']],
                                    ])->update(
                                        [
                                            'customers_id' => "",
                                            'products_options_values_id' => $option_id['options_values_id'],
                                            'session_id' => $device_id,
                                        ]);
                                }
                                
                            }
                            else if (!empty($detail['product_data'][0]->attributes)) {
                                
                                foreach ($detail['product_data'][0]->attributes as $attribute) {
                                    
                                    DB::table('customers_basket_attributes')->where([
                                        ['customers_basket_id', '=', $basket_id],
                                        ['products_id', '=', $products_id],
                                        ['products_options_id', '=', $option_id],
                                    ])->update(
                                        [
                                            'customers_id' => "",
                                            'products_id' => $products_id,
                                            'products_options_id' => $attribute['option']['id'],
                                            'products_options_values_id' => $attribute['values'][0]['id'],
                                            'session_id' => $device_id,
                                            'customers_basket_id' => $customers_basket_id,
                                        ]);
                                }
                            }
                            
                        }
                        
                    } else {
                        //update into cart
                        
                        //   print_r($exist[0]->customers_basket_id." ".$customers_basket_quantity);
                        //  die;
                        
                        DB::table('customers_basket')->where('customers_basket_id', '=', $exist[0]->customers_basket_id)->update(
                            [
                                'customers_id' => "",
                                'products_id' => $products_id,
                                'product_selected_name' => $product_selected_name,
                                'session_id' => $device_id,
                                'customers_basket_quantity' => DB::raw('customers_basket_quantity+' . $customers_basket_quantity),
                                'final_price' => $final_price,
                                'distributor_final_price' => $distributor_product_original_price,
                                'distributor_id'=>$product_distributor_id,
                                'customers_basket_date_added' => $customers_basket_date_added,
                            ]);
                        
                    }
                    //apply coupon
                    //                 if (count(session('coupon')) > 0) {
                    //                     $session_coupon_data = session('coupon');
                        //                     session(['coupon' => array()]);
                        //                     $response = array();
                        //                     if (!empty($session_coupon_data)) {
                        //                         foreach ($session_coupon_data as $key => $session_coupon) {
                            //                             $response = $this->common_apply_coupon($session_coupon->code);
                            //                         }
                            //                     }
                            //                 }
                            
                    }
                }
                //  $result['commonContent'] = $index->commonContent();
                //  $responseData = array('success' => '1', 'product_data' => array(), 'message' => "Unauthenticated call.");
                $responseData = array('success' => '1',  'status' => "Product Added to cart",'message' => "All OK".$products_id);
                
            } else {
                $responseData = array('success' => '0', 'status' => "Unauthenticated call.");
            }
            $categoryResponse = json_encode($responseData);
            
            return $categoryResponse;
            
            
            
        }
  
 
    public function updatemobilecart($customers_basket_id, $customers_id, $device_id, $quantity,$products_id)
    {

    	$consumer_data = array();
    	$consumer_data['consumer_key'] = request()->header('consumer-key');
    	$consumer_data['consumer_secret'] = request()->header('consumer-secret');
    	$consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
    	$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
    	$consumer_data['consumer_ip'] = request()->header('consumer-ip');
    	$consumer_data['consumer_url'] = __FUNCTION__;
    	 
    	$authController = new AppSettingController();
    	$authenticate = $authController->apiAuthenticate($consumer_data);
    	 
    	if (1) {
    		 
    	
    /*	
    	DB::table('customers_basket')->where('customers_basket_id', '=', $customers_basket_id)
    	->where('products_id', '=', $products_id)
    	->where('customers_id', '=', $customers_id) 
    	->update(
    			[
    					'customers_id' => $customers_id,
    				//	'session_id' => $session_id,
    					'customers_basket_quantity' => $quantity,
    			]);*/
    			
    			
    			 // Product Quantity Update For before Logout And after Login  24-04-2023
    if($customers_id){
   
    DB::table('customers_basket')->where('customers_basket_id', '=', $customers_basket_id)
    ->where('products_id', '=', $products_id)
    ->where('customers_id', '=', $customers_id)
    ->update([ 'customers_id' => $customers_id,
    // 'session_id' => $session_id,
    'customers_basket_quantity' => $quantity,
    ]);
    }else{
    DB::table('customers_basket')->where('customers_basket_id', '=', $customers_basket_id)
    ->where('products_id', '=', $products_id)
    ->where('session_id', '=', $device_id)
    ->update([     //'customers_id' => $customers_id,
    'session_id' => $device_id,
    'customers_basket_quantity' => $quantity,
    ]);
    }
    			
    	$responseData = array('success' => '1',  'status' => "Product item quantity has been updated successfully");
    	 
    	} else {
    		$responseData = array('success' => '0', 'status' => "Unauthenticated call.");
    	}
    	$categoryResponse = json_encode($responseData);
    	 
    	return $categoryResponse;
    }
    
    
    public function mobiledeleteCart($request)
    {
    	//session(['out_of_stock' => 0]);
    	$baskit_id = $request->basket_id;
    
    	$consumer_data = array();
    	$consumer_data['consumer_key'] = request()->header('consumer-key');
    	$consumer_data['consumer_secret'] = request()->header('consumer-secret');
    	$consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
    	$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
    	$consumer_data['consumer_ip'] = request()->header('consumer-ip');
    	$consumer_data['consumer_url'] = __FUNCTION__;
    	
    	$authController = new AppSettingController();
    	$authenticate = $authController->apiAuthenticate($consumer_data);
    	
    	if (1) {
    	
    	
    	DB::table('customers_basket')->where([
    			['customers_basket_id', '=', $baskit_id] 
    	])->delete();
    
    	DB::table('customers_basket_attributes')->where([
    			['customers_basket_id', '=', $baskit_id] 
    	])->delete();
    	
    	$check = DB::table('customers_basket')
    	->where('customers_basket.customers_basket_id', '=', $baskit_id)
    	->first();
    	if (empty($check)) {
    	$responseData = array('success' => '1',  'status' => "Cart item has been deleted successfully");
    	}else{ 
    		$responseData = array('success' => '1',  'status' => "Cart item has been deleted successfully"); 
    	}
    	} else {
    		$responseData = array('success' => '0', 'status' => "Unauthenticated call.");
    	}
    	$categoryResponse = json_encode($responseData);
    	
    	return $categoryResponse;
    	
    	 
    	
    	
    	
    
    }
    
    
    
    //we used this method in place order
	public function myCartOrder($request)
	{
	    
	    
	    $consumer_data = array();
	    $consumer_data['consumer_key'] = request()->header('consumer-key');
	    $consumer_data['consumer_secret'] = request()->header('consumer-secret');
	    $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
	    $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
	    $consumer_data['consumer_ip'] = request()->header('consumer-ip');
	    $consumer_data['consumer_url'] = __FUNCTION__;
	    
	    $authController = new AppSettingController();
	    $authenticate = $authController->apiAuthenticate($consumer_data);
	    
	    if (1) {
	        
	        $cart = DB::table('customers_basket')
	        ->join('products', 'products.products_id', '=', 'customers_basket.products_id')
	        ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
	        ->LeftJoin('image_categories', function ($join) {
	            $join->on('image_categories.image_id', '=', 'products.products_image')
	            ->where(function ($query) {
	                $query->where('image_categories.image_type', '=', 'THUMBNAIL')
	                ->where('image_categories.image_type', '!=', 'THUMBNAIL')
	                ->orWhere('image_categories.image_type', '=', 'ACTUAL');
	            });
	        })
	        ->select('customers_basket.*',
	            'image_categories.path as image_path', 'products.products_model as model',
	            'products.products_type as products_type', 'products.products_min_order as min_order', 'products.products_max_stock as max_order',
	            'products.products_image as image',
	            'products.distributor_product_price_percentage as distributor_product_price_percentage','products.hsn_sac_code as hsn_sac_code',
	            'products_description.products_name as products_name', 'products.products_price as price', 'products.distributor_product_price as distributor_product_price','products.distributor_id as distributor_id',
	            'products.products_weight as weight', 'products.products_weight_unit as unit', 'products.products_slug')
	            
	            ->where([
	                ['customers_basket.is_order', '=', '0'],
	                ['products_description.language_id', '=', $request->language_id],
	            ]);
	            
	            $cart->where('customers_basket.customers_id', '=', $request->customers_id);
	            
	            if (!empty($request->customers_basket_id)) {
	                $cart->where('customers_basket.customers_basket_id', '=', $request->customers_basket_id);
	            }
	            
	            $baskit = $cart->get();
	            $total_carts = count($baskit);
	            $result = array();
	            $index = 0;
	            if ($total_carts > 0) {
	                foreach ($baskit as $cart_data) {
	                    //products_image
	                    $default_images = DB::table('image_categories')
	                    ->where('image_id', '=', $cart_data->image)
	                    ->where('image_type', 'THUMBNAIL')
	                    ->first();
	                    
	                    if ($default_images) {
	                        $cart_data->image_path = $default_images->path;
	                    } else {
	                        $default_images = DB::table('image_categories')
	                        ->where('image_id', '=', $cart_data->image)
	                        ->where('image_type', 'Medium')
	                        ->first();
	                        
	                        if ($default_images) {
	                            $cart_data->image_path = $default_images->path;
	                        } else {
	                            $default_images = DB::table('image_categories')
	                            ->where('image_id', '=', $cart_data->image)
	                            ->where('image_type', 'ACTUAL')
	                            ->first();
	                            $cart_data->image_path = $default_images->path;
	                        }
	                        
	                    }
	                    
	                    
	                    //categories
	                    $categories = DB::table('products_to_categories')
	                    ->leftjoin('categories', 'categories.categories_id', 'products_to_categories.categories_id')
	                    ->leftjoin('categories_description', 'categories_description.categories_id', 'products_to_categories.categories_id')
	                    ->select('categories.categories_id', 'categories_description.categories_name', 'categories.categories_image', 'categories.categories_icon', 'categories.parent_id')
	                    ->where('products_id', '=', $cart_data->products_id)
	                    ->where('categories_description.language_id', '=', $request->language_id)->get();
	                    if(!empty($categories) and count($categories)>0){
	                        $cart_data->categories = $categories;
	                    }else{
	                        $cart_data->categories = array();
	                    }
	                    array_push($result, $cart_data);
	                    
	                    //default product
	                    $stocks = 0;
	                    if ($cart_data->products_type == '0') {
	                        
	                        $currentStocks = DB::table('inventory')->where('products_id', $cart_data->products_id)->get();
	                        if (count($currentStocks) > 0) {
	                            foreach ($currentStocks as $currentStock) {
	                                $stocks += $currentStock->stock;
	                            }
	                        }
	                        
	                        if (!empty($cart_data->max_order) and $cart_data->max_order != 0) {
	                            if ($cart_data->max_order >= $stocks) {
	                                $result[$index]->max_order = $stocks;
	                            }
	                        } else {
	                            $result[$index]->max_order = $stocks;
	                        }
	                        $index++;
	                        
	                    } else {
	                        
	                        $attributes = DB::table('customers_basket_attributes')
	                        ->join('products_options', 'products_options.products_options_id', '=', 'customers_basket_attributes.products_options_id')
	                        ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'customers_basket_attributes.products_options_id')
	                        ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')
	                        ->leftjoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')
	                        ->leftjoin('products_attributes', function ($join) {
	                            $join->on('customers_basket_attributes.products_id', '=', 'products_attributes.products_id')->on('customers_basket_attributes.products_options_id', '=', 'products_attributes.options_id')->on('customers_basket_attributes.products_options_values_id', '=', 'products_attributes.options_values_id');
	                        })
	                        // ->select('products_options_descriptions.options_name as attribute_name', 'products_options_values_descriptions.options_values_name as attribute_value', 'customers_basket_attributes.products_options_id as options_id', 'customers_basket_attributes.products_options_values_id as options_values_id', 'products_attributes.price_prefix as prefix', 'products_attributes.products_attributes_id as products_attributes_id', 'products_attributes.options_values_price as values_price')
	                            ->select('products_options_descriptions.options_name as attribute_name', 'products_options_values_descriptions.options_values_name as attribute_value', 'customers_basket_attributes.products_options_id as options_id', 'customers_basket_attributes.products_options_values_id as options_values_id', 'products_attributes.price_prefix as prefix', 'products_attributes.products_attributes_id as products_attributes_id', 'products_attributes.options_values_price as values_price','products_attributes.distributor_options_values_price as distributor_options_values_price')
	                            
	                            ->where('customers_basket_attributes.products_id', '=', $cart_data->products_id)
	                            ->where('customers_basket_id', '=', $cart_data->customers_basket_id)
	                            ->where('products_options_descriptions.language_id', '=', $request->language_id)
	                            ->where('products_options_values_descriptions.language_id', '=', $request->language_id);
	                            
	                            //	if (empty(session('customers_id'))) {
	                            //	$attributes->where('customers_basket_attributes.session_id', '=', Session::getId());
	                            //} else {
	                            $attributes->where('customers_basket_attributes.customers_id', '=', $request->customers_id);
	                            //	}
	                            
	                            $attributes_data = $attributes->get();
	                            
	                            //if($index==0){
	                            $products_attributes_id = array();
	                            //}
	                            
	                            foreach ($attributes_data as $attributes_datas) {
	                                if ($cart_data->products_type == '1') {
	                                    $products_attributes_id[] = $attributes_datas->products_attributes_id;
	                                    
	                                }
	                                
	                            }
	                            $myVar = new Product();
	                            
	                            $qunatity['products_id'] = $cart_data->products_id;
	                            $qunatity['attributes'] = $products_attributes_id;
	                            
	                            $content = $myVar->productQuantity($qunatity);
	                            $stocks = $content['remainingStock'];
	                            if (!empty($cart_data->max_order) and $cart_data->max_order != 0) {
	                                if ($cart_data->max_order >= $stocks) {
	                                    $result[$index]->max_order = $stocks;
	                                }
	                            } else {
	                                $result[$index]->max_order = $stocks;
	                            }
	                            
	                            $result[$index]->attributes_id = $products_attributes_id;
	                            
	                            $result2 = array();
	                            if (!empty($cart_data->coupon_id)) {
	                                //coupon
	                                $coupons = explode(',', $cart_data->coupon_id);
	                                $index2 = 0;
	                                foreach ($coupons as $coupons_data) {
	                                    $coupons = DB::table('coupons')->where('coupans_id', '=', $coupons_data)->get();
	                                    $result2[$index2++] = $coupons[0];
	                                }
	                                
	                            }
	                            
	                            $result[$index]->coupons = $result2;
	                           // $result[$index]->attributes = $attributes_data;
	                           //attributes paramter is not receognied in the api call so changes to productattributes...
	                           /*  @SerializedName("productattributes")
    @Expose
    private List<Attribute> attributes = new ArrayList<Attribute>();
*/
	                            $result[$index]->productattributes = $attributes_data;
	                            $index++;
	                            }
	                }
	            }
	            //   $responseData = array('success' => '1', 'cart_data' => $result, 'message' => "Returned all cart products.");
	            
	            return ($result);
	    }
	    else {
	        $responseData = array('success' => '0', 'cart_data' => array(), 'message' => "Unauthenticated call.");
	    }
	    //$categoryResponse = json_encode($responseData);
	    
	    //	return $categoryResponse;
	    
	    
	}

}
