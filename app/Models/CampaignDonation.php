<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignDonation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_number',
        'receipt_number',
        'user_id',
        'campaign_id',
        'donation_amount',
        'user_detail',
        'campaign_detail',
        'document_detail',
        'payment_detail',
        'payment_status'
    ];

    protected $casts = [
        'document_detail' => 'array'
    ];
}
