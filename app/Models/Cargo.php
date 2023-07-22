<?php

namespace App\Models;

use App\Enums\CargoStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Cargo extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $fillable
        = [
            'id',
            'name',
            'weight',
            'size',
            'order_id',
            'delivery_point_id',
            'status',
        ];
    protected $casts
        = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'status' => CargoStatusEnum::class,
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
