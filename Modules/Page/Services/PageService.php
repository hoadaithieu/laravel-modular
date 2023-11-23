<?php

namespace Modules\Page\Services;

use Illuminate\Http\Request;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;

class PageService
{
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getPages()
    {
        return $this->pageRepository->all();
    }

    public function createPage(Request $request)
    {
        $page = $this->pageRepository->create($request->all());

        return $page;
    }

    public function updatePage(Page $page, Request $request)
    {
        $page = $this->pageRepository->update($page, $request->all());

        return $page;
    }

    public function test()
    {
        return 'PageService';
    }
}
