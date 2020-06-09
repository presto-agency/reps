<?php

namespace App\Observers;

use App\Models\GasTransaction;
use App\User;

class GasTransactionObserver
{

    protected static $modelInit
        = [
            'id'   => '',
            'name' => '',
        ];

    public function creating(GasTransaction $gasTransaction)
    {
        if (isset($gasTransaction->admin_id) && auth()->check()) {
            self::$modelInit['id']   = auth()->user()->id;
            self::$modelInit['name'] = 'admin';
            unset($gasTransaction['admin_id']);
        }
    }

    /**
     * Handle the gas transaction "created" event.
     *
     * @param  \App\Models\GasTransaction  $gasTransaction
     *
     * @return void
     */
    public function created(GasTransaction $gasTransaction)
    {
        if (isset($gasTransaction->incoming) || isset($gasTransaction->outgoing)) {
            $user = User::with('gas')->find($gasTransaction->user_id);
            if ($user) {
                $debit   = $user->gas->sum('incoming');
                $credit  = $user->gas->sum('outgoing');
                $balance = $debit - $credit;

                // обернути в транзакцію
                switch (self::$modelInit['name']) {
                    //для адмінів які створюють транзакції з адмінки
                    case 'admin':
                        $admin = auth()->user();
                        $admin->gas_transactions()->save($gasTransaction);
                        self::$modelInit = [];
                        break;

                    //для звичайних юзерів
                    case 'user':
                        //автоматично створювати опис до транзакції
                        break;

                    //для транзакцій, які були створені за допомогою ставок
                    case 'bet':
                        break;
                }

                $user->gas_balance = $balance;
                $user->save();
            }
        }
    }

    /**
     * Handle the gas transaction "updated" event.
     *
     * @param  \App\Models\GasTransaction  $gasTransaction
     *
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
     *
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
     *
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
     *
     * @return void
     */
    public function forceDeleted(GasTransaction $gasTransaction)
    {
        //
    }

}
