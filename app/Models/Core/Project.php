<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;
use Carbon\Carbon;

class Project extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    
    public function fetchclients()
    { 
    	
    	 
    	$clients = DB::table('clients')
    	 
    	->get();
    
    	return $clients;
    
    }
     

    public function fetchproject()
    {

      $projects = DB::table('projects')
      ->leftJoin('clients', 'clients.id', '=', 'projects.client_id')
      ->select('projects.*','clients.client_name as clientname')
               ->paginate(60);

        return $projects;

    }

    public function InsertProject($request)
    {

        $unitId = DB::table('projects')->insert([
        		'client_id' => $request->client_id,
        		'project_name' => $request->project_name,
        		'project_description' => $request->project_description,
        		'project_status' => $request->project_status,
        		'project_startdate' => $request->project_startdate,
        		'project_enddate' => $request->project_enddate,
        		'created_at' => Carbon::now()
        		 
        		 
        		 
             
        ]);

        return $unitId;

    }

    

    public function editproject($request)
    {

        $result = array();

        
        
        $projects = DB::table('projects')
        ->leftJoin('clients', 'clients.id', '=', 'projects.client_id')
        ->select('projects.*','clients.client_name as clientname')
        ->where('projects.id', $request->id)->first();
         $result['projects'] = $projects;
        
        return $result;

    }
    
    
    public function projectdocs($request)
    {
     
     
    
    	$projectdocs = DB::table('project_docs')
    	->where('project_id', $request->id)->get();
    	$result['projectdocs'] = $projectdocs;
    
    	return $projectdocs;
    
    }
    
    

    public function projectfollowups($request)
    {
    	 
    	 
    
    	$projectfollowups = DB::table('project_followups')
    	->where('project_id', $request->id)->get();
    	$result['projectfollowups'] = $projectfollowups;
    	
    	   
    	 
    	return $projectfollowups;
    
    }
    
    

    public function updateproject($request)
    {

        $orders_status = DB::table('projects')->where('id', '=', $request->id)->update([

          'client_id' => $request->client_id,
        		'project_name' => $request->project_name,
        		'project_description' => $request->project_description,
        		'project_status' => $request->project_status,
        		'project_startdate' => $request->project_startdate,
        		'project_enddate' => $request->project_enddate,
        		'updated_at' => Carbon::now()
        		 
        		 
        ]);

        return $orders_status;

    }

   

    public function deleteprojects($request)
    {

        DB::table('projects')->where('id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }
    
    public function addprojectdoc($request)
    {
    
   //	DB::table('projects')->where('id', $request->id)->delete();
    	if ($request->hasFile('document') && $request->file('document')->isValid()) {
    		$projectdoc = $request->file('document')->store('documents');
    	}
    	DB::table('project_docs')->insert([
    			'project_id' => $request->project_id,
    			 'document' => $projectdoc,
    			'date' => Carbon::now(),
    			'created_at' => Carbon::now(),
    	 
    			 
    	]);
    	
    	
    	// DB::table('units_descriptions')->where('unit_id', $request->id)->delete();
    
    	return "success";
    
    }
    
    
    public function addprojectfollowup($request)
    {
    
    	if ($request->hasFile('followup_document') && $request->file('followup_document')->isValid()) {
    		$projectfollowupdoc = $request->file('followup_document')->store('documents');
    	}
    	 
    	DB::table('project_followups')->insert([
    			'project_id' => $request->project_id,
    			'project_followup' => $request->project_followup,
    			'followup_document' =>$projectfollowupdoc,
    			'date' => Carbon::now(),
    			'created_at' => Carbon::now(),
    
    
    	]);
    	 
    	  
    	return "success";
    
    }
    
    public function projectdocumentdownload($request)
    { 
    	 
    	
    	$projectdocs = DB::table('project_docs')
    	->where('id', $request->id)->first();
    	$result['projectdocs'] = $projectdocs;
    
    	return $projectdocs;
    
    }
    
    
    public function projectfollowupdocumentdownload($request)
    {
    
    	 
    	$projectfollowupdocs = DB::table('project_followups')
    	->where('id', $request->id)->first();
    	$result['projectfollowupdocs'] = $projectfollowupdocs;
    
    	return $projectfollowupdocs;
    
    }

    
}
