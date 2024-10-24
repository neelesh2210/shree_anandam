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
        <div class="col-6">
            <div class="mt-3 text-right">
                <x-admin.add-button route="{{route('admin.image.create')}}" text="Add Image"/>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        {{-- <form action="{{route('admin.campaigns.index')}}" id="search_form">
                            <div class="row">
                                <div class="col-sm-6 m-b-xs"></div>
                                <div class="col-sm-3 m-b-xs">
                                    <label for="search_verify_status">Active/Inactive</label>
                                    <div class="input-group">
                                        <select name="search_is_active" class="form-control" onchange="fillter()">
                                            <option value="">All</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 m-b-xs" style="padding:0px 0px 0px 0px">
                                    <label for="search_key">Search</label>
                                    <div class="input-group">
                                        <input placeholder="Title..." type="text" name="search_key" id="search_key" value="{{$search_key}}" class="form-control form-control-sm" onkeyup="fillter()">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-sm btn-primary dim">Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                        <div id="table_div">
                            @include('admin.image.table')
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
                var route = "{{route('admin.image.index')}}";
                var form = $('#search_form').serialize();
                $.ajax({
                    type: 'GET',
                    url: route,
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
