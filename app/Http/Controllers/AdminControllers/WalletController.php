<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Wallet;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class WalletController extends Controller
{

    public function __construct()
    {
        $wallet = new Wallet();
        $this->Wallet = $wallet;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Wallets
    public function wallets(Request $request)
    {

        $title = array('pageTitle' => "Wallets List");

        $result = array();
        
        
        
        $users= DB::table("users")->where('customer_type','CLIENT')->get();

        $result['users'] = $users;
        $wallets = $this->Wallet->fetchwallet();

        $result['wallets'] = $wallets;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.wallets.index", $title)->with('result', $result);
    }
    
    
    //Wallets
    public function filter(Request $request)
    {
    
    	$title = array('pageTitle' => "Wallets List");
    
    	$result = array();
    
    	$customer_id= $request->customer_id;
    	
     
    
    	$users= DB::table("users")->where('customer_type','CLIENT')->get();
    	$result['users'] = $users;
    	$wallets = $this->Wallet->filterbycustomer($request);
    
    	$result['wallets'] = $wallets;
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	return view("admin.wallets.index", $title)->with('result', $result);
    }

    //addclient
    public function addwallet(Request $request)
    {
        $title = array('pageTitle' => "Add Wallet");
        $result = array();
        $customers = $this->Wallet->fetchcustomers();
        $result['customers'] = $customers;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.wallets.add", $title)->with('result', $result);
    }

    //addnewunit
    public function addnewwallet(Request $request)
    {
        $unitId = $this->Wallet->InsertWallet($request);
       
        $message = "Wallet Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editunit
    public function editwallet(Request $request)
    {
        $title = array('pageTitle' => "Edit Client");
        $result = array();
       
        
        $result = $this->Wallet->editwallet($request);
        $customers = $this->Wallet->fetchcustomers();
        $result['customers'] = $customers;
        
        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.wallets.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updatewallet(Request $request)
    {
        $orders_status = $this->Wallet->updatewallet($request);

       

        $message = "Wallet Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteunit
    public function deletewallet(Request $request)
    {
        $this->Wallet->deletewallets($request);
        return redirect()->back()->withErrors("Wallet Deleted Successfully");
    }

    

}
