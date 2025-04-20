<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Filter by role if specified
        if ($request->has('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        
        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        $groups = Group::where('active', true)->get();
        return view('admin.users.create', compact('roles', 'groups'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'group_id' => ['nullable', 'exists:groups,id']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'group_id' => $request->group_id,
        ]);

        // Assign the selected role to the user
        $role = Role::findOrFail($request->role_id);
        $user->roles()->attach($role);

        return redirect()->route('users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $groups = Group::where('active', true)->get();
        return view('admin.users.edit', compact('user', 'roles', 'groups'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'group_id' => ['nullable', 'exists:groups,id']
        ];

        // إضافة قواعد التحقق من كلمة المرور فقط إذا تم تقديمها
        if ($request->filled('password')) {
            $validationRules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($validationRules);

        // تحديث البيانات الأساسية
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'group_id' => $request->group_id,
        ];

        // تحديث كلمة المرور فقط إذا تم تقديمها
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // تحديث دور المستخدم
        $user->roles()->sync([$request->role_id]);

        return redirect()->route('users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Display a listing of students.
     *
     * @return \Illuminate\View\View
     */
    public function students()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Student');
        })->with('roles')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a listing of teachers.
     *
     * @return \Illuminate\View\View
     */
    public function teachers()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Teacher');
        })->with('roles')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }
}
