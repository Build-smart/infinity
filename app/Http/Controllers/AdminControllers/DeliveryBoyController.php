<?php
namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Deliveryboy;
 
use App\Models\Core\Images;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Kyslik\ColumnSortable\Sortable;

class DeliveryBoyController extends Controller
{
    //
    public function __construct(Deliveryboy $customers, Setting $setting)
    {
        $this->Deliveryboy = $customers;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Setting = $setting;
    }

    public function display() 
    {
        $title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
        $language_id = '1';

        $customers = $this->Deliveryboy->paginator();

        $result = array();
        $index = 0;
        foreach($customers as $customers_data){
            array_push($result, $customers_data);

            $devices = DB::table('devices')->where('user_id','=',$customers_data->id)->orderBy('created_at','DESC')->take(1)->get();
            $result[$index]->devices = $devices;
            $index++;
        }

        $customerData = array();
        $message = array();
        $errorMessage = array();

        $customerData['message'] = $message;
        $customerData['errorMessage'] = $errorMessage;
        $customerData['result'] = $customers;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboy.index", $title)->with('customers', $customerData)->with('result', $result);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddCustomer"));
        $images = new Images;
        $allimage = $images->getimages();
        $language_id = '1';
        $customerData = array();
        $message = array();
        $errorMessage = array();
        $customerData['countries'] = $this->Deliveryboy->countries();
        $customerData['message'] = $message;
        $customerData['errorMessage'] = $errorMessage;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboy.add", $title)->with('customers', $customerData)->with('allimage',$allimage)->with('result', $result);
    }


    //add addcustomers data and redirect to address
    public function insert(Request $request)
    {
        $language_id = '1';
        //get function from other controller
        $images = new Images;
        $allimage = $images->getimages();

        $customerData = array();
        $message = array();
        $errorMessage = array();

        //check email already exists
        $existEmail = $this->Deliveryboy->email($request);
        $this->validate($request, [
            'customers_firstname' => 'required',
            'customers_lastname' => 'required',
           
            'customers_telephone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'isActive' => 'required',
        ]);


        if (count($existEmail)> 0 ) {
            $messages = Lang::get("labels.Email address already exist");
            return Redirect::back()->withErrors($messages)->withInput($request->all());
        } else {
            $customers_id = $this->Deliveryboy->insert($request);
            return redirect('admin/deliveryboy/address/display/' . $customers_id)->with('update', 'Delivery Boy has been created successfully!');
        }
    }

    public function diplayaddress(Request $request){

        $title = array('pageTitle' => Lang::get("labels.AddAddress"));

        $language_id   				=   $request->language_id;
        $id            				=   $request->id;

        $customerData = array();
        $message = array();
        $errorMessage = array();

        $customer_addresses = $this->Deliveryboy->addresses($id);
        $countries = $this->Deliveryboy->country();

        $customerData['message'] = $message;
        $customerData['errorMessage'] = $errorMessage;
        $customerData['customer_addresses'] = $customer_addresses;
        $customerData['countries'] = $countries;
        $customerData['user_id'] = $id;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.deliveryboy.address.index",$title)->with('data', $customerData)->with('result', $result);
    }


    //add Customer address
    public function addcustomeraddress(Request $request){
      $customer_addresses = $this->Deliveryboy->addcustomeraddress($request);
      return $customer_addresses;
    }

    public function editaddress(Request $request){

      $user_id                 =   $request->user_id;
      $address_book_id         =   $request->address_book_id;

      $customer_addresses = $this->Deliveryboy->addressBook($address_book_id);
      $countries = $this->Deliveryboy->countries();;
      $zones = $this->Deliveryboy->zones($customer_addresses);
      $customers = $this->Deliveryboy->checkdefualtaddress($address_book_id);

      $customerData['user_id'] = $user_id;
      $customerData['customer_addresses'] = $customer_addresses;
      $customerData['countries'] = $countries;
      $customerData['zones'] = $zones;
      $customerData['customers'] = $customers;
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin/deliveryboy/address/editaddress")->with('data', $customerData)->with('result', $result);
    }

    //update Customers address
    public function updateaddress(Request $request){
      $customer_addresses = $this->Deliveryboy->updateaddress($request);
      return ($customer_addresses);
    }

    public function deleteAddress(Request $request){
      $customer_addresses = $this->Deliveryboy->deleteAddresses($request);
      return redirect()->back()->withErrors([Lang::get("labels.Delete Address Text")]);
    }

    //editcustomers data and redirect to address
    public function edit(Request $request){

      $images           = new Images;
      $allimage         = $images->getimages();
      $title            = array('pageTitle' => Lang::get("labels.EditCustomer"));
      $language_id      =   '1';
      $id               =   $request->id;

      $customerData = array();
      $message = array();
      $errorMessage = array();
      $customers = $this->Deliveryboy->edit($id);

      $customerData['message'] = $message;
      $customerData['errorMessage'] = $errorMessage;
      $customerData['countries'] = $this->Deliveryboy->countries();
      $customerData['customers'] = $customers;
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin.deliveryboy.edit",$title)->with('data', $customerData)->with('result', $result)->with('allimage', $allimage);
    }

    //add addcustomers data and redirect to address
    public function update(Request $request){
        $language_id  =   '1';
        $user_id				  =	$request->customers_id;

        $customerData = array();
        $message = array();
        $errorMessage = array();

        //get function from other controller
        if($request->image_id!==null){
            $customers_picture = $request->image_id;
        }	else{
            $customers_picture = $request->oldImage;
        }

        if($request->image_id){
            $uploadImage = $request->image_id;
            $uploadImage = DB::table('image_categories')->where('image_id',$uploadImage)->select('path')->first();
            $customers_picture = $uploadImage->path;
        }	else{
            $customers_picture = $request->oldImage;
        }

        $user_data = array(
            'gender'   		 	=>   $request->gender,
            'first_name'		=>   $request->first_name,
            'last_name'		 	=>   $request->last_name,
            'dob'	 			 	  =>	 $request->dob,
            'phone'	 	      =>	 $request->phone,
            'status'		    =>   $request->status,
            'avatar'	 		  =>	 $customers_picture,
            'updated_at'    => date('Y-m-d H:i:s'),
        );
        $customer_data = array(
          'customers_newsletter'   		 	=>   0,
          'updated_at'    => date('Y-m-d H:i:s'),
        );

        if($request->changePassword == 'yes'){
            $user_data['password'] = Hash::make($request->password);
        }

        $this->Deliveryboy->updaterecord($customer_data,$user_id,$user_data);
        return redirect('admin/deliveryboy/address/display/'.$user_id);
        
    }

    public function delete(Request $request){
      $this->Deliveryboy->destroyrecord($request->users_id);
      return redirect()->back()->withErrors("Delivery Boy Deleted Successfully");
    }

    public function filter(Request $request){
      $filter    = $request->FilterBy;
      $parameter = $request->parameter;

      $title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
      $customers  = $this->Deliveryboy->filter($request);

      $result = array();
      $index = 0;
      foreach($customers as $customers_data){
          array_push($result, $customers_data);

          $devices = DB::table('devices')->where('user_id','=',$customers_data->id)->orderBy('created_at','DESC')->take(1)->get();
          $result[$index]->devices = $devices;
          $index++;
      }

      $customerData = array();
      $message = array();
      $errorMessage = array();

      $customerData['message'] = $message;
      $customerData['errorMessage'] = $errorMessage;
      $customerData['result'] = $customers;
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin.deliveryboy.index",$title)->with('result', $result)->with('customers', $customerData)->with('filter',$filter)->with('parameter',$parameter);
    }
}
