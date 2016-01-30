<?php

namespace Mv\ErrorLogBundle;

use Monolog\Logger;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use \Exception;
use \RuntimeException;

/**
 * Class MvErrorLogBundle
 *
 * @package Mv\ErrorLogBundle
 * @author Michaël VEROUX
 */
class MvErrorLogBundle extends Bundle
{
    /**
     * @return void
     * @author Michaël VEROUX
     */
    public function boot()
    {
        if ('prod' === $this->container->getParameter('kernel.environment')) {
            $handler = ErrorHandler::register();
            $handler->setExceptionHandler(array($this, 'handle'));
        }
    }

    /**
     * @param Exception $exception
     *
     * @return void
     * @author Michaël VEROUX
     */
    public function handle(Exception $exception)
    {
        $lastError = $this->container->get('mv_error_log.last_error');
        $logger = $this->container->get('mv_error_log.db_storage');
        $logger->handle(array(
            'context'   =>  array(
                'exception' => $exception,
                'line'      => $exception->getLine(),
                'file'      => $exception->getFile(),
            ),
            'message'   => $exception->getMessage(),
            'level'     => Logger::ERROR,
            'extra'     => array(),
        ));

        if (null === $lastError->getId()) {
            throw new RuntimeException('Une erreur interne est survenue');
        }

        throw new RuntimeException(sprintf('Une erreur interne est survenue #%s', $lastError->getId()));
    }
}
