<?php namespace Modules\User\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\User\Repositories\CompanyRepository;

class CacheCompanyDecorator extends BaseCacheDecorator implements CompanyRepository
{
    /**
     * @var CompanyRepository
     */
    protected $repository;

    public function __construct(CompanyRepository $company)
    {
        parent::__construct();
        $this->entityName = 'company';
        $this->repository = $company;
    }

    /**
     * Find the User set as homeUser
     *
     * @return object
     */
    public function findCompany()
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
