<div class="container-fuild">
  <nav aria-label="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('website.Shopping cart')</li>
          </ol>
      </div>
    </nav>
</div>
<!-- start-->
<!-- start-->
<!-- start-->
<section class="pro-content">
  <div class="container">
    <div class="page-heading-title">
        <h2>@lang('website.Shopping cart')</h2>           
    </div>
  </div>

<section class=" cart-content">
      <div class="container">
      <div class="row">

      <div class="col-12 col-sm-12 cart-area cart-page-one">
        @if(session()->has('message'))
           <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           </div>
       @endif
       @if(session::get('out_of_stock') == 1)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
               This Product is out of stock.
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
      @endif
        <div class="row">

          <div class="col-12 col-lg-9">
            <form method='POST' id="update_cart_form" action='{{ URL::to('/updateCart')}}' >
            <table class="table top-table">
              <?php
                $price = 0;
               ?>
              @foreach( $result['cart'] as $products)
              <?php
              $price+= $products->final_price * $products->customers_basket_quantity;
              ?>
              <tbody  @if(session::get('out_of_stock') == 1 and session::get('out_of_stock_product') == $products->products_id)style="	box-shadow: 0 20px 50px rgba(0,0,0,.5); border:2px solid #FF9999;"@endif>

                  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                  <input type="hidden" name="cart[]" value="{{$products->customers_basket_id}}">

                  <tr class="d-flex">
                    <td class="col-12 col-md-3" >
                      <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}" class="cart-thumb">
                        <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}"/>
                        </a>
                    </td>
                      <td class="col-12 col-md-4 item-detail-left">
                        <div class="item-detail">
                            <span>
                              @foreach($products->categories as $key=>$category)
                                  {{$category->categories_name}}@if(++$key === count($products->categories)) @else, @endif
                              @endforeach 
                            </span>
                               <h4> @if($products->product_selected_name) 
                                                         {{$products->product_selected_name}}
                                                         
                                                         @else 
                                                          {{$products->products_name}}
                                                          @endif
                            </h4>
                            <div class="item-attributes">
                              @if(isset($products->attributes))
                              @foreach($products->attributes as $attributes)
                                <small>{{$attributes->attribute_name}} : {{$attributes->attribute_value}}</small>
                              @endforeach
                              @endif
                            </div>

                            <div class="item-controls">
                                <a href="{{ url('/editcart/'.$products->customers_basket_id.'/'.$products->products_slug)}}"  class="btn" >
                                  <span class="fas fa-pencil-alt"></span>
                                </a>

                                <a href="{{ URL::to('/deleteCart?id='.$products->customers_basket_id)}}"  class="btn" >
                                  <span class="fas fa-times"></span>
                              </a>
                            </div>                          
                          </div>                        

                      </td>
                      <?php
                      if(!empty($products->discount_price)){
                          $discount_price = $products->discount_price * session('currency_value');
                      }
                      if(!empty($products->final_price)){
                        $flash_price = $products->final_price * session('currency_value');
                      }
                      $orignal_price = $products->price * session('currency_value');


                       if(!empty($products->discount_price)){

                        if(($orignal_price+0)>0){
                          $discounted_price = $orignal_price-$discount_price;
                          $discount_percentage = $discounted_price/$orignal_price*100;
                       }else{
                         $discount_percentage = 0;
                         $discounted_price = 0;
                     }
                   }
                   ?>
                  <td class="item-price col-12 col-md-2">
                    @if(!empty($products->final_price))
                    {{Session::get('symbol_left')}}{{$flash_price+0}}{{Session::get('symbol_right')}}
                    @elseif(!empty($products->discount_price))
                    {{Session::get('symbol_left')}}{{$discount_price+0}}{{Session::get('symbol_right')}}
                    <span> {{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span>
                    @else
                    {{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}
                    @endif

                   </td>
                    <td class="col-12 col-md-2 Qty">       
                                       
                        <div class="input-group item-quantity">  
                                      <label><b><small>Can Enter Quantity Manually: </small></b></label>                        
<!--                             <input name="quantity[]" type="text" readonly value="{ {$products->customers_basket_quantity} }" class="form-control qty" min="{  {$products->min_order} }" max="{ {$products->max_order} }"> -->
                            <input name="quantity[]" type="text"   value="{{$products->customers_basket_quantity}}" class="form-control qty" min="{{$products->min_order}}" maxorder="{{$products->max_order}}">
                            <span class="input-group-btn ">
                                <button type="button" value="quantity"  class="quantity-right-plus btn qtypluscart update_cart" data-type="plus" data-field="">                                  
                                    <span class="fas fa-plus"></span>
                                </button>
                                <button type="button" value="quantity" class="quantity-left-minus btn qtyminuscart update_cart" data-type="minus" data-field="">
                                    <span class="fas fa-minus"></span>
                                </button>            
                            </span> 
                        </div>
                    </td>
                    <td class="align-middle item-total col-12 col-md-1" align="center">
                      <span class="cart_price_{{$products->customers_basket_id}}">
                        {{Session::get('symbol_left')}}{{$products->final_price * $products->customers_basket_quantity * session('currency_value')}}{{Session::get('symbol_right')}}
                        </span>
                    </td>
                  </tr>
              </tbody>
              @endforeach
            </table>
          </form>
            @if(!empty(session('coupon')))
              <div class="form-group">
                    @foreach(session('coupon') as $coupons_show)

                        <div class="alert alert-success">
                            <a href="{{ URL::to('/removeCoupon/'.$coupons_show->coupans_id)}}" class="close"><span aria-hidden="true">&times;</span></a>
                          @lang('website.Coupon Applied') {{$coupons_show->code}}.@lang('website.If you do note want to apply this coupon just click cross button of this alert.')
                        </div>

                    @endforeach
                </div>
            @endif
            <div class="col-12 col-lg-12 mb-4">
              <div class="row justify-content-between click-btn">
                <div class="col-12 col-lg-4">
                  <form id="apply_coupon" class="form-validate">
                    <div class="row">
                        <div class="input-group">
                            <input type="text" name="coupon_code" class="form-control" id="coupon_code" placeholder="Coupon Code" aria-label="Coupon Code" aria-describedby="coupon-code">

                            <div class="">
                              <button class="btn btn-secondary swipe-to-top" type="submit" id="coupon-code">@lang('website.APPLY')</button>
                            </div>
                        </div>
                        <div id="coupon_error" class="help-block" style="display: none;color:red;"></div>
                        <div  id="coupon_require_error" class="help-block" style="display: none;color:red;">@lang('website.Please enter a valid coupon code')</div>
                    </div>
                 </form>
                </div>
                <div class="col-12 col-lg-7 align-right">
                  <div class="row">
                    <a  href="{{ URL::to('/shop')}}" class="btn btn-secondary swipe-to-top">@lang('website.Back To Shopping')</a>
                    <button class="btn btn-light swipe-to-top" id="update_cart">@lang('website.Update Cart')</button>
                  </div>
               
                </div>
               
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3">
            <table class="table right-table">
              <thead>
                <tr>
                  <th scope="col" colspan="2" align="center">@lang('website.Order Summary')</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">@lang('website.SubTotal')</th>
                  <td align="right">
                    @php

                    if(!empty(session('coupon_discount'))){
                      $coupon_amount = session('currency_value') * session('coupon_discount');  
                    }else{
                      $coupon_amount = 0;
                    }

                    @endphp
                    {{Session::get('symbol_left')}}{{session('currency_value') * $price+0}}{{Session::get('symbol_right')}}
                  </td>
                </tr>
                <tr>
                  <th scope="row">@lang('website.Discount(Coupon)')</th>
                  <td align="right">{{Session::get('symbol_left')}}{{number_format((float)$coupon_amount, 2, '.', '')+0}}{{Session::get('symbol_right')}}</td>
                </tr>
                <tr class="item-price">
                  <th scope="row">@lang('website.Total')</th>
                  <td align="right" >{{Session::get('symbol_left')}}{{session('currency_value') * $price+0-number_format((float)$coupon_amount, 2, '.', '')}}{{Session::get('symbol_right')}}</td>
                </tr>
              </tbody>
            </table>
            <a href="{{ URL::to('/checkout')}}" class="btn btn-secondary m-btn col-12 swipe-to-top">@lang('website.proceedToCheckout')</a>
          </div>
        </div>
      </div>
    </div>

    </div>
  </section>
</section>

 

<script>  
$(document).ready(function () {  
  
	jQuery(document).on('click', '.update_cart', function(e){
 
		jQuery('#loader').css('display','block');
		jQuery("#update_cart_form").submit();
	});
	 


});  
</script>  





 


