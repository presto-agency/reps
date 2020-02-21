<?php

namespace App\Policies;

use App\Http\Sections\User as Users;
use App\Models\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    use HandlesAuthorization;

    /**
     * @param  User  $user
     * @param  string  $ability
     * @param  Users  $section
     * @param  User  $item
     *
     * @return bool
     */
    public function before(User $user, $ability, Users $section, User $item = null)
    {
    }

    /**
     * @param  User  $user
     * @param  Users  $section
     * @param  User  $item
     *
     * @return bool
     */
    public function display(User $user, Users $section, User $item)
    {
        return true;
    }

    /**
     * @param  User  $user
     * @param  Users  $section
     * @param  User  $item
     *
     * @return bool
     */
    public function edit(User $user, Users $section, User $item)
    {
        if ($user->roles->name == 'admin') {
            if ($item->role_id == Role::getRoleId('user')) {
                return true;
            }
            if ($item->role_id == Role::getRoleId('moderator')) {
                return true;
            }

            return false;
        }

        return true;
    }

    /**
     * @param  User  $user
     * @param  Users  $section
     * @param  User  $item
     *
     * @return bool
     */
    public function delete(User $user, Users $section, User $item)
    {
        if ($user->roles->name == 'admin') {
            if ($item->role_id == Role::getRoleId('user')) {
                return true;
            }
            if ($item->role_id == Role::getRoleId('moderator')) {
                return true;
            }

            return false;
        }

        return true;
    }

}
