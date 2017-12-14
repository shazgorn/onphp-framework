<?php
/* $Id$ */

namespace Onphp\Test;

final class TruncateQueryTest extends TestCaseDB
{
    public function testQuery()
    {
        $pgDialect = $this->getDbByType('\Onphp\PgSQL')->getDialect();
        // $myDialect = $this->getDbByType('\Onphp\MySQLim')->getDialect();
        // $liteDialect = $this->getDbByType('\Onphp\SQLitePDO')->getDialect();

        $query = \Onphp\OSQL::truncate('single_table');

        try {
            \Onphp\OSQL::truncate()->toDialectString(\Onphp\ImaginaryDialect::me());
            $this->fail();
        } catch (\Onphp\WrongArgumentException $e) {
            /* pass */
        }

        $this->assertEquals(
            $query->toDialectString(\Onphp\ImaginaryDialect::me()),
            'DELETE FROM single_table;'
        );

        $this->assertEquals(
            $query->toDialectString($pgDialect),
            'TRUNCATE TABLE "single_table";'
        );

        $query = \Onphp\OSQL::truncate(array('foo', 'bar', 'bleh'));

        $this->assertEquals(
            $query->toDialectString(\Onphp\ImaginaryDialect::me()),
            'DELETE FROM foo; DELETE FROM bar; DELETE FROM bleh;'
        );

        $this->assertEquals(
            $query->toDialectString($pgDialect),
            'TRUNCATE TABLE "foo", "bar", "bleh";'
        );

    }

    protected function lite1()
    {
        $this->assertEquals(
            $query->toDialectString($liteDialect),
            'DELETE FROM "single_table";'
        );
    }

    protected function my1()
    {
        $this->assertEquals(
            $query->toDialectString($myDialect),
            'TRUNCATE TABLE `single_table`;'
        );
    }

    protected function lite2()
    {
        $this->assertEquals(
            $query->toDialectString($liteDialect),
            'DELETE FROM "foo"; DELETE FROM "bar"; DELETE FROM "bleh";'
        );
    }

    protected function my2()
    {
        $this->assertEquals(
            $query->toDialectString($myDialect),
            'TRUNCATE TABLE `foo`; TRUNCATE TABLE `bar`; TRUNCATE TABLE `bleh`;'
        );
    }
}
?>
