<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">staffs</th>
            @canany(['staff-edit','staff-delete'])
                <th class="text-center">Action</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            @forelse ($staffs as $key=>$staff)
                <tr>
                    <td class="text-center">{{ $key + 1 + ($staffs->currentPage() - 1) * $staffs->perPage() }}</td>
                    <td class="text-center">{{$staff->name}}</td>
                    <td class="text-center">{{$staff->email}}</td>
                    <td class="text-center">
                        @if(!empty($staff->getRoleNames()))
                            @foreach($staff->getRoleNames() as $v)
                                <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                        @endif
                    </td>
                    @canany(['staff-edit','staff-delete'])
                        <td  class="text-center">
                            @can('staff-edit')
                                <x-admin.edit-button route="{{route('admin.staffs.edit', $staff->id)}}" />
                            @endcan
                            @can('staff-delete')
                                <x-admin.delete-button route="{{route('admin.staffs.destroy', $staff->id)}}" id="{{$staff->id}}" />
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
            <b>Showing {{ ($staffs->currentpage() - 1) * $staffs->perpage() + 1 }} to {{ ($staffs->currentpage() - 1) * $staffs->perpage() + $staffs->count() }} of {{ $staffs->total() }} staffs</b>
        </p>
    </div>
    <div class="col-md-8">
        <div class="float-right">
            {!! $staffs->links() !!}
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
