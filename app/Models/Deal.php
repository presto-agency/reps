<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'user_id',
            'bet_id',
            'amount',
        ];

    public function bet()
    {
        return $this->belongsTo(Bet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
