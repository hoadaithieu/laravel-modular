<?php

namespace Modules\Post\Http\Controllers\Api\V1\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Entities\Post;
use Modules\Post\Services\PostService;
use Modules\Post\Transformers\PostCollection;
use Modules\Post\Transformers\PostResource;

class PostController extends Controller
{
    //use HasApiTokens, Notifiable;

    protected $postService;

    public function __construct(PostService $postService)
    {
        //$this->middleware('auth:api', ['except' => ['store', 'show', 'index']]);
        $this->postService = $postService;

        return $this;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        $posts = $this->postService->findMany($request);

        return new PostCollection($posts);
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
        $post = $this->postService->createPost($request);

        //return response()->json($post);
        return new PostResource($post);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    //public function show(Post $post)
    public function show(Request $request)
    {

        $post = $this->postService->findOne($request);

        //return response()->json($post);
        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    //public function edit($id)
    public function edit(Post $post)
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
    public function update(Post $post, Request $request)
    {

        $post = $this->postService->updatePost($post, $request);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Post $post)
    {
        $this->postService->destroyPost($post);

        return response()->json($post);
    }

}
