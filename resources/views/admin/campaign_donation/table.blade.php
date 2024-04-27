
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Donation Number</th>
            <th class="text-center">Receipt Number</th>
            <th class="text-center">User Detail</th>
            <th class="text-center">Campaign</th>
            <th class="text-center">Document Detail</th>
            <th class="text-center">Payment Detail</th>
            <th class="text-center">Date</th>
        </tr>
        </thead>
        <tbody class="tbody">
            @forelse ($campaign_donations as $key=>$campaign_donation)
                <tr>
                    <td class="text-center">{{ $key + 1 + ($campaign_donations->currentPage() - 1) * $campaign_donations->perPage() }}</td>
                    <td class="text-center">{{$campaign_donation->donation_number}}</td>
                    <td class="text-center">{{$campaign_donation->receipt_number}}</td>
                    <td>
                        <b>Name: </b>{{json_decode($campaign_donation->user_detail)->name}} <br>
                        <b>Phone Number: </b>{{json_decode($campaign_donation->user_detail)->phone_number}} <br>
                        <b>Address: </b>{{json_decode($campaign_donation->user_detail)->address}} <br>
                        <b>Referral Code: </b>{{json_decode($campaign_donation->user_detail)->referral_code}}
                    </td>
                    <td class="text-center">{{json_decode($campaign_donation->campaign_detail)->title}}</td>
                    <td>
                        <b>Pan Number: </b>{{$campaign_donation->document_detail['pan_number']}} <br>
                        <b>Aadhar Number: </b>{{$campaign_donation->document_detail['aadhar_number']}}
                    </td>
                    <td>
                        <b>Amount: </b>₹ {{$campaign_donation->donation_amount}} <br>
                        <b>Status: </b>
                        @if($campaign_donation->payment_status == 'initiated')
                            <span class="badge badge-success">Initiated</span>
                        @elseif($campaign_donation->payment_status == 'success')
                            <span class="badge badge-primary">Success</span>
                        @elseif($campaign_donation->payment_status == 'failed')
                            <span class="badge badge-warning">Failed</span>
                        @elseif($campaign_donation->payment_status == 'cancelled')
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </td>
                    <td class="text-center">{{$campaign_donation->created_at->format('d-m-Y h:i A')}}</td>
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
            <b>Showing {{ ($campaign_donations->currentpage() - 1) * $campaign_donations->perpage() + 1 }} to {{ ($campaign_donations->currentpage() - 1) * $campaign_donations->perpage() + $campaign_donations->count() }} of {{ $campaign_donations->total() }} campaign_donations</b>
        </p>
    </div>
    <div class="col-md-8">
        <div class="float-right">
            {!! $campaign_donations->appends(['search_start_date'=>$search_start_date,'search_end_date'=>$search_end_date,'search_campaign'=>$search_campaign,'search_payment_status'=>$search_payment_status,'search_key'=>$search_key])->links() !!}
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
