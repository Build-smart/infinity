@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Promotional Banners<small>Promotional Banners List...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">Promotional Banners</li>
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
                            <h3 class="box-title">Promotional Banners List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addpromotionalbannerimage')}}" type="button" class="btn btn-block btn-primary">Add Promotional Banner</a>
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
                      <th>{{ trans('labels.ID') }}</th>
                      <th>Category</th>
                      <th>Website Promotioanl Banner Image</th>
                      <th>App Promotioanl Banner Image</th>
                      <th>Added Date</th>
                       <th>{{ trans('labels.Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($result['promotionalbanners'])>0)
                    @foreach ($result['promotionalbanners'] as $key=>$promotionalbanner)
                        <tr>
                            <td>{{ $promotionalbanner->id }}</td>
                          
								<td>{{ $promotionalbanner->categories_name }}</td>

                            <td><img src="{{asset('').$promotionalbanner->web_path}}" alt="" width=" 200px"></td>
       <td><img src="{{asset('').$promotionalbanner->app_path}}" alt="" width=" 200px"></td>
                             
					<td>{{ $promotionalbanner->date_added }}</td>

                            
                            <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editpromotionalbanner/{{ $promotionalbanner->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                             <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deletePromotionalBannerId" promotionalbanner_id ="{{ $promotionalbanner->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </tr>
                    @endforeach
                    @else
                       <tr>
                            <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{--$result['promotionalbanners']->links('vendor.pagination.default')--}}
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

    <!-- deleteSliderModal -->
	<div class="modal fade" id="deletePromotionalBannerModal" tabindex="-1" role="dialog" aria-labelledby="deletePromotionalBannerModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deletePromotionalBannerModalLabel">Delete Promotional Banner</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deletepromotionalbanner', 'name'=>'deletePromotionalBanner', 'id'=>'deletePromotionalBanner', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'promotionalbanner_id')) !!}
		  <div class="modal-body">
			  <p> Are you sure you want to delete this Promotional Banner?</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary" id="deletePromotionalBanner">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection
