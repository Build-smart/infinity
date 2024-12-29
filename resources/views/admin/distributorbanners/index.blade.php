@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Distributor {{ trans('labels.Banners') }} <small>Listing All The Distributor Banners......</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Distributor {{ trans('labels.Banners') }}</li>
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
                          <h3 class="box-title">  Distributor Banners</h3> 

                             
                            <div class="box-tools pull-right">
                                <a href="{{url('admin/distributorbanners/add')}}" type="button" class="btn btn-block btn-primary">Add New Distributor Banner</a>
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
                                            <th>@sortablelink('distributorbanners_id', trans('labels.ID') )</th>
                                            <th>@sortablelink('distributorbanners_title', trans('labels.Title') )</th>
                                            <th> Position</th>
                                            <th>{{ trans('labels.Image') }}</th>
                                            <th>@sortablelink('created_at', trans('labels.AddedModifiedDate') )</th>
                                            
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['distributorbanners'])>0)
                                            @php $resultitems['distributorbanners']  = $result['distributorbanners']->unique('distributorbanners_id');@endphp
                                            @foreach ($resultitems['distributorbanners'] as $key=>$distributorbanners)
                                                <tr>
                                                    <td>{{ $distributorbanners->distributorbanners_id }}</td>
                                                    <td>{{ $distributorbanners->distributorbanners_title }}</td>
                                                     <td>{{ $distributorbanners->display_position }}</td>
                                                    <td><img src="{{asset($distributorbanners->path)}}" alt="" width=" 100px"></td>
                                                    <td><strong>{{ trans('labels.AddedDate') }}: </strong> {{ date('d M, Y', strtotime($distributorbanners->created_at)) }}<br>
                                                        <strong>{{ trans('labels.ModifiedDate') }}: </strong>@if(!empty($distributorbanners->updated_at)) {{ date('d M, Y', strtotime($distributorbanners->updated_at)) }}  @endif<br>
                                                        <strong>{{ trans('labels.ExpiryDate') }}: </strong>@if(!empty($distributorbanners->expires_date)) {{ date('d M, Y', strtotime($distributorbanners->expires_date)) }}  @endif</td>

                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="{{url('admin/distributorbanners/edit')}}/{{ $distributorbanners->distributorbanners_id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteDistributorBannerId" distributorbanners_id ="{{ $distributorbanners->distributorbanners_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

                                        {!! $result['distributorbanners']->appends(\Request::except('page'))->render() !!}
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

            <!-- deleteBannerModal -->
            <div class="modal fade" id="deleteDistributorBannerModal" tabindex="-1" role="dialog" aria-labelledby="deleteDistributorBannerModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteDistributorBannerModalLabel">Delete Distributor Banner</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/distributorbanners/delete', 'name'=>'deleteDistributorBanner', 'id'=>'deleteDistributorBanner', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('distributorbanners_id',  '', array('class'=>'form-control', 'id'=>'distributorbanners_id')) !!}
                        <div class="modal-body">
                            <p>Are you sure you want to delete this Distributor Banner?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteDistributorBanner">{{ trans('labels.Delete') }}</button>
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
