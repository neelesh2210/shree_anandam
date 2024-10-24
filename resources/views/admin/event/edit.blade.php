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
                <x-admin.back-button route="{{route('admin.event.index')}}" />
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <form action="{{route('admin.event.update',$event->id)}}" method="POST" enctype="multipart/form-data" class="form-example" id="update_form">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image <span class="text-danger">*</span></label>
                                        <div class="custom-file">
                                            <input id="image" type="file" name="image" class="custom-file-input" required>
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        <img id="img1" src="{{asset('backend/assets/image/events/'.$event->image)}}" alt="" class="mt-2" height="100px" width="100px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';"><br>
                                        @error('image')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control summernote" placeholder="Enter Description...">{{old('description',$event->description)}}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="form-group">
                                        <x-admin.update-button />
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
            image.onchange = evt => {
                const [file] = image.files
                if (file) {
                    img1.src = URL.createObjectURL(file)
                }
            }
        </script>
    @endpush

@endsection
