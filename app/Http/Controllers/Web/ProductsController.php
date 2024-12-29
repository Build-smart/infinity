<?php
namespace App\Http\Controllers\Web;

//validator is builtin class in laravel
use App\Models\Web\Currency;
use App\Models\Web\Index;
//for password encryption or hash protected
use App\Models\Web\Languages;

//for authenitcate login data
use App\Models\Web\Products;
use Auth;

//for requesting a value
use DB;
//for Carbon a value
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
use Session;

use Cache;
//email

class ProductsController extends Controller
{
    public function __construct(
        Index $index,
        Languages $languages,
        Products $products,
        Currency $currency
    ) {
        $this->index = $index;
        $this->languages = $languages;
        $this->products = $products;
        $this->currencies = $currency;
        $this->theme = new ThemeController();
    }

    public function reviews(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            $check = DB::table('reviews')
                ->where('customers_id', Auth::guard('customer')->user()->id)
                ->where('products_id', $request->products_id)
                ->first();

            if ($check) {
                return 'already_commented';
            }
            $id = DB::table('reviews')->insertGetId([
                'products_id' => $request->products_id,
                'reviews_rating' => $request->rating,
                'customers_id' => Auth::guard('customer')->user()->id,
                'customers_name' => Auth::guard('customer')->user()->first_name,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            DB::table('reviews_description')
                ->insert([
                    'review_id' => $id,
                    'language_id' => Session::get('language_id'),
                    'reviews_text' => $request->reviews_text,
                ]);
            return 'done';
        } else {
            return 'not_login';

        }
    }

    //shop
    public function shop(Request $request)
    {
        $title = array('pageTitle' => Lang::get('website.Shop'));
        $result = array();
   $categories_id="";
     //   $result['commonContent'] = $this->index->commonContent();
        $final_theme = $this->theme->theme();
		
		 $result['commonContent']=$final_theme['commonContent'];
		
        if (!empty($request->page)) {
            $page_number = $request->page;
        } else {
            $page_number = 0;
        }

        if (!empty($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 15;
        }

        if (!empty($request->type)) {
            $type = $request->type;
        } else {
            $type = '';
        }

        //min_max_price
        if (!empty($request->price)) {
            $d = explode(";", $request->price);
            $min_price = $d[0];
            $max_price = $d[1];
        } else {
            $min_price = '';
            $max_price = '';
        }
        $exist_category = '1';
        $categories_status = 1;
     
        //category
        if (!empty($request->category) and $request->category != 'all') {
            $category = $this->products->getCategories($request);
            
            if(!empty($category) and count($category)>0){
                $categories_id = $category[0]->categories_id;
                //for main
                if ($category[0]->parent_id == 0) {
                    $category_name = $category[0]->categories_name;
                    $category_description = $category[0]->description;
                    $sub_category_name = '';
                    $category_slug = '';
                    $categories_status = $category[0]->categories_status;
                } else {
                    //for sub
                    $main_category = $this->products->getMainCategories($category[0]->parent_id);

                    $category_slug = $main_category[0]->categories_slug;
                    $category_name = $main_category[0]->categories_name;
                    $category_description = $category[0]->description;
                    $sub_category_name = $category[0]->categories_name;
                    $categories_status = $category[0]->categories_status;
                }
            }else{
                $categories_id = '';
                $category_name = '';
                $sub_category_name = '';
                $category_slug = '';
                $categories_status = 0;
                $category_description='';
            }
                            

        } else {
            $categories_id = '';
            $category_name = '';
            $sub_category_name = '';
            $category_slug = '';
            $categories_status = 1;
            $category_description='';
        }

        $result['category_name'] = $category_name;
        $result['category_slug'] = $category_slug;
        $result['sub_category_name'] = $sub_category_name;
        $result['categories_status'] = $categories_status;
        $result['category_description'] = $category_description;

        //search value
        if (!empty($request->search)) {
            $search = $request->search;
        } else {
            $search = '';
        }

        $filters = array();
        if (!empty($request->filters_applied) and $request->filters_applied == 1) {
            $index = 0;
            $options = array();
            $option_values = array();

            $option = $this->products->getOptions();

            foreach ($option as $key => $options_data) {
                $option_name = str_replace(' ', '_', $options_data->products_options_name);

                if (!empty($request->$option_name)) {
                    $index2 = 0;
                    $values = array();
                    foreach ($request->$option_name as $value) {
                        $value = $this->products->getOptionsValues($value);
                        $option_values[] = $value[0]->products_options_values_id;
                    }
                    $options[] = $options_data->products_options_id;
                }
            }
// $filters['options'] = implode($options, ',');
 //  $filters['option_value'] = implode($option_values, ',');
   
   
          $filters['options_count'] = count($options);
 if( count($options)>0){
           $filters['options'] = implode(',',$options);
           
          //  $filters['options'] = $options;
            
		}else{
			 $filters['options'] =array();
		}
		
		  if(count($options)>0){
			             $filters['option_value'] = implode(',',$option_values);
			          
			            //  $filters['option_value'] = $option_values;

		  }else{
			   $filters['option_value'] = array();
		  } 

            $filters['filter_attribute']['options'] = $options;
            $filters['filter_attribute']['option_values'] = $option_values;

            $result['filter_attribute']['options'] = $options;
            $result['filter_attribute']['option_values'] = $option_values; 
        }


         //max_price
        if (!empty($request->brands)) {
            $brands = $request->brands;
        } else {
            $brands = '';
        }



//start of discounts....
   $discounts=array();
        if ($request->has('one_ten_discounts')) {
        $discounts = [1,2,3,4,5,6,7,8,9,10];
        }
       
        if ($request->has('ten_twenty_discounts')) {
        $discounts = array_merge($discounts,[11,12,13,14,15,16,17,18,19,20]);
        }
       
        if ($request->has('twenty_thirty_discounts')) {
        $discounts = array_merge($discounts,[21,22,23,24,25,26,27,28,29,30]);
        }
        if ($request->has('thirty_fourty_discounts')) {
        $discounts = array_merge($discounts,[31,32,33,34,35,36,37,38,39,40]);
        }
        if ($request->has('fourty_fifty_discounts')) {
        $discounts = array_merge($discounts,[41,42,43,44,45,46,47,48,49,50]);
        }
       
 


//end of discounts..

        $data = array('page_number' => $page_number, 'type' => $type, 'limit' => $limit,
            'categories_id' => $categories_id, 'search' => $search,
            'filters' => $filters,'brands'=>$brands,'discounts'=>$discounts,'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);


 $result['brands']=$brands;
 
 
 
 
 $result['one_ten_discounts']=$request->has('one_ten_discounts');
 $result['ten_twenty_discounts']=$request->has('ten_twenty_discounts');
 $result['twenty_thirty_discounts']=$request->has('twenty_thirty_discounts');
 $result['thirty_fourty_discounts']=$request->has('thirty_fourty_discounts');
 $result['fourty_fifty_discounts']=$request->has('fourty_fifty_discounts');


  $result['search']=$search;

 
 
        $products = $this->products->products($data);        
        $result['products'] = $products;

        // added on 31 jan 2022 

        $products_price = array(0);

        //for displaying the brands
        $manufactueres_ids = array();
        if(empty($request->category)){
        
        foreach($result['products']['total_record_data'] as $product){
        
        $manufactueres_ids[] =$product->manufacturers_id;
        
                // added on 31 jan 2022 

                 $products_price[] = $product->products_price;

        
        }
        }
        $manufactueres_ids[] = implode(',',array_unique($manufactueres_ids));
        
        // added on 31 jan 2022 
                $products_price = max($products_price);

         //end for displaying the brands


 //mahadev  attributes like size and color  filter code on feb 3 2022
		 	//mahadev
		$category_ids = array();
	    $categories_id1 = array();
	 if(empty($request->category))
	  {
	    foreach($result['products']['product_data'] as $product_details_categories)
		 {
        
		   $categories = $product_details_categories->categories;
		
           foreach($categories as $product_detail_category)
		    {
              $categories_id1[] = $product_detail_category->categories_id;
	 
             }
         }
     }
		$category_ids[] = implode(',',array_unique($categories_id1));

  
    if(empty($request->category))
	  {
		$data = array('limit' => $limit, 'categories_id1' => $category_ids,'categories_id' =>"",'products_price'=>$products_price);
        $filters = $this->filters($data);
	  }
	  else{
		 $data = array('limit' => $limit, 'categories_id' => $categories_id,'categories_id1'=>"");
        $filters = $this->filters($data);
	  }
       //end of  size and color



       // $data = array('limit' => $limit, 'categories_id' => $categories_id);
       // $filters = $this->filters($data);
        
        //for inner pages promotional banners
           $promotional_banners = DB::table('promotional_banners')
        ->leftJoin('image_categories', 'promotional_banners.image_id', '=', 'image_categories.image_id')
        ->select( 'promotional_banners.*', 'image_categories.path')
        ->where('promotional_banners.category_id','=',$categories_id)
        ->first();
        $result['promotional_banners'] = $promotional_banners;
    
        
     /*   $manufacturers = DB::table('manufacturers')
            ->leftJoin('manufacturers_info', 'manufacturers_info.manufacturers_id', 'manufacturers.manufacturers_id')
               ->leftJoin('products', 'products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
               ->join('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
            
            ->select('manufacturers.*', 'manufacturers_info.*')
            ->where('products_to_categories.categories_id', '=', $categories_id)
            ->distinct()
            ->get();
            
            */
            
            
            
           /*  if (isset($categories_id) and !empty($categories_id)) {
            $manufacturers->where('products_to_categories.categories_id', '=', $categories_id);
        }
*/




//for displaying the brands added on 28 jan 2022
   
        if(empty($request->category) and !empty($manufactueres_ids)){
 $manufacturers = DB::table('manufacturers')
            ->leftJoin('manufacturers_info', 'manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->leftJoin('products', 'products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->join('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
           
            ->select('manufacturers.*', 'manufacturers_info.*')
->whereIn('manufacturers.manufacturers_id', $manufactueres_ids)
         
            ->distinct()
            ->get();

}else{

        $manufacturers = DB::table('manufacturers')
            ->leftJoin('manufacturers_info', 'manufacturers_info.manufacturers_id','=', 'manufacturers.manufacturers_id')
               ->leftJoin('products', 'products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
               ->join('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
           
            ->select('manufacturers.*', 'manufacturers_info.*')
            ->where('products_to_categories.categories_id', '=', $categories_id)
            ->distinct()
            ->get();

}
        $result['manufacturers'] = $manufacturers;

        
        
        $result['filters'] = $filters;

        $cart = '';
        $result['cartArray'] = $this->products->cartIdArray($cart);

        if ($limit > $result['products']['total_record']) {
            $result['limit'] = $result['products']['total_record'];
        } else {
            $result['limit'] = $limit;
        }

        //liked products
     //   $result['liked_products'] = $this->products->likedProducts();
        $result['categories'] = $this->products->categories();


  
        
       $result['min_price'] = $min_price;
        $result['max_price'] = $max_price;


        // add the manufactueres list here in $result ...

        return view("web.shop", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);

    }

    public function filterProducts(Request $request)
    {

        //min_price
        if (!empty($request->min_price)) {
            $min_price = $request->min_price;
        } else {
            $min_price = '';
        }

        //max_price
        if (!empty($request->max_price)) {
            $max_price = $request->max_price;
        } else {
            $max_price = '';
        }

        if (!empty($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 15;
        }

        if (!empty($request->type)) {
            $type = $request->type;
        } else {
            $type = '';
        }

        //if(!empty($request->category_id)){
        if (!empty($request->category) and $request->category != 'all') {
            $category = DB::table('categories')->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')->where('categories_slug', $request->category)->where('language_id', Session::get('language_id'))->get();

            $categories_id = $category[0]->categories_id;
        } else {
            $categories_id = '';
        }

        //search value
        if (!empty($request->search)) {
            $search = $request->search;
        } else {
            $search = '';
        }

        //min_price
        if (!empty($request->min_price)) {
            $min_price = $request->min_price;
        } else {
            $min_price = '';
        }

        //max_price
        if (!empty($request->max_price)) {
            $max_price = $request->max_price;
        } else {
            $max_price = '';
        }

        if (!empty($request->filters_applied) and $request->filters_applied == 1) {
            $filters['options_count'] = count($request->options_value);
            $filters['options'] = $request->options;
            $filters['option_value'] = $request->options_value;
            
           
        } else {
            $filters = array();
        }
        
        
          //max_price
        if (!empty($request->brands)) {
            $brands = $request->brands;
        } else {
            $brands = '';
        }



//start of discounts....
   $discounts=array();
        if ($request->has('one_ten_discounts')) {
        $discounts = [1,2,3,4,5,6,7,8,9,10];
        }
       
        if ($request->has('ten_twenty_discounts')) {
        $discounts = array_merge($discounts,[11,12,13,14,15,16,17,18,19,20]);
        }
       
        if ($request->has('twenty_thirty_discounts')) {
        $discounts = array_merge($discounts,[21,22,23,24,25,26,27,28,29,30]);
        }
        if ($request->has('thirty_fourty_discounts')) {
        $discounts = array_merge($discounts,[31,32,33,34,35,36,37,38,39,40]);
        }
        if ($request->has('fourty_fifty_discounts')) {
        $discounts = array_merge($discounts,[41,42,43,44,45,46,47,48,49,50]);
        }
       
 


//end of discounts..

        $data = array('page_number' => $request->page_number, 'type' => $type,'discounts'=>$discounts, 'limit' => $limit, 'categories_id' => $categories_id, 'search' => $search, 'filters' => $filters,'brands'=>$brands, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
       
    $result['brands']=$brands;
 $result['one_ten_discounts']=$request->has('one_ten_discounts');
 $result['ten_twenty_discounts']=$request->has('ten_twenty_discounts');
 $result['twenty_thirty_discounts']=$request->has('twenty_thirty_discounts');
 $result['thirty_fourty_discounts']=$request->has('thirty_fourty_discounts');
 $result['fourty_fifty_discounts']=$request->has('fourty_fifty_discounts');

        $products = $this->products->products($data);
        $result['products'] = $products;

        $cart = '';
        $result['cartArray'] = $this->products->cartIdArray($cart);
        $result['limit'] = $limit;
        $result['commonContent'] = $this->index->commonContent();
        return view("web.filterproducts")->with('result', $result);

    }

    public function ModalShow(Request $request)
    {
        $result = array();
       // $result['commonContent'] = $this->index->commonContent();
       
       
        $final_theme = $this->theme->theme();
        
        		$result['commonContent']=$final_theme['commonContent'];


        //min_price
        if (!empty($request->min_price)) {
            $min_price = $request->min_price;
        } else {
            $min_price = '';
        }

        //max_price
        if (!empty($request->max_price)) {
            $max_price = $request->max_price;
        } else {
            $max_price = '';
        }

        if (!empty($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 15;
        }

        $products = $this->products->getProductsById($request->products_id);

        $products = $this->products->getProductsBySlug($products[0]->products_slug);
        //category
        $category = $this->products->getCategoryByParent($products[0]->products_id);

        if (!empty($category) and count($category) > 0) {
            $category_slug = $category[0]->categories_slug;
            $category_name = $category[0]->categories_name;
        } else {
            $category_slug = '';
            $category_name = '';
        }
        $sub_category = $this->products->getSubCategoryByParent($products[0]->products_id);

        if (!empty($sub_category) and count($sub_category) > 0) {
            $sub_category_name = $sub_category[0]->categories_name;
            $sub_category_slug = $sub_category[0]->categories_slug;
        } else {
            $sub_category_name = '';
            $sub_category_slug = '';
        }

        $result['category_name'] = $category_name;
        $result['category_slug'] = $category_slug;
        $result['sub_category_name'] = $sub_category_name;
        $result['sub_category_slug'] = $sub_category_slug;

        $isFlash = $this->products->getFlashSale($products[0]->products_id);

        if (!empty($isFlash) and count($isFlash) > 0) {
            $type = "flashsale";
        } else {
            $type = "";
        }

        $data = array('page_number' => '0', 'type' => $type, 'products_id' => $products[0]->products_id, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
        $detail = $this->products->products($data);
        $result['detail'] = $detail;
        $postCategoryId = '';
        if (!empty($result['detail']['product_data'][0]->categories) and count($result['detail']['product_data'][0]->categories) > 0) {
            $i = 0;
            foreach ($result['detail']['product_data'][0]->categories as $postCategory) {
                if ($i == 0) {
                    $postCategoryId = $postCategory->categories_id;
                    $i++;
                }
            }
        }

        $data = array('page_number' => '0', 'type' => '', 'categories_id' => $postCategoryId, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
        $simliar_products = $this->products->products($data);
        $result['simliar_products'] = $simliar_products;

        $cart = '';
        $result['cartArray'] = $this->products->cartIdArray($cart);

        //liked products
        $result['liked_products'] = $this->products->likedProducts();
        return view("web.common.modal1")->with('result', $result);
    }

    //access object for custom pagination
    public function accessObjectArray($var)
    {
        return $var;
    }

     //productDetail
     public function productDetail(Request $request)
     {
 
         $title = array('pageTitle' => Lang::get('website.Product Detail'));
         $result = array();
        // $result['commonContent'] = $this->index->commonContent();
         $final_theme = $this->theme->theme();
         
         		$result['commonContent']=$final_theme['commonContent'];

         //min_price
         if (!empty($request->min_price)) {
             $min_price = $request->min_price;
         } else {
             $min_price = '';
         }
 
         //max_price
         if (!empty($request->max_price)) {
             $max_price = $request->max_price;
         } else {
             $max_price = '';
         }
 
         if (!empty($request->limit)) {
             $limit = $request->limit;
         } else {
             $limit = 15;
         }
 
         $products = $this->products->getProductsBySlug($request->slug);
         if(!empty($products) and count($products)>0){
             
             //category
             $category = $this->products->getCategoryByParent($products[0]->products_id);
 
             if (!empty($category) and count($category) > 0) {
                 $category_slug = $category[0]->categories_slug;
                 $category_name = $category[0]->categories_name;
             } else {
                 $category_slug = '';
                 $category_name = '';
             }
             $sub_category = $this->products->getSubCategoryByParent($products[0]->products_id);
 
             if (!empty($sub_category) and count($sub_category) > 0) {
                 $sub_category_name = $sub_category[0]->categories_name;
                 $sub_category_slug = $sub_category[0]->categories_slug;
             } else {
                 $sub_category_name = '';
                 $sub_category_slug = '';
             }
 
             $result['category_name'] = $category_name;
             $result['category_slug'] = $category_slug;
             $result['sub_category_name'] = $sub_category_name;
             $result['sub_category_slug'] = $sub_category_slug;
 
             $isFlash = $this->products->getFlashSale($products[0]->products_id);
 
             if (!empty($isFlash) and count($isFlash) > 0) {
                 $type = "flashsale";
             } else {
                 $type = "";
             }
             $postCategoryId = '';
             $data = array('page_number' => '0', 'type' => $type, 'products_id' => $products[0]->products_id, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
             $detail = $this->products->products($data);
             $result['detail'] = $detail;
             if (!empty($result['detail']['product_data'][0]->categories) and count($result['detail']['product_data'][0]->categories) > 0) {
                 $i = 0;
                 foreach ($result['detail']['product_data'][0]->categories as $postCategory) {
                     if ($i == 0) {
                         $postCategoryId = $postCategory->categories_id;
                         $i++;
                     }
                 }
             }
 
             $data = array('page_number' => '0', 'type' => '', 'categories_id' => $postCategoryId, 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
             $simliar_products = $this->products->products($data);
             $result['simliar_products'] = $simliar_products;
 
             $cart = '';
             $result['cartArray'] = $this->products->cartIdArray($cart);
 
             //liked products
             $result['liked_products'] = $this->products->likedProducts();
 
             $data = array('page_number' => '0', 'type' => 'topseller', 'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
             $top_seller = $this->products->products($data);
             $result['top_seller'] = $top_seller;		
         }else{
             $products = '';
             $result['detail']['product_data'] = '';
         }
         return view("web.detail", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
     }

    //filters
    public function filters($data)
    {
        $response = $this->products->filters($data);
        return ($response);
    }

    //getquantity
    public function getquantity(Request $request)
    {
        $data = array();
        $data['products_id'] = $request->products_id;
        $data['attributes'] = $request->attributeid;

        $result = $this->products->productQuantity($data);
        print_r(json_encode($result));
    }
    
    
    // NEW METHOD FOR SEARCH 
    
    
    
//search shop
    public function searchshop(Request $request)
    {
    	$title = array('pageTitle' => Lang::get('website.Shop'));
    	$result = array();
    	$categories_id="";
    	//   $result['commonContent'] = $this->index->commonContent();
    	$start = microtime(true);
    	$final_theme = $this->theme->theme();
    	
    
    	$result['commonContent']=$final_theme['commonContent'];
    	
    	$time = microtime(true) - $start;
     // echo "theme time:".$time;
    
    	if (!empty($request->page)) {
    		$page_number = $request->page;
    	} else {
    		$page_number = 0;
    	}
    
    	if (!empty($request->limit)) {
    		$limit = $request->limit;
    	} else {
    		$limit = 15;
    	}
    
    	if (!empty($request->type)) {
    		$type = $request->type;
    	} else {
    		$type = '';
    	}
    
    	//min_max_price
    	if (!empty($request->price)) {
    		$d = explode(";", $request->price);
    		$min_price = $d[0];
    		$max_price = $d[1];
    	} else {
    		$min_price = '';
    		$max_price = '';
    	}
    	$exist_category = '1';
    	$categories_status = 1;
    	 
    	//category
    	if (!empty($request->category) and $request->category != 'all') {
    		$category = $this->products->getCategories($request);
    
    		if(!empty($category) and count($category)>0){
    			$categories_id = $category[0]->categories_id;
    			//for main
    			if ($category[0]->parent_id == 0) {
    				$category_name = $category[0]->categories_name;
    				$category_description = $category[0]->description;
    				$sub_category_name = '';
    				$category_slug = '';
    				$categories_status = $category[0]->categories_status;
    			} else {
    				//for sub
    				$main_category = $this->products->getMainCategories($category[0]->parent_id);
    
    				$category_slug = $main_category[0]->categories_slug;
    				$category_name = $main_category[0]->categories_name;
    				$category_description = $category[0]->description;
    				$sub_category_name = $category[0]->categories_name;
    				$categories_status = $category[0]->categories_status;
    			}
    		}else{
    			$categories_id = '';
    			$category_name = '';
    			$sub_category_name = '';
    			$category_slug = '';
    			$categories_status = 0;
    			$category_description='';
    		}
    
    
    	} else {
    		$categories_id = '';
    		$category_name = '';
    		$sub_category_name = '';
    		$category_slug = '';
    		$categories_status = 1;
    		$category_description='';
    	}
    
    	$result['category_name'] = $category_name;
    	$result['category_slug'] = $category_slug;
    	$result['sub_category_name'] = $sub_category_name;
    	$result['categories_status'] = $categories_status;
    	$result['category_description'] = $category_description;
    
    	//search value
    	if (!empty($request->search)) {
    		$search = $request->search;
    	} else {
    		$search = '';
    	}
    
    	$filters = array();
    	if (!empty($request->filters_applied) and $request->filters_applied == 1) {
    		$index = 0;
    		$options = array();
    		$option_values = array();
    
    		$option = $this->products->getOptions();
    
    		foreach ($option as $key => $options_data) {
    			$option_name = str_replace(' ', '_', $options_data->products_options_name);
    
    			if (!empty($request->$option_name)) {
    				$index2 = 0;
    				$values = array();
    				foreach ($request->$option_name as $value) {
    					$value = $this->products->getOptionsValues($value);
    					$option_values[] = $value[0]->products_options_values_id;
    				}
    				$options[] = $options_data->products_options_id;
    			}
    		}
    		// $filters['options'] = implode($options, ',');
    		//  $filters['option_value'] = implode($option_values, ',');
    		 
    		 
    		$filters['options_count'] = count($options);
    		if( count($options)>0){
    			$filters['options'] = implode($options, ',');
    		}else{
    			$filters['options'] =array();
    		}
    
    		if(count($options)>0){
    			$filters['option_value'] = implode($option_values, ',');
    
    		}else{
    			$filters['option_value'] = array();
    		}
    
    		$filters['filter_attribute']['options'] = $options;
    		$filters['filter_attribute']['option_values'] = $option_values;
    
    		$result['filter_attribute']['options'] = $options;
    		$result['filter_attribute']['option_values'] = $option_values;
    	}
    
    
    	//max_price
    	if (!empty($request->brands)) {
    		$brands = $request->brands;
    	} else {
    		$brands = '';
    	}
    
    
    	$data = array('page_number' => $page_number, 'type' => $type, 'limit' => $limit,
    			'categories_id' => $categories_id, 'search' => $search,
    			'filters' => $filters,'brands'=>$brands,'limit' => $limit, 'min_price' => $min_price, 'max_price' => $max_price);
    
    
    	$result['brands']=$brands;
    	$products = $this->products->searchproducts($data);
    	$result['products'] = $products;
    
    	$data = array('limit' => $limit, 'categories_id' => $categories_id);
    	$filters = $this->searchfilters($data);
    
    	//for inner pages promotional banners
    	$promotional_banners = DB::table('promotional_banners')
    	->leftJoin('image_categories', 'promotional_banners.image_id', '=', 'image_categories.image_id')
    	->select( 'promotional_banners.*', 'image_categories.path')
    	->where('promotional_banners.category_id','=',$categories_id)
    	->first();
    	$result['promotional_banners'] = $promotional_banners;
    
    
    	$manufacturers = DB::table('manufacturers')
    	->leftJoin('manufacturers_info', 'manufacturers_info.manufacturers_id', 'manufacturers.manufacturers_id')
    	->leftJoin('products', 'products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
    	->join('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
    
    	->select('manufacturers.*', 'manufacturers_info.*')
    	->where('products_to_categories.categories_id', '=', $categories_id)
    	->distinct()
    	->get();
    
    
    	/*  if (isset($categories_id) and !empty($categories_id)) {
    	 $manufacturers->where('products_to_categories.categories_id', '=', $categories_id);
    	 }
    	 */
    	$result['manufacturers'] = $manufacturers;
    
    
    
    	$result['filters'] = $filters;
    
    	$cart = '';
    	$result['cartArray'] = $this->products->cartIdArray($cart);
    
    	if ($limit > $result['products']['total_record']) {
    		$result['limit'] = $result['products']['total_record'];
    	} else {
    		$result['limit'] = $limit;
    	}
    
    	//liked products
    	//   $result['liked_products'] = $this->products->likedProducts();
    	$result['categories'] = $this->products->categories();
    
    	$result['min_price'] = $min_price;
    	$result['max_price'] = $max_price;
    
    
    	// add the manufactueres list here in $result ...
    
    	return view("web.shop", ['title' => $title, 'final_theme' => $final_theme])->with('result', $result);
    
    }
    
    //search filters
    public function searchfilters($data)
    {
    	$response = $this->products->searchfilters($data);
    
    	return ($response);
    }
	

}
