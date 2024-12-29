@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.AddProduct') }} <small>{{ trans('labels.AddProduct') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/products/display')}}"><i class="fa fa-database"></i> {{ trans('labels.ListingAllProducts') }}</a></li>
            <li class="active">{{ trans('labels.AddProduct') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.AddNewProduct') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                            {{ $error }}
                                        </div>
                                        @endforeach
                                        @endif

                                        {!! Form::open(array('url' =>'admin/products/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                        <div class="row">
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Product Type') }}<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control field-validate prodcust-type" name="products_type" onChange="prodcust_type();">
                                                            <option value="">{{ trans('labels.Choose Type') }}</option>
                                                            <option value="0">{{ trans('labels.Simple') }}</option>
                                                            <option value="1">{{ trans('labels.Variable') }}</option>
                                                            <!--option value="2">{{ trans('labels.External') }}</option--->
                                                        </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.Product Type Text') }}.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                                  
                                           <div class="col-xs-12 col-md-6">
                                                <div class="form-group" id="location_id">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('Product Location') }} <span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control field-validate" name="location_id">
                                                            <option value="">{{ trans('Select Location') }}</option>
                                                            @foreach ($result['locations'] as $locations)
                                                            <option value="{{ $locations->id }}">{{ $locations->location_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('Choose Location') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('Select  Locaion') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        
                                            
                                          <div class="row">  
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">Product Segment<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control field-validate" name="product_segment" >
                                                            <option value="">Choose Segment</option>
                                                            <option value="ECONOMY">ECONOMY</option>
                                                            <option value="STANDARD">STANDARD</option>
                                                            <option value="PREMIUM">PREMIUM</option>
                                                        </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            Please choose product segment...</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Manufacturers') }} <span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control field-validate" name="manufacturers_id">
                                                            <option value="">{{ trans('labels.ChooseManufacturers') }}</option>
                                                            @foreach ($result['manufacturer'] as $manufacturer)
                                                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                                            @endforeach
                                                        </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ChooseManufacturerText') }}.</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                               <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">Distributors <span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control field-validate" name="distributor_id">
                                                            <option value="">Choose Distributors </option>
                                                            @foreach ($result['distributors'] as $distributor)
                                                            <option value="{{ $distributor->id }}">{{ $distributor->first_name }}</option>
                                                            @endforeach
                                                        </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            Please Choose Distributor</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                             <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsPrice') }}<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::text('products_price', '', array('class'=>'form-control products_price products_price_distributor number-validate', 'id'=>'products_price')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ProductPriceText') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.ProductPriceText') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">Distributor Product Price Percentage<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::text('distributor_product_price_percentage', '', array('class'=>'form-control number-validate distributor_product_price_percentage', 'id'=>'distributor_product_price_percentage')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ProductPriceText') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.ProductPriceText') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">Distributor Product Price<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::text('distributor_product_price', '', array('class'=>'form-control number-validate', 'readonly', 'id'=>'distributor_product_price')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ProductPriceText') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.ProductPriceText') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        
                                        
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Category') }}<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-9">
                                                        <?php print_r($result['categories']); ?>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ChooseCatgoryText') }}.</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.IsFeature') }} </label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control" name="is_feature">
                                                            <option value="0">{{ trans('labels.No') }}</option>
                                                            <option value="1">{{ trans('labels.Yes') }}</option>
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.IsFeatureProuctsText') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control" name="products_status">
                                                            <option value="1">{{ trans('labels.Active') }}</option>
                                                            <option value="0">{{ trans('labels.Inactive') }}</option>
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.SelectStatus') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                      <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="hsn_sac_code" class="col-sm-2 col-md-3 control-label">HSN/SAC Code<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::text('hsn_sac_code', '', array('class'=>'form-control field-validate', 'id'=>'hsn_sac_code')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                           Enter HSN/SAC Code
                                                        </span>
                                                        <span class="help-block hidden">Enter HSN/SAC Code</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group" id="tax-class">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TaxClass') }}<span style="color:red;">*</span> </label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control field-validate" name="tax_class_id">
                                                            <option value="">{{ trans('labels.SelectTaxClass') }}</option>
                                                            @foreach ($result['taxClass'] as $taxClass)
                                                            <option value="{{ $taxClass->tax_class_id }}">{{ $taxClass->tax_class_title }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ChooseTaxClassForProductText') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.SelectProductTaxClass') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Min Order Limit') }}</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::text('products_min_order', '1', array('class'=>'form-control field-validate number-validate', 'id'=>'products_min_order')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.Min Order Limit Text') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.Min Order Limit Text') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Max Order Limit') }}</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::text('products_max_stock', '', array('class'=>'form-control ', 'id'=>'products_max_stock')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.Max Order Limit Text') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.Max Order Limit Text') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsWeight') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        {!! Form::text('products_weight', '', array('class'=>'form-control', 'id'=>'products_weight')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.RequiredTextForWeight') }}
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-10 col-md-4" style="padding-left: 0;">
                                                        <select class="form-control" name="products_weight_unit">
                                                            @if($result['units'] !== null)
                                                            @foreach($result['units'] as $unit)
                                                            <option value="{{$unit->units_name}}">{{$unit->units_name}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsModel') }}</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::text('products_model', '', array('class'=>'form-control', 'id'=>'products_model')) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ProductsModelText') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-md-6 ">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}<span style="color:red;">*</span></label>
                                                   
                                                    
                                                   
                                                    <div class="col-sm-10 col-md-8">
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
                                                        <span class="help-block img-help-block" style="font-weight: normal;font-size: 20px;margin-bottom: 0;">{{ trans('labels.UploadProductImageText') }}</span>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.VideoEmbedCodeLink') }}</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        {!! Form::textarea('products_video_link', '', array('class'=>'form-control', 'id'=>'products_video_link', 'rows'=>4)) !!}
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.VideoEmbedCodeLinkText') }}
                                                        </span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">Assured By </label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control" name="assured_by">
                                                        <option value="">Select Assured By</option>
                                                            <option value="BM">BM ASSURED</option>
                                                           
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            Select Assured By</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>


                                        <div class="row">
                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group flash-sale-link">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSale') }}</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control" onChange="showFlash();" name="isFlash" id="isFlash">
                                                            <option value="no">{{ trans('labels.No') }}</option>
                                                            <option value="yes">{{ trans('labels.Yes') }}</option>
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.FlashSaleText') }}</span>
                                                    </div>
                                                </div>

                                                <div class="flash-container" style="display: none;">
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSalePrice') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <input class="form-control" type="text" name="flash_sale_products_price" id="flash_sale_products_price" value="">
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.FlashSalePriceText') }}</span>
                                                            <span class="help-block hidden">{{ trans('labels.FlashSalePriceText') }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSaleDate') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <input class="form-control datepicker" readonly type="text" name="flash_start_date" id="flash_start_date" readonly value="">
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.FlashSaleDateText') }}</span>
                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                        </div>
                                                        <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                                                            <input type="text" class="form-control timepicker" name="flash_start_time" readonly id="flash_start_time" value="">
                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashExpireDate') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-4">
                                                            <input class="form-control datepicker" readonly type="text" readonly name="flash_expires_date" id="flash_expires_date" value="">
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.FlashExpireDateText') }}</span>
                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                        </div>
                                                        <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                                                            <input type="text" class="form-control timepicker" readonly name="flash_end_time" id="flash_end_time" value="">
                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <select class="form-control" name="flash_status">
                                                                <option value="1">{{ trans('labels.Active') }}</option>
                                                                <option value="0">{{ trans('labels.Inactive') }}</option>
                                                            </select>
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.ActiveFlashSaleProductText') }}</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-md-6">
                                                <div class="form-group special-link">
                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Special') }}</label>
                                                    <div class="col-sm-10 col-md-8">
                                                        <select class="form-control" onChange="showSpecial();" name="isSpecial" id="isSpecial">
                                                            <option value="no">{{ trans('labels.No') }}</option>
                                                            <option value="yes">{{ trans('labels.Yes') }}</option>
                                                        </select>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.SpecialProductText') }}.</span>
                                                    </div>
                                                </div>

                                                <div class="special-container" style="display: none;">
                                                   <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">Special Price Percentage<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <input class="form-control special_price_percentage" type="text" name="specials_new_products_price_percentage"  id="special_price_percentage" value="">
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.SpecialPriceTxt') }}.</span>
                                                            <span class="help-block hidden">Special products price percentage of deals. Please enter a numberic value.</span>
                                                        </div>
                                                    </div>
                                                   
                                                   
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SpecialPrice') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-8"> 
                                                            <input class="form-control" type="text" name="specials_new_products_price" readonly id="special_price" value="">
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.SpecialPriceTxt') }}.</span>
                                                            <span class="help-block hidden">{{ trans('labels.SpecialPriceNote') }}.</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ExpiryDate') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <input class="form-control datepicker" readonly readonly type="text" name="expires_date" id="expiry-date" value="">
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.SpecialExpiryDateTxt') }}
                                                            </span>
                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <select class="form-control" name="status">
                                                                <option value="1">{{ trans('labels.Active') }}</option>
                                                                <option value="0">{{ trans('labels.Inactive') }}</option>
                                                            </select>
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.ActiveSpecialProductText') }}.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="tabbable tabs-left">
                                                    <ul class="nav nav-tabs">
                                                        @foreach($result['languages'] as $key=>$languages)
                                                        <li class="@if($key==0) active @endif"><a href="#product_<?=$languages->languages_id?>" data-toggle="tab"><?=$languages->name?><span style="color:red;">*</span></a></li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach($result['languages'] as $key=>$languages)

                                                        <div style="margin-top: 15px;" class="tab-pane @if($key==0) active @endif" id="product_<?=$languages->languages_id?>">
                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductName') }}<span style="color:red;">*</span> ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="products_name_<?=$languages->languages_id?>" class="form-control field-validate">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.EnterProductNameIn') }} {{ $languages->name }} </span>
                                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group external_link" style="display: none">
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.External URL') }} ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="products_url_<?=$languages->languages_id?>" class="form-control products_url">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.External URL Text') }} {{ $languages->name }} </span>
                                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }}<span style="color:red;">*</span> ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <textarea id="editor<?=$languages->languages_id?>" name="products_description_<?=$languages->languages_id?>" class="form-control" rows="5"></textarea>
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.EnterProductDetailIn') }} {{ $languages->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <span>{{ trans('labels.Save_And_Continue') }}</span>
                                                <i class="fa fa-angle-right 2x"></i>
                                            </button>
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
        @foreach($result['languages'] as $languages)
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor{{$languages->languages_id}}');

        @endforeach

        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

    });
</script>

 


<script>
    $(document).ready(function () {
 
 
        $(document).on('keyup', ".special_price_percentage", function () {

 
            
            let specialpricepercentage = $(this);
            
           let specialprice =$('#products_price').val() - $('#products_price').val() * $('#special_price_percentage').val()/100;

        
       	  $( '#special_price').val(specialprice.toFixed(2));

  
            
        });

  $(document).on('keyup', ".products_price", function () {
  
            let specialpricepercentage = $(this);
            
           let specialprice =$('#products_price').val() - $('#products_price').val() * $('#special_price_percentage').val()/100;

        
       	  $( '#special_price').val(specialprice.toFixed(2));

  
            
        });
        
        
        
        

  $(document).on('keyup', ".distributor_product_price_percentage", function () {

	   
      let distributorproductpricepercentage = $(this);
      
     let distributorproductprice =$('#products_price').val() - $('#products_price').val() * $('#distributor_product_price_percentage').val()/100;
 
  
 	  $( '#distributor_product_price').val(distributorproductprice.toFixed(2));


      
  });

  $(document).on('keyup', ".products_price_distributor", function () {
	  
      let distributorproductpricepercentage = $(this);
      
     let distributorproductprice =$('#products_price').val() - $('#products_price').val() * $('#distributor_product_price_percentage').val()/100;

  
 	  $( '#distributor_product_price').val(distributorproductprice.toFixed(2));


      
  });

       
    });

</script>



@endsection
