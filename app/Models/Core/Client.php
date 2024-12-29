<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;

class Client extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchclient()
    {

      $clients = DB::table('clients')
               
               ->paginate(60);

        return $clients;

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

    

    public function editclient($request)
    {

        $result = array();

       
        $clients = DB::table('clients')->where('id', $request->id)->first();
        $result['clients'] = $clients;
        
        return $result;

    }

    public function updateclient($request)
    {

        $orders_status = DB::table('clients')->where('id', '=', $request->id)->update([

           'client_name' => $request->client_name,
        		'client_phone' => $request->client_phone,
        		'client_email' => $request->client_email,
        		'client_address' => $request->client_address,
        		'state' => $request->state,
        		'country' => $request->country,
        		'pincode' => $request->pincode,
        		'is_active' => $request->is_active,
        		 
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
