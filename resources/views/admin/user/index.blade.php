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
        @can('user-create')
            <div class="col-6">
                <div class="mt-3 text-right">
                    <x-admin.add-button route="{{route('admin.users.create')}}" text="Add User"/>
                </div>
            </div>
        @endcan
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
                                    <label for="search_block_status">Block Status</label>
                                    <div class="input-group">
                                        <select name="search_block_status" class="form-control" onchange="fillter()">
                                            <option value="">All</option>
                                            <option value="1">Blocked</option>
                                            <option value="0">Unblock</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 m-b-xs">
                                    <label for="search_verify_status">Block Status</label>
                                    <div class="input-group">
                                        <select name="search_verify_status" class="form-control" onchange="fillter()">
                                            <option value="">All</option>
                                            <option value="1">Verified</option>
                                            <option value="0">Not Verified</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 m-b-xs" style="padding:0px 0px 0px 0px">
                                    <label for="search_key">Search</label>
                                    <div class="input-group">
                                        <input placeholder="Name/Referral/Phone" type="text" name="search_key" id="search_key" value="{{$search_key}}" class="form-control form-control-sm" onkeyup="fillter()">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-sm btn-primary dim">Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="table_div">
                            @include('admin.user.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="user_forget_password" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Change User Password</h4>
                </div>
                <form class="form-example" id="change_user_password_form">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="user_id" id="change_user_password_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group m-b">
                                    <input type="password" name="password" id="change_user_password" placeholder="Enter Password..." class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-addon cursor-pointer" id="toggle-change-user-password"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="text-danger change_user_password_error" style="display: none"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="input-group m-b">
                                    <input type="password" name="confirm_password" id="change_user_confirm_password" placeholder="Enter Confirm Password..." class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-addon cursor-pointer" id="toggle-change-user-confirm-password"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="text-danger change_user_password_error" style="display: none"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger dim" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-w-m btn-warning dim" onclick="changeUserPassword()"><i class="fa fa-floppy-o"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')

        <script>

            function fillter(){
                $('.tbody').addClass('loading')
                var route = "{{route('admin.users.index')}}";
                var form = $('#search_form').serialize();
                $.ajax({
                    type: 'GET',
                    url: "{{route('admin.users.index')}}",
                    data: $('#search_form').serialize(),
                    success: function(data) {
                        window.history.pushState("", "", route+'?'+form);
                        $('.tbody').removeClass('loading');
                        $('#table_div').html(data);
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                });
            }

            $('#toggle-change-user-password').click(function(){
                $(this).children().toggleClass('fa fa-eye fa fa-eye-slash');
                let input = $('#change_user_password').attr('type');
                $('#change_user_password').attr('type', input === 'password' ? 'text' : 'password');
            });

            $('#toggle-change-user-confirm-password').click(function(){
                $(this).children().toggleClass('fa fa-eye fa fa-eye-slash');
                let input = $('#change_user_confirm_password').attr('type');
                $('#change_user_confirm_password').attr('type', input === 'password' ? 'text' : 'password');
            });

            function showChangeUserPassword(user_id){
                $('#change_user_password_form').trigger("reset");
                $('#change_user_password_id').val(user_id);
                $('#user_forget_password').modal('show');
            }

            function changeUserPassword(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure want to Update!",
                    showCancelButton: true,
                    confirmButtonColor: '#f79d3c',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.value) {
                        $('.change_user_password_error').hide();
                        $.ajax({
                            type: 'POST',
                            url: "{{route('admin.change.user.password')}}",
                            data: $('#change_user_password_form').serialize(),
                            success: function(data) {
                                $('#change_user_password_form').trigger("reset");
                                $('#user_forget_password').modal('hide');
                                var Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                });
                            },
                            error: function(request, status, error) {
                                if (request.responseJSON.errors.password) {
                                    $('.change_user_password_error').show();
                                    $('.change_user_password_error').text(request.responseJSON.errors.password);
                                } else {
                                    $('.change_user_password_error').hide();
                                }
                            }
                        });
                    }
                })
                return false;
            }

        </script>

    @endpush

@endsection
