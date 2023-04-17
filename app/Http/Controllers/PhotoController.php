<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhotoRequest;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->take(10)->get();

        return view('photos.index', compact('photos'));
    }

    public function photos()
    {
        $photos = Photo::orderByDesc('created_at')->paginate(10);
        $comments = Comment::with('user')->get();
        $qrCodes = [];
        foreach ($photos as $photo) {
            $qrCode = QrCode::size(50)->generate(asset('images/' . $photo->image));
            $qrCodes[$photo->id] = base64_encode($qrCode);
        }

        return view('photos.photos', compact('comments', 'photos', 'qrCodes'));
    }

    public function store(StorePhotoRequest $request)
    {
        // Check if user has already uploaded 10 photos
        if (auth()->user()->photos->count() >= 10) {
            return back()->with('error', 'Вече има 10 качени снимки.');
        }

        $photo = new Photo();
        $photo->title = $request->title;
        if ($image = $request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $photo->image = $imageName;
        }
        $photo->user_id = auth()->user()->id;
        $photo->save();

        $tags = $request->input('tags', []);
        $photo->tags()->attach($tags);

        return redirect()->route('photos.index')->with('success', 'Снимката е качена успешно');
    }

    public function show(Photo $photo)
    {
        $countLike = $photo->likes()->count();
        $countDislike = $photo->dislikes()->count();
        return view('photos.show', compact('photo', 'countLike', 'countDislike'));
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();

        return redirect()->back()->with('success', 'Снимката беше изтрита успешно');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $photo = Photo::query()
            ->where('title', 'LIKE', "%{$search}%")->first();

        return view('photos.search', compact('photo'));
    }

    public function like(Request $request, Photo $photo)
    {
        auth()->user()->like($photo);

        return redirect()->back();
    }

    public function dislike(Request $request, Photo $photo)
    {
        auth()->user()->dislike($photo);

        return redirect()->back();
    }

    public function getPhotosByTag(Tag $tag)
    {
        $photos = $tag->photo;

        return view('photos.tag', ['photos' => $photos, 'tag_name' => $tag->name]);
    }
}
