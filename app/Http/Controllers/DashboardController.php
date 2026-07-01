<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $totalContacts = $user->contacts()->count();
        $totalGroups = $user->contactGroups()->count();
        $favoriteContacts = $user->contacts()->where('favorite', true)->count();
        $recentlyAdded = $user->contacts()->where('created_at', '>=', now()->subDays(7))->count();
        $recentContacts = $user->contacts()->with('group')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalContacts',
            'totalGroups',
            'favoriteContacts',
            'recentlyAdded',
            'recentContacts'
        ));
    }
}
