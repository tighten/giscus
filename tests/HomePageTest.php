<?php

namespace Tests;

class HomePageTest extends BrowserKitTestCase
{
    /** @test */
    public function itDisplaysTheWordGiscusOnTheHomepage()
    {
        $this->visit('/')
             ->see('Giscus');
    }
}
