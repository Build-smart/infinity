<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Reedem;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ReedemController extends Controller
{

    public function __construct()
    {
        $reedem = new Reedem();
        $this->Reedem = $reedem;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Clients
    public function reedems(Request $request)
    {

        $title = array('pageTitle' => "Clients List");

        $result = array();

        $reedems = $this->Reedem->fetchreedem();

        $result['reedems'] = $reedems;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.reedems.index", $title)->with('result', $result);
    }

    //addclient
    public function addclient(Request $request)
    {
        $title = array('pageTitle' => "Add Client");
        $result = array();
        $languages = $this->Client->fetchLanguages();
        $result['languages'] = $languages;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.clients.add", $title)->with('result', $result);
    }

    //addnewunit
    public function addnewclient(Request $request)
    {
        $unitId = $this->Client->InsertClient($request);
       
        $message = "Client Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editunit
    public function editreedem(Request $request)
    {
        $title = array('pageTitle' => "Edit Reedem Value");
        $result = array();
        $languages = $this->Reedem->fetchLanguages();
        $result = $this->Reedem->editreedem($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.reedems.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updatereedem(Request $request)
    {
        $orders_status = $this->Reedem->updatereedem($request);

       

        $message = "Reedem Value Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteunit
    public function deleteclient(Request $request)
    {
        $this->Client->deleteclients($request);
        return redirect()->back()->withErrors("Client Deleted Successfully");
    }

    

}
