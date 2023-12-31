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
use Modules\Post\Services\PostService;
use Modules\Post\Transformers\PostResource;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserResource;

//use Modules\Page\Transformers\UserCollection;
//use Modules\Page\Transformers\UserResource;

class PageController extends Controller
{
#    use HasApiTokens, Notifiable;
    /**
     * @var PageRepository
     */
    private $pageService;
    private $postService;
    private $userService;

    //public function __construct(PageRepository $page)
    public function __construct(PageService $pageService, PostService $postService, UserService $userService)
    {
        //parent::__construct();

        $this->pageService = $pageService;
        $this->postService = $postService;
        $this->userService = $userService;

        return $this;
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
        $pages = $this->pageService->getPostsAtHomePage($request);

        $posts = $this->postService->findMany($request);
        $users = $this->userService->findMany($request);

        return response()->json($pages);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function postAtHomePage(Request $request)
    {
        //$pages = $this->pageRepository->all();
        //$pages = $this->pageService->getPostsAtHomePage($request);

        $post = $this->postService->findOne($request);

        $userRequest = clone $request;
        $userRequest->merge(['user_id' => $post->user_id]);

        $user = $this->userService->findOne($userRequest);

        $postData = new PostResource($post);
        $userData = new UserResource($user);

        $data = [
            'post' => $postData,
            'user' => $userData,
        ];

        return response()->json($data);
    }
}
