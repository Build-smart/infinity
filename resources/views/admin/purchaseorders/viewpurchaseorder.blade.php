@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> View Puchase Order<small> View Puchase Order...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
       <li class="active"> View Puchase Order</li>
    </ol>
    
    
     
            
  </section>

  <!-- Main content -->
  <section class="invoice" style="margin: 15px;">
      <!-- title row -->
      @if(session()->has('message'))
       <div class="col-xs-12">
       <div class="row">
      	<div class="alert alert-success alert-dismissible">
           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
           <h4><i class="icon fa fa-check"></i> {{ trans('labels.Successlabel') }}</h4>
            {{ session()->get('message') }}
        </div>
        </div>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="col-xs-12">
      	<div class="row">
        	<div class="alert alert-warning alert-dismissible">
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
               <h4><i class="icon fa fa-warning"></i> {{ trans('labels.WarningLabel') }}</h4>
                {{ session()->get('error') }}
            </div>
          </div>
         </div>
        @endif
      <div class="row">
        <div class="col-xs-3">
          <h2 class="page-header" style="padding-bottom: 25px; margin-top:0;">
            <i class="fa fa-globe"></i> Purchase Order Id# {{ $data['orders_data'][0]->purchase_orders_id }}
             </h2>
        </div>
         <div class="col-xs-3">
          @if($result['commonContent']['setting']['sitename_logo']=='logo')
            <img class="img-fluid" src="{{asset('').$result['commonContent']['setting']['website_logo']}}" height="50" alt="<?=stripslashes($result['commonContent']['setting']['website_name'])?>">
             @endif
        </div>
         <div class="col-xs-4">
         @if($result['commonContent']['setting']['sitename_logo']=='logo')
      <strong>   Address: </strong>    <?=stripslashes($result['commonContent']['setting']['headquaters'])?>
            @endif
    <br>  <strong>   GST: </strong> 36AAJCB7149P1ZY
            
         </div>
         
         <div class="col-xs-2">
         <small style="display: inline-block">Purchase {{ trans('labels.OrderedDate') }}: {{ date('m/d/Y h:i A', strtotime($data['orders_data'][0]->date_purchased)) }}</small>
            <a href="{{ URL::to('admin/orders/purchase_order_invoiceprint/'.$data['orders_data'][0]->purchase_orders_id)}}" target="_blank"  class="btn btn-default pull-right"><i class="fa fa-print"></i> {{ trans('labels.Print') }}</a>
         
         </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          {{ trans('labels.CustomerInfo') }}:
          <address>
            <strong>{{ $data['orders_data'][0]->customers_name }}</strong><br>
            {{ $data['orders_data'][0]->customers_street_address }} <br>
             
            {{ trans('labels.Phone') }}: {{ $data['orders_data'][0]->customers_telephone }}<br>
            {{ trans('labels.Email') }}: {{ $data['orders_data'][0]->email }}<br>
                       GST: {{ $data['orders_data'][0]->gst }}
            
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          {{ trans('labels.ShippingInfo') }}
          <address>
             <strong>{{ $data['orders_data'][0]->delivery_company }}</strong><br>
            <strong>{{ $data['orders_data'][0]->delivery_name }}</strong><br>
            {{ $data['orders_data'][0]->delivery_street_address }} <br>
           
            <strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->delivery_phone }}<br>
            <strong>Alternate Phone: </strong>{{ $data['orders_data'][0]->delivery_alternate_phone }}<br>
            
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
         {{ trans('labels.BillingInfo') }}
          <address>
           <strong>{{ $data['orders_data'][0]->billing_company }}</strong><br>
            <strong>{{ $data['orders_data'][0]->billing_name }}</strong><br>
            {{ $data['orders_data'][0]->billing_street_address }} <br>
            <strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->billing_phone }}<br>
                        <strong>Alternate Phone: </strong>{{ $data['orders_data'][0]->billing_alternate_phone }}<br>
            
            
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              
              <th>{{ trans('labels.Image') }}</th>
              <th>{{ trans('labels.ProductName') }}</th>
              <th>HSN/SAC Code</th>
                
              <th>{{ trans('labels.Options') }}</th>
               <th>MRP</th>
              <th>Discount %</th>
              <th>Product {{ trans('labels.Price') }}</th>
              <th>Variant {{ trans('labels.Price') }}</th>
              <th>{{ trans('labels.Qty') }}</th>
              <th>Total {{ trans('labels.Price') }}</th>
              <th>{{ trans('labels.Status') }}</th>
              <th>Update Product Status</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data['orders_data'][0]->data as $products)

            <tr>
                
                <td >
                   <img src="{{ asset('').$products->image }}" width="60px"> <br>
                </td>
                <td  width="20%">
                    {{  $products->products_name }}<br>
                </td>
                <td>
                    {{  $products->hsn_sac_code }}
                </td>
                <td>
                @foreach($products->attribute as $attributes)
                	<b>{{ trans('labels.Name') }}:</b> {{ $attributes->products_options }}<br>
                    <b>{{ trans('labels.Value') }}:</b> {{ $attributes->products_options_values }}<br>
<!--                     <b>{{ trans('labels.Price') }}:</b>  -->
<!--                     @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $attributes->distributor_options_values_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif<br> -->

                @endforeach</td>
                  <td>
                 @php
                 $products_details=DB::table('products')->where('products_id',$products->products_id)->first();
                 
                 $product_price=$products_details->products_price;
                 
                 @endphp
                  
                 {{$product_price}}
                   
                 </td>
                  <td>
                    {{  $products->distributor_product_price_percentage }}
                </td>
<td>
                  
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $products->distributor_products_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif<br>
                  </td>
                  <td>
                  @foreach($products->attribute as $attributes)
               @if($attributes->distributor_options_values_price == 0)
                0
                      @else  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif 
                   
                   {{ $attributes->distributor_options_values_price }}   @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif<br>
                  @endif
                 @endforeach
                   </td>
                   <td>{{  $products->products_quantity }}</td>
                <td>
                  
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $products->distributor_final_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif<br>
                  </td>
                  
                   <td>
                   
                    @if($products->purchase_order_product_status_id==1)
                                                            <span class="label label-success">
                                                           
                                                        @else
                                                             <span class="label label-danger">
                                                              
                                                        @endif
                                                        {{  $products->purchase_orders_status_name }}
                   </span>
                   
                   <br>
                    @if($products->purchase_order_product_status_id==2)
                                         {!! Form::open(array('url' =>'admin/orders/regenerate_purchase_order', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
        
        
        
                       <input type="hidden" name="purchase_orders_products_id"      value="{{$products->purchase_orders_products_id}}">                
                     
                   <div class="form-group">
                                                         <select class="form-control" req name="distributor_id">
                                                            <option value="">Choose Distributors </option>
                                                            @foreach ($result['distributors'] as $distributor)
                                                            <option value="{{ $distributor->id }}">{{ $distributor->first_name }}</option>
                                                            @endforeach
                                                        </select> 
                                                    </div>
                                                    
                                                    
                           <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                              <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                     </div>
                                            
                                             {!! Form::close() !!}
                   @endif
                   
                   </td>
                   
                   <td>
                     {!! Form::open(array('url' =>'admin/orders/purchase_order_status_update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                                                                    
                       <input type="hidden" name="purchase_orders_products_id"      value="{{$products->purchase_orders_products_id}}">                
                                 <div class="form-group">
                                                 
                                                    <select name="purchase_order_product_status_id" class="form-control">
                                                      @foreach( $data['orders_status'] as $orders_status)
                  <option value="{{ $orders_status->purchase_orders_status_id }}" @if( $products->purchase_order_product_status_id == $orders_status->purchase_orders_status_id) selected="selected" @endif >{{ $orders_status->purchase_orders_status_name }}</option>
                 @endforeach
                                                     
                                                      </select>
                                                   
                                            </div>                                                  
                           <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                              <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                     </div>
                                            
                                           
                                            {!! Form::close() !!}
                   </td>
                   
                   
             </tr>
            @endforeach

            </tbody>
          </table>
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-7">
           {!! Form::open(array('url' =>'admin/orders/updatepurchaseorderrecord', 'method'=>'post', 'onSubmit'=>'return cancelOrder();', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data','id'=>'order_status_update')) !!}
     {!! Form::hidden('purchase_orders_id', $data['orders_data'][0]->purchase_orders_id, array('class'=>'form-control', 'id'=>'orders_id'))!!}
     {!! Form::hidden('old_orders_status', $data['orders_data'][0]->purchase_orders_status_id, array('class'=>'form-control', 'id'=>'old_orders_status'))!!}
 
         <div class="col-xs-12">
        <hr>
          <p class="lead">{{ trans('labels.ChangeStatus') }}:</p>

            <div class="col-md-12">
              <div class="form-group">
                <label>Order Status {{$data['orders_data'][0]->purchase_orders_status_id}}</label>  
                <select class="form-control select2" id="status_idx" name="orders_status" style="width: 100%;">

               	 @foreach( $data['orders_main_status'] as $orders_status)
                  <option value="{{ $orders_status->purchase_orders_main_status_id }}" @if( $data['orders_data'][0]->purchase_orders_status_id == $orders_status->purchase_orders_main_status_id) selected="selected" @endif >{{ $orders_status->purchase_orders_main_status_name }}</option>
                 @endforeach
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseStatus') }}</span>
              </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                <label>{{ trans('labels.Comments') }}:</label>
                {!! Form::textarea('comments',  '', array('class'=>'form-control', 'id'=>'comments', 'rows'=>'4'))!!}
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CommentsOrderText') }}</span>
              </div>
            </div>
        </div>
         <!-- this row will not appear when printing -->
            <div class="col-xs-12">
               <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> {{ trans('labels.Submit') }} </button>
              <!--<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> Generate PDF
              </button>-->

         <br><br> <hr><br>

            </div>
          {!! Form::close() !!}
 
        </div>
        <!-- /.col -->
        <div class="col-xs-5">
          <!--<p class="lead"></p>-->

          <div class="table-responsive ">
            <table class="table order-table">
              <tr>
                <th style="width:50%">{{ trans('labels.Subtotal') }}:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->distributor_order_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                  </td>
              </tr>
              <tr>
                <th>{{ trans('labels.Tax') }}:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->total_tax }}   @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                  </td>
              </tr>
              <tr>
                <th>{{ trans('labels.ShippingCost') }}:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->shipping_cost }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}}@endif
                  </td>
              </tr>
              @if(!empty($data['orders_data'][0]->coupon_code))
              <tr>
                <th>{{ trans('labels.DicountCoupon') }}:</th>
                <td>                  
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->coupon_amount }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
              </tr>
              @endif
              <tr>
                <th>{{ trans('labels.Total') }}:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->distributor_order_price + $data['orders_data'][0]->total_tax }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                  </td>
              </tr>
            </table>
          </div>

        </div>
 

         <br><br> <hr><br>
<div class="col-xs-12">
          <p class="lead">{{ trans('labels.OrderHistory') }}</p>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ trans('labels.Date') }}</th>
                  <th>{{ trans('labels.Status') }}</th>
                  <th>{{ trans('labels.Comments') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $data['orders_status_history'] as $orders_status_history)
                    <tr>
                        <td>
							<?php
								$date = new DateTime($orders_status_history->date_added);
								$status_date = $date->format('d-m-Y');
								print $status_date;
							?>
                        </td>
                        <td>
                        	@if($orders_status_history->purchase_orders_status_id==1)
                            	<span class="label label-warning">
                            @elseif($orders_status_history->purchase_orders_status_id==2)
                                <span class="label label-success">
                            @elseif($orders_status_history->purchase_orders_status_id==3)
                                 <span class="label label-danger">
                            @else
                                 <span class="label label-primary">
                            @endif
                            {{ $orders_status_history->purchase_orders_main_status_name }}
                                 </span>
                        </td>
                        <td style="text-transform: initial;">{{ $orders_status_history->comments }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
            </div>
 
        <!-- /.col -->
      </div>
      <!-- /.row -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      
      <script type='text/javascript'>

    $(document).ready(function(){

      // City Change
      $('#status_id').change(function(){

         // City id
         var status_id = $(this).val();
 // alert(status_id);
         // Empty the dropdown
         $('#comments').find('input').not(':first').remove();

     	var parentFrom = $('#order_status_update');
		var formData = parentFrom.serialize();
         
         // AJAX request 
         $.ajax({
           url: '{{ URL::to("admin/orders/getorderstatus_comments")}}',
           type: 'post',
           dataType: 'json',
			data: formData,
	           
           success: function(response){
 // alert(response['data']);
             var len = 0;
             if(response['data'] != null){
                 
            	 $('#comments').val(response['data']);
             }
        
           }
        });
      });

    });

    </script>

    </section>
  <!-- /.content -->
</div>
@endsection
