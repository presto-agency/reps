<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'author_id',
            'player1',
            'player2',
            'coefficient1',
            'coefficient2',
            'amount'
        ];

    public function getNameAttribute(){
        return " #{$this->id} {$this->player1}({$this->coefficient1}:{$this->coefficient2}){$this->player2} ({$this->amount} gas)";
    }

    public function gas_transactions(){
        return $this->morphMany(GasTransaction::class, 'initializable');
    }

    public function deals(){
        return $this->hasMany(Deal::class, 'bet_id');
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }
    public function winner(){
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function scopeActive($query){
        return $query->where('status', true);
    }
}
