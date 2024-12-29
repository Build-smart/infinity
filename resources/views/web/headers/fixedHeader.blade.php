    @include('web.common.scripts.changeLocation')
        <header id="stickyHeader" class="header-area header-sticky d-none">
          <div class="header-sticky-inner  bg-sticky-bar">
            <div class="container">
    
                <div class="row align-items-center">
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
       
        <div class="col-12 col-sm-7 col-md-4 col-lg-2">
        <header id="headerSix" class="header-area header-six header-desktop d-none d-lg-block d-xl-block">
        
         <div class="header-mini">  
         
     
          <nav id="navbar_0_6" class="navbar navbar-expand-md navbar-dark navbar-0">
        <div class="navbar-lang">              
               
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" style="text-transform: capitalize;" >
                 @if(session('location_name')=="")
                 {{$default_locations->location_name}}
               
                 @else
                 {{session('location_name')}}
                 @endif
                    </button>
                    <div class="dropdown-menu" >
                     
                     
                       @if(count($locations) > 1)
               
                 
                    <span style="color: #ffffff;">
                      <ul>
                        @foreach($locations as $location)
                           <li class="dropdown-item changeLocation" data-id="{{$location->id}}">{{$location->location_name}}</li>
                        @endforeach
                      </ul>
                    </span>
                 
             
              
                @endif                  
                                     
                    </div>
                </div>
             
                 
        </div>
       
        </nav>
        </div>
       </header>
        </div>
       
        <div class="col-12 col-sm-7 col-md-4 col-lg-4">      
         
         
          <form class="form-inline" action="{{ URL::to('/shop')}}" method="get">  
             
             
              @if(!empty(app('request')->input('search')))
                           <input  type="search" class="form-control" name="search" placeholder="@lang('website.Search entire store here')..." data-toggle="tooltip" data-placement="bottom" title="@lang('website.Search Products')" value="{{app('request')->input('search')}}">

                             @else
                           <input  type="search" class="form-control" name="search" placeholder="@lang('website.Search entire store here')..." data-toggle="tooltip" data-placement="bottom" title="@lang('website.Search Products')" value="">

                             @endif
                             
                             
                   <button class="btn btn-secondary swipe-to-top" data-toggle="tooltip"
                  data-placement="bottom" title="@lang('website.Search Products')">
                  <i class="fa fa-search login-white"></i></button>
               
          </form>
        </div>
        <div class="col-6 col-sm-6 col-md-2 col-lg-3">
         <?php if(auth()->guard('customer')->check()){ ?>
         <header id="headerSix" class="header-area header-six header-desktop d-none d-lg-block d-xl-block">
         
        <div class="header-mini">  
         
     
          <nav id="navbar_0_6" class="navbar navbar-expand-md navbar-dark navbar-0">
        <div class="navbar-lang">              
               
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" >
                   {{auth()->guard('customer')->user()->first_name}} 
                    </button>
                    <div class="dropdown-menu" >
                     
                    <span style="color: #ffffff;">
                      <ul>
                  <li> <a href="{{url('profile')}}" class="dropdown-item">@lang('website.Profile')</a> </li>
                  <li> <a href="{{url('wishlist')}}" class="dropdown-item">@lang('website.Wishlist')<span class="total_wishlist"> ({{$result['commonContent']['total_wishlist']}})</span></a> </li>
                  <li> <a href="{{url('compare')}}" class="dropdown-item">@lang('website.Compare')&nbsp;(<span id="compare">{{$count}}</span>)</a> </li>
                  <li> <a href="{{url('orders')}}" class="dropdown-item">@lang('website.Orders')</a> </li>
				  
				  
				  
				  
				      
       <?php if(auth()->guard('customer')->user()->customer_type=="CLIENT"){ ?>
                  <li> <a href="{{url('/wallet_history')}}" class="dropdown-item">Wallet: {{Session::get('symbol_left')}}{{round($remainingwallet_amount,2)}} </a> </li>
              <?php }else{ ?>
                
                 <?php } ?>
      
      
       <?php if(auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER"){ ?>
                  <li> <a href="{{url('widthdrawcashback')}}" class="dropdown-item">@lang('CashBack:') {{Session::get('symbol_left')}}{{$totalcashback_amount}}</a> </li>
                                      
              <?php }else{ ?>
                
                 <?php } ?>
				  
				  
                   <li> <a href="{{url('shipping-address')}}" class="dropdown-item">@lang('website.Shipping Address')</a> </li>
                  <li> <a href="{{url('logout')}}" class="dropdown-item">@lang('website.Logout')</a> </li>
                      </ul>
                    </span>
                  </div>
                </div>
             
                 
        </div>
        </nav>
        </div>
        </header>
           <?php }else{ ?>
               <ul class="navbar-nav">          
  <li class="nav-item"> <a href="{{ URL::to('/login')}}" class="nav-link -before login-white"><i class="fa fa-lock login-white" aria-hidden="true" ></i>&nbsp;Login</a> </li>                      
                </ul>
                <?php } ?>
                
                
                
             
        </div>
       
         
       
        <div class="col-6 col-sm-6 col-md-2 col-lg-1">
           <ul class="pro-header-right-options">  
           
<?php if(auth()->guard('customer')->check() && auth()->guard('customer')->user()->customer_type=="CLIENT"){ ?>
        
                  <li> <a href="{{ URL::to('/wallet_history')}}" class="nav-link -before login-white">Wallet&nbsp; {{Session::get('symbol_left')}}{{$remainingwallet_amount}} </a> </li>
              <?php } ?>  
              
              <?php if(auth()->guard('customer')->check() && auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER"){ ?>
        
        
                  <li> <a href="{{ URL::to('/widthdrawcashback')}}" class="nav-link -before login-white">CashBack&nbsp; {{Session::get('symbol_left')}}{{$totalcashback_amount}} </a> </li>
              <?php } ?>  
               
            <li class="dropdown head-cart-content">
              @include('web.headers.cartButtons.cartButton6')
            </li>
          </ul>
        </div>
      </div>
            </div>
          </div> 
		
        </header>
