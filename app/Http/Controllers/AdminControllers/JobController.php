<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Job;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class JobController extends Controller
{

    public function __construct()
    {
        $job = new Job();
        $this->Job = $job;
        
        $setting = new Setting();
        $this->Setting = $setting;
         
    }
 
    //Clients
    public function jobs(Request $request)
    {

        $title = array('pageTitle' => "Jobs List");

        $result = array();

        $jobs = $this->Job->fetchjobs();

        $result['jobs'] = $jobs;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.jobs.index", $title)->with('result', $result);
    }

    //addclient
    public function addjob(Request $request)
    {
        $title = array('pageTitle' => "Add Job");
        $result = array();
        $languages = $this->Job->fetchLanguages();
        $result['languages'] = $languages;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.jobs.add", $title)->with('result', $result);
    }

    //addnewunit
    public function addnewjob(Request $request)
    {
        $unitId = $this->Job->InsertJob($request);
       
        $message = "Job Added Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //editunit
    public function editjob(Request $request)
    {
        $title = array('pageTitle' => "Edit Job");
        $result = array();
        $languages = $this->Job->fetchLanguages();
        $result = $this->Job->editjob($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.jobs.edit", $title)->with('result', $result);
    }

    //updateunit
    public function updatejob(Request $request)
    {
        $orders_status = $this->Job->updatejob($request);
 
        $message = "Job Updated Successfully";
        return redirect()->back()->withErrors([$message]);
    }

    //deleteunit
    public function deletejob(Request $request)
    {
        $this->Job->deletejobs($request);
        return redirect()->back()->withErrors("Job Deleted Successfully");
    }

    
    public function job_applicants(Request $request)
    {
    
    	$title = array('pageTitle' => "Jobs List");
    
    	$result = array();
    
    	$jobapplicants = $this->Job->fetchjobapplicants();
    
    	$result['jobapplicants'] = $jobapplicants;
    	$result['commonContent'] = $this->Setting->commonContent();
    
    	return view("admin.jobs.job_applicantslist", $title)->with('result', $result);
    }
    

}
