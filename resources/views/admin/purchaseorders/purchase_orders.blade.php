@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Purchase {{ trans('labels.Orders') }} <small>{{ trans('labels.ListingAllOrders') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">Purchase {{ trans('labels.Orders') }}</li>
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
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('orders_id', "Purchase Order Id" )</th>
                                             <th>@sortablelink('customers_name', "Distributor Name" )</th> 
                                             <th>Subtotal</th>
                                             <th>Tax</th> 
                                            <th>{{ trans('labels.OrderTotal') }}</th>
                                            <th>Round Up Amount</th>
                                            <th>Discount Amount</th>
                                            
                                            <th>Payable Amount</th>
                                            
                                             <th>Add To Wallet Date</th>
                                              <th>{{ trans('labels.Status') }} </th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($listingOrders['purchase_orders'])>0)
                                            @foreach ($listingOrders['purchase_orders'] as $key=>$purchaseorderData)
                                                <tr @if($purchaseorderData->obsolete_purchase_order == 1) style="background-color:#ff3636" @endif >
                                                    <td> Order ID : {{ $purchaseorderData->orders_id }} Purchase Order ID {{ $purchaseorderData->purchase_orders_id }}</td>
                                                      <td>{{ $purchaseorderData->customers_name }}</td>
                                                   
                                                       
                                                    <td>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $purchaseorderData->distributor_order_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                    <td>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $purchaseorderData->total_tax }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                    
                                                   <td>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $purchaseorderData->distributor_order_price+$purchaseorderData->total_tax }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                     <th>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $purchaseorderData->roundup_purchaseorder_amount }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</th>
                                            <th>   
                                             @if($purchaseorderData->cashdiscount_purchaseorder_amount == 0)
                                                 No Discount
                                            @else
                                            
                                            Rs. {{$purchaseorderData->cashdiscount_purchaseorder_amount}}
                                              
                                             @if($purchaseorderData->is_discount == 0 )
                                                 
                                            <select name="is_discount" id="is_discount_{{$purchaseorderData->purchase_orders_id}}" class="form-control">
                                             <option value="1">Accept</option>
                                             <option value="0">Reject</option>
                                            </select>
                                            <input type="hidden" id="purchase_orders_id_{{$purchaseorderData->purchase_orders_id}}" value="{{$purchaseorderData->purchase_orders_id}}">
                                                   
                                           <button data-id="{{ $purchaseorderData->purchase_orders_id }}" class="btn btn-primary btn-xs discount">submit</button>
                        <strong id="disocuntmsg_{{$purchaseorderData->purchase_orders_id}}" class="badge bg-green"></strong>
                                                   
                                            @endif
                                            @endif
                                            
                                            </th>
                                              
           
            <th>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $purchaseorderData->roundup_cashdiscount_final_amount }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</th>
                                            
                                                    
                                                   <td>
                                                    @if($purchaseorderData->obsolete_purchase_order == 0)
                                                 
                                                     
                                                   <input type="date" class="form-control" id="added_wallet_date_{{$purchaseorderData->purchase_orders_id}}">
                                                   <input type="hidden" id="purchase_order_id_{{$purchaseorderData->purchase_orders_id}}" value="{{$purchaseorderData->purchase_orders_id}}">
                                                            <button data-id="{{ $purchaseorderData->purchase_orders_id }}" class="btn btn-primary btn-xs addtowallet">Add Date</button>
                                                  
                                                    
                                                   
                                                   <strong id="message_{{$purchaseorderData->purchase_orders_id}}" class="badge bg-green"></strong>
                                                <br>          
 {{$purchaseorderData->purchaseorder_creditpayment_date}}
                                                   
                                                    @endif
                                                   
                                                   </td>
                                                   
                                                    <td>
                                                        @if($purchaseorderData->purchase_orders_status_id==1)
                                                            <span class="label label-warning">
                                                        @elseif($purchaseorderData->purchase_orders_status_id==2)
                                                            <span class="label label-success">
                                                        @elseif($purchaseorderData->purchase_orders_status_id==3)
                                                            <span class="label label-danger">
                                                        @else
                                                            <span class="label label-primary">
                                                        @endif
                                                        {{ $purchaseorderData->orders_status }}
                                                            </span>
                                                        
                                                         
                                                          @if($purchaseorderData->purchase_orders_status_id==7)
                                                        
                                                        <a data-toggle="tooltip" data-placement="bottom" title="View Distributor Wallet" href="distributorwallet/{{ $purchaseorderData->purchase_orders_id }}" class="badge bg-green">View   Wallet</a>
             
 
             @endif
                                                    </td> 
                                                    <td>  
                                                        <a data-toggle="tooltip" data-placement="bottom" title="View Order" href="view_purchase_order/{{ $purchaseorderData->purchase_orders_id }}" class="badge bg-light-blue"><i class="fa fa-eye" aria-hidden="true"></i></a>
 
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6"><strong>{{ trans('labels.NoRecordFound') }}</strong></td>
                                            </tr>
                                        @endif
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
  <!-- Modal -->
<div class="modal fade" id="addtowalletModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Date </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Are you sure you want to Add the Date ?
      </div>
      <div class="modal-footer">
	  
	    <button type="button" id="addtowalletNow" class="btn btn-secondary">Yes, Add the Date</button>
		
        <button type="button" id="cancel" class="btn btn-primary" data-dismiss="modal">No, Don't Add the Date</button>
      
      </div>
    </div>
  </div>
</div>





<div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Disocunt </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Are you sure you want to update the disocunt?
      </div>
      <div class="modal-footer">
	  
	    <button type="button" id="discountacceptreject" class="btn btn-secondary">Yes, update the disocunt</button>
		
        <button type="button" id="cancel" class="btn btn-primary" data-dismiss="modal">No, update the disocunt</button>
      
      </div>
    </div>
  </div>
</div>


            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
