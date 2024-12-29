@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Jobs <small>Jobs List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Jobs</li>
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
                            <h3 class="box-title">Jobs List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addjob')}}" type="button" class="btn btn-block btn-primary">Add Job</a>
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
                                            <th>Job Name</th>
                                            <th>Job Type</th>
                                            <th>Description</th>
                                            <th>No Of Positions</th>
                                            <th>Experience</th>
                                            <th>Location</th>
                                            <th>{{ trans('labels.Status') }}</th>
                                            <th>Created On</th>
                                            <th>Updated On</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['jobs'])>0)
                                            @foreach ($result['jobs'] as $key=>$job)
                                                <tr>
                                                    <td>{{ $job->id }}</td>
                                                    <td>{{ $job->job_title }}</td>
                                                    <td>{{ $job->job_type }}</td>
                                                    <td>{!! $job->description !!}</td>
                                                    <td>{{ $job->no_of_positions }}</td>
                                                    <td>{{ $job->experience }}</td>
                                                    <td>{{ $job->location }}</td>
                                                    <td>
                                                        @if($job->status==1)
                                                            <strong class="badge bg-green">{{ trans('labels.Active') }}</strong>
                                                        @else
                                                            <strong class="badge bg-red">{{ trans('labels.InActive') }}</strong>
                                                        @endif</td>
                                                         <td>{{ $job->created_at }}</td>
                                                          <td>{{ $job->updated_at }}</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editjob/{{ $job->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteJobId" job_id ="{{ $job->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Jobs are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['jobs']->links()}}
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
            <div class="modal fade" id="deleteJobModal" tabindex="-1" role="dialog" aria-labelledby="deleteJobModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteJobModalLabel">Delete Job</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deletejob', 'name'=>'deleteJob', 'id'=>'deleteJob', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'job_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Job?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteJob">{{ trans('labels.Delete') }}</button>
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