<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Role;
//use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        // $role= Role::latest()->get();
        // $permission = Permission::latest()->get();

        // return view('settings.roles.index', ['roles' => $role, 'permissions' => $permission]);
        $roles = Role::all();
        $permissions = Permission::all();

        $rolePermissions = [];
        foreach ($roles as $role) {
            $rolePermissions[$role->id] = $role->permissions->pluck('name');
        }

        return view('settings.roles.index', compact('roles', 'permissions', 'rolePermissions'));

    }

    public function create(){
        return view('settings.roles.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'status' => $request->status
        ]);

        $request->session()->flash('msg', 'Role is created successfully!');
        return redirect()->route('role.index');
    }


    public function edit(Role $role)
    {
        return view('settings.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $role->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        $request->session()->flash('msg', 'Role is updated successfully!');
        return redirect()->route('role.index');
    }

    public function delete(Request $request, $id)
    {
        $role = Role::find($id);

        $role->delete();

        $request->session()->flash('msg', 'Role is deleted successfully!');
        return redirect()->route('role.index');

    }

    public function assignPermissions(Request $request, Role $role)
    {
        $permissions = Permission::all();
        return view('settings.roles.assign-permissions', compact('role', 'permissions'));
    }

    public function storePermissions(Request $request, Role $role)
    {
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->route('role.index')->with('success', 'Permissions assigned successfully');
    }

}
