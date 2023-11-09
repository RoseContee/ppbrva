<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::with(['users'])->get();
        $all_permissions = Role::getPermissions();
        foreach ($roles as $role) {
            $role_permissions = explode(',', $role['permissions']);
            $permissions_description = 'No access to any views';
            $permissions = [];
            $all = true;
            foreach ($all_permissions as $permission) {
                if (in_array($permission, $role_permissions)) {
                    $permissions[] = Role::PERMISSIONS[$permission];
                } else {
                    $all = false;
                }
            }
            if ($all) {
                $permissions_description = 'Access to all views';
            } else if (!empty($permissions)) {
                $permissions_description = implode(', ', $permissions);
            }
            $role['permission'] = $permissions_description;
            $role['usersNumber'] = count($role['users']);
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
            'permissions.*' => ['required', 'numeric', Role::gerPermissionsRule()],
        ]);
        Role::create([
            'name' => $request['name'],
            'permissions' => implode(',', $request['permissions']),
        ]);
        return redirect()->route('settings.roles.index')
            ->with('success_message', 'New role has been added.');
    }

    public function edit($id) {
        $role = Role::find($id);
        if (!$role) return back();
        return view('settings.roles.add', [
            'role' => $role,
        ]);
    }

    public function update(Request $request, $id) {
        $role = Role::find($id);
        if (!$role) return back();
        $request->validate([
            'name' => ['required'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'numeric', Role::gerPermissionsRule()],
        ]);
        $role['name'] = $request['name'];
        $role['permissions'] = implode(',', $request['permissions']);
        $role->save();
        return back()->with('info_message', 'Role has been updated.');
    }

    public function destroy(Request $request) {
        $roles = explode(',', $request['roles']);
        Role::whereIn('id', $roles)->delete();
        return back()->with('error_message', 'Roles have been removed.');
    }
}
