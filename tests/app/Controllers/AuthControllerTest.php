<?php

namespace Tests\App\Controllers;

use Tests\BrowserKitTestCase;

class AuthControllerTest extends BrowserKitTestCase
{
    public function testAuthRedirectToReturnsWelcomeRoute()
    {
        $response = $this->get('/home');

        $response->assertRedirectedTo('/');
        $response->assertRedirectedToRoute('welcome');
    }
}
