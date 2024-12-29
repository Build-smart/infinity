@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Add Promotional Banner <small>Promotional Banner...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/promotionalbanners')}}"><i class="fa fa-bars"></i>Promotional Banners List </a></li>
      <li class="active">Add Promotional Banner</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <style>
      .selectedthumbnail {
          display: block;
          margin-bottom: 10px;
          padding: 0;
      }
      .thumbnail {
          padding: 0;
      }
      .closimage{
        position: relative
      }
      </style>

    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Add Promotional Banner</h3>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <br>
                        @if (count($errors) > 0)
                              @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  {{$errors->first()}}
                                </div>
                              @endif
                          @endif

                        <!-- form start -->
                         <div class="box-body">

                            {!! Form::open(array('url' =>'admin/addNewpromotionalbanner', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                            	<div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Categories</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate" name="category_id">
                                       <option value="">Select Category</option>
                                          @foreach($result['categories'] as $category)
                                              <option value="{{$category->id}}">{{ $category->name }}</option>
                                          @endforeach
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      Select Category</span>
                                  </div>
                                </div>
                                 

                                <div class="form-group" id="imageIcone">
                                    <label for="name" class="col-sm-2 col-md-3 control-label">Website Promotional Banner </label>
                                    <div class="col-sm-10 col-md-4">
                                        <!-- Modal -->
                                        <div class="modal fade embed-images" id="ModalmanufacturedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">Ã—</span></button>
                                                        <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Slider Image') }} </h3>
                                                    </div>
                                                    <div class="modal-body manufacturer-image-embed">
  														<ul class="thumbnails image_picker_selector" id="image_post_data">
                                                                    
                                                                        
                                                      </ul>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                        <button type="button" class="btn btn-default" id="imagerefresh" >Refresh</button>
                                                        <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="imageselectedtwo">
                                          {!! Form::button(trans('labels.Add Image'), array('id'=>'newIcon','class'=>"btn btn-primary field-validate", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )) !!}
                                          <br>
                                           <input type="hidden"   id="selectedimage_id" name="image_id"  >
                                                         
                                          <div id="selectedthumbnailIcon" style="display:none" class="selectedthumbnail col-md-12"> </div>
                                            <div class="closimage">
                                                <button type="button" class="close pull-left image-close " id="image-Icone"
                                                style="display:none; position: absolute;left: -3px !important;top: 15px !important;background-color: black;color: white;opacity: 2.2;" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                       

                                        <br>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group"  >
                                            <label for="name" class="col-sm-2 col-md-3 control-label">App Promotional Banner </label>
                                            <div class="col-sm-10 col-md-4">
                                              
                                                <!-- Modal -->
                                                <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content"  >
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">X</span></button>
                                                                        <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }}</h3>
                                                                    </div>
                                                                    <div class="modal-body manufacturer-image-embed"  >
                                                                           <ul class="thumbnails image_picker_selector" id="post_data">
                                                                    
                                                                        
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal-footer">

                                                                        <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left">{{ trans('labels.Add Image') }}</a>
                                                                        <button type="button"  id="load" class="btn btn-default  ">Refresh</button>
                                                                        <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">Done</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                
                                                 
                                                <div id="imageselected">
                                                          {!! Form::button( trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary field-validate", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                                          <br>
                                                          
                                                          <input type="hidden"   id="product_id" name="app_image_id"  >
                                                          
                                                          <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                                          <div class="closimage">
                                                              <button type="button" class="close pull-left image-close " id="image-close"
                                                                style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                              </button>
                                                          </div>
                                                        </div>
                                             </div>
                                        </div>

                   
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                <a href="{{ URL::to('admin/sliders')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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

@endsection
