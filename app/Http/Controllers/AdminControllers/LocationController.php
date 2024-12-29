<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Location;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\Core\Zones;

class LocationController extends Controller
{

    public function __construct()
    {
        $location = new Location();
        $this->Location = $location;
        
        $setting = new Setting();
        $this->Setting = $setting;
       
        
        $zones = new Zones();
        $this->Zones = $zones;
        
         
    }
 
    //locations
    public function locations(Request $request)
    {

        $title = array('pageTitle' => "Locations List");

        $result = array();

        $locations = $this->Location->fetchlocation();

        $result['locations'] = $locations;
     
        
       
        
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.locations.index", $title)->with('result', $result);
    }

    //addlocation
    public function addlocation(Request $request)
    {
        $title = array('pageTitle' => "Add Location");
        $result = array();
        $languages = $this->Location->fetchLanguages();
        
        
        $result['languages'] = $languages;
        
        $zones = $this->Zones->getter();
        $result['zones'] = $zones;
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.locations.add", $title)->with('result', $result);
    }

    //addnewlocation
    public function addnewlocation(Request $request)
    {
        $unitId = $this->Location->InsertLocation($request);
       
        $message = "Location Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editlocation
    public function editlocation(Request $request)
    {
        $title = array('pageTitle' => "Edit Location");
        $result = array();
        $languages = $this->Location->fetchLanguages();
        $result = $this->Location->editlocation($request);
        $zones = $this->Zones->getter();
        $result['zones'] = $zones;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.locations.edit", $title)->with('result', $result);
    }

    //updatelocation
    public function updatelocation(Request $request)
    {
        $orders_status = $this->Location->updatelocation($request);

       

        $message = "Location Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deletelocation
    public function deletelocation(Request $request)
    {
        $this->Location->deletelocations($request);
        return redirect()->back()->withErrors("Location Deleted Successfully");
    }

    

}
