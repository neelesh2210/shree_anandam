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
                        <form action="{{route('admin.user.documnet.detail.update',$user->id)}}" method="POST" enctype="multipart/form-data" class="form-example" id="update_form">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Id Proof Type <span class="text-danger">*</span></label>
                                        <select name="id_proof_type" class="form-control" id="id_proof_type" onchange="showIdProofDiv()" required>
                                                <option value="">Select Id Proof Type...</option>
                                                <option value="aadhar" @if(old('id_proof_type',optional($user->userDetail)->id_proof_type) === 'aadhar') selected @endif>Addhar</option>
                                                <option value="pan" @if(old('id_proof_type',optional($user->userDetail)->id_proof_type) === 'pan') selected @endif>Pan</option>
                                        </select>
                                        @error('id_proof_type')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4" id="aadhar_front_image_div" style="display: none">
                                    <div class="form-group">
                                        <label>Aadhar Front Image</label>
                                        <div class="custom-file">
                                            <input id="aadhar_front_image" type="file" name="aadhar_front_image" class="custom-file-input">
                                            <label class="custom-file-label" for="aadhar_front_image">Choose file</label>
                                        </div>
                                        @php
                                            if(isset(optional($user->userDetail)->id_proof[0])){
                                                $aadhar_front_image = optional($user->userDetail)->id_proof[0];
                                            }else{
                                                $aadhar_front_image = 'no-image.png';
                                            }
                                        @endphp
                                        <img id="aadhar_front_image_preview" src="{{asset('backend/assets/image/documents/'.$aadhar_front_image)}}" alt="" class="mt-2" height="100px" width="100px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';"><br>
                                        @error('aadhar_front_image')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4" id="aadhar_back_image_div" style="display: none">
                                    <div class="form-group">
                                        <label>Aadhar Back Image</label>
                                        <div class="custom-file">
                                            <input id="aadhar_back_image" type="file" name="aadhar_back_image" class="custom-file-input">
                                            <label class="custom-file-label" for="aadhar_back_image">Choose file</label>
                                        </div>
                                        @php
                                            if(isset(optional($user->userDetail)->id_proof[1])){
                                                $aadhar_back_image = optional($user->userDetail)->id_proof[1];
                                            }else{
                                                $aadhar_back_image = 'no-image.png';
                                            }
                                        @endphp
                                        <img id="aadhar_back_image_preview" src="{{asset('backend/assets/image/documents/'.$aadhar_back_image)}}" alt="" class="mt-2" height="100px" width="100px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';"><br>
                                        @error('aadhar_back_image')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4" id="pan_image_div" style="display: none">
                                    <div class="form-group">
                                        <label>Pan Image</label>
                                        <div class="custom-file">
                                            <input id="pan_image" type="file" name="pan_image" class="custom-file-input">
                                            <label class="custom-file-label" for="pan_image">Choose file</label>
                                        </div>
                                        @php
                                            if(isset(optional($user->userDetail)->id_proof[0])){
                                                $pan_image = optional($user->userDetail)->id_proof[0];
                                            }else{
                                                $pan_image = 'no-image.png';
                                            }
                                        @endphp
                                        <img id="pan_image_preview" src="{{asset('backend/assets/image/documents/'.$pan_image)}}" alt="" class="mt-2" height="100px" width="100px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';"><br>
                                        @error('pan_image')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Photo</label>
                                        <div class="custom-file">
                                            <input id="photo" type="file" name="photo" class="custom-file-input">
                                            <label class="custom-file-label" for="photo">Choose file</label>
                                        </div>
                                        <img id="photo_preview" src="{{asset('backend/assets/image/documents/'.optional($user->userDetail)->photo)}}" alt="" class="mt-2" height="100px" width="100px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';"><br>
                                        @error('photo')
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
            aadhar_front_image.onchange = evt => {
                const [file] = aadhar_front_image.files
                if (file) {
                    aadhar_front_image_preview.src = URL.createObjectURL(file)
                }
            }

            aadhar_back_image.onchange = evt => {
                const [file] = aadhar_back_image.files
                if (file) {
                    aadhar_back_image_preview.src = URL.createObjectURL(file)
                }
            }

            pan_image.onchange = evt => {
                const [file] = pan_image.files
                if (file) {
                    pan_image_preview.src = URL.createObjectURL(file)
                }
            }

            photo.onchange = evt => {
                const [file] = photo.files
                if (file) {
                    photo_preview.src = URL.createObjectURL(file)
                }
            }

            $(showIdProofDiv());
            function showIdProofDiv(){
                var id_proof_type = $('#id_proof_type').val();
                if(id_proof_type === 'aadhar'){
                    $('#pan_image_div').hide();
                    $('#aadhar_front_image_div').show();
                    $('#aadhar_back_image_div').show();
                }else if(id_proof_type === 'pan'){
                    $('#pan_image_div').show();
                    $('#aadhar_front_image_div').hide();
                    $('#aadhar_back_image_div').hide();
                }else{
                    $('#pan_image_div').hide();
                    $('#aadhar_front_image_div').hide();
                    $('#aadhar_back_image_div').hide()
                }
            }
        </script>
    @endpush

@endsection
