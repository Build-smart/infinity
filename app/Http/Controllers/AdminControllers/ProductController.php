<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Categories;
use App\Models\Core\Images;
use App\Models\Core\Languages;
use App\Models\Core\Manufacturers;
use App\Models\Core\Products;
use App\Models\Core\Reviews;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ProductController extends Controller
{

    public function __construct(Products $products, Languages $language, Images $images, Categories $category, Setting $setting,
        Manufacturers $manufacturer, Reviews $reviews) {
        $this->category = $category;
        $this->reviews = $reviews;
        $this->language = $language;
        $this->images = $images;
        $this->manufacturer = $manufacturer;
        $this->products = $products;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->myVaralter = new AlertController($setting);
        $this->Setting = $setting;

    }

    public function reviews(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.reviews"));
        $result = array();
        $data = $this->reviews->paginator();
        $result['reviews'] = $data;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.reviews.index", $title)->with('result', $result);

    }

    public function editreviews($id, $status)
    {
        if ($status == 1) {
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_status' => 1,
                ]);
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_read' => 1,
                ]);
        } elseif ($status == 0) {
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_read' => 1,
                ]);
        } else {
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_read' => 1,
                    'reviews_status' => -1,
                ]);
        }
        $message = Lang::get("labels.reviewupdateMessage");
        return redirect()->back()->withErrors([$message]);

    }

    public function display(Request $request)
    {
        $language_id = '1';
        $categories_id = $request->categories_id;
        $product = $request->product;
        $title = array('pageTitle' => Lang::get("labels.Products"));
        $subCategories = $this->category->allcategories($language_id);
        $products = $this->products->paginator($request);
        $results['products'] = $products;
        $results['currency'] = $this->myVarsetting->getSetting();
        $results['units'] = $this->myVarsetting->getUnits();
        $results['subCategories'] = $subCategories;
        
                $locations=DB::table('location')->get();
        $results['locations'] =$locations;
        
        $currentTime = array('currentTime' => time());
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.index", $title)->with('result', $result)->with('results', $results)->with('categories_id', $categories_id)->with('product', $product);

    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddProduct"));
        $language_id = '1';
        $allimage = $this->images->getimages();
        $result = array();
        $categories = $this->category->recursivecategories($request);

        $parent_id = array();
        $option = '<ul class="list-group list-group-root well">';

        foreach ($categories as $parents) {

            if (in_array($parents->categories_id, $parent_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $option .= '<li href="#" class="list-group-item">
          <label style="width:100%">
            <input id="categories_' . $parents->categories_id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->categories_id . '">
          ' . $parents->categories_name . '
          </label></li>';

            if (isset($parents->childs)) {
                $option .= '<ul class="list-group">
          <li class="list-group-item">';
                $option .= $this->childcat($parents->childs, $parent_id);
                $option .= '</li></ul>';
            }
        }
        $option .= '</ul>';

        $result['categories'] = $option;

        $result['manufacturer'] = $this->manufacturer->getter($language_id);
        $taxClass = DB::table('tax_class')->get();
        $result['taxClass'] = $taxClass;
        $result['languages'] = $this->myVarsetting->getLanguages();
        $result['units'] = $this->myVarsetting->getUnits();
        $result['commonContent'] = $this->Setting->commonContent();
        
                $result['locations'] = $this->myVarsetting->getlocations();

        $distributors = DB::table('users')->where('customer_type','DISTRIBUTOR')->where('status','1')->get();
                $result['distributors'] = $distributors;
                
                
                
        return view("admin.products.add", $title)->with('result', $result)->with('allimage', $allimage);

    }

    public function childcat($childs, $parent_id)
    {

        $contents = '';
        foreach ($childs as $key => $child) {

            if (in_array($child->categories_id, $parent_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $contents .= '<label> <input id="categories_' . $child->categories_id . '" parents_id="' . $child->parent_id . '"  type="checkbox" name="categories[]" class="required_one sub_categories categories sub_categories_' . $child->parent_id . '" value="' . $child->categories_id . '" ' . $checked . '> ' . $child->categories_name . '</label>';

            if (isset($child->childs)) {
                $contents .= '<ul class="list-group">
        <li class="list-group-item">';
                $contents .= $this->childcat($child->childs, $parent_id);
                $contents .= "</li></ul>";
            }

        }
        return $contents;
    }

    public function edit(Request $request)
    {
       // $allimage = $this->images->getimages();
        $result = $this->products->edit($request);
        //dd($result['categories_array']);
        $categories = $this->category->recursivecategories($request);

        $parent_id = $result['categories_array'];
        $option = '<ul class="list-group list-group-root well">';

        foreach ($categories as $parents) {

            if (in_array($parents->categories_id, $parent_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $option .= '<li href="#" class="list-group-item">
        <label style="width:100%">
          <input id="categories_' . $parents->categories_id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->categories_id . '">
        ' . $parents->categories_name . '
        </label></li>';

            if (isset($parents->childs)) {
                $option .= '<ul class="list-group">
        <li class="list-group-item">';
                $option .= $this->childcat($parents->childs, $parent_id);
                $option .= '</li></ul>';
            }
        }

        $option .= '</ul>';
        $result['categories'] = $option;
        $title = array('pageTitle' => Lang::get("labels.EditProduct"));
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.edit", $title)->with('result', $result);

    }

    public function update(Request $request)
    {
        $result = $this->products->updaterecord($request);
        $products_id = $request->id;
        if ($request->products_type == 1) {
            return redirect('admin/products/attach/attribute/display/' . $products_id);
        } else {
            return redirect('admin/products/images/display/' . $products_id);
        }
    }

    public function delete(Request $request)
    {
        $this->products->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.ProducthasbeendeletedMessage")]);

    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddAttributes"));
        $language_id = '1';
        $products_id = $this->products->insert($request);
        $result['data'] = array('products_id' => $products_id, 'language_id' => $language_id);
        $alertSetting = $this->myVaralter->newProductNotification($products_id);
        if ($request->products_type == 1) {
            return redirect('/admin/products/attach/attribute/display/' . $products_id);
        } else {
            return redirect('admin/products/images/display/' . $products_id);
        }
    }

    public function addinventory(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        $id = $request->id;
        $result = $this->products->addinventory($id);
        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.inventory.add", $title)->with('result', $result);

    }

    public function ajax_min_max($id)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        $result = $this->products->ajax_min_max($id);
        return $result;

    }

    public function ajax_attr($id)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        $result = $this->products->ajax_attr($id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.inventory.attribute_div")->with('result', $result);

    }

    public function addinventoryfromsidebar(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        
       // commented on april 13 2022 as the product list is an ajax call.
       // no prepopulated products will be showcased....
       // $result = $this->products->addinventoryfromsidebar();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.inventory.add1", $title)->with('result', $result);

    }

    public function addnewstock(Request $request)
    {

        $this->products->addnewstock($request);
        return redirect()->back()->withErrors([Lang::get("labels.inventoryaddedsuccessfully")]);

    }

    public function addminmax(Request $request)
    {

       //dd($request);
       $this->products->addminmax($request);
       return redirect()->back()->withErrors([Lang::get("labels.Min max level added successfully")]);

    }

    public function displayProductImages(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddImages"));
        $products_id = $request->id;
        $result = $this->products->displayProductImages($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products/images/index", $title)->with('result', $result)->with('products_id', $products_id);

    }

    public function addProductImages($products_id)
    {
        $title = array('pageTitle' => Lang::get("labels.AddImages"));
     //   $allimage = $this->images->getimages();
        $result = $this->products->addProductImages($products_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view('admin.products.images.add', $title)->with('result', $result)->with('products_id', $products_id);

    }

    public function insertProductImages(Request $request)
    {
        $product_id = $this->products->insertProductImages($request);
        return redirect()->back()->with('product_id', $product_id);
    }

    public function editProductImages($id)
    {

      //  $allimage = $this->images->getimages();
        $products_images = $this->products->editProductImages($id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/images/edit")->with('products_images', $products_images)->with('result', $result);

    }

    public function updateproductimage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.Manage Values"));
        $result = $this->products->updateproductimage($request);
        return redirect()->back();

    }

    public function deleteproductimagemodal(Request $request)
    {

        $products_id = $request->products_id;
        $id = $request->id;
        $result['data'] = array('products_id' => $products_id, 'id' => $id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/images/modal/delete")->with('result', $result);

    }

    public function deleteproductimage(Request $request)
    {
        $this->products->deleteproductimage($request);
        return redirect()->back()->with('success', trans('labels.DeletedSuccessfully'));

    }

    public function addproductattribute(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddAttributes"));
        $result = $this->products->addproductattribute($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.attribute.add", $title)->with('result', $result);
    }

    public function addnewdefaultattribute(Request $request)
    {
        $products_attributes = $this->products->addnewdefaultattribute($request);
        return ($products_attributes);
    }

    public function editdefaultattribute(Request $request)
    {
        $result = $this->products->editdefaultattribute($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/pop_up_forms/editdefaultattributeform")->with('result', $result);
    }

    public function updatedefaultattribute(Request $request)
    {
        $products_attributes = $this->products->updatedefaultattribute($request);
        return ($products_attributes);

    }

    public function deletedefaultattributemodal(Request $request)
    {

        $products_id = $request->products_id;
        $products_attributes_id = $request->products_attributes_id;
        $result['data'] = array('products_id' => $products_id, 'products_attributes_id' => $products_attributes_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/modals/deletedefaultattributemodal")->with('result', $result);

    }

    public function deletedefaultattribute(Request $request)
    {
        $products_attributes = $this->products->deletedefaultattribute($request);
        return ($products_attributes);
    }

    public function showoptions(Request $request)
    {
        $products_attributes = $this->products->showoptions($request);
        return ($products_attributes);
    }

    public function editoptionform(Request $request)
    {
        $result = $this->products->editoptionform($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/pop_up_forms/editproductattributeoptionform")->with('result', $result);

    }

    public function updateoption(Request $request)
    {
        $products_attributes = $this->products->updateoption($request);
        return ($products_attributes);
    }

    public function showdeletemodal(Request $request)
    {

        $products_id = $request->products_id;
        $products_attributes_id = $request->products_attributes_id;
        $result['data'] = array('products_id' => $products_id, 'products_attributes_id' => $products_attributes_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/modals/deleteproductattributemodal")->with('result', $result);

    }

    public function deleteoption(Request $request)
    {

        $products_attributes = $this->products->deleteoption($request);
        return ($products_attributes);

    }

    public function getOptionsValue(Request $request)
    {
        $value = $this->products->getOptionsValue($request);
        if (count($value) > 0) {
            foreach ($value as $value_data) {
                $value_name[] = "<option value='" . $value_data->products_options_values_id . "'>" . $value_data->options_values_name . "</option>";
            }
        } else {
            $value_name = "<option value=''>" . Lang::get("labels.ChooseValue") . "</option>";
        }
        print_r($value_name);
    }

    public function currentstock(Request $request)
    {

        $result = $this->products->currentstock($request);
        print_r(json_encode($result));

    }
    
    
    //for new location 
    
     public function addfornewlocation(Request $request)
    {
    //	$allimage = $this->images->getimages();
    	$result = $this->products->edit($request);
    	//dd($result['categories_array']);
    	$categories = $this->category->recursivecategories($request);
    
    	$parent_id = $result['categories_array'];
    	$option = '<ul class="list-group list-group-root well">';
    
    	foreach ($categories as $parents) {
    
    		if (in_array($parents->categories_id, $parent_id)) {
    			$checked = 'checked';
    		} else {
    			$checked = '';
    		}
    
    		$option .= '<li href="#" class="list-group-item">
        <label style="width:100%">
          <input id="categories_' . $parents->categories_id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->categories_id . '">
        ' . $parents->categories_name . '
        </label></li>';
    
    		if (isset($parents->childs)) {
    			$option .= '<ul class="list-group">
        <li class="list-group-item">';
    			$option .= $this->childcat($parents->childs, $parent_id);
    			$option .= '</li></ul>';
    		}
    	}
    
    	$option .= '</ul>';
    	$result['categories'] = $option;
    	$title = array('pageTitle' => Lang::get("labels.EditProduct"));
    	$result['commonContent'] = $this->Setting->commonContent();
    	return view("admin.products.addfornewlocation", $title)->with('result', $result);
    
    }
    
    
    
    
     public function productpriceupdate(Request $request)
    { 
    	$products_id=$request->data_id;
    	
    	$products_price= $request->productprice;
    	
    	
    	 
    	
    	$data =   DB::table('products')->where('products_id', '=', $products_id)->update([
              
              'products_price' => $products_price,
              
          ]);
    		
    	if($data){
    			
    		$data=array('status' => "SUCCESS", 'content' => $data);
    
    	}else{
    			
    		$data=array('status' => "FAIL", 'content' => $data);
    	}
    	 
    	return response()->json($data);
    }
    
    
    
    public function productspecialpriceupdate(Request $request)
    {
    	$products_id=$request->data_id;
    	 
    	$productspecial_price= $request->productspecialprice;
    	  
    	$data =   DB::table('specials')->where('products_id', '=', $products_id)
    	->where('status',1)->update([
    
    			'specials_new_products_price' => $productspecial_price,
    
    	]);
    
    	if($data){
    		 
    		$data=array('status' => "SUCCESS", 'content' => $data);
    
    	}else{
    		 
    		$data=array('status' => "FAIL", 'content' => $data);
    	}
    
    	return response()->json($data);
    }
    
    
    
      public function inactive_products(Request $request)
    {
    	$language_id = '1';
    	$categories_id = $request->categories_id;
    	$product = $request->product;
    	$title = array('pageTitle' => Lang::get("labels.Products"));
    	$subCategories = $this->category->allcategories($language_id);
    	$products = $this->products->inactive_products($request);
    	$results['products'] = $products;
    	$results['currency'] = $this->myVarsetting->getSetting();
    	$results['units'] = $this->myVarsetting->getUnits();
    	$results['subCategories'] = $subCategories;
    	$currentTime = array('currentTime' => time());
    	$result['commonContent'] = $this->Setting->commonContent();
    	return view("admin.products.inactiveproducts", $title)->with('result', $result)->with('results', $results)->with('categories_id', $categories_id)->with('product', $product);
    
    }
    
     ///bharath
    public function addtonewlocationinsert(Request $request)
    {
    	$title = array('pageTitle' => Lang::get("labels.AddAttributes"));
    	$language_id = '1';
    	
    	$new_products_id = $this->products->insert($request);
   
    	$duplicated_from_producted_id=$request->duplicated_from_producted_id;
    	$result['data'] = array('products_id' => $new_products_id, 'language_id' => $language_id);
    	$alertSetting = $this->myVaralter->newProductNotification($new_products_id);
    	
    	//read from product_attriutes with duplicated_from_producted_id
    	$products_attributes = DB::table('products_attributes')
     	->where('products_attributes.products_id', '=', $duplicated_from_producted_id)
     	->get();
    	
     	$products_images = DB::table('products_images')
     	 
     	->where('products_images.products_id', '=', $duplicated_from_producted_id)
      
     	->get();
     	
    	
     	if($products_attributes){
     	 foreach($products_attributes as $productattr){
     	 	
     	 	
     	 	$products_attributes_id = DB::table('products_attributes')->insert([
     	 			'products_id' => $new_products_id,
     	 			'options_id' => $productattr->options_id,
     	 			'options_values_id' => $productattr->options_values_id,
     	 			'options_values_price' => $productattr->options_values_price,
     	 			'price_prefix' => $productattr->price_prefix,
     	 			'is_default' => $productattr->is_default
     	 	]);
     	 	
     	 	
     	 }
     	}
     	
     	if($products_images){
     	 foreach($products_images as $productimgae){
     	 
     	 
     	  DB::table('products_images')->insert([
             'products_id' => $new_products_id,
             'image' => $productimgae->image,
             'htmlcontent' => $productimgae->htmlcontent,
             'sort_order' => $productimgae->sort_order,
         ]);
     	 
     	 }
     	}
     	 	
     	
    	
    	if ($request->products_type == 1) {
    		return redirect('/admin/products/attach/attribute/display/' . $new_products_id);
    	} else {
    		return redirect('admin/products/images/display/' . $new_products_id);
    	}
    }
    
    
 public function getinventoryproducts(Request $request){
    	 
    	$search = $request->search;
    	 
    	if($search == ''){
  $products = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
                ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
				
				// location label to show up in drop down...
				 ->leftJoin('location', 'location.id', '=', 'products.location_id')
				 
                ->LeftJoin('specials', function ($join) {

                  $join->on('specials.products_id', '=', 'products.products_id')->where('specials.status', '=', '1');
					
				//	 $join->on('specials.products_id', '=', 'products.products_id');

                })
                ->select('products.*','location.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                 ->orderBy('products_description.products_name','asc')
                ->where('products_description.language_id', '=', 1)
                ->get();
    	}else{
    		
    		$products = DB::table('products')
    		->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
    		->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
    		->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
    		
    		// location label to show up in drop down...
    		->leftJoin('location', 'location.id', '=', 'products.location_id')
    			
    		->LeftJoin('specials', function ($join) {
    		
    			$join->on('specials.products_id', '=', 'products.products_id')->where('specials.status', '=', '1');
    				
    			//	 $join->on('specials.products_id', '=', 'products.products_id');
    		
    		})
    		->select('products.*','location.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
    		->orderBy('products_description.products_name','asc')
    		->where('products_description.language_id', '=', 1)
    		->where('products_description.products_name', 'like', '%' .$search . '%')
    		 
    		->limit(15)
    		->get();
    		
    		 	}
    	 
    	 
    	$output="PRODUCT NOT FOUND";
    	 
    
    
    	if(count($products)){
    		$output="";
    		$output = '<ul class="dropdown-menu" style="display:block; position:relative; width:500px;">';
    		foreach($products as $row)
    		{
    			$output .= "<li  class='products_data product-type' id='$row->products_id' name='$row->products_name'  segment='$row->product_segment' location='$row->location_name' >$row->products_name"." - ".$row->product_segment." - ".$row->location_name."</li>";
    		}
    		$output .= '</ul>';
    	}
    	echo $output;
    	 
    	//   $response = array();
    	//   foreach($autocomplate as $autocomplate){
    	//      $response[] = array("value"=>$autocomplate->id,"label"=>$autocomplate->name);
    	// }
    	 
    	// echo json_encode($response);
    	//  exit;
    }
    
    

}
