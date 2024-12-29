@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.EditCustomers') }} <small>{{ trans('labels.EditCurrentCustomers') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/customers/display')}}"><i class="fa fa-users"></i> {{ trans('labels.ListingAllCustomers') }}</a></li>
            <li class="active">{{ trans('labels.EditCustomers') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.EditCustomers') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Edit category</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                    <br>
                                    @if (count($errors) > 0)
                                      @if($errors->any())
                                      <div class="alert alert-danger alert-dismissible" role="alert">
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          {{$errors->first()}}
                                      </div>
                                      @endif
                                    @endif


                                    <!-- form start -->
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/customers/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                        {!! Form::hidden('customers_id', $data['customers']->id, array('class'=>'form-control', 'id'=>'id')) !!}

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FirstName') }}* </label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('first_name', $data['customers']->first_name, array('class'=>'form-control field-validate', 'id'=>'first_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.FirstNameText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.LastName') }}*</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('last_name', $data['customers']->last_name , array('class'=>'form-control field-validate', 'id'=>'last_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.lastNameText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Bank Account Holder Name</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('bank_holder_name', $data['customers']->bank_holder_name , array('class'=>'form-control', 'id'=>'bank_holder_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please enter Bank Account Holder Name</span>
                                                <span class="help-block hidden">Please enter Bank Account Holder Name</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Bank Account Number</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('bank_account_number', $data['customers']->bank_account_number , array('class'=>'form-control', 'id'=>'bank_account_number')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please enter Bank Account Number</span>
                                                <span class="help-block hidden">Please enter Bank Account Number</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Bank Name</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('bank_name', $data['customers']->bank_name , array('class'=>'form-control ', 'id'=>'bank_name')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please enter Bank Name</span>
                                                <span class="help-block hidden">Please enter Bank Name</span>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Bank IFS Code</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('bank_ifs_code', $data['customers']->bank_ifs_code , array('class'=>'form-control', 'id'=>'bank_ifs_code')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please enter Bank IFS Code</span>
                                                <span class="help-block hidden">Please enter Bank IFS Code</span>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">UPI Address / GooglePay / Phonepay / Paytm</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('upi_address', $data['customers']->upi_address , array('class'=>'form-control', 'id'=>'upi_address')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please enter UPI Address / GooglePay / Phonepay / Paytm</span>
                                                <span class="help-block hidden">Please enter UPI Address / GooglePay / Phonepay / Paytm</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">GST Number</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('gst', $data['customers']->gst , array('class'=>'form-control', 'id'=>'gst')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please enter GST Number</span>
                                                <span class="help-block hidden">Please enter GST Number</span>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Pan Card Number</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::text('pan', $data['customers']->pan , array('class'=>'form-control', 'id'=>'pan')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please enter Pan Card Number</span>
                                                <span class="help-block hidden">Please enter Pan Card Number</span>
                                            </div>
                                        </div>
                                       

                                      
                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Telephone') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('phone',  $data['customers']->phone, array('class'=>'form-control phone-validate', 'id'=>'phone','maxlength' => 10)) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.TelephoneText') }}</span>
                                          </div>
                                        </div>

                            <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Customer Type
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control customer_type" name="customer_type">
                                                    <option @if($data['customers']->customer_type == "CUSTOMER")
                                                        selected
                                                        @endif
                                                        value="CUSTOMER">Customer</option>
                                                        
                                                    <option @if($data['customers']->customer_type == "BUSINESSOWNER")
                                                        selected
                                                        @endif
                                                        value="BUSINESSOWNER">Workforce</option>
                                                        
                                                        
                                                        <option @if($data['customers']->customer_type == "CLIENT")
                                                        selected
                                                        @endif
                                                        value="CLIENT">Home Builder or House Contractor</option>
                                                </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.StatusText') }}</span>

                                            </div>
                                        </div>
                                        
                                        <div class="form-group" id="workforce">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">Workforce Name</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('workforce_name',  $data['customers']->workforce_name, array('class'=>'form-control field-validate', 'id'=>'workforce_name')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Workforce Name</span>
                                          </div>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.changePassword') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::checkbox('changePassword', 'yes', null, ['class' => '', 'id'=>'change-passowrd']) !!}
                                            </div>
                                        </div>

                                        <!-- <div class="form-group password_content">-->
                                        <div class="form-group password" style="display: none">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Password') }}*</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::password('password', array('class'=>'form-control ', 'id'=>'password')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.PasswordText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}
                                            </label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="status">
                                                    <option @if($data['customers']->status == 1)
                                                        selected
                                                        @endif
                                                        value="1">{{ trans('labels.Active') }}</option>
                                                    <option @if($data['customers']->status == 0)
                                                        selected
                                                        @endif
                                                        value="0">{{ trans('labels.Inactive') }}</option>
                                                </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.StatusText') }}</span>

                                            </div>
                                        </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                            <a href="{{ URL::to('admin/customers/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
