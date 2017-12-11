<?php

namespace Onphp;

final class FeedAuthor
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $email;

    /**
     * @return \Onphp\FeedAuthor
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return \Onphp\FeedAuthor
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return \Onphp\FeedAuthor
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }
}
