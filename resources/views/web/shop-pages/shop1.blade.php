  <style>
 
.column {
  float: left;
  width: 33.33%;
  display: none;  
} 
 
.show {
  display: block;
}

 
.btns {
  border: none;
  outline: none;
  padding: 6px 8px;
  background-color: white;
  cursor: pointer;
}

.btns:hover {
  background-color: #7b9cbf;
}

.btns.active {
  background-color: #479af1;
  color: #ffffff;
}
</style>
 @if(!empty($result['promotional_banners']))
  <section class="carousel-content">
  <div class="container-fuild">
    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
     
    <div class="carousel-inner">
      
          <div class="carousel-item   active">
          
            <img class="d-block w-100"  src="{{asset('').$result['promotional_banners']->path}}"   alt="First slide">
           
          </div>
            
    </div>
 
  </div>
  </div>
</section>
@endif
 
  <!-- Shop Page One content -->
  <div class="container-fuild">
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
              @if(!empty($result['category_name']) and !empty($result['sub_category_name']))
              <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
              <li  class="breadcrumb-item"><a href="{{ URL::to('/shop')}}">@lang('website.Shop')</a></li>
             <li  class="breadcrumb-item"><a href="{{ URL::to('/shop?category='.$result['category_slug'])}}">{{$result['category_name']}}</a></li>
             <li  class="breadcrumb-item active">{{$result['sub_category_name']}}</li>
             @elseif(!empty($result['category_name']) and empty($result['sub_category_name']))
             <li class="breadcrumb-item active">{{$result['category_name']}}</li>
             @else
             <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
             <li class="breadcrumb-item active">@lang('website.Shop')</li>
             @endif
            </ol>
        </div>
      </nav>
  </div> 
 
      
    <section class="pro-content">
          
          
          <section class="shop-content shop-two">
                  
            <div class="container">
                <div class="row">
                  <div class="col-12 col-lg-3  d-lg-block d-xl-block right-menu"> 
                    <div class="right-menu-categories" style="text-transform: capitalize !important;">
                       @include('web.common.shopCategories')
                       @php    shopCategories(); @endphp 
                     </div>
  
              {{-- Hide filters if record does not exist --}}
              @if($result['products']['success']==1 ||  $result['products']['success']==0)
  
              @if(!empty($result['categories']))
             <form enctype="multipart/form-data" name="filters" id="test" method="get">
               <input type="hidden" name="min_price" id="min_price" value="0">
               <input type="hidden" name="max_price" id="max_price" value="{{$result['filters']['maxPrice']}}">
               @if(app('request')->input('category'))
                <input type="hidden" name="category" value="{{app('request')->input('category')}}">
               @endif
               @if(app('request')->input('filters_applied')==1)
               <input type="hidden" name="filters_applied" id="filters_applied" value="1">
               
                <input type="hidden" name="options" id="options" value="<?php echo implode(',',$result['filter_attribute']['options'])?>">
               <input type="hidden" name="options_value" id="options_value" value="<?php echo implode(',',$result['filter_attribute']['option_values'])?>">
      
               
                    @else
               <input type="hidden" name="filters_applied" id="filters_applied" value="0">
               @endif
               <div class="range-slider-main" >
                 <h2>@lang('website.Price Range') </h2>
                 <div class="wrapper">
                     <div class="range-slider">
                         <input onChange="getComboA(this)" name="price" type="text" class="js-range-slider" value="" />
                     </div>
                     <div class="extra-controls form-inline">
                       <div class="form-group">
                           <span>
                             @if(session('symbol_left') != null)
                             <font>{{session('symbol_left')}}</font>
                             @else
                             <font>{{session('symbol_right')}}</font>
                             @endif
                                 <input type="text"  class="js-input-from form-control" value="0" />
                           </span>
                               <font>-</font>
                               <span>
                                 @if(session('symbol_left') != null)
                                 <font>{{session('symbol_left')}}</font>
                                 @else
                                 <font>{{session('symbol_right')}}</font>
                                 @endif
                                   <input  type="text" class="js-input-to form-control" value="0" />
                                   <input  type="hidden" class="maximum_price" value="{{$result['filters']['maxPrice']}}">
                                   </span>
                     </div>
                       </div>
                 </div>
               </div>                       
               
               
               
               
            
               
               @include('web.common.scripts.slider')
                     @if(count($result['filters']['attr_data'])>0)
                     @foreach($result['filters']['attr_data'] as $key=>$attr_data)
                     <div class="color-range-main">
                       <h4  style="font-size: 0.875rem !important" @if(count($result['filters']['attr_data'])==$key+1) last @endif>{{$attr_data['option']['name']}}</h4>
                         <div class="block">
                                <div class="card-body">
                                 <ul class="list" style="list-style:none; padding: 0px;">
                                     @foreach($attr_data['values'] as $key=>$values)
                                     <li >
                                         <div class="form-check">
                                           <label class="form-check-label">
                                             <input class="form-check-input filters_box" name="{{$attr_data['option']['name']}}[]" type="checkbox" value="{{$values['value']}}" 								 									<?php
                                             if(!empty($result['filter_attribute']['option_values']) and in_array($values['value_id'],$result['filter_attribute']['option_values'])) print 'checked';
                                             ?>>
                                             {{$values['value']}}
                                           </label>
                                         </div>
                                     </li>
                                     @endforeach
                                 </ul>
                             </div>
                         </div>
  
                       </div>
                     @endforeach
                     @endif
                     
                     
                     
                       @if(!empty($result['manufacturers']) and count($result['manufacturers'])>0)
              <div class="range-slider-main">
                  <a class=" main-manu" data-toggle="collapse" href="#brands" role="button" aria-expanded="true" aria-controls="men-cloth">
                    @lang('website.Brands')   
                  </a>
                  <div class="sub-manu collapse show multi-collapse" id="brands">
                    
                    <ul class="unorder-list">
                        
                        <?php  
                        
                        //dd($result['brands']); 
                        
                        ?>
                      @foreach ($result['manufacturers'] as $item)
                      
                      
                      
                             <li >
                                         <div class="form-check">
                                           <label class="form-check-label"> <?php // dd( $result['brands']);
                                         
                                           ?>
                                             <input class="form-check-input filters_box" name="brands[]" type="checkbox" value="{{$item->manufacturers_id}}" 								 									
                                             <?php
                                           
                                           if(!empty($result['brands']) and in_array($item->manufacturers_id,$result['brands'])) print 'checked';
                                             ?>>
                                             {{$item->manufacturer_name}}
                                           </label>
                                         </div>
                                     </li>
                      
                      
                      <!--li class="list-item">
                        @if($item->manufacturers_url)
                         <a class="brands-btn list-item" href="{{url($item->manufacturers_url)}}" role="button"><i class="fas fa-angle-right"></i>{{$item->manufacturer_name}}</a>
                        @else
                        <a class="brands-btn list-item" href="#" role="button"><i class="fas fa-angle-right"></i>{{$item->manufacturer_name}}</a>
                        @endif
                    </li -->
                      @endforeach
                    </ul>    
                  </div> 
              </div> 
              @endif   
              
              
             @if(!empty($result['search']))
                  <input type="hidden" name="search" value="{{ $result['search'] }}">
                  @endif  

<!--              discount price -->

              <div class="range-slider-main">
                  <a class=" main-manu" data-toggle="collapse" href="#discount" role="button" aria-expanded="true" aria-controls="men-cloth">
                    Discount Price  
                  </a>
                  <div class="sub-manu collapse show multi-collapse" id="discount">
                   
                      <ul class="unorder-list">

                                                                 

       
  <li >
                                         <div class="form-check">
                                           <label class="form-check-label">
       <input class="form-check-input filters_box" name="one_ten_discounts" type="checkbox" value=""
       
                                           <?php
                                           
                                           if(!empty($result['one_ten_discounts'])) print 'checked';
                                             ?>
       > upto 10%
                                           </label>
                                         </div>
                                     </li>
                                      <li >
                                         <div class="form-check">
                                           <label class="form-check-label">
       <input class="form-check-input filters_box" name="ten_twenty_discounts" type="checkbox" value=""
       
                                           <?php
                                           
                                           if(!empty($result['ten_twenty_discounts'])) print 'checked';
                                             ?>
       > 10% - 20%
                                           </label>
                                         </div>
                                     </li>
                                      <li >
                                         <div class="form-check">
                                           <label class="form-check-label">
       <input class="form-check-input filters_box" name="twenty_thirty_discounts" type="checkbox" value=""
                                      <?php
                                           
                                           if(!empty($result['twenty_thirty_discounts'])) print 'checked';
                                             ?>
       > 20% - 30%
                                           </label>
                                         </div>
                                     </li>
                                      <li >
                                         <div class="form-check">
                                           <label class="form-check-label">
       <input class="form-check-input filters_box" name="thirty_fourty_discounts" type="checkbox" value=""
                                            <?php
                                           
                                           if(!empty($result['thirty_fourty_discounts'])) print 'checked';
                                             ?>
       
       >30% - 40%
                                           </label>
                                         </div>
                                     </li>
                                      <li >
                                         <div class="form-check">
                                           <label class="form-check-label">
       <input class="form-check-input filters_box" name="fourty_fifty_discounts" type="checkbox" value=""
                                       <?php
                                           
                                           if(!empty($result['fourty_fifty_discounts'])) print 'checked';
                                             ?> > 40% - 50% </label>
                                         </div>
                                     </li>
                                     
                                     
                                     

                 
                 </ul>
                 
                 
                  </div>
              </div>

                     
                     
                     <div class="color-range-main">
  
                     <div class="alret alert-danger" id="filter_required">
                     </div>
  
                     <div class="button">
                     <?php
                 $url = '';
                       if(isset($_REQUEST['category'])){
                   $url = "?category=".$_REQUEST['category'];
                   $sign = '&';
                 }else{
                   $sign = '?';
                 }
                 if(isset($_REQUEST['search'])){
                   $url.= $sign."search=".$_REQUEST['search'];
                 }
               ?>
                   <a href="{{ URL::to('/shop')}}" class="btn btn-dark" id="apply_options"> @lang('website.Reset') </a>
                      @if(app('request')->input('filters_applied')==1)
                   <button type="button" class="btn btn-secondary" id="apply_options_btn"> @lang('website.Apply')</button>
                     @else
                   <!--<button type="button" class="btn btn-secondary" id="apply_options_btn" disabled> @lang('website.Apply')</button>-->
                     <button type="button" class="btn btn-secondary" id="apply_options_btn" > @lang('website.Apply')</button>
                     @endif
                 </div>
               </div>
<!--                      @if(count($result['commonContent']['homeBanners'])>0) -->
<!--                       @foreach(($result['commonContent']['homeBanners']) as $homeBanners) -->
<!--                          @if($homeBanners->type==7) -->
<!--                          <div class="img-main"> -->
<!--                              <a href="{{ $homeBanners->banners_url}}" ><img class="img-fluid" src="{{asset('').$homeBanners->path}}"></a> -->
<!--                          </div> -->
<!--                        @endif -->
<!--                       @endforeach -->
<!--                      @endif -->
               </form>
               @endif
               @endif
                    
              
  
              </div>
                  <div class="col-12 col-lg-9">
<!--                   <div class="container" sty le="padding:20px;margin-bottom:20px;background-color: #ffffff;border:1px solid #eee ;box-shadow: 10px 5px 10px 5px #88888833;"> -->
<!--                   @if(!empty($result['category_name']) and !empty($result['sub_category_name'])) -->
<!--               <h1><b>{{$result['sub_category_name']}}</b></h1> -->
<!--                      @if($result['category_description'])  -->
<!--                         <h1>Description:</h1> -->
<!--                   <p>  {!! $result['category_description'] !!}</p> -->
<!--                    @endif -->
<!--              @elseif(!empty($result['category_name']) and empty($result['sub_category_name'])) -->
<!--             <br> <h1>{{$result['category_name']}}</h1> -->
                 
<!--                  @if($result['category_description']) -->
<!--                   <h1>Description:</h1> -->
<!--                   <p>  {!! $result['category_description'] !!}</p> -->
<!--                   @endif -->
<!--              @endif -->
                  
<!--                   </div> -->
                 
                  
                  <div id="myBtnContainer">
  <button class="btns active" onclick="filterSelection('all')"> Show all</button>
  <button class="btns" onclick="filterSelection('ECONOMY')"> ECONOMY</button>
  <button class="btns" onclick="filterSelection('STANDARD')"> STANDARD</button>
  <button class="btns" onclick="filterSelection('PREMIUM')"> PREMIUM</button>
</div>
                  
                    
                    
                      <div class="products-area">
                        <div class="top-bar">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-lg-6">
                                          <div class="block">
                                              <label>@lang('website.Display')</label>
                                              <div class="buttons">
                                                <a href="javascript:void(0);" id="grid"><i class="fas fa-th-large"></i></a>
                                                <a href="javascript:void(0);" id="list"><i class="fas fa-list"></i></a>
                                                </div>
                                          </div>
                                        </div> 
                                        <div class="col-12 col-lg-6">
                                          
  
                                          <form class="form-inline justify-content-end" id="load_products_form">
                                            <input type="hidden" value="1" name="page_number" id="page_number">
                                            @if(!empty(app('request')->input('search')))
                                             <input type="hidden"  name="search" value="{{ app('request')->input('search') }}">
                                            @endif
                                            @if(!empty(app('request')->input('category')))
                                             <input type="hidden"  name="category" value="@if(app('request')->input('category')!='all'){{ app('request')->input('category') }} @endif">
                                            @endif
                                             <input type="hidden"  name="load_products" value="1">
  
                                             <input type="hidden"  name="products_style" id="products_style" value="grid">
               
               
								        @if(!empty($result['max_price']))
                                             <input type="hidden"  name="max_price" value="{{ $result['max_price'] }}">
                                            @endif
               <!---  Start Of Discount input For Load More Button-->
                                          @if(!empty($result['one_ten_discounts']))
                                             <input type="hidden"  name="one_ten_discounts" value="">
                                            @endif

@if(!empty($result['ten_twenty_discounts']))
                                             <input type="hidden"  name="ten_twenty_discounts" value="">
                                            @endif

@if(!empty($result['twenty_thirty_discounts']))
                                             <input type="hidden"  name="twenty_thirty_discounts" value="">
                                            @endif
@if(!empty($result['thirty_fourty_discounts']))
                                             <input type="hidden"  name="thirty_fourty_discounts" value="">
                                            @endif
@if(!empty($result['fourty_fifty_discounts']))
                                             <input type="hidden"  name="fourty_fifty_discounts" value="">
                                            @endif  
<!---  End Of Discount input For Load More Button-->



<!---  Brands buttons-->
 @if(!empty($result['brands']))

   @foreach ($result['brands'] as $item)
   
  <input type="hidden"  name="brands[]" value="{{$item}}">
 
   @endforeach

@endif

                                            
                                            <div class="form-group">
                                                <label>@lang('website.Sort')</label>
                                                <div class="select-control">
                                                <select name="type" id="sortbytype" class="form-control">
                                                  <option value="desc" @if(app('request')->input('type')=='desc') selected @endif>@lang('website.Newest')</option>
                                                  <option value="atoz" @if(app('request')->input('type')=='atoz') selected @endif>@lang('website.A - Z')</option>
                                                  <option value="ztoa" @if(app('request')->input('type')=='ztoa') selected @endif>@lang('website.Z - A')</option>
                                                 
                                                 
                                                  <option value="ECONOMY" @if(app('request')->input('type')=='ECONOMY') selected @endif>ECONOMY</option>
                                                     <option value="STANDARD" @if(app('request')->input('type')=='STANDARD') selected @endif>STANDARD</option>
                                                     <option value="PREMIUM" @if(app('request')->input('type')=='PREMIUM') selected @endif>PREMIUM</option>
                                                 
                                                 
                                                  <option value="hightolow" @if(app('request')->input('type')=='hightolow') selected @endif>@lang('website.Price: High To Low')</option>
                                                  <option value="lowtohigh" @if(app('request')->input('type')=='lowtohigh') selected @endif>@lang('website.Price: Low To High')</option>
                                                  <option value="topseller" @if(app('request')->input('type')=='topseller') selected @endif>@lang('website.Top Seller')</option>
                                                  <option value="special" @if(app('request')->input('type')=='special') selected @endif>@lang('website.Special Products')</option>
                                                  <option value="mostliked" @if(app('request')->input('type')=='mostliked') selected @endif>@lang('website.Most Liked')</option>
                                                </select>
                                                </div>
                                              </div>
  
               
                                              
                                              <div class="form-group">
                                                <label>@lang('website.Limit')</label>
                                                <div class="select-control">
                                                  <select class="form-control"name="limit"id="sortbylimit">
                                                    <option value="15" @if(app('request')->input('limit')=='15') selected @endif>15</option>
                                                    <option value="30" @if(app('request')->input('limit')=='30') selected @endif>30</option>
                                                    <option value="60" @if(app('request')->input('limit')=='60') selected @endif>60</option>
                                                  </select>
                                                  </div>
                                                </div>
                      
                                                  @include('web.common.scripts.shop_page_load_products')
                                              </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div> 
                        
                        
                                            @if($result['products']['success']==1)

                        <section id="swap" class="shop-content" >
                              <div class="products-area">
                                  <div class="row">  
                                    
                                    @foreach($result['products']['product_data'] as $key=>$products)   
                                    <div class="col-12 col-lg-4 col-sm-6 column griding {{$products->product_segment}}">
                                      @include('web.common.product')
                                  </div>
                                    
                                      
                                    @endforeach
                                    @include('web.common.scripts.addToCompare')
                                      
                                  </div>
                              </div> 
                        </section>  
                      </div>
                      
  
                        <div class="pagination justify-content-between ">
                              <input id="record_limit" type="hidden" value="{{$result['limit']}}">
                              <input id="total_record" type="hidden" value="{{$result['products']['total_record']}}">
                              <label for="staticEmail" class="col-form-label"> @lang('website.Showing')&nbsp;<span class="showing_record">{{$result['limit']}}</span>&nbsp;@lang('website.of')&nbsp;<span class="showing_total_record">{{$result['products']['total_record']}}</span> &nbsp;@lang('website.results')</label>
                              
                            <div class=" justify-content-end col-6">
                              
                           <?php
                                    if(!empty(app('request')->input('limit'))){
                                        $record = app('request')->input('limit');
                                    }else{
                                        $record = '15';
                                    }
                                ?>
                                <button class="btn btn-dark" type="button" id="load_products"
                                @if(count($result['products']['product_data']) < $record )
                                    style="display:none"
                                @endif
                                >@lang('website.Load More')</button>
                            </div>
                    </div>
                    @else
                    <h3>@lang('website.No Record Found!')</h3>
                    @endif
                  </form>
  
                  </div>
              
                                
  
                  </div>
                </div>
          
            
        </section> 
        </section>  
    
  
  <script>
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>
  