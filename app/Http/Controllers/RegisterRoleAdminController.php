<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterRoleAdminController extends Controller
{
    // List all admins
    public function index(Request $request)
    {
        $admins = $request->get('search')
            ? Admin::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5)
            : Admin::latest()->paginate(5);

        return view('messages.adminRole.admin_role', compact('admins'));
    }

    // Show create form
    public function create()
    {
        $roles = Role::all(); 
        return view('messages.adminRole.form_admin', compact('roles'));
    }

    // Store new admin
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'is_Admin' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_Admin' => $request->is_Admin ?? 0,
        ]);

        // Assign roles if provided
       if ($request->filled('roles')) {
            $admin->assignRole($request->roles); // Use assignRole, not syncRoles if single
        }

        return redirect()->route('admin-role.index')->with('success', 'Admin created successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::all(); 
        return view('messages.adminRole.edit_admin', compact('admin', 'roles'));
    }

    // Update admin
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
            'is_Admin' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->is_Admin = $request->is_Admin ?? 0;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        // Assign or remove roles
        if ($request->filled('roles')) {
            $admin->syncRoles($request->roles);
        } else {
            $admin->syncRoles([]);
        }

        return redirect()->route('admin-role.index')->with('success', 'Admin updated successfully');
    }

    // Delete admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin-role.index')->with('success', 'Admin deleted successfully');
    }

    // Delete multiple admins
    public function deleteSelected(Request $request)
    {
        $ids = explode(',', $request->selected_id);
        Admin::whereIn('id', $ids)->delete();

        return response()->json(['status' => 200, 'message' => 'Admins deleted successfully']);
    }

    // Show admin details along with roles

public function show($id)
{
    $admin = Admin::findOrFail($id);

    $roles = $admin->getRoleNames(); // Roles list
    $permissions = \Spatie\Permission\Models\Permission::all(); // All permissions
    $adminPermissions = $admin->getAllPermissions()->pluck('name')->toArray(); // Permissions that admin has

    return  view('messages.adminRole.show_admin', compact('admin', 'roles', 'permissions', 'adminPermissions'));
}


}
