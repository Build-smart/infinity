<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\ConstructionResources;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ConstructionResourcesController extends Controller
{

    public function __construct()
    {
        $constructionresource = new ConstructionResources();
        $this->ConstructionResources = $constructionresource;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Clients
    public function constructionresources(Request $request)
    {

        $title = array('pageTitle' => "Construction Resources List");

        $result = array();
     
	
        $constructionresources = $this->ConstructionResources->fetchconstructionresource();

        $result['constructionresources'] = $constructionresources;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.constructionresources.index", $title)->with('result', $result);
    }

    //addclient
    public function addconstructionresource(Request $request)
    {
        $title = array('pageTitle' => "Add Construction Resources");
        $result = array();
        $languages = $this->ConstructionResources->fetchLanguages();
        $locations = DB::table("location")->get();
        $result['locations'] = $locations;
        $result['languages'] = $languages;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.constructionresources.add", $title)->with('result', $result);
    }

    //addnewunit
    public function addnewconstructionresource(Request $request)
    {
        $unitId = $this->ConstructionResources->InsertConstructionResources($request);
       
        $message = "Construction Resources Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editunit
    public function editconstructionresource(Request $request)
    {
        $title = array('pageTitle' => "Edit Construction Resource");
        $result = array();
        $languages = $this->ConstructionResources->fetchLanguages();
       
        $result = $this->ConstructionResources->editconstructionresource($request);
        $locations = DB::table("location")->get();
        $result['locations'] = $locations;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.constructionresources.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updateconstructionresource(Request $request)
    {
        $orders_status = $this->ConstructionResources->updateconstructionresource($request);
 
        $message = "Construction Resources Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteunit
    public function deleteconstructionresource(Request $request)
    {
        $this->ConstructionResources->deleteconstructionresources($request);
        return redirect()->back()->withErrors("Construction Resources Deleted Successfully");
    }

    

}
