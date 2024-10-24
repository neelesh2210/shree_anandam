<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Type</th>
            <th class="text-center">About</th>
        </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($abouts as $key=>$about)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">
                        {{ucfirst($about->type)}}
                    </td>
                    <td class="text-center">{!!$about->about!!}</td>
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
