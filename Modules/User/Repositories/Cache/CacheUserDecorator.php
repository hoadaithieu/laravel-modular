<?php namespace Modules\User\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\User\Repositories\UserRepository;

class CacheUserDecorator extends BaseCacheDecorator implements UserRepository
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->entityName = 'user';
        $this->repository = $user;
    }

    /**
     * Find the User set as homeUser
     *
     * @return object
     */
    public function findUser()
    {
        return $this->cache
            ->tags($this->entityName, 'global')
            ->remember("{$this->locale}.{$this->entityName}.findHomeUser", $this->cacheTime,
                function () {
                    return $this->repository->findUser();
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
