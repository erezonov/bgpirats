<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kickstarter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'url'];

    public function lots() {
        return $this->hasMany(Kickstarter_pledges::class, 'kick_id', 'id');
    }
}
