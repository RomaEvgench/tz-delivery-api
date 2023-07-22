<?php

namespace App\Enums;

enum CargoStatusEnum: string
{
    case DELIVERED = 'Доставлен';
    case UNDELIVERED = 'Не доставлен';

    public static function values(): array
    {
        return [
            self::DELIVERED->value,
            self::UNDELIVERED->value,
        ];
    }
}
