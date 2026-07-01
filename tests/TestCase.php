<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function getTestCaseId(): string
    {
        return 'N/A';
    }

    public function getExpectedResult(): string
    {
        return 'N/A';
    }
}
