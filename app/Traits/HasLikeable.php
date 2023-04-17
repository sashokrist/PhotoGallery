<?php

namespace App\Traits;

use App\Models\Like;
use App\Models\Likeable;

trait HasLikeable
{
    public function like(Likeable $likeable, $state = true)
    {
        if ($like = $likeable->likes()->whereMorphedTo('userable', $this)->first()) {
            $like->update([
                'is_liked' => $state
            ]);
            return;
        }
        app(Like::class)
            ->userable()->associate($this)
            ->likeable()->associate($likeable)
            ->fill([
                'is_liked' => $state
            ])
            ->save();
    }

    public function dislike(Likeable $likeable)
    {
        $this->like($likeable, false);
    }
}
