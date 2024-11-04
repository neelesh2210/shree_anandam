
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Phone</th>
            <th class="text-center">Address</th>
            <th class="text-center">Referral Code </th>
            <th class="text-center">Referrer Code </th>
            <th class="text-center">Date</th>
            <th class="text-center">Block Status</th>
            <th class="text-center">Verify Status</th>
            @can('user-edit')
                <th class="text-center">Action</th>
            @endcan
        </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($users as $key=>$user)
                <tr>
                    <td class="text-center">{{ $key + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td class="text-center">{{$user->name}}</td>
                    <td class="text-center">{{$user->phone_number}}</td>
                    <td class="text-center">{{$user->address}}</td>
                    <td class="text-center">{{$user->referral_code }}</td>
                    <td class="text-center">{{$user->referrer_code }}</td>
                    <td class="text-center">{{$user->created_at->format('d-m-Y h:i A')}}</td>
                    <td class="text-center">
                        @if($user->is_block == '1')
                            @can('user-block')
                                <a href="{{route('admin.user.block',[$user->id,'0'])}}">
                                    <span class="badge badge-danger">Blocked</span>
                                </a>
                            @else
                                <span class="badge badge-danger">Blocked</span>
                            @endcan
                        @else
                            @can('user-block')
                                <a href="{{route('admin.user.block',[$user->id,'1'])}}">
                                    <span class="badge badge-primary">Unblocked</span>
                                </a>
                            @else
                                <span class="badge badge-primary">Unblocked</span>
                            @endcan
                        @endif
                    </td>
                    <td class="text-center">
                        @if($user->is_verify == '1')
                            @can('user-verify')
                                <a href="{{route('admin.user.verify',[$user->id,'0'])}}">
                                    <span class="badge badge-primary">Verified</span>
                                </a>
                            @else
                                <span class="badge badge-primary">Verified</span>
                            @endcan
                        @else
                            @can('user-block')
                                <a href="{{route('admin.user.verify',[$user->id,'1'])}}">
                                    <span class="badge badge-danger">Not Verified</span>
                                </a>
                            @else
                                <span class="badge badge-danger">Not Verified</span>
                            @endcan
                        @endif
                    </td>
                    @can('user-edit')
                        <td class="text-center">
                            <a class="btn btn-warning dim text-white pt-2" data-toggle="tooltip" data-placement="top" data-original-title="Change Password" onclick="showChangeUserPassword('{{$user->id}}')"><i class="fa fa-key"></i></a>
                            <a class="btn btn-primary dim text-white pt-2" href="{{route('admin.user.documnet.detail',$user->id)}}" data-toggle="tooltip" data-placement="top" data-original-title="Update Document Detail"><i class="fa fa-file-alt"></i></a>
                            <a class="btn btn-default dim text-white pt-2" href="{{route('admin.user.team',$user->id)}}" data-toggle="tooltip" data-placement="top" data-original-title="Team"><i class="fa fa-users" style="color: black;"></i></a>
                            @can('user-edit')
                                <x-admin.edit-button route="{{route('admin.users.edit', $user->id)}}" />
                            @endcan
                        </td>
                    @endcan
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
            <b>Showing {{ ($users->currentpage() - 1) * $users->perpage() + 1 }} to {{ ($users->currentpage() - 1) * $users->perpage() + $users->count() }} of {{ $users->total() }} Users</b>
        </p>
    </div>
    <div class="col-md-8">
        <div class="float-right">
            {!! $users->appends(['search_start_date'=>$search_start_date,'search_end_date'=>$search_end_date,'search_block_status'=>$search_block_status,'search_verify_status'=>$search_verify_status,'search_key'=>$search_key])->links() !!}
        </div>
    </div>
</div>

<script>

    $(function() {
        $('a.page-link').on('click', function(event) {
            $('.tbody').addClass('loading')
            event.preventDefault()
            var url = $(this).attr('href');
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    window.history.pushState("", "", url);
                    $('.tbody').removeClass('loading');
                    $('#table_div').html(data);
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });
    });

</script>
