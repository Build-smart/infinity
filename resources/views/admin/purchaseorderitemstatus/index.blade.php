@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Purchase Order Status <small>Purchase Order Status List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Purchase Order Status</li>
            </ol>
        </section>

        <!--  content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Purchase Order Status List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addpurchaseorderstatus')}}" type="button" class="btn btn-block btn-primary">Add Purchase Order Status</a>
                            </div>
                        </div>

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
                                            <th>Id</th>
                                            <th>Purchase Order Status Name</th>
                                             <th>Comments</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['purchaseorderstatus'])>0)
                                            @foreach ($result['purchaseorderstatus'] as $key=>$purchaseorderstatus_data)
                                                <tr>
                                                    <td>{{ $purchaseorderstatus_data->purchase_orders_status_id }}</td>
                                                    <td>{{ $purchaseorderstatus_data->purchase_orders_status_name }}</td>
                                              		<td>{{ $purchaseorderstatus_data->comments }}</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editpurchaseorderstatus/{{ $purchaseorderstatus_data->purchase_orders_status_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deletePurchaseorderstatusId" purchaseorderstatus_id ="{{ $purchaseorderstatus_data->purchase_orders_status_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Purchase Order Status are not added yet</strong></td>
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
            <!-- deleteOrderStatusModal -->
            <div class="modal fade" id="deletePurchaseorderstatusModal" tabindex="-1" role="dialog" aria-labelledby="deletePurchaseorderstatusModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deletePurchaseorderstatusModalLabel">Delete Purchase Order Status</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deletepurchaseorderstatus', 'name'=>'deletePurchaseorderstatus', 'id'=>'deletePurchaseorderstatus', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'purchaseorderstatus_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Location?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deletePurchaseorderstatus">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!--  row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection