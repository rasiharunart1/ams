<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->role !== 'superadmin') {
            if (!$user->subscription_ends_at || Carbon::parse($user->subscription_ends_at)->isPast()) {
                // Allow access to profile and logout even if expired
                if (!$request->routeIs('profile.*') && !$request->routeIs('logout')) {
                    $message = $user->subscription_message ?: 'Masa berlangganan Anda telah habis. Silakan hubungi Super Admin untuk memperpanjang akses Anda.';
                    return redirect()->route('profile.edit')->with('subscription_expired', $message);
                }
            }
        }

        return $next($request);
    }
}