<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable
        = [
            'id',
            'pickup_point',
            'return_point',
            'price',
            'status',
        ];
    protected $casts
        = [
            'pickup_point' => 'json',
            'return_point' => 'json',
            'price' => 'integer',
            'status' => OrderStatusEnum::class,
        ];
    public function cargos(): HasMany
    {
        return $this->hasMany(Cargo::class);
    }
    public function deliveryPoints(): HasMany
    {
        return $this->hasMany(DeliveryPoint::class);
    }

    public function pickupPoint(): HasOne
    {
        return $this->hasOne(PickupPoint::class);
    }
    public function returnPoint(): HasOne
    {
        return $this->hasOne(ReturnPoint::class);
    }
    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
