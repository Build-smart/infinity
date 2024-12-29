@extends('web.layout')
@section('content')

<!-- checkout Content -->
<section class="checkout-area">

@if(session::get('paytm') == 'success')
@php Session(['paytm' => 'sasa']); @endphp
<script>
jQuery(document).ready(function() {
 // executes when HTML-Document is loaded and DOM is ready
 jQuery("#update_cart_form").submit();
});

</script>
@endif

<div class="container-fuild">
  <nav aria-label="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">@lang('website.Checkout')</a></li>
            <li class="breadcrumb-item">
              <a href="javascript:void(0)">
                @if(session('step')==0)
                      @lang('website.Shipping Address')
                    @elseif(session('step')==1)
                      @lang('website.Billing Address')
                    @elseif(session('step')==2)
                      @lang('website.Shipping Methods')
                    @elseif(session('step')==3)
                      @lang('website.Order Detail')
                    @endif
              </a>
            </li>
          </ol>
      </div>
    </nav>
</div> 
<section class="pro-content">

  <div class="container">
    <div class="page-heading-title">
      <h2> @lang('website.Checkout') </h2>

      </div>
  </div>
 <!-- checkout Content -->
 <section class="checkout-area">
 <div class="container">
   <div class="row">
     
     <div class="col-12 col-xl-9 checkout-left">
       <input type="hidden" id="hyperpayresponse" value="@if(!empty(session('paymentResponse'))) @if(session('paymentResponse')=='success') {{session('paymentResponse')}} @else {{session('paymentResponse')}}  @endif @endif">
       
       <div class="alert alert-danger alert-dismissible" id="paymentError" role="alert" style="display:none;">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           @if(!empty(session('paymentResponse')) and session('paymentResponse')=='error') {{session('paymentResponseData') }} @endif
       </div>
         <div class="row">
           <div class="checkout-module">
             <ul class="nav nav-pills mb-3 checkoutd-nav d-none d-lg-flex" id="pills-tab" role="tablist">
                 <li class="nav-item">
                   <a class="nav-link @if(session('step')==0) active @elseif(session('step')>0)  @endif" id="pills-shipping-tab" data-toggle="pill" href="#pills-shipping" role="tab" aria-controls="pills-shipping" aria-selected="true">
                    <span class="d-flex d-lg-none">1</span>
                    <span class="d-none d-lg-flex">@lang('website.Shipping Address')</span></a>
                 </li>
                 <li class="nav-item">
                   <a class="nav-link @if(session('step')==1) active @elseif(session('step')>1) @endif" @if(session('step')>=1) id="pills-billing-tab" data-toggle="pill" href="#pills-billing" role="tab" aria-controls="pills-billing" aria-selected="false"  @endif >@lang('website.Billing Address')</a>
                 </li>
                 <li class="nav-item">
                   <a class="nav-link @if(session('step')==2) active @elseif(session('step')>2)  @endif" @if(session('step')>=2) id="pills-method-tab" data-toggle="pill" href="#pills-method" role="tab" aria-controls="pills-method" aria-selected="false" @endif> @lang('website.Shipping Methods')</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link @if(session('step')==3) active @elseif(session('step')>3) @endif"  @if(session('step')>=3) id="pills-order-tab" data-toggle="pill" href="#pills-order" role="tab" aria-controls="pills-order" aria-selected="false"@endif>@lang('website.Order Detail')</a>
                   </li>
               </ul>
               <ul class="nav nav-pills mb-3 checkoutd-nav d-flex d-lg-none" id="pills-tab" role="tablist">
                 <li class="nav-item">
                   <a class="nav-link @if(session('step')==0) active @elseif(session('step')>0) active-check @endif" id="pills-shipping-tab" data-toggle="pill" href="#pills-shipping" role="tab" aria-controls="pills-shipping" aria-selected="true">1</a>
                 </li>
                 <li class="nav-item second">
                   <a class="nav-link @if(session('step')==1) active @elseif(session('step')>1) active-check @endif" @if(session('step')>=1) id="pills-billing-tab" data-toggle="pill" href="#pills-billing" role="tab" aria-controls="pills-billing" aria-selected="false"  @endif >2</a>
                 </li>
                 <li class="nav-item third">
                   <a class="nav-link @if(session('step')==2) active @elseif(session('step')>2) active-check @endif" @if(session('step')>=2) id="pills-method-tab" data-toggle="pill" href="#pills-method" role="tab" aria-controls="pills-method" aria-selected="false" @endif>3</a>
                 </li>
                 <li class="nav-item fourth">
                   <a class="nav-link @if(session('step')==3) active @elseif(session('step')>3) active-check @endif"  @if(session('step')>=3) id="pills-order-tab" data-toggle="pill" href="#pills-order" role="tab" aria-controls="pills-order" aria-selected="false"@endif>4</a>
                   </li>
               </ul>
               <div class="tab-content" id="pills-tabContent">
                 <div class="tab-pane fade @if(session('step') == 0) show active @endif" id="pills-shipping" role="tabpanel" aria-labelledby="pills-shipping-tab">
                   <form name="signup" enctype="multipart/form-data" class="form-validate"  action="{{ URL::to('/checkout_shipping_address')}}" method="post">
                     <input type="hidden" required name="_token" id="csrf-token" value="{{ Session::token() }}" />
                     <div class="form-row">
                      <div class="form-group">
                        <label for=""> @lang('website.First Name')</label>
                        <input type="text"  required class="form-control field-validate" id="firstname" name="firstname" value="@if(!empty(session('shipping_address'))){{session('shipping_address')->firstname}}@endif" aria-describedby="NameHelp1" placeholder="Enter Your Name">
                        <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your first name')</span>
                      </div>
                      <div class="form-group">
                        <label for=""> @lang('website.Last Name')</label>
                        <input type="text" required class="form-control field-validate" id="lastname" name="lastname" value="@if(!empty(session('shipping_address'))){{session('shipping_address')->lastname}}@endif" aria-describedby="NameHelp1" placeholder="Enter Your Last Name">
                        <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your last name')</span>
                      </div>
                      
                   
                      <div class="form-group">
                        <label for=""> @lang('website.Company')</label>
                        <input type="text" required class="form-control field-validate" id="company" aria-describedby="companyHelp" placeholder="Enter Your Company Name" name="company" value="@if(!empty(session('shipping_address'))) {{session('shipping_address')->company}}@endif">
                        <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your company name')</span>
                      </div>

                      <div class="form-group">
                        <label for=""> @lang('website.Address')</label>
                        <input type="text" required class="form-control field-validate" name="street" id="street" aria-describedby="addressHelp" placeholder="@lang('website.Please enter your address')" value="@if(!empty(session('shipping_address'))) {{session('shipping_address')->street}}@endif">
                        <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your address')</span>
                      </div>
                      <div class="form-group">
                        <label for=""> @lang('website.Country')</label>
                        <div class="input-group select-control">
                            <select required class="form-control field-validate" id="entry_country_id" onChange="getZones();" name="countries_id" aria-describedby="countryHelp">
                              <option value="" selected>@lang('website.Select Country')</option>
                              @if(!empty($result['countries']))
                                @foreach($result['countries'] as $countries)
                                    <option value="{{$countries->countries_id}}" @if(!empty(session('shipping_address'))) @if(session('shipping_address')->countries_id == $countries->countries_id) selected @endif @endif >{{$countries->countries_name}}</option>
                                @endforeach
                              @endif
                              </select>
                        </div>
                        <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please select your country')</span>
                      </div>
                      <div class="form-group">
                        <label for=""> @lang('website.State')</label>
                        <div class="input-group select-control">
                            <select required class="form-control field-validate" id="entry_zone_id"  onChange="getCities();"   name="zone_id" aria-describedby="stateHelp">
                              <option value="">@lang('website.Select State')</option>
                                @if(!empty($result['zones']))
                                @foreach($result['zones'] as $zones)
                                    <option value="{{$zones->zone_id}}" @if(!empty(session('shipping_address'))) @if(session('shipping_address')->zone_id == $zones->zone_id) selected @endif @endif >{{$zones->zone_name}}</option>
                                @endforeach
                              @endif

                                <option value="-1" @if(!empty(session('shipping_address'))) @if(session('shipping_address')->zone_id == 'Other') selected @endif @endif>@lang('website.Other')</option>
                              </select>
                        </div>
                          <small id="stateHelp" class="form-text text-muted"></small>
                        </div>
                             
                                      <div class="form-group">
                        <label for=""> @lang('website.City')</label>
                        <div class="input-group select-control">
                            <select required class="form-control field-validate" id="city"  name="city" aria-describedby="cityHelp">
                              <option value="" selected>Select City</option>
                              @if(!empty($result['locations']))
                                @foreach($result['locations'] as $location)
                                    <option value="{{$location->location_name}}" @if(!empty(session('shipping_address'))) @if(session('shipping_address')->city == $location->location_name) selected @endif @endif >{{$location->location_name}}</option>
                                @endforeach
                              @endif
                              </select>
                        </div>
                        <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your city')</span>
                      </div>
                        <div class="form-group">
                          <label for=""> @lang('website.Zip/Postal Code')</label>
                          <input required type="number" class="form-control" id="postcode" aria-describedby="zpcodeHelp" placeholder="@lang('website.Enter Your Zip / Postal Code')" name="postcode" value="@if(!empty(session('shipping_address'))){{session('shipping_address')->postcode}}@endif">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your Zip/Postal Code')</span>
                        </div>
                        <div class="form-group">
                          <label for=""> @lang('website.Phone')</label>
                          <input required type="text" class="form-control" id="delivery_phone" maxlength="10" pattern="([0-9]{10})" aria-describedby="numberHelp" placeholder="@lang('website.Enter Your Phone Number')" name="delivery_phone" value="@if(!empty(session('shipping_address'))){{session('shipping_address')->delivery_phone}}@endif">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your valid phone number')</span>
                        </div>
                          
                                <div class="form-group">
                          <label for=""> Alternate Phone Number</label>
                          <input required type="text" class="form-control" id="delivery_alternate_phone" maxlength="10" pattern="([0-9]{10})" aria-describedby="numberHelp" placeholder="@lang('website.Enter Your Phone Number')" name="delivery_alternate_phone" value="">
                          <span style="color:red;" class="help-block error-content" hidden>@lang('website.Please enter your valid phone number')</span>
                        </div>
                          
                                                
                      </div>
                      <div class="form-row">
                        <div class="form-group">
                          <button type="submit"  class="btn swipe-to-top btn-secondary">@lang('website.Continue')</button>
                        </div>
                      </div>
                   </form>
                 </div>
                 <div class="tab-pane fade @if(session('step') == 1) show active @endif"  id="pills-billing" role="tabpanel" aria-labelledby="pills-billing-tab">
                         <form name="signup" enctype="multipart/form-data" action="{{ URL::to('/checkout_billing_address')}}" method="post">
                       <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                       <div class="form-row">
                         <div class="form-group">
                            <label for=""> @lang('website.First Name')</label>
                             <input required type="text" class="form-control same_address" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) readonly @endif @else readonly @endif  id="billing_firstname" name="billing_firstname" value="@if(!empty(session('billing_address'))){{session('billing_address')->billing_firstname}}@endif" aria-describedby="NameHelp1" placeholder="Enter Your Name">
                             <span class="help-block error-content" hidden>@lang('website.Please enter your first name')</span>
                           </div>
                           <div class="form-group">
                            <label for=""> @lang('website.Last Name')</label>
                             <input required type="text" class="form-control same_address" id="exampleInputName2" aria-describedby="NameHelp2" placeholder="Enter Your Name" @if(!empty(session('billing_address'))>0) @if(session('billing_address')->same_billing_address==1) readonly @endif @else readonly @endif  id="billing_lastname" name="billing_lastname" value="@if(!empty(session('billing_address'))>0){{session('billing_address')->billing_lastname}}@endif">
                             <span class="help-block error-content" hidden>@lang('website.Please enter your last name')</span>
                           </div>

                           <div class="form-group">
                            <label for=""> @lang('website.Company')</label>
                             <input required type="text" class="form-control same_address" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) readonly @endif @else readonly @endif  id="billing_company" name="billing_company" value="@if(!empty(session('billing_address'))){{session('billing_address')->billing_company}}@endif" id="exampleInputCompany1" aria-describedby="companyHelp" placeholder="Enter Your Company Name">
                             <span class="help-block error-content" hidden>@lang('website.Please enter your company name')</span>
                           </div>

                           <div class="form-group">
                            <label for=""> @lang('website.Address')</label>
                             <input required type="text" class="form-control same_address" id="exampleInputAddress1" aria-describedby="addressHelp" placeholder="Enter Your Address" @if(!empty(session('22'))>0) @if(session('billing_address')->same_billing_address==1) readonly @endif @else readonly @endif  id="billing_street" name="billing_street" value="@if(!empty(session('billing_address'))>0){{session('billing_address')->billing_street}}@endif">
                             <span class="help-block error-content" hidden>@lang('website.Please enter your address')</span>
                           </div>
                           <div class="form-group">
                            <label for=""> @lang('website.Country')</label>
                             <div class="input-group select-control">
                                 <select required class="form-control same_address_select" id="billing_countries_id" aria-describedby="countryHelp" onChange="getBillingZones();" name="billing_countries_id" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) disabled @endif @else disabled @endif>
                                   <option value=""  >@lang('website.Select Country')</option>
                                   @if(!empty($result['countries']))
                                     @foreach($result['countries'] as $countries)
                                         <option value="{{$countries->countries_id}}" @if(!empty(session('billing_address'))) @if(session('billing_address')->billing_countries_id == $countries->countries_id) selected @endif @endif >{{$countries->countries_name}}</option>
                                     @endforeach
                                   @endif
                                   </select>
                             </div>
                             <span class="help-block error-content" hidden>@lang('website.Please select your country')</span>
                           </div>
                           <div class="form-group">
                            <label for=""> @lang('website.State')</label>
                             <div class="input-group select-control">
                                 <select required class="form-control same_address_select" onChange="getBillingCities();" name="billing_zone_id" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) disabled @endif @else disabled @endif id="billing_zone_id" aria-describedby="stateHelp">
                                   <option value="" >@lang('website.Select State')</option>
                                   @if(!empty($result['zones']))
                                     @foreach($result['zones'] as $key=>$zones)
                                         <option value="{{$zones->zone_id}}" @if(!empty(session('billing_address'))) @if(session('billing_address')->billing_zone_id == $zones->zone_id) selected @endif @endif >{{$zones->zone_name}}</option>
                                     @endforeach
                                   @endif
                                     <option value="-1" @if(!empty(session('billing_address'))) @if(session('billing_address')->billing_zone_id == 'Other') selected @endif @endif>@lang('website.Other')</option>
                                   </select>
                             </div>
                             <span class="help-block error-content" hidden>@lang('website.Please select your state')</span>
                           </div>
                         
                         
                         
                                  <div class="form-group">
                            <label for=""> @lang('website.City')</label>
                            <div class="input-group select-control">
                                 <select required class="form-control same_address_select" name="billing_city" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) disabled  @endif @else disabled  @endif  id="billing_city"    aria-describedby="cityHelp">
                                   <option value="" > Select City</option>
                                   @if(!empty($result['locations']))
                                     @foreach($result['locations'] as $key=>$location)
                                         <option value="{{$location->location_name}}" @if(!empty(session('billing_address'))) @if(session('billing_address')->billing_city == $location->location_name) selected @endif @endif >{{$location->location_name}}</option>
                                     @endforeach
                                   @endif
                                    </select>
                             </div>
                            
                            
                                <span class="help-block error-content" hidden>@lang('website.Please enter your city')</span>
                           </div>
                         
                         
                             <div class="form-group">
                              <label for=""> @lang('website.Zip/Postal Code')</label>
                               <input required type="text" class="form-control same_address" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) readonly @endif @else readonly @endif  id="billing_zip" name="billing_zip" value="@if(!empty(session('billing_address'))){{session('billing_address')->billing_zip}}@endif" aria-describedby="zpcodeHelp" placeholder="Enter Your Zip / Postal Code">
                               <small id="zpcodeHelp" class="form-text text-muted"></small>
                             </div>
                             <div class="form-group">
                              <label for=""> @lang('website.Phone')</label>
                               <input required type="text" maxlength="10" pattern="([0-9]{10})" class="form-control same_address" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) readonly @endif @else readonly @endif  id="billing_phone" name="billing_phone" value="@if(!empty(session('billing_address'))){{session('billing_address')->billing_phone}}@endif" aria-describedby="numberHelp" placeholder="Enter Your Phone Number">
                               <span class="help-block error-content" hidden>@lang('website.Please enter your valid phone number')</span>
                             </div>
                             <div class="form-group">
                              <label for="">Alternate Phone Number</label>
                               <input required type="text" maxlength="10" pattern="([0-9]{10})" class="form-control same_address" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) readonly @endif @else readonly @endif  id="billing_alternate_phone" name="billing_alternate_phone" value="@if(!empty(session('billing_address'))){{session('billing_address')->billing_alternate_phone}}@endif" aria-describedby="numberHelp" placeholder="Enter Your Phone Number">
                               <span class="help-block error-content" hidden>@lang('website.Please enter your valid phone number')</span>
                             </div>
                             
                            </div>
                             <div class="form-row">
                             <div class="form-group">
                                 <div class="form-check">
                                     <input class="form-check-input" type="checkbox" id="same_billing_address" value="1" name="same_billing_address" @if(!empty(session('billing_address'))) @if(session('billing_address')->same_billing_address==1) checked @endif @else checked  @endif > @lang('website.Same shipping and billing address')
                                     <small id="checkboxHelp" class="form-text text-muted"></small>
                                   </div>
                             </div>
                             </div>
                             <div class="form-row">
                              <div class="form-group">
                               <button type="submit"  class="btn swipe-to-top btn-secondary"><span>@lang('website.Continue')</span></button>
                              </div>
                             </div>
                       </form>
                 </div>
                 <div class="tab-pane fade  @if(session('step') == 2) show active @endif" id="pills-method" role="tabpanel" aria-labelledby="pills-method-tab">

                             <div class="col-12 col-sm-12 ">
                                <div class="row"> <p>@lang('website.Please select a prefered shipping method to use on this order')</p></div>
                             </div>

                             <form name="shipping_mehtods" method="post" id="shipping_mehtods_form" enctype="multipart/form-data" action="{{ URL::to('/checkout_payment_method')}}">
                              <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                @if(!empty($result['shipping_methods'])>0)
                                    <input type="hidden" name="mehtod_name" id="mehtod_name">
                                    <input type="hidden" name="shipping_price" id="shipping_price">

                                     @foreach($result['shipping_methods'] as $shipping_methods)
                                        <div class="heading">
                                            <h2>Shipping Charges</h2>
                                            <hr>
                                        </div>
                                        <div class="form-check">

                                            <div class="form-row">
                                                @if($shipping_methods['success']==1)
                                                <ul class="list"style="list-style:none; padding: 0px;">
                                                    @foreach($shipping_methods['services'] as $services)
                                                     <?php
                                                         if($services['shipping_method']=='upsShipping')
                                                            $method_name=$shipping_methods['name'].'('.$services['name'].')';
                                                         else{
                                                            $method_name=$services['name'];
                                                            }
                                                        ?>
                                                        <li>
                                                     
                                                        <input class="shipping_data" id="{{$method_name}}" type="radio" name="shipping_method" value="{{$services['shipping_method']}}" shipping_price="{{$services['rate']}}"  method_name="{{$method_name}}" @if(!empty(session('shipping_detail')) and !empty(session('shipping_detail')) > 0)
                                                        @if(session('shipping_detail')->mehtod_name == $method_name) checked @endif
                                                        @elseif($shipping_methods['is_default']==1) checked @endif
                                                        @if($shipping_methods['is_default']==1) checked @endif
                                                        >
                                                       
                                                            @if(auth()->guard('customer')->user()->customer_type=="CUSTOMER" || auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER")
                                     
                                                        
                                                                                <div class="alert alert-success">
                                         Shipping Charges will be applicable for this order. Our executive will assist you for the shipping prices or delivery prices depending upon Distance once the order is confirmed. In this order the Shipping Charges are not included.
                                         </div>
										 @endif
                                                        
                                                        
                                                        
                                                                                                               
<!--                                                          @if($result['commonContent']['setting'][82]->value <= session('total_price')) -->
<!--                                                          {{Session::get('symbol_left')}}0 -->
<!--                                                          @else -->
<!--                                                          {{Session::get('symbol_left')}}{{$services['rate']* session('currency_value')}}{{Session::get('symbol_right')}} -->
<!--                                                          @endif</label> -->
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                @else
                                                    <ul class="list"style="list-style:none; padding: 0px;">
                                                        <li>@lang('website.Your location does not support this') {{$shipping_methods['name']}}.</li>
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="alert alert-danger alert-dismissible error_shipping" role="alert" style="display:none;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    @lang('website.Please select your shipping method')
                                </div>

                                <div class="row">
                                  <div class="col-12 col-sm-12">
                                  <button type="submit" class="btn swipe-to-top btn-secondary">@lang('website.Continue')</button>
                                  </div>
                                </div>
                              </form>

                 </div>
                 <div class="tab-pane fade @if(session('step') == 3) show active @endif" id="pills-order" role="tabpanel" aria-labelledby="pills-method-order">
                               <?php
                                   $price = 0;
                               ?>
                               <form method='POST' id="update_cart_form" action='{{ URL::to('/place_order')}}' >
                                 {!! csrf_field() !!}
                                 
          
                
                <input type="hidden" id="paymentID" name="paymentID"/>
                
  <input type="hidden" id="paymentDate" name="paymentDate"/>
  
  
                                       <table class="table top-table">
                                           
                                           @foreach( $result['cart'] as $products)
                                           <?php
                                              $orignal_price = $products->final_price * session('currency_value');
                                              $price+= $orignal_price * $products->customers_basket_quantity;
                                           ?>

                                           <tbody>

                                            <tr class="d-flex">
                                              <td class="col-12 col-md-2" >
                                                <input type="hidden" name="cart[]" value="{{$products->customers_basket_id}}">
                                                <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}" class="cart-thumb">
                                                    <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}" alt="">
                                                </a>
                                              </td>
                                              <td class="col-12 col-md-5 justify-content-start">
                                                  <div class="item-detail">
                                                      <span class="pro-info">
                                                        @foreach($products->categories as $key=>$category)
                                                            {{$category->categories_name}}@if(++$key === count($products->categories)) @else, @endif
                                                        @endforeach 
                                                      </span>
                                                      <h5 class="pro-title">
                                                          
                                                        <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}">
                                                              
                                                         @if($products->product_selected_name) 
                                                         {{$products->product_selected_name}}
                                                         
                                                         @else 
                                                          {{$products->products_name}}
                                                         @endif
                                                        </a>
                                                       
                                                      </h5>
                                                      
                                                      <div class="item-attributes">
                                                        @if(isset($products->attributes))
                                                          @foreach($products->attributes as $attributes)
                                                            <small>{{$attributes->attribute_name}} : {{$attributes->attribute_value}}</small>
                                                          @endforeach
                                                        @endif
                                                      </div>
                                                     
                                                    </div>
                                                </td>
                                                <?php                                                      
                                                    $orignal_price = $products->final_price * session('currency_value');
                                                ?>
                                              <td class="item-price col-12 col-md-2"><span>{{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span></td>
                                              <td class="col-12 col-md-1">
                                                  <div class="input-group item-quantity">                                                      
                                                    <input type="text" id="quantity" readonly name="quantity" class="form-control input-number" value="{{$products->customers_basket_quantity}}">                    
                                                  </div>
                                              </td>
                                              <td class="align-middle item-total col-12 col-md-2 ">{{Session::get('symbol_left')}}{{$orignal_price*$products->customers_basket_quantity}}{{Session::get('symbol_right')}}</td>
                                            </tr>

                                           </tbody>
                                           @endforeach
                                       </table>
                                                   <?php
                                                      if(!empty(session('coupon_discount'))){
                                                        $coupon_amount = session('currency_value') * session('coupon_discount');  
                                                      }else{
                                                        $coupon_amount = 0;
                                                      }

                                                      if(!empty(session('tax_rate'))){
                                                        $tax_rate = session('currency_value') * session('tax_rate');  
                                                      //  echo "tax".session('tax_rate');
                                                      }else{
                                                        $tax_rate = 0;
                                                      }
                                                  //  $tax_rate=0.18;
                                                       if(!empty(session('shipping_detail')) and !empty(session('shipping_detail'))>0){
                                                           $shipping_price = session('shipping_detail')->shipping_price;
                                                           $shipping_name = session('shipping_detail')->mehtod_name;
                                                       }else{
                                                           $shipping_price = 0;
                                                           $shipping_name = '';
                                                       }
                                                   //$price=$price*$tax_rate;
                                                      // dd($price,$tax_rate,$shipping_price);
                                                       $tax_rate = number_format((float)$tax_rate, 2, '.', '');
                                                       $coupon_discount = number_format((float)$coupon_amount, 2, '.', '');
                                                       $total_price = ($price+$tax_rate+($shipping_price*session('currency_value')))-$coupon_discount;
                                                       session(['total_price'=>($total_price)]);

                                                    ?>
                               </form>
             <div class="row">
                               <div class="col-12 col-sm-12">
                                    
                                        <div class="heading">
                                            <h4>@lang('website.orderNotesandSummary')</h4>
                                            
                                          </div>
                                      
                                      <div class="form-group" style="width:100%; padding:0;">
                                        <label for="exampleFormControlTextarea1">@lang('website.Please write notes of your order')</label>
                                          <textarea name="comments" id="exampleFormControlTextarea1"  class="form-control" id="order_comments" rows="3">@if(!empty(session('order_comments'))){{session('order_comments')}}@endif</textarea>
                                        </div>
                                    </div>
                                
                                         <div class="col-12 col-sm-12 mb-1">
                                         <div class="heading">
                                           <h2>@lang('website.Payment Methods')</h2>
                                           <hr>
                                           <p> 
                                           
                                                                                     <label for="exampleFormControlTextarea1" style="width:100%; margin-bottom:30px;">@lang('website.Please select a prefered payment method to use on this order')</label>
                                           
                                           </p>
                                           
                                         </div>

                                          @if(auth()->guard('customer')->user()->customer_type=="CUSTOMER" || auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER")
                                         <div class="alert alert-success">
                                         Shipping Charges will be applicable for this order. Our executive will assist you for the shipping prices or delivery prices depending upon Distance once the order is confirmed. In this order the Shipping Charges are not included.
                                         </div>
										 @endif

                                          <div class="row  ">
                                         <div class="col-6 col-md-6   col-sm-6 col-xs-6 mb-3 ">
                                           <form name="shipping_mehtods" method="post" id="payment_mehtods_form" enctype="multipart/form-data" action="{{ URL::to('/order_detail')}}">
                                          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                      
                                         <div class="form-group" style="width:100%; margin-left:30px;">
                                          <input id="payment_currency" type="hidden" onClick="paymentMethods();" name="payment_currency" value="{{session('currency_code')}}">
                                      <?php $flag=$total_price<=$remainingwallet_amount?1:0; ?>
                                       
                                            
                                               
                                      
                                          @foreach($result['payment_methods'] as $payment_methods)
                                            <div class="row">
                                         <div class="col-12 col-md-12 mb-2">
                                            @if($payment_methods['active']==1)
                                            
                                            
                                             
                                              
                                            
                                              
                                            
                                            
                                               <input id="payment_currency" type="hidden" onClick="paymentMethods();" name="payment_currency" value="{{$payment_methods['payment_currency']}}">
                                              @if($payment_methods['payment_method']=='cash_on_delivery'  )

                                                   
                                              
                                                  <input id="{{$payment_methods['payment_method']}}_public_key" type="hidden" name="public_key" value="{{$payment_methods['public_key']}}">
                                                  <input id="{{$payment_methods['payment_method']}}_environment" type="hidden" name="{{$payment_methods['payment_method']}}_environment" value="{{$payment_methods['environment']}}">
                                                
                                                  
                                              
                                                  <div class="form-checkx form-check-inlinex">
                                                    <input onClick="paymentMethods();" id="{{$payment_methods['payment_method']}}_label" type="radio" name="payment_method" class="form-check-input payment_method" value="{{$payment_methods['payment_method']}}" @if(!empty(session('payment_method'))) @if(session('payment_method')==$payment_methods['payment_method']) checked @endif @endif>
                                                     <label class="form-check-label" for="{{$payment_methods['payment_method']}}_label">
                                                     </label>
                                                         @if(file_exists( 'images/'.str_replace(" ","_", $payment_methods['payment_method']).'.png'))
                                                     <img   src="{{URL::asset('images/').'/'.str_replace(" ","_", $payment_methods['payment_method']).'.png'}}" alt="{{$payment_methods['name']}}">
                                                      @else
                                                      {{$payment_methods['name']}}
                                                      @endif
                                                   
                                                  </div>
                                              @endif  
                                              
                                              
                                                      @if($payment_methods['payment_method']=='razor_pay')

                                                 
                                              
                                                  <input id="{{$payment_methods['payment_method']}}_public_key" type="hidden" name="public_key" value="{{$payment_methods['public_key']}}">
                                                  <input id="{{$payment_methods['payment_method']}}_environment" type="hidden" name="{{$payment_methods['payment_method']}}_environment" value="{{$payment_methods['environment']}}">
                                                
                                                  
                                              
                                                  <div class="form-checkx form-check-inlinex">
                                                    <input onClick="paymentMethods();" id="{{$payment_methods['payment_method']}}_label" type="radio" name="payment_method" class="form-check-input payment_method" value="{{$payment_methods['payment_method']}}" @if(!empty(session('payment_method'))) @if(session('payment_method')==$payment_methods['payment_method']) checked @endif @endif>
                                                     <label class="form-check-label" for="{{$payment_methods['payment_method']}}_label">
                                                     </label>
<!--                                                          @ i f(file_exists( 'images/'.str_replace(" ","_", $payment_methods['payment_method']).'.png')) -->
<!--                                                      <img   src="{{URL::asset('images/').'/'.str_replace(" ","_", $payment_methods['payment_method']).'.png'}}" alt="{{$payment_methods['name']}}"> -->
<!--                                                       @ else -->
                                                     <b> {{$payment_methods['name']}}, PhonePe, Google Pay, UPI, PayTm</b>
<!--                                                       @ endif -->
                                                   
                                                  </div>
                                              @endif  
                                               @if($payment_methods['payment_method']=='buildermart_wallet' && auth()->guard('customer')->user()->customer_type=="CLIENT" && $flag==1 )
    
                                 			 
                                 				 <input id="{{$payment_methods['payment_method']}}_public_key" type="hidden" name="public_key" value="{{$payment_methods['public_key']}}">
                                                  <input id="{{$payment_methods['payment_method']}}_environment" type="hidden" name="{{$payment_methods['payment_method']}}_environment" value="{{$payment_methods['environment']}}">
                                                
                                                  
                                              
                                                  <div class="form-checkx form-check-inlinex">
                                                    <input onClick="paymentMethods();" id="{{$payment_methods['payment_method']}}_label" type="radio" name="payment_method" class="form-check-input payment_method" value="{{$payment_methods['payment_method']}}" @if(!empty(session('payment_method'))) @if(session('payment_method')==$payment_methods['payment_method']) checked @endif @endif>
                                                     <label class="form-check-label" for="{{$payment_methods['payment_method']}}_label">
                                                     </label>
                                                         @if(file_exists( 'images/'.str_replace(" ","_", $payment_methods['payment_method']).'.png'))
                                                     <img   src="{{URL::asset('images/').'/'.str_replace(" ","_", $payment_methods['payment_method']).'.png'}}" alt="{{$payment_methods['name']}}">
                                                      @else
                                                      {{$payment_methods['name']}}
                                                      @endif
                                                   
                                                  </div>
                                 				
 
                                              @endif  
                                                @endif
                                               
								</div></div>
                                          @endforeach 
                                          
                                          
                                            
                                                                                 
                                        </div>
                                         </form>
                                         </div>
                                         
                                         
                                          <div class="col-6 col-md-6 mb-3 col-sm-6 col-xs-6 jumbotron text-center ">
                                          <div class="button">
                                            @foreach($result['payment_methods'] as $payment_methods)
                                          
                                              @if($payment_methods['active']==1 and $payment_methods['payment_method']=='banktransfer')
                                              <div class="alert alert-info alert-dismissible" id="payment_description" role="alert" style="display: none">
                                              <span>{{$payment_methods['descriptions']}}</span>
                                              </div>
                                              @endif

                                            @endforeach

                                                <!--- paypal -->
                                                 
                                                 <button id="cash_on_delivery_button" class="btn swipe-to-top btn-secondary payment_btns" style="display: none">@lang('website.Order Now')</button>
                                                <button id="buildermart_wallet_button" class="btn swipe-to-top btn-secondary payment_btns" style="display: none">@lang('website.Order Now')</button>
                                             
                                                 <button id="razor_pay_button" class="razorpay-payment-button btn swipe-to-top btn-secondary payment_btns"  style="display: none"  type="button">@lang('website.Order Now')</button>
                                                
                                              </div>
                                         </div>
                                         
                                         </div>
                                         
                                       
                                          
                                          
                                       </div>
                                        
                                      

                                      
                                        
                                   </div>
       
                 </div>
               </div>

         </div>
         </div>
     </div>
     
     <div class="col-12 col-xl-3 checkout-right cart-page-one cart-area">
      <table class="table right-table">
        <thead>
          <tr>
            <th scope="col" colspan="2" align="center">@lang('website.Order Summary')</th>                    
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">@lang('website.SubTotal')</th>
            <td align="right">{{Session::get('symbol_left')}}{{$price+0}}{{Session::get('symbol_right')}}</td>

          </tr>
          <tr>
            <th scope="row">@lang('website.Discount')</th>
            <td align="right">{{Session::get('symbol_left')}}{{number_format((float)$coupon_discount, 2, '.', '')+0*session('currency_value')}}{{Session::get('symbol_right')}}</td>

          </tr>
          <tr>
              <th scope="row">@lang('website.Tax')</th>
              <td align="right">{{Session::get('symbol_left')}}{{$tax_rate*session('currency_value')}}{{Session::get('symbol_right')}}</td>

            </tr>
            <tr>
                <th scope="row">@lang('website.Shipping Cost')</th>
                <td align="right">{{Session::get('symbol_left')}}{{$shipping_price*session('currency_value')}}{{Session::get('symbol_right')}}</td>

              </tr>
          <tr class="item-price">
            <th scope="row">@lang('website.Total')</th>
            <td align="right" >{{Session::get('symbol_left')}}{{number_format((float)$total_price+0, 2, '.', '')+0*session('currency_value')}}{{Session::get('symbol_right')}}</td>

          </tr>
      
        </tbody>
        
      </table>

       </div>
   </div>
 </div>
</section>
</section>

<script>
jQuery(document).on('click', '#cash_on_delivery_button, #banktransfer_button, #buildermart_wallet_button', function(e){
	jQuery("#update_cart_form").submit();
});
</script>
<script>
    $('#rzp-footer-form').submit(function (e) {
        var button = $(this).find('button');
        var parent = $(this);
        button.attr('disabled', 'true').html('Please Wait...');
        $.ajax({
            method: 'get',
            url: this.action,
            data: $(this).serialize(),
            complete: function (r) {
                jQuery("#update_cart_form").submit();
                console.log(r);
            }
        })
        return false;
    })
</script>

<script>
    function padStart(str) {
        return ('0' + str).slice(-2)
    }

    function demoSuccessHandler(transaction) {
        // You can write success code here. If you want to store some data in database.
        jQuery("#paymentDetail").removeAttr('style');
        $('#paymentID').val(transaction.razorpay_payment_id);
        
       // alert("Transaction id "+transaction.razorpay_payment_id);
        
        var paymentDate = new Date();
        jQuery('#paymentDate').text(
                padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
                );

        jQuery.ajax({
            method: 'post',
            url: "{!!route('dopayment')!!}",
            data: {
                "_token": "{{ csrf_token() }}",
                "razorpay_payment_id": transaction.razorpay_payment_id
            },
            complete: function (r) {
                jQuery("#update_cart_form").submit();
                console.log(r);
            }
        })
    }
</script>
<?php

if(!empty($result['payment_methods'][6]) and $result['payment_methods'][6]['active'] == 1){

$rezorpay_key =  $result['payment_methods'][6]['RAZORPAY_KEY'];

if(!empty($result['commonContent']['setting'][79]->value)){
  $name = $result['commonContent']['setting'][79]->value;
}else{
  $name = Lang::get('website.Ecommerce');
}

$logo = $result['commonContent']['setting'][15]->value;
 ?>
<script>
    var options = {
        key: "{{ $rezorpay_key }}",
        amount: '<?php echo (float) round($total_price, 2)*100;?>',
        name: '{{$name}}',
        image: '{{$logo}}',
        handler: demoSuccessHandler
    }
</script>
<script>
    window.r = new Razorpay(options);
    document.getElementById('razor_pay_button').onclick = function () {
        r.open()
    }
</script>

<?php
}

foreach($result['payment_methods'] as $payment_methods){
  if($payment_methods['active']==1 and $payment_methods['payment_method']=='midtrans'){
    if($payment_methods['environment'] == 'Live'){
      print '<script src="https://app.midtrans.com/snap/snap.js" data-client-key="'.$payment_methods['public_key'].'"></script>';
    }else{
      print '<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="'.$payment_methods['public_key'].'"></script>';

    }
  }
}
                                          
                                            

?>

<script>
jQuery( document ).ready( function () {
  var midtrans_environment = jQuery('#midtrans_environment').val();
  if(midtrans_environment !== undefined){
    midtrans_environment = midtrans_environment;
  }else{
    midtrans_environment = ';'
  }
});

</script>


<script type="text/javascript">
  document.getElementById('midtrans_button').onclick = function(){
    var tokken = jQuery('#midtransToken').val();
      // SnapToken acquired from previous step
      snap.pay(tokken, {
          // Optional
          onSuccess: function(result){
           // alert('onSuccess');
              // /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
              paymentSuccess(JSON.stringify(result, null, 2));
          },
          // Optional
          onPending: function(result){
           // alert('onPending');
              /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          // Optional
          onError: function(result){
            jQuery('#payment_error').show();
            var response = JSON.stringify(result, null, 2);
           // alert('error');
              /* You may add your own js here, this is just example */ document.getElementById('payment_error-error-text').innerHTML += result.status_message;
          }
      });
  };
  
  
  
//validate form
$("#delivery_phone").keyup(function() {
    $("#delivery_phone").val(this.value.match(/[0-9]*/));
	 
	      
});

$("#delivery_alternate_phone").keyup(function() {
    $("#delivery_alternate_phone").val(this.value.match(/[0-9]*/));
	
});

$("#billing_phone").keyup(function() {
    $("#billing_phone").val(this.value.match(/[0-9]*/));

});

$("#billing_alternate_phone").keyup(function() {
    $("#billing_alternate_phone").val(this.value.match(/[0-9]*/));
});
  
</script>

@endsection
