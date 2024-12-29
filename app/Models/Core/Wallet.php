<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
  

class Wallet extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchwallet()
    {

      $wallets = DB::table('wallet')
      ->LeftJoin('users', 'users.id', '=', 'wallet.customer_id')
      ->select('wallet.*','users.first_name','users.last_name')
               ->paginate(60);

        return $wallets;

    }
    
    
    public function filterbycustomer($request){
    	
    	$customer_id= $request->customer_id;
    	
    	
    	$wallets = DB::table('wallet')
    	->LeftJoin('users', 'users.id', '=', 'wallet.customer_id')
    	->select('wallet.*','users.first_name','users.last_name')
    	->where('wallet.customer_id',$customer_id)
    	->paginate(60);
    	
    	return $wallets;
    	 
    
    }
    
    
    public function fetchcustomers()
    {
    
    	$customers = DB::table('users')->where('customer_type','CLIENT')->get();
    
    	return $customers;
    
    }
    

    public function InsertWallet($request)
    {

        $unitId = DB::table('wallet')->insert([
        		'customer_id' => $request->customer_id,
        		'wallet_amount' => $request->wallet_amount,
        		'added_date' =>  date('Y-m-d H:i:s'),
        ]);

        return $unitId;

    }

    public function editwallet($request)
    {

        $result = array();

       
        $wallets = DB::table('wallet')->where('id', $request->id)->first();
        $result['wallets'] = $wallets;
        
        return $result;

    }

    public function updatewallet($request)
    {

        $orders_status = DB::table('wallet')->where('id', '=', $request->id)->update([

          'customer_id' => $request->customer_id,
        		'wallet_amount' => $request->wallet_amount,
        		'added_date' =>  date('Y-m-d H:i:s'),
             	 
        ]);

        return $orders_status;

    }

   

    public function deletewallets($request)
    {

        DB::table('wallet')->where('id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
