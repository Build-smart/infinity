@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Product Order Status <small>Edit Product Order Status...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/productorderstatus')}}"><i class="fa fa-dashboard"></i>Product Order Status List</a></li>
                <li class="active">Edit Product Order Status</li>
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
                            <h3 class="box-title">Edit Product Order Status</h3>
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
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/updateproductorderstatus', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('product_orders_status_id', $result['productorderstatus']->product_orders_status_id, array('class'=>'form-control', 'id'=>'product_orders_status_id'))!!}
                                            
											 
                                            
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Product Order Status</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="product_orders_status_name"  value="{{$result['productorderstatus']->product_orders_status_name}}" Placeholder="Enter Product Order Status" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Product Order Status</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Comments</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="comments"  value="{{$result['productorderstatus']->comments}}" Placeholder="Enter Comments" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Comments</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                              
                                                
                                         
                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/productorderstatus')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                                </div>
                                            </div>

                                            <!-- /.box-footer -->
                                            {!! Form::close() !!}
                                        </div>
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

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection