<?php

namespace App\Http\Controllers;

use App\Models\AnimeList;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        $animeList = AnimeList::where('user_id', auth()->id())->latest()->get();
        return view('anime.index', compact('animeList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'genre'             => 'required|string|max:100',
            'episodes'          => 'required|integer|min:0',
            'episodes_watched'  => 'required|integer|min:0',
            'status'            => 'required|in:Watching,Completed,On Hold,Dropped,Plan to Watch',
            'rating'            => 'nullable|integer|min:1|max:10',
            'notes'             => 'nullable|string',
        ]);

        AnimeList::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return back()->with('toast_success', 'Anime added to your list!');
    }

    public function update(Request $request, AnimeList $anime)
    {
        abort_if($anime->user_id !== auth()->id(), 403);

        $request->validate([
            'title'             => 'required|string|max:255',
            'genre'             => 'required|string|max:100',
            'episodes'          => 'required|integer|min:0',
            'episodes_watched'  => 'required|integer|min:0',
            'status'            => 'required|in:Watching,Completed,On Hold,Dropped,Plan to Watch',
            'rating'            => 'nullable|integer|min:1|max:10',
            'notes'             => 'nullable|string',
        ]);

        $anime->update($request->all());
        return back()->with('toast_success', 'Anime updated successfully!');
    }

    public function destroy(AnimeList $anime)
    {
        abort_if($anime->user_id !== auth()->id(), 403);
        $anime->delete();
        return back()->with('toast_success', 'Anime removed from your list!');
    }
}
