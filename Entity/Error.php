<?php

namespace Mv\ErrorLogBundle\Entity;

use DateTime;

/**
 * Class Error
 *
 * @package Mv\ErrorLogBundle\Entity
 * @author Michaël VEROUX
 */
class Error
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var string
     */
    private $type = 'unknown';

    /**
     * @var string
     */
    private $file = '';

    /**
     * @var integer
     */
    private $line;

    /**
     * @var string
     */
    private $trace;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var DateTime
     */
    private $created;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $userContext;

    /**
     *
     */
    public function __construct()
    {
        $this->created = new DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Error
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Error
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Error
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set line
     *
     * @param integer $line
     *
     * @return Error
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get line
     *
     * @return integer
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Set trace
     *
     * @param string $trace
     *
     * @return Error
     */
    public function setTrace($trace)
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * Get trace
     *
     * @return string
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return Error
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set controller
     *
     * @param string $controller
     *
     * @return Error
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set uri
     *
     * @param string $uri
     *
     * @return Error
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Error
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     *
     * @return Error
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set created
     *
     * @param DateTime $created
     *
     * @return Error
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Error
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set userContext
     *
     * @param string $userContext
     *
     * @return Error
     */
    public function setUserContext($userContext)
    {
        $this->userContext = $userContext;

        return $this;
    }

    /**
     * Get userContext
     *
     * @return string
     */
    public function getUserContext()
    {
        return $this->userContext;
    }
}
