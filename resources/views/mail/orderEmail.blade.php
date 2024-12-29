  <style>
      * {
 
 font-family: Verdana !important;
}
 
 table {
	font-family:Verdana;

}
  </style>
  
  
  <table   dir="ltr" style="color:rgb(51,51,51);margin:0 auto;border-collapse:collapse;width:720px;"  > 
   <tbody>
    <tr> 
     <td>  
     
    
       <table  style="width:100%;border-collapse:collapse"  > 
       <tbody>
        <tr> 
         <td style="vertical-align:top;line-height:16px;font-family:Verdana,Arial,sans-serif"> 
          <table   style="width:100%;border-collapse:collapse"> 
           <tbody>
               
            <tr> 
             <td rowspan="2" style="width:115px;padding:18px 0 0 0;vertical-align:top;line-height:16px;font-family:Verdana,Arial,sans-serif"> <a href="https://buildermart.in/" title="Visit buildermart.in" style="text-decoration:none;color:rgb(0,102,153);font:12px/16px verdana,Arial,sans-serif" rel="noreferrer" target="_blank"  > <img alt="buildermart.in" src="https://buildermart.in/images/media/2021/11/uksTb18406.png" style="border:0;width:115px" > </a> </td> 
             <td style="text-align:right;padding:5px 0;border-bottom:1px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;line-height:16px;font-family:Verdana,Arial,sans-serif"> </td>
             <td style="padding:7px 5px 0;text-align:right;border-bottom:1px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;line-height:16px;font-family:Verdana,Arial,sans-serif"> </td> 
             <td style="text-align:right;padding:5px 0;border-bottom:1px solid rgb(204,204,204);white-space:nowrap;vertical-align:top;line-height:16px;font-family:Verdana,Arial,sans-serif">
                
                 <a href="https://buildermart.in/orders">Your Orders</a> 
                  <span style="text-decoration:none;color:rgb(204,204,204);font-size:15px;font-family:Verdana,Arial,sans-serif">&nbsp;|&nbsp;</span> <a href="https://buildermart.in/login"  target="_blank"  >Your Account</a> 
             <span style="text-decoration:none;color:rgb(204,204,204);font-size:15px;font-family:Verdana,Arial,sans-serif">&nbsp;|&nbsp;</span> 
             <a href="https://buildermart.in/"  style="border-right:0px solid rgb(204,204,204);margin-right:0px;padding-right:0px;color:rgb(0,102,153);font:12px/16px verdana,Arial,sans-serif" rel="noreferrer" target="_blank"  >Buildermart.in</a>
             </td>  
            </tr> 
            <tr> 
             <td colspan="3" style="text-align:right;padding:7px 0 5px 0;vertical-align:top;line-height:16px;font-family:Verdana,Arial,sans-serif"> <h2 style="font-size:20px;line-height:24px;margin:0;padding:0;font-weight:normal;color:rgb(0,0,0)!important"> Order Confirmation </h2>  <small style="padding:10px;">Order Confirmation</small>
    <small  style="padding:10px;">{{ trans('labels.OrderID') }}# {{ $ordersData['orders_data'][0]->orders_id }}</small>
    
    <small style="padding: 10px;">{{ trans('labels.OrderedDate') }}: {{ date('m/d/Y', strtotime($ordersData['orders_data'][0]->date_purchased)) }} </small>
 <br> </td> 
            </tr> 
           </tbody>
          </table> </td> 
        </tr> 
        
     
    
       
       </tbody>
      </table> 
 
 
 
 
 
 
   <br>
   
       <table  style="width:100%;border-collapse:collapse"> 
       <tbody>
        <tr> 
        <td>
            
            
   <div style="padding: 5px;  overflow: hidden">
    <div style="width: 100%; display: block;">
          <span>
              
              Hello       <span style="text-transform: capitalize;">{{ $ordersData['orders_data'][0]->customers_name }},</span><br><br>

    Thank you for ordering and your order is confirmed. Your product delivery will be updated by our delivery staff. If you would like to view the status of your order <a href="https://buildermart.in/orders">click to view. </a>
</span> 
        </div>
  <hr style="border-top: 1px solid red;">
  <!-- info row -->
  <div style="display: display: block;width: 100%;padding: 0 0 20px; ">
    <div style="display: inline-block; width:35%"> <strong>{{ trans('labels.CustomerInfo') }}:</strong>
      
      <span style="text-transform: capitalize;">{{ $ordersData['orders_data'][0]->customers_name }}</span><br>
      {{ $ordersData['orders_data'][0]->customers_street_address }} <br>
        {{ $ordersData['orders_data'][0]->customers_city }}, {{ $ordersData['orders_data'][0]->customers_state }} {{ $ordersData['orders_data'][0]->customers_postcode }}, {{ $ordersData['orders_data'][0]->customers_country }}<br>
        {{ trans('labels.Phone') }}: {{ $ordersData['orders_data'][0]->customers_telephone }}<br>
        {{ trans('labels.Email') }}: {{ $ordersData['orders_data'][0]->email }}
     
    </div>
    <div style="display: inline-block; width:32%"> <strong>{{ trans('labels.ShippingInfo') }}:</strong>
     
      <span style="text-transform: capitalize;">{{ $ordersData['orders_data'][0]->delivery_name }}</span><br>
      {{ $ordersData['orders_data'][0]->delivery_street_address }} <br>
      {{ $ordersData['orders_data'][0]->delivery_city }}, {{ $ordersData['orders_data'][0]->delivery_state }} {{ $ordersData['orders_data'][0]->delivery_postcode }}, {{ $ordersData['orders_data'][0]->delivery_country }}
      
    </div>
    <div style="display: inline-block; width:32%"> <strong>{{ trans('labels.BillingInfo') }}:</strong>
     
      <span style="text-transform: capitalize;">{{ $ordersData['orders_data'][0]->billing_name }}</span><br>
       {{ $ordersData['orders_data'][0]->billing_street_address }} <br>
       {{ $ordersData['orders_data'][0]->billing_city }}, {{ $ordersData['orders_data'][0]->billing_state }} {{ $ordersData['orders_data'][0]->billing_postcode }}, {{ $ordersData['orders_data'][0]->billing_country }}
      
    </div>
    
    <!-- /.col --> 
  </div>
  <!-- /.row --> 
  
  <!-- Table row -->
  <table class="table table-striped" style="width: 100%;background-color: transparent;margin: 15px 0 15px;font-family:Verdana,Arial,sans-serif">
    <thead>
      <tr>
        <th align="center">{{ trans('labels.Qty') }}</th>
        <th align="center" >{{ trans('labels.Image') }}</th>
        <th align="center">{{ trans('labels.ProductName') }}</th>
        <th align="center">{{ trans('labels.AdditionalAttributes') }}</th>
        <th align="center">{{ trans('labels.Price') }}</th>
      </tr>
    </thead>
    <tbody style="text-transform: capitalize;font-family:Verdana,Arial,sans-serif">
     @foreach($ordersData['orders_data'][0]->data as $key=>$products)
      <tr @if($key%2==0) style="background-color: #d8d8d8;font-family:Verdana,Arial,sans-serif" @endif>
      
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif {{  $products->products_quantity }}</td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif<img src="{{ asset('').$products->image }}" width="60px"> </td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif  {{  $products->products_name }}<br></td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif
            @foreach($products->attribute as $attributes)
                <b>Name:</b> {{ $attributes->products_options }}<br>
                <b>Value:</b> {{ $attributes->products_options_values }}<br>
                <b>Price:</b> {{ $attributes->price_prefix }}{{ $attributes->options_values_price }}<br>
    
            @endforeach
        </td>
        @if($key%2==0) <td align="center" style="border-top: 1px solid #f4f4f4; padding: 8px;"> @else <td align="center" style="padding: 8px;"> @endif  ₹  {{ $products->final_price }}</td>
      </tr>
      @endforeach
      <tr>
        <td align="left" colspan="5" >
            <a style="   background: #3D94F6;
   background-image: -webkit-linear-gradient(top, #3D94F6, #1E62D0);
   background-image: -moz-linear-gradient(top, #3D94F6, #1E62D0);
   background-image: -ms-linear-gradient(top, #3D94F6, #1E62D0);
   background-image: -o-linear-gradient(top, #3D94F6, #1E62D0);
   background-image: -webkit-gradient(to bottom, #3D94F6, #1E62D0);
   -webkit-border-radius: 5px;
   -moz-border-radius: 5px;
   border-radius: 5px;
   color: #FFFFFF;
   font-family:Verdana,Arial,sans-serif;
   
   font-weight: 400;
   padding: 10px;
   -webkit-box-shadow: 0 5px 13px 0 #000000;
   -moz-box-shadow: 0 5px 13px 0 #000000;
   box-shadow: 0 5px 13px 0 #000000;
   text-shadow: 1px 1px 20px #000000;
   border: solid #337FED 1px;
   text-decoration: none;
   display: inline-block;
   cursor: pointer;
   text-align: center;;color:white;padding:7px" href="https://buildermart.in/orders">Track your Package </a>
            </td> 
          
          
      </tr>
    </tbody>
  </table>
  
  <!-- /.row -->
  
  <div style="display: block;"> 
    <!-- accepted payments column -->
    <div style="float:left;width: 100%;padding-right: 4%;">
      <p class="lead" style="margin-bottom: 0;font-size: 18px;font-weight: bold;">{{ trans('labels.PaymentMethods') }}:</p>
      <p style="text-transform:capitalize; border: 1px solid #e3e3e3; padding: 10px;border-radius: 4px;background-color: #f5f5f5;margin-top: 5px;"> {{ str_replace('_',' ', $ordersData['orders_data'][0]->payment_method) }} </p>
      
      @if(!empty($ordersData['orders_data'][0]->coupon_code))
      <p style="margin-bottom: 5px;font-size: 18px;font-weight: bold;">{{ trans('labels.Coupons') }}:</p>
      <table style="text-align: center; width: 80%;
    border-radius: 3px;     margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;">
        <tr>
          <th style="text-align: center; border-top: 1px solid #f4f4f4;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ trans('labels.Code') }}</th>
          <th style="text-align: center; border-top: 1px solid #f4f4f4;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ trans('labels.Amount') }}</th>
        </tr>
    
     @foreach( json_decode($ordersData['orders_data'][0]->coupon_code) as $couponData)
        <tr>
          <td style="text-align: center; border-top: 1px solid #e3e3e3;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ $couponData->code}}</td>
    
          <td style="text-align: center; border-top: 1px solid #e3e3e3;     padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;">{{ $couponData->amount}} 
            
            @if($couponData->discount_type=='percent_product')
                ({{ trans('labels.Percent') }})
            @elseif($couponData->discount_type=='percent')
                ({{ trans('labels.Percent') }})
            @elseif($couponData->discount_type=='fixed_cart')
                ({{ trans('labels.Fixed') }})
            @elseif($couponData->discount_type=='fixed_product')
                ({{ trans('labels.Fixed') }})
            @endif
           </td>
        </tr>
      @endforeach
        
      </table>
      
      @endif
      
    </div>
    <br>
    <!-- /.col -->
    <div style="float:left;width: 100%;padding-right: 4%"> 
      
        <table style="width: 100%;padding: 38px 0;">
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.Subtotal') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;"> ₹ {{ $ordersData['subtotal'] }}</td>
          </tr>
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.Tax') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">  ₹   {{ $ordersData['orders_data'][0]->total_tax }}</td>
          </tr>
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.ShippingCost') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">  ₹   {{ $ordersData['orders_data'][0]->shipping_cost }}</td>
          </tr>
          @if(!empty($ordersData['orders_data'][0]->coupon_code))
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.DicountCoupon') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;">  ₹   {{ $ordersData['orders_data'][0]->coupon_amount }}</td>
          </tr>
          @endif
          <tr>
            <th style="width:50%;padding: 10px 0; border-top: 1px solid #f4f4f4;" align="left">{{ trans('labels.Total') }}:</th>
            <td align="right" style="border-top: 1px solid #f4f4f4;"> ₹ {{ $ordersData['orders_data'][0]->order_price }}</td>
          </tr>
        </table>
        
        
        
        
    </div>
    
    
   
    
    <!-- /.col --> 
  </div>
  <!-- /.row --> 
  
  <!-- /.content --> 
</div>

</td></tr></tbody></table>

 </td>
 
     </tr>
     <tr>
         <td>
             
                 <div style="width: 100%; display: block;font-family:Verdana,Arial,sans-serif;text-align: justify;">
          <span>
              
            

Buildermart.in's <a href="https://buildermart.in/page?name=term-services">Terms and Conditions</a> apply. All amounts are inclusive of GST where applicable. For return policy <a href="https://buildermart.in/page?name=refund-policy">click here</a>.

Please Note: This email was sent from a onlineorders address that can't accept incomming emails. Please do not reply to this message.
</span> 
        </div>
             
         </td>
         
     </tr>
     </tbody>
     </table>