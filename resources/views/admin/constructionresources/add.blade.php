@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Add Construction Resources<small> Add Construction Resource</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/constructionresources')}}"><i class="fa fa-dashboard"></i>Construction Resource List</a></li>
                <li class="active"> Add Construction Resource</li>
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
                            <h3 class="box-title">Add Construction Resource</h3>
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

                                            {!! Form::open(array('url' =>'admin/addnewconstructionresource', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
											
											
											<div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Select City</label>
                                                    <div class="col-sm-10 col-md-4">
                                                       <select class="form-control field-validate" name="city">
                                                        <option value="">Select City</option>
                                                        @foreach ($result['locations'] as $key=>$location)
                                                        <option value="{{$location->location_name}}">{{$location->location_name}}</option>
                                                        @endforeach
                                                    </select>
                                                       <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select City</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
 
                                                 
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Material Quality</label>
                                                    <div class="col-sm-10 col-md-4">
                                                       <select class="form-control field-validate" name="materialquality" >
                                                       <option value="">Select Material Quality</option>
                                                        <option value="ECONOMY">ECONOMY</option>
                                                        <option value="STANDARD">STANDARD</option>
                                                         <option value="PREMIUM">PREMIUM</option> 
                                                    </select> <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Material Quality</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Cement</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="cement" Placeholder="Enter Cement" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Cement</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Steel</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="steel" Placeholder="Enter Steel" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Steel</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bricks</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bricks" Placeholder="Enter Bricks" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bricks</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Aggregate</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="aggregate" Placeholder="Enter Aggregate" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Aggregate</span>
                                                     </div>
                                                </div>
                                            <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Sand</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="sand" Placeholder="Enter Sand" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Sand</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Flooring</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="flooring" Placeholder="Enter Flooring" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Flooring</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Windows</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="windows" Placeholder="Enter Windows" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Windows</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Doors</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="doors" Placeholder="Enter Doors" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Doors</span>
                                                     </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Electrical Fittings</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="electricalfittings" Placeholder="Enter Electrical Fittings" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Electrical Fittings</span>
                                                     </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Painting</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="painting" Placeholder="Enter Painting" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Painting</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Sanitary Fitting</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="sanitaryfitting" Placeholder="Enter Sanitary Fitting" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Sanitary Fitting</span>
                                                     </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Kitchen Work</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="kitchenwork" Placeholder="Enter Kitchen Work" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Kitchen Work</span>
                                                     </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Contractor Charges</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="contractorcharges" Placeholder="Enter Contractor Charges" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Contractor Charges</span>
                                                     </div>
                                                </div>

                                             
                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/constructionresources')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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