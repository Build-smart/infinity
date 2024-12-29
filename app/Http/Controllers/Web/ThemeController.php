<?php
namespace App\Http\Controllers\Web;

use App\Models\Web\Currency;
use App\Models\Web\Index;
use App\Models\Web\Languages;
use App\Models\Web\News;
use App\Models\Web\Products;
use Auth;
use Carbon;
use Illuminate\Routing\Controller;
use Lang;
use View;
use App\Models\Web\Locations;
use DB;
class ThemeController extends Controller
{
  
 
   
     
    public function theme()
    {
		
		
		    

        $index = new Index();
		
		     $commonContent = $index->commonContent();
			
			
        $data = $index->finalTheme();
        $header_id = $data->header;
        $carousel_id = $data->carousel;
        $banner_id = $data->banner;
        $footer_id = $data->footer;
        $cart = $data->cart;
        $blog = $data->news;
        $detail = $data->detail;
        $shop = $data->shop;
        $contact = $data->contact;
        $login = $data->login;
        $transitions = $data->transitions;
        $product_section_order = $data->product_section_order;
        $top_offer = $this->setTopOffer($commonContent);
        $header = $this->setHeader($commonContent,$header_id);
        $mobileheader = $this->mobileHeader($commonContent);
        $carousel = $this->setCarousal($commonContent,$carousel_id);
        $banner = $this->setBanner($commonContent,$banner_id);
        $footer = $this->setFooter($commonContent,$footer_id);
        $mobilefooter = $this->mobileFooter($commonContent);       
        $final_theme = array(
            'top_offer' => $top_offer,
            'header' => $header,
            'mobile_header' => $mobileheader,
            'carousel' => $carousel,
            'banner' => $banner,
            'footer' => $footer,
            'mobile_footer' => $mobilefooter,
            'cart' => $cart,
            'blog' => $blog,
            'detail' => $detail,
            'shop' => $shop,
            'contact' => $contact,
            'login'=>$login,
            'transitions'=>$transitions,
            'product_section_order' => $product_section_order,
			'commonContent'=>$commonContent,
        );

        return ($final_theme);
    }

    private function setTopOffer($commonContent)
    {
        $index = new Index();
		$result['commonContent'] = $commonContent;
        $top_offer = (string) View::make('web.headers.topoffer', ['result' => $result])->render();
        return $top_offer;
    }

    private function setHeader($commonContent,$header_id)
    { 
        
        
        $index = new Index();
        $languages = new Languages();
        $locations = new Locations();
        $products = new Products();
        $currencies = new Currency();
        
   
 		 
		

        $languages = $languages->languages();
        //get all locations
        $locations = $locations->locations();
        $currencies = $currencies->getter();
        $productcategories = $products->productCategories();
        
          $totalcashback_amount="";
          $remainingwallet_amount="";
          
        if (Auth::guard('customer')->check()) {
            $count = $index->compareCount();
            
            
            
                 
            //cashback code
            
            $login_id=auth()->guard('customer')->user()->id;
            
           $cashback_amount = DB::table('orders')
            ->where('orders.customers_id', '=', $login_id)
            ->sum('orders.cashback_amount');
            
            

            $cashback_paidamount = DB::table('cashback_transactions')
            ->where('cashback_transactions.user_id', '=', $login_id)
            ->sum('cashback_transactions.request_amount');
             
             
            $totalcashback_amount= $cashback_amount - $cashback_paidamount;
             
			   
            $wallet_amount = DB::table('wallet')
            ->where('wallet.customer_id', '=', $login_id)
            ->sum('wallet.wallet_amount');
            
//             $orders_amount = DB::table('orders')
//             ->where('orders.customers_id', '=', $login_id)
//             ->where('orders.payment_method', '=', "Buildermart Wallet")
//             ->sum('orders.order_price');
            $orders_amount = DB::table('orders')
            ->leftjoin('orders_status_history','orders_status_history.orders_id','=','orders.orders_id')
            ->where('orders.customers_id', '=', $login_id)
            ->where('orders.payment_method', '=', "Buildermart Wallet")
            ->where('orders_status_history.orders_status_id','!=',3)
            ->where('orders_status_history.current_status',1)
            ->sum('orders.order_price');
    
            
            $remainingwallet_amount = $wallet_amount- $orders_amount;
            
			
			
            //cashback code
            
            
            
        } else {
            $count = "";
        }
        $title = array('pageTitle' => Lang::get("website.Home"));
        $result = array();
        $result['commonContent'] = $commonContent;

       /*  if ($header_id == 1) {

            $header = (string) View::make('web.headers.headerOne', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 2) {
            $header = (string) View::make('web.headers.headerTwo', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 3) {
            $header = (string) View::make('web.headers.headerThree', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 4) {
            $header = (string) View::make('web.headers.headerFour', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 5) {
            $header = (string) View::make('web.headers.headerFive', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 6) {
            $header = (string) View::make('web.headers.headerSix', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 7) {
            $header = (string) View::make('web.headers.headerSeven', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 8) {
            $header = (string) View::make('web.headers.headerEight', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } elseif ($header_id == 9) {
            $header = (string) View::make('web.headers.headerNine', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } else {
            $header = (string) View::make('web.headers.headerTen', ['default_locations'=>$default_locations,'locations'=>$locations,'count' => $count, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        } 
        */
 
 
 $header = (string) View::make('web.headers.headerSix', ['locations'=>$locations,'count' => $count,'remainingwallet_amount'=>$remainingwallet_amount, 'totalcashback_amount'=>$totalcashback_amount,'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories, 'result' => $result])->render();
        return $header;
    
        
        
    }

    private function mobileHeader($commonContent)
    {
        $index = new Index();
        $languages = new Languages();
        $products = new Products();
        $locations = new Locations();
        $currencies = new Currency();

        $languages = $languages->languages();
        $currencies = $currencies->getter();
        $productcategories = $products->productCategories();
        if (Auth::guard('customer')->check()) {
            $count = $index->compareCount();
        } else {
            $count = "";
        }
        
        //set a default location hyderabad
        $default_locations = DB::table('location')
        ->where('location.is_default','=',1)
        ->first();
        
        //get all locations
        $locations = $locations->locations();
        
        
         $remainingwallet_amount="";
            
        $totalcashback_amount="";
         if (Auth::guard('customer')->check()) {
        	$count = $index->compareCount();
        
        
        
        	 
        	//cashback code
        
        	$login_id=auth()->guard('customer')->user()->id;
        
        	$cashback_amount = DB::table('orders')
        	->where('orders.customers_id', '=', $login_id)
        	->sum('orders.cashback_amount');
        	
        $cashback_paidamount = DB::table('cashback_transactions')
        	->where('cashback_transactions.user_id', '=', $login_id)
        	->sum('cashback_transactions.request_amount');
        	 
        	 
        	$totalcashback_amount= $cashback_amount - $cashback_paidamount;
        	 
        
        	$wallet_amount = DB::table('wallet')
        	->where('wallet.customer_id', '=', $login_id)
        	->sum('wallet.wallet_amount');
        
        	$orders_amount = DB::table('orders')
        	->where('orders.customers_id', '=', $login_id)
        	->where('orders.payment_method', '=', "Buildermart Wallet")
        	->sum('orders.order_price');
        
        
        
        	$remainingwallet_amount = $wallet_amount- $orders_amount;
        
        		
        		
        	//cashback code
        
        
        
        } else {
        	$count = "";
        }
        
        $title = array('pageTitle' => Lang::get("website.Home"));
        $result = array();
        $result['commonContent'] = $commonContent;
        $header = (string) View::make('web.headers.mobile', ['count' => $count,'remainingwallet_amount'=>$remainingwallet_amount, 'totalcashback_amount'=>$totalcashback_amount, 'currencies' => $currencies, 'languages' => $languages, 'productcategories' => $productcategories,'default_locations'=>$default_locations,'locations'=>$locations, 'result' => $result])->render();
        return $header;
    }

    private function setCarousal($commonContent,$carousel_id)
    {
        $languages = new Languages();
        $products = new Products();
        $currencies = new Currency();
        $index = new Index();
        $result['commonContent'] = $commonContent;
        $currentDate = Carbon\Carbon::now();
        $currentDate = $currentDate->toDateTimeString();
        $slides = $index->slidesByCarousel($currentDate, $carousel_id);
        $cates = $products->productCategories1();
        $result['cat'] = $cates;

        $result['slides'] = $slides;
        if ($carousel_id == 1) {
            $carousel = (string) View::make('web.carousels.boot-carousel-content-full-screen', ['result' => $result])->render();
        } elseif ($carousel_id == 2) {
            $carousel = (string) View::make('web.carousels.boot-carousel-content-full-width', ['result' => $result])->render();
        } elseif ($carousel_id == 3) {
            $carousel = (string) View::make('web.carousels.boot-carousel-content-with-left-banner', ['result' => $result])->render();
        } elseif ($carousel_id == 4) {

            $carousel = (string) View::make('web.carousels.boot-carousel-content-with-navigation', ['result' => $result])->render();
        } else {
            $carousel = (string) View::make('web.carousels.boot-carousel-content-with-right-banner', ['result' => $result])->render();
        }
        return $carousel;
    }

    private function setBanner($commonContent,$banner_id)
    {
        $index = new Index();
        $result['commonContent'] = $commonContent;

        if ($banner_id == 1) {
            $banner = (string) View::make('web.banners.banner1', ['result' => $result])->render();
        } elseif ($banner_id == 2) {
            $banner = (string) View::make('web.banners.banner2', ['result' => $result])->render();
        } elseif ($banner_id == 3) {
            $banner = (string) View::make('web.banners.banner3', ['result' => $result])->render();
        } elseif ($banner_id == 4) {
            $banner = (string) View::make('web.banners.banner4', ['result' => $result])->render();
        } elseif ($banner_id == 5) {
            $banner = (string) View::make('web.banners.banner5', ['result' => $result])->render();
        } elseif ($banner_id == 6) {
            $banner = (string) View::make('web.banners.banner6', ['result' => $result])->render();
        } elseif ($banner_id == 7) {
            $banner = (string) View::make('web.banners.banner7', ['result' => $result])->render();
        } elseif ($banner_id == 8) {
            $banner = (string) View::make('web.banners.banner8', ['result' => $result])->render();
        } elseif ($banner_id == 9) {
            $banner = (string) View::make('web.banners.banner9', ['result' => $result])->render();
        } elseif ($banner_id == 10) {
            $banner = (string) View::make('web.banners.banner10', ['result' => $result])->render();
        } elseif ($banner_id == 11) {
            $banner = (string) View::make('web.banners.banner11', ['result' => $result])->render();
        } elseif ($banner_id == 12) {
            $banner = (string) View::make('web.banners.banner12', ['result' => $result])->render();
        } elseif ($banner_id == 13) {
            $banner = (string) View::make('web.banners.banner13', ['result' => $result])->render();
        } elseif ($banner_id == 14) {
            $banner = (string) View::make('web.banners.banner14', ['result' => $result])->render();
        } elseif ($banner_id == 15) {
            $banner = (string) View::make('web.banners.banner15', ['result' => $result])->render();
        } elseif ($banner_id == 16) {
            $banner = (string) View::make('web.banners.banner16', ['result' => $result])->render();
        } elseif ($banner_id == 17) {
            $banner = (string) View::make('web.banners.banner17', ['result' => $result])->render();
        } elseif ($banner_id == 18) {
            $banner = (string) View::make('web.banners.banner18', ['result' => $result])->render();
        } elseif ($banner_id == 19) {
            $banner = (string) View::make('web.banners.banner19', ['result' => $result])->render();
        } else {
            $banner = (string) View::make('web.banners.banner20', ['result' => $result])->render();
        }
        return $banner;
    }

    private function setFooter($commonContent,$footer_id)
    {
        $index = new Index();
        $newss = new News();
        $products = new Products();
        $result['commonContent'] = $commonContent;
        $categories_id = '';
        $categories_name = '';
        $limit = 16;
        $type = '';
        $data = array('page_number' => 0, 'type' => $type, 'is_feature' => '', 'limit' => $limit, 'categories_id' => $categories_id, 'load_news' => 0);
      //  $news = $newss->getAllNews($data);
		
		$news=$commonContent['featuredNews'];
		
        $result['news'] = $news;
     //   $result['categories'] = $products->categories();
		
	$result['categories']=	$commonContent['categories'];

        if ($footer_id == 1) {
            $footer = (string) View::make('web.footers.footer1', ['result' => $result])->render();
        } elseif ($footer_id == 2) {
            $footer = (string) View::make('web.footers.footer2', ['result' => $result])->render();
        } elseif ($footer_id == 3) {
            $footer = (string) View::make('web.footers.footer3', ['result' => $result])->render();
        } elseif ($footer_id == 4) {
            $footer = (string) View::make('web.footers.footer4', ['result' => $result])->render();
        } elseif ($footer_id == 5) {
            $footer = (string) View::make('web.footers.footer5', ['result' => $result])->render();
        } elseif ($footer_id == 6) {
            $footer = (string) View::make('web.footers.footer6', ['result' => $result])->render();
        } elseif ($footer_id == 7) {
            $footer = (string) View::make('web.footers.footer7', ['result' => $result])->render();
        } elseif ($footer_id == 8) {
            $footer = (string) View::make('web.footers.footer8', ['result' => $result])->render();
        } elseif ($footer_id == 9) {
            $footer = (string) View::make('web.footers.footer9', ['result' => $result])->render();
        } else {
            $footer = (string) View::make('web.footers.footer10', ['result' => $result])->render();
        }
        return $footer;
    }

    private function mobileFooter($commonContent)
    {
        $index = new Index();
        $result['commonContent'] = $commonContent;
        $footer = (string) View::make('web.footers.mobile', ['result' => $result])->render();
        return $footer;
    }

}
