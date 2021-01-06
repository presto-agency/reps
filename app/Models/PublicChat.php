<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicChat extends Model
{

    public $timestamps = true;
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
            'is_anon',
        ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public static function getLast100Messages()
    {
        return self::query()->orderByDesc('id')->where('is_hidden', 0)->take(100)->get();
    }
}
