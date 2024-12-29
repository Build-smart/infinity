<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Client;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ClientController extends Controller
{

    public function __construct()
    {
        $client = new Client();
        $this->Client = $client;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Clients
    public function clients(Request $request)
    {

        $title = array('pageTitle' => "Clients List");

        $result = array();

        $clients = $this->Client->fetchclient();

        $result['clients'] = $clients;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.clients.index", $title)->with('result', $result);
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
    public function editclient(Request $request)
    {
        $title = array('pageTitle' => "Edit Client");
        $result = array();
        $languages = $this->Client->fetchLanguages();
        $result = $this->Client->editclient($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.clients.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updateclient(Request $request)
    {
        $orders_status = $this->Client->updateclient($request);

       

        $message = "Client Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteunit
    public function deleteclient(Request $request)
    {
        $this->Client->deleteclients($request);
        return redirect()->back()->withErrors("Client Deleted Successfully");
    }

    

}
