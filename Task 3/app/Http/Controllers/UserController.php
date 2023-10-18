<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        $userRoles = [];

        foreach ($users as $user) {
            $userRoles[$user->id] = $user->getRoleNames();
        }

        return view('settings.users.index', compact('users', 'roles', 'userRoles'));

    }

    public function create(){
        return view('settings.users.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make('password'), //default password id password
                'status' => $request->status
            ]);

            DB::commit();
            $request->session()->flash('msg', 'User is created successfully!');
            return redirect()->route('user.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User creation: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while saving!');
            return redirect()->route('user.index');
        }
    }


    public function edit(User $user)
    {
        return view('settings.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'status' => $request->status
            ]);

            DB::commit();

            $request->session()->flash('msg', 'User is updated successfully!');
            return redirect()->route('user.index');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('User update: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while updating the user!');
            return redirect()->route('user.index');
        }
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        DB::beginTransaction();
        try {
            $user->delete();

            DB::commit();

            $request->session()->flash('msg', 'User is deleted successfully!');
            return redirect()->route('user.index');
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('User delete: ' . $e->getMessage(), []);
            $request->session()->flash('msg', 'Error occurred while deleting the user!');
            return redirect()->route('user.index');
        }
    }

    // public function show(User $user)
    // {
    //     $roles = Role::all();
    //     return view('role-assignment.show', compact('user', 'roles'));
    // }

    public function assignRoles(Request $request, User $user)
    {
        $roles = Role::all();
        return view('user.assign-roles', compact('user', 'roles'));
    }

    public function storeRoles(Request $request, User $user)
    {
        $roles = $request->input('roles', []);
        $user->syncRoles($roles);

        return redirect()->route('user.index')->with('success', 'Roles assigned successfully');
    }
}
