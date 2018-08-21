<?php
/***************************************************************************
 *   Copyright (C) 2006-2007 by Konstantin V. Arkhipov                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

/**
 * @ingroup MetaBase
 **/
namespace Onphp;

class MigrationOutput
{
    /** @var string */
    protected $fileName;

    /** @var resource */
    protected $res;

    public function __construct()
    {
        $this->fileName = 'migrate-' . date('Y-m-d_His', time()) . '.sql';
        $this->res = fopen($this->fileName, 'w');
    }

    /**
     * @return \Onphp\TextOutput
     **/
    public function write($text)
    {
        fwrite($this->res, $text);

        return $this;
    }

    /**
     * @return \Onphp\TextOutput
     **/
    public function writeLine($text)
    {
        fwrite($this->res, $text . PHP_EOL);

        return $this;
    }

    /**
     * @return TextOutput
     **/
    public function newLine()
    {
        fwrite($this->res, PHP_EOL);

        return $this;
    }

    /**
     * @return \Onphp\TextOutput
     **/
    public function setMode(
        $attribute = ConsoleMode::ATTR_RESET_ALL,
        $foreground = ConsoleMode::FG_WHITE,
        $background = ConsoleMode::BG_BLACK
    )
    {
        // nop

        return $this;
    }

    /**
     * @return \Onphp\TextOutput
     **/
    public function resetAll()
    {
        // nop

        return $this;
    }
}
?>
