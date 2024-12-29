<style>
.bordercats{
    width:50%;
     
     border-radius: 50%;
    /* box-shadow: 3px 9px 17px -6px rgb(0 0 0 / 75%); */
    /* -webkit-box-shadow: 3px 9px 17px -6px rgb(0 0 0 / 75%); */
    -moz-box-shadow: 3px 9px 17px -6px rgba(0,0,0,0.8);
    box-shadow: 3px 9px 17px -6px rgb(0 0 0 / 80%);
    -webkit-box-shadow: 3px 5px 10px -6px rgb(0 0 0 / 80%);
    -moz-box-shadow: 3px 7px 10px -6px rgba(0,0,0,0.80);
}
.text-center-cat{
margin-top:8px;
text-align:center;
}

</style>
 
<header id="headerMobile" class="header-area header-mobile d-lg-none d-xl-none">
  <div class="header-mini bg-top-bar"> 
      
    <div class="header-maxi bg-header-bar ">
      <div class="container">

        <div class="row align-items-center">
          <div class="col-2 pr-0">
              <div class="navigation-mobile-container">
                  <a href="javascript:void(0)" class="navigation-mobile-toggler">
                      <span class="fas fa-bars"></span>
                  </a>
                  <nav id="navigation-mobile">
                      
                      
                        
        
                      <div class="logout-main">
                          
                          
                          <div class="welcome">
                              
                              
                                <div class="col-12 col-sm-12 col-lg-2">
          <a href="{{ URL::to('/')}}" class="logo" data-toggle="tooltip" data-placement="bottom" title="@lang('website.logo')">
            @if($result['commonContent']['settings']['sitename_logo']=='name')
            <?=stripslashes($result['commonContent']['settings']['website_name'])?>
            @endif
       
            @if($result['commonContent']['settings']['sitename_logo']=='logo')
            <img class="img-fluid" src="{{asset('').$result['commonContent']['settings']['website_logo']}}" alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>">
            @endif
            </a>
        </div>
        
        
                            <span class="login-white"><?php if(auth()->guard('customer')->check()){ ?> {{auth()->guard('customer')->user()->first_name}}&nbsp;! <?php }?> </span>
                          </div>
                         
                      </div>

                      {!! $result['commonContent']["menusRecursiveMobile"] !!}
                     
                      <?php if(auth()->guard('customer')->check()){ ?>
                       <a href="{{url('profile')}}" class="main-manu btn btn-primary">@lang('website.Profile')</a>
                       <a href="{{url('wishlist')}}" class="main-manu btn btn-primary">@lang('website.Wishlist')<span class="total_wishlist"> ({{$result['commonContent']['total_wishlist']}})</span></a>
                       <a href="{{url('compare')}}" class="main-manu btn btn-primary">@lang('website.Compare')&nbsp;(<span id="compare">{{$count}}</span>)</a>
                       <a href="{{url('orders')}}" class="main-manu btn btn-primary">@lang('website.Orders')</a>
					   
					    <?php if(auth()->guard('customer')->user()->customer_type=="CLIENT"){ ?>
                   <a href="{{ URL::to('/wallet_history')}}" class="main-manu btn btn-primary">Wallet: {{Session::get('symbol_left')}}{{round($remainingwallet_amount,2)}} </a>  
              <?php }else{ ?>
                
                 <?php } ?>
      
	  
	  
      
       <?php if(auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER"){ ?>
                   <a href="{{url('widthdrawcashback')}}" class="main-manu btn btn-primary">@lang('CashBack:'){{$totalcashback_amount}}</a>  
                                       
              <?php }else{ ?>
                
                 <?php } ?>
      
                      
					   
                       <a href="{{url('shipping-address')}}" class="main-manu btn btn-primary">@lang('website.Shipping Address')</a>
					   
                       <a href="{{url('logout')}}" class="main-manu btn btn-primary">@lang('website.Logout')</a>
                      <?php }else{ ?>
                      
                         <a href="{{ URL::to('/login')}}" class="main-manu btn btn-primary"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;@lang('website.Login/Register')</a>
                       <?php } ?>
                  </nav>
              </div>

          </div>



          <div class="col-8">
            <a href="{{ URL::to('/')}}" class="logo">
              @if($result['commonContent']['settings']['sitename_logo']=='name')
              <?=stripslashes($result['commonContent']['settings']['website_name'])?>
              @endif

              @if($result['commonContent']['settings']['sitename_logo']=='logo')
              <img class="img-fluid"   src="{{asset('').$result['commonContent']['settings']['website_logo']}}" alt="<?=stripslashes($result['commonContent']['settings']['website_name'])?>">
              @endif
           </a>
          </div>

          <div class="col-2 pl-0">              
              <ul class="pro-header-right-options" id="resposive-header-cart">
                      <!--li >
    <a href="{  { URL::to('/wishlist')}}" class="btn" data-toggle="tooltip" data-placement="bottom" title="@lang('website.Wishlist')">
                <i   class="far fa-heart"></i>
                <span class="badge badge-secondary total_wishlist">{  {$result['commonContent']['total_wishlist']}}</span>
              </a>
            </li --->
                @include('web.headers.cartButtons.cartButton')
                
            
              </ul> 
          </div>
          </div>
        </div>
      </div>
    </div>
   
         
     <div class="header-navbar  bg-menu-bar">
      <div class="container">
        <form class="form-inline" action="{{ URL::to('/shop')}}" method="get">
		<div class="search">
            
             
		
                @if(count($locations) > 1)
                
                <div class="select-control"  name="category">
                  <select class="form-control" name="changeMobileLocation" id="changeMobileLocation"   >
                   @foreach($locations as $location)
                    <option value="{{$location->id}}"   @if(Session::get('location_id')==$location->id) selected @endif  >  {{$location->location_name}}</option>
                    @endforeach
                  </select>
                </div>
                @endif   
				
				
             <input  type="search" class="form-control" name="search" placeholder="@lang('website.Search entire store here')..."  value="{{ app('request')->input('search') }}">
            <button class="btn btn-secondary" type="submit">
            <i class="fa fa-search login-white"></i></button>
            </div>
         </form>
      </div>
    </div>
    
    
    
     
       
	@if(!empty($result['commonContent']['categories']))
<section class="categories-content">
    <div class="container">
        
   <div class="row bottom-margin-topcategories"> 
        
        @foreach($result['commonContent']['categories'] as $categories_data)
    
        <div class="col-4 col-md-6 col-sm-4 col-lg-2 cat-banner">
              
               <a href="{{ URL::to('/shop?category='.$categories_data->slug)}}">
                <img class="img-fluid bordercats" src="{{asset('').$categories_data->path}}" alt="{{$categories_data->name}}">
               </a>  
            
                  <h6 class="text-center-cat">{{$categories_data->name}}</h6>
                

          </div>
     @endforeach
     
   </div>
      
   </div>
  </section>
  @endif
               	    @include('web.common.scripts.changeLocation')

  	
</header>