<?php

namespace App\Concerns;

use App\User;
use App\NotifiedComment;

trait IdentifiesIfACommentNeedsNotification
{
    private function commentNeedsNotification($comment, User $user)
    {
        return ! (
            $comment['updated_at'] < $user->created_at
            || $comment['user']['id'] == $user->github_id
            /* This is checked in multiple places as well as here as a "just in case" measure. */
            || NotifiedComment::where('github_id', $comment['id'])->count() > 0
        );
    }
}
