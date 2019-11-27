<?php

namespace App\Policies;

use App\Http\Sections\User as Users;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    /**
     * @param  User    $user
     * @param  string  $ability
     * @param  Users   $section
     * @param  User    $item
     *
     * @return bool
     */
    public function before(
        User $user, $ability, Users $section, User $item = null
    ) {

        if ($user->roles->name == 'super-admin' || 'admin') {
            //if ($ability != 'display' && $ability != 'create' && !is_null($item) && $item->id <= 2) {
            //    return false;
            //  }

            return true;
        }
    }

    /**
     * @param  User   $user
     * @param  Users  $section
     * @param  User   $item
     *
     * @return bool
     */
    public function display(User $user, Users $section, User $item)
    {
        dump('display');
        return true;
    }

    /**
     * @param  User   $user
     * @param  Users  $section
     * @param  User   $item
     *
     * @return bool
     */
    public function edit(User $user, Users $section, User $item)
    {
        dump('edit');
        return $item->id > 2;
    }

    /**
     * @param  User   $user
     * @param  Users  $section
     * @param  User   $item
     *
     * @return bool
     */
    public function delete(User $user, Users $section, User $item)
    {
        dump('delete');
        return $item->id > 2;
    }
//    public function before(User $user, $ability, User $item)
//    {
//        return false;
//    }
//    /**
//     * Determine whether the user can view any models.
//     *
//     * @param  \App\User  $user
//     * @return mixed
//     */
//    public function viewAny(User $user)
//    {
//        return false;
//    }
//
//    /**
//     * Determine whether the user can view the model.
//     *
//     * @param  \App\User  $user
//     * @param  \App\User  $model
//     * @return mixed
//     */
//    public function view(User $user, User $model)
//    {
//        return false;
//    }
//
//    /**
//     * Determine whether the user can create models.
//     *
//     * @param  \App\User  $user
//     * @return mixed
//     */
//    public function create(User $user)
//    {
//        return false;
//    }
//
//    /**
//     * Determine whether the user can update the model.
//     *
//     * @param  \App\User  $user
//     * @param  \App\User  $model
//     * @return mixed
//     */
//    public function update(User $user, User $model)
//    {
//        return false;
//    }
//
//    public function edit(User $user, User $model)
//    {
//
//        return false;
//    }
//    /**
//     * Determine whether the user can delete the model.
//     *
//     * @param  \App\User  $user
//     * @param  \App\User  $model
//     * @return mixed
//     */
//    public function delete(User $user, User $model)
//    {
//        return false;
//    }
//
//    /**
//     * Determine whether the user can restore the model.
//     *
//     * @param  \App\User  $user
//     * @param  \App\User  $model
//     * @return mixed
//     */
//    public function restore(User $user, User $model)
//    {
//        return false;
//    }
//
//    /**
//     * Determine whether the user can permanently delete the model.
//     *
//     * @param  \App\User  $user
//     * @param  \App\User  $model
//     * @return mixed
//     */
//    public function forceDelete(User $user, User $model)
//    {
//        return false;
//    }
}
