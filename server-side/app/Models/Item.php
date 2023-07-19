<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory, UsesUuid;
    protected $fillable = [
        'order_id',
        'name',
        'price',
        'quantity',
        'image'
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public $timestamps = false;

}
