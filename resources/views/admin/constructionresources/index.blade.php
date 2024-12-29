@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>  Construction Resources <small>Construction Resources List...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> Construction Resources</li>
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
                            <h3 class="box-title">Construction Resources List </h3>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/addconstructionresource')}}" type="button" class="btn btn-block btn-primary">Add Construction Resource</a>
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
                                             
                                            <th>City</th>
                                            <th>Material Quality</th>
                                            <th>Cement</th>
                                            <th>Steel</th>
                                            <th>Bricks</th>
                                            <th>Aggregate</th>
                                            <th>Sand</th>
                                            <th>Flooring</th>
                                            <th>Windows</th>
                                            <th>Doors</th>
                                            <th>Electrical Fittings</th>
                                            <th>Painting</th>
                                            <th>Sanitary Fitting</th>
                                            <th>Kitchen Work</th>
                                            <th>Contractor Charges</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($result['constructionresources'])>0)
                                            @foreach ($result['constructionresources'] as $key=>$constructionresource)
                                                <tr>
                                                    
                                                    <td>{{ $constructionresource->city }}</td>
                                                    <td>{{ $constructionresource->materialquality }}</td>
                                                    <td>{{ $constructionresource->cement }}</td>
                                                    <td>{{ $constructionresource->steel }}</td>
                                                    <td>{{ $constructionresource->bricks }}</td>
                                                    <td>{{ $constructionresource->aggregate }}</td>
                                                    <td>{{ $constructionresource->sand }}</td>
                                                    <td>{{ $constructionresource->flooring }}</td>
                                                    <td>{{ $constructionresource->windows }}</td>
                                                    <td>{{ $constructionresource->doors }}</td>
                                                    <td>{{ $constructionresource->electricalfittings }}</td>
                                                    <td>{{ $constructionresource->painting }}</td>
                                                    <td>{{ $constructionresource->sanitaryfitting }}</td>
                                                    <td>{{ $constructionresource->kitchenwork }}</td>
                                                    <td>{{ $constructionresource->contractorcharges }}</td>
                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editconstructionresource/{{ $constructionresource->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteConstructionResourceId" constructionresource_id ="{{ $constructionresource->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3"  style="text-transform:none"><strong>Construction Resources are not added yet</strong></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 text-right">
                                        {{$result['constructionresources']->links()}}
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
            <div class="modal fade" id="deleteConstructionResourceModal" tabindex="-1" role="dialog" aria-labelledby="deleteConstructionResourceModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteConstructionResourceModalLabel">Delete Construction Resource</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/deleteconstructionresource', 'name'=>'deleteConstructionResource', 'id'=>'deleteConstructionResource', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'constructionresource_id')) !!}
                        <div class="modal-body">
                          Are you sure you want to delete this Construction Resource?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteClient">{{ trans('labels.Delete') }}</button>
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
@endsection