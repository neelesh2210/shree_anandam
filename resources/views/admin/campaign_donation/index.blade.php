@extends('admin.layouts.app')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-6">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.dashboard')}}">Dashboard</a>
                </li>
                @isset($page_title)
                    <li class="breadcrumb-item active">
                        <strong>{{$page_title}}</strong>
                    </li>
                @endisset
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <form action="{{route('admin.users.index')}}" id="search_form">
                            <div class="row">
                                <div class="col-sm-3 m-b-xs">
                                    <div class="form-group date_range">
                                        <label class="font-normal">Date</label>
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" class="form-control-sm form-control" name="search_start_date" placeholder="--/--/----" value="{{$search_start_date}}" onchange="fillter()">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control-sm form-control" name="search_end_date" placeholder="--/--/----" value="{{$search_end_date}}" onchange="fillter()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 m-b-xs">
                                    <label for="search_campaign">Campaign</label>
                                    <div class="input-group">
                                        <select name="search_campaign" class="form-control select2" onchange="fillter()">
                                            <option value="">All</option>
                                            @foreach (App\Models\Campaign::oldest('title')->get() as $campaign)
                                                <option value="{{$campaign->id}}">{{$campaign->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 m-b-xs">
                                    <label for="search_payment_status">Payment Status</label>
                                    <div class="input-group">
                                        <select name="search_payment_status" class="form-control" onchange="fillter()">
                                            <option value="">All</option>
                                            <option value="initiated">Initiated</option>
                                            <option value="success">Success</option>
                                            <option value="failed">Failed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 m-b-xs" style="padding:0px 0px 0px 0px">
                                    <label for="search_key">Search</label>
                                    <div class="input-group">
                                        <input placeholder="Search..." type="text" name="search_key" id="search_key" value="{{$search_key}}" class="form-control form-control-sm" onkeyup="fillter()">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-sm btn-primary dim">Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="table_div">
                            @include('admin.campaign_donation.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')

        <script>

            function fillter(){
                $('.tbody').addClass('loading')
                var route = "{{route('admin.campaign.donation')}}";
                var form = $('#search_form').serialize();
                $.ajax({
                    type: 'GET',
                    url: "{{route('admin.campaign.donation')}}",
                    data: $('#search_form').serialize(),
                    success: function(data) {
                        window.history.pushState("", "", route+'?'+form);
                        $('.tbody').removeClass('loading');
                        $('#table_div').html(data);
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                });
            }

        </script>

    @endpush

@endsection
