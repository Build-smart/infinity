@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Project <small>Edit Project...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/projects')}}"><i class="fa fa-dashboard"></i>Projects List</a></li>
                <li class="active">Edit Project</li>
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
                            <h3 class="box-title">Edit Project</h3>
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

                                            {!! Form::open(array('url' =>'admin/updateproject', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id', $result['projects']->id, array('class'=>'form-control', 'id'=>'id'))!!}
                                            

                                            
                                               <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Select Client</label>
                                                    <div class="col-sm-10 col-md-8">
                                                       <select class="form-control field-validate" name="client_id">
                                                        <option value="">Select Client</option>
                                                       @foreach ($result['clients'] as $client)
                                                       
                                                       
                                                       
                                                            <option @if($result['projects']->client_id == $client->id )
                                                                selected
                                                                @endif
                                                                value="{{ $client->id }}">{{ $client->client_name }}</option>
                                                            @endforeach
                                                    </select>
                                                       <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select Client</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Project Name</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <input type="text" name="project_name" value="{{$result['projects']->project_name}}" Placeholder="Enter Project Name" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Project Name</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Description') }}<span style="color:red;">*</span></label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <textarea id="editor" name="project_description" class="form-control field-validate" rows="5">{{$result['projects']->project_description}}</textarea>
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.EnterProductDetailIn') }}</span>
                                                                    </div>
                                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Start Date</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <input type="date" name="project_startdate" value="{{$result['projects']->project_startdate}}" Placeholder="Enter Address" class="form-control  "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select Start Date</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">End Date</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <input type="date" name="project_enddate" value="{{$result['projects']->project_enddate}}" Placeholder="Enter State" class="form-control "  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select End Date</span>
                                                     </div>
                                                </div>
                                                
                                             


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="project_status">
                                                        <option value="1" @if($result['projects']->project_status==1) selected @endif>{{ trans('labels.Active') }}</option>
                                                        <option value="0" @if($result['projects']->project_status==0) selected @endif>{{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.StatusUnitText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/projects')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Projects Documents </h3>
                             
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                             
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Document</th>
                                            <th>Created On</th>
                                             
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['projectdocs'])>0)
                                            @foreach ($result['projectdocs'] as $key=>$projectdoc)
                                                <tr>
                                                    <td>{{ $projectdoc->id }}</td>
                                                    <td>{{ $projectdoc->document }}
                   <a    href="downloaddocument/{{ $projectdoc->id }}" target="_blank"> Click here to download document</a>                                   
                                                    </td>
                                                    <td>{{ $projectdoc->date }}</td>
                                                     
<!--                                                     <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editproject/{{ $projectdoc->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
<!--                                                         <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteProjectId" project_id ="{{ $projectdoc->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                                        
<!--                                                     </td> -->
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Projects are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Projects Followups </h3>
                             
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                             
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Follow Up</th>
                                            <th>Document</th>
                                            
                                            <th>Created On</th>
                                             
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['projectfollowups'])>0)
                                            @foreach ($result['projectfollowups'] as $key=>$projectfollowup)
                                                <tr>
                                                    <td>{{ $projectfollowup->id }}</td>
                                                    <td>{!! $projectfollowup->project_followup !!}</td>
                                                    <td>{{ $projectfollowup->followup_document }}
    <a href="downloadfollowupdocument/{{ $projectfollowup->id }}" target="_blank"> Click here to download document</a>                                   
                                                    
                                                    </td>
                                                    <td>{{ $projectfollowup->date }}</td>
                                                     
<!--                                                     <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editproject/{{ $projectfollowup->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
<!--                                                         <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteProjectId" project_id ="{{ $projectfollowup->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                                        
<!--                                                     </td> -->
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Projects are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    
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
        </section>
        <!-- /.content -->
    </div>
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
@endsection