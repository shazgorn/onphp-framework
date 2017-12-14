<?php
namespace Onphp\Test;

final class RangeTest extends TestCase
{
    /**
     * @dataProvider rangeDataProvider
     **/
    public function testCreation($min, $max, $throwsException)
    {
        if ($throwsException) {
            $this->expectException(\Onphp\WrongArgumentException::class);
        }
        $range = \Onphp\Range::create($min, $max);
    }

    public static function rangeDataProvider()
    {
        return array(
            array(
                1, 1, false
            ),
            array(
                1, 222222222222222222222222222, true
            ),
            array(
                0.1, 1, true
            ),
            array(
                0, 1, false
            ),
            array(
                2, 1, false
            )
        );
    }
}
?>
