<?php

namespace App\Http\Controllers;


use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\StorePermissionsRequest;
use App\Http\Requests\Admin\UpdatePermissionsRequest;
use RealRashid\SweetAlert\Facades\Alert;
class PermissionController extends Controller
{
    
    public function index()
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }

        $permissions = Permission::all();

        return view('back.pages.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating new Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        return view('back.pages.permissions.create');
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \App\Http\Requests\StorePermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionsRequest $request)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        Permission::create($request->all());
        session()->flash('success', 'Permission has been created !!');
        return redirect()->route('admin.permissions.index');
    }


    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
       
        $permission = Permission::find($id);
      
        return view('back.pages.permissions.edit', compact('permission'));
    }

    /**
     * Update Permission in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionsRequest $request,  $id)
    {
        
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $permission = Permission::find($id);
        $permission->update($request->all());
        session()->flash('success', 'Permission has been updated !!');
        return redirect()->route('admin.permissions.index');
    }


    /**
     * Remove Permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
        $permission = Permission::find($id);
        $permission->delete();
        session()->flash('success', 'Permission has been deleted !!');
        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Permission::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
