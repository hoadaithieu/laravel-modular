<?php

namespace Modules\Post\Services;

use Illuminate\Http\Request;
use Modules\Post\Repositories\CommentRepository;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getComment(Request $request)
    {
        return $this->commentRepository->findComment($request);
    }

    public function getComments(Request $request)
    {
        return $this->commentRepository->getList($request);
    }

    public function createComment(Request $request)
    {
        $comment = $this->commentRepository->create($request->all());

        return $comment;
    }

    public function updateComment(Request $request)
    {
        $comment = null;

        $commentId = $request->get('comment_id');

        if ($commentId) {
            $comment = $this->commentRepository->find($commentId);
        }

        if (!$comment) {
            return null;
        }

        $comment = $this->commentRepository->update($comment, $request->all());

        return $comment;
    }

    public function destroyComment(Request $request)
    {
        $comment = null;

        $commentId = $request->get('comment_id');

        if ($commentId) {
            $comment = $this->commentRepository->find($commentId);
        }

        if (!$comment) {
            return null;
        }

        $this->commentRepository->destroy($comment);

        return $this;
    }
}
