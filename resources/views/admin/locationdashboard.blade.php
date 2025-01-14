@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            <small>{{ trans('labels.title_dashboard') }} {{$result['commonContent']['setting']['admin_version']}}</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</li>
            </ol>
        </section>
       
        <!-- Main content -->
        <section class="content">
             @if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->locationdashboard_view == 1)

              <div class="row">
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{ $result['total_orders'] }}</h3>
        			        <p>{{ trans('labels.NewOrders') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ URL::to('admin/orders/locationorderdisplay')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.NewOrders') }}">{{ trans('labels.NewOrders') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-light-blue">
                    <div class="inner">
                      <h3>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $result['profit'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</h3>
        			  <p>{{ trans('labels.Total Money') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                     {{ trans('labels.viewAllProducts') }} <i class="fa fa-arrow-circle-right"></i> 
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-teal">
                    <div class="inner">
                      <h3>@if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $result['profit'] }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</h3>
        			  <p>{{ trans('labels.Total Money Earned') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ URL::to('admin/orders/locationorderdisplay')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllOrders') }}">{{ trans('labels.viewAllOrders') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">

                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>{{ $result['outOfStock'] }} </h3>
                      <p>{{ trans('labels.outOfStock') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ URL::to('admin/locationoutofstock')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.outOfStock') }}">{{ trans('labels.outOfStock') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                 
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>{{ $result['totalProducts'] }}</h3>

                      <p>{{ trans('labels.totalProducts') }}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{ URL::to('admin/orders/locationorderdisplay')}}" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.viewAllProducts') }}">{{ trans('labels.viewAllProducts') }} <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->

              </div>

             
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
                    <!-- MAP & BOX PANE -->

                    <!-- /.box -->
                     
                    <!-- /.row -->

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ trans('labels.NewOrders') }}</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('labels.OrderID') }}</th>
                                        <th>{{ trans('labels.CustomerName') }}</th>
                                        <th>{{ trans('labels.TotalPrice') }}</th>
                                        <th>{{ trans('labels.Status') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($result['orders'])>0)
                                        @foreach($result['orders'] as $total_orders)
                                            @foreach($total_orders as $key=>$orders)
                                                @if($key<=10)
                                                    <tr>
                                                        <td><a href="{{ URL::to('admin/orders/vieworder/') }}/{{ $orders->orders_id }}" data-toggle="tooltip" data-placement="bottom" title="Go to detail">{{ $orders->orders_id }}</a></td>
                                                        <td>{{ $orders->customers_name }}</td>
                                                        <td>
                                                            @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ floatval($orders->total_price) }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                                                        </td>
                                                        <td>
                                                            @if($orders->orders_status_id==1)
                                                                <span class="label label-warning"></span>
                            @elseif($orders->orders_status_id==2)
                                                                  <span class="label label-success">
                            @elseif($orders->orders_status_id==3)
                                                                </span>  <span class="label label-danger"></span>
                            @else
                                                                  <span class="label label-primary">
                            @endif
                                                                                            {{ $orders->orders_status }}
                                 </span>


                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    @else
                                        <tr>
                                            <td colspan="4">{{ trans('labels.noOrderPlaced') }}</td>

                                        </tr>
                                    @endif


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <!--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>-->
                            <a href="{{ URL::to('admin/orders/locationorderdisplay') }}" class="btn btn-sm btn-default btn-flat pull-right" data-toggle="tooltip" data-placement="bottom" title="View All Orders">{{ trans('labels.viewAllOrders') }}</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-md-4">

                    <!-- PRODUCT LIST -->

                     
                     
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
               @endif
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>

    <script src="{!! asset('admin/dist/js/pages/dashboard2.js') !!}"></script>
@endsection
