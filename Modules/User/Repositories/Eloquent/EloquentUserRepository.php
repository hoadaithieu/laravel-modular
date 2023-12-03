<?php namespace Modules\User\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\User\Events\UserWasCreated;
use Modules\User\Events\UserWasDeleted;
use Modules\User\Events\UserWasUpdated;
use Modules\User\Repositories\UserRepository;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    /**
     * Find the page set as homepage
     * @return object
     */
    public function findUser()
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
        $user = $this->model->create($data);

        event(new UserWasCreated($user->id, $data));

        return $user;
    }

    /**
     * @param $model
     * @param  array  $data
     * @return object
     */
    public function update($model, $data)
    {
        $companyIds = [4, 6];

        //if (!$model->companies()->wherePivot('COMPANY_ID', $companyId)->exists()) {
        if (!$model->companies()->wherePivotIn('COMPANY_ID', $companyIds)->exists()) {
            $model->companies()->attach($companyIds);
        }

        $model->update($data);

        event(new UserWasUpdated($model->id, $data));

        return $model;
    }

    public function destroy($model)
    {
        event(new UserWasDeleted($model));

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

    /*
public function getItem($model)
{
//return $model->with('companies');
return $model->load('companies');
}
 */
}
