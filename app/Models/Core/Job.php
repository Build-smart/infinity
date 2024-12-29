<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;
use Carbon\Carbon;

class Job extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchjobs()
    {

      $jobs = DB::table('jobs')
               
               ->paginate(60);

        return $jobs;

    }

    public function InsertJob($request)
    {

        $unitId = DB::table('jobs')->insert([
        		'job_title' => $request->job_title,
        		'job_type' => $request->job_type,
        		'experience' => $request->experience,
        		'location' => $request->location,
        		'no_of_positions' => $request->no_of_positions,
        		'description' => $request->description,
        		'status' => $request->status,
        		'created_at' => Carbon::now()
        		 
        		 
             
        ]);

        return $unitId;

    }

    

    public function editjob($request)
    {

        $result = array();

       
        $jobs = DB::table('jobs')->where('id', $request->id)->first();
        $result['jobs'] = $jobs;
        
        return $result;

    }

    public function updatejob($request)
    {

        $orders_status = DB::table('jobs')->where('id', '=', $request->id)->update([

           'job_title' => $request->job_title,
        		'job_type' => $request->job_type,
        		'experience' => $request->experience,
        		'location' => $request->location,
        		'no_of_positions' => $request->no_of_positions,
        		'description' => $request->description,
        		'status' => $request->status,
        		'updated_at' => Carbon::now()
        		 
        ]);

        return $orders_status;

    }

   

    public function deletejobs($request)
    {

        DB::table('jobs')->where('id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }
    
    
       
    public function fetchjobapplicants()
    {
    
    	$jobapplicants = DB::table('job_applicants')
    	  				->paginate(30);
    
    	return $jobapplicants;
    
    }


    
}
