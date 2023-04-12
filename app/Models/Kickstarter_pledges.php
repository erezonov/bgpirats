<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kickstarter_pledges extends Model
{
    use HasFactory;

    protected $table = 'kickstarter_lots';

    protected $fillable = ['lot_name', 'lot_price', 'kick_id', 'code', 'currency', 'description', 'weight'];

    public function kickName() {
        return $this->belongsTo(Kickstarter::class, 'kick_id', 'id');
    }
}
