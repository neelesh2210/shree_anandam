@extends('admin.layouts.app')
@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-content">
                        <u><h2 class="text-center">Edit Profile</h2></u>
                        <div class="text-center">
                            <img src="{{asset('backend/assets/image/avatars/'.Auth::guard('admin')->user()->avatar)}}" id="img1" class="rounded-circle circle-border m-b-md" alt="profile" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/admin.webp')}}';" style="width: 30%;border-color: #c2c2c2;border: 1px solid; aspect-ratio: 1 / 1;">
                        </div>
                        <form action="{{route('admin.profile.store')}}" method="POST" enctype="multipart/form-data" class="form-example" id="update_form">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" placeholder="Enter Name..." value="{{Auth::guard('admin')->user()->name}}" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Enter Email..." value="{{Auth::guard('admin')->user()->email}}" class="form-control">
                                    @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    <div class="custom-file">
                                        <input id="image" type="file" name="image" class="custom-file-input">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <x-admin.update-button />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    @push('js')

        <script>

            image.onchange = evt => {
                const [file] = image.files
                if (file) {
                    img1.src = URL.createObjectURL(file)
                }
            }

        </script>

    @endpush

@endsection
