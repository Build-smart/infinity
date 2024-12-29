<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class PurchaseOrderMainStatus extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchpurchaseordermainstatus()
    {

      $purchaseordermainstatus = DB::table('purchase_orders_main_status')->get();

        return $purchaseordermainstatus;

    }

    public function InsertPurchaseordermainstatus($request)
    {

        $unitId = DB::table('purchase_orders_main_status')->insert([
        		'purchase_orders_main_status_name' => $request->purchase_orders_main_status_name,
        		'comments' => $request->comments,
             
        ]);

        return $unitId;

    }

    

    public function editpurchaseordermainstatus($request)
    {

        $result = array();

       
        $purchaseordermainstatus = DB::table('purchase_orders_main_status')->where('purchase_orders_main_status_id', $request->id)->first();
        $result['purchaseordermainstatus'] = $purchaseordermainstatus;
        
        return $result;

    }

    public function updatepurchaseordermainstatus($request)
    {

        $orders_status = DB::table('purchase_orders_main_status')->where('purchase_orders_main_status_id', '=', $request->purchase_orders_main_status_id)->update([

       'purchase_orders_main_status_name' => $request->purchase_orders_main_status_name,
        		'comments' => $request->comments,
              
        ]);

        return $orders_status;

    }

   

    public function deletepurchaseordermainstatus($request)
    {

        DB::table('purchase_orders_main_status')->where('purchase_orders_main_status_id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
