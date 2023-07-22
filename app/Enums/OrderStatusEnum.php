<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case CREATED = 'Новый';
    case DELIVERING = 'В пути';
    case CANCELLED = 'Отменен';
    case COMPLETED = 'Выполнен';
    case RETURNING = 'Возвращается';
    case RETURNED = 'Возвращен';

    public static function values(): array
    {
        return [
            self::CREATED->value,
            self::DELIVERING->value,
            self::CANCELLED->value,
            self::COMPLETED->value,
            self::RETURNING->value,
            self::RETURNED->value,
        ];
    }

}
