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
                <x-admin.back-button route="{{route('admin.staffs.index')}}" />
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <form action="{{ route('admin.staffs.store') }}" method="POST" id="add_form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email..." required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Role <span class="text-danger">*</span></label>
                                        <select name="roles[]" class="form-control select2" multiple data-placeholder="Select Roles...">
                                            @foreach ($roles as $role)
                                                <option value="{{$role}}">{{$role}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Enter Password..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="c_password">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" id="c_password" class="form-control" name="confirm-password" placeholder="Enter Confirm Password..." required>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="form-group">
                                        <x-admin.save-button />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
