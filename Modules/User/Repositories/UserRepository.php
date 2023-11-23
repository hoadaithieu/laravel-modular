<?php namespace Modules\User\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface UserRepository extends BaseRepository
{
    /**
     * Find the page set as homepage
     * @return object
     */
    public function findUser();

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
