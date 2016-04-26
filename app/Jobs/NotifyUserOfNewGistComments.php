<?php

namespace App\Jobs;

use App\NotifiedComment;
use Exception;
use Github\Client;
use Github\Exception\ExceptionInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class NotifyUserOfNewGistComments extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(Client $client)
    {
        $client->authenticate($this->user->token, Client::AUTH_HTTP_TOKEN);

        try {
            // @todo: Can we get only those updated since date? the API can.. can our client? and does a new comment make it marked as updated?
            foreach ($client->api('gists')->all() as $gist) {
                foreach ($client->api('gist')->comments()->all($gist['id']) as $comment) {
                    $this->handleComment($comment, $gist, $this->user);
                }
            }
        } catch (ExceptionInterface $e) {
            Log::info(sprintf(
                'Attempting to queue "get comments" for user %s after GitHub exception. Delayed exceution for 60 minutes after (%d) attempts. Message: [%s] Exception class: [%s]',
                $this->user->id,
                $this->attempts(),
                $e->getMessage(),
                get_class($e)
            ));

            $this->release(3600);
        } catch (Exception $e) {
            Log::info(sprintf(
                'Attempting to queue "get comments" for user %s after generic exception. Delayed execution for 2 seconds after (%d) attempts. Message: [%s] Exception class: [%s]',
                $this->user->id,
                $this->attempts(),
                $e->getMessage(),
                get_class($e)
            ));

            $this->release(2);
        }
    }

    private function handleComment($comment, $gist, $user)
    {
        if ($this->commentNeedsNotification($comment, $user)) {
            $this->notifyComment($comment, $gist, $user);
        }
    }

    private function commentNeedsNotification($comment, $user)
    {
        if ($comment['updated_at'] < $user->created_at || $comment['user']['id'] == $user->github_id) {
            return false;
        }

        return NotifiedComment::where('github_id', $comment['id'])
            ->where('github_updated_at', $comment['updated_at'])
            ->count() == 0;
    }

    private function notifyComment($comment, $gist, $user)
    {
        $this->dispatch(new NotifyUserOfNewGistComment(
            $user,
            $comment,
            $gist
        ));
    }
}
