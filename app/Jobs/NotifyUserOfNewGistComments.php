<?php

namespace App\Jobs;

use App\Concerns\IdentifiesIfACommentNeedsNotification;
use App\GistClient;
use App\NotifiedComment;
use Carbon\Carbon;
use Exception;
use Github\Client as GitHubClient;
use Github\Exception\ExceptionInterface as GithubException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyUserOfNewGistComments extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs, IdentifiesIfACommentNeedsNotification;

    public $tries = 5;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(GistClient $gistClient, GitHubClient $githubClient)
    {
        // Disable--just in case someone runs queueForUsers for some reason
        return;

        Log::debug('Notify user? user ['.$this->user->id.']');

        try {
            $notifiedCommentIds = NotifiedComment::pluck('github_id');

            foreach ($gistClient->all($this->user) as $gist) {
                if ($this->gistCreatedAfterTheDayOfReckoning($gist)) {
                    Log::debug('Skipping gist created after the day of reckoning; gist ['.$gist['id'].']');

                    return;
                }

                Log::debug('Notify comment? user ['.$this->user->id.'] gist ['.$gist['id'].']');

                collect($githubClient->api('gist')->comments()->all($gist['id']))
                    ->filter(function ($comment) use ($notifiedCommentIds) {
                        return (! $notifiedCommentIds->contains($comment['id']))
                            && $this->commentNeedsNotification($comment, $this->user);
                    })
                    ->each(function ($comment) use ($gist) {
                        $this->handleComment($comment, $gist, $this->user);
                    });
            }
        } catch (GithubException $e) {
            Log::info(sprintf(
                'Attempting to queue "get comments" for user %s after GitHub exception. Delayed execution for 60 minutes after (%d) attempts. Message: [%s] Exception class: [%s]',
                $this->user->id,
                $this->attempts(),
                $e->getMessage(),
                get_class($e)
            ));

            $this->handleGitHubException($e);
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

    private function gistCreatedAfterTheDayOfReckoning($gist)
    {
        $date = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $gist['created_at']);
        // Compare against the day GitHub added gist comment notifications *for new gists*
        return $date->greaterThan(Carbon::createFromDate(2019, 5, 8, 'UTC')->startOfDay());
    }

    private function handleComment($comment, $gist, $user)
    {
        Log::debug('Notify comment? user ['.$this->user->id.'] gist ['.$gist['id'].'] comment ['.$comment['id'].']');

        $this->notifyComment($comment, $gist, $user);
    }

    private function notifyComment($comment, $gist, $user)
    {
        Log::debug('Queue notification! user ['.$this->user->id.'] gist ['.$gist['id'].'] comment ['.$comment['id'].']');

        $this->dispatch(new NotifyUserOfNewGistComment(
            $user,
            $comment,
            $gist
        ));
    }

    private function handleGitHubException($e)
    {
        if ($e->getMessage() == 'Bad credentials') {
            Log::error('Bad credentials; cancelling. For user '.$this->user->id);

            return $this->handleBrokenGitHubToken();
        }

        $this->release(3600);
    }

    private function handleBrokenGitHubToken()
    {
        $this->dispatch(new CancelUserForBadCredentials($this->user));

        $this->delete();
    }
}
