<script src="{{ asset('backend/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('backend/assets/js/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('backend/assets/js/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/inspinia.js') }}"></script>
<script src="{{ asset('backend/assets/js/pace.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/additional-methods.min.js') }}"></script>

<script src="{{asset('backend/assets/js/bs-custom-file-input.min.js')}}"></script>

<script src="{{ asset('backend/assets/js/sweetalert2.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/select2.full.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/summernote-bs4.js') }}"></script>

<script src="{{ asset('backend/assets/js/bootstrap-datepicker.js') }}"></script>

<script src="{{ asset('backend/assets/js/bootstrap-toggle.min.js') }}"></script>

<script>
    $('.form-example').validate({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    $(document).ready(function () {
        bsCustomFileInput.init()
    });

    function confirmSave(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure want to Save!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#1ab394',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.value) {
                $('#add_form').submit()
            }
        })
        return false;
    }

    function confirmUpdate(){
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure want to Update!",
            showCancelButton: true,
            confirmButtonColor: '#f79d3c',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.value) {
                $('#update_form').submit()
            }
        })
        return false;
    }

    function confirmDelete(id){
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure want to Delete!',
            showCancelButton: true,
            confirmButtonColor: '#ea394c',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $('#delete_form_'+id).submit()
            }
        })
        return false;
    }
</script>

<script>
    $(function () {

        //Select2
        $(".select2").select2({
            theme: 'bootstrap4',
        });

        //Summernote

        $('.summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                //['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                //['view', ['fullscreen'/*, 'codeview' */]],   // remove codeview button
                //['help', ['help']]
            ]
        });

        //Date Range
        $('.date_range .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

        //alerts
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        var success_message = "{{ Session::get('success') }}";
        var info_message = "{{ Session::get('info') }}";
        var error_message = "{{ Session::get('error') }}";
        var warning_message = "{{ Session::get('warning') }}";

        if (success_message != "") {
            success_alert(success_message);
        }
        if (info_message != "") {
            info_alert(info_message);
        }
        if (error_message != "") {
            error_alert(error_message)
        }
        if (warning_message != "") {
            warning_alert(warning_message)
        }
        function success_alert(success_message) {
            Toast.fire({
                icon: 'success',
                title: success_message
            })
        }
        function info_alert(info_message) {
            Toast.fire({
                icon: 'info',
                title: info_message
            })
        }
        function error_alert(error_message) {
            Toast.fire({
                icon: 'error',
                title: error_message
            })
        }
        function warning_alert(warning_message) {
            Toast.fire({
                icon: 'warning',
                title: warning_message
            })
        }
    });
</script>

@stack('js')
