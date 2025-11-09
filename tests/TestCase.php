<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    /**
     * Create the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // Load bootstrap app
        $app = require __DIR__.'/../bootstrap/app.php';

        // biar larapel idup, perkara ini ga ada jadi ga jalan test nya cik
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
