<?php

namespace Modules\User\Http\Controllers\Api\V1\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserCollection;
use Modules\User\Transformers\UserResource;

class UserController extends Controller
#class UserController extends Authenticatable

{
#    use HasApiTokens, Notifiable;

    protected $userService;

    public function __construct(UserService $userService)
    {
        //$this->middleware('auth:api', ['except' => ['store', 'show', 'index']]);
        $this->userService = $userService;

        return $this;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $users = $this->userService->findMany($request);

        //return response()->json($users);
        return new UserCollection($users);
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
        $user = $this->userService->createUser($request);

        return response()->json($user);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    //public function show(User $user)
    public function show(Request $request)
    {
        $user = $this->userService->findOne($request);

        //return response()->json($user);
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    //public function edit($id)
    public function edit(User $user)
    {
        //return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    //public function update(Request $request, $id)
    public function update(User $user, Request $request)
    {

        $user = $this->userService->updateUser($user, $request);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $this->userService->destroyUser($user);

        return response()->json($user);
    }

    public function profile()
    {
        if (Auth::check()) {
            //$user = Auth::user();
            //dd($user);
        }
        return new UserResource(auth()->user());
        //return response()->json(auth()->user());
    }

    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Example validation rules
        ]);

        if ($request->file('file')->isValid()) {
            $file = $request->file('file');
            $path = $file->store('uploads'); // 'uploads' is a directory in the storage/app folder

            // Perform database operations or return a response as needed
            // For example: File::create(['path' => $path]);

            //return back()->with('success', 'File uploaded successfully!');
        }

        //return back()->with('error', 'File upload failed. Please try again.');

    }

}
