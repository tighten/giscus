<?php

namespace tests\App\Jobs;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

/**
 * @coversNothing
 */
class UnsubscribeLinkTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $user;

    protected function setUp()
    {
        parent::setUp();

        factory(User::class)->create([
            'github_id' => 987654,
            'token' => 'ABC123',
            'email' => 'foo@example.com',
            'avatar' => 'bar.jpg',
        ]);
    }

    public function testItGeneratesUnsubscribeUrl()
    {
        $user = User::where('github_id', 987654)->first();

        $expectedUrl = route('unsubscribe', [
            'id' => 987654,
            'hash' => $user->getVerifyHash(),
        ]);

        $this->assertSame($expectedUrl, $user->getUnsubscribeUrl());
    }

    public function testItCanUnsubscribeSomeone()
    {
        $user = User::where('github_id', 987654)->first();

        $url = $user->getUnsubscribeUrl();

        $this->visit($url)
            ->seePageIs('/user/confirm-cancel')
            ->click('Yes');

        $this->assertNull(User::where('github_id', 987654)->first());
    }
}
