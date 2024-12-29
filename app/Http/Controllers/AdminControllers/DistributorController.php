<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Distributor;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class DistributorController extends Controller
{

    public function __construct()
    {
        $distributor = new Distributor();
        $this->Distributor = $distributor;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Distributors
    public function distributors(Request $request)
    {

        $title = array('pageTitle' => "Distributors List");

        $result = array();

        $distributors = $this->Distributor->fetchdistributors();

        $result['distributors'] = $distributors;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.distributors.index", $title)->with('result', $result);
    }

    //addclient
    public function adddistributor(Request $request)
    {
        $title = array('pageTitle' => "Add Distributor");
        $result = array();
        $languages = $this->Distributor->fetchLanguages();
        $result['languages'] = $languages;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.distributors.add", $title)->with('result', $result);
    }

    //addnewunit
    public function addnewdistributor(Request $request)
    {
    	$existUseremail = DB::table('users')->where('email', $request->email)->first();
    	
    	$existUserphone = DB::table('users')->where('phone', $request->phone)->first();
    	
    	if($existUseremail){
    	
    		$message = "Email already Exists";
            return redirect()->back()->with('error',$message);
    	}
    	 
    	if($existUserphone){
    		 
    		$message = "Phone Number already Exists";
            return redirect()->back()->with('error', $message);
    	}
    	 
    	
    	
        $unitId = $this->Distributor->InsertDistributor($request);
       
        $message = "Distributor Added Successfully";
            return redirect()->back()->with('message', $message);
    }

    //editunit
    public function editdistributor(Request $request)
    {
        $title = array('pageTitle' => "Edit Distributor");
        $result = array();
        $languages = $this->Distributor->fetchLanguages();
        $result = $this->Distributor->editdistributor($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.distributors.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updatedistributor(Request $request)
    {
        $orders_status = $this->Distributor->updatedistributor($request);

       

        $message = "Distributor Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteunit
    public function deletedistributor(Request $request)
    {
        $this->Distributor->deletedistributors($request);
        return redirect()->back()->withErrors("Client Deleted Successfully");
    }

    

}
