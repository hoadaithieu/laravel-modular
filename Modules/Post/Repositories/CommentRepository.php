<?php namespace Modules\Post\Repositories;

use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface CommentRepository extends BaseRepository
{
    /**
     * Find the page set as homepage
     * @return object
     */
    public function findComment(Request $request);

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
