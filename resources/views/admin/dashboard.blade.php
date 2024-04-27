@extends('admin.layouts.app')
@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="label label-success float-right">Total</span>
                        </div>
                        <h5>Users</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><i class="fa fa-users"></i> {{$total_user}}</h1>
                        <small>Total User</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="label label-success float-right">Total</span>
                        </div>
                        <h5>Campaign</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><i class="fa fa-bullhorn"></i> {{$total_active_campaign}}</h1>
                        <small>Total Active Campaign</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
