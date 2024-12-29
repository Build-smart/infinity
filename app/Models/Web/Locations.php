<?php

namespace App\Models\Web;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Core\Categories;
use Illuminate\Support\Facades\Lang;



class Locations extends Model
{

  public function locations(){
    $data =  DB::table('location')
    	 ->select('location.*')
//     	 ->where('location.location_name','!=',"Guntur")
//     	 ->where('location.location_name','!=',"Vijayawada")
    	->where('location.status','=',1)
    	->get();
              
    return $data;
  }

}
