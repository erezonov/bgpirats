<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'weight', 'from', 'name'];

    public const STATUS_CREATED = 0;
    public const STATUS_TO_FORWARDER = 1;
    public const STATUS_FORWARDER = 2;
    public const STATUS_TO_RUSSIA = 3;
    public const STATUS_TO_WAREHOUSE = 4;
    public const STATUS_IN_WAREHOUSE = 5;
    public const STATUS_COMPLETED = 6;

    public const STATUSTEXT = [
        'Создан',
        'В пути к форвардеру',
        'У форвардера',
        'В пути в Россию',
        'В пути на склад',
        'На складе',
        'Готово'
    ];
    public const STATUSES = [
        self::STATUS_CREATED,
        self::STATUS_TO_FORWARDER,
        self::STATUS_FORWARDER,
        self::STATUS_TO_RUSSIA,
        self::STATUS_TO_WAREHOUSE,
        self::STATUS_IN_WAREHOUSE,
        self::STATUS_COMPLETED
    ];

    public const INWORK = [
        self::STATUS_CREATED,
        self::STATUS_TO_FORWARDER,
        self::STATUS_FORWARDER,
        self::STATUS_TO_RUSSIA,
        self::STATUS_TO_WAREHOUSE,
        self::STATUS_IN_WAREHOUSE,
    ];
    public const SOURCE_KICK = 'Кикстартер';
    public const SOURCE_LOCAL = 'Локзакуп';
    public const SOURCE_SHOP = 'Интернет магазин';

    public const SOURCES = [
        self::SOURCE_KICK,
        self::SOURCE_LOCAL,
        self::SOURCE_SHOP
    ];

    public function packages()
    {

    }

    public static function getSource($id)
    {
        return self::SOURCES[$id];
    }

    public static function getStatus($id)
    {
        return self::STATUSES[$id];
    }

    public function getinWork() {
        return $this->whereIn('status', self::INWORK)->get();
    }

    public function orders() {
        return $this->hasMany(Orders::class, 'package_id');
    }
}
