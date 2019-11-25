<?php


namespace App\Admin\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;

class UserSectionModelPolicy
{

    use HandlesAuthorization;

    /**
     * @param  \App\User  $user
     * @param $ability
     * @param  \App\Http\Sections\User  $section
     * @param  \App\User|null  $item
     *
     * @return bool
     */
    public function before(
        \App\User $user,
        $ability,
        \App\Http\Sections\User $section,
        \App\User $item = null
    ) {
        if ($user->superAdminRoles()) {
            if ($ability != 'display' && ! is_null($item)
                && $item->roles->name == 'super-admin'
            ) {
                return false;
            }
        }
        if ($user->adminRoles()) {
            if ($ability != 'display' && ! is_null($item)
                && $item->roles->name == 'admin'
            ) {
                return false;
            }
            if ($ability != 'display' && ! is_null($item)
                && $item->roles->name == 'super-admin'
            ) {
                return false;
            }
            if ($ability != 'display' && $ability != 'edit' && ! is_null($item)
                && $item->roles->name == 'user'
            ) {
                return true;
            }
            if ($ability != 'display' && $ability != 'edit' && ! is_null($item)
                && $item->roles->name == 'moderator'
            ) {

                return true;
            }
        }

        return true;
    }

    /**
     * @param  \App\User  $user
     * @param $ability
     * @param  \App\Http\Sections\User  $section
     * @param  \App\User  $item
     *
     * @return bool
     */
    public function display(
        \App\User $user,
        $ability,
        \App\Http\Sections\User $section,
        \App\User $item
    ) {
        return true;
    }

    /**
     * @param  \App\User  $user
     * @param $ability
     * @param  \App\Http\Sections\User  $section
     * @param  \App\User  $item
     *
     * @return bool
     */
    public function edit(
        \App\User $user,
        $ability,
        \App\Http\Sections\User $section,
        \App\User $item
    ) {
        if ($user->adminRoles()) {
            if ( ! is_null($item) && $item->roles->name == 'user') {
                return true;
            }
            if ( ! is_null($item) && $item->roles->name == 'moderator') {
                return true;
            }

            return false;
        }

        return true;
    }

    /**
     * @param  \App\User  $user
     * @param $ability
     * @param  \App\Http\Sections\User  $section
     * @param  \App\User  $item
     *
     * @return bool
     */
    public function delete(
        \App\User $user,
        $ability,
        \App\Http\Sections\User $section,
        \App\User $item
    ) {
        return true;
    }

    public function create(
        \App\User $user,
        $ability,
        \App\Http\Sections\User $section,
        \App\User $item
    ) {
        return true;
    }

}
