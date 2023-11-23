<?php

namespace Modules\User\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //return ['id' => 1];
        //User::all();
        //$users = User::paginate();
        //$users = User::paginate($request->get('limit') ?? 10, ['*'], 'page');
        //dd($request->all());
        //return response()->json($users);
        /*
        $perPage = 10;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $posts = Post::offset($offset)->limit($perPage)->get();
         */

        /*
        $filters = $request->get('filters');

        $conditions = [
        ['STATUS', '=', $filters['status']],
        ['FIRST_NAME', 'like', '%' . $filters['name'] . '%'],
        ];

        //$users = User::where($conditions)->get();
        $users = User::where($conditions)->paginate($request->get('limit') ?? 10, ['*'], 'page');

        return new UserCollection($users);

         */
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        //$user = User::find($id);
        //User::findOrFail($id)
        //return response()->json($user);
        //return new UserResource($user);
        //return view('user::show');
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
