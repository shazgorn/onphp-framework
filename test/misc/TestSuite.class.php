<?php
namespace Onphp\Test;

final class TestSuite extends \PHPUnit\Framework\TestSuite
{
    public function setUp()
    {
        if (AllTests::$workers) {
            $worker = array_pop(AllTests::$workers);
            echo "\nProcessing with {$worker}\n";
            \Onphp\Cache::dropWorkers();
            \Onphp\Cache::setDefaultWorker($worker);
        } else {
            $this->markTestSuiteSkipped('No more workers available.');
        }
    }

    public function tearDown()
    {
        echo "\n";
    }
}
?>
