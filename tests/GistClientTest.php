<?php

namespace Tests;

use App\GistClient;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\app\Gist;

class GistClientTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'token' => env('TESTING_USER_GITHUB_API_TOKEN'),
        ]);
    }

    public function testItPullsMoreThan30GistsFromTestingUsersAccount()
    {
        $gistList = factory(Gist::class, 35)->make()->toArray();
        $client = $this->createMock(GistClient::class);
        $client->method('all')->willReturn($gistList);

        $this->assertGreaterThan(30, count($client->all($this->user)));
    }

    public function testItPullsAvailableGists()
    {
        $gistList = factory(Gist::class, 2)->make()->toArray();
        $client = $this->createMock(GistClient::class);
        $client->method('all')->willReturn($gistList);
        $response = $client->all($this->user);

        $this->assertNotEmpty($response);
        $this->assertArrayNotHasKey('url', $response);
        $this->assertArrayNotHasKey('files', $response);
    }
}
