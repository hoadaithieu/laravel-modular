<?php namespace Modules\User\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CompanyRepository extends BaseRepository
{
    /**
     * Find the page set as homepage
     * @return object
     */
    public function findCompany();

    /**
     * Count all records
     * @return int
     */
    public function countAll();

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale);
}
