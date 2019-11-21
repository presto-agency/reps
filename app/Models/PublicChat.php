<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicChat extends Model
{

    /**
     * Using table name
     *
     * @var string
     */
    protected $table = 'public_messages';

    protected $fillable
        = [
            'user_id',
            'user_name',
            'file_path',
            'message',
            'is_hidden',
            'to',
            'imo',
        ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

}
