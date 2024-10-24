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
                <x-admin.back-button route="{{route('admin.about.index')}}" />
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <form action="{{route('admin.about.store')}}" method="POST" enctype="multipart/form-data" class="form-example" id="add_form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Type <span class="text-danger">*</span></label>
                                        <select name="type" id="type" class="form-control" required onchange="getAboutData()">
                                            <option value="">Select Type...</option>
                                            <option value="sansthan" @if(old('type') == 'sansthan') selected @endif>Sansthan</option>
                                            <option value="guruji" @if(old('type') == 'guruji') selected @endif>Guruji</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About</label>
                                        <textarea name="about" id="about" class="form-control summernote" placeholder="Enter About...">{{old('about')}}</textarea>
                                        @error('about')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
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

    @push('js')
        <script>

            function getAboutData(){
                var type = $('#type').val();
                $.ajax({
                    type: 'GET',
                    url: "{{route('admin.about.show','')}}/"+type,
                    success: function(data) {
                        $('#about').summernote('code', data.about);
                    }
                });
            }

        </script>
    @endpush

@endsection
