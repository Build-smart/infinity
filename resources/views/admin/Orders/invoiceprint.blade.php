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

<div class="information" style="margin:30px;">
  
    <table width="100%"  border="2" cellpadding="2">
         
        <tr>
              
            <td align="left" colspan="5" >
              <b style="font-size: 30px;">Tax Invoice</b> <br>
             Invoice No:  # {{ $data['orders_data'][0]->orders_id }}<br>
              <b style="font-size: 15px;"> BMLED & BUILDER MART INDIA PVT LTD </b><br>
           <strong> GSTIN:</strong> 36AAJCB7149P1ZY32 <br>
           
               @if($result['commonContent']['setting']['sitename_logo']=='logo')
        <strong>   Address: </strong>    <?=stripslashes($result['commonContent']['setting']['headquaters'])?>
            @endif
            <br>  
             <strong> Phone: </strong> 040-35629825<br>
             <strong> Email: </strong> sales@buildermart.in
            </td>
            <td align="left" colspan="5" >
            
             @if($result['commonContent']['setting']['sitename_logo']=='logo')
            <img class="img-fluid" src="{{asset('').$result['commonContent']['setting']['website_logo']}}" height="50" alt="<?=stripslashes($result['commonContent']['setting']['website_name'])?>">
             @endif

            </td>
            </tr>
            <tr>
            <th align="left"  colspan="5" >Invoice Date: {{ date('m/d/Y', strtotime($data['orders_data'][0]->date_purchased)) }}</th>
            <th align="left" colspan="5"  >Place of Supply: India, Telangana </th>
            </tr>
            <tr>
            <th align="left" colspan="5"  >Bill To</th>
            <th align="left" colspan="5"  >Ship to </th>
            </tr>
            
            <tr>
            <td align="left" colspan="5"  > 
              
            <address>
            <strong>{{ $data['orders_data'][0]->delivery_name }}</strong><br>
            
            {{ $data['orders_data'][0]->delivery_street_address }} <br>
            {{ $data['orders_data'][0]->delivery_city }}, {{ $data['orders_data'][0]->delivery_state }} {{ $data['orders_data'][0]->delivery_postcode }}, {{ $data['orders_data'][0]->delivery_country }}<br>
           {{ trans('labels.Phone') }}: {{ $data['orders_data'][0]->delivery_phone }}<br>
           Alternate Phone: {{ $data['orders_data'][0]->delivery_alternate_phone }}<br>
            
          </address>
          </td>
            <td align="left" colspan="5" > 
        
          <address>
            <strong>{{ $data['orders_data'][0]->billing_name }}</strong><br>
           
            {{ $data['orders_data'][0]->billing_street_address }} <br>
            {{ $data['orders_data'][0]->billing_city }}, {{ $data['orders_data'][0]->billing_state }} {{ $data['orders_data'][0]->billing_postcode }}, {{ $data['orders_data'][0]->billing_country }}<br>
         {{ trans('labels.Phone') }}: {{ $data['orders_data'][0]->billing_phone }}<br>
            Alternate Phone: {{ $data['orders_data'][0]->billing_alternate_phone }}<br>
          </address>
            </td>
        </tr>

    
    <tr class="tabletitle">
         
              <th>Item</th> 
               <th>{{ trans('labels.Qty') }}</th> 
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>Discount</th>
              <th>Net Price</th>
              <th>Sub Total</th>
              <th>Taxes</th>
              <th>Tax Amount</th>
              <th>Total Amount</th>
    </tr>
   
     @php $total_qty=0; @endphp
    @foreach($data['orders_data'][0]->data as $products)
            	
            <tr>
                
                <td>
                    {{  $products->products_name }}<br>
                </td>
                <td>
                @php $total_qty=$total_qty+$products->products_quantity   @endphp
                {{  $products->products_quantity }}</td> 
                 <td>
                    {{  $products->hsn_sac_code }}
                </td>
                @php $total_variant_price=0; @endphp   
                <td>  @foreach($products->attribute as $attributes)
               @php     
                $prefix=  $attributes->price_prefix; 
                @endphp 
                @if($prefix=="+")
@php $total_variant_price= $total_variant_price+$attributes->options_values_price;    @endphp
@else

 @php $total_variant_price=$total_variant_price- $attributes->options_values_price;  @endphp

@endif
         @endforeach
               
                  @php $mrpprice= $products->products_price+$total_variant_price;  @endphp
                   
                  {{$mrpprice}}
                  </td>
                <td>@php
                 $discounted_price = $mrpprice-$products->cart_product_price;
                $discount_percentage = $discounted_price/$mrpprice*100;
                 $discount_percent = round($discount_percentage, 2);
                      
                @endphp
                  
                {{ $discount_percent }} %
               
                </td>
              <td>{{ $products->cart_product_price }}</td>
              <td>{{ $products->cart_product_price * $products->products_quantity}}</td>
              <td>{{ $products->product_tax_rate }} %</td>
              <td>{{ $products->products_tax }}</td>
              <td>{{ ($products->cart_product_price * $products->products_quantity) + $products->products_tax}} </td>
             </tr>
            @endforeach
            
            <tr>
            <th>Total</th>
            <th>{{$total_qty}}</th>
            <th colspan="8"></th>
            </tr>
            
    
    <tr>
        <td colspan="8"></td>
        <td align="right">Taxable Amount:</td>
        <td align="right">                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['subtotal'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif

                 </td>
    </tr>
    @if($data['orders_data'][0]->billing_state == "TS")
     <tr>
        <td colspan="8"></td>
        <td align="right">SGST:</td>
        <td align="right">                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['sgst_amount'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif

                 </td>
    </tr>
    
     <tr>
        <td colspan="8"></td>
        <td align="right">CGST:</td>
        <td align="right">                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['cgst_amount'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif

                 </td>
    </tr>
    @else
     <tr>
        <td colspan="8"></td>
        <td align="right">IGST:</td>
        <td align="right">                    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['igst_amount'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif

                 </td>
    </tr>
    @endif
         @if(!empty($data['orders_data'][0]->coupon_code))
    <tr>
        <td colspan="8"></td>
        <td align="right">{{ trans('labels.DicountCoupon') }}:</td>
        <td align="right" class="gray">    @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->coupon_amount }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
            </td>
    </tr>
         @endif
    <tr>
        <td colspan="8">Amount In Words:</td>
        <td align="right">{{ trans('labels.ShippingCost') }}:</td>
        <td align="right">     @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->shipping_cost }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}}@endif
                </td>
    </tr>
    
   
         
         <tr>
        <td colspan="8"> <?php
  
$number = $data['orders_data'][0]->order_price;
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
 ?> </td>
        <td align="right">{{ trans('labels.Total') }}:</td>
        <td align="right">       @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->order_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                
    </tr>
     
    <tr>
        <td colspan="10">Bank Details:<br>
        Receiver: BMLED & BUILDER MART INDIA PRIVATE LIMITED<br>
        Account No.: 921020019395087<br>
        Currency : INR<br>
        Bank Name : Axis Bank<br>
        IFSC : UTIB0003063<br>
        </td>
        
    </tr>
    
    <tr>
        <td colspan="10">Terms & Conditions
        <ol>
        <li>Taxes (GST &amp; Others) as shown above</li>
        <li>Transport Charges Extra</li> 
        </ol>
        
        </td> 
    </tr>
     <tr>
   
        <td colspan="10">We Declare that this invoice shows the actual price of the Goods described and all the particulars are true and correct</td> 
    </tr>
    <tr>
    <td colspan="5" align="left" color="gray">
    <br><br><br><br><br><br>
    <b> Receivers Signatory</b>
    </td>
    <td colspan="5" align="right" color="gray">
    <img src="{{asset('images/bmstamp.jpg')}}" width="100" height="100" alt="Image">
     <br>
    <b>Authorised Signatory</b>
    </td>
    </tr>
    
     
    
</table>

</div>

</body>
</html>
