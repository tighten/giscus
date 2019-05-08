<?php

namespace Tests\app\Jobs;

use App\GistClient;
use App\Jobs\NotifyUserOfNewGistComment;
use App\Jobs\NotifyUserOfNewGistComments;
use App\NotifiedComment;
use App\User;
use Carbon\Carbon;
use Github\Client;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\BrowserKitTestCase;

class NotifyUserOfNewGistCommentsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected function setUp() : void
    {
        parent::setUp();

        Bus::fake();
        Mail::fake();
    }

    /** @test */
    function it_dispatches_individual_comment_notification_job_for_new_comment()
    {
        $user = factory(User::class)->create();

        $comment = [
            'id' => 2,
            'updated_at' => $user->created_at->copy()->addDay(),
            'body' => 'body',
            'user' => [
                'id' => 'test id, different from user id',
            ],
        ];

        $gistClientMock = $this->createMock(GistClient::class);
        $gistClientMock->method('all')->willReturn(collect([['id' => 'testId', 'created_at' => '2018-01-01T01:01:01Z']]));

        $githubClientMock = Mockery::mock(Client::class);
        $githubClientMock->shouldReceive('api->comments->all')->andReturn([$comment]);

        $NotifyUserOfNewGistComments = new NotifyUserOfNewGistComments($user);
        $NotifyUserOfNewGistComments->handle($gistClientMock, $githubClientMock);

        Bus::assertDispatched(NotifyUserOfNewGistComment::class);
    }

    /** @test */
    function it_does_not_dispatch_individual_comment_notification_job_for_already_notified_comment()
    {
        $user = factory(User::class)->create();

        $comment = [
            'id' => 2,
            'updated_at' => $user->created_at->copy()->addDay(),
            'body' => 'body',
            'user' => [
                'id' => 'test id, different from user id',
            ],
        ];

        NotifiedComment::create([
            'github_id' => $comment['id'],
            'github_updated_at' => $comment['updated_at'],
        ]);

        $gistClientMock = $this->createMock(GistClient::class);
        $gistClientMock->method('all')->willReturn(collect([['id' => 'testId']]));

        $githubClientMock = Mockery::mock(Client::class);
        $githubClientMock->shouldReceive('api->comments->all')->andReturn([$comment]);

        $NotifyUserOfNewGistComments = new NotifyUserOfNewGistComments($user);
        $NotifyUserOfNewGistComments->handle($gistClientMock, $githubClientMock);

        Bus::assertNotDispatched(NotifyUserOfNewGistComment::class);
    }

    /** @test */
    function it_does_not_dispatch_individual_comment_notification_job_when_a_comment_was_before_giscus_user_create()
    {
        $comment = [
            'id' => 1,
            'updated_at' => '2017-10-03T02:03:04Z',
            'body' => 'body',
        ];

        $user = factory(User::class)->make();
        $user->created_at = Carbon::now();
        $user->save();

        $gistClientMock = $this->createMock(GistClient::class);
        $gistClientMock->method('all')->willReturn(collect([['id' => 'testId']]));

        $githubClientMock = Mockery::mock(Client::class);
        $githubClientMock->shouldReceive('api->comments->all')->andReturn([$comment]);

        $NotifyUserOfNewGistComments = new NotifyUserOfNewGistComments($user);
        $NotifyUserOfNewGistComments->handle($gistClientMock, $githubClientMock);

        Bus::assertNotDispatched(NotifyUserOfNewGistComment::class);
    }

    // https://github.com/tightenco/giscus/issues/66
    /** @test */
    function it_does_not_dispatch_individual_comment_notification_job_when_a_gist_was_after_the_great_day_of_reckoning()
    {
        $user = factory(User::class)->make();
        $user->created_at = Carbon::now();
        $user->save();

        $gistClientMock = $this->createMock(GistClient::class);
        $gistClientMock->method('all')->willReturn(collect([['id' => 'testId', 'created_at' => '2019-05-09T01:01:01Z']]));

        $githubClientMock = Mockery::mock(Client::class);

        $NotifyUserOfNewGistComments = new NotifyUserOfNewGistComments($user);
        $NotifyUserOfNewGistComments->handle($gistClientMock, $githubClientMock);

        Bus::assertNotDispatched(NotifyUserOfNewGistComment::class);
    }
}
