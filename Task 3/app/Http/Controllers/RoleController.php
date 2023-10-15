<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $role= Role::latest()->get();
        $permission = Permission::latest()->get();

        return view('settings.roles.index', ['roles' => $role, 'permissions' => $permission]);
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
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
                'status' => $request->status
            ]);

            DB::commit();
            $request->session()->flash('msg', 'Role is created successfully!');
            return redirect()->route('role.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Role creation: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while saving!');
            return redirect()->route('role.index');
        }
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
        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->name,
                'status' => $request->status
            ]);

            DB::commit();

            $request->session()->flash('msg', 'Role is updated successfully!');
            return redirect()->route('role.index');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Role update: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while updating the role!');
            return redirect()->route('role.index');
        }
    }

    public function delete(Request $request, $id)
    {
        $role = Role::find($id);
        DB::beginTransaction();
        try {
            $role->delete();

            DB::commit();

            $request->session()->flash('msg', 'Role is deleted successfully!');
            return redirect()->route('role.index');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Role delete: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while deleting the role!');
            return redirect()->route('role.index');
        }
    }
}
