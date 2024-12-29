@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Projects <small>Projects List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Projects</li>
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
                            <h3 class="box-title">Projects List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addproject')}}" type="button" class="btn btn-block btn-primary">Add Project</a>
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
                                            <th>Project Name</th>
                                            <th>Project Description</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>{{ trans('labels.Status') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['projects'])>0)
                                            @foreach ($result['projects'] as $key=>$project)
                                                <tr>
                                                    <td>{{ $project->id }}</td>
                                                    <td>{{ $project->clientname }}</td>
                                                    <td>{{ $project->project_name }}</td>
                                                    <td>{!! $project->project_description !!}</td>
                                                     <td>{{ $project->project_startdate }}</td>
                                                      <td>{{ $project->project_enddate }}</td>
                                                    <td>
                                                        @if($project->project_status==1)
                                                            <strong class="badge bg-green">{{ trans('labels.Active') }}</strong>
                                                        @else
                                                            <strong class="badge bg-red">{{ trans('labels.InActive') }}</strong>
                                                        @endif</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editproject/{{ $project->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteProjectId" project_id ="{{ $project->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                      <br>  <a data-toggle="tooltip" data-placement="bottom" title="Add Project Document" id="ProjectDocsId" project_id ="{{ $project->id }}" class="badge bg-blue"><i class="fa fa-plus" aria-hidden="true"></i>Add Project Document</a>
                                                        <br><a data-toggle="tooltip" data-placement="bottom" title="Add Project Followup" id="ProjectFollowupsId" project_id ="{{ $project->id }}" class="badge bg-blue"><i class="fa fa-plus" aria-hidden="true"></i>Add Project Followup</a>
                                                    
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Projects are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['projects']->links()}}
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
            <div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteProjectModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteProjectModalLabel">Delete Client</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deleteproject', 'name'=>'deleteProject', 'id'=>'deleteProject', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'project_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Project?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteProject">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="projectDocsModal" tabindex="-1" role="dialog" aria-labelledby="projectDocsModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="projectDocsModalLabel">Delete Client</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/addprojectdoc', 'name'=>'projectDocs', 'id'=>'projectDocs', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('project_id',  '', array('class'=>'form-control', 'id'=>'projects_id')) !!}
                        <div class="modal-body">
                          <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Document</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <input type="file" name="document" class="form-control document field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select End Date</span>
                                                     </div>
                                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary adddocbutton" id="projectDocs">{{ trans('labels.Add') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            
            
            <div class="modal fade" id="projectFollowupsModal" tabindex="-1" role="dialog" aria-labelledby="projectFollowupsModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="projectFollowupsModalLabel">Delete Client</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/addprojectfollowup', 'name'=>'projectFollowups', 'id'=>'projectFollowups', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('project_id',  '', array('class'=>'form-control', 'id'=>'projectss_id')) !!}
                        <div class="modal-body">
                         <div class="form-group">
                              <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Description') }}<span style="color:red;">*</span></label>
                                
                                 <div class="col-sm-10 col-md-12">
                           <textarea id="editor" name="project_followup" class="form-control  field-validate" rows="5" ></textarea>
                           <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                               {{ trans('labels.EnterProductDetailIn') }}</span>
                                  </div>
                             </div>
                             
                             <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Document</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <input type="file" name="followup_document" class="form-control followupdocument field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Select End Date</span>
                                                     </div>
                                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary addfollowupbutton" id="projectFollowups">{{ trans('labels.Add') }}</button>
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