<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;



class DistributorBanner extends Model
{
    //
    use Sortable;

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public function image_category(){
        return $this->belongsTo('App\Image_category');
    }

    public $sortable = ['distributorbanners_id','distributorbanners_title','created_at'];

    public function fetchbanner($request,$uploadImage,$banners_url,$expiryDateFormate){

        $banner = DB::table('distributor_banners')->insert([
            'distributorbanners_title'  		 =>   $request->distributorbanners_title,
            'created_at'	 		 			 =>   date('Y-m-d H:i:s'),
            'distributorbanners_image'			 =>	  $uploadImage,
            'distributorbanners_url'	 		 =>   $banners_url,
            'status'	 			 			 =>   $request->status,
            'expires_date'			 			 =>	  $expiryDateFormate,
            'type'					        	 =>	  $request->type,
        	'display_position'					         =>	  $request->position
        ]);

        return $banner;
    }

    public function editdistributorbanners($request){

        $distributorbanners = DB::table('distributor_banners')
            ->leftJoin('image_categories as categoryTable','categoryTable.image_id', '=', 'distributor_banners.distributorbanners_image')
            ->select('distributor_banners.*','categoryTable.path')
            ->where('distributorbanners_id', $request->id)->get();
        return $distributorbanners;

    }

    public function updatedistributorbanner($request,$uploadImage,$banners_url,$expiryDateFormate){

        $bannersUpdate = DB::table('distributor_banners')->where('distributorbanners_id', $request->id)->update([
            'updated_at'	 =>   date('Y-m-d H:i:s'),
            'distributorbanners_title'  		 =>   $request->distributorbanners_title,
            'created_at'	 		 			 =>   date('Y-m-d H:i:s'),
            'distributorbanners_image'			 =>	  $uploadImage,
            'distributorbanners_url'	 		 =>   $banners_url,
            'status'	 			 			 =>   $request->status,
            'expires_date'						 =>	  $expiryDateFormate,
            'type'					 			 =>	  $request->type,
        	'display_position'					         =>	  $request->position
        ]);

        return $bannersUpdate;
    }

    public function deletedistributorbanners($request){
      $deletebanners =  DB::table('distributor_banners')->where('distributorbanners_id', $request->distributorbanners_id)->delete();
      return $deletebanners;
    }
    
    
      
    public function youtubevideolink($request){
    
    	$distributorbanners = DB::table('distributor_banners') 
    	->where('distributorbanners_id', $request->id)->get();
    	return $distributorbanners;
    
    }
    
    
    public function updateyoutubevideolink($request){
    
    	$bannersUpdate = DB::table('distributor_banners')->where('distributorbanners_id', $request->id)->update([
    			'updated_at'	 =>   date('Y-m-d H:i:s'),
    			'distributorbanners_title'	 		 =>   "Youtube Video Link",
    			'display_position'	 		 =>   "YOUTUBE",
    			'status'	 		 =>   1,
    		 	'distributorbanners_url'	 		 =>   $request->distributorbanners_url,
    			 
    	]);
    
    	return $bannersUpdate;
    }
    

}
