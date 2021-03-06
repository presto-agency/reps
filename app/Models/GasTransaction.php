<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class GasTransaction extends Model
{

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owning initializable model.
     */
    public function initializable()
    {
        return $this->morphTo();
    }

}
