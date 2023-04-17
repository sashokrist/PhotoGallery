<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.loginAsAdmin');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        if ($user !== null && $user->is_admin === 1) {
            Auth::login($user, $remember = true);
            return redirect()->route('users.profile');
        }

        return redirect()->back()->with('error', ' Ти не си АДМИН');
    }

    public function statistics()
    {
        // last 5 users registered
        $latestUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // last 5 photos uploaded with the associated user information
        $latestPhotos = Photo::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 5 most liked photos
        $mostLikedPhotos = Photo::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        return view('admin.index', compact('latestUsers', 'latestPhotos', 'mostLikedPhotos'));
    }

    public function photos()
    {
        $photos = Photo::orderBy('created_at', 'desc')->take(5)->paginate(10);
        foreach ($photos as $photo) {
            $photo->comments = Comment::where('photo_id', $photo->id)->get();
        }

        return view('admin.photos', compact('photos'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function deletePhoto($id)
    {
        $photo = Photo::find($id);
        if ($photo) {
            Comment::where('photo_id', $id)->delete();
            $photo->delete();
            return redirect()->back()->with('success', 'Снимката беше изтрита успешно!');
        }

        return redirect()->back()->with('error', 'Няма намерана снимка.');
    }

    public function getUsers()
    {
        $users = User::withTrashed()->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users', compact('users'));
    }

    /**
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function viewPhotos($id)
    {
        $user = User::findOrFail($id);
        $photos = Photo::where('user_id', $id)->get(); //individual user photos

        return view('admin.view-photos', compact('user', 'photos'));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $user->delete(); //softDelete user, permanently delete photos and comments

        return redirect()->back()->with('success', 'Потребителят беше деактивиран успешно!');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function activateUser($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
            return redirect()->back()->with('success', 'Потребителят беше активиран успешно!');
        }

        return redirect()->back()->with('error', 'User not found.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function deleteUserPermanently($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->photos()->forceDelete();
            $user->forceDelete();
            return redirect()->back()->with('success', 'Потребителят и неговите снимки бяха изтрити успешно!.');
        }

        return redirect()->back()->with('error', 'Потребителят не е намерен!.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function makeAdmin($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_admin = 1; // Set user as admin
            $user->save();
            return redirect()->back()->with('success', 'Потребителят беше направен АДМИН успешно!.');
        }

        return redirect()->back()->with('error', 'Потребителят не е намерен!');
    }
}
