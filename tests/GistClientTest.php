<?php

namespace Tests;

use App\User;
use App\GistClient;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GistClientTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'token' => env('TESTING_USER_GITHUB_API_TOKEN'),
        ]);
    }

    /**
     * @requires ApiTest
     *
     * Note: This test is not particularly useful unless you have a token for a user
     * who has more than 30 gists, which is why it requires you to pass in a flag
     * in order for it to run.
     *
     * Sadly, I don't have the time or energy to look up passing in a flag right now,
     * so right now it's just set in the .env.test file.
     */
    public function testItPullsMoreThan30GistsFromTestingUsersAccount()
    {
        $this->markTestSkipped('Needs revisiting.');

        $client = $this->app->make(GistClient::class);
        $this->assertGreaterThan(30, count($client->all($this->user)));
    }

    /**
     * @requires ApiTest
     */
    public function testItPullsAvailableGists()
    {
        $client = $this->app->make(GistClient::class);
        $this->assertNotEmpty($client->all($this->user));
    }
}
