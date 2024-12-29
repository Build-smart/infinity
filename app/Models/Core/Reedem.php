<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;

class Reedem extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchreedem()
    {

      $reedems = DB::table('reedem_values')
               
               ->paginate(60);

        return $reedems;

    }

    public function InsertClient($request)
    {

        $unitId = DB::table('clients')->insert([
        		'client_name' => $request->client_name,
        		'client_phone' => $request->client_phone,
        		'client_email' => $request->client_email,
        		'client_address' => $request->client_address,
        		'state' => $request->state,
        		'country' => $request->country,
        		'pincode' => $request->pincode,
        		'is_active' => $request->is_active,
        		 
        		 
        		 
             
        ]);

        return $unitId;

    }

    

    public function editreedem($request)
    {

        $result = array();

       
        $reedems = DB::table('reedem_values')->where('reedem_id', $request->id)->first();
        $result['reedems'] = $reedems;
        
        return $result;

    }

    public function updatereedem($request)
    {

        $orders_status = DB::table('reedem_values')->where('reedem_id', '=', $request->id)->update([

           'reward_point' => $request->reward_point,
        		'value' => $request->value,
        		 
        		 
        ]);

        return $orders_status;

    }

   

    public function deleteclients($request)
    {

        DB::table('clients')->where('id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
