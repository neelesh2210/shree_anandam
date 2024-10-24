<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Image</th>
            <th class="text-center">Desription</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($events as $key=>$event)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">
                        <img src="{{asset('backend/assets/image/events/'.$event->image)}}" height="50px" width="50px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';">
                    </td>
                    <td class="text-center">{!!$event->description!!}</td>
                    <td class="text-center">
                        <x-admin.edit-button route="{{route('admin.event.edit', $event->id)}}" />
                        <x-admin.delete-button route="{{route('admin.event.destroy', $event->id)}}" id="{{$event->id}}" />
                    </td>
                </tr>
            @empty
                <x-admin.empty-table />
            @endforelse
        </tbody>
    </table>
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
