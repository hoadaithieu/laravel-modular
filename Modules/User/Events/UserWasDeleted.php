<?php

namespace Modules\User\Events;

class UserWasDeleted
{
    /**
     * @var object
     */
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
