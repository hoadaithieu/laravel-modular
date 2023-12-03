<?php namespace Modules\Post\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Post\Repositories\PostRepository;

class CachePostDecorator extends BaseCacheDecorator implements PostRepository
{
    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $post)
    {
        parent::__construct();
        $this->entityName = 'post';
        $this->repository = $post;
    }

    /**
     * Find the Post set as homeUser
     *
     * @return object
     */
    public function findPost()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.findHomePost", $this->cacheTime,
                function () {
                    return $this->repository->findPost();
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
