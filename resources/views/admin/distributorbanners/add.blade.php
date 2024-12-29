@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Add Distributor Banner <small>Add Distributor Banner...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/distributorbanners')}}"><i class="fa fa-bars"></i> List All Distributor Banners</a></li>
                <li class="active">Add Distributor Banner</li>
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
                            <h3 class="box-title">Add Distributor Banner</h3>
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

                                            {!! Form::open(array('url' =>'admin/distributorbanners/insert', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Title') }} </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('distributorbanners_title', '', array('class'=>'form-control field-validate','id'=>'distributorbanners_title')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.BannerTitletext') }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">Position</label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <select class="form-control" name="position">
                                                                <option value="TOP">TOP</option>
                                                                <option value="BOTTOM">BOTTOM</option>
                                                            </select>
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                Please Select Position</span>
                                                        </div>
                                                    </div>

                                            <div class="form-group"  >
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}</label>
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
                                                          
                                                          <input type="hidden"   id="product_id" name="image_id"  >
                                                          
                                                          <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                                          <div class="closimage">
                                                              <button type="button" class="close pull-left image-close " id="image-close"
                                                                style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                              </button>
                                                          </div>
                                                        </div>
                                                    <span class="help-block img-help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ImageText') }}</span>

                                                    <br>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Type') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="type" id="bannerType" onchange="bannerstypes()">
                                                        <option value="category">{{ trans('labels.ChooseSubCategory') }}</option>
<!--                                                         <option value="product">{{ trans('labels.Product') }}</option> -->
                                                        <option value="top seller">{{ trans('labels.TopSeller') }}</option>
                                                        <option value="deals">{{ trans('labels.Deals') }}</option>
                                                        <option value="most liked">{{ trans('labels.MostLiked') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                        {{ trans('labels.AddBannerText') }}</span>
                                                </div>
                                            </div>

                                        <!--<div class="form-group banner-link">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Banners Link </label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('banners_url', '', array('class'=>'form-control','id'=>'banners_url')) !!}
                                                </div>
                                              </div>-->

                                            <div class="form-group categoryContent">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Categories') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="categories_id" id="categories_id">
                                                        @foreach($result['categories'] as $category)
                                                            <option value="{{ $category->id}}">{{ $category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.CategoriesbannerText') }}</span>
                                                </div>
                                            </div>

<!--                                             <div class="form-group productContent" styl e="display: none"> -->
<!--                                                 <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Products') }}</label> -->
<!--                                                 <div class="col-sm-10 col-md-4"> -->
<!--                                                     <select class="form-control" name="products_id" id="products_id"> -->
<!--                                                         @ foreach($  result [ ' pr odu cts ' ]  as $ pr oduct s_ dat a) -->
<!--                                                             <option value="{ { $products_data->products_id }}">{ { $products_data->products_name }}</option> -->
<!--                                                         @ endforeach -->
<!--                                                     </select> -->
<!--                                                     <span class="help-block" sty le="font-weight: normal;font-size: 11px;margin-bottom: 0;"> -->
<!--                                       {{ trans('labels.ProductsBannerText') }}</span> -->
<!--                                                 </div> -->
<!--                                             </div> -->



                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ExpiryDate') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input readonly class="form-control datepicker field-validate" type="text" name="expires_date" value="">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ExpiryDateBanner') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control" name="status">
                                                        <option value="1">{{ trans('labels.Active') }}</option>
                                                        <option value="0">{{ trans('labels.InActive') }}</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.StatusBannerText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/distributorbanners')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
