<?php

namespace tests\App\Jobs;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TestCase;

class UnsubscribeLinkTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        User::create([
            'github_id' => 987654,
            'token' => 'ABC123',
            'email' => 'foo@example.com',
            'avatar' => 'bar.jpg',
        ]);
    }

    /**
     * @test
     */
    public function itGeneratesUnsubscribeUrl()
    {
        $user = User::where('github_id', 987654)->first();

        $expectedUrl = route('unsubscribe', [
            'id' => 987654,
            'hash' => $user->getVerifyHash(),
        ]);

        $this->assertSame($expectedUrl, $user->getUnsubscribeUrl());
    }

    /**
     * @test
     */
    public function itCanUnsubscribeSomeone()
    {
        $user = User::where('github_id', 987654)->first();

        $url = $user->getUnsubscribeUrl();

        $this->visit($url)
            ->seePageIs('/user/confirm-cancel')
            ->click('Yes');

        $this->assertNull(User::where('github_id', 987654)->first());
    }
}
