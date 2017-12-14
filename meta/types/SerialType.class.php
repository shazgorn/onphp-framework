<?php

/**
 * @ingroup Types
 **/
namespace Onphp;

class SerialType extends IntegerType
{
    public function toColumnType()
    {
        return '\Onphp\DataType::create(\Onphp\DataType::INTEGER)'
            ."->\n"
            .'setSerial(true)';
    }

    public function isSerial()
    {
        return true;
    }
}
