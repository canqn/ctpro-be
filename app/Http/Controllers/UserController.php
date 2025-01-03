<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userprofile()
    {
        return view('userprofile');
    }

    public function about()
    {
        return view('about');
    }


    public function userList()
    {
        $user = User::orderBy('created_at', 'DESC')->paginate(20); // Hiển thị 10 người dùng mỗi trang
        return view('content/users.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content/users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'username' => 'required|unique:users|min:3|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
            'is_active' => 'required|boolean',
        ]);

        // Create a new user instance
        $user = new User();
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->role = $validatedData['role'] == 'admin' ? 1 : 0;
        $user->is_active = $validatedData['is_active'];

        // Save the user to the database
        $user->save();

        // Redirect the user back with a success message
        return redirect()->route('admin/users')->with('success', 'User added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('content/users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        return view('content/users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and sanitize input data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:admin,user',
            'is_active' => 'required|boolean',
        ]);

        // Retrieve user from database
        $user = User::findOrFail($id);

        // Update user data
        $user->update($validatedData);

        // Assign role based on value
        if ($validatedData['role'] === 'admin') {
            $user->role = 1; // Admin value
        } else {
            $user->role = 0; // User value
        }

        // Save user role change
        $user->save();

        // Return success message with redirect
        return redirect()->route('admin/users')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return redirect()->route('admin/users')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('admin/users')->with('error', 'Failed to delete user');
        }
    }
}
