<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Project;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Lang;

class ProjectController extends Controller
{

    public function __construct()
    {
        $project = new Project();
        $this->Project = $project;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Clients
    public function projects(Request $request)
    {

        $title = array('pageTitle' => "Clients List");

        $result = array();

        $projects = $this->Project->fetchproject();

        $result['projects'] = $projects;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.projects.index", $title)->with('result', $result);
    }

    //addclient
    public function addproject(Request $request)
    {
        $title = array('pageTitle' => "Add Project");
        $result = array();
        $languages = $this->Project->fetchLanguages();
        $clients = $this->Project->fetchclients();
        
        $result['clients'] = $clients;
        $result['languages'] = $languages;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.projects.add", $title)->with('result', $result);
    }

    //addnewunit
    public function addnewproject(Request $request)
    {
        $unitId = $this->Project->InsertProject($request);
       
        $message = "Project Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editunit
    public function editproject(Request $request)
    {
        $title = array('pageTitle' => "Edit Project");
        $result = array();
        $languages = $this->Project->fetchLanguages();
        $result = $this->Project->editproject($request);
        $clients = $this->Project->fetchclients();
        $result['clients'] = $clients;
        
        $projectdocs =  $this->Project->projectdocs($request);
        
        $result['projectdocs'] = $projectdocs;
        
        $projectfollowups =  $this->Project->projectfollowups($request);
        
        $result['projectfollowups'] = $projectfollowups;
        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.projects.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updateproject(Request $request)
    {
        $orders_status = $this->Project->updateproject($request);

       

        $message = "Project Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteproject
    public function deleteproject(Request $request)
    {
        $this->Project->deleteprojects($request);
        return redirect()->back()->withErrors("Project Deleted Successfully");
    }

    //addprojectdocument
    public function addprojectdoc(Request $request)
    {
    	$this->Project->addprojectdoc($request);
    	return redirect()->back()->withErrors("Project Document Added Successfully");
    }
    
    //Addprojectfollowup
    public function addprojectfollowup(Request $request)
    {
    	$this->Project->addprojectfollowup($request);
    	return redirect()->back()->withErrors("Project FollowUp Added Successfully");
    }
    
    
    public function downloaddocument(Request $request) {
    	 
    	$projectdocs = $this->Project->projectdocumentdownload($request);
    	
    	$result['projectdocs'] = $projectdocs;
    	
    	 
    	if (! Storage::exists ($projectdocs->document)) {
    		return response ()->json ( [
    				'message' => __ ( 'No Document Found!' )
    		] );
    	}
    	//	$filename = $client->name . "_Marksheet.pdf";
    	return Storage::download ($projectdocs->document);
    	 
    	 
    	 
    }
    
    
    public function downloadfollowupdocument(Request $request) {
    
    	$projectfollowupdocs = $this->Project->projectfollowupdocumentdownload($request);
    	 
    	$result['projectfollowupdocs'] = $projectfollowupdocs;
    	 
    
    	if (! Storage::exists ($projectfollowupdocs->followup_document)) {
    		return response ()->json ( [
    				'message' => __ ( 'No Document Found!' )
    		] );
    	}
    	//	$filename = $client->name . "_Marksheet.pdf";
    	return Storage::download ($projectfollowupdocs->followup_document);
    
    
    
    }
    

}
