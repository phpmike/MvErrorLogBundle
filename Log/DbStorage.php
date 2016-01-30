<?php

namespace Mv\ErrorLogBundle\Log;

use Doctrine\ORM\EntityManager;
use Monolog\Handler\AbstractProcessingHandler;
use Mv\ErrorLogBundle\Entity\Error;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class DbStorage
 *
 * @package Mv\ErrorLogBundle\Log
 * @author Michaël VEROUX
 */
class DbStorage extends AbstractProcessingHandler
{
    /**
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * @var Container
     */
    protected $container = null;

    /**
     * @var array
     */
    protected $record = array();

    /**
     * @var LastError
     */
    protected $lastError;

    /**
     * DbStorage constructor.
     *
     * @param LastError $lastError
     */
    public function __construct(LastError $lastError)
    {
        $this->lastError = $lastError;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Container $container
     *
     * @return $this
     * @author Michaël VEROUX
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLastErrorLogId()
    {
        return $this->lastErrorLogId;
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     *
     * @return void
     */
    protected function write(array $record)
    {
        $this->record = $record;

        /** @var \Symfony\Component\HttpFoundation\Request|null $request */
        $request = $this->container->isScopeActive('request') ? $this->container->get('request') : null;

        $error = new Error();
        $error->setMessage($this->getFromRecord('message'));
        $error->setFile($this->getFile());
        $error->setLine($this->getLine());
        $error->setTrace($this->getTrace());
        $error->setType($this->getType());
        $error->setCode($this->getCode());
        if ($request) {
            $error->setUri($request->getRequestUri());
            $error->setRoute($request->get('_route'));
            $error->setController($request->get('_controller'));
            $error->setUserAgent($request->headers->get('User-Agent'));
        }

        if ($this->container->get('security.token_storage')->getToken() instanceof TokenInterface) {
            $error->setUserContext($this->container->get('security.token_storage')->getToken());
            $error->setUser($this->container->get('security.token_storage')->getToken()->getUsername());
        }

        if (!$this->entityManager->isOpen()) {
            $this->entityManager = $this->entityManager->create(
                $this->entityManager->getConnection(),
                $this->entityManager->getConfiguration()
            );
        }

        $this->entityManager->persist($error);
        $this->entityManager->flush($error);
        $this->lastError->setId($error->getId());
    }

    /**
     * @param $name
     *
     * @return string
     * @author Michaël VEROUX
     */
    private function getFromRecord($name)
    {
        if (isset($this->record[$name])) {
            return $this->record[$name];
        } else {
            return '';
        }
    }

    /**
     * @param $name
     *
     * @return string
     * @author Michaël VEROUX
     */
    private function getFromRecordContext($name)
    {
        $context = $this->getFromRecord('context');
        if ('' !== $context && isset($context[$name])) {
            return $context[$name];
        } else {
            return '';
        }
    }

    /**
     * @return null|\Exception
     * @author Michaël VEROUX
     */
    private function getException()
    {
        if ($exception = $this->getFromRecordContext('exception')) {
            if ($exception instanceof \Exception) {
                return $exception;
            }
        }

        return null;
    }

    /**
     * @return int|string
     * @author Michaël VEROUX
     */
    private function getLine()
    {
        if ($this->getFromRecordContext('line')) {
            return $this->getFromRecordContext('line');
        }

        if ($this->getException()) {
            return $this->getException()->getLine();
        }

        return 0;
    }

    /**
     * @return string
     * @author Michaël VEROUX
     */
    private function getFile()
    {
        if ($this->getFromRecordContext('file')) {
            return $this->getFromRecordContext('file');
        }

        if ($this->getException()) {
            return $this->getException()->getFile();
        }

        return '';
    }

    /**
     * @return string
     * @author Michaël VEROUX
     */
    private function getTrace()
    {
        if ($this->getException()) {
            return $this->getException()->getTraceAsString();
        }

        return '';
    }

    /**
     * @return string
     * @author Michaël VEROUX
     */
    private function getType()
    {
        if ($this->getException()) {
            return get_class($this->getException());
        }

        return 'unknown';
    }

    /**
     * @return null|int
     * @author Michaël VEROUX
     */
    private function getCode()
    {
        if ($this->getException()) {
            return $this->getException()->getCode();
        }

        return null;
    }
}
