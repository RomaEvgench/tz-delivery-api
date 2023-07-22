<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ReturnPoint extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    protected $fillable
        = [
            'id',
            'latitude',
            'longitude',
            'address',
            'receiver_name',
            'receiver_phone',
            'order_id',
        ];

    protected $casts
        = [
            'latitude' => 'string',
            'longitude' => 'string',
            'address' => 'string',
            'receiver_name' => 'string',
            'receiver_phone' => 'string',
        ];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
