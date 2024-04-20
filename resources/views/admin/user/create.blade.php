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
                <x-admin.back-button route="{{route('admin.users.index')}}" />
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data" class="form-example" id="add_form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter Name..." required>
                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <input type="number" name="phone_number" class="form-control" value="{{old('phone_number')}}" placeholder="Enter Phone Number..." required>
                                        @error('phone_number')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" placeholder="Enter Address..." required>{{old('address')}}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <div class="input-group m-b">
                                            <input type="password" name="password" id="user_password" placeholder="Enter Password..." class="form-control" required>
                                            <div class="input-group-append">
                                                <span class="input-group-addon cursor-pointer" id="toggle-user-password"><i class="fa fa-eye"></i></span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Referrer Code</label>
                                        <input type="text" name="referrer_code" class="form-control" value="{{old('referrer_code')}}" placeholder="Enter Referrer Code...">
                                        @error('referrer_code')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <div class="custom-file">
                                            <input id="image" type="file" name="image" class="custom-file-input">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        <img id="img1" src="{{asset('backend/assets/image/no-image.png')}}" alt="" class="mt-2" height="100px" width="100px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';"><br>
                                        @error('image')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div> --}}
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

    @push('js')
        <script>
            // image.onchange = evt => {
            //     const [file] = image.files
            //     if (file) {
            //         img1.src = URL.createObjectURL(file)
            //     }
            // }

            $('#toggle-user-password').click(function(){
                $(this).children().toggleClass('fa fa-eye fa fa-eye-slash');
                let input = $('#user_password').attr('type');
                $('#user_password').attr('type', input === 'password' ? 'text' : 'password');
            });
        </script>
    @endpush

@endsection
