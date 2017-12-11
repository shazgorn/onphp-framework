<?php

namespace Onphp;

final class XMLNamespace
{
    /** @var string xmlns:$prefix */
    protected $prefix;

    /** @var string xmlns:prefix=$URI */
    protected $URI;

    public static function create()
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return FeedNamespace
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getURI()
    {
        return $this->URI;
    }

    /**
     * @param string $URI
     * @return FeedNamespace
     */
    public function setURI(string $URI)
    {
        $this->URI = $URI;

        return $this;
    }
}
