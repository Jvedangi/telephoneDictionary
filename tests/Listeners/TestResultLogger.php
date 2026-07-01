<?php

namespace Tests\Listeners;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use Tests\TestCase;

class TestResultLogger implements \PHPUnit\Framework\TestListener
{
    public function addError(Test $test, \Throwable $t, float $time): void
    {
        if ($test instanceof TestCase) {
            $this->log($test, 'FAIL', $t->getMessage());
        }
    }

    public function addWarning(Test $test, \PHPUnit\Framework\Warning $e, float $time): void
    {
        // Not implemented
    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
        if ($test instanceof TestCase) {
            $this->log($test, 'FAIL', $e->getMessage());
        }
    }

    public function addIncompleteTest(Test $test, \Throwable $t, float $time): void
    {
        // Not implemented
    }

    public function addRiskyTest(Test $test, \Throwable $t, float $time): void
    {
        // Not implemented
    }

    public function addSkippedTest(Test $test, \Throwable $t, float $time): void
    {
        // Not implemented
    }

    public function startTestSuite(TestSuite $suite): void
    {
        // Not implemented
    }

    public function endTestSuite(TestSuite $suite): void
    {
        // Not implemented
    }

    public function startTest(Test $test): void
    {
        // Not implemented
    }

    public function endTest(Test $test, float $time): void
    {
        if ($test instanceof TestCase) {
            $this->log($test, 'PASS');
        }
    }

    protected function log(Test $test, string $status, string $actualResult = ''): void
    {
        if (!$test instanceof TestCase) {
            return;
        }

        DB::table('test_case_results')->insert([
            'test_case_id' => $test->getTestCaseId(),
            'test_name' => get_class($test),
            'expected_result' => $test->getExpectedResult(),
            'actual_result' => $actualResult,
            'status' => $status,
            'executed_by' => 'system',
            'executed_at' => now(),
        ]);
    }
}
