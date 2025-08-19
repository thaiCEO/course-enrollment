<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // List roles
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $roles = Role::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5);
        } else {
            $roles = Role::latest()->paginate(5);
        }

        return view('messages/role/role', [
            'roles' => $roles,
        ]);
    }

    // Show create form
    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('messages/role/form_role', [
            'permissions' => $permissions,
        ]);

    }

    // Store role
 public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|unique:roles,name',
            'permissions' => 'array|nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web', // default guard
        ]);

        // ✅ Convert IDs to permission models
        if ($request->filled('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'បានបង្កើតតួនាទីដោយជោគជ័យ');
    }

    // Show single role
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('messages/role/show_role', [
            'role' => $role,
        ]);
    }

    // Show edit form
  public function edit($id)
{
    $role = Role::findOrFail($id);
    $permissions = \Spatie\Permission\Models\Permission::all();

    return view('messages/role/edit_role', [
        'role' => $role,
        'permissions' => $permissions,
    ]);
}

    // Update role
public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:3|unique:roles,name,' . $role->id,
        'permissions' => 'array|nullable',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $role->update([
        'name' => $request->name,
    ]);

    // ✅ Sync permissions
    if ($request->filled('permissions')) {
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);
    } else {
        $role->syncPermissions([]); // clear if none selected
    }

    return redirect()->route('roles.index')->with('success', 'បានកែប្រែតួនាទីដោយជោគជ័យ');
}


    // Delete role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'បានលុបតួនាទីដោយជោគជ័យ');
    }

    public function deleteSelected(Request $request)
    {
        $ids = explode(',', $request->selected_id);
        Role::whereIn('id', $ids)->delete();

        return response()->json(['status' => 200, 'message' => 'Roles deleted successfully']);
    }

}
