<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
     $user = session('user');

    if (!$user) {
        return redirect('/login')->with('error', 'Session expired. Please log in again.');
    }

    $role = $user['role'] ?? 'user';

    if ($role === 'admin') {
        return view('admin.dashboard', compact('user'));
    }

    return view('user.dashboard', compact('user'));
    }
public function adminUsers(Request $request)
{
    $token = session('api_token');

    $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/admin/users', [
        'page' => $request->query('page', 1),
        'term' => $request->query('search', '')
    ]);

    $users = $response->json();
     if (isset($users['links'])) {
        foreach ($users['links'] as &$link) {
            if (isset($link['url'])) {
                $url = $link['url'];
                $query = parse_url($url, PHP_URL_QUERY);
                $link['url'] = '/admin/users?' . $query;
            }
        }
    }
   //dd($response->status(), $response->body());

    

    return view('admin.users', compact('users'));
}

public function createUser(Request $request)
{
    $token = session('api_token');

    $response = Http::withToken($token)->post('http://127.0.0.1:8000/api/admin/users', [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'role' => $request->role
    ]);

    if ($response->successful()) {
        return redirect('/admin/users')->with('success', 'User created.');
    }

    return back()->with('error', 'Creation failed.');
}

public function editUser(Request $request, $id)
{
    $token = session('api_token');

    $response = Http::withToken($token)->put("http://127.0.0.1:8000/api/admin/users/$id", [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role
    ]);

    return redirect('/admin/users')->with('success', 'User updated.');
}

public function deleteUser($id)
{
    $token = session('api_token');

    $response = Http::withToken($token)->delete("http://127.0.0.1:8000/api/admin/users/{$id}");

    return redirect('/admin/users')->with('success', 'User deleted.');
}


}
