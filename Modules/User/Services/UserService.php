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

    public function findOne(Request $request)
    {

        $userId = $request->get('user_id');

        $user = $this->userRepository->find($userId);

        if ($user) {
            //$post->load('comments');
        }

        return $user;
    }

    public function findMany(Request $request)
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
