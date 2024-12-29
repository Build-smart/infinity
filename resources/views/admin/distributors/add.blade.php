@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Add Distributor<small> Add Distributor</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/distributors')}}"><i class="fa fa-dashboard"></i>Distributor List</a></li>
                <li class="active"> Add Distributor</li>
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
                            <h3 class="box-title">Add Distributor</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                      @if(session()->has('message'))
       <div class="col-xs-12">
       <div class="row">
      	<div class="alert alert-success alert-dismissible">
            {{ session()->get('message') }}
        </div>
        </div>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="col-xs-12">
      	<div class="row">
        	<div class="alert alert-danger alert-dismissible">
                {{ session()->get('error') }}
            </div>
          </div>
         </div>
        @endif
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/addnewdistributor', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

 
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Distributor Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="first_name" Placeholder="Enter Distributor Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Distributor Name</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Company Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="company_name" Placeholder="Enter Company Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Company Name</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Profile Photo</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="photo" Placeholder="Enter Profile Photo" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Profile Photo</span>
                                                        <span class="help-block hidden">Please Upload Profile Photo</span>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Company Store Photo</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="company_store_photo" Placeholder="Enter Company Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Company Store Photo</span>
                                                        <span class="help-block hidden">Please Upload Company Store Photo</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">GST</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="gst" Placeholder="Enter GST Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter GST Number</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">GST Document (In PDF Or JPG)</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="gst_doc" Placeholder="Enter Company Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload GST Document</span>
                                                        <span class="help-block hidden">Please Upload GST Document</span>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Pan Card Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="pan" Placeholder="Enter Pan Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Pan Card Number</span>
                                                        <span class="help-block hidden">Please Enter Pan Card Number</span>
                                                    </div>
                                                </div>
                                                
                                                
                                               
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Pan Card Document (In PDF Or JPG)</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="pan_doc" Placeholder="Enter GST Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Pan Card Document</span>
                                                        <span class="help-block hidden">Please Upload Pan Card Document</span>
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Visiting Card (In PDF Or JPG)</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="visiting_card" Placeholder="Enter Visiting Card" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Visiting Card</span>
                                                        <span class="help-block hidden">Please Upload Visiting Card</span>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Phone Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="phone" Placeholder="Enter Phone Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Phone Number</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Email</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="email" Placeholder="Enter Email" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Email</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Password</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="password" Placeholder="Enter Password" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Password</span>
                                                     </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Address</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="distributor_address" Placeholder="Enter Address" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Address</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_name" Placeholder="Enter Bank Name" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank Name</span>
                                                     </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank Holder Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_holder_name" Placeholder="Enter Bank Holder Name" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank Holder Name</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank Account Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_account_number" Placeholder="Enter Bank Account Number" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank Account Number</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank IFSC</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_ifs_code" Placeholder="Enter Bank IFSC" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank IFSC</span>
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