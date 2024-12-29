@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Wallets <small> Wallets  List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">   Wallets </li>
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
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 form-inline" id="contact-form">
                                    <form name='registration' id="walletcustomer" class="registration" method="get" action="{{url('admin/wallet_customers')}}">
                                        <input type="hidden" value="{{csrf_token()}}">
                                        {{--<div class="input-group-btn search-panel ">--}}
                                        <div class="input-group-form search-panel ">
                                           <select type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" name="customer_id" id="customer_id">
                                                <option value="" selected >Filter By Customer</option>
                                                 @foreach ($result['users'] as $key=>$user)
                                                <option  value="{{$user->id}}" >{{ $user->first_name }} {{ $user->last_name }}</option>
                                                    @endforeach  
                                            </select>
                                             <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                         </div>
                                    </form>
                                    
                                </div>
                                <div class="box-tools pull-right">
                                    <a href="{{ url('admin/addwallet')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                                </div>
                            </div>
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
                                            <th>Customer Name</th>
                                            <th>Wallet Amount</th>
                                           
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['wallets'])>0)
                                            @foreach ($result['wallets'] as $key=>$wallet)
                                                <tr>
                                                    <td>{{ $wallet->id }}</td>
                                                    <td>{{ $wallet->first_name }} {{ $wallet->last_name }}</td>
                                                     <td>{{ $wallet->wallet_amount }}  </td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editwallet/{{ $wallet->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteWalletId" wallet_id ="{{ $wallet->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Wallets are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['wallets']->links()}}
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
            <div class="modal fade" id="deleteWalletModal" tabindex="-1" role="dialog" aria-labelledby="deleteWalletModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteWalletModalLabel">Delete Client</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deletewallet', 'name'=>'deleteWallet', 'id'=>'deleteWallet', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'wallet_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Wallet?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteWallet">{{ trans('labels.Delete') }}</button>
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