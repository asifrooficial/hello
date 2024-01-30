<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'body', 
        'user_id',
        'eventId',
        'mainHand', 
        'offHand',
        'head', 
        'armor', 
        'shoes', 
        'cape', 
        'mount', 
        'killer', 
        'killerGuild', 
        'killerAlliance',
        'timeKilled',
        'isApproved',
        'regearMe',
        'item_id',
        'isBomb',
        'bag'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
