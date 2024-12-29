@extends('web.layout')
@section('content')

<div class="container-fuild">
  <nav aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('website.myProfile')</li>

      </ol>
    </div>
  </nav>
</div> 
<section class="pro-content">
<!-- Profile Content -->
<section class="profile-content">
  <div class="container">
    <div class="row">

      <div class="col-12 media-main">
        <div class="media">
          <h3>{{ substr(auth()->guard('customer')->user()->first_name, 0, 1)}}</h3>
            <div class="media-body">
              <div class="row">
                <div class="col-12 col-sm-4 col-md-6">
                  <h4>{{auth()->guard('customer')->user()->first_name}} {{auth()->guard('customer')->user()->last_name}}<br>
                  <small>@lang('website.Phone'): {{ auth()->guard('customer')->user()->phone }} </small></h4>
                </div>
                <div class="col-12 col-sm-8 col-md-6 detail">                  
                  <p class="mb-0">@lang('website.E-mail'):<span>{{auth()->guard('customer')->user()->email}}</span></p>
                </div>
                </div>
            </div>
            
        </div>
    </div>

       <div class="col-12 col-lg-3">
           <div class="heading">
               <h2>
                   @lang('website.My Account')
               </h2>
               <hr >
             </div>

           <ul class="list-group">
               <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/profile')}}">
                       <i class="fas fa-user"></i>
                     @lang('website.Profile')
                   </a>
               </li>
               <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/wishlist')}}">
                       <i class="fas fa-heart"></i>
                    @lang('website.Wishlist')
                   </a>
               </li>
               <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/orders')}}">
                       <i class="fas fa-shopping-cart"></i>
                     @lang('website.Orders')
                   </a>
               </li>
                <?php if(auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER"){ ?>
                <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/widthdrawcashback')}}">
                       <i class="fas fa-map-marker-alt"></i>
                     CashBack : {{$result['totalcashback_amount']}}
                   </a>
               </li>
               <?php } ?>
                <?php if(auth()->guard('customer')->user()->customer_type=="CLIENT"){ ?>
               <li class="list-group-item">
                    <a class="nav-link" href="{{ URL::to('/wallet_history')}}">
                        <i class="fas fa-shopping-cart"></i>
                     Wallet Amount  :   {{round($result['remainingwallet_amount'],2)}}
                    </a>
                </li>
                <?php } ?>
               <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/shipping-address')}}">
                       <i class="fas fa-map-marker-alt"></i>
                    @lang('website.Shipping Address')
                   </a>
               </li>
              
               <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/change-password')}}">
                       <i class="fas fa-unlock-alt"></i>
                     @lang('website.Change Password')
                   </a>
               </li>
                <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/logout')}}">
                       <i class="fas fa-power-off"></i>
                     @lang('website.Logout')
                   </a>
               </li>
             </ul>
       </div>
       <div class="col-12 col-lg-9 ">
           <div class="heading">
               <h2>
                   @lang('website.Personal Information')
               </h2>
               <hr >
             </div>
             <form name="updateMyProfile" class="align-items-center form-validate" enctype="multipart/form-data" action="{{ URL::to('updateMyProfile')}}" method="post">
               @csrf
                @if( count($errors) > 0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">@lang('website.Error'):</span>
                            {{ $error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">@lang('website.Error'):</span>
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">@lang('website.Error'):</span>
                        {!! session('loginError') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session()->has('success') )
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                 <div class="form-group row">
                   <label for="firstName" class="col-sm-2 col-form-label">@lang('website.First Name')</label>
                   <div class="col-sm-10">
                     <input type="text" required name="customers_firstname" class="form-control field-validate" id="inputName" value="{{ auth()->guard('customer')->user()->first_name }}" placeholder="@lang('website.First Name')">
                   </div>
                 </div>
                 <div class="form-group row">
                   <label for="lastName" class="col-sm-2 col-form-label">@lang('website.Last Name')</label>
                   <div class="col-sm-10">
                     <input type="text" required name="customers_lastname" placeholder="@lang('website.Last Name')" class="form-control field-validate" id="lastName" value="{{ auth()->guard('customer')->user()->last_name }}">
                   </div>
                 </div>

                 <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">@lang('website.Gender')</label>
                  <div class="from-group  select-control col-sm-4 ">
                 
                      <select class="form-control " name="gender" required id="exampleSelectGender1">
                        <option value="0" @if(auth()->guard('customer')->user()->gender == 0) selected @endif>@lang('website.Male')</option>
                        <option value="1"  @if(auth()->guard('customer')->user()->gender == 1) selected @endif>@lang('website.Female')</option>
                      </select> 
                
                  </div>
                  <label for="inputPassword" class="col-sm-2 col-form-label">@lang('website.DOB')</label>
                  <div class=" col-sm-4">
                      <div class="input-group date">
                        <input readonly name="customers_dob" type="text" id="customers_dob" data-provide="datepicker" class="form-control" placeholder="@lang('website.Date of Birth')" value="{{ auth()->guard('customer')->user()->dob }}" aria-label="date-picker" aria-describedby="date-picker-addon1">
                          
                          <div class="input-group-prepend">
                              <span class="input-group-text" id="date-picker-addon1"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                        </div>

                      
                      
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">@lang('website.Phone')</label>
                  <div class="col-sm-10">
                    <input name="customers_telephone" type="tel" readonly  placeholder="@lang('website.Phone Number')" value="{{ auth()->guard('customer')->user()->phone }}" class="form-control phone-validate">
                  </div>
                </div> 
                
                
<!--                   < ?php if(auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER"){ ?> -->
                <div class="form-group row">
                  <label for="inputBankAccountDetails" class="col-sm-2 col-form-label">Bank Account Holder Name</label>
                  <div class="col-sm-10">
                    <input name="bank_holder_name" type="text"    placeholder="Bank Account Holder Name" value="{{ auth()->guard('customer')->user()->bank_holder_name }}" class="form-control  ">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputBankAccountDetails" class="col-sm-2 col-form-label">Bank Account Number</label>
                  <div class="col-sm-10">
                    <input name="bank_account_number" type="text"    placeholder="Bank Account Number" value="{{ auth()->guard('customer')->user()->bank_account_number }}" class="form-control  ">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputBankAccountDetails" class="col-sm-2 col-form-label">Bank Name</label>
                  <div class="col-sm-10">
                    <input name="bank_name" type="text"    placeholder="Bank Name" value="{{ auth()->guard('customer')->user()->bank_name }}" class="form-control  ">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputBankAccountDetails" class="col-sm-2 col-form-label">Bank Ifs Code</label>
                  <div class="col-sm-10">
                    <input name="bank_ifs_code" type="text"    placeholder="Bank Ifs Code" value="{{ auth()->guard('customer')->user()->bank_ifs_code }}" class="form-control  ">
                  </div>
                </div>
               
                 <div class="form-group row">
                  <label for="inputUpiAddress" class="col-sm-2 col-form-label">UPI Address / GooglePay / Phonepay / Paytm</label>
                  <div class="col-sm-10">
                    <input name="customers_upi_address" type="text"  placeholder="UPI Address / GooglePay / Phonepay / Paytm" value="{{ auth()->guard('customer')->user()->upi_address }}" class="form-control  ">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputUpiAddress" class="col-sm-2 col-form-label">GST Number</label>
                  <div class="col-sm-10">
                    <input name="gst" type="text"  placeholder="GST Number" value="{{ auth()->guard('customer')->user()->gst }}" class="form-control  ">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="inputUpiAddress" class="col-sm-2 col-form-label">Pan Card Number</label>
                  <div class="col-sm-10">
                    <input name="pan" type="text"  placeholder="Pan Card Number" value="{{ auth()->guard('customer')->user()->pan }}" class="form-control  ">
                  </div>
                </div>

                
<!--                  < ?php }else{ ?> -->
                
<!--                  < ?php } ?> -->
                
                
                
                <button type="submit" class="btn btn-secondary swipe-to-top">@lang('website.Update')</button>
             </form>

         <!-- ............the end..... -->
       </div>
     </div>
    </div>
  </section>
</div>
 </section>
 @endsection
