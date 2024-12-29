@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Distributor Wallet <small>Distributor Wallet...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">Distributor Wallet</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                         

                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Order ID & Purchase Order Id</th>
                                           <th>Distributor Id</th>
                                            <th>Distributor Name</th> 
                                             <th>Purchase Order Amount</th>
                                             <th>Purchase Tax Amount</th> 
                                            <th>Purchase Order Total Amount</th>
                                             
                                              <th>RoundUp Amount </th>
                                              <th>Payment Details</th>
                                              <th>Requested By Distributor</th>
                                              <th>Requested Date</th>
                                              <th> Status</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                 <tr>
                                                    <td> Order ID : {{ $result['distributorwallet']->orders_id }} Purchase Order ID {{ $result['distributorwallet']->purchase_orders_id }}</td>
                                                    <td>{{ $result['distributorwallet']->distributor_id }}</td>
                                                     <td>{{ $result['distributorwallet']->customers_name }}</td>
                                                   
                                                       
                                                    <td>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $result['distributorwallet']->distributor_order_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                    <td>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $result['distributorwallet']->total_tax }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                    
                                                   <td>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $result['distributorwallet']->distributor_order_price + $result['distributorwallet']->total_tax  }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                     
                                                   
                                                     <td>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $result['distributorwallet']->roundup_purchaseorder_amount }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                     <td>{{ $result['distributorwallet']->payment_transaction_details }}</td>
                                                     <td>
                                                     
                                                     @if($result['distributorwallet']->request_by_distributor==1)
                                                     YES
                                                     @else
                                                     NO
                                                     @endif
                                                      <td>{{ $result['distributorwallet']->request_date }}</td>
                                                   
                                                      <td>
                                                       
                                                     @if($result['distributorwallet']->is_paid==1)
                                                     PAID
                                                     @else
                                                     PENDING
                                                     @endif
                                                      
                                                      </td>
                                                    <td>  
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit Distributor Wallet" href="editdistributorwallet/{{ $result['distributorwallet']->purchase_orders_id }}" class="badge bg-light-blue"><i class="fa fa-pencil" aria-hidden="true"></i></a>
 
                                                    </td>

                                                </tr>
                                           
                                             
                                       
                                        </tbody>
                                    </table>
 
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            
            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
