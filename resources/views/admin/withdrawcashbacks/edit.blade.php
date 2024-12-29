@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Widthdraw Cashback Request Status Update <small> Widthdraw Cashback Request Status Update </small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                 <li class="active">Widthdraw Cashback Request Status Update</li>
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
                            <h3 class="box-title">Widthdraw Cashback Request Status Update</h3>
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

                                            {!! Form::open(array('url' =>'admin/updatewidthdrawcashback', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id', $result['widthdrawcashbacks']->id, array('class'=>'form-control', 'id'=>'id'))!!}
                                            

                                            
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Customer Name</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="client_name"  value="{{$result['widthdrawcashbacks']->first_name}} {{$result['widthdrawcashbacks']->last_name}}" readonly   class="form-control  "  >
                                                       <input type="hidden" name="user_id"  value="{{$result['widthdrawcashbacks']->user_id}}"      class="form-control"  >
                                                      
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Request Amount</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="request_amount" value="{{$result['widthdrawcashbacks']->request_amount}}" readonly   class="form-control  "  >
                                                       
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Date</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="request_date" value="{{$result['widthdrawcashbacks']->request_date}}" readonly   class="form-control  "  >
                                                       </div> 
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Transaction Details</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="transcation_details" value="{{$result['widthdrawcashbacks']->transcation_details}}" Placeholder="Enter Transaction Details" class="form-control  field-validate"  >
														 <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Transaction Details</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>                
                                                          </div>
                                                </div>
                                                
                                            

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">Payment {{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" name="status">
                                                       
                                                        <option value="PAID"  selected>PAID</option>
                                                    </select>
                                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select Payment Status</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>  
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/widthdrawcashbacks')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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