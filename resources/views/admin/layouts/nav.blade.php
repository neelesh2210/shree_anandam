<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary dim" href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li style="padding-right: 10px;">
                <div class="dropdown profile-element d-flex">
                    <img alt="image" class="rounded-circle" src="{{asset('backend/assets/image/avatars/'.Auth::guard('admin')->user()->avatar)}}" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/admin.webp')}}';" style="height: 50px;width: 50px;margin-top: 15px;" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{Auth::guard('admin')->user()->name}} <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="{{route('admin.profile')}}"><i class="fa fa-user"></i> Profile</a></li>
                        <li><a class="dropdown-item" data-toggle="modal" data-target="#forget_password"><i class="fa fa-lock"></i> Change Password</a></li>
                        <li>
                            <a class="dropdown-item" onclick="$('#logout_form').submit()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            <form action="{{route('admin.logout')}}" id="logout_form" method="POST">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>

<div class="modal inmodal" id="forget_password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Change Password</h4>
            </div>
            <form class="form-example" id="change_password_form">
                <div class="modal-body">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group m-b">
                                <input type="password" name="password" id="password" placeholder="Enter Password..." class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-addon cursor-pointer" id="toggle-password"><i class="fa fa-eye"></i></span>
                                </div>
                            </div>
                            <span class="text-danger password_error" style="display: none"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <div class="input-group m-b">
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password..." class="form-control" required>
                                <div class="input-group-append">
                                    <span class="input-group-addon cursor-pointer" id="toggle-confirm-password"><i class="fa fa-eye"></i></span>
                                </div>
                            </div>
                            <span class="text-danger password_error" style="display: none"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger dim" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-w-m btn-warning dim" onclick="changePassword()"><i class="fa fa-floppy-o"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')

    <script>

        $('#toggle-password').click(function(){
            $(this).children().toggleClass('fa fa-eye fa fa-eye-slash');
            let input = $('#password').attr('type');
            $('#password').attr('type', input === 'password' ? 'text' : 'password');
        });

        $('#toggle-confirm-password').click(function(){
            $(this).children().toggleClass('fa fa-eye fa fa-eye-slash');
            let input = $('#confirm_password').attr('type');
            $('#confirm_password').attr('type', input === 'password' ? 'text' : 'password');
        });

        function changePassword(){
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure want to Update!",
                showCancelButton: true,
                confirmButtonColor: '#f79d3c',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.value) {
                    $('.password_error').hide();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.change.password') }}",
                        data: $('#change_password_form').serialize(),
                        success: function(data) {
                            $('#change_password_form').trigger("reset");
                            $('#forget_password').modal('hide');
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
                                $('.password_error').show();
                                $('.password_error').text(request.responseJSON.errors.password);
                            } else {
                                $('.password_error').hide();
                            }
                        }
                    });
                }
            })
            return false;
        }

    </script>

@endpush
