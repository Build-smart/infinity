<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class Location extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchlocation()
    {

      $locations = DB::table('location')
      ->LeftJoin('zones', 'zones.zone_id', '=', 'location.zone_id')
      	->select('location.*','zones.zone_name')
               ->paginate(60);

        return $locations;

    }

    public function InsertLocation($request)
    {

        $unitId = DB::table('location')->insert([
        		'location_name' => $request->location_name,
        		'zone_id' => $request->zone_id,
             
        ]);

        return $unitId;

    }

    

    public function editlocation($request)
    {

        $result = array();

       
        $locations = DB::table('location')->where('id', $request->id)->first();
        $result['locations'] = $locations;
        
        return $result;

    }

    public function updatelocation($request)
    {

        $orders_status = DB::table('location')->where('id', '=', $request->id)->update([

           'location_name' => $request->location_name,
        		'zone_id' => $request->zone_id,
        		'status' => $request->status,
        ]);

        return $orders_status;

    }

   

    public function deletelocations($request)
    {

        DB::table('location')->where('id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
