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
        if (auth()->check() && auth()->user()->roles->name == 'admin') {
            $getRoleId = $user->getAttribute('role_id');
            if ($getRoleId == Role::getRoleId('admin') || $getRoleId == Role::getRoleId('super-admin')
            ) {
                unset($user['role_id']);
            }
        }
        if (auth()->check() && auth()->user()->roles->name == 'user') {
            unset($user['role_id']);
        }
        if (auth()->check() && auth()->user()->roles->name == 'moderator') {
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
