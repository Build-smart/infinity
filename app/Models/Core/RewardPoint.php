<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;

class RewardPoint extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchrewardpoint()
    {

      $rewardpoints = DB::table('reward_points')
               
               ->paginate(60);

        return $rewardpoints;

    }

    public function InsertRewardPoint($request)
    {

        $unitId = DB::table('reward_points')->insert([
        		'min_cart_value' => $request->min_cart_value,
        		'reward_point' => $request->reward_point,
        	  
             
        ]);

        return $unitId;

    }

    

    public function editrewardpoint($request)
    {

        $result = array();

       
        $rewardpoints = DB::table('reward_points')->where('reward_id', $request->id)->first();
        $result['rewardpoints'] = $rewardpoints;
        
        return $result;

    }

    public function updaterewardpoint($request)
    {

        $orders_status = DB::table('reward_points')->where('reward_id', '=', $request->id)->update([

           'min_cart_value' => $request->min_cart_value,
        		'reward_point' => $request->reward_point,
        		 
        ]);

        return $orders_status;

    }

   

    public function deleterewardpoints($request)
    {

        DB::table('reward_points')->where('reward_id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
