<?php

/**
 * @ingroup Types
 **/
namespace Onphp;

class SmallSerialType extends SmallIntegerType
{
    public function toColumnType()
    {
        return '\Onphp\DataType::create(\Onphp\DataType::SMALLINT)'
            ."->\n"
            .'setSerial(true)';
    }

    public function isSerial()
    {
        return true;
    }
}
