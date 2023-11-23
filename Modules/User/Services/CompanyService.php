<?php

namespace Modules\User\Services;

use Illuminate\Http\Request;
use Modules\User\Entities\Company;
use Modules\User\Repositories\CompanyRepository;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getCompany(Company $company)
    {
        return $company;
    }

    public function getCompanies(Request $request)
    {
        return $this->companyRepository->getList($request);
    }

    public function createCompany(Request $request)
    {
        $company = $this->companyRepository->create($request->all());

        return $company;
    }

    public function updateCompany(Company $company, Request $request)
    {
        $company = $this->companyRepository->update($company, $request->all());

        return $company;
    }

    public function destroyCompany(Company $company)
    {
        $this->companyRepository->destroy($company);

        return $this;
    }
}
