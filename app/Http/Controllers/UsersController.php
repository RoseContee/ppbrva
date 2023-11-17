<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index() {
        $users = User::query()->with(['role'])->get();
        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create() {
        $roles = Role::query()->get();
        return view('users.add', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,id'],
        ]);
        User::query()->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'phone' => $request['phone'],
            'role_id' => $request['role'],
            'active' => !empty($request['status']),
        ]);
        return redirect()->route('users.index')
            ->with('success_message', 'New user has been added.');
    }

    public function edit($id) {
        $user = User::query()->find($id);
        if (!$user) return back();
        $roles = Role::query()->get();
        return view('users.add', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id) {
        $user = User::query()->find($id);
        if (!$user) return back();
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user['id'])],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,id'],
        ]);
        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        $user['password'] = bcrypt($request['password']);
        $user['phone'] = $request['phone'];
        $user['role_id'] = $request['role'];
        $user['active'] = $user['id'] == 1 || !empty($request['status']);
        $user->save();
        return back()->with('info_message', 'User has been updated.');
    }

    public function destroy(Request $request) {
        $users = explode(',', $request['users']);
        User::query()
            ->where('id', '<>', 1)
            ->whereIn('id', $users)
            ->delete();
        return back()->with('error_message', 'Users have been removed.');
    }
}
