<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
     * @param UpdateUserRequest $request
     * @param User $users
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateUserRequest $request, User $users)
    {
        $users->name = $request->get('name');
        $users->email = $request->get('email');

        if ($request->has('password')) {
            $users->password = bcrypt($request->get('password'));
        }

        if ($request->has('roles')) {
            $users->roles()->sync($request->get('roles'));
        }

        if ($request->has('api_only')) {
            $users->api_only = $request->get('api_only');
        }

        $users->save();

        return redirect()->route('users.show', [$users->id])->with('success', 'Die Nutzerdaten wurden erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUserRequest $request
     * @param User $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyUserRequest $request, User $users)
    {
        $users->delete();

        return redirect()->route('users.index')->with('success', 'Der Benutzer wurde erfolgreich gelöscht!');
    }
}
