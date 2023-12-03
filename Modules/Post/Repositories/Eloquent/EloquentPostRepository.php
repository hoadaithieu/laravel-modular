<?php namespace Modules\Post\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Post\Events\PostWasCreated;
use Modules\Post\Events\PostWasDeleted;
use Modules\Post\Events\PostWasUpdated;
use Modules\Post\Repositories\PostRepository;

class EloquentPostRepository extends EloquentBaseRepository implements PostRepository
{
    /**
     * Find the page set as homepage
     * @return object
     */
    public function findPost()
    {
        //return $this->model->where('is_home', 1)->first();
        return $this->model->first();
    }

    /**
     * Count all records
     * @return int
     */
    public function countAll()
    {
        return $this->model->count();
    }

    /**
     * @param  mixed  $data
     * @return object
     */
    public function create($data)
    {
        $post = $this->model->create($data);

        event(new PostWasCreated($post->id, $data));

        return $post;
    }

    /**
     * @param $model
     * @param  array  $data
     * @return object
     */
    public function update($model, $data)
    {

        $model->update($data);

        event(new PostWasUpdated($model->id, $data));

        return $model;
    }

    public function destroy($model)
    {
        event(new PostWasDeleted($model));

        return $model->delete();
    }

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug, $locale) {
                $q->where('slug', $slug);
                $q->where('locale', $locale);
            })->with('translations')->first();
        }

        return $this->model->where('slug', $slug)->where('locale', $locale)->first();
    }

    public function getList(Request $request)
    {

        if (method_exists($this->model, 'translations')) {
            //return $this->model->with('translations')->orderBy('CREATED_DATETIME', 'DESC')->paginate($request->get('limit') ?? 10, ['*'], 'page');
            return $this->model->with('translations')->filter()->sort()->paginate($request->get('limit') ?? 10, ['*'], 'page');
        }

        //return $this->model->orderBy('CREATED_DATETIME', 'DESC')->filter()->sort()->paginate($request->get('limit') ?? 10, ['*'], 'page');
        return $this->model->filter()->sort()->paginate($request->get('limit') ?? 10, ['*'], 'page');
    }

}
