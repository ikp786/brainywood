@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('javascript')
    <script>
        jQuery(document).ready(function($) {
            var dt = $('#courses').DataTable();
            var export_filename = 'Filename-' + tools.date( '%d-%M-%Y' );
            new $.fn.dataTable.Buttons( dt, {
                buttons: [
                    {
                        text: '<i class="fa fa-lg fa-print"></i> Print Assets',
                        extend: 'print',
                        className: 'btn btn-primary btn-sm m-5 width-140 assets-select-btn export-print'
                    }
                ]
            } );

            // Add the Print button to the toolbox
            dt.buttons( 1, null ).container().appendTo( '#anrbtn' );
        } );
    </script>
@endsection

@section('content')

    {{--section for instructor--}}
    @can('liveclasses')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">All Live Classes Notify Requests</div>
                    <div class="panel-body">
                        @if(Session::has('msg'))
                            <div class="alert alert-info">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong>{!!Session::get('msg')!!}</strong>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form name="filterfrm" action="{{route('admin.NotifyLiveclasses')}}" method="GET">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <select name="live_class" class="form-control select2">
                                        <option value="">-select live class-</option>
                                        @if($liveClasses)
                                        @foreach($liveClasses as $liveClass)
                                        <option value="{{$liveClass->id}}" @if($request->query('live_class')==$liveClass->id)selected @endif>{{$liveClass->title}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="date" name="from" class="form-control" value="@if($request->query('from')){{$request->query('from')}}@endif">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="date" name="to" class="form-control" value="@if($request->query('to')){{$request->query('to')}}@endif">
                                </div>
                                <div class="form-group col-md-2">
                                    <a href="{{route('admin.NotifyLiveclasses')}}" class="btn btn-warning">RESET</a>
                                    <button class="btn btn-info">GET</button>
                                </div>
                            </div>
                        </form>

                        <div class="box-default text-right">
                            <!-- <a class="btn btn-bitbucket float-right" href="{{route('admin.createLiveclass')}}">Add New Live Class</a> -->
                        </div>
                        <p></p>
                        <table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Request By</th>
                                    <th>Live Class Title</th>
                                    <th>Start DateTime</th>
                                    <th>End DateTime</th>
                                    <!-- <th>Status</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($data as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>@if($val->user_id>0){{$val->user->name.' - '.$val->user->phone}}@endif</td>
                                    <td>@if($val->class_id>0){{$val->liveclass->title}}@endif</td>
                                    <td>@if($val->class_id>0){{$val->liveclass->class_time}}@endif</td>
                                    <td>@if($val->class_id>0){{$val->liveclass->end_time}}@endif</td>
                                    <!-- <td>
                                        <?php if($val->status==1) { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Deactive</a> <?php } else { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Active</a> <?php } ?>
                                    </td> -->
                                    <td>
                                        <a href="{{route('admin.sendLiveclass',['id'=> $val->id])}}">Send Notification</a>
                                        <!-- <a href="{{route('admin.deleteLiveclass',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
                                    </td>
                                </tr>
                                  <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    {{--end section for instructor--}}

@endsection
