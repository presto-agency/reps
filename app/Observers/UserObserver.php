<?php

namespace App\Observers;


use App\Models\Role;
use App\User;

class UserObserver
{


    public function creating(User $user)
    {

    }

    public function created(User $user)
    {

    }

    public function updating(User $user)
    {
        if (auth()->user()->role_id == Role::getRoleId('admin')) {
            $getRoleId = $user->getAttribute('role_id');
            if ($getRoleId == Role::getRoleId('admin') || $getRoleId == Role::getRoleId('super-admin')
            ) {
                unset($user['role_id']);
            }
        }
        if (auth()->user()->role_id == Role::getRoleId('user')) {
            unset($user['role_id']);
        }
        if (auth()->user()->role_id == Role::getRoleId('moderator')) {
            unset($user['role_id']);
        }
    }

    public function updated(User $user)
    {

    }


    public function deleted(User $user)
    {
        //
    }


    public function restored(User $user)
    {
        //
    }


    public function forceDeleted(User $user)
    {
        //
    }

}
