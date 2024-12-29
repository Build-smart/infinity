<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;
use Carbon\Carbon;

class ConstructionResources extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchconstructionresource()
    {

      $fetchconstructionresources = DB::table('constructionresources')
               
               ->paginate(60);

        return $fetchconstructionresources;

    }

    public function InsertConstructionResources($request)
    {

        $unitId = DB::table('constructionresources')->insert([
        		'city' => $request->city,
        		'materialquality' => $request->materialquality,
        		'cement' => $request->cement,
        		'steel' => $request->steel,
        		'bricks' => $request->bricks,
        		'aggregate' => $request->aggregate,
        		'sand' => $request->sand,
        		'flooring' => $request->flooring,
        		'windows' => $request->windows,
        		'doors' => $request->doors,
        		'electricalfittings' => $request->electricalfittings,
        		'painting' => $request->painting,
        		'sanitaryfitting' => $request->sanitaryfitting,
        		'kitchenwork' => $request->kitchenwork,
        		'contractorcharges' => $request->contractorcharges,
        		'created_at' => Carbon::now(),
        		  
             
        ]);

        return $unitId;

    }

    

    public function editconstructionresource($request)
    {

        $result = array();

       
        $constructionresources = DB::table('constructionresources')->where('id', $request->id)->first();
        $result['constructionresources'] = $constructionresources;
        
        return $result;

    }

    public function updateconstructionresource($request)
    {

        $orders_status = DB::table('constructionresources')->where('id', '=', $request->id)->update([

          'city' => $request->city,
        		'materialquality' => $request->materialquality,
        		'cement' => $request->cement,
        		'steel' => $request->steel,
        		'bricks' => $request->bricks,
        		'aggregate' => $request->aggregate,
        		'sand' => $request->sand,
        		'flooring' => $request->flooring,
        		'windows' => $request->windows,
        		'doors' => $request->doors,
        		'electricalfittings' => $request->electricalfittings,
        		'painting' => $request->painting,
        		'sanitaryfitting' => $request->sanitaryfitting,
        		'kitchenwork' => $request->kitchenwork,
        		'contractorcharges' => $request->contractorcharges,
        		'updated_at' => Carbon::now(),
        		 
        ]);

        return $orders_status;

    }

   

    public function deleteconstructionresources($request)
    {

        DB::table('constructionresources')->where('id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
