<?php namespace Modules\Post\Repositories\Cache;

use Illuminate\Http\Request;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Post\Repositories\CommentRepository;

class CacheCommentDecorator extends BaseCacheDecorator implements CommentRepository
{
    /**
     * @var CommentRepository
     */
    protected $repository;

    public function __construct(CommentRepository $comment)
    {
        parent::__construct();
        $this->entityName = 'post_comments';
        $this->repository = $comment;
    }

    /**
     * Find the Comment set as homeUser
     *
     * @return object
     */
    public function findComment(Request $request)
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.findHomePost", $this->cacheTime,
                function () {
                    return $this->repository->findComment();
                }
            );
    }

    /**
     * Count all records
     * @return int
     */
    public function countAll()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.countAll", $this->cacheTime,
                function () {
                    return $this->repository->countAll();
                }
            );
    }

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale)
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.findBySlugInLocale.{$slug}.{$locale}", $this->cacheTime,
                function () use ($slug, $locale) {
                    return $this->repository->findBySlugInLocale($slug, $locale);
                }
            );
    }
}
