<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class PurchaseOrderItemStatus extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchpurchaseorderstatus()
    {

      $purchaseorderstatus = DB::table('purchase_orders_status')->get();

        return $purchaseorderstatus;

    }

    public function InsertPurchaseorderstatus($request)
    {

        $unitId = DB::table('purchase_orders_status')->insert([
        		'purchase_orders_status_name' => $request->purchase_orders_status_name,
        		'comments' => $request->comments,
             
        ]);

        return $unitId;

    }

    

    public function editpurchaseorderstatus($request)
    {

        $result = array();

       
        $purchaseorderstatus = DB::table('purchase_orders_status')->where('purchase_orders_status_id', $request->id)->first();
        $result['purchaseorderstatus'] = $purchaseorderstatus;
        
        return $result;

    }

    public function updatepurchaseorderstatus($request)
    {

        $orders_status = DB::table('purchase_orders_status')->where('purchase_orders_status_id', '=', $request->purchase_orders_status_id)->update([

        'purchase_orders_status_name' => $request->purchase_orders_status_name,
        		'comments' => $request->comments,
              
        ]);

        return $orders_status;

    }

   

    public function deletepurchaseorderstatus($request)
    {

        DB::table('purchase_orders_status')->where('purchase_orders_status_id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
