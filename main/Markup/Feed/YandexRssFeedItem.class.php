<?php
/***************************************************************************
 *   Copyright (C) 2010 by Alexandr S. Krotov                              *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

/**
 * @ingroup Feed
 **/
namespace Onphp;

final class YandexRssFeedItem extends FeedItem
{
    /** @var string */
    private $fullText = null;

    /** @var string */
    private $genre = null;

    /** @var bool */
    protected $turbo;

    /** @var array|null */
    protected $related = [];

    /** @var bool */
    protected $relatedInfinity = false;

    /** @var string */
    protected $turboContent;

    /**
     * @return \Onphp\YandexRssFeedItem
     **/
    public static function create($title)
    {
        return new self($title);
    }

    public function getFullText()
    {
        return $this->fullText;
    }

    /**
     * @return \Onphp\YandexRssFeedItem
     **/
    public function setFullText($fullText)
    {
        $this->fullText = $fullText;

        return $this;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     * @return $this
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTurbo()
    {
        return $this->turbo;
    }

    /**
     * @return bool
     */
    public function getTurbo()
    {
        return $this->turbo;
    }

    /**
     * @param bool $turbo
     * @return YandexRssFeedItem
     */
    public function setTurbo($turbo)
    {
        $this->turbo = $turbo;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * @param bool $related
     * @return array
     */
    public function setRelated($related)
    {
        $this->related = $related;

        return $this;
    }

    /**
     * @param array $link
     */
    public function appendRelated($link)
    {
        $this->related[] = $link;

        return $this;
    }

    /**
     * @param string $turboContent
     *
     * @return YandexRssFeedItem
     */
    public function setTurboContent($turboContent)
    {
        $this->turboContent = $turboContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getTurboContent()
    {
        return $this->turboContent;
    }

    /**
     * @param bool $relatedInfinity
     * @return YandexRssFeedItem
     */
    public function setRelatedInfinity($relatedInfinity)
    {
        $this->relatedInfinity = $relatedInfinity;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRelatedInfinity()
    {
        return $this->relatedInfinity;
    }
}
?>
