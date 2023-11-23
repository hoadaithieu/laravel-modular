<?php namespace Modules\User\Events;

class CompanyWasCreated
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var int
     */
    public $companyId;

    public function __construct($companyId, array $data)
    {
        $this->data = $data;
        $this->companyId = $companyId;
    }
}
