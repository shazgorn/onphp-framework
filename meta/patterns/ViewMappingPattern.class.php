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
 * @ingroup Patterns
 **/
namespace Onphp;

/**
 * Class maps to view, not table
 */
final class ViewMappingPattern extends BasePattern
{
    public function daoExists()
    {
        return true;
    }

    public function isView()
    {
        return true;
    }
}
?>
