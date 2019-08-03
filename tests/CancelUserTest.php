<?php

namespace Tests;

use App\User;
use Illuminate\Support\Facades\Mail;
use App\Jobs\NotifyUserOfNewGistComments;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CancelUserTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function itDeletesUserWithBadCredentialsWhenAttemptingToNotifyThem()
    {
        Mail::fake();

        // Create a fake user that will definitely fail GitHub Authentication
        $user = factory(User::class)->create();

        // Attempt to notify the user of new gists
        dispatch(new NotifyUserOfNewGistComments($user));

        // User deleted due to authentication failure
        $this->assertNull(User::find($user->id));
    }
}
