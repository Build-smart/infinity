<?php
namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\Categories;
use App\Models\Core\Images;
//for password encryption or hash protected
use App\Models\Core\Languages;
use App\Models\Core\Products;
use App\Models\Core\Setting;
use DB;
use Illuminate\Http\Request;

//for authenitcate login data
use Lang;

//for requesting a value

class PromotionalBannerController extends Controller
{

    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    //listingTaxClass
    public function promotionalbanners(Request $request)
    {
        $title = array('pageTitle' => "Promotional Banners");

        $result = array();
        $message = array();

        

        $promotionalbanner = DB::table('promotional_banners')
        ->leftJoin('categories_description', 'promotional_banners.category_id', '=', 'categories_description.categories_id')
->LeftJoin('image_categories as web_prom_banner', function ($join) {
                $join->on('web_prom_banner.image_id', '=', 'promotional_banners.image_id')
                    ->where(function ($query) {
                        $query->where('web_prom_banner.image_type', '=', 'THUMBNAIL')
                            ->where('web_prom_banner.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('web_prom_banner.image_type', '=', 'ACTUAL');
                    });
            })
            ->LeftJoin('image_categories as app_prom_banner', function ($join) {
                $join->on('app_prom_banner.image_id', '=', 'promotional_banners.app_image_id')
                    ->where(function ($query) {
                        $query->where('app_prom_banner.image_type', '=', 'THUMBNAIL')
                            ->where('app_prom_banner.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('app_prom_banner.image_type', '=', 'ACTUAL');
                    });
            })
        ->select('promotional_banners.*', 'web_prom_banner.path as web_path','app_prom_banner.path as app_path','categories_description.categories_name')
        ->where('categories_description.language_id','1')
      

        ->orderBy('promotional_banners.id','ASC');
            
        

        $promotionalbanners = $promotionalbanner->get();

        $result['message'] = $message;
        $result['promotionalbanners'] = $promotionalbanners;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.settings.web.promotionalbanners.index", $title)->with('result', $result);
    }

    //addTaxClass
    public function addpromotionalbannerimage(Request $request)
    {
        $title = array('pageTitle' => "Add Promotional Banner");

        $result = array();
        $message = array();

      
        $categories = DB::table('categories')
        ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
        ->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.created_at as date_added', 'categories.updated_at as last_modified', 'categories_description.categories_name as name', 'categories.categories_slug as slug'
        		, 'categories.parent_id')
        		->where('categories_description.language_id','=', 1 )
        		 
        		->where('categories_status', '1')
        		->get();

   //     $images = new Images();
    //    $allimage = $images->getimages();

       
        

        $result['message'] = $message;
        $result['categories'] = $categories;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.settings.web.promotionalbanners.add", $title)->with(['result' => $result]);
    }

    //addNewZone
    public function addNewpromotionalbanner(Request $request)
    {

      //  $images = new Images();
      //  $allimage = $images->getimages();

      
        if ($request->image_id) {
            $uploadImage = $request->image_id;
        } else {
            $uploadImage = '';
        }

        if ($request->app_image_id) {
        	$appuploadImage = $request->app_image_id;
        } else {
        	$appuploadImage = '';
        }
        
        

        DB::table('promotional_banners')->insert([
            'category_id' => $request->category_id,
            'date_added' => date('Y-m-d H:i:s'),
            'image_id' => $uploadImage,
        		'app_image_id' => $appuploadImage,
            
        ]);

        $message = " Promotional Banner Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editTaxClass
    public function editpromotionalbanner(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditSliderImage"));
        $result = array();
        $result['message'] = array();

        $promotionalbanner = DB::table('promotional_banners')
          ->leftJoin('categories_description', 'promotional_banners.category_id', '=', 'categories_description.categories_id')
         ->leftJoin('image_categories as web_prom_banner', 'promotional_banners.image_id', '=', 'web_prom_banner.image_id')
         ->leftJoin('image_categories as app_prom_banner', 'promotional_banners.app_image_id', '=', 'app_prom_banner.image_id')
          ->select('promotional_banners.*', 'web_prom_banner.path as web_path', 'app_prom_banner.path as app_path','categories_description.categories_name')
        ->where('categories_description.language_id','1')
       	->where('promotional_banners.id', $request->id)
         ->first();
        $result['promotionalbanners'] = $promotionalbanner;

       
        
        
        $categories = DB::table('categories')
        ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
        ->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.created_at as date_added', 'categories.updated_at as last_modified', 'categories_description.categories_name as name', 'categories.categories_slug as slug'
        		, 'categories.parent_id')
        		->where('categories_description.language_id','=', 1 )
        		 
        		->where('categories_status', '1')
        		->get();
        
        	 
        
      //  $images = new Images();
      //  $allimage = $images->getimages();

        
       
        $result['categories'] = $categories;
      
        $result['commonContent'] = $this->Setting->commonContent();

        return view('admin.settings.web.promotionalbanners.edit', $title)->with(['result' => $result]);
    }

    public function updatepromotionalbanner(Request $request)
    {
        

        if ($request->image_id) {
            $uploadImage = $request->image_id;
            $countryUpdate = DB::table('promotional_banners')->where('id', $request->id)->update([
                 'category_id' => $request->category_id,
            'date_added' => date('Y-m-d H:i:s'),
            'image_id' => $uploadImage,
            ]);
        } else {
            $countryUpdate = DB::table('promotional_banners')->where('id', $request->id)->update([
               'category_id' => $request->category_id,
            'date_added' => date('Y-m-d H:i:s'),
            ]);
        }
        
        
        if ($request->app_image_id) {
        	$appuploadImage = $request->app_image_id;
        	$countryUpdate = DB::table('promotional_banners')->where('id', $request->id)->update([
        			'category_id' => $request->category_id,
        			'date_added' => date('Y-m-d H:i:s'),
        			'app_image_id' => $appuploadImage,
        	]);
        } else {
        	$countryUpdate = DB::table('promotional_banners')->where('id', $request->id)->update([
        			'category_id' => $request->category_id,
        			'date_added' => date('Y-m-d H:i:s'),
        	]);
        }

        $message = "Promotional Banner Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteCountry
    public function deletepromotionalbanner(Request $request)
    {
        DB::table('promotional_banners')->where('id', $request->id)->delete();
        return redirect()->back()->withErrors("Promotional Banner Deleted Successfully");
    }
}
