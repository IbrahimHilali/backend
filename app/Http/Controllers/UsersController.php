<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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

        return view('users.index', compact('users', 'roles'));
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

        if ($request->has('roles')) {
            $user->roles()->sync($request->get('roles'));
        }

        return redirect()->route('users.show', [$user->id])->with('success', trans('users.store_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param ShowUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(ShowUserRequest $request, User $user)
    {
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
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        if ($request->has('roles')) {
            $user->roles()->sync($request->get('roles'));
        }

        if ($request->has('api_only')) {
            $user->api_only = $request->get('api_only');
        }

        $user->save();

        return redirect()->route('users.show', [$user->id])->with('success', 'Die Nutzerdaten wurden erfolgreich aktualisiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyUserRequest $request, User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Der Benutzer wurde erfolgreich gelöscht!');
    }
}
