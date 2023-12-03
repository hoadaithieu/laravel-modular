<?php namespace Modules\Post\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Post\Events\CommentWasCreated;
use Modules\Post\Events\CommentWasDeleted;
use Modules\Post\Events\CommentWasUpdated;
use Modules\Post\Repositories\CommentRepository;

class EloquentCommentRepository extends EloquentBaseRepository implements CommentRepository
{
    /**
     * Find the page set as homepage
     * @return object
     */
    public function findComment(Request $request)
    {
        if ($request->get('comment_id')) {
            $this->model = $this->model->where('id', $request->get('comment_id'));
        }

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
        $comment = $this->model->create($data);

        event(new CommentWasCreated($comment->id, $data));

        return $comment;
    }

    /**
     * @param $model
     * @param  array  $data
     * @return object
     */
    public function update($model, $data)
    {

        $model->update($data);

        event(new CommentWasUpdated($model->id, $data));

        return $model;
    }

    public function destroy($model)
    {
        event(new CommentWasDeleted($model));

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

        if ($request->get('post_id') > 0) {
            $this->model = $this->model->where('post_id', $request->get('post_id'));
        }

        if (method_exists($this->model, 'translations')) {
            //return $this->model->with('translations')->orderBy('CREATED_DATETIME', 'DESC')->paginate($request->get('limit') ?? 10, ['*'], 'page');
            return $this->model->with('translations')->filter()->sort()->paginate($request->get('limit') ?? 10, ['*'], 'page');
        }

        //return $this->model->orderBy('CREATED_DATETIME', 'DESC')->filter()->sort()->paginate($request->get('limit') ?? 10, ['*'], 'page');
        return $this->model->filter()->sort()->paginate($request->get('limit') ?? 10, ['*'], 'page');
    }
}
