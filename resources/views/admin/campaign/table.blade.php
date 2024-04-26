
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Title</th>
            <th class="text-center">Image</th>
            <th class="text-center">Total Raise Amount</th>
            <th class="text-center">Total Raised Amount</th>
            <th class="text-center">Short Description</th>
            <th class="text-center">Is Active</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($campaigns as $key=>$campaign)
                <tr>
                    <td class="text-center">{{ $key + 1 + ($campaigns->currentPage() - 1) * $campaigns->perPage() }}</td>
                    <td class="text-center">{{$campaign->title}}</td>
                    <td class="text-center">
                        <img src="{{asset('backend/assets/image/campaigns/'.$campaign->image)}}" height="50px" width="50px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';">
                    </td>
                    <td class="text-center">₹ {{abreviateTotalCount($campaign->total_raise_amount)}}</td>
                    <td class="text-center">₹ {{abreviateTotalCount($campaign->total_raised_amount)}}</td>
                    <td class="text-center">{!!$campaign->short_description!!}</td>
                    <td class="text-center">
                        @if($campaign->is_active == '1')
                            <a href="{{route('admin.campaigns.status',[$campaign->id,'0'])}}">
                                <span class="badge badge-primary">Active</span>
                            </a>
                        @else
                            <a href="{{route('admin.campaigns.status',[$campaign->id,'1'])}}">
                                <span class="badge badge-danger">Inactive</span>
                            </a>
                        @endif
                    </td>
                    <td class="text-center">
                        <x-admin.edit-button route="{{route('admin.campaigns.edit', $campaign->id)}}" />
                    </td>
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
            <b>Showing {{ ($campaigns->currentpage() - 1) * $campaigns->perpage() + 1 }} to {{ ($campaigns->currentpage() - 1) * $campaigns->perpage() + $campaigns->count() }} of {{ $campaigns->total() }} campaigns</b>
        </p>
    </div>
    <div class="col-md-8">
        <div class="float-right">
            {!! $campaigns->appends(['campaigns'=>$campaigns,'search_is_active'=>$search_is_active,'search_key'=>$search_key])->links() !!}
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
