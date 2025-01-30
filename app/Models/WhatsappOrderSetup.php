<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WhatsappOrderSetup extends Model
{
    use HasFactory;

    protected $table = "whatsapp_order_setup";
    protected $fillable = [
        'branch_id', 'phone','status'
    ];

    protected $casts = [
        'id'                => 'integer',
        'branch_id'         => 'integer',
        'phone'             => 'string',
        'status'            => 'integer',
    ];

    public function branch():HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
