@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Client <small>Edit Client...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/clients')}}"><i class="fa fa-dashboard"></i>Clients List</a></li>
                <li class="active">Edit Client</li>
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
                            <h3 class="box-title">Edit Client</h3>
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

                                            {!! Form::open(array('url' =>'admin/updateclient', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id', $result['clients']->id, array('class'=>'form-control', 'id'=>'id'))!!}
                                            

                                            
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Client Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="client_name"  value="{{$result['clients']->client_name}}" Placeholder="Enter Client Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Client Name</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Phone Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="client_phone" value="{{$result['clients']->client_phone}}" Placeholder="Enter Phone Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Phone Number</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Email</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="client_email" value="{{$result['clients']->client_email}}" Placeholder="Enter Email" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Email</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Address</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="client_address" value="{{$result['clients']->client_address}}" Placeholder="Enter Address" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Address</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">State</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="state" value="{{$result['clients']->state}}" Placeholder="Enter State" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter State</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Country</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="country" value="{{$result['clients']->country}}" Placeholder="Enter Country" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Country</span>
                                                     </div>
                                                </div>
                                            <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Pincode</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="pincode" value="{{$result['clients']->pincode}}" Placeholder="Enter Pincode" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Pincode</span>
                                                     </div>
                                                </div>
                                             


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="is_active">
                                                        <option value="1" @if($result['clients']->is_active==1) selected @endif>{{ trans('labels.Active') }}</option>
                                                        <option value="0" @if($result['clients']->is_active==0) selected @endif>{{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.StatusUnitText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/clients')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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