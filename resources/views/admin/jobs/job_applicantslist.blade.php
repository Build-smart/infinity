@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Job Applicants <small>Job Applicants List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Job Applicants</li>
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
                            <h3 class="box-title">Job Applicants List </h3>
                             
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
                                            <th>Applicant Name</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>Message</th>
                                            <th>Resume</th>
                                            <th>Created On</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['jobapplicants'])>0)
                                            @foreach ($result['jobapplicants'] as $key=>$job)
                                                <tr>
                                                    <td>{{ $job->id }}</td>
                                                    <td>{{ $job->job_title }}</td>
                                                    <td>{{ $job->applicant_name }}</td>
                                                    <td>{!! $job->phone !!}</td>
                                                    <td>{{ $job->email }}</td>
                                                    <td>{{ $job->message }}</td>
                                                    <td><a href="{{asset('').$job->resume}}" target="_blank">Download Resume</a></td>
                                                    <td>{{ $job->created_on }}</td>
                                                           
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
                                        {{$result['jobapplicants']->links()}}
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