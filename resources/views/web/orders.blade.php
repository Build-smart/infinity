@extends('web.layout')
@section('content')

<div class="container-fuild">
  <nav aria-label="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
            <li class="breadcrumb-item active" aria-current="page">@lang('website.My Orders')</li>
          </ol>
      </div>
    </nav>
</div> 

     <!--My Order Content -->
     <section class="order-one-content pro-content">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-3  d-none d-lg-block d-xl-block">
            <div class="heading">
                <h2>
                    @lang('website.My Account')
                </h2>
                <hr >
              </div>
            @if(Auth::guard('customer')->check())
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
                    <a class="nav-link" href="{{ URL::to('/logout')}}">
                        <i class="fas fa-power-off"></i>
                      @lang('website.Logout')
                    </a>
                </li>
              </ul>
              @elseif(!empty(session('guest_checkout')) and session('guest_checkout') == 1)
              <ul class="list-group">
                <li class="list-group-item">
                    <a class="nav-link" href="{{ URL::to('/orders')}}">
                        <i class="fas fa-shopping-cart"></i>
                      @lang('website.Orders')
                    </a>
                </li>
              </ul>
              @endif
          </div>
          <div class="col-12 col-lg-9 ">
              <div class="heading">
                  <h2>
                      @lang('website.My Orders')
                  </h2>
                  <hr >
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         {{ session()->get('message') }}
                    </div>

                @endif

<?php if(auth()->guard('customer')->user()->customer_type=="BUSINESSOWNER"){ ?>
              <table class="table order-table">

                <thead>
                  <tr class="d-flex">
                    <th class="col-12 col-md-2">@lang('website.Order ID')</th>
                    <th class="col-12 col-md-2">@lang('website.Order Date')</th>
                    <th class="col-12 col-md-2">@lang('website.Price')</th>
                    <th class="col-12 col-md-2">Cashback</th>
                    <th class="col-12 col-md-2" >@lang('website.Status')</th>
                    <th class="col-12 col-md-2" > Detail</th>

                  </tr>
                </thead>
                <tbody>
                  @if(count($result['orders']) > 0)
                  @foreach( $result['orders'] as $orders)
                  <tr class="d-flex">
                    <td class="col-12 col-md-2">{{$orders->orders_id}}</td>
                    <td class="col-12 col-md-2">
                      {{ date('d/m/Y', strtotime($orders->date_purchased))}}
                    </td>
                    <td class="col-12 col-md-2">
                      {{Session::get('symbol_left')}}{{$orders->order_price * session('currency_value') }}{{Session::get('symbol_right')}}
                    </td>
                    
                     <td class="col-12 col-md-2">
                      {{Session::get('symbol_left')}}{{$orders->cashback_amount * session('currency_value') }}{{Session::get('symbol_right')}}
                    </td>
                    <td class="col-12 col-md-2">
                        @if($orders->orders_status_id == '2')
                            <span class="badge badge-success">{{$orders->orders_status}}</span>
                         <!--   &nbsp;&nbsp;/&nbsp;&nbsp;

                            <form action="{   { URL::to('/updatestatus')}}" method="post" onSubmit="return returnOrder();" style="display: inline-block">
                            <input type="hidden" name="_token" id="csrf-token" value="{   { Session::token() }}" />
                            <input type="hidden" name="orders_id" value="{   {$orders->orders_id}}">
                            <input type="hidden" name="orders_status_id" value="4">
                            <button type="submit" class="badge badge-danger" style="text-transform:capitalize; cursor:pointer">{   {$orders->orders_status}}) </button>
                            </form    -->
                        @else
                          @if($orders->orders_status_id == '3')
                            <span class="badge badge-danger">{{$orders->orders_status}} </span>
                          @elseif($orders->orders_status_id == '4')
                            <span class="badge badge-danger">{{$orders->orders_status}} </span>
                            
                            
                            
                            	 <!--cancel button only displayed when it is place the order-->
						@elseif($orders->orders_status_id == '5')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '6')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						
						@elseif($orders->orders_status_id == '7')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '8')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '9')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '10')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
						
						 <!--cancel button only displayed when it is place the order-->
                            
                            
                            @else
                            <span class="badge badge-primary">{{$orders->orders_status}}</span>
                            &nbsp;&nbsp;/&nbsp;&nbsp;

                            <form action="{{ URL::to('/updatestatus')}}" method="post" onSubmit="return cancelOrder();" style="display: inline-block">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <input type="hidden" name="orders_id" value="{{$orders->orders_id}}">
                            <input type="hidden" name="orders_status_id" value="3">
                            <button type="submit" class="badge badge-danger" style="text-transform:capitalize; cursor:pointer">@lang('website.cancel order') </button>
                            </form>

                            @endif
                        @endif
                    </td>
                    <td align="right" class="col-12 col-md-2"><a href="{{ URL::to('/view-order/'.$orders->orders_id)}}">@lang('website.View Order')</a></td>
                  </tr>
                  @endforeach
                  @else
                      <tr>
                          <td colspan="4">@lang('website.No order is placed yet')
                          </td>
                      </tr>
                  @endif
                </tbody>
              </table>
              
              
                  <?php }else{ ?>
                  
                    <table class="table order-table">

                <thead>
                  <tr class="d-flex">
                    <th class="col-12 col-md-2">@lang('website.Order ID')</th>
                    <th class="col-12 col-md-2">@lang('website.Order Date')</th>
                    <th class="col-12 col-md-2">@lang('website.Price')</th>
                    <th class="col-12 col-md-2" >@lang('website.Status')</th>
                    <th class="col-12 col-md-2" > Detail</th>

                  </tr>
                </thead>
                <tbody>
                  @if(count($result['orders']) > 0)
                  @foreach( $result['orders'] as $orders)
                  <tr class="d-flex">
                    <td class="col-12 col-md-2">{{$orders->orders_id}}</td>
                    <td class="col-12 col-md-2">
                      {{ date('d/m/Y', strtotime($orders->date_purchased))}}
                    </td>
                    <td class="col-12 col-md-2">
                      {{Session::get('symbol_left')}}{{$orders->order_price * session('currency_value') }}{{Session::get('symbol_right')}}
                    </td>
                    
                     
                    <td class="col-12 col-md-2">
                        @if($orders->orders_status_id == '2')
                            <span class="badge badge-success">{{$orders->orders_status}}</span>
                          <!--  &nbsp;&nbsp;/&nbsp;&nbsp;

                            <form action="{  { URL::to('/updatestatus')}}" method="post" onSubmit="return returnOrder();" style="display: inline-block">
                            <input type="hidden" name="_token" id="csrf-token" value="  {   { Session::token() }}" />
                            <input type="hidden" name="orders_id" value="{  {$orders->orders_id}}">
                            <input type="hidden" name="orders_status_id" value="4">
                            <button type="submit" class="badge badge-danger" style="text-transform:capitalize; cursor:pointer">{  {$orders->orders_status}}) </button>
                            </form    -->
                        @else
                          @if($orders->orders_status_id == '3')
                            <span class="badge badge-danger">{{$orders->orders_status}} </span>
                          @elseif($orders->orders_status_id == '4')
                            <span class="badge badge-danger">{{$orders->orders_status}} </span>  
                            
                              <!--cancel button only displayed when it is place the order-->
						@elseif($orders->orders_status_id == '5')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '6')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						
						@elseif($orders->orders_status_id == '7')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '8')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '9')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
							
						@elseif($orders->orders_status_id == '10')
                            <span class="badge badge-info">{{$orders->orders_status}} </span>
						
						 <!--cancel button only displayed when it is place the order-->
                            
                            
                            @else
                            <span class="badge badge-primary">{{$orders->orders_status}}</span>
                            &nbsp;&nbsp;/&nbsp;&nbsp;

                            <form action="{{ URL::to('/updatestatus')}}" method="post" onSubmit="return cancelOrder();" style="display: inline-block">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <input type="hidden" name="orders_id" value="{{$orders->orders_id}}">
                            <input type="hidden" name="orders_status_id" value="3">
                            <button type="submit" class="badge badge-danger" style="text-transform:capitalize; cursor:pointer">@lang('website.cancel order') </button>
                            </form>

                            @endif
                        @endif
                    </td>
                    <td align="right" class="col-12 col-md-2"><a href="{{ URL::to('/view-order/'.$orders->orders_id)}}">@lang('website.View Order')</a></td>
                  </tr>
                  @endforeach
                  @else
                      <tr>
                          <td colspan="4">@lang('website.No order is placed yet')
                          </td>
                      </tr>
                  @endif
                </tbody>
              </table>
                
                 <?php } ?>
                 
                 
            <!-- ............the end..... -->
          </div>
        </div>
      </div>
    </section>

@endsection
