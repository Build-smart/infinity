@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Reward Points <small>  Reward Points  List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active">   Reward Points </li>
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
                            <h3 class="box-title">  Reward Points  List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addrewardpoint')}}" type="button" class="btn btn-block btn-primary">Add Reward Points</a>
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
                                            <th>Minimum Cart Value</th>
                                            <th>Reward Points</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['rewardpoints'])>0)
                                            @foreach ($result['rewardpoints'] as $key=>$rewardpoint)
                                                <tr>
                                                    <td>{{ $rewardpoint->reward_id }}</td>
                                                    <td>{{ $rewardpoint->min_cart_value }}</td>
                                                    <td>{{ $rewardpoint->reward_point }}</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editrewardpoint/{{ $rewardpoint->reward_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteRewardPointId" reward_id ="{{ $rewardpoint->reward_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Reward Points are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['rewardpoints']->links()}}
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
            <div class="modal fade" id="deleteRewardPointModal" tabindex="-1" role="dialog" aria-labelledby="deleteRewardPointModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteRewardPointModalLabel">Delete Reward Points</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deleterewardpoint', 'name'=>'deleteRewardPoint', 'id'=>'deleteRewardPoint', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'reward_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Reward Points?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteRewardPoint">{{ trans('labels.Delete') }}</button>
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