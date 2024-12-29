<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\PurchaseOrderItemStatus;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\Core\Zones;

class PurchaseOrderItemStatusController extends Controller
{

    public function __construct()
    {
        $purchaseorderstatus = new PurchaseOrderItemStatus();
        $this->PurchaseOrderItemStatus = $purchaseorderstatus;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //PurchaseOrderItemStatus
    public function purchaseorderstatus(Request $request)
    {

        $title = array('pageTitle' => "Purchase Order Status List");

        $result = array();

        $purchaseorderstatus = $this->PurchaseOrderItemStatus->fetchpurchaseorderstatus();

        $result['purchaseorderstatus'] = $purchaseorderstatus;
      
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.purchaseorderitemstatus.index", $title)->with('result', $result);
    }

    //addpurchaseorderstatus
    public function addpurchaseorderstatus(Request $request)
    {
        $title = array('pageTitle' => "Add Purchase Order Status");
        $result = array();
        $languages = $this->PurchaseOrderItemStatus->fetchLanguages();
        
        
        $result['languages'] = $languages;
 
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.purchaseorderitemstatus.add", $title)->with('result', $result);
    }

    //addnewpurchaseorderstatus
    public function addnewpurchaseorderstatus(Request $request)
    {
        $unitId = $this->PurchaseOrderItemStatus->InsertPurchaseorderstatus($request);
       
        $message = "Purchase Order Status Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editpurchaseorderstatus
    public function editpurchaseorderstatus(Request $request)
    {
        $title = array('pageTitle' => "Edit Purchase Order Status");
        $result = array();
        $languages = $this->PurchaseOrderItemStatus->fetchLanguages();
        $result = $this->PurchaseOrderItemStatus->editpurchaseorderstatus($request);
         
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.purchaseorderitemstatus.edit", $title)->with('result', $result);
    }

    //updatepurchaseorderstatus
    public function updatepurchaseorderstatus(Request $request)
    {
        $orders_status = $this->PurchaseOrderItemStatus->updatepurchaseorderstatus($request);
 
        $message = "Purchase Order Status Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deletepurchaseorderstatus
    public function deletepurchaseorderstatus(Request $request)
    {
        $this->PurchaseOrderItemStatus->deletepurchaseorderstatus($request);
        return redirect()->back()->withErrors("Purchase Order Status Deleted Successfully");
    }

    

}
