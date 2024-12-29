@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Widthdraw Cashback Request <small>Widthdraw Cashback Request List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Widthdraw Cashback Request</li>
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
                            <h3 class="box-title">Widthdraw Cashback Request List </h3>
                             
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
                                            <th>Amount</th>
                                            <th>date</th>
                                            <th>Tansaction Details</th>
                                            <th>Status</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['widthdrawcashbacks'])>0)
                                            @foreach ($result['widthdrawcashbacks'] as $key=>$widthdrawcashback)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $widthdrawcashback->first_name }} {{ $widthdrawcashback->last_name }}</td>
                                                    <td>{{ $widthdrawcashback->request_amount }}</td>
                                                    <td>{{ $widthdrawcashback->request_date }}</td>
                                                    <td>{{ $widthdrawcashback->transcation_details }}</td>
                                                     <td>{{ $widthdrawcashback->status }}</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editwidthdrawcashback/{{ $widthdrawcashback->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                     </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>No Widthdraw Cashback Requests yet.</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['widthdrawcashbacks']->links()}}
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
            
        </section>
        <!-- /.content -->
    </div>
@endsection