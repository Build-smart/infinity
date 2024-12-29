 @extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Distributor <small>Edit Distributor...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/distributors')}}"><i class="fa fa-dashboard"></i>Distributors List</a></li>
                <li class="active">Edit Distributor</li>
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
                            <h3 class="box-title">Edit Distributor</h3>
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

                                            {!! Form::open(array('url' =>'admin/updatedistributor', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id', $result['distributors']->id, array('class'=>'form-control', 'id'=>'id'))!!}
                                            

                                            
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Distributor Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="first_name"  value="{{$result['distributors']->first_name}}" Placeholder="Enter Distributor Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Distributor Name</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Company Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="company_name"  value="{{$result['distributors']->company_name}}" Placeholder="Enter Company Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Company Name</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Profile Photo</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="photo"    Placeholder="Enter Profile Photo" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Profile Photo</span>
                                                        <span class="help-block hidden">Please Upload Profile Photo</span>
                                                  
                                                      <img src="{{asset($result['distributors']->avatar)}}" alt="" width=" 100px">
               
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Company Store Photo</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="company_store_photo"    Placeholder="Enter Company Name" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Company Store Photo</span>
                                                        <span class="help-block hidden">Please Upload Company Store Photo</span>
                                                  
                                                      <img src="{{asset($result['distributors']->company_store_photo)}}" alt="" width=" 100px">
               
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">GST Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="gst"  value="{{$result['distributors']->gst}}" Placeholder="Enter GST Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter GST Number</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">GST Document</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="gst_doc"    Placeholder="Enter GST Number" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload GST Document</span>
                                                        <span class="help-block hidden">Please Upload GST Document</span>
                                                     @if(substr ($result['distributors']->gst_doc, -3)=="pdf")
                                                     <a class="btn btn-primary" href="{{asset($result['distributors']->gst_doc)}}">View Document</a>
                                                 @else    
                                                      <img src="{{asset($result['distributors']->gst_doc)}}" alt="" width=" 100px">
                                                 @endif  
                                                    
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Pan Card Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="pan"  value="{{$result['distributors']->pan}}" Placeholder="Enter Pan Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Pan Card Number</span>
                                                        <span class="help-block hidden">Please Enter Pan Card Number</span>
                                                    </div>
                                                </div>
                                                 
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Pan Card Document</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="pan_doc"    Placeholder="Enter Pan Card Document" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Pan Card Document</span>
                                                        <span class="help-block hidden">Please Upload Pan Card Document</span>
                                                      @if(substr ($result['distributors']->pan_doc, -3)=="pdf")
                                                     <a class="btn btn-primary" href="{{asset($result['distributors']->pan_doc)}}">View Document</a>
                                                 @else    
                                                      <img src="{{asset($result['distributors']->pan_doc)}}" alt="" width=" 100px">
                                                 @endif  
                                                    
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Visiting Card</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="file" name="visiting_card"    Placeholder="Enter Visiting Card" class="form-control"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Upload Visiting Card</span>
                                                        <span class="help-block hidden">Please Upload Visiting Card</span>
                                                      @if(substr ($result['distributors']->visiting_card, -3)=="pdf")
                                                     <a class="btn btn-primary" href="{{asset($result['distributors']->visiting_card)}}">View Document</a>
                                                 @else    
                                                      <img src="{{asset($result['distributors']->visiting_card)}}" alt="" width=" 100px">
                                                 @endif  
                                                    
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Phone Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="phone" readonly value="{{$result['distributors']->phone}}" Placeholder="Enter Phone Number" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Phone Number</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Email</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="email" readonly value="{{$result['distributors']->email}}" Placeholder="Enter Email" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Email</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.changePassword') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::checkbox('changePassword', 'yes', null, ['class' => '', 'id'=>'change-passowrd']) !!}
                                            </div>
                                        </div>

                                        <!-- <div class="form-group password_content">-->
                                        <div class="form-group password" style="display: none">
                                            <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Password') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::password('password', array('class'=>'form-control ', 'id'=>'password')) !!}
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.PasswordText') }}</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            </div>
                                        </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Address</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="distributor_address" value="{{$result['distributors']->distributor_address}}" Placeholder="Enter Address" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Address</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_name" value="{{$result['distributors']->bank_name}}" Placeholder="Enter Bank Account Details" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank Account Details</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank Holder Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_holder_name" value="{{$result['distributors']->bank_holder_name}}" Placeholder="Enter Bank Holder Name" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank Holder Name</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank Account Number</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_account_number" value="{{$result['distributors']->bank_account_number}}" Placeholder="Enter Bank Account Number" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank Account Number</span>
                                                     </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Bank IFSC</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="bank_ifs_code" value="{{$result['distributors']->bank_ifs_code}}" Placeholder="Enter Bank IFSC" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Bank IFSC</span>
                                                     </div>
                                                </div>
                                                
                                                 
                                              
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="status">
                                                        <option value="1" @if($result['distributors']->status==1) selected @endif>{{ trans('labels.Active') }}</option>
                                                        <option value="0" @if($result['distributors']->status==0) selected @endif>{{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.StatusUnitText') }}</span>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="kyc_status">
                                                        <option value="PENDING" @if($result['distributors']->kyc_status=="PENDING") selected @endif>PENDING</option>
                                                        <option value="REJECTED" @if($result['distributors']->kyc_status=="REJECTED") selected @endif>REJECTED</option>
                                                      	<option value="NOTCLEAR" @if($result['distributors']->kyc_status=="NOTCLEAR") selected @endif>NOT CLEAR</option>
                                                       <option value="COMPLETED" @if($result['distributors']->kyc_status=="COMPLETED") selected @endif>COMPLETED</option>
                                                  
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