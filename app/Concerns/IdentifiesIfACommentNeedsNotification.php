<?php

namespace App\Concerns;

use App\NotifiedComment;
use App\User;

trait IdentifiesIfACommentNeedsNotification
{
    private function commentNeedsNotification($comment, User $user)
    {
        return ! (
            $comment['updated_at'] < $user->created_at
            || $comment['user']['id'] == $user->github_id
            || NotifiedComment::where('github_id', $comment['id'])->count() > 0
        );
    }
}
