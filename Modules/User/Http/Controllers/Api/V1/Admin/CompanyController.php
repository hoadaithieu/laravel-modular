<?php

namespace Modules\User\Http\Controllers\Api\V1\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Company;
use Modules\User\Entities\User;
use Modules\User\Services\CompanyService;
use Modules\User\Transformers\CompanyCollection;
use Modules\User\Transformers\CompanyResource;

class CompanyController extends Controller
{
#    use HasApiTokens, Notifiable;

    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;

        return $this;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request, User $user = null)
    {
        $request->merge(['user' => $user]);

        $companies = $this->companyService->getCompanies($request);

        //return response()->json($companies);
        return new CompanyCollection($companies);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $company = $this->companyService->createCompany($request);

        //return response()->json($company);
        return new CompanyResource($company);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    public function show(Company $company)
    {
        $company = $this->companyService->getCompany($company);

        //return response()->json($company);
        return new CompanyResource($company);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    //public function edit($id)
    public function edit(Company $company)
    {
        //return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    //public function update(Request $request, $id)
    public function update(Company $company, Request $request)
    {

        $company = $this->companyService->updateCompany($company, $request);

        //return response()->json($company);
        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Company $company)
    {
        $this->companyService->destroyCompany($company);

        return response()->json($company);
        //return new CompanyResource($company);
    }
}
