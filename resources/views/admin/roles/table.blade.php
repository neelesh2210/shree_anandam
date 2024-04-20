<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            @canany(['role-edit','role-delete'])
                <th class="text-center">Action</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            @forelse ($roles as $key=>$role)
                <tr>
                    <td class="text-center">{{ $key + 1 + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                    <td class="text-center">{{$role->name}}</td>
                    @canany(['role-edit','role-delete'])
                        <td class="text-center">
                            @can('role-edit')
                                <x-admin.edit-button route="{{route('admin.roles.edit', $role->id)}}" />
                            @endcan
                            @can('role-delete')
                                <x-admin.delete-button route="{{route('admin.roles.destroy', $role->id)}}" id="{{$role->id}}" />
                            @endcan
                        </td>
                    @endcanany
                </tr>
            @empty
                <x-admin.empty-table />
            @endforelse
        </tbody>
    </table>
</div>
<hr>
<div class="row">
    <div class="col-md-4">
        <p>
            <b>Showing {{ ($roles->currentpage() - 1) * $roles->perpage() + 1 }} to {{ ($roles->currentpage() - 1) * $roles->perpage() + $roles->count() }} of {{ $roles->total() }} Roles</b>
        </p>
    </div>
    <div class="col-md-8">
        <div class="float-right">
            {!! $roles->links() !!}
        </div>
    </div>
</div>

<script>

    $(function() {
        $('a.page-link').on('click', function(event) {
            $('tbody').addClass('loading')
            event.preventDefault()
            var url = $(this).attr('href');
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    window.history.pushState("", "", url);
                    $('tbody').removeClass('loading');
                    $('#table_div').html(data);
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });
    });

</script>
