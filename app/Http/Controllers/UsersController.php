<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index() {
        $users = User::with(['role'])->get();
        foreach ($users as $user) {
            $user['last_login'] = $user['last_login'] ? date('n/j/y @ g:ia', strtotime($user['last_login'])) : '';
            $user['role_name'] = $user['id'] == 1 ? 'Admin' : $user['role']['name'] ?? '';
        }
        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create() {
        $roles = Role::get();
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
        User::create([
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
        $user = User::find($id);
        if (!$user) return back();
        $roles = Role::get();
        return view('users.add', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
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
        $users = array_filter(explode(',', $request['users']), function($id) {
            return $id != 1;
        });
        User::whereIn('id', $users)->delete();
        return back()->with('error_message', 'Users has been removed.');
    }
}
