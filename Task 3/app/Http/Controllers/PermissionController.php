<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\Permission;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::latest()->get();

        return view('settings.permissions.index', ['permissions' => $permission]);
    }

    public function create(){
        return view('settings.permissions.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $permission = Permission::create([
                'name' => $request->name,
                'guard_name' => 'web',
                'description' => $request->description
            ]);

            DB::commit();
            $request->session()->flash('msg', 'Permission is created successfully!');
            return redirect()->route('permission.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Permission creation: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while saving!');
            return redirect()->route('permission.index');
        }
    }


    public function edit(Permission $permission)
    {
        return view('settings.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $permission->update([
                'name' => $request->name,
                'status' => $request->description
            ]);

            DB::commit();

            $request->session()->flash('msg', 'Permission is updated successfully!');
            return redirect()->route('permission.index');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Permission update: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while updating the permission!');
            return redirect()->route('permission.index');
        }
    }

    public function delete(Request $request, $id)
    {
        $permission = Permission::find($id);
        DB::beginTransaction();
        try {
            $permission->delete();

            DB::commit();

            $request->session()->flash('msg', 'Permission is deleted successfully!');
            return redirect()->route('permission.index');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('permission delete: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while deleting the permission!');
            return redirect()->route('permission.index');
        }
    }
}
