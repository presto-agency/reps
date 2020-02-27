<?php

namespace App\Observers;

use App\Models\GasTransaction;
use App\User;

class GasTransactionObserver
{
    /**
     * Handle the gas transaction "created" event.
     *
     * @param  \App\Models\GasTransaction  $gasTransaction
     * @return void
     */
    public function created(GasTransaction $gasTransaction)
    {
        if(isset($gasTransaction->incoming) || isset($gasTransaction->outgoing)){

            $user = User::with('gas')->find($gasTransaction->user_id);
            if ($user){

                $debit = $user->gas->sum('incoming');
                $credit = $user->gas->sum('outgoing');
                $balance = $debit - $credit;

                $user->gas_balance = $balance;
                $user->save();
            }

        }
    }

    /**
     * Handle the gas transaction "updated" event.
     *
     * @param  \App\Models\GasTransaction  $gasTransaction
     * @return void
     */
    public function updated(GasTransaction $gasTransaction)
    {
        //
    }

    /**
     * Handle the gas transaction "deleted" event.
     *
     * @param  \App\Models\GasTransaction  $gasTransaction
     * @return void
     */
    public function deleted(GasTransaction $gasTransaction)
    {
        //
    }

    /**
     * Handle the gas transaction "restored" event.
     *
     * @param  \App\Models\GasTransaction  $gasTransaction
     * @return void
     */
    public function restored(GasTransaction $gasTransaction)
    {
        //
    }

    /**
     * Handle the gas transaction "force deleted" event.
     *
     * @param  \App\Models\GasTransaction  $gasTransaction
     * @return void
     */
    public function forceDeleted(GasTransaction $gasTransaction)
    {
        //
    }
}
