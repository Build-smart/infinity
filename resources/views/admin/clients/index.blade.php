@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Clients <small>Clients List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Clients</li>
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
                            <h3 class="box-title">Clients List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addclient')}}" type="button" class="btn btn-block btn-primary">Add Client</a>
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
                                            <th>Id</th>
                                            <th>Client Name</th>
                                            <th>Mobile Number</th>
                                            <th>Client Email</th>
                                            <th>Client Address</th>
                                            <th>{{ trans('labels.Status') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['clients'])>0)
                                            @foreach ($result['clients'] as $key=>$client)
                                                <tr>
                                                    <td>{{ $client->id }}</td>
                                                    <td>{{ $client->client_name }}</td>
                                                    <td>{{ $client->client_phone }}</td>
                                                    <td>{{ $client->client_email }}</td>
                                                    <td>{{ $client->client_address }}</td>
                                                    <td>
                                                        @if($client->is_active==1)
                                                            <strong class="badge bg-green">{{ trans('labels.Active') }}</strong>
                                                        @else
                                                            <strong class="badge bg-red">{{ trans('labels.InActive') }}</strong>
                                                        @endif</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editclient/{{ $client->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteClientId" client_id ="{{ $client->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Clients are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['clients']->links()}}
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
            <div class="modal fade" id="deleteClientModal" tabindex="-1" role="dialog" aria-labelledby="deleteClientModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteClientModalLabel">Delete Client</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deleteclient', 'name'=>'deleteClient', 'id'=>'deleteClient', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'client_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Client?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteClient">{{ trans('labels.Delete') }}</button>
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