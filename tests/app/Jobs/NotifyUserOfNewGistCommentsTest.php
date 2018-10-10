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

class NotifyUserOfNewGistCommentsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $mailSendData;

    protected function setUp()
    {
        parent::setUp();

        Mail::fake();

        $this->user = factory(User::class)->create();

        // @Todo mock github clients

        $gitHubMarkdownParserMock = $this->createMock(GitHubMarkdownParser::class);
        $this->app->instance(GitHubMarkdownParser::class, $gitHubMarkdownParserMock);
    }

    /** @test */
    public function it_does_not_trigger_send_job_for_notified_comments()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_triggers_send_job_for_unnotified_comments()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_triggers_send_job_for_edited_comments()
    {
        $this->markTestIncomplete();
    }
}
