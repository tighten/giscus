<?php

namespace tests\App\Jobs;

use App\User;
use TestCase;
use App\NotifiedComment;
use App\GitHubMarkdownParser;
use Illuminate\Support\Facades\Mail;
use App\Jobs\NotifyUserOfNewGistComment;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotifyUserOfNewGistCommentTest extends TestCase
{
    use DatabaseMigrations;

    protected $mailSendData;

    public function setUp()
    {
        parent::setUp();

        $gitHubMarkdownParserMock = $this->createMock(GitHubMarkdownParser::class);
        $this->app->instance(GitHubMarkdownParser::class, $gitHubMarkdownParserMock);

        $notifiedComment = new NotifiedComment();
        $notifiedComment->github_id = 1;
        $notifiedComment->github_updated_at = '2017-10-03 01:02:03';
        $notifiedComment->save();

        Mail::shouldReceive('send')
            ->andReturnUsing(function ($view, $data, $callback) {
                $this->mailSendData = [$view, $data, $callback];
            });
    }

    /**
     * @test
     */
    public function itSendsNewCommentEmailWhenNewCommentHasBeenAdded()
    {
        $comment = [
            'id' => 2,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
        ];

        $job = new NotifyUserOfNewGistComment($user = null, $comment, $gist = null);
        $job->handle();

        $this->assertEquals('emails.new-comment', $this->mailSendData[0]);
    }

    /**
     * @test
     */
    public function itSendsEditCommentEmailWhenACommentHasBeenEdited()
    {
        $comment = [
            'id' => 1,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
        ];

        $job = new NotifyUserOfNewGistComment($user = null, $comment, $gist = null);
        $job->handle();

        $this->assertEquals('emails.edit-comment', $this->mailSendData[0]);
    }

    /**
     * @test
     */
    public function itGeneratesUnsubscribeUrl()
    {
        $user = new User([
            'github_id' => 987654,
            'token' => 'ABC123',
        ]);

        $this->assertEquals('https://giscus.co/unsubscribe?id=987654&hash=2e8f94ecbd8dba1da15c888b2ef0dbd3', $user->getUnsubscribeUrl());
    }
}
