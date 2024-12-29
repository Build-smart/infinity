<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\DistributorWallet;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class DistributorWalletController extends Controller
{

    public function __construct()
    {
        $distributorwallet = new DistributorWallet();
        $this->DistributorWallet = $distributorwallet;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
  
    
 public function distributorwallet(Request $request){
    
    	$language_id = '1';
    	$purchase_orders_id = $request->id;
    		$title = array('pageTitle' => "Distributor Wallet List");
    
    	$distributorwallet = DB::table('distributor_wallet')->where('purchase_orders_id',$purchase_orders_id)
    	 
    	->get();
 
      
     	$result['distributorwallet'] = $distributorwallet;
     	$result['commonContent'] = $this->Setting->commonContent();
     	
     	return view("admin.distributors.distributor_wallet")->with('result', $result);
    }
     

    //editunit
    public function editdistributorwallet(Request $request)
    {
        $title = array('pageTitle' => "Edit Distributor Wallet");
        $result = array();
       
        
        $result = $this->DistributorWallet->editdistributorwallet($request);
        
        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.distributors.distributorwallet_edit", $title)->with('result', $result);
    }

    //updateunit
    public function updatedistributorwallet(Request $request)
    {
        $orders_status = $this->DistributorWallet->updatedistributorwallet($request);
 
        $message = "Distributor Wallet Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    
    
    
    public function adddistributorwallet(Request $request)
    {
    	$purchase_order_id=$request->purchase_order_id;
    	$order_id=$request->order_id;
    	$distributor_id= $request->distributor_id;
    	$purchase_order_amount=$request->purchase_order_amount;
    	$purchase_order_taxamount=$request->purchase_order_taxamount;
    	$purchase_order_totalamount=$request->purchase_order_totalamount;
    	$distributor_name=$request->distributor_name;
    	 
    	$data =   DB::table('distributor_wallet')->insert([
    
    			'distributor_id' => $distributor_id,
    			'distributor_name' => $distributor_name,
    			'purchase_orders_id' => $purchase_order_id,
    			'order_id' => $order_id,
    			'purchaseorder_amount' => $purchase_order_amount,
    			'purchaseorder_tax' => $purchase_order_taxamount,
    			'purchaseorder_totalamount' => $purchase_order_totalamount,
    			'added_date' =>  date('Y-m-d H:i:s'),
    	]);
    
    	if($data){
    		 
    		$data=array('status' => "SUCCESS", 'content' => $data);
    
    	}else{
    		 
    		$data=array('status' => "FAIL", 'content' => $data);
    	}
    
    	return response()->json($data);
    }
    
    

}
