<?php

namespace Modules\Post\Services;

use Illuminate\Http\Request;
use Modules\Post\Entities\Post;
use Modules\Post\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function findOne(Request $request)
    {
        $postId = $request->get('post_id');

        $post = $this->postRepository->find($postId);

        if ($post) {
            //$post->load('comments');
        }

        return $post;
    }

    public function findMany(Request $request)
    {
        return $this->postRepository->getList($request);
    }

    public function createPost(Request $request)
    {
        $post = $this->postRepository->create($request->all());

        return $post;
    }

    public function updatePost(Post $post, Request $request)
    {
        $post = $this->postRepository->update($post, $request->all());

        return $post;
    }

    public function destroyPost(Post $post)
    {
        $this->postRepository->destroy($post);

        return $this;
    }
}
