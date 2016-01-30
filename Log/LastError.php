<?php

namespace Mv\ErrorLogBundle\Log;

/**
 * Class LastError
 *
 * @package Mv\ErrorLogBundle\Log
 * @author Michaël VEROUX
 */
final class LastError
{

    /**
     * @var null|int
     */
    private $id = null;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
