<?php

namespace Mv\ErrorLogBundle\Listener;

use Mv\ErrorLogBundle\Log\LastError;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener as BaseExceptionListener;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ExceptionListener
 *
 * @package Mv\ErrorLogBundle\Listener
 * @author Michaël VEROUX
 */
class ExceptionListener extends BaseExceptionListener
{
    /**
     * @var LastError
     */
    protected $lastError;

    /**
     * @var LoggerInterface
     */
    protected $loggerDb;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var FlashBagInterface
     */
    protected $flashBag;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @param string                 $controller
     * @param LastError              $lastError
     * @param LoggerInterface        $loggerDb
     * @param RouterInterface        $router
     * @param FlashBagInterface|null $flashBag
     * @param string                 $mode
     */
    public function __construct($controller, LastError $lastError, LoggerInterface $loggerDb, RouterInterface $router, FlashBagInterface $flashBag = null, $mode = 'dev')
    {
        $this->lastError = $lastError;
        $this->loggerDb = $loggerDb;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->mode = $mode;

        parent::__construct($controller, null);
    }

    /**
     * @param GetResponseForExceptionEvent $event
     *
     * @return void
     * @author Michaël VEROUX
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$event->getException() instanceof AccessDeniedException) {
            $exception = null;
            try {
                parent::onKernelException($event);
            } catch (\Exception $e) {
                $exception = $e;
            }

            if (!$exception instanceof HttpExceptionInterface
                && !$event->getException() instanceof HttpExceptionInterface
                && 'prod' === $this->mode
            ) {
                $this->loggerDb->error($event->getException()->getMessage(), array('exception' => $event->getException()));
                if ($this->flashBag) {
                    if (null == $this->lastError->getId()) {
                        $this->flashBag->add('error', 'Une erreur est survenue');
                    } else {
                        $this->flashBag->add('error', sprintf('Une erreur est survenue #%s', $this->lastError->getId()));
                    }
                }
            }
        }
    }
}
