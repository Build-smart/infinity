@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Orders') }} <small>{{ trans('labels.ListingAllOrders') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">{{ trans('labels.Orders') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                       <div class="box-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 form-inline" id="contact-form">
                                    <form name='registration' id="registration" class="registration" method="get" action="{{url('admin/orders/filter')}}">
                                        <input type="hidden" value="{{csrf_token()}}">
                                        {{--<div class="input-group-btn search-panel ">--}}
                                        <div class="input-group-form search-panel ">
                                            <select type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" name="FilterBy" id="FilterBy">
                                                <option value="" selected disabled hidden>Filter By</option>
                                                <option value="ID" @if(isset($filter)) @if ($filter=="ID" ) {{ 'selected' }} @endif @endif>ID</option>
                                                 <option value="Name" @if(isset($filter)) @if ($filter=="Name" ) {{ 'selected' }} @endif @endif>Customer Name</option>
                                                 <option value="Phone" @if(isset($filter)) @if ($filter=="Phone" ) {{ 'selected' }}@endif @endif>Phone Number</option>
                                                 
                                                   <option value="Location" @if(isset($filter)) @if ($filter=="Location" ) {{ 'selected' }}@endif @endif>Location</option>
                                                 </select>
                                            <input type="text" class="form-control input-group-form " name="parameter" placeholder="Search term..." id="parameter" @if(isset($parameter)) value="{{$parameter}}" @endif>
                                            <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                            @if(isset($parameter,$filter)) <a class="btn btn-danger " href="{{url('admin/orders/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                        </div>
                                    </form>
                                    <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                </div>
                                <div class="box-tools pull-right">
<h3 class="box-title">{{ trans('labels.ListingAllOrders') }} </h3>                                </div>
                            </div>
                        </div>
                    </div> 
                        
                        
                        
                       

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                  @if(session()->has('error'))
        <div class="col-xs-12">
      	<div class="row">
        	<div class="alert alert-danger alert-dismissible">
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>
               <h4><i class="icon fa fa-warning"></i>Error</h4>
                {{ session()->get('error') }}
            </div>
          </div>
         </div>
        @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('orders_id', trans('labels.ID') )</th>
                                            <th>@sortablelink('customers_name', trans('labels.CustomerName') )</th>
                                             <th>Phone Number</th>
                                            <th>{{ trans('labels.OrderTotal') }}</th>
                                            <th>@sortablelink('date_purchased', trans('labels.DatePurchased') ) </th>
                                            <th>{{ trans('labels.Status') }} </th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($listingOrders['orders'])>0)
                                            @foreach ($listingOrders['orders'] as $key=>$orderData)
                                                <tr>
                                                    <td>{{ $orderData->orders_id }}</td>
                                                    <td>{{ $orderData->customers_name }}</td>
                                                      <td>{{ $orderData->delivery_phone }}</td>
                                                    <td>
                                                        
                                                        @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $orderData->order_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
                                                    <td>{{ date('d/m/Y H:i a', strtotime($orderData->date_purchased)) }}</td>
                                                    <td>
                                                        @if($orderData->orders_status_id==1)
                                                            <span class="label label-warning">
                                                        @elseif($orderData->orders_status_id==2)
                                                            <span class="label label-success">
                                                        @elseif($orderData->orders_status_id==3)
                                                            <span class="label label-danger">
                                                        @else
                                                            <span class="label label-primary">
                                                        @endif
                                                        {{ $orderData->orders_status }}
                                                            </span>
                                                    </td>
                                                    <td>
                                                        
                                                         @if($orderData->is_purchase_order_raised==1)
                                                    <a data-toggle="tooltip" data-placement="bottom" title="View Purchase Order" href="purchase_orders/{{ $orderData->orders_id }}" class="badge bg-green">View Purchase Order</a>
                                                     @else
                                                     <a data-toggle="tooltip" data-placement="bottom" title="Raise Purchase Order" href="generate_prucahse_order/{{ $orderData->orders_id }}" class="badge bg-light-blue">Raise Purchase Orders</a>
                                                     @endif
                                                     
                                                     
                                                        <a data-toggle="tooltip" data-placement="bottom" title="View Order" href="vieworder/{{ $orderData->orders_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                        <a data-toggle="tooltip" data-placement="bottom" title="Delete Order" id="deleteOrdersId" orders_id ="{{ $orderData->orders_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>

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
                                    <div class="col-xs-12 text-right">
                                        {{$listingOrders['orders']->links()}}
                                    </div>
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

            <!-- deleteModal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteModalLabel">{{ trans('labels.DeleteOrder') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/orders/deleteOrder', 'name'=>'deleteOrder', 'id'=>'deleteOrder', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('orders_id',  '', array('class'=>'form-control', 'id'=>'orders_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteOrderText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteOrder">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
