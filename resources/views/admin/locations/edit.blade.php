@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Location <small>Edit Location...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/locations')}}"><i class="fa fa-dashboard"></i>Locations List</a></li>
                <li class="active">Edit Location</li>
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
                            <h3 class="box-title">Edit Location</h3>
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

                                            {!! Form::open(array('url' =>'admin/updatelocation', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id', $result['locations']->id, array('class'=>'form-control', 'id'=>'id'))!!}
                                            
											<div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Zone') }}
                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select name="zone_id" class="form-control field-validate">
                                                    <option value=""> Select Zone</option>
                                                        @foreach($result['zones'] as $zones)
                                                            <option
                                                                    @if($result['locations']->zone_id == $zones->zone_id)
                                                                    selected
                                                                    @endif
                                                                    value="{{ $zones->zone_id }}"> {{ $zones->zone_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select Zone</span>
                                                </div>
                                            </div>
                                            
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Location Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="location_name"  value="{{$result['locations']->location_name}}" Placeholder="Enter Location Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Location Name</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                              
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }} </label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <select class="form-control" name="status">
                                                            <option value="1" @if($result['locations']->status==1) selected @endif >{{ trans('labels.Active') }}</option>
                                                            <option value="0" @if($result['locations']->status==0) selected @endif>{{ trans('labels.Inactive') }}</option>
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.SelectStatus') }}</span>
                                                    </div>
                                                </div>
                                             
                                              
                                                
                                         
                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/locations')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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