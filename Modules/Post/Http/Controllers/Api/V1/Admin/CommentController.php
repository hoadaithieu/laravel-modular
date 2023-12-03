<?php

namespace Modules\Post\Http\Controllers\Api\V1\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Entities\Comment;
use Modules\Post\Entities\Post;
use Modules\Post\Services\CommentService;
use Modules\Post\Transformers\CommentCollection;
use Modules\Post\Transformers\CommentResource;

class CommentController extends Controller
{
    //use HasApiTokens, Notifiable;

    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        //$this->middleware('auth:api', ['except' => ['store', 'show', 'index']]);
        $this->commentService = $commentService;

        return $this;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    //public function index(Post $post, Request $request)
    public function index(Request $request)
    {

        $comments = $this->commentService->getComments($request);

        return new CommentCollection($comments);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('comment::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $comment = $this->commentService->createComment($request);

        //return response()->json($comment);
        return new CommentResource($comment);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    public function show(Request $request)
    {
        $comment = $this->commentService->getComment($request);

        //return response()->json($comment);
        return new CommentResource($comment);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */

    //public function edit($id)
    public function edit(Comment $comment)
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
    public function update(Request $request)
    {

        $comment = $this->commentService->updateComment($request);

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */

    public function destroy(Request $request)
    {
        $this->commentService->destroyComment($request);

        return response()->json(['Deleted']);
    }

}
