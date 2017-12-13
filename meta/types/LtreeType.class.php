<?php

namespace Onphp;

class LtreeType extends StringType
{
    public function getPrimitiveName()
    {
        return 'ltree';
    }

    public function toColumnType()
    {
        return '\Onphp\DataType::create(\Onphp\DataType::LTREE)';
    }

}
