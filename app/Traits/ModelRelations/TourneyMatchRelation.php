<?php

namespace App\Traits\ModelRelations;


trait TourneyMatchRelation
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function file1()
//    {
//        return $this->belongsTo('App\Models\File', 'rep1');
//    }
//    public function file2()
//    {
//        return $this->belongsTo('App\Models\File', 'rep2');
//    }
//    public function file3()
//    {
//        return $this->belongsTo('App\Models\File', 'rep3');
//    }
//    public function file4()
//    {
//        return $this->belongsTo('App\Models\File', 'rep4');
//    }
//    public function file5()
//    {
//        return $this->belongsTo('App\Models\File', 'rep5');
//    }
//    public function file6()
//    {
//        return $this->belongsTo('App\Models\File', 'rep6');
//    }
//    public function file7()
//    {
//        return $this->belongsTo('App\Models\File', 'rep7');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player1()
    {
        return $this->belongsTo('App\Models\TourneyPlayer', 'player1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player2()
    {
        return $this->belongsTo('App\Models\TourneyPlayer', 'player2_id');
    }
}
