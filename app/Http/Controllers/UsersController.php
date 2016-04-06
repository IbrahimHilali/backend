<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use Grimm\Permission;
use Grimm\Role;
use Grimm\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexUserRequest $request)
    {
        $users = User::query()->paginate(50);

        $roles = Role::query()->paginate(50);

        $permissions = Permission::orderBy('name', 'asc')->paginate(50);

        return view('users.index', compact('users', 'roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->api_only = $request->get('api_only');
        $user->api_token = str_random(60);

        $user->save();

        $user->roles()->sync($request->get('roles'));

        redirect()->route('user.show', [$user->id])->with('success', trans('user.store_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param ShowUserRequest $request
     * @param User $users
     * @return \Illuminate\Http\Response
     */
    public function show(ShowUserRequest $request, User $users)
    {
        /** @var User $user */
        $user = $users;
        $roles = Role::all();

        return view('users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
