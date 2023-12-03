<?php

namespace Modules\Page\Http\Controllers\Api\V1\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Services\PageService;

//use Modules\Page\Transformers\UserCollection;
//use Modules\Page\Transformers\UserResource;

class PageController extends Controller
{
#    use HasApiTokens, Notifiable;
    /**
     * @var PageRepository
     */
    private $pageService;

    //public function __construct(PageRepository $page)
    public function __construct(PageService $pageService)
    {
        //parent::__construct();

        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        //$pages = $this->pageRepository->all();
        $pages = $this->pageService->getPages();

        return response()->json($pages);
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
    //public function store(Request $request)
    public function store(CreatePageRequest $request)
    {
        //$page = $this->pageRepository->create($request->all());
        $page = $this->pageService->createPage($request);

        return response()->json($page);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    //public function show($id)
    public function show($page)
    {

        //$page = $this->page->find($id);

        return response()->json($page);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
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
    public function update(Page $page, UpdatePageRequest $request)
    {
        //$this->pageRepository->update($page, $request->all());
        $page = $this->pageService->updatePage($page, $request);

        return response()->json($page);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    //public function destroy($id)
    //{
    //
    public function destroy(Page $page)
    {
        $this->pageRepository->destroy($page);
        return response()->json($page);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function postsAtHomePage(Request $request)
    {
        //$pages = $this->pageRepository->all();
        $pages = $this->pageService->getPostsAtHomePage();

        return response()->json($pages);
    }

}
