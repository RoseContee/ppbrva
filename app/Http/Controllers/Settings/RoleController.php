<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $allPermissions = Role::getAllPermissions();
        $roles = Role::query()->withCount(['users'])->get();
        foreach ($roles as $role) {
            $all = true; $permissions = [];
            $rolePermissions = explode(',', $role['permissions']);
            foreach ($allPermissions as $permission => $p) {
                if (in_array($permission, $rolePermissions)) {
                    $permissions[] = $p['label'];
                } else {
                    $all = false;
                }
            }
            if ($all) $role['permission'] = 'Access to all views';
            else if (empty($permissions)) $role['permission'] = 'No access to any views';
            else $role['permission'] = implode(', ', $permissions);
        }
        return view('settings.roles.index', [
            'roles' => $roles,
        ]);
    }

    public function create() {
        $permissions = Role::getAllPermissions();
        return view('settings.roles.add', [
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'numeric', Role::getPermissionsRule()],
        ]);
        Role::query()->create([
            'name' => $request['name'],
            'permissions' => implode(',', $request['permissions']),
        ]);
        return redirect()->route('settings.roles.index')
            ->with('success_message', 'New role has been added.');
    }

    public function edit($id) {
        $role = Role::query()->find($id);
        if (!$role) return back();
        $permissions = Role::getAllPermissions();
        return view('settings.roles.add', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, $id) {
        $role = Role::query()->find($id);
        if (!$role) return back();
        $request->validate([
            'name' => ['required'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'numeric', Role::getPermissionsRule()],
        ]);
        $role['name'] = $request['name'];
        $role['permissions'] = implode(',', $request['permissions']);
        $role->save();
        return back()->with('info_message', 'Role has been updated.');
    }

    public function destroy(Request $request) {
        $roles = explode(',', $request['roles']);
        Role::query()->whereIn('id', $roles)->delete();
        return back()->with('error_message', 'Roles have been removed.');
    }
}
