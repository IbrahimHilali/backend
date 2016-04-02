<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use Grimm\Permission;
use Grimm\Role;
use Grimm\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('roles.create', compact('users', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $id = $request->persist();

        return redirect()
            ->route('roles.show', ['id' => $id])
            ->with('success', trans('users.store.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Role $role */
        $role = Role::query()->with('permissions', 'users')->findOrFail($id);

        return view('roles.show', compact('role'));
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
