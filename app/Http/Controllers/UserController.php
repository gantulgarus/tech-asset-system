<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $branches = Branch::all();
        return view('users.create', compact('roles', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'branch_id' => 'required|integer',
            'role_id' => 'required|integer',
            'division' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $input['password'] = Hash::make($request->password);

        User::create($input);

        LogActivity::addToLog("Хэрэглэгч амжилттай бүртгэгдлээ.");

        return redirect()->route('users.index')->with('success', 'Хэрэглэгч амжилттай бүртгэгдлээ.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $branches = Branch::all();

        return view('users.edit', compact('user', 'roles', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'branch_id' => 'required|integer',
            'role_id' => 'required|integer',
            'division' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $input = $request->all();

        if (trim($request->password) == '') {
            $input = $request->except('password');
        } else {
            $input['password'] = Hash::make($request->password);
        }

        $user->update($input);

        LogActivity::addToLog("Хэрэглэгч амжилттай засагдлаа.");

        return redirect()->route('users.index')->with('success', 'Хэрэглэгч амжилттай засагдлаа.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        LogActivity::addToLog("Хэрэглэгч амжилттай устгагдлаа.");

        return redirect()->route('users.index')->with('success', 'Хэрэглэгч амжилттай устгагдлаа.');
    }
}