<?php

namespace App\Http\Controllers;

use App\Models\AnimeList;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers  = User::count();
        $totalAnime  = AnimeList::count();
        $myAnime     = AnimeList::where('user_id', auth()->id())->count();

        $statusCounts = AnimeList::where('user_id', auth()->id())
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $genreCounts = AnimeList::where('user_id', auth()->id())
            ->selectRaw('genre, count(*) as count')
            ->groupBy('genre')
            ->orderByDesc('count')
            ->limit(6)
            ->pluck('count', 'genre');

        $recentAnime = AnimeList::where('user_id', auth()->id())
            ->latest()->limit(5)->get();

        return view('dashboard', compact(
            'totalUsers', 'totalAnime', 'myAnime',
            'statusCounts', 'genreCounts', 'recentAnime'
        ));
    }
}
