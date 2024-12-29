<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Web\AlertController;


class DistributorWallet extends Model
{
      
    public function editdistributorwallet($request)
    {

        $result = array();

       
        $distributorwallets = DB::table('distributor_wallet')->where('id', $request->id)->first();
        $result['distributorwallets'] = $distributorwallets;
        
        return $result;

    }

    public function updatedistributorwallet($request)
    {

        $orders_status = DB::table('distributor_wallet')->where('id', '=', $request->id)->update([

          'payment_transaction_details' => $request->payment_transaction_details,
        		'is_paid' => $request->is_paid,        		  
        ]);






//Start Notification For Purchase Order Amount Paid  
        $date_added = date('Y-m-d');
         
        $distributorwallets = DB::table('distributor_wallet')->where('id', $request->id)->first();
         
        $purchase_order_id =$distributorwallets->purchase_orders_id;
       
        $distributor_id =$distributorwallets->distributor_id;
       
        $total_amount=$distributorwallets->roundup_purchaseorder_amount;
       
        $title = "Purchase Order Amount Paid";
       
        $description= "Your Purchase order amount Rs.$total_amount of Purchase Order ID #$purchase_order_id is $request->payment_transaction_details";
         
         
        $distributor_notifications = DB::table('distributor_notifications')->insertGetId(
    [       'purchase_order_id' => $purchase_order_id,
    'distributor_id' =>  $distributor_id,
    'title' => $title,
    'description' => $description,
    'notification_date' => $date_added,
   
   
    ]);
       
        //notification/email
        $myVar = new AlertController();
        $alertSetting = $myVar->purchaseorderAlert($description,$title,$distributor_id);
        //End Notification For Purchase Order Amount Paid


        return $orders_status;

    }

   
 
    
}
