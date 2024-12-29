@extends('web.layout')
@section('content')

<div class="container-fuild">
  <nav aria-label="breadcrumb">
      <div class="container">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
            <li class="breadcrumb-item active" aria-current="page">Wallet History</li>
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
                
                 <li class="list-group-item">
                    <a class="nav-link" href="{{ URL::to('/wallet_history')}}">
                        <i class="fas fa-shopping-cart"></i>
                     Wallet Amount  :   {{round($result['remainingwallet_amount'],2)}}
                    </a>
                </li>
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
                     Available Wallet Amount: {{$result['remainingwallet_amount']}}
                  </h2>
                  <hr >
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         {{ session()->get('message') }}
                    </div>

                @endif

               <table class="table order-table">

                <thead>
                  <tr class="d-flex">
                    <th class="col-12 col-md-4">SL No.</th>
                    <th class="col-12 col-md-4">Amount</th>
                    <th class="col-12 col-md-4">Added Date</th>
                    

                  </tr>
                </thead>
                <tbody>
                  @if(count($result['wallets']) > 0)
                  @foreach( $result['wallets'] as $wallet)
                  <tr class="d-flex">
                    <td class="col-12 col-md-4">{{$loop->iteration}}</td>
                    <td class="col-12 col-md-4">   {{  $wallet->wallet_amount }}  </td>
                    <td class="col-12 col-md-4"> {{  $wallet->added_date }}  </td>
                    
                    
                     
                   </tr>
                  @endforeach
                  @else
                      <tr>
                          <td colspan="4">No Wallet History
                          </td>
                      </tr>
                  @endif
                </tbody>
              </table>
              
              
                  
                 
                 
            <!-- ............the end..... -->
          </div>
        </div>
      </div>
    </section>

@endsection
