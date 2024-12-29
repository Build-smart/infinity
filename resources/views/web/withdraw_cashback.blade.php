@extends('web.layout')
@section('content')

<div class="container-fuild">
  <nav aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
        <li class="breadcrumb-item active" aria-current="page">Withdraw CashBack</li>

      </ol>
    </div>
  </nav>
</div> 
<section class="pro-content">
<!-- Profile Content -->
<section class="profile-content">
  <div class="container">
    <div class="row">

      <div class="col-12 media-main">
        <div class="media">
          <h3>{{ substr(auth()->guard('customer')->user()->first_name, 0, 1)}}</h3>
            <div class="media-body">
              <div class="row">
                <div class="col-12 col-sm-4 col-md-6">
                  <h4>{{auth()->guard('customer')->user()->first_name}} {{auth()->guard('customer')->user()->last_name}}<br>
                  <small>@lang('website.Phone'): {{ auth()->guard('customer')->user()->phone }} </small></h4>
                </div>
                <div class="col-12 col-sm-8 col-md-6 detail">                  
                  <p class="mb-0">@lang('website.E-mail'):<span>{{auth()->guard('customer')->user()->email}}</span></p>
                </div>
                </div>
            </div>
            
        </div>
    </div>

       <div class="col-12 col-lg-3">
           <div class="heading">
               <h2>
                   @lang('website.My Account')
               </h2>
               <hr >
             </div>

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
                   <a class="nav-link" href="{{ URL::to('/widthdrawcashback')}}">
                       <i class="fas fa-map-marker-alt"></i>
                   CashBack : {{$result['totalcashback_amount']}}
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
               <li class="list-group-item">
                   <a class="nav-link" href="{{ URL::to('/change-password')}}">
                       <i class="fas fa-unlock-alt"></i>
                     @lang('website.Change Password')
                   </a>
               </li>
             </ul>
       </div>
       <div class="col-12 col-lg-9 ">
           <div class="heading">
               <h2>
                 Available CashBack : {{$result['totalcashback_amount']}}
               </h2>
               <hr >
             </div>
             <form name="WidthdrawCashbackrequest" class="align-items-center form-validate" enctype="multipart/form-data" action="{{ URL::to('WidthdrawCashbackrequest')}}" method="post">
               @csrf
                

                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
 
                @if(session()->has('success') )
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                 <div class="form-group row">
                   <label for="firstName" class="col-sm-3 col-form-label">Withdraw CashBack Amount</label>
                   <div class="col-sm-5">
                     <input type="text" required name="request_amount" class="form-control field-validate" id="inputName"   placeholder="Enter Amount">
                   </div>
                 
                 <div class="col-sm-2">
                <button type="submit" class="btn btn-secondary swipe-to-top">Submit</button>
                </div>
                 </div>
                  
 
             </form>

         <!-- ............the end..... -->
              @if(count($result['widthdraws']) > 0)
         <table class="table order-table">

                <thead>
                
                <tr class="d-flex">
                    <th class="col-12 col-md-12">Withdraw Transctions</th>
                   
                  </tr>
                  <tr class="d-flex">
                   <th class="col-12 col-md-3">ID</th>
                    <th class="col-12 col-md-3">Amount</th>
                    <th class="col-12 col-md-3">Date</th>
                    <th class="col-12 col-md-3">Status</th>
                     
                  </tr>
                </thead>
                 <tbody>
              
                  @foreach( $result['widthdraws'] as $widthdraw)
                  <tr class="d-flex">
                    <td class="col-12 col-md-3">{{$loop->iteration}}</td>
                    <td class="col-12 col-md-3">
                    {{Session::get('symbol_right')}}  {{ $widthdraw->request_amount * session('currency_value') }}{{Session::get('symbol_right')}}
                    </td>
                    <td class="col-12 col-md-3">
                      {{ $widthdraw->request_date }}
                    </td>
                       <td class="col-12 col-md-3">
                      {{ $widthdraw->status  }}
                    </td>
                  </tr>
                  @endforeach
                  
                 
                </tbody>
              </table>
               @endif
       </div>
       
       
       
     </div>
    </div>
  </section>
</div>
 </section>
 @endsection
