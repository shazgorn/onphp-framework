<?php

/**
 * @ingroup Types
 **/
namespace Onphp;

class BigSerialType extends BigIntegerType
{
    public function toColumnType()
    {
        return '\Onphp\DataType::create(\Onphp\DataType::BIGINT)'
            ."->\n"
            .'setSerial(true)';
    }

    public function isSerial()
    {
        return true;
    }
}
