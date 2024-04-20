<a class="btn btn-danger dim text-white pt-2" onclick="confirmDelete({{$id}})" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
<form action="{{$route}}" method="POST" id="delete_form_{{$id}}">
    @method('DELETE')
    @csrf
</form>
