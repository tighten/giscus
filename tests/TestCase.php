<?php

namespace Tests;

use Dotenv\Dotenv;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        if (file_exists(dirname(__DIR__) . '/.env.test')) {
            (new Dotenv(dirname(__DIR__), '.env.test'))->load();
        }

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function checkRequirements()
    {
        parent::checkRequirements();

        if (file_exists(dirname(__DIR__) . '/.env.test')) {
            (new Dotenv(dirname(__DIR__), '.env.test'))->load();
        }

        collect($this->getAnnotations())->each(function ($location) {
            if (! isset($location['requires'])) {
                return;
            }

            if (in_array('ApiTest', $location['requires'])) {
                if (! env('TEST_API')) {
                    $this->markTestSkipped('Skipping API tests');
                }
            }
        });
    }
}
