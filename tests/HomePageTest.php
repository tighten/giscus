<?php

namespace Tests;

class HomePageTest extends TestCase
{
    /** @test */
    public function itDisplaysTheWordGiscusOnTheHomepage()
    {
        $this->visit('/')
             ->see('Giscus');
    }
}
