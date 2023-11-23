<?php

namespace Modules\User\Services;

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(User $user)
    {
        //return $user;
        //return $this->userRepository->getItem($user);
        return $user->load('companies');
    }

    public function getUsers(Request $request)
    {
        return $this->userRepository->getList($request);
    }

    public function createUser(Request $request)
    {
        $user = $this->userRepository->create($request->all());

        return $user;
    }

    public function updateUser(User $user, Request $request)
    {
        $user = $this->userRepository->update($user, $request->all());

        return $user;
    }

    public function destroyUser(User $user)
    {
        $this->userRepository->destroy($user);
        return $this;
    }
}
