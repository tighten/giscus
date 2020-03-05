<?php

namespace Tests;

use App\Jobs\NotifyUserOfNewGistComments;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;

class CancelUserTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itDeletesUserWithBadCredentialsWhenAttemptingToNotifyThem()
    {
        // This test fails when the app is disabled. Commenting out line 34 in
        // App\Jobs\NotifyUserOfNewGistComments makes this pass
        $this->markTestSkipped();

        Mail::fake();

        // Create a fake user that will definitely fail GitHub Authentication
        $user = factory(User::class)->create();

        // Attempt to notify the user of new gists
        dispatch(new NotifyUserOfNewGistComments($user));

        // User deleted due to authentication failure
        $this->assertNull(User::find($user->id));
    }
}
