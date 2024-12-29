@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Add Job<small> Add Job</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/jobs')}}"><i class="fa fa-dashboard"></i>Job List</a></li>
                <li class="active"> Add Job</li>
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
                            <h3 class="box-title">Add Job</h3>
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

                                            {!! Form::open(array('url' =>'admin/addnewjob', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

 
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Job Title</label>
                                                    <div class="col-sm-10 col-md-10">
                                                        <input type="text" name="job_title" Placeholder="Enter Job Title" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Job Title</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">Job Type</label>
                                                <div class="col-sm-10 col-md-10">
                                                    <select class="form-control field-validate" name="job_type">
                                                        <option value="">Please Select Job Type</option>
                                                        <option value="FullTime">Full Time</option>
                                                        <option value="PartTime">Part Time</option>
                                                        <option value="Contract">Contract</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> Please Select Job Type</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                 </div>
                                            </div>
                                                
                                                
                                                <div class="form-group">
                                             		<label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Description') }}<span style="color:red;">*</span></label>
                                            		<div class="col-sm-10 col-md-10">
                                             			<textarea id="editor" name="description" class="form-control field-validate" rows="5"></textarea>
                                               			<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Job Description</span>
                                                     	<span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                            		</div>
                                      			</div>
                                                
                                                 
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">No. Of Positions</label>
                                                    <div class="col-sm-10 col-md-10">
                                                        <input type="text" name="no_of_positions" Placeholder="Enter No. Of Positions" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter No. Of Positions</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Experience</label>
                                                    <div class="col-sm-10 col-md-10">
                                                        <input type="text" name="experience" Placeholder="Enter Experience" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Experience</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">Location</label>
                                                    <div class="col-sm-10 col-md-10">
                                                        <input type="text" name="location" Placeholder="Enter Location" class="form-control field-validate"  >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Please Enter Location</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                                 

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-10">
                                                    <select class="form-control" name="status">
                                                        <option value="1">{{ trans('labels.Active') }}</option>
                                                        <option value="0">{{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.StatusUnitText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/jobs')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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