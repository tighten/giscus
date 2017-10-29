<?php

namespace Tests;

use App\Jobs\NotifyUserOfNewGistComments;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mail;

class CancelUserTest extends TestCase
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
