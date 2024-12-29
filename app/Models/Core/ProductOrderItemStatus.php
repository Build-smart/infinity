<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class ProductOrderItemStatus extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchproductorderstatus()
    {

      $productorderstatus = DB::table('product_orders_status')->get();

        return $productorderstatus;

    }

    public function InsertProductorderstatus($request)
    {

        $unitId = DB::table('product_orders_status')->insert([
        		'product_orders_status_name' => $request->product_orders_status_name,
        		'comments' => $request->comments,
             
        ]);

        return $unitId;

    }

    

    public function editproductorderstatus($request)
    {

        $result = array();

       
        $productorderstatus = DB::table('product_orders_status')->where('product_orders_status_id', $request->id)->first();
        $result['productorderstatus'] = $productorderstatus;
        
        return $result;

    }

    public function updateproductorderstatus($request)
    {

        $orders_status = DB::table('product_orders_status')->where('product_orders_status_id', '=', $request->product_orders_status_id)->update([

        'product_orders_status_name' => $request->product_orders_status_name,
        		'comments' => $request->comments,
              
        ]);

        return $orders_status;

    }

   

    public function deleteproductorderstatus($request)
    {

        DB::table('product_orders_status')->where('product_orders_status_id', $request->id)->delete();
 
        return "success";

    }

    
}
