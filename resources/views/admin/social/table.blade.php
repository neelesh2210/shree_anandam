<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Type</th>
            <th class="text-center">Link</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($socials as $key=>$social)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">
                        {{ucfirst($social->type)}}
                    </td>
                    <td class="text-center">
                        <a href="{{$social->about}}" target="_blank">
                            {{$social->about}}
                        </a>
                    </td>
                    <td class="text-center">
                        <x-admin.delete-button route="{{route('admin.social.destroy', $social->id)}}" id="{{$social->id}}" />
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
