<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationOrder extends Model
{
    use HasFactory;

    protected $table = 'variation_orders';

    protected $fillable = [
        'funds_utilization_id',
        'vo_number',
        'vo_abc',
        'vo_contract_amount',
        'vo_engineering',
        'vo_mqc',
        'vo_bid',
        'vo_contingency',
        'vo_appropriation',
    ];

    /**
     * Get the related FundsUtilization record.
     */
    public function fundsUtilization()
    {
        return $this->belongsTo(FundsUtilization::class, 'funds_utilization_id');
    }
}
