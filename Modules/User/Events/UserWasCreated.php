<?php namespace Modules\User\Events;

class UserWasCreated
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var int
     */
    public $userId;

    public function __construct($userId, array $data)
    {
        $this->data = $data;
        $this->userId = $userId;
    }
}
