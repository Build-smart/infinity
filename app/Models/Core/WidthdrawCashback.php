<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;

class WidthdrawCashback extends Model
{
    

     

    public function fetchwidthdrawcashbacks()
    {

     $widthdrawcashbacks = DB::table('cashback_transactions')
     						->LeftJoin('users', 'cashback_transactions.user_id', '=', 'users.id')
     						->select('cashback_transactions.*','users.first_name','users.last_name')
    						->paginate(60);

        return $widthdrawcashbacks;

    }

    
    

    public function editwidthdrawcashbacks($request)
    {

        $result = array();

       
        $widthdrawcashbacks = DB::table('cashback_transactions')
        ->LeftJoin('users', 'cashback_transactions.user_id', '=', 'users.id')
     						->select('cashback_transactions.*','users.first_name','users.last_name')
    						->where('cashback_transactions.id', $request->id)->first();
        $result['widthdrawcashbacks'] = $widthdrawcashbacks;
        
        return $result;

    }

    public function updatewidthdrawcashback($request)
    {

        $orders_status = DB::table('cashback_transactions')->where('id', '=', $request->id)->update([

           'user_id' => $request->user_id,
        		 'request_amount' =>$request->request_amount,
                'request_date' =>$request->request_date,
        		'transcation_details' =>$request->transcation_details,
                 'status' => 'PAID'
        		 
        ]);

        return $orders_status;

    }

   

     

    
}
