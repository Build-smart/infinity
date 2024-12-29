<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Faker\date;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Str;
use Carbon\Carbon;


class Distributor extends Model
{
     
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    

     

    public function fetchdistributors()
    {

      $distributors = DB::table('users')->where('customer_type','DISTRIBUTOR')
               
               ->paginate(60);

        return $distributors;

    }

      public function InsertDistributor($request)
    {
    	// Creating a new time instance, we'll use it to name our file and declare the path
    	$time = Carbon::now();
    	
    	$photo = $request->file('photo');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('photo') and in_array($request->photo->extension(), $extensions)) {
    		 
    		$size = getimagesize($photo);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $photo->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		 
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $photo->storeAs($directory, $filename, 'public_three');
    		 
    		//store DB
    		$photo_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			
    	} else {
    		return "Invalid Image";
    	}
    	
    	
    	
    	
    	$company_store_photo = $request->file('company_store_photo');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('company_store_photo') and in_array($request->company_store_photo->extension(), $extensions)) {
    	
    		$size = getimagesize($company_store_photo);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $company_store_photo->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    	
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $company_store_photo->storeAs($directory, $filename, 'public_three');
    	
    		//store DB
    		$company_store_photo_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    		   
    	} else {
    		return "Invalid Image";
    	} 
    	
    	
    	
    	$gst_doc = $request->file('gst_doc');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('gst_doc') and in_array($request->gst_doc->extension(), $extensions)) {
    		 
    		$size = getimagesize($gst_doc);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $gst_doc->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		 
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $gst_doc->storeAs($directory, $filename, 'public_three');
    		 
    		//store DB
    		$gst_doc_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			
    	} else {
    		return "Invalid Image";
    	}
    	
    	
    	$pan_doc = $request->file('pan_doc');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('pan_doc') and in_array($request->pan_doc->extension(), $extensions)) {
    		 
    		$size = getimagesize($pan_doc);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $pan_doc->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		 
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $pan_doc->storeAs($directory, $filename, 'public_three');
    		 
    		//store DB
    		$pan_doc_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			
    	} else {
    		return "Invalid Image";
    	}
    	
    	
    	$visiting_card = $request->file('visiting_card');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('visiting_card') and in_array($request->visiting_card->extension(), $extensions)) {
    		 
    		$size = getimagesize($visiting_card);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $visiting_card->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		 
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $visiting_card->storeAs($directory, $filename, 'public_three');
    		 
    		//store DB
    		$visiting_card_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    		 
    	} else {
    		return "Invalid Image";
    	}
    	 
        $unitId = DB::table('users')->insert([
        		'first_name' => $request->first_name,
        		'company_name' => $request->company_name,
        		'gst' => $request->gst,
        		'distributor_address' => $request->distributor_address,
        		'bank_holder_name' => $request->bank_holder_name,
        		'bank_account_number' => $request->bank_account_number,
        		'bank_ifs_code' => $request->bank_ifs_code,
        		'bank_name' => $request->bank_name,
        		'phone' => $request->phone,
        		'email' => $request->email,
        		'password' => Hash::make($request->password),
        		'customer_type' => "DISTRIBUTOR",
        		'avatar' => $photo_path,
        		'company_store_photo' =>$company_store_photo_path,
        		'gst_doc' =>$gst_doc_path,
        		'pan' =>$request->pan,
        		'pan_doc' =>$pan_doc_path,
        		'visiting_card' =>$visiting_card_path,
        		'status' => 0,
        		'role_id' =>21,
        		
        ]);
        
        return $unitId;

    }


    

    public function editdistributor($request)
    {

        $result = array();

       
        $distributors = DB::table('users')->where('id', $request->id)->first();
        $result['distributors'] = $distributors;
        
        return $result;

    }
   
   
   
   public function updatedistributor($request)
    {
    
    if($request->changePassword == 'yes'){
    	
    	$distributor_details = DB::table('users')->where('id', '=', $request->id)->first();
    	  
    	// Creating a new time instance, we'll use it to name our file and declare the path
    	$time = Carbon::now();
    	
    	
    	if($request->file('photo') ==""){
    		$photo_path = $distributor_details->avatar;
    	
    	}else{
    	
    		$photo = $request->file('photo');
    		$extensions = Setting::imageKycType();
    		if ($request->hasFile('photo') and in_array($request->photo->extension(), $extensions)) {
    			 
    			$size = getimagesize($photo);
    			list($width, $height, $type, $attr) = $size;
    			// Getting the extension of the file
    			$extension = $photo->getClientOriginalExtension();
    			// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    			$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    			// Creating the file name: random string followed by the day, random number and the hour
    			//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			 
    			// This is our upload main function, storing the image in the storage that named 'public'
    			$upload_success = $photo->storeAs($directory, $filename, 'public_three');
    			 
    			//store DB
    			$photo_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			 
    		} else {
    			return "Invalid Image";
    		}
    		 
    	}
    	
    	
    	 
    	if($request->file('company_store_photo') ==""){
    		$company_store_photo_path = $distributor_details->company_store_photo;
    		
    	}else{
    	 
    	$company_store_photo = $request->file('company_store_photo');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('company_store_photo') and in_array($request->company_store_photo->extension(), $extensions)) {
    		 
    		$size = getimagesize($company_store_photo);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $company_store_photo->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		 
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $company_store_photo->storeAs($directory, $filename, 'public_three');
    		 
    		//store DB
    		$company_store_photo_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			
    	} else {
    		return "Invalid Image";
    	}
    	 	
    	}
    	 
    	
    	if($request->file('gst_doc') ==""){
    		$gst_doc_path = $distributor_details->gst_doc;
    	
    	}else{
    	$gst_doc = $request->file('gst_doc');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('gst_doc') and in_array($request->gst_doc->extension(), $extensions)) {
    		 
    		$size = getimagesize($gst_doc);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $gst_doc->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		 
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $gst_doc->storeAs($directory, $filename, 'public_three');
    		 
    		//store DB
    		$gst_doc_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    		 
    	} else {
    		return "Invalid Image";
    	}
    	}
    	
    	
    	if($request->file('pan_doc') ==""){
    		$pan_doc_path = $distributor_details->pan_doc;
    		 
    	}else{
    	$pan_doc = $request->file('pan_doc');
    	$extensions = Setting::imageKycType();
    	if ($request->hasFile('pan_doc') and in_array($request->pan_doc->extension(), $extensions)) {
    		 
    		$size = getimagesize($pan_doc);
    		list($width, $height, $type, $attr) = $size;
    		// Getting the extension of the file
    		$extension = $pan_doc->getClientOriginalExtension();
    		// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    		$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    		// Creating the file name: random string followed by the day, random number and the hour
    		//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    		 
    		// This is our upload main function, storing the image in the storage that named 'public'
    		$upload_success = $pan_doc->storeAs($directory, $filename, 'public_three');
    		 
    		//store DB
    		$pan_doc_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    		 
    	} else {
    		return "Invalid Image";
    	}
    	}
    	
    	if($request->file('visiting_card') ==""){
    		$visiting_card_path = $distributor_details->visiting_card;
    		 
    	}else{
    		$visiting_card = $request->file('visiting_card');
    		$extensions = Setting::imageKycType();
    		if ($request->hasFile('visiting_card') and in_array($request->visiting_card->extension(), $extensions)) {
    			 
    			$size = getimagesize($visiting_card);
    			list($width, $height, $type, $attr) = $size;
    			// Getting the extension of the file
    			$extension = $visiting_card->getClientOriginalExtension();
    			// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    			$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    			// Creating the file name: random string followed by the day, random number and the hour
    			//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			 
    			// This is our upload main function, storing the image in the storage that named 'public'
    			$upload_success = $visiting_card->storeAs($directory, $filename, 'public_three');
    			 
    			//store DB
    			$visiting_card_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			 
    		} else {
    			return "Invalid Image";
    		}
    	}
    	
    	 
    $orders_status = DB::table('users')->where('id', '=', $request->id)->update([
   
    'first_name' => $request->first_name,
    'company_name' => $request->company_name,
    'gst' => $request->gst,
    		'avatar' => $photo_path,
    'company_store_photo' =>$company_store_photo_path,
    'gst_doc' =>$gst_doc_path,
    'pan' =>$request->pan,
    'pan_doc' =>$pan_doc_path,
    		'visiting_card' =>$visiting_card_path,
    'distributor_address' => $request->distributor_address,
    'bank_holder_name' => $request->bank_holder_name,
    'bank_account_number' => $request->bank_account_number,
    'bank_ifs_code' => $request->bank_ifs_code,
    'bank_name' => $request->bank_name,
    'phone' => $request->phone,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'status' => $request->status,
    'kyc_status' =>$request->kyc_status,
    ]);
   
   
    }else{
    	
    	$distributor_details = DB::table('users')->where('id', '=', $request->id)->first();
    	 
    	// Creating a new time instance, we'll use it to name our file and declare the path
    	$time = Carbon::now();
    	
    	
    	if($request->file('photo') ==""){
    		$photo_path = $distributor_details->avatar;
    		 
    	}else{
    		 
    		$photo = $request->file('photo');
    		$extensions = Setting::imageKycType();
    		if ($request->hasFile('photo') and in_array($request->photo->extension(), $extensions)) {
    	
    			$size = getimagesize($photo);
    			list($width, $height, $type, $attr) = $size;
    			// Getting the extension of the file
    			$extension = $photo->getClientOriginalExtension();
    			// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    			$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    			// Creating the file name: random string followed by the day, random number and the hour
    			//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    	
    			// This is our upload main function, storing the image in the storage that named 'public'
    			$upload_success = $photo->storeAs($directory, $filename, 'public_three');
    	
    			//store DB
    			$photo_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    	
    		} else {
    			return "Invalid Image";
    		}
    		 
    	}
    	
    	if($request->file('company_store_photo') ==""){
    		$company_store_photo_path = $distributor_details->company_store_photo;
    	
    	}else{
    	
    		$company_store_photo = $request->file('company_store_photo');
    		$extensions = Setting::imageKycType();
    		if ($request->hasFile('company_store_photo') and in_array($request->company_store_photo->extension(), $extensions)) {
    			 
    			$size = getimagesize($company_store_photo);
    			list($width, $height, $type, $attr) = $size;
    			// Getting the extension of the file
    			$extension = $company_store_photo->getClientOriginalExtension();
    			// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    			$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    			// Creating the file name: random string followed by the day, random number and the hour
    			//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			 
    			// This is our upload main function, storing the image in the storage that named 'public'
    			$upload_success = $company_store_photo->storeAs($directory, $filename, 'public_three');
    			 
    			//store DB
    			$company_store_photo_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			 
    		} else {
    			return "Invalid Image";
    		}
    		 
    	}
    	
    	 
    	 
    	if($request->file('gst_doc') ==""){
    		$gst_doc_path = $distributor_details->gst_doc;
    		 
    	}else{
    		$gst_doc = $request->file('gst_doc');
    		$extensions = Setting::imageKycType();
    		if ($request->hasFile('gst_doc') and in_array($request->gst_doc->extension(), $extensions)) {
    			 
    			$size = getimagesize($gst_doc);
    			list($width, $height, $type, $attr) = $size;
    			// Getting the extension of the file
    			$extension = $gst_doc->getClientOriginalExtension();
    			// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    			$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    			// Creating the file name: random string followed by the day, random number and the hour
    			//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			 
    			// This is our upload main function, storing the image in the storage that named 'public'
    			$upload_success = $gst_doc->storeAs($directory, $filename, 'public_three');
    			 
    			//store DB
    			$gst_doc_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			 
    		} else {
    			return "Invalid Image";
    		}
    	}
    	 
    	 
    	if($request->file('pan_doc') ==""){
    		$pan_doc_path = $distributor_details->pan_doc;
    		 
    	}else{
    		$pan_doc = $request->file('pan_doc');
    		$extensions = Setting::imageKycType();
    		if ($request->hasFile('pan_doc') and in_array($request->pan_doc->extension(), $extensions)) {
    			 
    			$size = getimagesize($pan_doc);
    			list($width, $height, $type, $attr) = $size;
    			// Getting the extension of the file
    			$extension = $pan_doc->getClientOriginalExtension();
    			// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    			$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    			// Creating the file name: random string followed by the day, random number and the hour
    			//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			 
    			// This is our upload main function, storing the image in the storage that named 'public'
    			$upload_success = $pan_doc->storeAs($directory, $filename, 'public_three');
    			 
    			//store DB
    			$pan_doc_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    			 
    		} else {
    			return "Invalid Image";
    		}
    	}
    	
    	if($request->file('visiting_card') ==""){
    		$visiting_card_path = $distributor_details->visiting_card;
    		 
    	}else{
    		$visiting_card = $request->file('visiting_card');
    		$extensions = Setting::imageKycType();
    		if ($request->hasFile('visiting_card') and in_array($request->visiting_card->extension(), $extensions)) {
    	
    			$size = getimagesize($visiting_card);
    			list($width, $height, $type, $attr) = $size;
    			// Getting the extension of the file
    			$extension = $visiting_card->getClientOriginalExtension();
    			// Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
    			$directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    			// Creating the file name: random string followed by the day, random number and the hour
    			//$filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    			$filename = Str::random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
    	
    			// This is our upload main function, storing the image in the storage that named 'public'
    			$upload_success = $visiting_card->storeAs($directory, $filename, 'public_three');
    	
    			//store DB
    			$visiting_card_path = 'images/distributor_kyc/' . $directory . '/' . $filename;
    	
    		} else {
    			return "Invalid Image";
    		}
    	}
    	
    $orders_status = DB::table('users')->where('id', '=', $request->id)->update([
   
    'first_name' => $request->first_name,
    'company_name' => $request->company_name,
    'gst' => $request->gst,
    		'avatar' => $photo_path,
    'company_store_photo' =>$company_store_photo_path,
    'gst_doc' =>$gst_doc_path,
    'pan' =>$request->pan,
    'pan_doc' =>$pan_doc_path,
    'visiting_card' =>$visiting_card_path,
    'distributor_address' => $request->distributor_address,
    'bank_holder_name' => $request->bank_holder_name,
    'bank_account_number' => $request->bank_account_number,
    'bank_ifs_code' => $request->bank_ifs_code,
    'bank_name' => $request->bank_name,
    'phone' => $request->phone,
    'email' => $request->email,
    'status' => $request->status,
    'kyc_status' =>$request->kyc_status,
    		
    ]);
   
    }
   
        return $orders_status;

    }


   

    public function deletedistributors($request)
    {

        DB::table('users')->where('id', $request->id)->delete();
       // DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    
}
