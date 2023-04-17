<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);

        if (Auth::check()) {
            $photoId = $request->photo_id;
            // Check if user has already stored 10 comments for this photo
            $commentsCount = Comment::where('user_id', auth()->user()->id)
                ->where('photo_id', $photoId)
                ->count();
            if ($commentsCount >= 10) {
                return redirect()->back()->with('error', 'Ти достигна лимита от 10 коментара.');
            }
            Comment::create([
                'user_id' => auth()->user()->id,
                'photo_id' => $photoId,
                'body' => $request->body,
            ]);
            return redirect()->back()->with('success', 'Коментарът е записан успешно!');
        }

        return redirect()->back()->with('error', 'Само влезлите потребители могат да правят коментари.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (auth()->user() !== null && auth()->user()->is_admin === 1) {
            $comment->delete();
            return redirect()->back()->with('success', 'Коментарът е изтрит успешно.');
        }

        return redirect()->back()->with('error', 'Само администраторър може да изтрие коментар.');
    }
}
