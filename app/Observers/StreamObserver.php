<?php

namespace App\Observers;

use App\Models\Stream;

class StreamObserver
{

    public function creating(Stream $stream)
    {

        $this->setUserIdAttribute($stream);

    }
    /**
     * Handle the stream "created" event.
     *
     * @param  \App\Models\Stream  $stream
     * @return void
     */
    public function created(Stream $stream)
    {

    }

    public function updating(Stream $stream)
    {
        $this->setUserIdAttribute($stream);
    }

    /**
     * Handle the stream "updated" event.
     *
     * @param  \App\Models\Stream  $stream
     * @return void
     */
    public function updated(Stream $stream)
    {
        //
    }

    /**
     * Handle the stream "deleted" event.
     *
     * @param  \App\Models\Stream  $stream
     * @return void
     */
    public function deleted(Stream $stream)
    {
        //
    }

    /**
     * Handle the stream "restored" event.
     *
     * @param  \App\Models\Stream  $stream
     * @return void
     */
    public function restored(Stream $stream)
    {
        //
    }

    /**
     * Handle the stream "force deleted" event.
     *
     * @param  \App\Models\Stream  $stream
     * @return void
     */
    public function forceDeleted(Stream $stream)
    {
        //
    }

    private function setUserIdAttribute($data)
    {
        return $data['user_id'] = auth()->user()->id;

    }
}
