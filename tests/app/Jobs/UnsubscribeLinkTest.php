<?php

namespace Tests\app\Jobs;

use App\User;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UnsubscribeLinkTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    public function testItGeneratesUnsubscribeUrl()
    {
        $user = factory(User::class)->create();

        $expectedUrl = route('unsubscribe', [
            'id' => $user->github_id,
            'hash' => $user->getVerifyHash(),
        ]);

        $this->assertSame($expectedUrl, $user->getUnsubscribeUrl());
    }

    public function testItCanUnsubscribeSomeone()
    {
        $user = factory(User::class)->create();

        $this->visit($user->getUnsubscribeUrl())
            ->seePageIs('/user/confirm-cancel')
            ->click('Yes');

        $this->assertEmpty(User::all());
    }
}
