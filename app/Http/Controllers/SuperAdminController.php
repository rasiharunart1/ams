<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'apoteker')->count();
        $activeUsers = User::where('role', 'apoteker')
            ->where(function($q) {
                $q->whereNull('subscription_ends_at')
                  ->orWhere('subscription_ends_at', '>=', now());
            })->count();
        $expiredUsers = $totalUsers - $activeUsers;

        $recentLogs = ActivityLog::with('user')->latest()->take(10)->get();

        return view('superadmin.dashboard', compact('totalUsers', 'activeUsers', 'expiredUsers', 'recentLogs'));
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->latest()->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:apoteker,superadmin'],
            'subscription_ends_at' => ['nullable', 'date'],
            'subscription_message' => ['nullable', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'subscription_ends_at' => $request->subscription_ends_at,
            'subscription_message' => $request->subscription_message,
            'email_verified_at' => now(), // Auto verify for admin created users
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'role' => ['required', 'in:apoteker,superadmin'],
            'subscription_ends_at' => ['nullable', 'date'],
            'subscription_message' => ['nullable', 'string'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'subscription_ends_at' => $request->subscription_ends_at,
            'subscription_message' => $request->subscription_message,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['required', Rules\Password::defaults()]]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function resetData(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // Disable foreign key checks to truncate tables
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        \App\Models\StockIn::truncate();
        \App\Models\StockOut::truncate();
        \App\Models\Product::truncate();
        \App\Models\Category::truncate();
        \App\Models\ActivityLog::truncate();
        
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return back()->with('success', 'Semua data master dan transaksi berhasil direset.');
    }
}