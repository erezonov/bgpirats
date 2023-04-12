<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    public const STATUS_START = 1;
    public const STATUS_PLEDGE = 2;
    public const STATUS_IN_PACK = 3;
    public const STATUS_COMPLETED = 4;


    public const ALLSTATUSES = [
        'Заказ сделан',
        'Заказ сделан',
        'Заказ оплачен',
        'Заказ в посылке',
        'Заказ готов',
        self::STATUS_COMPLETED,
    ];
    protected $fillable = ['count', 'lot_id', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lot() {
        return $this->belongsTo(Kickstarter_pledges::class);
    }

    public function package() {
        return $this->belongsTo(Packages::class, 'package_id', 'id');
    }

}
