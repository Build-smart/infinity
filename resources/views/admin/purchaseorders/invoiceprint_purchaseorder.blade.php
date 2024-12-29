 <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('labels.OrderID') }}# {{ $data['orders_data'][0]->orders_id }}</title>

    <style type="text/css">
        * {
            font-family: 'Roboto', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }


        tfoot tr td {
            font-weight: bold;
        }

        .gray {
            background-color: lightgray
        }

        .information {
            background-color: #FFFFFF;
            color: black;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .tabletitle {
            padding: 5px;
            background: #EEE;
        }

        .service {
            border: 1px solid #EEE;
        }

        .item {
            width: 50%;
        }

        .itemtext {
            font-size: .9em;
        }

        .tabletitle {
            padding: 5px;
            background: #EEE;
        }

        p {
            font-size: .7em;
            color: #666;
            line-height: 1.2em;
        }
    </style>

</head>
<body onload="window.print();">

<div class="information" style="margin:20px;">
  
    <table width="100%" border="2" cellpadding="2">
         
        <tr>
              
            <td align="left" style="width: 100%;" colspan="5">
              @if($result['commonContent']['setting']['sitename_logo']=='logo')
            <img class="img-fluid" src="{{asset('').$result['commonContent']['setting']['website_logo']}}" height="50" alt="<?=stripslashes($result['commonContent']['setting']['website_name'])?>">
             @endif
             <br>
               @if($result['commonContent']['setting']['sitename_logo']=='logo')
      <strong>   Address: </strong>    <?=stripslashes($result['commonContent']['setting']['headquaters'])?>
            @endif
            <br>  <strong>   GST: </strong>          36AAJCB7149P1ZY
            </td>
            <td align="left" colspan="6">
                <h3> {{ trans('labels.CustomerInfo') }}: </h3>
                 
          <address>
            <strong>{{ $data['orders_data'][0]->customers_name }}</strong><br>
            {{ $data['orders_data'][0]->customers_street_address }} <br>
             {{ trans('labels.Phone') }}: {{ $data['orders_data'][0]->customers_telephone }}<br>
            {{ trans('labels.Email') }}: {{ $data['orders_data'][0]->email }}<br>
              GST: {{ $data['orders_data'][0]->gst }}
          </address>
                
                {{ trans('labels.OrderID') }}# {{ $data['orders_data'][0]->orders_id }}<br/>
                 {{ trans('labels.OrderedDate') }}: {{ date('m/d/Y', strtotime($data['orders_data'][0]->date_purchased)) }}

            </td>
            </tr>
            <tr>
            <td align="left" style="width: 100%;" colspan="5"> 
               <h4><b> {{ trans('labels.ShippingInfo') }}</b></h4>
            <address>
            <strong>{{ $data['orders_data'][0]->delivery_name }}</strong><br>
           
            {{ $data['orders_data'][0]->delivery_street_address }} <br>
             {{ trans('labels.Phone') }}: {{ $data['orders_data'][0]->delivery_phone }}<br>
           Alternate Phone: {{ $data['orders_data'][0]->delivery_alternate_phone }}<br>
            </address>
          </td>
            <td align="left" colspan="6"> 
         <h4> <b> {{ trans('labels.BillingInfo') }}</b> </h4>
          <address>
            <strong>{{ $data['orders_data'][0]->billing_name }}</strong><br>
         
            {{ $data['orders_data'][0]->billing_street_address }} <br>
               {{ trans('labels.Phone') }}: {{ $data['orders_data'][0]->billing_phone }}<br>
            Alternate Phone: {{ $data['orders_data'][0]->billing_alternate_phone }}<br>
           </address>
            </td>
        </tr>
  
    <tr class="tabletitle">
          
              <th>Item</th>
              <th>{{ trans('labels.Qty') }}</th>
             <th>HSN/SAC Code</th> 
              <th>MRP</th>
             <th>Discount %</th>
              <th>Net Price</th>
              <th>Variant {{ trans('labels.Price') }}</th>
              <th>Sub Total</th>
              <th>Taxes</th>
              <th>Tax Amount</th>
              <th>Total Amount</th>
   			 </tr>
    
    <tbody>
    @foreach($data['orders_data'][0]->data as $products)
            	
            <tr>
                 
                <td  width="20%">
                    {{  $products->products_name }}<br>
                </td>
                  <td>{{  $products->products_quantity }}</td>
                <td>
                    {{  $products->hsn_sac_code }}
                </td>
                
                
                 <td>
                
                 
                 @php
                 $products_details=DB::table('products')->where('products_id',$products->products_id)->first();
                 
                 $product_price=$products_details->products_price;
                 
                 @endphp
                  
                 {{$product_price}}
                   
                 </td>
                 
                   <td> 
                     {{  $products->distributor_product_price_percentage }} 
                 </td>
                 <td>{{$products->distributor_products_price}}</td>
                 <td>
                  @foreach($products->attribute as $attributes)
                  
                   @php     
                $prefix=  $attributes->price_prefix; 
                @endphp
               @if($attributes->distributor_options_values_price == 0)
                       @else   
                   
                   {{ $attributes->distributor_options_values_price }}   
                     @endif
                 @endforeach
                   </td>
              <td>{{ $products->distributor_final_price }}</td>
              
              <td>{{$products->product_tax_rate}} %</td>
              <td>{{ $products->products_tax }}</td>
             <td> 
                 {{ $products->distributor_final_price + $products->products_tax  }} 
                  </td>
           
                  </tr>
            @endforeach
    </tbody>
 
    <tfoot  >
    <tr>
        <td colspan="9"></td>
        <td align="right">Taxable Amount:</td>
        <td align="right">  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['subtotal'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                 </td>
    </tr>
 
     <tr>
        <td colspan="9"></td>
        <td align="right">SGST:</td>
        <td align="right">                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['sgst_amount'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif

                 </td>
    </tr>
    
     <tr>
        <td colspan="9"></td>
        <td align="right">CGST:</td>
        <td align="right">                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['cgst_amount'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif

                 </td>
    </tr>
  
<!--      <tr> -->
<!--         <td colspan="8"></td> -->
<!--         <td align="right">IGST:</td> -->
<!--         <td align="right">                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['igst_amount'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif -->

<!--                  </td> -->
<!--     </tr> -->
    
        @if(!empty($data['orders_data'][0]->coupon_code))
    <tr>
        <td colspan="9"></td>
        <td align="right">{{ trans('labels.DicountCoupon') }}:</td>
        <td align="right" class="gray">     @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->coupon_amount }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>

    </tr>
         @endif
    <tr>
        <td colspan="9"></td>
        <td align="right">{{ trans('labels.ShippingCost') }}:</td>
        <td align="right">                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->shipping_cost }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}}@endif
</td>
    </tr>
    
  
         
         <tr>
        <td colspan="9"><b>Amount In Words:</b></td>
        <td align="right">{{ trans('labels.Total') }}:</td>
        <td align="right">     @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif  {{ $data['orders_data'][0]->distributor_order_price + $data['total_purchase_tax'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>

</td>
    </tr>
    <tr>
    <td colspan="11">
   <?php
  
$number = $data['orders_data'][0]->distributor_order_price + $data['total_purchase_tax'];
   $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Fourty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  echo $result . "Rupees  " . $points . " .Paise";
 ?> 
    </td>
    </tr>
    <tr>
    <td colspan="11" align="right">
     <img src="{{asset('images/bmstamp.jpg')}}" width="100" height="100" alt="Image">
     <br>
    <b>Authorised Signatory</b>
    </td>
    </tr>
    </tfoot>
    
</table>

</div>

</body>
</html>
