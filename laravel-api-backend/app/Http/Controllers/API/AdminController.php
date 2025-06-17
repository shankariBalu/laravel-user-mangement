<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index(Request $request)
    {
         $query = User::query();

    if ($request->has('term')) {
        $term = $request->term;
        $query->where('name', 'like', "%$term%")
              ->orWhere('email', 'like', "%$term%")
              ->orWhere('role', 'like', "%$term%");
    }
        return User::paginate(10);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,manager,user'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'role' => 'in:admin,manager,user'
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }

    public function search(Request $request)
    {
        $term = $request->query('term');

        $users = User::where('name', 'like', "%$term%")
                    ->orWhere('email', 'like', "%$term%")
                    ->orWhere('role', 'like', "%$term%")
                    ->paginate(10);

        return response()->json($users);
    }

}
