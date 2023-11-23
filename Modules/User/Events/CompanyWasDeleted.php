<?php

namespace Modules\User\Events;

class CompanyWasDeleted
{
    /**
     * @var object
     */
    public $company;

    public function __construct($company)
    {
        $this->company = $company;
    }
}
