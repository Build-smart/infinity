<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\ProductOrderItemStatus;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\Core\Zones;

class ProductOrderItemStatusController extends Controller
{

    public function __construct()
    {
        $productorderstatus = new ProductOrderItemStatus();
        $this->ProductOrderItemStatus = $productorderstatus;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //PurchaseOrderItemStatus
    public function productorderstatus(Request $request)
    {

        $title = array('pageTitle' => "Product Order Status List");

        $result = array();

        $productorderstatus = $this->ProductOrderItemStatus->fetchproductorderstatus();

        $result['productorderstatus'] = $productorderstatus;
      
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.productorderitemstatus.index", $title)->with('result', $result);
    }

    //addpurchaseorderstatus
    public function addproductorderstatus(Request $request)
    {
        $title = array('pageTitle' => "Add Product Order Status");
        $result = array();
        $languages = $this->ProductOrderItemStatus->fetchLanguages();
        
        
        $result['languages'] = $languages;
 
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.productorderitemstatus.add", $title)->with('result', $result);
    }

    //addnewpurchaseorderstatus
    public function addnewproductorderstatus(Request $request)
    {
        $unitId = $this->ProductOrderItemStatus->InsertProductorderstatus($request);
       
        $message = "Product Order Status Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editpurchaseorderstatus
    public function editproductorderstatus(Request $request)
    {
        $title = array('pageTitle' => "Edit Product Order Status");
        $result = array();
        $languages = $this->ProductOrderItemStatus->fetchLanguages();
        $result = $this->ProductOrderItemStatus->editproductorderstatus($request);
         
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.productorderitemstatus.edit", $title)->with('result', $result);
    }

    //updatepurchaseorderstatus
    public function updateproductorderstatus(Request $request)
    {
        $orders_status = $this->ProductOrderItemStatus->updateproductorderstatus($request);
 
        $message = "Product Order Status Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deletepurchaseorderstatus
    public function deleteproductorderstatus(Request $request)
    {
        $this->ProductOrderItemStatus->deleteproductorderstatus($request);
        return redirect()->back()->withErrors("Purchase Order Status Deleted Successfully");
    }

    

}
