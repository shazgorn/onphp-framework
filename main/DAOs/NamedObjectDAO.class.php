<?php
/***************************************************************************
 *   Copyright (C) 2004-2005 by Konstantin V. Arkhipov                     *
 *   voxus@onphp.org                                                       *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * Simple DAO for simple NamedObject.
	 * 
	 * @ingroup DAOs
	**/
	abstract class NamedObjectDAO extends GenericDAO
	{
		// if you will override it later - append this fields to your array
		protected $fields = array('id', 'name');
		
		/*
			do not forget to declare in every child:
			
			protected function setQueryFields(
				InsertOrUpdateQuery $query, NamedObject $no
			)
		*/
		
		final public function getByName($name)
		{
			$key = $this->getNameCacheKey($name);
			
			if ($no = $this->getCachedByKey($this->getNameCacheKey($name)))
				return $no;
			else {
				$no =
					$this->getByLogic(
						Expression::eq(
							new DBField('name', $this->getTable()),
							new DBValue($name)
						),
						Cache::DO_NOT_CACHE
					);

				return $this->cacheByKey($key, $no, Cache::EXPIRES_MEDIUM);
			}
		}
		
		final public function uncacheByName($name)
		{
			return
				$this->uncacheByKey($this->getNameCacheKey($name));
		}
		
		final protected function saveNamed(Named $no)
		{
			return
				self::injectNamed(
					OSQL::update($this->getTable())->
						where(Expression::eqId('id', $no)),
					$no
				);
		}

		final protected function addNamed(Named $no)
		{
			return
				self::importNamed(
					$no->setId(
						DBFactory::getDefaultInstance()->
						obtainSequence($this->getSequence())
					)
				);
		}

		final protected function importNamed(Named $no)
		{
			return
				self::injectNamed(
					OSQL::insert()->into($this->getTable()), $no
				);
		}

		final protected function injectNamed(
			InsertOrUpdateQuery $query, Named $no
		)
		{
			DBFactory::getDefaultInstance()->queryNull(
				$this->setQueryFields($query, $no)
			);
			
			$this->uncacheById($no->getId());
			
			return $no;
		}

		final protected function setNamedQueryFields(
			InsertOrUpdateQuery $query, Named $no
		)
		{
			$query->set('name', $no->getName());
			
			if ($query instanceof InsertQuery)
				return $query->setId('id', $no);
			else
				return $query;
		}

		final protected function makeNamedObject(
			&$array, Named $no, $prefix = null
		)
		{
			return
				$no->
					setId($array[$prefix.'id'])->
					setName($array[$prefix.'name']);
		}
		
		private function getNameCacheKey($name)
		{
			return $this->getObjectName().'_name_'.sha1($name);
		}
	}
?>