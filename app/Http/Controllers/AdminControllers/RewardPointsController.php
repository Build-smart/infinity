<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\RewardPoint;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class RewardPointsController extends Controller
{

    public function __construct()
    {
        $rewardpoint = new RewardPoint();
        $this->RewardPoint = $rewardpoint;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Clients
    public function rewardpoints(Request $request)
    {

        $title = array('pageTitle' => "Reward Points List");

        $result = array();

        $rewardpoints = $this->RewardPoint->fetchrewardpoint();

        $result['rewardpoints'] = $rewardpoints;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.rewardpoints.index", $title)->with('result', $result);
    }

    //addclient
    public function addrewardpoint(Request $request)
    {
        $title = array('pageTitle' => "Add Reward Points");
        $result = array();
        $languages = $this->RewardPoint->fetchLanguages();
        $result['languages'] = $languages;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.rewardpoints.add", $title)->with('result', $result);
    }

    //addnewunit
    public function addnewrewardpoint(Request $request)
    {
        $unitId = $this->RewardPoint->InsertRewardPoint($request);
       
        $message = "Reward Points Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editunit
    public function editrewardpoint(Request $request)
    {
        $title = array('pageTitle' => "Edit Client");
        $result = array();
        $languages = $this->RewardPoint->fetchLanguages();
        $result = $this->RewardPoint->editrewardpoint($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.rewardpoints.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updaterewardpoint(Request $request)
    {
        $orders_status = $this->RewardPoint->updaterewardpoint($request);

       

        $message = "Reward Points Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteunit
    public function deleterewardpoint(Request $request)
    {
        $this->RewardPoint->deleterewardpoints($request);
        return redirect()->back()->withErrors("Reward Points Deleted Successfully");
    }

    

}
