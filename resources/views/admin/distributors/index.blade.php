 @extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Distributors <small>Distributors List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Distributors</li>
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
                            <h3 class="box-title">Distributors List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/adddistributor')}}" type="button" class="btn btn-block btn-primary">Add Distributor</a>
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
                                            <th>Sl.No</th>
                                            <th>Distributor Name</th>
                                            <th>Company Name</th>
                                            <th>Phone Number</th>
                                            <th>Email Address</th>
                                            <th>GST</th> 
                                            <th>Address</th>
                                            <th>Bank Account Details</th>
                                             <th>{{ trans('labels.Status') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['distributors'])>0)
                                            @foreach ($result['distributors'] as $key=>$distributor)
                                                <tr>
                                                    <td>{{ $distributor->id }}</td>
                                                    <td>{{ $distributor->first_name }}</td>
                                                    <td>{{ $distributor->company_name }}</td>
                                                    <td>{{ $distributor->phone }}</td>
                                                    <td>{{ $distributor->email }}</td>
                                                    <td>{{ $distributor->gst }}</td>
                                                    <td>{{ $distributor->distributor_address }}</td>
                                                    <td><b>Bank Name:</b>{{ $distributor->bank_name }}<br>
                                                    <b> Holder Name:</b>{{ $distributor->bank_holder_name }}<br>
                                                    <b>  Account Number:</b>{{ $distributor->bank_account_number }}<br>
                                                    <b>  IFSC:</b>{{ $distributor->bank_ifs_code }}<br></td>
                                                     <td>
                                                        @if($distributor->status==1)
                                                            <strong class="badge bg-green">{{ trans('labels.Active') }}</strong>
                                                        @else
                                                            <strong class="badge bg-red">{{ trans('labels.InActive') }}</strong>
                                                        @endif</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editdistributor/{{ $distributor->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteDistributorId" distributor_id ="{{ $distributor->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Distributors are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['distributors']->links()}}
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
            <!-- deleteOrderStatusModal -->
            <div class="modal fade" id="deleteDistributorModal" tabindex="-1" role="dialog" aria-labelledby="deleteDistributorModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteDistributorModalLabel">Delete Distributor</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deletedistributor', 'name'=>'deleteDistributor', 'id'=>'deleteDistributor', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'distributor_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Distributor?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteDistributor">{{ trans('labels.Delete') }}</button>
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