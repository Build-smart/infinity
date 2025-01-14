@extends('admin.layout')
@section('content')
<style>
 
.couponproducts_data:hover{

background-color: #00c0ef;
color: #ffffff;
padding:5px;

}

.couponproducts_data{
padding:5px;
}

.coupon_exclude_products_data:hover{

background-color: #00c0ef;
color: #ffffff;
padding:5px;

}

.coupon_exclude_products_data{
padding:5px;
}

</style>



    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.EditCoupons') }} <small>{{ trans('labels.EditCoupons') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/coupons/display')}}"><i class="fa fa-dashboard"></i>All Coupons</a></li>
                <li class="active">{{ trans('labels.EditCoupons') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.EditCoupons') }}</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div  @if ($errors->first() == 'Coupon has been updated successfully!') class="alert alert-success alert-dismissible" @else class="alert alert-danger alert-dismissible" @endif role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif

                                    @if(Session::has('success'))

                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {!! session('success') !!}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info"><br>

                                        @if(count($result['message'])>0)
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{ $result['message'] }}
                                            </div>
                                    @endif

                                    <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/coupons/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            {!! Form::hidden('id',  $result['coupon'][0]->coupans_id)!!}

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Coupon') }} </label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::text('code',  $result['coupon'][0]->code, array('class'=>'form-control field-validate', 'id'=>'code'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.AddCouponsTaxt') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.AddCouponsTaxt') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.CouponDescription') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::textarea('description',  $result['coupon'][0]->description, array('class'=>'form-control', 'rows'=>'5', 'id'=>'description'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CouponDescriptionText') }}</span>
                                                </div>
                                            </div>
                                        <!--<div class="box">
                            <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.EditCoupons') }}</h3>
                            </div>
                            </div>-->
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Discounttype') }} </label>
                                                <div class="col-sm-10 col-md-9">
                                                    <select name="discount_type" class='form-control'>
                                                        <option value="fixed_cart" @if($result['coupon'][0]->discount_type == 'fixed_cart') selected @endif>Cart Discount</option>
                                                        <option value="percent" @if($result['coupon'][0]->discount_type == 'percent') selected @endif>Cart % Discount</option>
                                                        <option value="fixed_product" @if($result['coupon'][0]->discount_type == 'fixed_product') selected @endif>Product Discount</option>
                                                        <option value="percent_product" @if($result['coupon'][0]->discount_type == 'percent_product') selected @endif>Product % Discount</option>
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.DiscounttypeText') }}</span>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.CouponAmount') }}
                                                </label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::text('amount',  $result['coupon'][0]->amount, array('class'=>'form-control', 'id'=>'amount'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CouponAmountText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.AllowFreeShipping') }}</label>
                                                <div class="col-sm-10 col-md-9" style="padding-top: 7px;">
                                                    <label style="margin-bottom:0">
                                                        {!! Form::checkbox('free_shipping', 1, $result['coupon'][0]->free_shipping, ['class' => 'minimal']) !!}
                                                    </label>
                                                    &nbsp; {{ trans('labels.AllowFreeShippingText') }}

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.CouponExpiryDate') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::text('expiry_date',  date('d/m/Y', strtotime($result['coupon'][0]->expiry_date)), array('class'=>'form-control field-validate datepicker', 'id'=>'datepicker', 'readonly'=>'readonly'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CouponExpiryDateText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.CouponExpiryDateText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Minimumspend') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::text('minimum_amount', $result['coupon'][0]->minimum_amount, array('class'=>'form-control', 'placeholder'=>trans('labels.NoMinimum'), 'id'=>'minimum_amount'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.MinimumspendText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.MaximumSpend') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::text('maximum_amount', $result['coupon'][0]->maximum_amount, array('class'=>'form-control', 'placeholder'=>trans('labels.NoMaximum'), 'id'=>'maximum_amount'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.MaximumSpendText') }}</span>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.IndividualUseOnly') }}</label>
                                                <div class="col-sm-10 col-md-9"  style="padding-top: 7px; line-height: 22px;">
                                                    <label  style="margin-bottom: 0px;">
                                                        {!! Form::checkbox('individual_use', 1, $result['coupon'][0]->individual_use, ['class' => 'minimal']) !!}
                                                    </label>
                                                    &nbsp; {{ trans('labels.IndividualUseOnlyText') }}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.ExcludeSaleItems') }}</label>
                                                <div class="col-sm-10 col-md-9"  style="padding-top: 7px; line-height: 22px;">
                                                    <label  style="margin-bottom: 0px;">
                                                        {!! Form::checkbox('exclude_sale_items', 1, $result['coupon'][0]->exclude_sale_items, ['class' => 'minimal']) !!}
                                                    </label>
                                                    &nbsp; {{ trans('labels.ExcludeSaleItemsText') }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                             <label for="name" class="col-sm-2 col-md-2 control-label">Search Products</label>
                                                <div class="col-sm-10 col-md-9  ">
                                           
 									<input type="text" id='products_search_coupon' placeholder="Search Products" class="form-control" autocomplete="OFF">
           
         					    <div id="productList">
  							  </div>   
   							 </div>
  							  </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Products') }}</label>
                                                <div class="col-sm-10 col-md-9 couponProdcuts">
                                                    <select name="product_ids[]" id="selected_products_id" multiple class="form-control select2">
                                                        @foreach($result['products'] as $products)
                                                            <option value="{{ $products->products_id }}" selected>{{ $products->products_name }} </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> Please select all the products in this box </span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                             <label for="name" class="col-sm-2 col-md-2 control-label">Search Exculde Products</label>
                                                <div class="col-sm-10 col-md-9  ">
                                           
 									<input type="text" id='exclude_products_search_coupon' placeholder="Search Products" class="form-control" autocomplete="OFF">
           
         					    <div id="excludeproductList">
  							  </div>   
   							 </div>
  							  </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.ExcludeProducts') }}</label>
                                                <div class="col-sm-10 col-md-9 couponProdcuts">
                                                    <select name="exclude_product_ids[]" id="selected_exclude_products_id" multiple class="form-control select2 ">
                                                        @foreach($result['exclude_products'] as $excludeproducts)
                                                            <option value="{{ $excludeproducts->products_id }}"   selected >{{ $excludeproducts->products_name }}  </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> Please select all the products in this box </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.IncludeCategories') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    <select name="product_categories[]" multiple class="form-control select2">
                                                        @foreach($result['categories'] as $categories)
                                                            <option value="{{ $categories->categories_id }}" @if(in_array($categories->categories_id, explode(',', $result['coupon'][0]->product_categories))) selected @endif>{{ $categories->categories_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.IncludeCategoriesText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.ExcludeCategories') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    <select name="excluded_product_categories[]" multiple class="form-control select2">
                                                        @foreach($result['categories'] as $categories)
                                                            <option value="{{ $categories->categories_id }}" @if(in_array($categories->categories_id, explode(',', $result['coupon'][0]->excluded_product_categories))) selected @endif >{{ $categories->categories_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ExcludeCategoriesText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.EmailRestrictions') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    <select name="email_restrictions[]" multiple class="form-control select2">
                                                        @foreach($result['emails'] as $emails)
                                                            <option value="{{ $emails->email }}"  @if(in_array($emails->email, explode(',', $result['coupon'][0]->email_restrictions))) selected @endif >{{ $emails->email }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.EmailRestrictionsText') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.UsageLimitPerCoupon') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::number('usage_limit', $result['coupon'][0]->usage_limit, array('class'=>'form-control', 'placeholder'=>'Unlimited', 'id'=>'usage_limit'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UsageLimitPerCouponText') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.UsageLimitPerUser') }}</label>
                                                <div class="col-sm-10 col-md-9">
                                                    {!! Form::number('usage_limit_per_user', $result['coupon'][0]->usage_limit_per_user, array('class'=>'form-control', 'placeholder'=>'Unlimited', 'id'=>'usage_limit_per_user'))!!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UsageLimitPerUserText') }}</span>
                                                </div>
                                            </div>

                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/coupons/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
