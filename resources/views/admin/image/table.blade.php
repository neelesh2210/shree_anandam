<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Image</th>
            <th class="text-center">Type</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($images as $key=>$image)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">
                        <img src="{{asset('backend/assets/image/images/'.$image->image)}}" height="50px" width="50px" onerror="this.onerror=null;this.src='{{asset('backend/assets/image/no-image.png')}}';">
                    </td>
                    <td class="text-center">{{ucwords(str_replace('_',' ',$image->type))}}</td>
                    <td class="text-center">
                        <x-admin.delete-button route="{{route('admin.image.destroy', $image->id)}}" id="{{$image->id}}" />
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
