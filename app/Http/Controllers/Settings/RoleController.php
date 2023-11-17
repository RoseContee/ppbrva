<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::query()->withCount(['users'])->get();
        $all_permissions = Role::getPermissions();
        foreach ($roles as $role) {
            $all = true; $permissions = [];
            $role_permissions = explode(',', $role['permissions']);
            foreach ($all_permissions as $permission) {
                if (!in_array($permission, $role_permissions)) $all = false;
                else $permissions[] = Role::PERMISSIONS[$permission];
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
        return view('settings.roles.add');
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
        return view('settings.roles.add', [
            'role' => $role,
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
