<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DeliveryPoint extends Model
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
            'description' => 'string',
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

    public function cargos(): HasMany
    {
        return $this->hasMany(Cargo::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
