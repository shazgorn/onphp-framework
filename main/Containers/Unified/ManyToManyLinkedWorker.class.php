<?php
/***************************************************************************
 *   Copyright (C) 2005-2007 by Konstantin V. Arkhipov                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 3 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @ingroup Containers
	**/
	abstract class ManyToManyLinkedWorker extends UnifiedContainerWorker
	{
		protected function makeInsertQuery($childId)
		{
			$uc = $this->container;
			
			return
				OSQL::insert()->into($uc->getHelperTable())->
				set(
					$uc->getParentIdField(),
					$uc->getParentObject()->getId()
				)->
				set($uc->getChildIdField(), $childId);
		}
		
		// only unlinking, we don't want to drop original object
		protected function makeDeleteQuery(&$delete)
		{
			$uc = $this->container;
			
			return
				OSQL::delete()->from($uc->getHelperTable())->
				where(
					Expression::eq(
						new DBField($uc->getParentIdField()),
						new DBValue($uc->getParentObject()->getId())
					)
				)->
				andWhere(
					Expression::in(
						$uc->getChildIdField(),
						$delete
					)
				);
		}
	}
?>