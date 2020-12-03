<?php

namespace App\Policies;

use App\Http\Controllers\Api\AuthController;
use App\Http\Resources\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class Permissions
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function login(User $User, AuthController $Auth): Response
    {
        return $User->active ? $this->allow() : $this->deny();
    }

    //public function create(User $User, $args): Response
    public function read(User $User, $args): Response
    {
        return $this->allow();
        return UserRoles::where('user_id', $User->id)->where('create', true) ? $this->allow() : $this->deny();
    }
}
