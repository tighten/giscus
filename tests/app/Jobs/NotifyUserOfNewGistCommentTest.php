<?php

namespace Tests\app\Jobs;

use App\User;
use Carbon\Carbon;
use App\Mail\NewComment;
use App\NotifiedComment;
use App\GitHubMarkdownParser;
use Tests\BrowserKitTestCase;
use Illuminate\Support\Facades\Mail;
use App\Jobs\NotifyUserOfNewGistComment;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotifyUserOfNewGistCommentTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $mailSendData;

    private $user;

    protected function setUp() : void
    {
        parent::setUp();

        Mail::fake();

        $this->user = factory(User::class)->make();
        $this->user->created_at = Carbon::now()->year(2016);
        $this->user->save();

        $gitHubMarkdownParserMock = $this->createMock(GitHubMarkdownParser::class);
        $this->app->instance(GitHubMarkdownParser::class, $gitHubMarkdownParserMock);
    }

    public function testItSendsNewCommentEmailWhenNewCommentHasBeenAdded()
    {
        $comment = [
            'id' => 2,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
            'user' => [
                'id' => 'testId',
            ],
        ];

        dispatch(new NotifyUserOfNewGistComment($this->user, $comment, $gist = null));

        Mail::assertSent(NewComment::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
    }

    public function testItDoesNotSendEmailWhenACommentHasBeenEdited()
    {
        $this->createNotifiedComment();

        $comment = [
            'id' => 1,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
            'user' => [
                'id' => 'testId',
            ],
        ];

        dispatch(new NotifyUserOfNewGistComment($this->user, $comment, $gist = 'null'));

        Mail::assertNothingSent();
    }

    public function testItDoesNotSendEmailWhenACommentWasBeforeGiscusUserCreated()
    {
        $comment = [
            'id' => 1,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
        ];

        $user = factory(User::class)->make();
        $user->created_at = Carbon::now();
        $user->save();

        dispatch(new NotifyUserOfNewGistComment($user, $comment, $gist = 'null'));

        Mail::assertNothingSent();
    }

    private function createNotifiedComment()
    {
        return NotifiedComment::create([
            'github_id' => 1,
            'github_updated_at' => '2017-10-03 01:02:03',
        ]);
    }
}
