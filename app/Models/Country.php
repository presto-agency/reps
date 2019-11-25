<?php

namespace App\Models;

use App\User;
use checkFile;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable
        = [
            'name', 'code', 'flag',
        ];

    public function using()
    {
        return $this->hasMany(User::class, 'country_id');
    }

    public function flagOrDefault()
    {
        if ( ! empty($this->flag) && checkFile::checkFileExists($this->flag)) {
            return $this->flag;
        } else {
            return 'images/default/flag/country.png';
        }
    }

}
