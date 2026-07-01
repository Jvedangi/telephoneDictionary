<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestListener;
use Tests\Listeners\TestResultLogger;

class TestListenerRegistry
{
    public static function getListeners(): array
    {
        return [
            new TestResultLogger(),
        ];
    }
}
