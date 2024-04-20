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
                <x-admin.back-button route="{{route('admin.roles.index')}}" />
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data" class="form-example" id="add_form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name..." required>
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                @foreach ($permissionParent as $parent)
                                    <div class="col-md-4">
                                        <div class="card card-outline card-primary mt-4">
                                            <div class="card-header">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="all_{{ $parent->parent_name }}">
                                                    <label for="all_{{ $parent->parent_name }}">
                                                        <h5 class="card-title">
                                                            {{ ucwords(str_replace('-', ' ', ucwords(str_replace('_', ' ', $parent->parent_name)))) }}
                                                        </h5>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="card-body" style="height: 200px; overflow-x: hidden;">
                                                @php $permission = Spatie\Permission\Models\Permission::where('parent_name', $parent->parent_name)->get(); @endphp
                                                @foreach ($permission as $value)
                                                    <div class="icheck-danger mb-2">
                                                        <input type="checkbox" name="permission[]" id="roles_{{ $value->name }}" class="roles_{{ $parent->parent_name }}" value="{{ $value->id }}">
                                                        <label for="roles_{{ $value->name }}">
                                                            {{ ucwords(str_replace('-', ' ', ucwords(str_replace('_', ' ', $value->name)))) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#all_{{ $parent->parent_name }}').change(function() {
                                            $('.roles_{{ $parent->parent_name }}').prop('checked', this.checked);
                                        });
                                        $('.roles_{{ $parent->parent_name }}').change(function() {
                                            if ($('.roles_{{ $parent->parent_name }}:checked').length == $('.roles_{{ $parent->parent_name }}').length) {
                                                $('#all_{{ $parent->parent_name }}').prop('checked', true);
                                            } else {
                                                $('#all_{{ $parent->parent_name }}').prop('checked', false);
                                            }
                                        });
                                    </script>
                                @endforeach
                                <div class="col-md-12 text-center mt-4">
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
