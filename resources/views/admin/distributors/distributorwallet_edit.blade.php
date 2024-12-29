 @extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Distributor Wallet<small>Edit Distributor Wallet...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                 <li class="active">Edit Distributor Wallet</li>
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
                            <h3 class="box-title">Edit Distributor Wallet</h3>
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

                                            {!! Form::open(array('url' =>'admin/orders/purchase_orders/distributorwallet/updatedistributorwallet', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id', $result['distributorwallets']->purchase_orders_id, array('class'=>'form-control', 'id'=>'id'))!!}
                                             
                                             
                                             <div class="form-group">
                                             		<label for="name" class="col-sm-2 col-md-2 control-label">Payment Transaction Details<span style="color:red;">*</span></label>
                                            		<div class="col-sm-10 col-md-10">
                                             			<textarea   name="payment_transaction_details" class="form-control field-validate" rows="5">{{$result['distributorwallets']->payment_transaction_details}}</textarea>
                                               			<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Payment Transaction Details</span>
                                                     	<span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            		</div>
                                      			</div>
                                      			
                                      			<div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-10">
                                                    <select class="form-control" name="is_paid">
                                                        <option value="1" @if($result['distributorwallets']->is_paid==1) selected @endif>PAID</option>
                                                        <option value="0" @if($result['distributorwallets']->is_paid==0) selected @endif>PENDNG</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.StatusUnitText') }}</span>
                                                </div>
                                            </div>
                                      			
                                             

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
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
        
         <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
    
    <script type="text/javascript">
    $(function() {

        //for multiple languages
        
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor');

   

        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

    });
</script>
    </div>
@endsection