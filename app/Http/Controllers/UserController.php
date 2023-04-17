<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // users with photo count
        $users = User::withCount('photos')
            ->orderBy('photos_count', 'desc')
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'Името беше променено успешно');
    }

    public function profile(Request $request)
    {
        if (Auth::check()) {
            $ip = $request->ip();
            $user = auth()->user();
            $photos = Photo::where('user_id', auth()->user()->id)->paginate(10);
            return view('users.profile', compact('ip', 'user', 'photos'));
        }

        return redirect()->route('login')->with('error', 'Трябва да влезнеш за да видиш твор профил');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $user = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->first();

        return view('users.search', compact('user'));
    }
}
