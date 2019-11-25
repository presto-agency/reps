<?php


namespace App\Admin\Policies;
use App\User;
use App\Http\Sections\User as Section;
use App\User as Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSectionModelPolicy
{

    use HandlesAuthorization;

    public function before(User $user, $ability, Section $section, Model $item = null) {
                if ($user->superAdminRole()) {
                    if ($ability != 'display' && ! is_null($item)
                        && $item->roles->name == 'super-admin'
                    ) {
                        return false;
                    }
                }
                if ($user->adminRole()) {
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
                }

        return  true;
    }

    public function display(User $user, $ability, Section $section, Model $item = null) {
        return true;
    }

    public function edit(User $user, $ability, Section $section, Model $item = null) {

        if ($user->adminRole()) {
            if (!is_null($item) && $item->roles->name == 'admin'
            ) {
                return false;
            }
            if (!is_null($item) && $item->roles->name == 'super-admin'
            ) {
                return false;
            }

        }
        return true;
    }

    public function delete(
        User $user, $ability, Section $section, Model $item = null
    ) {
        if ($user->adminRole()) {
            if (!is_null($item) && $item->roles->name == 'admin'
            ) {
                return false;
            }
            if (!is_null($item) && $item->roles->name == 'super-admin'
            ) {
                return false;
            }

        }
        return true;
    }

    public function create(User $user, $ability, Section $section, Model $item = null) {
        if ($user->adminRole()) {
            if (!is_null($item) && $item->roles->name == 'admin'
            ) {
                return false;
            }
            if (!is_null($item) && $item->roles->name == 'super-admin'
            ) {
                return false;
            }

        }
        return true;
    }

}
