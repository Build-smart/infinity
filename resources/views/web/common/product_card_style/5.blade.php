
 
<div class="product product5 ">
  <article>
   <div class="thumb">
     <div class="badges">
      <?php 
        $current_date = date("Y-m-d", strtotime("now"));

        $string = substr($products->products_date_added, 0, strpos($products->products_date_added, ' '));
        $date=date_create($string);
        date_add($date,date_interval_create_from_date_string($web_setting[20]->value." days"));
        $after_date = date_format($date,"Y-m-d");
        if($after_date>=$current_date){
          print '<span class="badge badge-info">';
          print __('website.New');
          print '</span>';
        }
        ?> 
          <?php
        if(!empty($products->discount_price)){
          $discount_price = $products->discount_price * session('currency_value');
        }
        $orignal_price = $products->products_price * session('currency_value');

        if(!empty($products->discount_price)){

        if(($orignal_price+0)>0){
          $discounted_price = $orignal_price-$discount_price;
          $discount_percentage = $discounted_price/$orignal_price*100;
        }else{
          $discount_percentage = 0;
          $discounted_price = 0;
        }
        ?>
      
        <span class="badge badge-danger"  data-toggle="tooltip" data-placement="bottom" title="<?php echo (int)$discount_percentage; ?>% @lang('website.off')"><?php echo (int)$discount_percentage; ?>%</span>
        <?php }?>
        
      
      @if($products->is_feature == 1)
        <span class="badge badge-success">@lang('website.Featured')</span>                                            
      @endif  
      
     </div>
     
     <ul class="product-action-vertical">
      <li>  
        <a href="javascript:void(0)" class="icon active swipe-to-top is_liked" products_id="<?=$products->products_id?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('website.Wishlist')">
          <i class="fas fa-heart"></i>
        </a>
      </li>
<li> 
<div class="icon swipe-to-top modal_show" products_id ="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Quick View')"> 
<i class="fas fa-eye"></i> 
</div>
 </li> 
   <li>
    <a onclick="myFunction3({{$products->products_id}})" class="btn-secondary icon swipe-to-top" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Compare')">
      <i class="fas fa-align-right" data-fa-transform="rotate-90"></i>
    </a>
    
   </li>
    
     </ul>

    <a href="{{ URL::to('/product-detail/'.$products->products_slug)}}"> <img class="img-fluid" src="{{asset('').$products->image_path}}" alt="{{$products->products_name}}"></a>
 
     
   </div>
   
   <div class="content text-center">
     <!--span class="tag">
      <!- ?php 
    
      $cat_name = '';
      foreach($products->categories as $key=>$category){
          $cat_name = $category->categories_name;
      }              
              
      echo $cat_name;
      ?   -->                              
     <!--/span -->
     
      <span class="tag">{{$products->products_model}}</span>
      
     <span class="title text-center"><a href="{{ URL::to('/product-detail/'.$products->products_slug)}}"   class="text-dark">{{$products->products_name}}</a></span>
     <p>
      <?php
      $descriptions = strip_tags($products->products_name);
      echo stripslashes($descriptions);
      ?>
     </p>
     <div class="price">                     
        @if(!empty($products->discount_price))
          {{Session::get('symbol_left')}}&nbsp;{{$discount_price+0}}&nbsp;{{Session::get('symbol_right')}} / <b class="text-dark"> &nbsp;&nbsp;{{$products->products_weight_unit}}</b>
        <span> {{Session::get('symbol_left')}}{{$orignal_price+0}}{{Session::get('symbol_right')}}</span>
        @else
          {{Session::get('symbol_left')}}&nbsp;{{$orignal_price+0}}&nbsp;{{Session::get('symbol_right')}} / <b class="text-dark"> &nbsp;&nbsp;{{$products->products_weight_unit}}</b>
        @endif                         
     </div>  
     
          <div class="price">
     + GST T&C Apply  
     </div>
     
          @if($products->assured_by=="BM")
      <img src="{{asset('images/bmassured.png')}}" width="150" alt="BM Assured"> 
@endif
      
<!--
      @if($products->products_type==0)
          @if(!in_array($products->products_id,$result['cartArray']))
              @if($products->defaultStock==0)

                  <button type="button" class="btn btn-danger swipe-to-top" products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Out of Stock')"><i class="fas fa-shopping-bag"></i> @lang('website.Out of Stock')</button>
              @elseif($products->products_min_order>1)
              <a class="btn btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.View Detail')"><i class="fas fa-shopping-bag"></i> @lang('website.View Detail')</a>
              @else
                  <button type="button" class="btn btn-secondary cart swipe-to-top" products_id="{{$products->products_id}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Add to Cart')"><i class="fas fa-shopping-bag"></i> @lang('website.Add to Cart')</button>
              @endif
          @else
              <button type="button" class="btn btn-secondary active swipe-to-top" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Added')"><i class="fas fa-shopping-bag"></i> @lang('website.Added')</button>
          @endif
      @elseif($products->products_type==1)
          <a class="btn btn-secondary swipe-to-top" href="{{ URL::to('/product-detail/'.$products->products_slug)}}" data-toggle="tooltip" data-placement="bottom" title="@lang('website.View Detail')"><i class="fas fa-shopping-bag"></i> @lang('website.View Detail')</a>
      @elseif($products->products_type==2)
          <a href="{{$products->products_url}} swipe-to-top" target="_blank" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="@lang('website.External Link')"><i class="fas fa-shopping-bag"></i>@lang('website.External Link')</a>
      @endif
      
      -->
      
   </div>                 


  </article>
</div>