<?php
	/* $Id$ */

	namespace Onphp\Test;

	final class PrimitiveTimestampTZTest extends TestCase
	{

		public function testMarried()
		{
			$currentTimeZone = new \DateTimeZone(date_default_timezone_get());
			$now = new \DateTime('now', $currentTimeZone);
			$zone = $now->format('O');

			$prm = \Onphp\Primitive::timestampTZ('test')->setComplex();

			$array = array(
				'test' => array(
					\Onphp\PrimitiveDate::DAY		=> '1',
					\Onphp\PrimitiveDate::MONTH	=> '2',
					\Onphp\PrimitiveDate::YEAR		=> '',
					\Onphp\PrimitiveTimestamp::HOURS	=> '17',
					\Onphp\PrimitiveTimestamp::MINUTES	=> '38',
					\Onphp\PrimitiveTimestamp::SECONDS	=> '59',
					\Onphp\PrimitiveTimestampTZ::ZONE => $currentTimeZone->getName(),
				)
			);

			$this->assertFalse($prm->import($array));
			$this->assertEquals($array['test'], $prm->getRawValue());

			$this->assertEmpty(
				array_filter($prm->exportValue())
			);

			//not supported other epochs
			$array['test'][\Onphp\PrimitiveDate::YEAR] = '3456';
			$this->assertTrue($prm->import($array));
			$this->assertEquals(3456, $prm->getValue()->getYear());
			$this->assertEquals(17, $prm->getValue()->getHour());

			$this->assertEquals(
				$array['test'],
				$prm->exportValue()
			);

			$array['test'][\Onphp\PrimitiveDate::YEAR] = '2012';

			$this->assertTrue($prm->import($array));
			$this->assertEquals(
				'2012-02-01 17:38:59'.$zone,
				$prm->getValue()->toString()
			);
		}

		public function testSingle()
		{
			$prm = \Onphp\Primitive::timestampTZ('test')->setSingle();

			$array = array('test' => '1234-01-02 17:38:59');

			$this->assertTrue($prm->import($array));
			$this->assertEquals(1234, $prm->getValue()->getYear());

			$array = array('test' => '1975-01-02 17:38:59');

			$this->assertTrue($prm->import($array));

			$this->assertEquals(
				'1975-01-02 17:38.59',
				$prm->getValue()->toDateTime()
			);
		}
	}
?>