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
    @can('coupon_code')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">All Coupon Codes</div>
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
                        <form name="filterfrm" action="{{route('admin.AllCoupon')}}" method="GET">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <select name="user" class="form-control select2">
                                        <option value="">-select user-</option>
                                        @if($users)
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" @if($request->query('user')==$user->id)selected @endif>{{$user->name.' - '.$user->phone}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select name="subscription" class="form-control select2">
                                        <option value="">-select subscription plan-</option>
                                        @if($subscriptions)
                                        @foreach($subscriptions as $subscription)
                                        <option value="{{$subscription->id}}" @if($request->query('subscription')==$subscription->id)selected @endif>{{$subscription->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select name="coupon" class="form-control select2">
                                        <option value="">-select coupon code-</option>
                                        @if($coupons)
                                        @foreach($coupons as $coupon)
                                        <option value="{{$coupon->coupon}}" @if($request->query('coupon')==$coupon->coupon)selected @endif>{{$coupon->coupon}}</option>
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
                                    <a href="{{route('admin.AllCoupon')}}" class="btn btn-warning">RESET</a>
                                    <button class="btn btn-info">GET</button>
                                </div>
                            </div>
                        </form>

                        <div class="box-default text-right">
                            <a class="btn btn-bitbucket float-right" href="{{route('admin.createCoupon')}}">Add New</a>
                        </div>
                        <p></p>
                        <table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Issued to</th>
                                    <th>Subscription Plan</th>
                                    <th>Coupon Code</th>
                                    <th>% of Discount</th>
                                    <th>Validity</th>
                                    <th>No. of Used</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($data as $val)
                                @php $totalUsedCouponCode = \App\UserSubscription::where("coupon_code", $val->coupon)->count(); @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>@if($val->user_id>0){{$val->user->name.' - '.$val->user->phone}}@endif</td>
                                    <td>@if($val->subscription_id>0){{$val->subscription->name}}@endif</td>
                                    <td>{{$val->coupon}}</td>
                                    <td>{{$val->discount}}%</td>
                                    <td>{{$val->end_date}}<!-- {{date('Y-m-d',strtotime($val->end_date))}} --><!--{{$val->validity}} Months--></td>
                                    <td>{{$totalUsedCouponCode}}</td>
                                    <td>{{$val->description}}</td>
                                    <td>
                                        <?php if($val->status==1) { ?><a href="<?php echo url('admin/couponcodes/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/couponcodes/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.editCoupon',['id'=> $val->id])}}">Edit</a>
                                        <!-- <a href="{{route('admin.deleteCoupon',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
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
