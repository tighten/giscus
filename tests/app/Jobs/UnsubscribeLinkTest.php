<?php

namespace tests\App\Jobs;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TestCase;

class UnsubscribeLinkTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        // Add a sample user
        User::create([
            'github_id' => 987654,
            'token' => 'ABC123',
            'email' => 'foo@example.com',
            'avatar' => 'bar.jpg',
        ])->save();
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

        // Generate unsubscribe URL
        $url = $user->getUnsubscribeUrl();

        // Follow the URL and click "Yes"
        $this->visit($url)
            ->seePageIs('/user/confirm-cancel')
            ->click('Yes');

        // Check that the user no longer exists
        $this->assertNull(User::where('github_id', 987654)->first());
    }
}
