<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\WidthdrawCashback;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class WithdrawCashbackController extends Controller
{

    public function __construct()
    {
        $widthdrawwashback = new WidthdrawCashback();
        $this->WidthdrawCashback = $widthdrawwashback;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Clients
    public function widthdrawcashbacks(Request $request)
    {

        $title = array('pageTitle' => "Clients List");

        $result = array();

        $widthdrawcashbacks = $this->WidthdrawCashback->fetchwidthdrawcashbacks();

        $result['widthdrawcashbacks'] = $widthdrawcashbacks;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.withdrawcashbacks.index", $title)->with('result', $result);
    }

    

    //editunit
    public function editwidthdrawcashbacks(Request $request)
    {
        $title = array('pageTitle' => "Edit Client");
        $result = array();
       
        $result = $this->WidthdrawCashback->editwidthdrawcashbacks($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.withdrawcashbacks.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updatewidthdrawcashback(Request $request)
    {
        $orders_status = $this->WidthdrawCashback->updatewidthdrawcashback($request);
 
        $message = "Withdraw Cashback Paid Successfully";
        return redirect()->back()->withErrors([$message]);
    }

     
    

}
