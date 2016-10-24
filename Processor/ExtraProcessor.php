<?php

namespace Mv\ErrorLogBundle\Processor;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ExtraProcessor
 *
 * @package Mv\ErrorLogBundle\Processor
 * @author Michaël VEROUX
 */
class ExtraProcessor
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var RequestStack
     */
    protected $request;

    /**
     * ExtraProcessor constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param RequestStack          $request
     */
    public function __construct(TokenStorageInterface $tokenStorage = null, RequestStack $request = null)
    {
        $this->tokenStorage = $tokenStorage;
        $this->request = $request;
    }

    /**
     * @param array $record
     *
     * @return array
     * @author Michaël VEROUX
     */
    public function processRecord(array $record)
    {
        $extra = array(
            'userContext' => null,
            'user'        => null,
            'uri'         => null,
            'route'       => null,
            'controller'  => null,
            'userAgent'   => null,
        );
        $record['extra'] = $extra;
        if ($this->tokenStorage && $this->tokenStorage->getToken()) {
            $record['extra']['userContext'] = $this->tokenStorage->getToken();
            $record['extra']['user'] = $this->tokenStorage->getToken()->getUsername();
        }
        $request = null;
        if ($this->request) {
            $request = $this->request->getCurrentRequest();
        }
        if ($request) {
            $record['extra']['uri'] = $request->getRequestUri();
            $record['extra']['route'] = $request->get('_route');
            $record['extra']['controller'] = $request->get('_controller');
            $record['extra']['userAgent'] = $request->headers->get('User-Agent');
        }

        return $record;
    }
}
