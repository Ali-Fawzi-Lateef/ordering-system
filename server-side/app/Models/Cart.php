<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory, UsesUuid;
    protected $fillable = [
        'user_id',
        'storage_id',
        'quantity_of_item'
    ];
    public function Storage(): BelongsTo
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public $timestamps = false;

}
