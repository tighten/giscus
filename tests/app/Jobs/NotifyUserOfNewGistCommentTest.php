<?php

namespace Tests\App\Jobs;

use App\GitHubMarkdownParser;
use App\Jobs\NotifyUserOfNewGistComment;
use App\Mail\ModifiedComment;
use App\Mail\NewComment;
use App\NotifiedComment;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\BrowserKitTestCase;

class NotifyUserOfNewGistCommentTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $mailSendData;

    protected function setUp()
    {
        parent::setUp();

        Mail::fake();

        $this->user = factory(User::class)->create();

        $gitHubMarkdownParserMock = $this->createMock(GitHubMarkdownParser::class);
        $this->app->instance(GitHubMarkdownParser::class, $gitHubMarkdownParserMock);
    }

    public function testItSendsNewCommentEmailWhenNewCommentHasBeenAdded()
    {
        $comment = [
            'id' => 2,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
        ];

        dispatch(new NotifyUserOfNewGistComment($this->user, $comment, $gist = null));

        Mail::assertSent(NewComment::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
    }

    public function testItSendsEditCommentEmailWhenACommentHasBeenEdited()
    {
        $this->createNotifiedComment();

        $comment = [
            'id' => 1,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
        ];

        dispatch(new NotifyUserOfNewGistComment($this->user, $comment, $gist = 'null'));

        Mail::assertSent(ModifiedComment::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
    }

    private function createNotifiedComment()
    {
        return NotifiedComment::create([
            'github_id' => 1,
            'github_updated_at' => '2017-10-03 01:02:03',
        ]);
    }
}
