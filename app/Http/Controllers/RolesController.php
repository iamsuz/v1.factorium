<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles= Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->all());

        if (Request::wantsJson()) {
            return $role;
        } else {
            return redirect()->route('roles.index')->withMessage('<p class="alert alert-success text-center">New Role is Created</p>');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        $users = $role->users;
        return view('roles.show', compact('role', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $status = $role->update($request->all());
        if($status) {
            return redirect()->route('roles.edit', [$role])->withMessage('<p class="alert alert-success text-center">updated Successfully</p>');
        }
        return redirect()->route('roles.edit', [$role])->withMessage('<p class="alert alert-danger text-center">not updated Successfully</p>');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
