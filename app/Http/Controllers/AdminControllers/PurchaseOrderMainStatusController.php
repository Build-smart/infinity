<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\PurchaseOrderMainStatus;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\Core\Zones;

class PurchaseOrderMainStatusController extends Controller
{

    public function __construct()
    {
        $purchaseordermainstatus = new PurchaseOrderMainStatus();
        $this->PurchaseOrderMainStatus = $purchaseordermainstatus;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //PurchaseOrderItemStatus
    public function purchaseordermainstatus(Request $request)
    {

        $title = array('pageTitle' => "Purchase Order Status List");

        $result = array();

        $purchaseordermainstatus = $this->PurchaseOrderMainStatus->fetchpurchaseordermainstatus();

        $result['purchaseordermainstatus'] = $purchaseordermainstatus;
      
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.purchaseordermainstatus.index", $title)->with('result', $result);
    }

    //addpurchaseorderstatus
    public function addpurchaseordermainstatus(Request $request)
    {
        $title = array('pageTitle' => "Add Purchase Order Status");
        $result = array();
        $languages = $this->PurchaseOrderMainStatus->fetchLanguages();
        
        
        $result['languages'] = $languages;
 
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.purchaseordermainstatus.add", $title)->with('result', $result);
    }

    //addnewpurchaseorderstatus
    public function addnewpurchaseordermainstatus(Request $request)
    {
        $unitId = $this->PurchaseOrderMainStatus->InsertPurchaseordermainstatus($request);
       
        $message = "Purchase Order Status Main Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editpurchaseorderstatus
    public function editpurchaseordermainstatus(Request $request)
    {
        $title = array('pageTitle' => "Edit Purchase Order Status");
        $result = array();
        $languages = $this->PurchaseOrderMainStatus->fetchLanguages();
        $result = $this->PurchaseOrderMainStatus->editpurchaseordermainstatus($request);
         
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.purchaseordermainstatus.edit", $title)->with('result', $result);
    }

    //updatepurchaseorderstatus
    public function updatepurchaseordermainstatus(Request $request)
    {
        $orders_status = $this->PurchaseOrderMainStatus->updatepurchaseordermainstatus($request);
 
        $message = "Purchase Order Status Main Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deletepurchaseorderstatus
    public function deletepurchaseordermainstatus(Request $request)
    {
        $this->PurchaseOrderMainStatus->deletepurchaseordermainstatus($request);
        return redirect()->back()->withErrors("Purchase Order Main Status Deleted Successfully");
    }

    

}
